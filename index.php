<?php
declare(strict_types = 1);

spl_autoload_register(function (string $classNamesace){
    $path = str_replace(['\\', 'App/'], ['/', ''], $classNamesace);
    $path = "src/$path.php";
    require_once($path);
});

require_once("src/Utils/Debug.php");
$configuration = require_once("config/config.php"); 

use App\Controller\AbstractController;
use App\Controller\NoteController;
use App\Request;
use App\Exception\AppException;
use App\Exception\ConfigurationException;


$request = [
    'get' => $_GET,
    'post' => $_POST
];

$request = new Request($_GET, $_POST);

try 
{
    //$controller = new Controller($request);
    //$controller->run();
    AbstractController::initConfiguration($configuration);

    (new NoteController($request))->run(); //Robi to samo co dwie zakomentowane linijki powyżej w jednej lini
}
catch(ConfigurationException $e)
{
    //mail('xxx@xxx.com', 'Error', $e->getMessage());
    echo '<h1>Wystąpił błąd w aplikacji</h1>';
    echo 'Problem z aplikacją. Proszę spróbować za chwilę.';
}
catch(AppException $e)
{
    echo "<h1>Wystąpił błąd w aplikacji</h1>";
    echo '<h3>' . $e->getMessage() . '</h3>';
}
catch(\Throwable $e)
{
    echo "<h1>Wystąpił błąd w aplikacji</h1>";
    dump($e);
}