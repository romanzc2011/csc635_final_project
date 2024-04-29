<?php

require_once(__DIR__.'/../../controller/raspberrypi_mysql_connection.php');

global $MYSQL_CONN;

$course_number = "";
$server_request = "";
$student_id = "";

function checkStudentID($student_id)
{
    global $MYSQL_CONN;

    try {
        $MYSQL_CONN->beginTransaction();

        // Check for existing STUDENT ID
        $sql = "SELECT STUDENT_ID FROM STUDENT WHERE STUDENT_ID = ?";

        $stmt = $MYSQL_CONN->prepare($sql);
        $stmt->execute([$student_id]);

        if($stmt->rowCount() > 0)
        {
            $MYSQL_CONN->commit();
            return TRUE;
        } else {
            return FALSE;
        }
    } catch(PDOException $e) {
        echo "Error: ".$e->getMessage().'\n';
    }
}

function checkCourseNum($course)
{
    // Grab all column names except STUDENT_ID to start course check
    global $MYSQL_CONN;

    $sql = "SELECT COLUMN_NAME
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_SCHEMA = 'CSC635_FINAL_PROJECT'
            AND TABLE_NAME = 'IP_REQUESTS'
            AND ORDINAL_POSITION > 1";
    
    try {

    $MYSQL_CONN->beginTransaction();
    
    $stmt = $MYSQL_CONN->prepare($sql);
    $stmt->execute();
    $course_array = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $i = 0;
    // Get rid of all underscores
    foreach($course_array as $k => $v)
    {
        $course_array[$k]['COLUMN_NAME'] = str_ireplace('_', '', $course['COLUMN_NAME']);
    }

    } catch(PDOException $e) {
        echo "Error: ".$e->getMessage()."\n";
    }

    return $course_array;
}

// Retrieve IP assignents
if($_SERVER['REQUEST_METHOD'] == 'GET')
{
    isset($_GET['action']) ? $server_request = $_GET['action'] : $server_request;
    isset($_GET['student_id']) ? $student_id = strtoupper($_GET['student_id']) : $student_id;
    isset($_GET['course_num']) ? $course_number = strtoupper($_GET['course_num']) : $course_number;

    switch($server_request)
    {
        case 'fetch_assignments':
            try {
            $sql = "SELECT AIP.STUDENT_ID, CONCAT(S.FIRST_NAME,' ',S.LAST_NAME) STUDENT_NAME, AIP.COURSE, AIP.IP_ADDRESS, S.RPI_WIFI_MAC_ADDR
                    FROM AVAILABLE_IP_ADDR AIP
                    INNER JOIN STUDENT S ON S.STUDENT_ID = AIP.STUDENT_ID";

            $stmt = $MYSQL_CONN->prepare($sql);
            $stmt->execute();

            while($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                echo '<tr>';
                echo '<td>'.$row['STUDENT_ID'].'</td>';
                echo '<td>'.$row['STUDENT_NAME'].'</td>';
                echo '<td>'.$row['COURSE'].'</td>';
                echo '<td>'.$row['IP_ADDRESS'].'</td>';
                echo '<td>'.$row['RPI_WIFI_MAC_ADDR'].'</td>';
                echo '</tr>';
            }

            
            } catch(PDOException $e) {
                echo "Error: ".$e->getMessage();
            }
            break;

        case 'fetch_student':
            $retrieve_records = checkStudentID($student_id);
            $sql = "SELECT AIP.STUDENT_ID, CONCAT(S.FIRST_NAME,' ',S.LAST_NAME) STUDENT_NAME, AIP.COURSE, AIP.IP_ADDRESS, S.RPI_WIFI_MAC_ADDR
                    FROM AVAILABLE_IP_ADDR AIP
                    INNER JOIN STUDENT S ON S.STUDENT_ID = AIP.STUDENT_ID
                    WHERE S.STUDENT_ID = ?";
            
            if($retrieve_records)
            {
                $stmt = $MYSQL_CONN->prepare($sql);
                $stmt->execute([$student_id]);

                while($row = $stmt->fetch(PDO::FETCH_ASSOC))
                {
                    echo '<tr>';
                    echo '<td>'.$row['STUDENT_ID'].'</td>';
                    echo '<td>'.$row['STUDENT_NAME'].'</td>';
                    echo '<td>'.$row['COURSE'].'</td>';
                    echo '<td>'.$row['IP_ADDRESS'].'</td>';
                    echo '<td>'.$row['RPI_WIFI_MAC_ADDR'].'</td>';
                    echo '</tr>';
                }
            } else {
                echo "Student ID not found";
            }
            break;

        case 'fetch_by_course':
            
            $courses = checkCourseNum($course_number);
            print_r($courses);
            break;
    }
}
?>
