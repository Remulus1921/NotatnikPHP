<?php
declare(strict_types = 1);

namespace App;

use App\Exception\AppException;
use App\Exception\ConfigurationException;
use Throwable;

require_once("src/Utils/Debug.php");
require_once("src/Utils/Controller.php");
require_once("src/Exception/AppException.php");

$configuration = require_once("config/config.php"); 

$request = [
    'get' => $_GET,
    'post' => $_POST
];


try 
{
    //$controller = new Controller($request);
    //$controller->run();
    Controller::initConfiguration($configuration);

    (new Controller($request))->run(); //Robi to samo co dwie zakomentowane linijki powyżej w jednej lini
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
catch(Throwable $e)
{
    echo "<h1>Wystąpił błąd w aplikacji</h1>";
    dump($e);
}
?>