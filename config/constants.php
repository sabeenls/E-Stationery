<?php
    //start session
    session_start();
    //create comstant to store non repeating value
    define('SITEURL', 'http://localhost/estationery/');
    define('LOCALHOST', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'db_estationery');


    $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());  //db connection
    $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error());   //selecting bd

?>