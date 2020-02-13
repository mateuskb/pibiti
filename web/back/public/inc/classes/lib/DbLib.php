<?php

require __DIR__ . '/../../../../vendor/autoload.php';

include_once __dir__.'/../../consts/consts.php';

class DbLib {

    function __construct() {
        
        $username = USERNAME;
        $password = PASSWORD;
        $host = SERVERHOST;
        $db = DB;

        $conn_str = "mysql:host=$host;dbname=$db";

        try {
            $conn = new PDO($conn_str, $username, $password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        }catch(PDOException $e) {
            return false;
        }
    }
}