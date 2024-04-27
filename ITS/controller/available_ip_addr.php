<?php 
/* THIS SCRIPT NOT NECESSARILY PART OF PROJECT, JUST FOR TESTING IF YOU WANT TO
 * START WITH FRESH DATA, BUT IP ADDRESSES IN AVAILABLE_IP_ADDR TABLE WILL BE USED
 * FOR PART OF THE PROJECT, THIS SCRIPT SERVES NO OTHER PURPOSE THEN TO POPULATE
 * AVAILABLE_IP_ADDR WITH IP ADDRESSES */
require_once('../controller/raspberrypi_mysql_connection.php');

global $MYSQL_CONN;

$subnet_24 = 2;

for($i = 2; $i <= 253; $i++)
{
    $ip_address = "10.50.4.$i";
    $sql = "INSERT INTO AVAILABLE_IP_ADDR (IP_ADDRESS)
            VALUES
            (?)";
    $stmt = $MYSQL_CONN->prepare($sql);
    $stmt->bindParam(1, $ip_address, PDO::PARAM_STR);
    $stmt->execute();
}

?>
