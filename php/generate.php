<?php

require __DIR__ . '/vendor/autoload.php';

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Picqer\Barcode\BarcodeGeneratorPNG;

function generateBarcodeImage(string $data, string $type = 'barcode', int $width = 3, int $height = 60): void
{
    try {
        if ($type === 'barcode') { // generate  barcode biassaa
            $generator = new BarcodeGeneratorPNG();
            $barcodeData = $generator->getBarcode($data, $generator::TYPE_CODE_128, $width, $height);

            header('Content-Type: image/png');
            echo $barcodeData;
        } elseif ($type === 'qrcode') { // generate qr code
            $writer = new PngWriter();

            $qrCode = new QrCode(
                data: $data,
                encoding: new Encoding('UTF-8'),
                errorCorrectionLevel: ErrorCorrectionLevel::Low,
                size: 300,
                margin: 10,
                roundBlockSizeMode: RoundBlockSizeMode::Margin,
                foregroundColor: new Color(0, 0, 0),
                backgroundColor: new Color(255, 255, 255)
            );
            $result = $writer->write($qrCode);
            header('Content-Type: ' . $result->getMimeType());
            echo $result->getString();
        } else {
            throw new InvalidArgumentException("Tipe tidak valid. Gunakan 'barcode' atau 'qrcode'.");
        }
    } catch (Exception $e) {
        throw new InvalidArgumentException("Tipe tidak valid. Gunakan 'barcode' atau 'qrcode'.");
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['data'])) {

    $data = trim($_POST['data']);
    $type = $_POST['type'] ?? 'barcode';

    generateBarcodeImage($data, $type);
} else {
    exit();
}
