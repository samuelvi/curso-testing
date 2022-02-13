<?php

use App\Kernel;

require_once dirname(__DIR__) . '/vendor/autoload_runtime.php';

//$dsn = "mysql:host=curso_testing_mariadb;dbname=curso_testing_dev;charset=UTF8";
//try {
//    $pdo = new \PDO($dsn, 'curso_testing_dev', 'curso_testing_dev');
//
//    if ($pdo) {
//        echo "Connected to the  database successfully! 2";
//    }
//} catch (\PDOException $e) {
//    echo "L" . $e->getMessage();
//}
//
//die();

return function (array $context) {
    return new Kernel($context['APP_ENV'], (bool)$context['APP_DEBUG']);
};
