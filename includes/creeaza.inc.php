<?php

if(isset($_POST['create-submit'])){
    //the user got here legitimately
    require 'dbh.inc.php';
    //luam informatia din formular
    $name=$_POST['name']; //name e numele din input
    $email=$_POST['email'];
    $password=$_POST['pwd'];
    $passwordRepeat=$_POST['pwd-repeat'];
    $tipUtilizator=$_POST['tiputilizator'];
    if($tipUtilizator=="bucatar"){
        $description=$_POST['description']; 
        $contact=$_POST['contact'];
        $judet=$_POST['judet'];
        $oras=$_POST['Oras'];
    }
   
    
    $file = $_FILES['profilepic'];
    $fileName = $_FILES['profilepic']['name'];
    $fileTempName = $_FILES['profilepic']['tmp_name'];
    $fileSize = $_FILES['profilepic']['size'];
    $fileError = $_FILES['profilepic']['error'];
    $fileType = $_FILES['profilepic']['type'];

    
    $Extensie = strtolower(end(explode('.', $fileName)));//end= ultima parte dintr-un array
    $extensiiPermise = array('jpg', 'jpeg','png');
    //check for errors
    if(empty($name) || empty($email) || empty($password) || empty($passwordRepeat)|| ( $tipUtilizator=="bucatar" && (empty($contact)|| $judet=="" || $oras==""))){
        if($tipUtilizator=="client"){
           header("Location: ../creeaza-client.php?error=emptyfields&mail=".$email); 
        }else if($tipUtilizator=="bucatar"){
            header("Location: ../creeaza-bucatar.php?error=emptyfields&mail=".$email); 
        }
        exit();
        //nu mai merge mai departe cu codul care urmeaza daca a facut o greseala utilizatorul
    }
    else if(!filter_var($email, FILTER_VALIDATE_EMAIL) ){
        if($tipUtilizator=="client"){
            header("Location: ../creeaza-client.php?error=invalidmailuid");
        }else if($tipUtilizator=="bucatar"){
            header("Location: ../creeaza-bucatar.php?error=invalidmailuid");
        }
        exit();
    }
   
    else if($password !== $passwordRepeat){
        if($tipUtilizator=="client"){
            header("Location: ../creeaza-client.php?error=passwordcheck&uid=".$username."&mail=".$email);
        }else if($tipUtilizator=="bucatar"){
            header("Location: ../creeaza-bucatar.php?error=passwordcheck&uid=".$username."&mail=".$email);
        }
        exit();
    }
    
    else{
        
        $sql = "SELECT email FROM utilizator WHERE email=?;";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("Location: ../creeaza-client.php?error=sqlerror");
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);//run the information inside the database
            //check if we get a match inside the database

            mysqli_stmt_store_result($stmt);
            $resultCheck=mysqli_stmt_num_rows($stmt);
            if($resultCheck>0){
                if($tipUtilizator=="client"){
                    header("Location: ../creeaza-client.php?error=mailtaken");
                }else if($tipUtilizator=="bucatar"){
                    header("Location: ../creeaza-bucatar.php?error=mailtaken");
                }
                exit();
            }else{
                
                $sql ="INSERT INTO utilizator (email, parola, nume, tip_utilizator) 
                VALUES (?,?,?,?);";
                

               
                $stmt= mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt, $sql)){
                    if($tipUtilizator=="client"){
                        header("Location: ../creeaza-client.php?error=sqlerror");
                    }else if($tipUtilizator=="bucatar"){
                        header("Location: ../creeaza-bucatar.php?error=sqlerror");
                    }
                    exit();
                }else{
                   
                    
                    $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
                    
                    mysqli_stmt_bind_param($stmt, "ssss",  $email ,$hashedPwd, $name, $tipUtilizator);
                    mysqli_stmt_execute($stmt);


                    if($tipUtilizator=="bucatar"){
                        $sql ="INSERT INTO bucatar (email, descriere, contact,id_judet, id_localitate ) 
                        VALUES (?,?,?,?,?);";
                        $stmt= mysqli_stmt_init($conn);
                        if(!mysqli_stmt_prepare($stmt, $sql)){
                            header("Location: ../creeaza-bucatar.php?error=sqlerror");
                            exit();
                        }
                        else{
        
                            mysqli_stmt_bind_param($stmt, "sssss",  $email ,$description, $contact, $judet, $oras);
                            mysqli_stmt_execute($stmt);
        
                            // $sqllogin = "SELECT * FROM utilizator WHERE email=?;";
                            // $stmtlogin = mysqli_stmt_init($conn);
                            // mysqli_stmt_prepare($stmtlogin, $sqllogin);
                            // mysqli_stmt_bind_param($stmtlogin,"s", $email);
                            // mysqli_stmt_execute($stmtlogin);
                            // $result=mysqli_stmt_get_result($stmtlogin);
                            // $row=mysqli_fetch_assoc($result);
                        }

                    }

                     session_start();
                        $_SESSION['email']=$email;//$row['email'];
                        $_SESSION['tip']=$tipUtilizator;//$row['tip_utilizator'];
                       
                    if(!in_array($Extensie, $extensiiPermise)){
       
                            if($tipUtilizator=="client"){
                                header("Location: ../updatepoza.php?error=incorrectfiletype");
                            }else if($tipUtilizator=="bucatar"){
                                header("Location: ../updatepoza.php?error=incorrectfiletype");
                            }
                            exit();
                    }else if($fileError==1||$fileSize > 5000000){//5MB
                       
                        header("Location: ../updatepoza.php?error=filetoobig");
                        exit();     
                    }else{
                        $fileNameNew = uniqid('',true).".".$Extensie;
                        //$fileNameNew = "profile".$row['id_utilizator'].".jpg";
                        $fileDestinatie = '../pozeProfil/'.$fileNameNew;
                        move_uploaded_file($fileTempName, $fileDestinatie);

                        $sqlpoza = "UPDATE utilizator SET poza=? WHERE email=?;";
                        $stmtpoza = mysqli_stmt_init($conn);
                        mysqli_stmt_prepare($stmtpoza, $sqlpoza);
                        mysqli_stmt_bind_param($stmtpoza,"ss",$fileNameNew, $email);
                        mysqli_stmt_execute($stmtpoza);
                        // session_start();
                        // $_SESSION['email']=$email;//$row['email'];
                        // $_SESSION['tip']=$tipUtilizator;//$row['tip_utilizator'];
                        header("Location: ../index.php?signup=success");
                        exit();
                                            
                    }


                    
                }

            }
        }

        // mysqli_stmt_close($stmt);
        // mysqli_close($conn);
    }
    

}
else{
    header("Location: ../signup.php");
     exit();
}
?>