<?php
/**
 * Created by PhpStorm.
 * User: haro5
 * Date: 5/10/2019
 * Time: 1:18 PM
 */

/**
 * Class represents a premium member
 *
 * This class extends member with added fields for indoor and outdoor interests to support premium functionality
 * @author Jason Engelbrecht
 * @copyright 2019
 */
class PremiumMember extends Member
{
    private $_indoorInterests;
    private $_outdoorInterests;

    /**
     * Member constructor
     * @param $fname string - First name of member
     * @param $lname string - Last name of member
     * @param $age int - Age of member
     * @param $phone int - Phone number of member
     * @param $gender string - Gender of member
     * @return void
     */
    function __construct($fname, $lname, $age, $phone, $gender)
    {
        //pass to parent constructor
        parent::__construct($fname, $lname, $age, $phone, $gender);
    }

    /**
     * Get indoor interests of premium member
     * @return array
     */
    function getIndoorInterests()
    {
        return $this->_indoorInterests;
    }

    /**
     * Set indoor interests of premium member
     * @param $indoorInterests array - Indoor interests of premium member
     * @return void
     */
    function setIndoorInterests($indoorInterests)
    {
        $this->_indoorInterests = $indoorInterests;
    }

    /**
     * Get outdoor interests of premium member
     * @return array
     */
    function getOutdoorInterests()
    {
        return $this->_outdoorInterests;
    }

    /**
     * Set outdoor interests of premium member
     * @param $outdoorInterests array - Outdoor interests of premium member
     * @return void
     */
    function setOutdoorInterests($outdoorInterests)
    {
        $this->_outdoorInterests = $outdoorInterests;
    }
}