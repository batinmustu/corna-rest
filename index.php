<?php
header('Content-type: application/json');
include "config.php";

define('CONFIG', $config);

spl_autoload_register(function($calledClass){
    $prefixOfNamespaces = 'App\\';
    $baseDirectory = __DIR__ . '/app/';

    $prefixLength = strlen($prefixOfNamespaces);

    if (strncmp($prefixOfNamespaces, $calledClass, $prefixLength) !== 0) return;

    $classFile = substr($calledClass, $prefixLength);
    $classFile = str_replace('\\', '/', $classFile);
    $classFile = $baseDirectory . $classFile . '.php';

    if (file_exists($classFile))
        require $classFile;
});

use App\Core\Routes;
use App\Core\Response;
use App\Core\Database;

$routes = new Routes();
$response = new Response();
$db = new Database();

foreach (glob("app/route/*.php") as $fileName)  {
    include $fileName;
}

$routes->init();