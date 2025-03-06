<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'vendor/autoload.php';
require 'config.php';

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

function sendMessage($chat_id, $text) {
    $url = "https://api.telegram.org/bot" . BOT_TOKEN . "/sendMessage";
    $data = [
        'chat_id' => $chat_id,
        'text' => $text,
    ];
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    if ($response === false) {
        file_put_contents('bot_log.txt', "sendMessage cURL error: " . curl_error($ch) . "\n", FILE_APPEND);
    }
    file_put_contents('bot_log.txt', "sendMessage: " . $response . "\n", FILE_APPEND);
    curl_close($ch);
}

function sendPhoto($chat_id, $photo_path) {
    $url = "https://api.telegram.org/bot" . BOT_TOKEN . "/sendPhoto";
    $data = [
        'chat_id' => $chat_id,
        'photo' => new CURLFile($photo_path),
    ];
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    if ($response === false) {
        file_put_contents('bot_log.txt', "sendPhoto cURL error: " . curl_error($ch) . "\n", FILE_APPEND);
    }
    file_put_contents('bot_log.txt', "sendPhoto: " . $response . "\n", FILE_APPEND);
    curl_close($ch);
}

function decodeQR($photo_path) {
    $apiUrl = "https://api.qrserver.com/v1/read-qr-code/";
    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, ['file' => new CURLFile($photo_path)]);
    $response = curl_exec($ch);
    if ($response === false) {
        file_put_contents('bot_log.txt', "decodeQR cURL error: " . curl_error($ch) . "\n", FILE_APPEND);
        curl_close($ch);
        return false;
    }
    curl_close($ch);
    $result = json_decode($response, true);
    return $result[0]['symbol'][0]['data'] ?? false;
}

$update = json_decode(file_get_contents('php://input'), true);
file_put_contents('bot_log.txt', "Update: " . print_r($update, true) . "\n", FILE_APPEND);

if (!$update) {
    file_put_contents('bot_log.txt', "No update received\n", FILE_APPEND);
    http_response_code(200);
    exit;
}

$chat_id = $update['message']['chat']['id'] ?? null;
$text = $update['message']['text'] ?? null;
$photo = $update['message']['photo'] ?? null;

if ($text === '/start') {
    sendMessage($chat_id, 'Send text to generate a QR code or send a photo to decode a QR code.');
} elseif ($text) {
    try {
        $options = new QROptions([
            'eccLevel' => QRCode::ECC_L,
            'outputType' => QRCode::OUTPUT_IMAGE_PNG,
            'scale' => 7,
        ]);
        $qrcode = (new QRCode($options))->render($text);
        
        $temp_file = 'temp_qr.png';
        file_put_contents($temp_file, base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $qrcode)));
        
        sendPhoto($chat_id, $temp_file);
        sendMessage($chat_id, 'Success!');
        
        unlink($temp_file);
    } catch (Exception $e) {
        file_put_contents('bot_log.txt', "Error: " . $e->getMessage() . "\n", FILE_APPEND);
        sendMessage($chat_id, 'QR code generation error!');
    }
} elseif ($photo) {
    try {
        $file_id = end($photo)['file_id'];
        
        $file_url = "https://api.telegram.org/bot" . BOT_TOKEN . "/getFile?file_id=" . $file_id;
        $file_info = json_decode(file_get_contents($file_url), true);
        
        if ($file_info['ok']) {
            $file_path = $file_info['result']['file_path'];
            $download_url = "https://api.telegram.org/file/bot" . BOT_TOKEN . "/" . $file_path;
            
            $temp_file = 'temp_qr_decode.png';
            file_put_contents($temp_file, file_get_contents($download_url));
            
            $decoded_text = decodeQR($temp_file);
            if ($decoded_text) {
                sendMessage($chat_id, "Decoded QR: \n" . $decoded_text);
            } else {
                sendMessage($chat_id, "Couldn't decode QR!");
            }
            
            unlink($temp_file);
        } else {
            sendMessage($chat_id, "Error getting file from Telegram!");
        }
    } catch (Exception $e) {
        file_put_contents('bot_log.txt', "Decode error: " . $e->getMessage() . "\n", FILE_APPEND);
        sendMessage($chat_id, 'QR decode error!');
    }
}

http_response_code(200);