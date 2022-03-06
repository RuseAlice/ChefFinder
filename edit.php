<?php
session_start();
require 'includes/dbh.inc.php';
if(!isset($_SESSION['email'])|| $_SESSION['tip']=="client"){// || $_SESSION['tip']=="client"){
    header("Location: welcome.php");
    //exit();
}
$email=$_SESSION['email'];
$sqlnume="select * from utilizator
where email= ?;";
$stmt= mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt, $sqlnume)){
    header("Location: index.php?error=sqlerror");
    exit();
}else{
    mysqli_stmt_bind_param($stmt, "s",  $_SESSION['email']);
    mysqli_stmt_execute($stmt);
    $result=mysqli_stmt_get_result($stmt);
    $resultCheck=mysqli_num_rows($result);
    $row=mysqli_fetch_assoc($result);
    $nume= $row['nume'];
    $poza= $row['poza'];
}
?>
<!DOCTYPE html>
<html>
<head>
<link type="text/css" rel="stylesheet" href="generalstyle.css">
        <!-- <link type="text/css" rel="stylesheet" href="index.css"> -->
        <link type="text/css" rel="stylesheet" href="creeaza.css">
        <link type="text/css" rel="stylesheet" href="queries-creeaza.css">
        <link type="text/css" rel="stylesheet" href="edit.css">
        
        <!-- <link rel="icon" href="imagini/contur_soseta.png">
        <link rel="stylesheet" href="queries-login.css">
        <link rel="stylesheet" href="queries-general.css"> -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ChefFinder - Editează profil</title>
        

</head>
<body>
<header>
        <nav>
        <div class="header">
                <!-- <a href="index.php"><img class="logo" src="imagini/logo.jpg" alt="logo"></a> -->
                
                
                <div class="title"><a class="home" href="index.php"><h1>ChefFinder</h1></a></div>

                            <div class="dropdown">
                            <a href="profil.php"><p class="nume"><?php echo $nume ?></p><div class='poza-profil'><img class="profilepic" src= <?php echo"pozeProfil/".$poza;?> alt="profilepic"></div></a>
                            </div>
        
                        </div>
            </div>
            </nav>
        </header>


<?php
$sqlpostari="select descriere, contact from  bucatar 
where email= ?;";
$stmt= mysqli_stmt_init($conn);
//$result=mysqli_query($conn, $sqlpostari);
if(!mysqli_stmt_prepare($stmt, $sqlpostari)){
    header("Location: index.php?error=sqlerror");
    exit();
}else{
    mysqli_stmt_bind_param($stmt, "s",  $email);
    mysqli_stmt_execute($stmt);
    $result=mysqli_stmt_get_result($stmt);
    $resultCheck=mysqli_num_rows($result);
    if($resultCheck>0){
        $row=mysqli_fetch_assoc($result);
    echo"<div class='centru'> 
    <h1 class='title-text'>Actualizează-ți datele!</h1>
    <form method='POST' action='includes/edit.inc.php' class='form-edit'>
    <ul>
    <li>Descriere</li>
    <li><textarea name='descriere'>";echo $row['descriere']; echo"</textarea></li>
    <li>Date de contact</li>
    <li><textarea name='contact'>";echo $row['contact']; echo "</textarea></li>
    </ul>
    <button type='submit' name='submit-edit'>Actualizează!</button>
    </form>
    <a href='updatepoza.php'>Schimbă-ți poza de profil!</a>
    </div>";
    }
    

    if(isset($_GET["error"])){
        if($_GET["error"]=="emptyfields"){
            echo"<p class='note'>Eroare: Completează toate căsuțele!</p>";
        }else{
            echo"<p class='note'>Eroare: Ceva nu a mers bine, te rugăm să încerci din nou!</p>";
        }
    }
    
}
?>
</body>
</html>
