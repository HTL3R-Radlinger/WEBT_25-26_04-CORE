<?php

require_once '../vendor/autoload.php';

use Radlinger\Mealplan\QrCode\QrCodeBuilder;

// Directly output the QR code
$result = QrCodeBuilder::generate(data: 'Custom QR code contents', lable: 'This is the label');

header('Content-Type: ' . $result->getMimeType());
echo $result->getString();