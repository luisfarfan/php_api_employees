<?php
/**
 * Created by PhpStorm.
 * User: lfarfan
 * Date: 25/02/2017
 * Time: 14:43
 */
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require 'ApiEmployes.php';

$configuration = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];
$c = new \Slim\Container($configuration);
$app = new \Slim\App($c);


/*routes */

$app->get('/employes[/{id}]', function (Request $request, Response $response, $args) {
    $apiEmployes = new ApiEmployes();
    return $response->withHeader('Content-Type', 'application/json')
        ->write($apiEmployes->getEmployes(isset($args['id']) ? $args['id'] : null));
});

$app->post('/employes_byemail', function (Request $request, Response $response, $args) {
    $apiEmployes = new ApiEmployes();
    return $response->withHeader('Content-Type', 'application/json')
        ->write($apiEmployes->getEmployesbyEmail($args['email']));
});


$app->get('/employes_salary_range[/{min}/{max}]', function (Request $request, Response $response, $args) {
    $apiEmployes = new ApiEmployes();
    return $response->withHeader('Content-Type', 'text/xml')
        ->write($apiEmployes->getEmployesSalaryRange((int)$args['min'], (int)$args['max']));
});

$app->run();