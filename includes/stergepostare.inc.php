<?php
session_start();
require 'dbh.inc.php';
$idpostare = $_POST['idpostare'];

$sql ="delete from comentariu where id_postare=?;";
$stmt= mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt, $sql)){
    header("Location: ../postare.php?idpostare=$idpostare&error=sqlerror");
    exit();
}else{
mysqli_stmt_bind_param($stmt, "s",$idpostare);
mysqli_stmt_execute($stmt);
$sql ="delete from postare where id=?;";
$stmt= mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt, $sql)){
    header("Location: ../postare.php?idpostare=$idpostare&error=sqlerror");
    exit();
}else{
    mysqli_stmt_bind_param($stmt, "s",$idpostare);
    mysqli_stmt_execute($stmt);
    header("Location: ../profil.php?stergere=success");
    exit();
}
}
mysqli_stmt_close($stmt);
mysqli_close($conn);
