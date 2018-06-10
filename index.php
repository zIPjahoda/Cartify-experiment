<?php
/**
 * Created by PhpStorm.
 * User: zidan
 * Date: 25.2.2016
 * Time: 19:16
 */
session_start();

mb_internal_encoding("UTF-8");
function autoLoad($class){
    if(preg_match("/Controller$/", $class))
        require ("Controller/". $class . ".php" );
    else if(preg_match("/Manager$/", $class))
        require ("Models/Managers/". $class . ".php");
    else
        require ("Models/". $class . ".php");
}
spl_autoload_register("autoLoad");
Database::connect("localhost", "root", "","hw_system");
$router = new RouterController();
$router->doIs(array($_SERVER['REQUEST_URI']));
$router->getViews();