<?php
if(isset($_POST['login-submit'])){
    require 'dbh.inc.php';

    $mail = $_POST['mail'];
    $password = $_POST['parola'];
    
    if(empty($mail) || empty($password)){
        header("Location: ../login.php?error=emptyfields");
        exit();
    }
    else{
        $sql = "SELECT * FROM utilizator WHERE email=?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("Location: ../login.php?error=sqlerror");
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt,"s", $mail);
            mysqli_stmt_execute($stmt);
            $result=mysqli_stmt_get_result($stmt);
            if($row=mysqli_fetch_assoc($result)){
                $pwdCheck = password_verify($password, $row['parola']);
                if($pwdCheck == false){
                    header("Location: ../login.php?error=wrongpassword");
                    exit();
                }else if($pwdCheck == true){
                   // if($row['verificat']==1){
                        session_start();
                    $_SESSION['email']=$row['email'];
                    $_SESSION['tip']=$row['tip_utilizator'];
                    
                    
                    header("Location: ../index.php?login=success");
                    exit();
                    // }else{
                    //     header("Location: ../login.php?mail=unverified");
                    // exit();
                    // }
                    
                }
                else{
                    header("Location: ../login.php?error=wronguser");
                    exit();
                }
            }
            else{
                header("Location: ../login.php?error=wronguser");
                exit();
            }


        }
    }

}
else{
    header("Location: ../login.php");
     exit();
}




?>