<?php
/* THIS SCRIPT NOT NECESSARILY PART OF PROJECT, JUST FOR TESTING IF YOU WANT TO
 * START WITH FRESH DATA, BUT IP ADDRESSES IN AVAILABLE_IP_ADDR TABLE WILL BE USED
 * FOR PART OF THE PROJECT, THIS SCRIPT SERVES NO OTHER PURPOSE THEN TO POPULATE
 * AVAILABLE_IP_ADDR WITH IP ADDRESSES */
require_once('../../controller/raspberrypi_mysql_connection.php');

global $MYSQL_CONN;

$available_ip_addr = false;
$request_reset = false;
$student_table = false;
$trun_ip_req = false;
$trun_aval_ip_addr = false;

// TRUNCATE tables first
// IP_REQUESTS
try {

    $sql = "TRUNCATE IP_REQUESTS";
    $MYSQL_CONN->exec($sql);
    $trun_ip_req = true;
    echo "IP_REQUESTS table successfully truncated...\n";

} catch(PDOException $e){
    echo "Error truncating IP_REQUESTS: ".$e->getMessage()."\n";
}

// AVAILABLE_IP_ADDR
try {

    $sql = "TRUNCATE AVAILABLE_IP_ADDR";
    $MYSQL_CONN->exec($sql);
    $trun_aval_ip_addr = true;
    echo "AVAILABLE_IP_ADDR table successfully truncated...\n";

} catch(PDOException $e) {
    echo "Error truncating AVAILABLE_IP_ADDR: ".$e->getMessage();
}

// ###########################################################################

try {

    $sql = "ALTER TABLE AVAILABLE_IP_ADDR AUTO_INCREMENT = 2";
    $MYSQL_CONN->exec($sql);
    echo "AVAILABLE_IP_ADDR table successfully altered...\n";
    $available_ip_addr = true;

} catch(PDOException $e) {
    echo "Error altering table: ".$e->getMessage()."\n";
}

try {

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

    $ip_addr_added = true;
    echo "AVAILABLE_IP_ADDR successfully populated with ip addresses...\n";

} catch(PDOException $e) {
    echo "Error adding ip addresses: ".$e->getMessage()."\n";
}

try {

    // Reset STUDENT REQUEST_SENT to 0
    $sql = "UPDATE STUDENT SET REQUEST_SENT = 0 WHERE REQUEST_SENT = 1";
    $stmt = $MYSQL_CONN->prepare($sql);
    $stmt->execute();
    $request_reset = true;
    echo "REQUEST_SENT successfully reset to 0...\n";

} catch(PDOException $e) {
    echo "Error resetting REQUEST_SENT to 0 in STUDENT table: ".$e->getMessage()."\n";
}

if($trun_ip_req && $trun_aval_ip_addr && $available_ip_addr && $ip_addr_added && $request_reset)
{
    echo "Successfully restarted testing data...\n";
}

?>
