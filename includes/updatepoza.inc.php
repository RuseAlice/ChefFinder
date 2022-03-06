<?php
session_start();
if(isset($_POST['update-poza-submit'])){
    
    require 'dbh.inc.php';
    $email=$_SESSION['email'];
    $file = $_FILES['profilepic'];
    $fileName = $_FILES['profilepic']['name'];
    $fileTempName = $_FILES['profilepic']['tmp_name'];
    $fileSize = $_FILES['profilepic']['size'];
    $fileError = $_FILES['profilepic']['error'];
    $fileType = $_FILES['profilepic']['type'];

    
    $Extensie = strtolower(end(explode('.', $fileName)));//end= ultima parte dintr-un array
    $extensiiPermise = array("jpg", "jpeg","png");
    if(!in_array($Extensie, $extensiiPermise)){
        header("Location: ../updatepoza.php?error=incorrectfiletype");
    }else if($fileError==1||$fileSize > 5000000){//5MB    
        header("Location: ../updatepoza.php?error=filetoobig");
    }else{
          $fileNameNew = uniqid('',true).".".$Extensie;
    
    $fileDestinatie = '../pozeProfil/'.$fileNameNew;
    move_uploaded_file($fileTempName, $fileDestinatie);

    $sqlpoza = "UPDATE utilizator SET poza=? WHERE email=?;";
    $stmtpoza = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmtpoza, $sqlpoza);
    mysqli_stmt_bind_param($stmtpoza,"ss",$fileNameNew, $email);
    if(!mysqli_stmt_execute($stmtpoza)){
        header("Location: ../updatepoza.php?error=sqlerror");
    }
    else{
        header("Location: ../profil.php?updatepoza=success".$Extensie);
    }
    }

  
}else{
    header("Location: ../profil.php");
}