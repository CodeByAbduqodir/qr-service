<?php
require 'vendor/autoload.php';
require 'config.php';

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

define('WEBHOOK_URL', 'https://ac9c-89-236-218-41.ngrok-free.app');

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
    curl_exec($ch);
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
    curl_exec($ch);
    curl_close($ch);
}

$update = json_decode(file_get_contents('php://input'), true);
if (!$update) {
    exit;
}

$chat_id = $update['message']['chat']['id'] ?? null;
$text = $update['message']['text'] ?? null;

if ($text === '/start') {
    sendMessage($chat_id, 'Send text to generate QR code.');
} elseif ($text) {
    $options = new QROptions([
        'eccLevel' => QRCode::ECC_L,
        'outputType' => QRCode::OUTPUT_IMAGE_PNG,
        'scale' => 7,
    ]);
    $qrcode = (new QRCode($options))->render($text);
    
    $temp_file = 'temp_qr.png';
    file_put_contents($temp_file, base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $qrcode)));
    
    sendPhoto($chat_id, $temp_file);
    sendMessage($chat_id, 'Your QR code has been sent!');
    
    unlink($temp_file);
}