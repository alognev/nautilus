<?php
/**
 * Created by PhpStorm.
 * User: aognev
 * Date: 12.07.2016
 * Time: 11:37
 */

$appRoot =  str_replace('\\', '/' ,  dirname(__FILE__));

if ($appRoot[strlen($appRoot) - 1] == '/')
    $appRoot = substr($appRoot, 0, -1);

define('APPLICATION_ROOT' ,$appRoot);

if (file_exists(APPLICATION_ROOT . '/vendor/autoload.php')) {
    require  APPLICATION_ROOT . '/vendor/autoload.php';
}
else {
    throw new \Exception('Отсутствует vendor/autoload.php Запустите: "#php composer.phar update" для установки автозагрузчика классов');
}
