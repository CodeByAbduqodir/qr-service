<?php
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: *');

$response = ['status' => 'error', 'message' => 'No file provided'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $image = $_FILES['image'];

    if ($image['error'] === UPLOAD_ERR_OK) {
        $temp_path = $image['tmp_name'];

        $apiUrl = "https://api.qrserver.com/v1/read-qr-code/";
        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, ['file' => new CURLFile($temp_path)]);
        $response_data = curl_exec($ch);

        if ($response_data === false) {
            $response['message'] = 'cURL error: ' . curl_error($ch);
        } else {
            $result = json_decode($response_data, true);
            if (!empty($result[0]['symbol'][0]['data'])) {
                $response = [
                    'status' => 'success',
                    'decoded_text' => $result[0]['symbol'][0]['data'],
                    'message' => 'QR code decoded successfully'
                ];
            } else {
                $response['message'] = 'Couldn\'t decode QR!';
            }
        }
        curl_close($ch);
    } else {
        $response['message'] = 'File upload error: ' . $image['error'];
    }
} else {
    $response['message'] = 'No file uploaded';
}

echo json_encode($response, JSON_PRETTY_PRINT);