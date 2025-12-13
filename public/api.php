<?php
require_once '../vendor/autoload.php';

use Radlinger\Mealplan\Api\GetMeals;

header("Content-Type: application/json");

if (isset($_GET["mealplanID"])) {
    echo GetMeals::getMealWithId((int)$_GET["mealplanID"]);
} else echo json_encode(["error" => "No meal ID provided!"]);