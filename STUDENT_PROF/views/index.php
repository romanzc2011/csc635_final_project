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
       <h2>STUDENT IP ASSIGNMENT MASTER LIST</h2>
            
            <!-- MANUAL FETCH REQUEST ------------------------------------------------------------>
            <button class="button lsus-orange btn-height btn-primary-spacing" id="fetch_assignments" type="button">
                <span style="font-size: 15px; font-weight: bold">FETCH ASSIGNMENTS</span>
            </button>  

            <button class="button lsus-orange btn-height btn-primary-spacing" id="reset_form" type="reset">
                <span style="font-size: 15px; font-weight: bold">RESET</span>
            </button>
        </form>
        <h5>RESPONSE FROM SERVER: <span id="server_response" name="server_response"></span> </h5>

        <!-- IP ASSIGNMENTS  ----------------------------------------------------------->
        <h3>IP ASSIGNMENTS</h3>
        <table id="ip_table">
            <!-- STUDENT ID -->
            <th>STUDENT ID:</th>
            <th>CSC 242</th>
            <th>CSC 315</th>
            <th>CSC 382</th>
            <th>CSC 435/635</th>
            <th>OTHER</th>
            <?php require_once('../controller/ITS_processor.php'); ?> 
        </table>
        <img src="../img/lsus-logo.png">
    </body>
</html>

