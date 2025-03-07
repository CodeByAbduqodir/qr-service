<?php
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: *');

require __DIR__ . '/../vendor/autoload.php';

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

$response = ['status' => 'error', 'message' => 'No text provided'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['text'])) {
    $text = trim($_POST['text']);

    if (!empty($text)) {
        try {
            $options = new QROptions([
                'eccLevel' => QRCode::ECC_L,
                'outputType' => QRCode::OUTPUT_IMAGE_PNG,
                'scale' => 7,
            ]);

            $filename = 'qrcode_' . time() . '_' . uniqid() . '.png';
            $filepath = __DIR__ . '/../qrcodes/' . $filename;

            if (!file_exists(__DIR__ . '/../qrcodes')) {
                mkdir(__DIR__ . '/../qrcodes', 0777, true);
            }

            (new QRCode($options))->render($text, $filepath);

            $qr_url = 'http://localhost/qrcodes/' . $filename;
            $response = [
                'status' => 'success',
                'qr_url' => $qr_url,
                'message' => 'QR code generated successfully'
            ];
        } catch (Exception $e) {
            $response['message'] = 'Error generating QR code: ' . $e->getMessage();
        }
    } else {
        $response['message'] = 'Text cannot be empty';
    }
}

echo json_encode($response, JSON_PRETTY_PRINT);