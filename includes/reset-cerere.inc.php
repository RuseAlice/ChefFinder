<?php
if(isset($_POST['reset-request-submit'])){

    $selector=bin2hex(random_bytes(8));
    $token=random_bytes(32);

    $url="cheffinder.site/creeaza-parola.php?selector=".$selector."&validator=".bin2hex($token);
    $expires=date("U") + 600;

    require'dbh.inc.php';
    $email=$_POST['email'];

    $sql="DELETE FROM resetare_parola where email_reset=?;";
    $stmt=mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../reset-parola.php?error");
        exit();
    }else{
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);

    }
    $sql="INSERT INTO  resetare_parola (email_reset, selector, token, data_expirare) values (?,?,?,?);";
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../reset-parola.php?error");
        exit();
    }else{
        $hashedToken=password_hash($token, PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt, 'ssss', $email, $selector, $hashedToken, $expires);
        mysqli_stmt_execute($stmt);

    }
    mysqli_stmt_close($stmt);
    $destinatar=$email;
    $subiect='Resetează-ți parola pentru ChefFinder';
    $message = '<p>Accesează linkul următor pentru a crea o nouă parolă.</p>';
    $message .='<p>Acesta este linkul: <br>';
    $message .='<a href="'.$url.'">'.$url.'</a></p>';

    $headers="From: ChefFinder <support@cheffinder.ro>\r\n";
    $headers .="Reply-To: support@cheffinder.ro\r\n";
    $headers .="Content-type: text/html\r\n";

    mail($destinatar, $subiect, $message, $headers);
    header("Location: ../login.php?reset=successful");
}else{
    header("Location: ../login.php");
    exit();
}





?>