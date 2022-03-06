<?php
session_start();
require 'dbh.inc.php';
if(isset($_POST['posteaza-submit'])){
    //the user got here legitimately
    require 'dbh.inc.php';
    //luam informatia din formular
    $denumire=$_POST['denumire']; //name e numele din input
    $descriere=$_POST['descriere'];
    $pret=$_POST['pret'];
    $tip = $_POST['tip'];
    $file = $_FILES['poza'];
    $fileName = $_FILES['poza']['name'];
    $fileTmpName = $_FILES['poza']['tmp_name'];
    $fileSize = $_FILES['poza']['size'];
    $fileError = $_FILES['poza']['error'];
    $fileType = $_FILES['poza']['type'];

   //first name of file, second part extension
    $Extensie = strtolower(end( explode('.', $fileName)));//end= ultima parte dintr-un array
    $extensiiPermise = array('jpg', 'jpeg','png');
    //check for errors
    if(empty($denumire) || empty($descriere) || empty($pret) || ($fileSize==0 && $fileError==0)){
           header("Location: ../postare.php?error=emptyfields"); 
        
        exit();
        //nu mai merge mai departe cu codul care urmeaza daca a facut o greseala utilizatorul
    }
   
    else if($pret < 0){
        
            header("Location: ../postare.php?error=pretnegativ");
        exit();
    }
    else if(!in_array($Extensie, $extensiiPermise)){
        header("Location: ../postare.php?error=incorrectfiletype");
        exit();
    }else if($fileSize>10000000){//10MB
        header("Location: ../postare.php?error=filetoobig");
        exit();

    }else if($fileError==1){
        header("Location: ../postare.php?error=uploaderror");
        exit();

    }else{

            $sql ="INSERT INTO postare (email_autor, denumire,descriere,poza,pret,tip,data) 
            VALUES (?,?,?,?,?,?, now());";
            $stmt= mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql)){
                header("Location: ../postare.php?error=sqlerror");
                exit();
            }else{
                    // $sqlpost = "SELECT * FROM utilizator WHERE email=?;";
                    // $stmtpost = mysqli_stmt_init($conn);
                    // mysqli_stmt_prepare($stmtpost, $sqlpost);
                    // mysqli_stmt_bind_param($stmtpost,"s", $email);
                    // mysqli_stmt_execute($stmtpost);
                    // $result=mysqli_stmt_get_result($stmtpost);
                    // $row=mysqli_fetch_assoc($result);
                   
                           

                    $denumirePoza =uniqid('',true).".".$Extensie;
                    $fileDestinatie = '../pozePostare/'.$denumirePoza;
                    move_uploaded_file($fileTmpName, $fileDestinatie);

                    $autor= $_SESSION['email'];
                    mysqli_stmt_bind_param($stmt, "ssssss", $autor, $denumire ,$descriere,$denumirePoza, $pret, $tip);
                    mysqli_stmt_execute($stmt);

                    header("Location: ../profil.php?postare=success");//index
                    exit();
                    
                }

            
        }

        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    
    

}
else{
    header("Location: ../index.php");
     exit();
}
?>