<?php

namespace Radlinger\Mealplan\QrCode;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Exception\ValidationException;
use Endroid\QrCode\Label\LabelAlignment;
use Endroid\QrCode\Label\Font\OpenSans;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\Result\ResultInterface;

class QrCodeBuilder
{
    public static function generate(string $data, string $lable, int $size = 300, int $margin = 10): ?ResultInterface
    {
        $builder = new Builder(
            writer: new PngWriter(),
            writerOptions: [],
            validateResult: false,
            data: $data,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::High,
            size: $size,
            margin: $margin,
            roundBlockSizeMode: RoundBlockSizeMode::Margin,
            labelText: $lable,
            labelFont: new OpenSans(20),
            labelAlignment: LabelAlignment::Center
        );

        try {
            return $builder->build();
        } catch (ValidationException) {
            return null;
        }
    }
}