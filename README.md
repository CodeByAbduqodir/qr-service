# QR Code Service

Welcome to the **QR Code Service**, a web application that allows you to generate QR codes from text and decode QR codes from images. This project includes a user-friendly interface and supports any web server for deployment.

## Table of Contents

- [Features](#features)
- [Installation](#installation)
- [Usage](#usage)
- [Project Structure](#project-structure)
- [Technologies Used](#technologies-used)
- [Contributing](#contributing)
- [License](#license)
- [Contact](#contact)

## Features

- Generate QR codes from any text or URL.
- Decode QR codes from uploaded images.
- Responsive and modern web interface.
- Compatible with any web server (Apache, Nginx, PHP built-in server, etc.).
- Dynamic storage of generated QR codes.

## Installation

### Prerequisites

- **PHP 7.4 or higher**
- **Composer** (for dependency management)
- **Web server** (Apache, Nginx, or built-in PHP server)

### Steps

1. **Clone the repository:**

   ```bash
   git clone https://github.com/CodeByAbduqodir/qr-service.git
   cd qr-service
   ```

2. **Install dependencies:**

   ```bash
   composer install
   ```

3. **Set up the storage directory:**

   ```bash
   mkdir qrcodes
   chmod -R 777 qrcodes
   ```

   This directory will store the generated QR codes.

4. **Start the development server:**

   ```bash
   php -S localhost:8080 -t public
   ```

   Alternatively, configure a virtual host in Apache or Nginx.

5. **Access the application:**
   Open your browser and go to `http://localhost:8080` (or the appropriate URL for your server configuration).

## Usage

### Web Interface

- **Generate a QR Code:**
  - Enter text or a URL in the **"Create Your QR Code"** section.
  - Click **"Generate"** to create a QR code.
- **Decode a QR Code:**
  - Upload an image containing a QR code in the **"Decode QR Code"** section.
  - Click **"Decode"** to retrieve the encoded text.

## Project Structure

```
qr-service/
├── api/
│   ├── generate.php        # Handles QR code generation
│   └── decode.php          # Handles QR code decoding
├── qrcodes/                # Directory for storing generated QR code images (ignored by Git)
├── public/
│   ├── index.php           # Main web interface
│   ├── assets/             # CSS, JS, and other assets
├── router.php              # Routing script for PHP built-in server
├── config.php              # Configuration file
├── vendor/                 # Composer dependencies
├── .gitignore              # Ignored files (e.g., qrcodes/)
├── composer.json           # Composer configuration
└── README.md               # This file
```

## Technologies Used

- **PHP**: Backend logic and API.
- **Composer**: Dependency management.
- **chillerlan/qrcode**: Library for QR code generation.
- **cURL**: For decoding QR codes via an external API.
- **Bootstrap 5**: CSS framework for a responsive UI.
- **Google Fonts (Poppins)**: Custom typography.
- **Web Servers**: Compatible with Apache, Nginx, and PHP built-in server.

## Contributing

We welcome contributions! To contribute:

1. Fork the repository.
2. Create a new branch: `git checkout -b feature-name`.
3. Make your changes and commit: `git commit -m "Add feature"`.
4. Push to the branch: `git push origin feature-name`.
5. Open a pull request.

## License

This project is open-source under the MIT License. See the [LICENSE](LICENSE) file for details.

## Contact

- **Author:** [CodeByAbduqodir]
- **Email:** [[alrgmw@gmail.com](mailto\:alrgmw@gmail.com)]
- **GitHub:** [[https://github.com/CodeByAbduqodir](https://github.com/CodeByAbduqodir)]