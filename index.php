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

session_start();

//require autoload file
require_once("vendor/autoload.php");

//create an instance of the base class
$f3 = Base::instance();

//turn on fat-free error reporting
$f3->set('DEBUG', 3);

//define a default root
$f3->route('GET /', function($f3) {
    $f3->set('page_title', 'Home');

    //display a view
    $view = new Template();
    echo $view->render('views/home.html');
});

//route to start sign up (personal info)
$f3->route('GET /info', function($f3) {
    $f3->set('page_title', 'Personal Info');

    //display a view
    $view = new Template();
    echo $view->render('views/sign-up/personal-info.html');
});

//sign up form 2 (profile info)
$f3->route('POST /profile', function($f3) {
    $f3->set('page_title', 'Profile Info');

    //save form info in session
    $_SESSION['fname'] = $_POST['fname'];
    $_SESSION['lname'] = $_POST['lname'];
    $_SESSION['age'] = $_POST['age'];
    $_SESSION['gender'] = $_POST['gender'];
    $_SESSION['phone'] = $_POST['phone'];

    $view = new Template();
    echo $view->render('views/sign-up/profile.html');
});

//sign up form 3 (interests)
$f3->route('POST /interests', function($f3) {
    $f3->set('page_title', 'Interests');

    //save form info in session
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['state'] = $_POST['state'];
    $_SESSION['seeking'] = $_POST['seeking'];
    $_SESSION['bio'] = $_POST['bio'];

    $view = new Template();
    echo $view->render('views/sign-up/interests.html');
});

//final step in sign up, display profile page
$f3->route('POST /display-profile', function($f3) {
    $f3->set('page_title', 'My Profile');

    //creating string of interests
    $interests_string = implode(', ', $_POST['interests']);
    trim($interests_string);
    substr($interests_string, -1);

    //save form info in session
    $_SESSION['interests'] = $interests_string;

    $view = new Template();
    echo $view->render('views/display-profile.html');
});

//run fat-free
$f3->run();