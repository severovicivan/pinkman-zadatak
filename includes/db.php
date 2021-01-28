<?php

$mysqli= new mysqli("localhost","root","","condor",3306);
if ($mysqli->connect_error) {
    exit('Error connecting to database');
}

class Db {
    private $servername;
    private $username;
    private $password;
    private $dbname;
    private $port;

    protected function connect() {
        $this->servername = "localhost";
        $this->username = "root";
        $this->password = "";
        $this->dbname = "condor";
        $this->port = 3306;

        $conn = new mysqli($this->servername, $this->username,
            $this->password, $this->dbname, $this->port);
        return $conn;
    }
}