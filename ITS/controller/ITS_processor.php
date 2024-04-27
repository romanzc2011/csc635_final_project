<?php
/* This script will be used to query AVAILABLE_IP_ADDR if receiving a request from
 *  the ITS_interface.php. It will search if IP address is available and assign it, 
 *  ip addresses start at .2 and end at .253, network is usually assigned .0, .1 is 
 *  for default gateway and .254 reserved, .255 for broadcasting */
ini_set('display_errors',1);
ini_set('log_errors',1);
error_reporting(E_ALL);
require_once('../../controller/raspberrypi_mysql_connection.php');

global $MYSQL_CONN;
$ip_address = "";
$course = "";
$entry_id = "";
$student_id = "";
$student_exists = "";

// Get incoming variables
if($_SERVER['REQUEST_METHOD'] == "POST")
{
    $ip_address = isset($_POST['ip_addr_assign']) ? $_POST['ip_addr_assign'] : "";
    $course = isset($_POST['assign_course']) ? strtoupper($_POST['assign_course']) : "";
    $student_id = isset($_POST['INS_student_id']) ? strtoupper($_POST['INS_student_id']) : "";
}

// ################################################################################
// CHECKING FOR AVAILABILITY AND INSERTING NEW IP ADDRESS SECTION
// ################################################################################   
//
// Check for ip availability #######################################
// Get the last octet of IP address, these will be the primary key to search for
$entry_id = strripos($ip_address,'.');
$entry_id = substr($ip_address,$entry_id + 1);
$entry_id = intval($entry_id);

// Prepare, execute, and fetchall
$sql = "SELECT STUDENT_ID FROM AVAILABLE_IP_ADDR WHERE ENTRY_ID = ?";
$stmt = $MYSQL_CONN->prepare($sql);
$stmt->execute([$entry_id]);
$query_result = $stmt->fetch();

if(empty($query_result['STUDENT_ID']))
{
    // Check first if STUDENT_ID is actually in the STUDENT table
    $sql = "SELECT STUDENT_ID FROM STUDENT WHERE STUDENT_ID = ?";
    $stmt = $MYSQL_CONN->prepare($sql);
    $stmt->execute([$student_id]);
    $student_exists = $stmt->fetch();

    if($student_exists)
    {
        // Assign IP ADDR to student
        $sql = "UPDATE AVAILABLE_IP_ADDR SET STUDENT_ID = ? WHERE ENTRY_ID = ?";
        $stmt = $MYSQL_CONN->prepare($sql);
        $stmt->execute([$student_id, $entry_id]);

        echo "IP address successfully assigned to: ".$student_id;
    } else {
        echo "No student exists with ID: ".$student_id;
    }
    
} else {
    echo "IP address is already assigned to student: ".$query_result['STUDENT_ID'];
}


// ################################################################################   
// END AVAILABILITY/INSERTION OF IP ADDRESS SECTION
// ################################################################################   

?>
