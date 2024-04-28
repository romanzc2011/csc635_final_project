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
$all_query_results; // Need global access to check courses flagged, prevent redundant SELECT

// Function for getting ip requests manually
function getIPRequests()
{
    global $MYSQL_CONN;

    $sql = "SELECT * FROM IP_REQUESTS";
    // Prepare sql and exec
    $stmt = $MYSQL_CONN->prepare($sql);
    $stmt->execute();

    $all_query_results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if(empty($all_query_results))
    {
        echo 0;
    }
    
    // Display the results in the IP REQUEST table
    foreach($all_query_results as $row)
    {
        print('<tr>');
        print('<td>'.$row['STUDENT_ID'].'</td>');
        print('<td>'.$row['CSC_242'].'</td>');
        print('<td>'.$row['CSC_315'].'</td>');
        print('<td>'.$row['CSC_382'].'</td>');
        print('<td>'.$row['CSC_435_635'].'</td>');
        print('<td>'.$row['OTHER'].'</td>');
        print('</tr>');
    }
}
// Function to determine if the request in IP_REQUESTS can be deleted
function canDelete($student_id)
{
    global $MYSQL_CONN;

    try {
        // Start transaction to delete if no more courses need ip
        $MYSQL_CONN->beginTransaction();

        // Delete from record if no 1's
        $sql = "DELETE FROM IP_REQUESTS 
            WHERE STUDENT_ID = ?
            AND CSC_242 != 1
            AND CSC_315 != 1
            AND CSC_382 != 1
            AND CSC_435_635 != 1
            AND OTHER != 1";
        $stmt = $MYSQL_CONN->prepare($sql);
        $stmt->execute([$student_id]);
    
        if($stmt->rowCount() > 0)
        {
            echo "Deleting record. Row affected: ".$stmt->rowCount()."\n";
            $MYSQL_CONN->commit();
        } else {
            echo "No records deleted\n";
            $MYSQL_CONN->rollBack();
        }
    } catch(PDOException $e) {
        $MYSQL_CONN->rollBack();
        echo "Error: ".$e->getMessage(),"\n";
    }
}

// ###################################################################################
// CONTROL FLOW
// ###################################################################################

// Determine if fetch request
if($_SERVER['REQUEST_METHOD'] == "GET")
{
    if(isset($_GET['action']))
    {
        switch($_GET['action']) {
            case 'fetch_requests':
                getIPRequests();
        }
    }
}

// Get incoming variables
if($_SERVER['REQUEST_METHOD'] == "POST")
{
    $ip_address = isset($_POST['ip_addr_assign']) ? $_POST['ip_addr_assign'] : "";
    $course = isset($_POST['assign_course']) ? strtoupper($_POST['assign_course']) : "";
    $student_id = isset($_POST['INS_student_id']) ? strtoupper($_POST['INS_student_id']) : "";

    // ################################################################################
    // CHECKING FOR AVAILABILITY AND INSERTING NEW IP ADDRESS SECTION
    // ################################################################################
    //
    // Check for ip availability #######################################
    // Get the last octet of IP address, these will be the primary key to search for
    $entry_id = strripos($ip_address,'.');
    $entry_id = substr($ip_address,$entry_id + 1);
    $entry_id = intval($entry_id);

    // Prepare, execute, and fetchall, we're checking for ip address availabbility
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
            // Check if requested IP has already been assigned
            $sql = "SELECT STUDENT_ID FROM AVAILABLE_IP_ADDR WHERE ENTRY_ID = ?";
            $stmt = $MYSQL_CONN->prepare($sql);
            $stmt->execute([$entry_id]);
            $ip_addr_result = $stmt->fetch();

            // If empty continue assignment
            if(empty($ip_addr_result['STUDENT_ID']))
            {
                $sql = "UPDATE AVAILABLE_IP_ADDR SET STUDENT_ID = ?, COURSE = ? WHERE ENTRY_ID = ?";
                $stmt = $MYSQL_CONN->prepare($sql);
                $stmt->execute([$student_id,$course,$entry_id]);

                // Now that IP address has been assigned, we need to remove the request
                // Update the flag to 0, once that is

                // Build dynamic update to set correct course flag to 0
                $tmp_dept = substr($course,0,3);
                $tmp_num = substr($course,3,3);
                $update_course = $tmp_dept.'_'.$tmp_num;

                $sql = "UPDATE IP_REQUESTS SET $update_course = 0 WHERE STUDENT_ID = ?";
                $stmt = $MYSQL_CONN->prepare($sql);
                $stmt->execute([$student_id]);

                echo "IP address successfully assigned to: ".$student_id."\n";

                // Delete request if no more from that student_id
                canDelete($student_id);

            } else {
                echo "IP address has already been assigned to: ".$student_id."\n";
            }
        } else {
            echo "No student exists with ID: ".$student_id."\n";
        }
    } else {
        echo "IP address is already assigned to student: ".$query_result['STUDENT_ID']."\n";
    }
}
// ################################################################################   
// END AVAILABILITY/INSERTION OF IP ADDRESS SECTION
// ################################################################################   
