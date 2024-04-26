<form id="student_form" action="./controller/form_processor.php" method="post">

    <table>

        <!-- FIRST NAME --------------------------------------------->
        <th>FIRST NAME:</th>
        <td><input id="first_name" name="first_name" class="resp-text" type="text"></td>

        <!-- LAST NAME ---------------------------------------------->
        <tr>
            <th>LAST NAME:</th>
            <td><input id="last_name" name="last_name" class="resp-text" type="text"></td>
        </tr>

        <!-- STUDENT ID ---------------------------------------------->
        <tr>
            <th>STUDENT ID:</th>
            <td><input id="student_id" name="student_id" class="resp-text" type="text"></td>
        </tr>

        <!-- LSUS EMAIL ADDRESS --------------------------------------->
        <tr>
            <th>LSUS EMAIL ADDRESS:</th>
            <td><input id="email_address" name="email_address" class="resp-text" placeholder="StudentID@lsus.edu" type="text"></td>
        </tr>

        <!-- RPI WIFI MAC ADDRESS -------------------------------------->
        <tr>
            <th>RPi WIFI MAC ADDRESS</th>
            <td><input id="rpi_mac_address" name="rpi_mac_address" class="resp-text" type="text"></td>
        </tr>

        <!-- RPI WIFI MAC ADDRESS -------------------------------------->
        <tr>
            <th>RPi TYPE:</th>
            <td><select id="rpi_type" name="rpi_type" class="resp-text">
                    <option value="rpi_5">RPi 5</option>
                    <option value="rpi_4">RPi 4</option>
                    <option value="rpi_3">RPi 3</option>
                    <option value="rpi_zero_w">RPi Zero W</option>
                    <option value="rpi_zero_2">RPi Zero 2 W</option>
                    <option value="rpi_top">RPi-Top</option>
                </select>
            </td>
        </tr>

        <!-- COURSES USED FOR (CHECKBOXES) ------------------------------------------>
        <tr>
            <th>COURSES RPi USED:</th>
            <td>
                <!-- CSC 242  ------------------------------------------------------->
                <input id="csc_242" type="checkbox" name="courses[]" value="CSC 242">
                <label for="csc_242">CSC 242</label>

                <!-- CSC 315  ----------------------------------------------------------->
                <input id="csc_315" type="checkbox" name="courses[]" value="CSC 315">
                <label for="csc_315">CSC 315</label>

                <!-- CSC 382  ----------------------------------------------------------->
                <input id="csc_382" type="checkbox" name="courses[]" value="CSC 382">
                <label for="csc_382">CSC 382</label>

                <!-- CSC 435/635  ------------------------------------------------------->
                <input id="csc_435_635" type="checkbox" name="courses[]" value="CSC 435/635">
                <label for="csc_435_635">CSC 435/635</label>

                <!-- OTHER  ------------------------------------------------------------->
                <input id="csc_other" type="checkbox" name="courses[]" value="CSC OTHER">
                <label for="csc_other">Other</label>

            </td>
        </tr>

        <!-- ACADEMIC LEVEL ------------------------------------------------------------->
        <tr>
            <th>ACADEMIC LEVEL:</th>
            <td>
                <!-- FRESHMAN  ----------------------------------------------------------->
                <input name="academic_level" id="freshman" type="radio" value="freshman">
                <label for="freshman">FRESHMAN</label>

                <!-- SOPHMORE  ----------------------------------------------------------->
                <input name="academic_level" id="sophmore" type="radio" value="sophmore">
                <label for="sophmore">SOPHMORE</label>

                <!-- JUNIOR  ------------------------------------------------------------->
                <input name="academic_level" id="junior" type="radio" value="junior">
                <label for="junior">JUNIOR</label>

                <!-- SENIOR  ------------------------------------------------------------->
                <input name="academic_level" id="senior" type="radio" value="senior">
                <label for="senior">SENIOR</label>

                <!-- GRADUATE  ----------------------------------------------------------->
                <input name="academic_level" id="graduate" type="radio" value="graduate">
                <label for="graduate">GRADUATE</label>
            </td>
        </tr>
    </table>

    <!-- SUBMIT/RESET BUTTONS ----------------------------------------------------------->
    <button class="button lsus-orange btn-height btn-primary-spacing" id="submit_form" type="submit">
        <span style="font-size: 15px; font-weight: bold">SUBMIT</span>
    </button>

    <button class="button lsus-orange btn-height btn-primary-spacing" id="reset_form" type="reset">
        <span style="font-size: 15px; font-weight: bold">RESET</span>
    </button>
</form>