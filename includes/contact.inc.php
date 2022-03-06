<?php
session_start();
if(isset($_POST['submit-contact'])){

    require'dbh.inc.php';
    $email_b=$_POST['email_b'];
    $email=$_SESSION['email'];
    $sqlnume="select * from utilizator
            where email= ?;";
            $stmt= mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sqlnume)){
                header("Location: index.php?error=sqlerror");
                exit();
            }else{
                mysqli_stmt_bind_param($stmt, "s",  $email);
                mysqli_stmt_execute($stmt);
                $result=mysqli_stmt_get_result($stmt);
                $resultCheck=mysqli_num_rows($result);
                
        if($resultCheck>0){
                $row=mysqli_fetch_assoc($result);
                $nume= $row['nume'];
                $id=$row['id'];
                if(empty($_POST['continut'])){
                    $_POST['email_b']=$email_b;
                    header("Location: ../contact.php?id=".$id."&error=mesajgol");
                    exit();
                }else if(empty($_POST['subiect'])){
                    $_POST['email_b']=$email_b;
                    header("Location: ../contact.php?id=".$id."&error=subiectgol");
                    exit();
                }
                $destinatar=$email_b;
                $subiect='ChefFinder: mesaj nou - '.$_POST['subiect'];
                $mesaj = '<p>'.$_POST['continut'].'</p>';
                $mesaj .='<br><p>Acest mesaj a fost trimis de '.$nume.'  ('.$email.')</p>';

                $headers="From: ChefFinder <support@cheffinder.site>\r\n";
                $headers .="Reply-To: ".$email."\r\n";
                $headers .="Content-type: text/html\r\n";

                mail($destinatar, $subiect, $mesaj, $headers);

                //confirmare trimitere mesaj
                $sqlnume="select * from utilizator
                where email= ?;";
                $stmt= mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt, $sqlnume)){
                    header("Location: index.php?error=sqlerror");
                    exit();
                }else{
                    mysqli_stmt_bind_param($stmt, "s",  $email_b);
                    mysqli_stmt_execute($stmt);
                    $result=mysqli_stmt_get_result($stmt);
                    $resultCheck=mysqli_num_rows($result);
                    
                    if($resultCheck>0){
                        $row=mysqli_fetch_assoc($result);
                        $nume= $row['nume'];
                    
        
                    
                        $subiect='ChefFinder: confirmare trimitere mesaj - '.$_POST['subiect'];
                        $mesaj = '<p>Acest mesaj a fost trimis către '.$nume.'</p>';
                        $mesaj .='<br><p>„'.$_POST['continut'].'”</p>';

                        $headers="From: ChefFinder <support@cheffinder.site>\r\n";
                        $headers .="Reply-To: <support@cheffinder.site>\r\n";
                        $headers .="Content-type: text/html\r\n";

                        mail($email, $subiect, $mesaj, $headers);

                        $sqlmail="select * from utilizator
                        where email= ?;";
                        $stmt= mysqli_stmt_init($conn);
                        mysqli_stmt_prepare($stmt, $sqlmail);
                        mysqli_stmt_bind_param($stmt, "s",  $email_b);
                        mysqli_stmt_execute($stmt);
                        $result=mysqli_stmt_get_result($stmt);
                        $row=mysqli_fetch_assoc($result);
                        
                        $id= $row['id'];
                        header("Location: ../profil.php?id=".$id."&contact=successful");
                    }else{
                        header("Location: ../index.php?error=noresultsql");
                        exit();
                    }
                }
            }
        }
}else{
    header("Location: ../index.php");
    exit();
}





?>