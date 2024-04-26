// This javascript is to be used for form validation
// VARIABLES
let first_name = "";
let last_name = "";
let student_id = "";
let email_address = "";
let mac_address = "";
let form_data = new FormData();

// Object for student_id, email, and mac boolean values
form_booleans = {
    f_name : false,
    l_name : false,
    s_id : false,
    e_addr : false,
    mac_addr : false
};

// Replacement function for getElementById
function $(id)
{
    return document.getElementById(id);
}

// Validate the first name, last name, student id, email, and mac address
// First test and see which values are present and validate from there
function Validate()
{
    let name_RGEX = /^[a-zA-Z]+$/;
    let student_RGEX = /^[A-Z]\d{8}$/;
    let email_RGEX = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    let mac_RGEX = /^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/;

    // Eliminate any white space
    first_name = $('first_name').value.trim().toUpperCase();
    last_name = $('last_name').value.trim().toUpperCase();
    student_id = $('student_id').value.trim().toUpperCase();
    email_address = $('email_address').value.trim() // MAC addresses are case sensitive, no default toUpperCase;
    mac_address = $('rpi_mac_address').value.trim() // No default toUpperCase;

    // Some short hand if/else present to save space
    // For validate to be successful no false should be present in form_boolean
    // Validate first and last name
    // FIRST NAME ###################################################################################
    if(first_name != "")
    {
        name_RGEX.test(first_name) ? form_booleans.f_name = true : form_booleans.f_name = false;
    } else if(first_name == "")
    {
        form_booleans.f_name = "";
    }

    // LAST NAME ###################################################################################
    if(last_name != "")
    {
        name_RGEX.test(last_name) ? form_booleans.l_name = true : form_booleans.l_name = false;
    } else if(last_name == "")
    {
        form_booleans.l_name = "";
    }
    
    // STUDENT ID ###################################################################################
    // Validate student_id and set T or F
    if(student_id != "")
    {
        student_RGEX.test(student_id) ? form_booleans.s_id = true : form_booleans.s_id = false;
    } else if(student_id == "")
    {
        form_booleans.s_id = "";
    }

    // EMAIL ADDRESS ###################################################################################
    // Validate email_address and set T or F
    if(email_address != "")
    {
        email_RGEX.test(email_address) ? form_booleans.e_addr = true : form_booleans.e_addr = false;
    } else if(email_address == "")
    {
        form_booleans.e_addr = "";
    }

    // MAC ADDRESS ###################################################################################
    // Validate mac_address and set T or F if blank then assign empty string
    if(mac_address != "")
    {
        mac_RGEX.test(mac_address) ? form_booleans.mac_addr = true : form_booleans.mac_addr = false;
    } else if(mac_address == "")
    {
        form_booleans.mac_addr = "";
    }
    return form_booleans;
}

function Submit_Form()
{
    // Validate first
    let form_valid = Validate();

    // If no F in form_valid then send data to php script for processing via AJAX
    if((form_valid.f_name != false) && (form_valid.l_name != false) && (form_valid.s_id != false)
        && (form_valid.e_addr != false) && (form_valid.mac_addr != false))
    {
        form_data.append('first_name', first_name);
        form_data.append('last_name', last_name);
        form_data.append('student_id', student_id);
        form_data.append('email_address', email_address);
        form_data.append('mac_address', mac_address);
        Get_Academic_Val();
        Get_Courses_Used();

        // ######################################################################
        // Create AJAX to send data to form_processor.php
        // ######################################################################
        $('#submit_form').on('submit', function(event){
            event.preventDefault();
            let details = $('#student_form').serializeArray();
            $.post('./controller/form_processor.php', details, function(data){
                $('#form_data').html(data);
            });
        });
        
    } else {

        // Go thru all values in form_valid and determine the issue
        let alert_msg = "";

        // FIRST NAME ALERT
        if (!form_valid.f_name)
        {
            alert_msg += "Check first name, only string characters are allowed\n";
        } 
        
        // LAST NAME ALERT
        if (!form_valid.l_name)
        {
            alert_msg += "Check last name, only string characters are allowed\n";
        }

        // STUDENT ID ALERT
        if (!form_valid.s_id)
        {
            alert_msg += "Check student ID\n";
        }

        // EMAIL ADDR ALERT
        if (!form_valid.e_addr)
        {
            alert_msg += "Check email address format\n";
        }

        // MAC ADDR ALERT 
        if (!form_valid.mac_addr)
        {
            alert_msg += "Check MAC address format\n";
        } 
        alert(alert_msg);
    }

    // Get radio button value
    function Get_Academic_Val()
    {
        let academic_radio = document.getElementsByName('academic_level');

        // Loop through all academic radio buttons and find the checked value, add to form_data
        for(let i=0; i < academic_radio.length; i++)
        {
            if(academic_radio[i].checked)
            {
                form_data.append('academic_lvl', academic_radio[i].value);
                break;
            }
        }
    }

    function Get_Courses_Used() {
        let course_boxes = document.querySelectorAll('input[name="courses[]"]:checked');
        
        // Loop through checked checkboxes and append their values
        course_boxes.forEach(function(checkbox) {
            form_data.append('courses_used[]', checkbox.value);
        });
    }

}
