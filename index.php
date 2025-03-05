<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR generator</title>
</head>
<body>
    <h2>Input text</h2>
    <form action="generate.php" method="POST">
        <input type="text" name="qr_text" required>
        <button type="submit">Create QR code</button>
    </form>

    <h2>QR decoder</h2>
    <form action="decode.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="qr_image" accept="image/*" required>
        <button type="submit">Decode QR</button>
    </form>
</body>
</html>