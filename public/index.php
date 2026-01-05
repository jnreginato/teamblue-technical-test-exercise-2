<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\DigitArrayInteger;
use App\FactorialService;
use App\PostValidator;

$result = null;
$error = null;

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $postData = $_POST;

        if (isset($postData['action']) && $postData['action'] === 'multiply') {
            $a = DigitArrayInteger::fromString(PostValidator::string($postData, 'a'));
            $b = DigitArrayInteger::fromString(PostValidator::string($postData, 'b'));

            $result = $a->multiply($b)->toString();
        }

        if (isset($postData['action']) && $postData['action'] === 'factorial') {
            $n = PostValidator::int($postData, 'n');

            $factorialService = new FactorialService();
            $result = $factorialService->calculate($n)->toString();
        }
    } catch (Throwable $e) {
        $error = $e->getMessage();
    }
}

$viewData = [
    'result' => $result,
    'error' => $error,
];

/** @var array{result: string|null, error: string|null} $viewData */
require __DIR__ . '/../templates/form.php';
