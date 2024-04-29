/*This script is for IP address validation and submitting to student_prof_processor*/
// VARIABLES
let student_id = "";
let good_id = false;
let good_course = false;
let course_num = "";

ITS_data_bools = {
    stdnt_id : false,
    course_n : false
};

$(document).ready(function(){

    // Get ip requests ################################################################
    $('#fetch_assignments').on('click', function(event){
        $.get('../controller/student_prof_processor.php?action=fetch_assignments', function(response){
            $('#ip_table').find('tr:not(:first)').remove(); // Remove previous rows

            if(response != 0)
            {
                $('#ip_table').append(response);
                $('#server_response').text("");
            }
        });
    });

    // Fetch specific student ip info #################################################
    $('#fetch_student').on('click', function(event){

        good_id = validateStudentID();

        if(good_id)
        {
            $.get('../controller/student_prof_processor.php?action=fetch_student&student_id='+$('#student_id').val(), function(response){
            $('#ip_table').find('tr:not(:first)').remove(); // Remove previous rows

            if(response != 0)
            {
                $('#ip_table').append(response);
                $('#server_response').text("");
            } else {
                $('#server_response').text("No ip assignments for")
            }
        });

        }  
    });

    $('#fetch_courses').on('click', function(event){
        let course_numbers = $('#course_num').val().trim();
        good_course =  validateCourseNum(course_numbers);

        if(good_course)
        {
            $.get('../controller/student_prof_processor.php?action=fetch_by_course&course_num='+course_numbers, function(response){
                $('#ip_table').find('tr:not(:first)').remove();
                $('#ip_table').append(response);
            });

    // Reset page ##################################################
    $('#reset_table').on('click', function(event){
        $('#student_id').val("");
        $('#ip_table').find('tr:not(:first)').remove();
    });

});

function getEID(id)
{
    return document.getElementById(id);
}

// Validate the IP address, only allow integers and .
function validateStudentID()
{
    let STUDENT_REGEX = /^[a-zA-Z]\d{8}$/;

    // Eliminate any whitespace first
    student_id = getEID('student_id').value.trim();
    
    ITS_data_bools.stdnt_id = STUDENT_REGEX.test(student_id);

    if(!ITS_data_bools.stdnt_id)
    {
        alert("Invalid Student ID");
        return false;
    }
    
    if(ITS_data_bools.stdnt_id)
    {
        return true;
    }

}

// Validate Course number
function validateCourseNum(course_number)
{
    let COURSE_REGEX = /^[A-Za-z0-9]{1,6}$/;
    course_number = getEID('course_num').value.trim();

    ITS_data_bools.course_n = COURSE_REGEX.test(course_number);

    if(!ITS_data_bools.course_n)
    {
        alert("Invalid course number, Example: CSC242");
        return false;
    } else {
        return true;
    }

}
