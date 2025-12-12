<?php
require_once '../vendor/autoload.php';

use Radlinger\Mealplan\Seeder\MealSeeder;
use Radlinger\Mealplan\View\TemplateEngine;

$mealPlans = MealSeeder::generate();

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
        'plan_meals' => $plan->meals
    ];
};

// Render the template
echo TemplateEngine::render('../templates/index_template.html', $data);
