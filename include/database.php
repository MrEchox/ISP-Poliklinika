<?php

include("constants.php");

class MySQLDB {

    var $connection;         //The MySQL database connection

    /* Class constructor */

    function MySQLDB() {
        /* Make connection to database */
        $this->connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    
        /* Check the connection */
        if ($this->connection) {
            echo "Connected to the database successfully!";
        } else {
            die("Connection failed: " . mysqli_connect_error() . '<br><h1>Faile include/constants.php suveskite savo MySQLDB duomenis.</h1>');
        }
    }
    

    /**
     * confirmUserPass - Checks whether or not the given
     * email is in the database, if so it checks if the
     * given password is the same password in the database
     * for that user. If the user doesn't exist or if the
     * passwords don't match up, it returns an error code
     * (1 or 2). On success it returns 0.
     */
    function confirmUserPass($email, $password) {
        /* Verify that user is in the database */
        $email = mysqli_real_escape_string($this->connection, $email);
        $q = "SELECT Slaptazodis FROM " . TBL_USERS . " WHERE EPastas = '$email'";
        $result = mysqli_query($this->connection, $q);
    
        if (!$result || (mysqli_num_rows($result) < 1)) {
            return 1; // Indicates email failure
        }
    
        /* Retrieve password from result, no need to strip slashes */
        $dbarray = mysqli_fetch_array($result);
    
        /* Validate that password is correct */
        if ($password === $dbarray['password']) {
            return 0; // Success! Username and password confirmed
        } else {
            return 2; // Indicates password failure
        }
    }
    

    /**
     * emailtaken - Returns true if the email has
     * been taken by another user, false otherwise.
     */
    function emailTaken($email) {
        $q = "SELECT EPastas FROM " . TBL_USERS . " WHERE EPastas = '$email'";
        $result = mysqli_query($this->connection, $q);
        return (mysqli_num_rows($result) > 0);
    }

    /**
     * addNewUser - Inserts the given (username, password, email)
     * Returns true on success, false otherwise.
     */
    function addNewUser($name, $surname, $email, $tel_nr, $password) {
        $time = time();
        $q = "INSERT INTO " . TBL_USERS . " VALUES ('$name', '$surname', '$email', '$tel_nr', '$password', 'Svečias')";
        return mysqli_query($this->connection, $q);
    }

    /**
     * updateUserField - Updates a field, specified by the field
     * parameter, in the user's row of the database.
     */
    function updateUserField($email, $field, $value) {
        $q = "UPDATE " . TBL_USERS . " SET " . $field . " = '$value' WHERE email = '$email'";
        return mysqli_query($this->connection, $q);
    }

    /**
     * getUserInfo - Returns the result array from a mysql
     * query asking for all information stored regarding
     * the given username. If query fails, NULL is returned.
     */
    function getUserInfo($email) {
        $q = "SELECT * FROM " . TBL_USERS . " WHERE EPastas = '$email'";
        $result = mysqli_query($this->connection, $q);
        /* Error occurred, return given name by default */
        if (!$result || (mysqli_num_rows($result) < 1)) {
            return NULL;
        }
        /* Return result array */
        $dbarray = mysqli_fetch_array($result);
        return $dbarray;
    }

    /**
     * query - Performs the given query on the database and
     * returns the result, which may be false, true or a
     * resource identifier.
     */
    function query($query) {
        return mysqli_query($this->connection, $query);
    }

}

/* Create database connection */
$database = new MySQLDB;
