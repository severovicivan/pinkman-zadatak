<?php

class User extends Db {
    
    protected function getAllUsers() {
        $sql = "SELECT * FROM users";

        $result = $this->connect()->query($sql);
        $numRows = $result->num_rows;
        if ($numRows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        }
    }
}

class Country extends Db {
    
    protected function getAllCountries() {
        $sql = "SELECT * FROM country";

        $result = $this->connect()->query($sql);
        $numRows = $result->num_rows;
        if ($numRows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        }
    }
}

class Status extends Db {
    
    protected function getAllStatuses() {
        $sql = "SELECT * FROM stats"; // In condor.sql changed table name

        $result = $this->connect()->query($sql);
        $numRows = $result->num_rows;
        if ($numRows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        }
    }
}

// User class
// class Users {
//     // Constructor is a public method that is called when an object is created from a class
//     // Visibility must be alway public 
//     public function __construct(Array $properties=array()){
//         // echo 'Constructor run<br>';
//         foreach($properties as $key => $value){
//             $this->{$key} = $value;
//         }
//     } 
//     // De structor is used at the end of script
//     public function __destruct(){
//         echo 'This employee name '.$this->firstname.' is de structed';
//     }
//     // Properites
//     // public $firstName = 'Ivan';
//     // public $lastName = 'Severovic';
//     // public $userName = 'seve';
//     // public $contactInfo = [
//     //     'email' => 'abc',
//     //     'phone' => '123'
//     // ];
//     // Methods
//     function setUsername($name) {
//         // $this is pseudovariable only available inside of methods and reffers to an object 
//         $this->userName = $name;
//     }
// }