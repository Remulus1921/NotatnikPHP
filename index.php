<?php
declare(strict_types = 1);

namespace App;

require_once("src/Utils/Debug.php");
require_once("src/Utils/Controller.php");

$request = [
    'get' => $_GET,
    'post' => $_POST
];

$controller = new Controller($request);
$controller->run();

?>