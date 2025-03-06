<?php
require __DIR__ . '/vendor/autoload.php';
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Service</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Google Fonts -->
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
            transition: transform 0.3s ease;
        }
        .container:hover {
            transform: translateY(-5px);
        }
        h2 {
            color: #333;
            font-weight: 600;
            margin-bottom: 20px;
            text-align: center;
        }
        .btn-primary {
            background-color: #6b48ff;
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #5439cc;
        }
        .input-group {
            margin-bottom: 20px;
        }
        .form-control, .custom-file-input {
            border-radius: 10px;
            border: 2px solid #e0e0e0;
            transition: border-color 0.3s ease;
        }
        .form-control:focus, .custom-file-input:focus {
            border-color: #6b48ff;
            box-shadow: none;
        }
        .custom-file-label {
            border-radius: 10px;
            overflow: hidden;
        }
        .section-title {
            border-bottom: 2px solid #6b48ff;
            padding-bottom: 10px;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="section-title">Generate QR code</h2>
        <form action="generate.php" method="POST" class="form-group">
            <div class="input-group">
                <input type="text" class="form-control" name="qr_text" placeholder="Input text" required>
                <button type="submit" class="btn btn-primary">Generate</button>
            </div>
        </form>

        <h2 class="section-title">Decode QR code</h2>
        <form action="decode.php" method="POST" enctype="multipart/form-data" class="form-group">
            <div class="input-group">
                <input type="file" class="form-control" name="qr_image" accept="image/*" id="qrImage" required>
                <button type="submit" class="btn btn-primary"> Decode</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        document.querySelector('.custom-file-input').addEventListener('change', function(e) {
            let fileName = e.target.files[0].name;
            let label = e.target.nextElementSibling;
            label.innerText = fileName;
        });
    </script>
</body>
</html>

