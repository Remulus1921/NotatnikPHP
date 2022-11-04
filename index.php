<?php
declare(strict_types = 1);

namespace App;

require_once("src/Utils/Debug.php");
require_once("src/View.php");

$action = $action = $_GET['action'] ?? null;

$view = new View();
$view->render($action);

?>
