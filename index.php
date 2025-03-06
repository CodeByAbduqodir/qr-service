<?php
require __DIR__ . '/vendor/autoload.php';
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR generator</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Input text</h2>
        <form action="generate.php" method="POST" class="form-group">
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="qr_text" required>
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary">Create QR code</button>
                </div>
            </div>
        </form>

        <h2 class="text-center">QR decoder</h2>
        <form action="decode.php" method="POST" enctype="multipart/form-data" class="form-group">
            <div class="input-group mb-3">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="qr_image" accept="image/*" required>
                    <label class="custom-file-label">Choose file</label>
                </div>
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary">Decode QR</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>