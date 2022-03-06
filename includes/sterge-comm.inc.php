<?php
session_start();
require 'dbh.inc.php';
if(isset($_POST['submit-sterge-comm'])){


$idcomentariu = $_POST['idcomentariu'];

    $sql ="delete from comentariu where id=?;";
            $stmt= mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql)){
                header("Location: ../profil.php?idcomentariu=$idcomentariu&error=sqlerror");
                exit();
            }else{
                mysqli_stmt_bind_param($stmt, "s",$idcomentariu);
                mysqli_stmt_execute($stmt);
                header("Location: ../profil.php?stergere=success");
                exit();
            }

}
else{
    header("Location: ../index.php");
    exit();
}