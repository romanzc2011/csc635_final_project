/*This script is for IP address validation and submitting to ITS_processor*/
// VARIABLES
let ip_address = "";
let course_to_assign = "";
let student_id = "";

ITS_data_bools = {
    ip_addr : false,
    crs_assign : false,
    stdnt_id : false
};

$(document).ready(function(){
    $('#ip_request_form').on('submit', function(event){
        event.preventDefault();
        validateIPAddr(); // Validate the inputs
        submitIPData(); // Submit if valid inputs
    });
});

function getEID(id)
{
    return document.getElementById(id);
}

// Validate the IP address, only allow integers and .
function validateIPAddr()
{
    let IP_REGEX = /^10\.50\.4\.(?!0$|1$|254$|255$)(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)$/;
    let COURSE_REGEX = /^[A-Za-z0-9]+$/;
    let STUDENT_REGEX = /^[a-zA-Z]\d{8}$/;

    // Eliminate any whitespace first
    ip_address = getEID('ip_addr_assign').value.trim();
    course_to_assign = getEID('assign_course').value.trim().toUpperCase();
    student_id = getEID('INS_student_id').value.trim().toUpperCase();
    
    ITS_data_bools.ip_addr = IP_REGEX.test(ip_address);
    ITS_data_bools.crs_assign = COURSE_REGEX.test(course_to_assign);
    ITS_data_bools.stdnt_id = STUDENT_REGEX.test(student_id);

    if(ITS_data_bools.ip_addr == false)
    {
        alert("IP Address must be in the 10.50.4.0/24 network\nMust be 10.50.4.2-253");
    }

    if(ITS_data_bools.stdnt_id == false)
    {
        alert("Invalid Student ID");
    }

}

function submitIPData()
{
    if(ITS_data_bools.ip_addr && ITS_data_bools.crs_assign && ITS_data_bools.stdnt_id)
    {
        let data = $('#ip_request_form').serialize();

        $.post('../controller/ITS_processor.php',data,function(response){
          console.log(response);
         });
    }
}
