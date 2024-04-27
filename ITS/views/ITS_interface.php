<!DOCTYPE html>
<!-- INS_student_id is for inserting into database -->
<html>
    <head>
        <title>CSC 635 FINAL PROJECT ROMAN CAMPBELL/BRAD BUSH</title>
        <style>
            <?php require_once('../../css/stylesheet.css');?>
        </style>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>
        <script src="../js/ITS_validate.js" type="text/javascript"></script>
    </head>
    <body>
       <h2>ITS INTERFACE</h2>
       <form id="ip_request_form" action="#" method="post">
            <table border="1">

                <!-- IP ADDRESS --------------------------------------------->
                <th>IP ADDRESS:</th>
                <td><input id="ip_addr_assign" name="ip_addr_assign" class="resp-text" type="text"></td>
                
                <!-- COURSE TO ASSIGN IP ADDR TO ---------------------------->
                <tr>
                    <th>ASSIGN TO COURSE:</th>
                    <td><input id="assign_course" name="assign_course" class="resp-text" type="text"></td>
                </tr>

                <!-- STUDENT_ID TO ASSIGN TO -------------------------------->
                <tr>
                    <th>STUDENT ID:</th>
                    <td><input id="INS_student_id" name="INS_student_id" class="resp-text" type="text"></td>
                </tr>


                
            </table>
        
            <!-- SUBMIT/RESET BUTTONS ----------------------------------------------------------->
            <button class="button lsus-orange btn-height btn-primary-spacing" id="submit_form" type="submit">
                <span style="font-size: 15px; font-weight: bold">SUBMIT REQUEST</span>
            </button>
            
            <!-- MANUAL FETCH REQUEST ------------------------------------------------------------>
            <button class="button lsus-orange btn-height btn-primary-spacing" id="fetch_requests" type="button">
                <span style="font-size: 15px; font-weight: bold">FETCH REQUESTS</span>
            </button>   
            <button class="button lsus-orange btn-height btn-primary-spacing" id="reset_form" type="reset">
                <span style="font-size: 15px; font-weight: bold">RESET</span>
            </button>
        </form>

        <!-- IP REQUESTS  ----------------------------------------------------------->
        <h3>IP REQUESTS</h3>
        <table border="1">
            <!-- STUDENT ID -->
            <th>STUDENT ID:</th>
            <td id="student_id"></td>

            <!-- REQUIRED CLASSES ---------------------------------------------------->
            <th>CSC 242</th>
            <td id="csc242"></td>
            
            <!-- CSC315 -->
            <th>CSC 315</th>
            <td id="csc315"></td>

            <!-- CSC382 -->
            <th>CSC 382</th>
            <td id="csc382"></td>

            <!-- CSC435/635 -->
            <th>CSC 435/635</th>
            <td id="csc435635"></td>
            
            <!-- OTHER -->
            <th>OTHER</th>
            <td id="csc_other"></td>
            
        </table>
        <img src="../img/lsus-logo.png">
    </body>
</html>
