<?php
header('Content-Type: text/html; charset=UTF-8');

if (isset($_FILES['qr_image']) && $_FILES['qr_image']['error'] == UPLOAD_ERR_OK) {
    $image = $_FILES['qr_image']['tmp_name'];

    $apiUrl = "https://api.qrserver.com/v1/read-qr-code/";
    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, ['file' => new CURLFile($image)]);
    $response = curl_exec($ch);

    if ($response === false) {
        echo "cURL error: " . curl_error($ch);
    } else {
        $result = json_decode($response, true);
        if (!empty($result[0]['symbol'][0]['data'])) {
            echo "<h2>Decoded QR:</h2>";
            echo "<p>" . htmlspecialchars($result[0]['symbol'][0]['data'], ENT_QUOTES) . "</p>";
        } else {
            echo "Couldn't decode QR!";
        }
    }
    curl_close($ch);
    echo "<br><a href='index.php'>Back</a>";
} else {
    echo "File not uploaded! Error code: " . ($_FILES['qr_image']['error'] ?? 'No file');
    echo "<br><a href='index.php'>Back</a>";
}