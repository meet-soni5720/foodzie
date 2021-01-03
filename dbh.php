<?php

session_start();

$dbServerName = "localhost";
$dbUserName = "root";
$dbPassword = "";
$dbName = "food_blog";

$conn = mysqli_connect($dbServerName, $dbUserName, $dbPassword, $dbName);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
  }

define ('ROOT_PATH', realpath(dirname(__FILE__)));
define('BASE_URL', 'http://localhost/food_blog/');

?>