<?php 
if(isset($_POST['submit-logout'])){
    session_start();
    session_unset();
    session_destroy();
    header("Location: ../welcome.php");
}


?>