<?php
/**
 * Created by PhpStorm.
 * User: haro5
 * Date: 5/10/2019
 * Time: 1:17 PM
 */

/**
 * Class representing a member
 *
 * This class represents a dating member with fields for all information requested on sign up
 * @author Jason Engelbrecht
 * @copyright 2019
 */
class Member
{
    private $_fname;
    private $_lname;
    private $_age;
    private $_email;
    private $_phone;
    private $_gender;
    private $_state;
    private $_seeking;
    private $_bio;

    /**
     * Member constructor
     * @param $fname string - First name of member
     * @param $lname string - Last name of member
     * @param $age int - Age of member
     * @param $phone int - Phone number of member
     * @param $email int - Email of member
     * @param $gender string - Gender of member
     * @param $state string - State member resides
     * @param $seeking string - Gender preference of member
     * @param $bio string - Bio of member
     * @return void
     */
    function __construct($fname, $lname, $age, $phone, $email,
                                $gender='Unselected', $state='United States',
                                $seeking='Unselected', $bio='No bio yet')
    {
        $this->_fname = $fname;
        $this->_lname = $lname;
        $this->_age = $age;
        $this->_phone = $phone;
        $this->_email = $email;
        $this->_gender = $gender;
        $this->_state = $state;
        $this->_seeking = $seeking;
        $this->_bio = $bio;
    }

    /**
     * Get first name of member
     * @return string
     */
    function getFname()
    {
        return $this->_fname;
    }

    /**
     * Set first name of member
     * @param $fname string - First name of member
     * @return void
     */
    function setFname($fname)
    {
        $this->_fname = $fname;
    }

    /**
     * Get last name of member
     * @return string
     */
    function getLname()
    {
        return $this->_lname;
    }

    /**
     * Set last name of member
     * @param $lname string - Last name of member
     * @return void
     */
    function setLname($lname)
    {
        $this->_lname = $lname;
    }

    /**
     * Get age of member
     * @return int
     */
    function getAge()
    {
        return $this->_age;
    }

    /**
     * Set age of member
     * @param $age int - Age of member
     * @return void
     */
    function setAge($age)
    {
        $this->_age = $age;
    }

    /**
     * Get gender of member
     * @return string
     */
    function getGender()
    {
        return $this->_gender;
    }

    /**
     * Set gender of member
     * @param $gender string - Gender of member
     * @return void
     */
    function setGender($gender)
    {
        $this->_gender = $gender;
    }

    /**
     * Get phone number of member
     * @return int
     */
    function getPhone()
    {
        return $this->_phone;
    }

    /**
     * Set phone number of member
     * @param $phone string - Phone number of member
     * @return void
     */
    function setPhone($phone)
    {
        $this->_phone = $phone;
    }

    /**
     * Get email of member
     * @return string
     */
    function getEmail()
    {
        return $this->_email;
    }

    /**
     * Set email of member
     * @param $email string - Email of member
     * @return void
     */
    function setEmail($email)
    {
        $this->_email = $email;
    }

    /**
     * Get state member resides
     * @return string
     */
    function getState()
    {
        return $this->_state;
    }

    /**
     * Set state member resides
     * @param $state string - State member resides
     * @return void
     */
    function setState($state)
    {
        $this->_state = $state;
    }

    /**
     * Get gender preference of member
     * @return string
     */
    function getSeeking()
    {
        return $this->_seeking;
    }

    /**
     * Set gender preference of member
     * @param $seeking string - Gender preference of member
     * @return void
     */
    function setSeeking($seeking)
    {
        $this->_seeking = $seeking;
    }

    /**
     * Get bio of member
     * @return string
     */
    function getBio()
    {
        return $this->_bio;
    }

    /**
     * Set bio of member
     * @param $bio string - Bio of member
     * @return void
     */
    function setBio($bio)
    {
        $this->_bio = $bio;
    }
}