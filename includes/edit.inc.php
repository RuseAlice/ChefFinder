<?php
session_start();
if(isset($_POST['submit-edit'])){
    //the user got here legitimately
    require 'dbh.inc.php';
    //luam informatia din formular
    $descriere=$_POST['descriere']; //name e numele din input
    $contact=$_POST['contact'];
    $email=$_SESSION['email'];

    $sql = "update bucatar
    set descriere =?,
    contact=?
    WHERE email=?;";
    $stmt = mysqli_stmt_init($conn);
        
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("Location: ../edit.php?error=sqlerror");
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt, "sss",$descriere, $contact, $email);
            mysqli_stmt_execute($stmt);
            header("Location: ../profil.php");
        }
}else{
    header("Location: ../index.php");
}
    
   