
<?php
require_once(__DIR__.'/../../controller/raspberrypi_mysql_connection.php');
/* This script responsible for inserting ip requests into the IP_REQUESTS table*/
global $MYSQL_CONN;

// Prepare all sql statements first before exec
// GRAB CURRENT STUDENT RPI INFORMATION
$sql_select = "SELECT STUDENT_ID, COURSE_RPI_USED, REQUEST_SENT FROM STUDENT";
$stmt_select = $MYSQL_CONN->prepare($sql_select);
$stmt_select->execute();
$query_results = $stmt_select->fetchAll(PDO::FETCH_ASSOC);

// INSERT STATEMENTS
$sql_insert = "INSERT INTO IP_REQUESTS (STUDENT_ID, CSC_242, CSC_315, CSC_382, CSC_435_635, OTHER)
                VALUES
                (?,?,?,?,?,?)";
$stmt_insert = $MYSQL_CONN->prepare($sql_insert);

// UPDATE STATEMENT
$sql_update = "UPDATE STUDENT SET REQUEST_SENT = ? WHERE STUDENT_ID = ?";
$stmt_update = $MYSQL_CONN->prepare($sql_update);

// ###########################################################################################
foreach($query_results as $row)
{
    if($row['REQUEST_SENT'] === 0)
    {
        $student_id = $row['STUDENT_ID'];
        $courses_rpi_used = explode(',', $row['COURSE_RPI_USED']);
        $course_flags = array(
            'CSC242' => 0,
            'CSC315' => 0,
            'CSC382' => 0,
            'CSC435635' => 0,
            'OTHER' => 0
        );
        // Set flag to true if set
        foreach($courses_rpi_used as $course)
        {
            $course = preg_replace('/[^A-Z0-9]+/', '', $course);
            if(isset($course_flags[$course]))
            {
                $course_flags[$course] = 1;
            }
        }

        $stmt_insert->execute([
            $student_id,
            $course_flags['CSC242'],
            $course_flags['CSC315'],
            $course_flags['CSC382'],
            $course_flags['CSC435635'],
            $course_flags['OTHER']
        ]);

        if($stmt_insert->rowCount() > 0)
        {
            echo "Data insertion successful\n";
            $stmt_update->execute([1,$student_id]);
            if($stmt_update->rowCount() > 0)
            {
                echo "Request updated successfully...";
            } else {
                echo "Error updating record: No rows affected...\n";
            }
        }
    }
}

?>
