<?php
session_start();
require 'dbh.inc.php';
if(isset($_POST['comentariu-submit'])){

$idpostare = $_POST['idpostare'];
$autor = $_SESSION['email'];
$text = $_POST['comm'];

if(empty($text)){
    header("Location: ../detaliipostare.php?idpostare=".$idpostare."error=emptyfields");
    exit();
}else{
    $sql ="INSERT INTO comentariu (id_postare,autor,continut,data) 
            VALUES (?,?,?,now());";
            $stmt= mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql)){
                header("Location: ../postare.php?idpostare=".$idpostare."&error=sqlerror");
                exit();
            }else{
                mysqli_stmt_bind_param($stmt, "sss",$idpostare, $autor, $text);
                mysqli_stmt_execute($stmt);
                header("Location: ../detaliipostare.php?idpostare=".$idpostare."&comentariu=success");
                exit();
            }
}
mysqli_stmt_close($stmt);
mysqli_close($conn);
}else{
    header("Location: ../detaliipostare.php?idpostare=".$idpostare);
}