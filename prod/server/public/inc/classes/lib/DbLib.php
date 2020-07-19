<?php

require __DIR__ . '/../../../../vendor/autoload.php';

include_once __dir__.'/../../consts/consts.php';

class DbLib {

    function __construct() {
        
        $this->username = USERNAME;
        $this->password = PASSWORD;
        $host = SERVERHOST;
        $db = DB;

        $this->conn_str = "mysql:host=$host;dbname=$db";

    }

    public function connect(){
        try {
            $conn = new PDO($this->conn_str, $this->username, $this->password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        }catch(PDOException $e) {
            return 'Error: '.$e;
        }
    }
}