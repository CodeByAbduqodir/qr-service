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

    $decoded_text = "";
    $error_message = "";

    if ($response === false) {
        $error_message = "cURL error: " . curl_error($ch);
    } else {
        $result = json_decode($response, true);
        if (!empty($result[0]['symbol'][0]['data'])) {
            $decoded_text = htmlspecialchars($result[0]['symbol'][0]['data'], ENT_QUOTES);
        } else {
            $error_message = "Couldn't decode QR!";
        }
    }
    curl_close($ch);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Decoded QR Code</title>
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
        p {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            word-wrap: break-word;
        }
        .error {
            color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Decoded QR Code</h2>
        <?php if ($decoded_text): ?>
            <p><?php echo $decoded_text; ?></p>
        <?php elseif ($error_message): ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <a href="index.php" class="btn btn-primary">Back</a>
    </div>
</body>
</html>

<?php
} else {
    $error_message = "File not uploaded! Error code: " . ($_FILES['qr_image']['error'] ?? 'No file');
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Decode Error</title>
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
        .error {
            color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Error</h2>
        <p class="error"><?php echo $error_message; ?></p>
        <a href="index.php" class="btn btn-primary">Back</a>
    </div>
</body>
</html>

<?php
}