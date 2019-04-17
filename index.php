<?php
/*
Jason Engelbrecht
4.12.2019
https://jengelbrecht.greenriverdev.com/it328/dating
Dog dating site, route to views/home.html.
*/

//turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//require autoload file
require_once("vendor/autoload.php");

//create an instance of the base class
$f3 = Base::instance();

//turn on fat-free error reporting
$f3->set('DEBUG', 3);

//define a default root
$f3->route('GET /', function() {
    //display a view
    $view = new Template();
    echo $view->render('views/home.html');
});

$f3->route('GET /info', function() {
    //display a view
    $view = new Template();
    echo $view->render('views/sign-up/personal-info.html');
});

$f3->route('GET /profile', function() {
    //display a view
    $view = new Template();
    echo $view->render('views/sign-up/profile.html');
});

$f3->route('GET /interests', function() {
    //display a view
    $view = new Template();
    echo $view->render('views/sign-up/interests.html');
});

$f3->route('GET /display-profile', function() {
    //display a view
    $view = new Template();
    echo $view->render('views/display-profile.html');
});

//run fat-free
$f3->run();