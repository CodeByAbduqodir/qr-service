<?php
require 'vendor/autoload.php';

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

if (isset($_POST['qr_text'])) {
    $text = $_POST['qr_text'];

    $options = new QROptions([
        'eccLevel' => QRCode::ECC_L, 
        'outputType' => QRCode::OUTPUT_IMAGE_PNG,
        'scale' => 7, 
    ]);

    $qrcode = (new QRCode($options))->render($text);

    echo "<h2>Your QR:</h2>";
    echo "<img src='$qrcode'>";
    echo "<br><a href='index.php'>Back</a>";
} else {
    echo "Text not found!";
}