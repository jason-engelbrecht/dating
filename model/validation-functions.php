<?php
/*
Jason Engelbrecht
5.4.2019
https://jengelbrecht.greenriverdev.com/it328/dating
Validation functions.
*/

/**
 * Validate name
 * @param String name
 * @return boolean
*/
function validName($name) {
    return (!empty($name) && ctype_alpha($name));
}

/**
 * Validate age
 * @param String age
 * @return boolean
 */
function validAge($age) {
    return (!empty($age) && ctype_digit($age) && ($age >= 18 && $age <= 118));
}

/**
 * Validate phone number
 * @param String phone number
 * @return boolean
 */
function validPhone($phone) {
    return (!empty($phone));
}

/**
 * Validate email
 * @param String email
 * @return boolean
 */
function validEmail($email) {
    $email = filter_var(trim($email), FILTER_VALIDATE_EMAIL);
    if($email != false) {
        return true;
    }
    return false;
}

/**
 * Validate interests
 * @param String interests
 * @return boolean
 */
function validInterests($interests) {
    foreach ($interests as $interest) {
        if (!in_array($interest, $interests)) {
            return false;
        }
    }
    return true;
} //only did 1 interests validation function to avoid unnecessary complexity