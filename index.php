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

//require autoload file and validation functions
require_once("vendor/autoload.php");
require('model/validation-functions.php');

session_start();

//create an instance of the base class
$f3 = Base::instance();

//set arrays
$f3->set('indoorInterests', array('Netflix', 'Movies', 'Puzzles',
                                  'Reading', 'Cooking', 'Tug-of-war',
                                  'Boardgames', 'Video Games'));

$f3->set('outdoorInterests', array('Walking', 'Hiking', 'Swimming',
                                   'Beach Walks', 'Biking', 'Climbing',
                                   'Fetch', 'Dog Park'));

$f3->set('states', array('Alabama','Alaska','Arizona','Arkansas','California',
                         'Colorado','Connecticut','Delaware','District of Columbia','Florida','Georgia',
                         'Hawaii','Idaho','Illinois','Indiana','Iowa','Kansas','Kentucky','Louisiana',
                         'Maine','Maryland','Massachusetts','Michigan','Minnesota','Mississippi','Missouri',
                         'Montana','Nebraska','Nevada','New Hampshire','New Jersey','New Mexico','New York',
                         'North Carolina','North Dakota','Ohio','Oklahoma','Oregon','Pennsylvania','Rhode Island',
                         'South Carolina','South Dakota','Tennessee','Texas','Utah','Vermont','Virginia','Washington',
                         'West Virginia','Wisconsin','Wyoming'));

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
$f3->route('GET|POST /info', function($f3) {
    $f3->set('page_title', 'Personal Info');

    //check first name
    if(isset($_POST['fname'])) {
        $fname = $_POST['fname'];
        $f3->set('fname', $fname);
        if(validName($fname)) {
            $_SESSION['fname'] = $fname;
        }
        else {
            $f3->set("errors['fname']", "Please enter an alphabetic first name");
        }
    }

    //check last name
    if(isset($_POST['lname'])) {
        $lname = $_POST['lname'];
        $f3->set('lname', $lname);
        if(validName($lname)) {
            $_SESSION['lname'] = $lname;
        }
        else {
            $f3->set("errors['lname']", "Please enter an alphabetic last name");
        }
    }

    //check age
    if(isset($_POST['age'])) {
        $age = $_POST['age'];
        $f3->set('age', $age);
        if(validAge($age)) {
            $_SESSION['age'] = $age;
        }
        else {
            $f3->set("errors['age']", "Please enter a numeric age");
        }
    }

    //check phone number
    if(isset($_POST['phone'])) {
        $phone = $_POST['phone'];
        $f3->set('phone', $phone);
        if(validPhone($phone)) {
            $_SESSION['phone'] = $phone;
        }
        else {
            $f3->set("errors['phone']", "Please enter a valid phone number");
        }
    }

    //get gender
    $_SESSION['gender'] = $_POST['gender'];

    if(isset($_SESSION['fname']) && isset($_SESSION['lname']) && isset($_SESSION['age']) && isset($_SESSION['phone'])) {
        $f3->reroute('/profile');
    }

    //display a view
    $view = new Template();
    echo $view->render('views/sign-up/personal-info.html');
});

//sign up form 2 (profile info)
$f3->route('GET|POST /profile', function($f3) {
    $f3->set('page_title', 'Profile Info');

    //check email
    if(isset($_POST['email'])) {
        $email = $_POST['email'];
        $f3->set('email', $email);
        if(validEmail($email)) {
            $_SESSION['email'] = $email;
        }
        else {
            $f3->set("errors['email']", "Please enter a valid email address");
        }
    }

    //get rest of form data
    $_SESSION['state'] = $_POST['state'];
    $_SESSION['seeking'] = $_POST['seeking'];
    $_SESSION['bio'] = trim($_POST['bio']);

    if(isset($_SESSION['email'])) {
        $f3->reroute('/interests');
    }

    $view = new Template();
    echo $view->render('views/sign-up/profile.html');
});

//sign up form 3 (interests)
$f3->route('GET|POST /interests', function($f3) {
    $f3->set('page_title', 'Interests');

    if(isset($_POST['hidden'])) {
        //use hidden to submit without selections
        if(empty($_POST['interests'])) {
            $f3->reroute('/display-profile');
        }

        $interests = $_POST['interests'];
        $f3->set("interestsCheck", $interests);
        if(validInterests($interests)) {
            //creating string of interests
            $interests_string = implode(', ', $interests);
            trim($interests_string);
            substr($interests_string, -1);

            //save form info in session
            $_SESSION['interests'] = $interests_string;
            $f3->reroute('/display-profile');
        }
        else {
            $f3->set("errors['interests']", "Please select valid interests");
        }
    }
    else {
        $_SESSION['interests'] = "No interests selected";
        $f3->set("interestsCheck", array(''));
    }

    $view = new Template();
    echo $view->render('views/sign-up/interests.html');
});

//final step in sign up, display profile page
$f3->route('GET|POST /display-profile', function($f3) {
    $f3->set('page_title', 'My Profile');

    $view = new Template();
    echo $view->render('views/display-profile.html');
});

//run fat-free
$f3->run();