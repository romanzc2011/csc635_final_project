<?php

$host = "localhost";
$username = "roman";
$password = "ryder";
$db_name = "CSC635_FINAL_PROJECT";

// Create a new PDO instance
$MYSQL_CONN = new PDO('mysql:dbname='.$db_name.';host='.$host, $username, $password);

// Set PDO to throw exceptions on error
$MYSQL_CONN->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>


