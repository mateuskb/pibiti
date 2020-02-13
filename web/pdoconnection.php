<?php
$servername = "localhost";
$username = "mateuskb";
$password = "Qwerty123@";
$db = 'pibiti';

$conn_str = "mysql:host=$servername;dbname=$db";

try {
    $conn = new PDO($conn_str, $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    #echo "Connected successfully"; 
    var_dump($conn);
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
?>