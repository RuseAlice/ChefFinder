<?php
if(isset($_POST['reset-parola-submit'])){

    $selector=$_POST["selector"];
    $validator=$_POST["validator"];
    $parola=$_POST["parola"];
    $parolaRepetata=$_POST["parola-repetata"];

    if(empty($parola)||empty($parolaRepetata)){
        header("Location: ../creeaza-parola.php?password=empty");
        exit();
    }else if($parolaRepetata != $parola){
            header("Location: ../creeaza-parola.php?password=notmatched");
            exit();
    
    }
    $currentDate=date("U");

    require"dbh.inc.php";

    $sql="SELECT * FROM resetare_parola WHERE selector=? AND data_expirare>=?;";
    $stmt=mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../reset-parola.php?error");
        exit();
    }else{
        $hashedToken=password_hash($token, PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt, 'ss', $selector,$currentDate);
        mysqli_stmt_execute($stmt);

        $result=mysqli_stmt_get_result($stmt);
        if(!$row=mysqli_fetch_assoc($result)){
            header("Location: ../reset-parola.php?error=timpexpirat");
            //echo "Timpul a expirat";
            exit();
        }else{
            $tokenBin=hex2bin($validator);
            $tokenCheck = password_verify($tokenBin, $row['token']);
            if($tokenCheck==false){
                //eroare
                exit();
            }else if($tokenCheck===true){
                $tokenEmail=$row['email_reset'];
                $sql="SELECT * FROM utilizator WHERE email=?;";
                $stmt=mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt, $sql)){
                    header("Location: ../reset-parola.php?error=sqlemail");
                    exit();
                }else{
                    
                    mysqli_stmt_bind_param($stmt, 's', $tokenEmail);
                    mysqli_stmt_execute($stmt);
                    $result=mysqli_stmt_get_result($stmt);
                    if(!$row=mysqli_fetch_assoc($result)){
                        header("Location: ../reset-parola.php?error=sqlnouser");
                        exit();
                    }else{
                        $sql="UPDATE utilizator SET parola=? WHERE email=?;";
                        $stmt=mysqli_stmt_init($conn);
                        if(!mysqli_stmt_prepare($stmt, $sql)){
                            header("Location: ../reset-parola.php?error=sqlupdate");
                            exit();
                        }else{
                            $hashedPassword=password_hash($parola, PASSWORD_DEFAULT);
                            mysqli_stmt_bind_param($stmt, 'ss', $hashedPassword,$tokenEmail );
                            mysqli_stmt_execute($stmt);

                            $sql="DELETE FROM resetare_parola WHERE email_reset=?;";
                            $stmt=mysqli_stmt_init($conn);
                            if(!mysqli_stmt_prepare($stmt, $sql)){
                                header("Location: ../reset-parola.php?error=sqldeletetoken");

                                exit();
                            }else{
                                mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                                mysqli_stmt_execute($stmt);
                                header("Location: ../login.php?newpass=updated");
                            }

                        }
                    }
                }


            }
        }
    }

}else{
    header("Location: ../login.php");
    exit();
}






?>