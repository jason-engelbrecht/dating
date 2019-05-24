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
require_once'vendor/autoload.php';
require'model/validation-functions.php';

session_start();

$db = new Database();

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

//define default root
$f3->route('GET /', function($f3) {
    $f3->set('page_title', 'Home');

    /*global $db;
    $interests = $db->getMembers();
    foreach ($interests as $interest) {
        echo $interest['fname'];
    }*/

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
            define('FNAME', $fname);
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
            define('LNAME', $lname);
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
            define('AGE', $age);
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
            define('PHONE', $phone);
        }
        else {
            $f3->set("errors['phone']", "Please enter a valid phone number");
        }
    }

    //get gender
    if(isset($_POST['gender'])) {
        define('GENDER', $_POST['gender']);
        $_SESSION['gender'] = $_POST['gender'];
    }
    else {
        define('GENDER', 'Unselected');
    }

    //for sticky form
    $_SESSION['premium'] = $_POST['premium'];

    //if all required constants are defined
    if(defined('FNAME') && defined('LNAME') && defined('AGE') && defined('PHONE')) {
        //premium member
        if(isset($_POST['premium'])) {
            $_SESSION['member'] = new PremiumMember(FNAME, LNAME, AGE, PHONE, GENDER);
        }
        //non-premium
        else {
            $_SESSION['member'] = new Member(FNAME, LNAME, AGE, PHONE, GENDER);
        }
        //continue
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
            define('EMAIL', $email);
        }
        else {
            $f3->set("errors['email']", "Please enter a valid email address");
        }
    }

    //get state
    if($_POST['state'] == 'none') {
        define('STATE', 'Unselected');
    }
    else {
        define('STATE', $_POST['state']);
        $_SESSION['state'] = $_POST['state'];
    }

    //get seeking
    if(isset($_POST['seeking'])) {
        define('SEEKING', $_POST['seeking']);
        $_SESSION['seeking'] = $_POST['seeking'];
    }
    else {
        define('SEEKING', 'Unselected');
    }

    //get bio
    if(strlen(trim($_POST['bio'])) < 1) {
        define('BIO', 'Nothing yet');
    }
    else {
        define('BIO', $_POST['bio']);
        $_SESSION['bio'] = $_POST['bio'];
    }

    //email required
    if(defined('EMAIL')) {
        //set fields for member
        $member = $_SESSION['member'];
        $member->setEmail(EMAIL);
        $member->setState(STATE);
        $member->setSeeking(SEEKING);
        $member->setBio(BIO);
        $_SESSION['member'] = $member;

        //check where to go next
        if($member instanceof PremiumMember) {
            $f3->reroute('/interests');
        }
        else {
            $f3->reroute('/display-profile');
        }
    }
    $view = new Template();
    echo $view->render('views/sign-up/profile.html');
});

//sign up form 3 (interests)
$f3->route('GET|POST /interests', function($f3) {
    $f3->set('page_title', 'Interests');

    //grab member object
    $member = $_SESSION['member'];

    if(isset($_POST['hidden'])) {
        //use hidden to submit without selections
        if(empty($_POST['interests'])) {
            $member->setIndoorInterests(array('None selected'));
            $member->setOutdoorInterests(array('None selected'));
            $f3->reroute('/display-profile');
        }

        //validate interests
        $interests = $_POST['interests'];
        $f3->set("interestsCheck", $interests);
        if(validInterests($interests)) {
            //separate interests
            $tempIndoor = array();
            $tempOutdoor = array();
            foreach ($interests as $interest) {
                if(in_array($interest, $f3->get('indoorInterests'))) {
                    array_push($tempIndoor, $interest);
                }
                else if(in_array($interest, $f3->get('outdoorInterests'))) {
                    array_push($tempOutdoor, $interest);
                }
            }
            //add them to premium member object
            $member->setIndoorInterests($tempIndoor);
            $member->setOutdoorInterests($tempOutdoor);
            $_SESSION['member'] = $member;

            $f3->reroute('/display-profile');
        }
        else {
            $f3->set("errors['interests']", "Please select valid interests");
        }
    }
    else {
        //$_SESSION['interests'] = "No interests selected";
        $f3->set("interestsCheck", array(''));
    }
    $view = new Template();
    echo $view->render('views/sign-up/interests.html');
});

//display profile page
$f3->route('GET|POST /display-profile', function($f3) {
    $f3->set('page_title', 'My Profile');

    //get member and db object
    $member = $_SESSION['member'];
    global $db;

    //grab values for insertion
    $fname = $member->getFname();
    $lname = $member->getLname();
    $age = $member->getAge();
    $phone = $member->getPhone();
    $email = $member->getEmail();
    $gender = $member->getGender();
    $state = $member->getState();
    $seeking = $member->getSeeking();
    $bio = $member->getBio();

    //insert based on member type
    if($member instanceof PremiumMember) {
        $db->insertMember($fname, $lname, $age, $phone, $email,
                          $gender, $state, $seeking, $bio, 1);

        //get member id
        $member_id = $db->getMemberID($fname, $lname);

        //insert into member_interest
        $interests = array_merge($member->getIndoorInterests(), $member->getOutdoorInterests());
        foreach ($interests as $interest) {
            $interest_id = $db->getInterestID($interest);
            $db->insertMemberInterest($member_id['member_id'], $interest_id['interest_id']);
        }
    }
    else {
        $db->insertMember($fname, $lname, $age, $phone, $email,
                          $gender, $state, $seeking, $bio, 0);
    }

    $view = new Template();
    echo $view->render('views/display-profile.html');
});

//admin route
$f3->route('GET /admin', function($f3) {
    $f3->set('page_title', 'Admin');

    //get members
    global $db;
    $members = $db->getMembers();

    //set members and db for use in admin
    $f3->set('members', $members);
    $f3->set('db', $db);

    //display a view
    $view = new Template();
    echo $view->render('views/admin.html');
});

//run fat-free
$f3->run();