<?php
    $servername = "localhost";
    $database = "db_website"; 
    $user = "root"; 
    $password = ""; 
    $db = mysqli_connect($servername, $user, $password, $database);
    if ($db->connect_error) {
        error_log('Connection error: ' . $db->connect_error);
    }
?>
