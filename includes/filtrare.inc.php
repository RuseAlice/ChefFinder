<?php

if(isset($_POST['submit-aperitiv'])){
    $id_j=$_POST['judet'];
    $id_o=$_POST['Oras'];
    $denumire=strtolower($_POST['cuvant-cheie']);
    header("Location: ../index.php?filter=aperitiv&id_j=".$id_j."&id_o=".$id_o."&denumire=".$denumire);
}else if(isset($_POST['submit-felprincipal'])){
    $id_j=$_POST['judet'];
    $id_o=$_POST['Oras'];
    $denumire=strtolower($_POST['cuvant-cheie']);
    header("Location: ../index.php?filter=felprincipal&id_j=".$id_j."&id_o=".$id_o."&denumire=".$denumire);
}else if(isset($_POST['submit-desert'])){
    $id_j=$_POST['judet'];
    $id_o=$_POST['Oras'];
    $denumire=strtolower($_POST['cuvant-cheie']);
    header("Location: ../index.php?filter=desert&id_j=".$id_j."&id_o=".$id_o."&denumire=".$denumire);
}else if(isset($_POST['submit-altele'])){
    $id_j=$_POST['judet'];
    $id_o=$_POST['Oras'];
    $denumire=strtolower($_POST['cuvant-cheie']);
    header("Location: ../index.php?filter=altele&id_j=".$id_j."&id_o=".$id_o."&denumire=".$denumire);
}else if(isset($_POST['submit-toate'])){
    $id_j=$_POST['judet'];
    $id_o=$_POST['Oras'];
    $denumire=strtolower($_POST['cuvant-cheie']);
    header("Location: ../index.php?filter=toate&id_j=".$id_j."&id_o=".$id_o."&denumire=".$denumire);
}