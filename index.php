<?php
declare(strict_types = 1);

namespace App;

require_once("src/Utils/Debug.php");
require_once("src/View.php");

const DEFAULT_ACTION = 'list';

$action = $action = $_GET['action'] ?? DEFAULT_ACTION;

$view = new View();

$viewParams = [];
if ($action === 'create')
{   
    $viewParams['resultCreate'] = "udało się";
}
else 
{
    $viewParams['resultList'] = "wyświetlamy notatki";
}

$view->render($action, $viewParams);

?>
