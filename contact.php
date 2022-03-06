<?php
session_start();
require 'includes/dbh.inc.php';
if(!isset($_SESSION['email']) ){
    header("Location: welcome.php");
    //exit();
}
else if(!isset($_POST['submit-contact']) && !isset($_GET['id'])){
    header("Location: index.php");
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
        
        <!-- 
        <link rel="stylesheet" href="queries-login.css">
        <link rel="stylesheet" href="queries-general.css"> -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ChefFinder - Contactează</title>
        

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
if(isset($_POST['submit-contact'])){
    $email_b=$_POST['email_b'];
}else{
    $sqlmail="select * from utilizator
    where id= ?;";
    $stmt= mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sqlmail);
    mysqli_stmt_bind_param($stmt, "s",  $_GET['id']);
    mysqli_stmt_execute($stmt);
    $result=mysqli_stmt_get_result($stmt);
    $resultCheck=mysqli_num_rows($result);
    $row=mysqli_fetch_assoc($result);
    $email_b= $row['email'];

}
    
$sqlpostari="select nume from  bucatar b, utilizator u
where b.email=u.email and 
b.email= ?;";
$stmt= mysqli_stmt_init($conn);
//$result=mysqli_query($conn, $sqlpostari);
if(!mysqli_stmt_prepare($stmt, $sqlpostari)){
    header("Location: index.php?error=sqlerror");
    exit();
}else{
    mysqli_stmt_bind_param($stmt, "s",  $email_b);
    mysqli_stmt_execute($stmt);
    $result=mysqli_stmt_get_result($stmt);
    $resultCheck=mysqli_num_rows($result);
    
    $row=mysqli_fetch_assoc($result);
    echo"<div class='centru'> 
    <h1 class='title-text'>Scrie un mesaj pentru ".$row['nume']."!</h1>
    <form method='POST' action='includes/contact.inc.php' class='form-edit'>
    <input type='hidden' value='".$email_b."' name='email_b'>
    <ul>
    <li>Subiectul mesajului</li>
    <li><input name='subiect'></li>
    <li>Conținutul mesajului</li>
    <li><textarea name='continut'></textarea></li>
    </ul>
    <button type='submit' name='submit-contact'>Trimite mesajul!</button>
    ";
    
    

    if(isset($_GET["error"])){
        if($_GET["error"]=="mesajgol"){
            echo"<p class='note'>Eroare: Nu poți să trimiți un mesaj gol!</p>";
        }else if($_GET["error"]=="subiectgol"){
            echo"<p class='note'>Eroare: Nu poți să trimiți un mesaj fără subiect!</p>";
        }
        else{
            echo"<p class='note'>Eroare: Ceva nu a mers bine, te rugăm să încerci din nou!</p>";
        }
    }
   echo" </form>
        </div>";
    
}
?>
</body>
</html>
