<?php

  

  if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response']))
  {
        $secret = '6LftdswpAAAAAF7LEtzPj7whBiwnBpZHCFIWhuFy';
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
        $responseData = json_decode($verifyResponse);
        if($responseData->success)
        {
            echo 'Your contact request have submitted successfully.';
        }
        else
        {
            echo 'Robot verification failed, please try again.';
        }
   }


?>
