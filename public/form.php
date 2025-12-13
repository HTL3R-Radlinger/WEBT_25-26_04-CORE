<?php
require_once '../vendor/autoload.php';

use Radlinger\Mealplan\QrCode\QrCodeBuilder;
use Radlinger\Mealplan\View\TemplateEngine;

$apiLink = "http://localhost:8080/api.php?mealplanID=";

$data = [
    'title'=>"Form",
    'header'=>"Generate Meal QR Code",
    'qr_result' => "",
    'error' => ""
];

//QrCodeBuilder::generate('http://localhost:8080/api.php?mealplanID=' . $plan->id, 'MealPlan Nr.: ' . $plan->id)->getDataUri()


echo TemplateEngine::render('../templates/from.html', $data);
