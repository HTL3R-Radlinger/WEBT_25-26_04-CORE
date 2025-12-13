<?php
require_once '../vendor/autoload.php';

use Radlinger\Mealplan\QrCode\QrCodeBuilder;
use Radlinger\Mealplan\Seeder\MealSeeder;
use Radlinger\Mealplan\View\TemplateEngine;

$mealPlans = MealSeeder::generate();

$apiLink = "http://localhost:8080/api.php?mealplanID=";

// Prepare structured array for nested loops
$data = [
    'plans' => [],
    'title' => "Test!!!"
];

foreach ($mealPlans as $plan) {
    $data['plans'][] = (object)[
        'plan_name' => $plan->name,
        'school_name' => $plan->schoolName,
        'week_of_delivery' => $plan->weekOfDelivery,
        'plan_meals' => $plan->meals,
        'qr_code' => QrCodeBuilder::generate('http://localhost:8080/api.php?mealplanID=' . $plan->id, 'MealPlan Nr.: ' . $plan->id)->getDataUri()
    ];
}

// Render the template
echo TemplateEngine::render('../templates/index_template.html', $data);
