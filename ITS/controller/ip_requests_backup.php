
<?php
require_once(__DIR__.'/../../controller/raspberrypi_mysql_connection.php');
/* This script responsible for inserting ip requests into the IP_REQUESTS table*/
global $MYSQL_CONN;
$student_id = "";
$request_sent = 0;
$courses_str = ""; // This variable to be used in building insert statement
$courses_rpi_used = array();

// Class variables for true/false ip_requests
$csc242 = 0;
$csc315 = 0;
$csc382 = 0;
$csc435_635 = 0;
$csc_other = 0;

// Query Student table for new requests
$sql = "SELECT STUDENT_ID, COURSE_RPI_USED, REQUEST_SENT FROM STUDENT";

$stmt = $MYSQL_CONN->prepare($sql);
$stmt->execute();
$query_results = $stmt->fetchAll();

// Begin building dynamic insert statement
$sql = "INSERT INTO IP_REQUESTS (STUDENT_ID, CSC_242, CSC_315, CSC_382, CSC_435_635, OTHER)
        VALUES (?,?,?,?,?,?)";

// Begin preparing the sql statement for insertion
$stmt = $MYSQL_CONN->prepare($sql);

// Loop through results, grab student id, check if request has been sent
// if not, check if has_ip is true, if not then grab all courses taken and explode into array
foreach($query_results as $row)
{
    $student_id = $row['STUDENT_ID'];
    $request_sent = $row['REQUEST_SENT'];
    $courses_rpi_used = explode(",", $row['COURSE_RPI_USED']);
    
    if($request_sent === 0)
    {
        // Check for proper formatting ie. only this formatting is acceptable CSC242
        // Must loop thru $courses_rpi_used in case multiple classes
        foreach($courses_rpi_used as $course)
        {
            $course = preg_replace('/[^A-Z0-9]+/','',$course);

            // Go thru each $course to determine which course requires, rpi
            switch($course)
            {
                case 'CSC242':
                    $csc242 = 1;
                    break;
                case 'CSC315':
                    $csc315 = 1;
                    break;
                case 'CSC382':
                    $csc382 = 1;
                    break;
                case 'CSC435635':
                    $csc435_635 = 1;
                    break;
                case 'OTHER':
                    $csc_other = 1;
                    break;
            }

        }
        // Complete param binding and execute insert for each row
        $stmt->bindParam(1, $student_id, PDO::PARAM_STR);
        $stmt->bindParam(2, $csc242, PDO::PARAM_INT);
        $stmt->bindParam(3, $csc315, PDO::PARAM_INT);
        $stmt->bindParam(4, $csc382, PDO::PARAM_INT);
        $stmt->bindParam(5, $csc435_635, PDO::PARAM_INT);
        $stmt->bindParam(6, $csc_other, PDO::PARAM_INT);

        try {
        
            // Execute and commit
            if($stmt->execute())
            {
                echo "Data insertion successful\n";

                // Send success response back to STUDENT with REQUEST_SENT = 1 (TRUE)
                $request_sent = 1;

                $sql = "UPDATE STUDENT SET REQUEST_SENT = ? WHERE STUDENT_ID = ?";
                $stmt = $MYSQL_CONN->prepare($sql);
                $stmt->bindParam(1, $request_sent, PDO::PARAM_INT);
                $stmt->bindParam(2, $student_id, PDO::PARAM_STR);
                
                // Attempt execution, alert if failure
                try {
                    $stmt->execute();
                    echo "REQUEST UPDATED SUCCESSFULLY...\n";
                } catch(PDOException $e) {
                    echo "Error updating record: ".$e->getMessage();
                }
            } 
        } catch(PDOException $e) {
            echo "Error: ". $e->getMessage();
        }
    }    
}
?>
