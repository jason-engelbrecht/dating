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
    return (!empty($string) && ctype_alpha($name));
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
    $phone = trim($phone);
    //1 pass, 0 fail
    $check = preg_match("^(?:(?:\+?1\s*(?:[.-]\s*)?)?(?:\(\s*([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9])\s*\)|([2-9]1
    [02-9]|[2-9][02-8]1|[2-9][02-8][02-9]))\s*(?:[.-]\s*)?)?([2-9]1[02-9]|[2-9][02-9]1|[2-9][02-9]{2})\s*(?:[.-]\s*)?
    ([0-9]{4})(?:\s*(?:#|x\.?|ext\.?|extension)\s*(\d+))?$
    ", $phone); //source: https://stackoverflow.com/questions/123559/a-comprehensive-regex-for-phone-number-validation
    return (!empty($age) && $check == 1);
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