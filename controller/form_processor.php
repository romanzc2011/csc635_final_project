<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CSC 635 LAB 7 ROMAN CAMPBELL</title>
        <style>
            <?php require_once($_SERVER['DOCUMENT_ROOT'].'/Lab7/css/stylesheet.css'); ?>
        </style>
    <head>
    <body>
        <div class="container">
            <?php

            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                $first_name = isset($_POST['first_name']) ? strtoupper($_POST['first_name']) : "";
                $last_name = isset($_POST['last_name']) ? strtoupper($_POST['last_name']) : "";
                $student_id = isset($_POST['student_id']) ? strtoupper($_POST['student_id']) : "";
                $email_address = isset($_POST['email_address']) ? $_POST['email_address'] : "";
                $rpi_mac_address = isset($_POST['rpi_mac_address']) ? $_POST['rpi_mac_address'] : "";
                $academic_level = isset($_POST['academic_level']) ? strtoupper($_POST['academic_level']) : "";
                $courses_used = isset($_POST['courses']) ? $_POST['courses'] : [];

                // Print received data
                echo "FIRST NAME: $first_name<br>";
                echo "LAST NAME: $last_name<br>";
                echo "STUDENT ID: $student_id<br>";
                echo "EMAIL ADDRESS: $email_address<br>";
                echo "RPi MAC Address: $rpi_mac_address<br>";
                echo "ACADEMIC LEVEL: $academic_level<br>";

                // Print courses used
                echo "COURSES RPi USED:";
                foreach ($courses_used as $course) {
                    echo "- $course\n";
                }
            }
            ?>
        </div>
     <img src="../img/lsus-logo.png">

    </body>

</html>