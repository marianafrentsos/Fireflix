<?php
class Account {

    private $con;
    private $errorArray = array();

    public function __constructor($con, $errorArray) {
    $this->con = $con;
    }

    public function register($fn, $ln, $un, $em, $em2, $pw, $pw2){
        $this->validateFirstName($fn);
        $this->validateLastName($ln);
        $this->validateUserName($un);
        $this->validateEmails($em, $em2);
        $this->validatePasswords($pw, $pw2);

        if(empty($this->errorArray)) {
            return $this->insertUserDetails($fn, $ln, $un, $em, $pw);
        }

        return false; 
    }

    public function login($un, $pw) {
        $pw = hash("sha512", $pw); //hash the pass and store it 

        Global $con;
        $query=$con->prepare("SELECT * FROM users WHERE username=:un AND password=:pw");
        $query->bindValue(":un", $un);
        $query->bindValue(":pw", $pw);   

        $query->execute();

        if($query->rowCount() == 1) {
            return true;
        }

        array_push($this->errorArray, Constants::$loginFailed);

        return false;
    }

    private function insertUserDetails($fn, $ln, $un, $em, $pw) {
        $pw = hash("sha512", $pw); //hash the pass and store it 

        Global $con;
        $query=$con->prepare("INSERT INTO users (firstName, lastName, username, email, password)
                                VALUES(:fn, :ln, :un, :em, :pw)");
        $query->bindValue(":fn", $fn);
        $query->bindValue(":ln", $ln);
        $query->bindValue(":un", $un);
        $query->bindValue(":em", $em);
        $query->bindValue(":pw", $pw);

        return $query->execute();
        //return true or false depending if the data was inserted in the DB
    }

    private function validateFirstName($fn) {
        if(strlen($fn) < 2 || strlen($fn) > 25) {
            Global $errorArray;
            array_push($this->errorArray, Constants::$firstNameCharacters);
        }    
    }

    private function validateLastName($ln) {
        if(strlen($ln) < 2 || strlen($ln) > 25) {
            Global $errorArray;
            array_push($this->errorArray, Constants::$lastNameCharacters);
        }    
    }

    private function validateUserName($un) {
        if(strlen($un) < 2 || strlen($un) > 25) {
            Global $errorArray;
            array_push($this->errorArray, Constants::$userNameCharacters);
        }   
        
        Global $con;
        $query = $con->prepare("SELECT * FROM users WHERE username=:un");
        $query->bindValue(":un", $un);
    
        $query->execute();
    
        if($query->rowCount() != 0) {
            Global $errorArray;
            array_push($this->errorArray, Constants::$usernameTaken);
        }

    }

    private function validateEmails($em, $em2) {
        if($em !== $em2) {
            array_push($this->errorArray, Constants::$emailsDontMatch);
            return;
        }

        if(!filter_var($em, FILTER_VALIDATE_EMAIL)) {
            array_push($this->errorArray, Constants::$emailInvalid);
            return;
        }

        Global $con;
        $query = $con->prepare("SELECT * FROM users WHERE email=:em");
        $query->bindValue(":em", $em);
    
        $query->execute();
    
        if($query->rowCount() !== 0) {
            Global $errorArray;
            array_push($this->errorArray, Constants::$emailTaken);
        }

    }
    
    private function validatePasswords($pw, $pw2) {
        if($pw !== $pw2) {
            array_push($this->errorArray, Constants::$passwordsDontMatch);
            return;
        }

        if(strlen($pw) < 2 || strlen($pw) > 25) {
            Global $errorArray;
            array_push($this->errorArray, Constants::$passwordLenght);
        }
    }

    public function getError($error) {
            Global $errorArray;
            if(in_array($error, $this->errorArray)) {
                return "<span class='errorMessage'>$error</span>";
        }
    }
}

?>
