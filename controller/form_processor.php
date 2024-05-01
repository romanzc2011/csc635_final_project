<?php require_once('./raspberrypi_mysql_connection.php'); ?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CSC 635 FINAL PROJECT ROMAN CAMPBELL/BRAD BUSH</title>
        <style>
            <?php require_once(__DIR__.'/../css/stylesheet.css'); ?>
        </style>
    </head>
    <body>
        <div class="container">
<?php

            global $MYSQL_CONN;

            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                $first_name = isset($_POST['first_name']) ? strtoupper($_POST['first_name']) : "";
                $last_name = isset($_POST['last_name']) ? strtoupper($_POST['last_name']) : "";
                $student_id = isset($_POST['student_id']) ? strtoupper($_POST['student_id']) : "";
                $email_address = isset($_POST['email_address']) ? $_POST['email_address'] : "";
                $rpi_mac_address = isset($_POST['rpi_mac_address']) ? $_POST['rpi_mac_address'] : "";
                $rpi_type = isset($_POST['rpi_type']) ? strtoupper($_POST['rpi_type']) : "";
                $academic_level = isset($_POST['academic_level']) ? strtoupper($_POST['academic_level']) : "";
                $courses_used = isset($_POST['courses']) ? $_POST['courses'] : [];
                
                // Insert data into STUDENT TABLE
                $sql = "INSERT INTO STUDENT (STUDENT_ID,FIRST_NAME,LAST_NAME,STUDENT_EMAIL,RPI_WIFI_MAC_ADDR,RPI_TYPE,                          COURSE_RPI_USED,ACADEMIC_LEVEL)
                        VALUES
                        (?,?,?,?,?,?,?,?)";

                // Prepare sql stmt and bind values to params
                $MYSQL_CONN->beginTransaction();

                $stmt = $MYSQL_CONN->prepare($sql);
                $stmt->bindParam(1, $student_id, PDO::PARAM_STR);
                $stmt->bindParam(2, $first_name, PDO::PARAM_STR);
                $stmt->bindParam(3, $last_name, PDO::PARAM_STR);
                $stmt->bindParam(4, $email_address, PDO::PARAM_STR);
                $stmt->bindParam(5, $rpi_mac_address, PDO::PARAM_STR);
                $stmt->bindParam(6, $rpi_type);

                // convert to string 
                $course_rpi_used = implode(', ', $courses_used);
                $stmt->bindParam(7, $course_rpi_used, PDO::PARAM_STR);

                $stmt->bindParam(8, $academic_level, PDO::PARAM_STR);

                // Execute and commit
                if($stmt->execute())
                {
                    $MYSQL_CONN->commit();
                    print("Data insertion complete...");
                } else {
                    "Data insert error...";
                }
            }
            ?>
        </div>
     <img src="../img/lsus-logo.png">

    </body>

</html>
