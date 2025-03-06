<?php
require 'vendor/autoload.php';

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

header('Content-Type: text/html; charset=UTF-8');

if (isset($_POST['qr_text'])) {
    $text = $_POST['qr_text'];

    $options = new QROptions([
        'eccLevel' => QRCode::ECC_L,
        'outputType' => QRCode::OUTPUT_IMAGE_PNG,
        'scale' => 7,
    ]);

    $qrcode = (new QRCode($options))->render($text);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generated QR Code</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #e0eafc, #cfdef3);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 40px;
            max-width: 600px;
            text-align: center;
            transition: transform 0.3s ease;
        }
        .container:hover {
            transform: translateY(-5px);
        }
        h2 {
            color: #333;
            font-weight: 600;
            margin-bottom: 20px;
        }
        .btn-primary {
            background-color: #6b48ff;
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            transition: background-color 0.3s ease;
            text-decoration: none;
            color: white;
            display: inline-block;
            margin-top: 20px;
        }
        .btn-primary:hover {
            background-color: #5439cc;
            color: white;
        }
        img {
            border-radius: 10px;
            margin-bottom: 20px;
            max-width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Your QR code</h2>
        <img src="<?php echo $qrcode; ?>" alt="Generated QR Code">
        <a href="index.php" class="btn btn-primary">Back</a>
    </div>
</body>
</html>

<?php
} else {
    header('Location: index.php');
    exit;
}