<?php
/*
 Jason Engelbrecht
 5.23.2019
 https://jengelbrecht.greenriverdev.com/it328/dating
 Database class

 CREATE TABLE member (
 member_id INT AUTO_INCREMENT PRIMARY KEY,
 fname VARCHAR(30) NOT NULL,
 lname VARCHAR(30) NOT NULL,
 age VARCHAR(30) NOT NULL,
 gender CHAR(6),
 phone VARCHAR(20) NOT NULL,
 email VARCHAR(320) NOT NULL,
 state VARCHAR(30),
 seeking CHAR(6),
 bio TEXT,
 premium TINYINT,
 image VARCHAR(30)
 );

 CREATE TABLE interest (
 interest_id INT AUTO_INCREMENT PRIMARY KEY,
 interest VARCHAR(30),
 type VARCHAR(20)
 );

 CREATE TABLE member_interest (
 member_id INT NOT NULL,
 interest_id INT NOT NULL,
 FOREIGN KEY(member_id) references member(member_id),
 FOREIGN KEY(interest_id) references interest(interest_id)
 );
 */
require '/home/jengelbr/config.php';

/**
 * Class representing a database
 *
 * This class represents a database object for interactions.
 * @author Jason Engelbrecht
 * @copyright 2019
 */
class Database
{
    private $_db;

    /**
     * Database constructor
     * @return void
     */
    function __construct()
    {
        $this->connect();
    }

    /**
     * Connect to database
     * @return PDO
     */
    function connect()
    {
        try {
            //Instantiate a db object
            $this->_db = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            return $this->_db;
        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Insert a member
     * @param $fname - first name
     * @param $lname - last name
     * @param $age - age
     * @param $phone - phone number
     * @param $email - email address
     * @param string $gender - gender
     * @param string $state - residing state
     * @param string $seeking - gender seeking
     * @param string $bio - bio
     * @param int $premium - if premium member(1) or not(0)
     * @param string $image - image path
     * @return void
     */
    function insertMember($fname, $lname, $age, $phone, $email,
                          $gender='Unselected',
                          $state='Unselected',
                          $seeking='Unselected',
                          $bio='Nothing yet',
                          $premium=0,
                          $image='none')
    {
        //define query
        $query = 'INSERT INTO member
                  (fname, lname, age, gender, phone, email, state, seeking, bio, premium, image)
                  VALUES
                  (:fname, :lname, :age, :gender, :phone, :email, :state, :seeking, :bio, :premium, :image)';

        //prepare statement
        $statement = $this->_db->prepare($query);

        //bind parameters
        $statement->bindParam(':fname', $fname, PDO::PARAM_STR);
        $statement->bindParam(':lname', $lname, PDO::PARAM_STR);
        $statement->bindParam(':age', $age, PDO::PARAM_STR);
        $statement->bindParam(':gender', $gender, PDO::PARAM_STR);
        $statement->bindParam(':phone', $phone, PDO::PARAM_STR);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->bindParam(':state', $state, PDO::PARAM_STR);
        $statement->bindParam(':seeking', $seeking, PDO::PARAM_STR);
        $statement->bindParam(':bio', $bio, PDO::PARAM_STR);
        $statement->bindParam(':premium', $premium, PDO::PARAM_INT);
        $statement->bindParam(':image', $image, PDO::PARAM_STR);

        //execute statement
        $statement->execute();
        echo 'success';
    }

    /**
     * Insert a member-interest pair
     * @param $member_id - member's id
     * @param $interest_id - interest's id
     */
    function insertMemberInterest($member_id, $interest_id)
    {
        //define query
        $query = 'INSERT INTO member_interest (member_id, interest_id)
                  VALUES (:member_id, :interest_id)';

        //prepare statement
        $statement = $this->_db->prepare($query);

        //bind parameters
        $statement->bindParam(':member_id', $member_id, PDO::PARAM_STR);
        $statement->bindParam(':interest_id', $interest_id, PDO::PARAM_STR);

        //execute statement
        $statement->execute();
        echo 'success';
    }

    /**
     * Get interest id with label
     * @param $interest - interest label
     * @return mixed
     */
    function getInterestID($interest)
    {
        //define query
        $query = "SELECT interest_id FROM interest
                  WHERE interest = :interest";

        //prepare statement
        $statement = $this->_db->prepare($query);

        //bind parameters
        $statement->bindParam(':interest', $interest);

        //execute
        $statement->execute();

        //get result
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * Get member id with first and last name
     * @param $fname - first name
     * @param $lname - last name
     * @return mixed
     */
    function getMemberID($fname, $lname)
    {
        //define query
        $query = "SELECT member_id FROM member
                  WHERE fname = :fname 
                  AND lname = :lname";

        //prepare statement
        $statement = $this->_db->prepare($query);

        //bind parameters
        $statement->bindParam(':fname', $fname);
        $statement->bindParam(':lname', $lname);

        //execute
        $statement->execute();

        //get result
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * Get all members
     * @return mixed
     */
    function getMembers()
    {
        //define query
        $query = "SELECT * FROM member
                  ORDER BY lname ASC";

        //prepare statement
        $statement = $this->_db->prepare($query);

        //execute
        $statement->execute();

        //get results
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    /**
     * Get member
     * @param $member_id - member id
     * @return mixed
     */
    function getMember($member_id)
    {
        //define query
        $query = "SELECT * FROM member
                  WHERE member_id = :member_id";

        //prepare statement
        $statement = $this->_db->prepare($query);

        //bind parameters
        $statement->bindParam(':member_id', $member_id);

        //execute
        $statement->execute();

        //get result
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * Get interests for member
     * @param $member_id - member id
     * @return mixed
     */
    function getInterests($member_id)
    {
        //define query
        $query = "SELECT interest, type
                  FROM interest
                  INNER JOIN member_interest
                  ON member_interest.interest_id = interest.interest_id
                  WHERE member_id = :member_id";

        //prepare statement
        $statement = $this->_db->prepare($query);

        //bind parameters
        $statement->bindParam(':member_id', $member_id);

        //execute
        $statement->execute();

        //get results
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }
}