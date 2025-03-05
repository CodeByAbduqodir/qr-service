<?php
if (isset($_FILES['qr_image'])) {
    $image = $_FILES['qr_image']['tmp_name'];
    $imageData = base64_encode(file_get_contents($image));
    
    $apiUrl = "https://api.qrserver.com/v1/read-qr-code/";
    $response = file_get_contents($apiUrl . "?filedata=" . $imageData);
    $result = json_decode($response, true);
    
    if (!empty($result[0]['symbol'][0]['data'])) {
        echo "<h2>Decoded QR:</h2>";
        echo "<p>" . htmlspecialchars($result[0]['symbol'][0]['data'], ENT_QUOTES) . "</p>";
    } else {
        echo "Couldn't decode QR!";
    }
} else {
    echo "File not found!";
}
