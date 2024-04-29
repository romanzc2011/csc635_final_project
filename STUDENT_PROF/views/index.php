<!DOCTYPE html>
<!-- INS_student_id is for inserting into database -->
<html>
    <head>
        <title>CSC 635 FINAL PROJECT ROMAN CAMPBELL/BRAD BUSH</title>
        <style>
            <?php require_once('../../css/stylesheet.css');?>
        </style>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>
        <script src="../js/STUDENT_PROF_validate.js" type="text/javascript"></script>
    </head>
    <body>
       <label style="float:left;" for="course_num">COURSE:
            <input style="" id="course_num" name="course_num" class="resp-text" type="text">
       </label>
       <br>
       <br>
       <label style="float:left;" for="student_id">STUDENT ID:
            <input id="student_id" name="student_id" class="resp-text" type="text">
       </label>
       <br>
       <br>
       (Search by either Student ID or Course)
       <hr style="margin-top: 5px;">
       <h2>STUDENT IP ASSIGNMENT MASTER LIST</h2>
            
            <!-- ALL FETCH REQUEST ------------------------------------------------------------>
            <button class="button lsus-orange btn-height btn-primary-spacing" id="fetch_assignments" type="button">
                <span style="font-size: 15px; font-weight: bold">FETCH ASSIGNMENTS</span>
            </button>  

            <!-- SINGLE FETCH REQUEST ------------------------------------------------------------>
            <button class="button lsus-orange btn-height btn-primary-spacing" id="fetch_student" type="button">
                <span style="font-size: 15px; font-weight: bold">FETCH STUDENT</span>
            </button>
            
            <button class="button lsus-orange btn-height btn-primary-spacing" id="fetch_courses" type="button">
                <span style="font-size: 15px; font-weight: bold">FETCH BY COURSE</span>
            </button>


            <button class="button lsus-orange btn-height btn-primary-spacing" id="reset_table" type="button">
                <span style="font-size: 15px; font-weight: bold">RESET</span>
            </button>
        <h5>RESPONSE FROM SERVER: <span id="server_response" name="server_response"></span> </h5>

        <!-- IP ASSIGNMENTS  ----------------------------------------------------------->
        <h3>IP ASSIGNMENTS</h3>
        <table border="1" id="ip_table">
            <th>STUDENT ID</th>
            <th>STUDENT NAME</th>
            <th>COURSE</th>
            <th>IP ADDRESS</th>
            <th>RPi WIFI MAC ADDRESS</th>
            <?php require_once(__DIR__.'/../controller/student_prof_processor.php'); ?> 
        </table>
        <img src="../../img/lsus-logo.png">
    </body>
</html>

