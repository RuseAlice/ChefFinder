<?php 
session_start();
        include_once 'includes/dbh.inc.php';
        if(!isset($_SESSION['email'])){
            header("Location: welcome.php");
            //exit();
        }
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
        <link type="text/css" rel="stylesheet" href="detaliipostare.css">
        <link type="text/css" rel="stylesheet" href="queries-detalii.css">
        
        <!-- <link rel="icon" href="imagini/contur_soseta.png">
        <link rel="stylesheet" href="queries-login.css">
        <link rel="stylesheet" href="queries-general.css"> -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ChefFinder - Browse</title>
        

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

<div class="continut-pagina">

<?php
// session_start();
//require 'includes/dbh.inc.php';
$id=$_GET['idpostare'];
$email=$_SESSION['email'];
$sqlpostari="select p.id as id_postare, email_autor, denumire, descriere, p.poza as poza_postare,
             pret, tip, data, u.id as id_utilizator, nume, tip_utilizator, u.poza as poza_utilizator
             from postare p, utilizator u 
             where p.email_autor=u.email and p.id=?;";
$stmt= mysqli_stmt_init($conn);
//$result=mysqli_query($conn, $sqlpostari);
if(!mysqli_stmt_prepare($stmt, $sqlpostari)){
    header("Location: index.php?error=sqlerror");
    exit();
}else{
    mysqli_stmt_bind_param($stmt, "s",  $id);
    mysqli_stmt_execute($stmt);
    $result=mysqli_stmt_get_result($stmt);
    $resultCheck=mysqli_num_rows($result);
if($resultCheck>0){
    while($row=mysqli_fetch_assoc($result)){
        echo "<div class='postare'>
        <div class='preparat'>
            <img src='pozePostare/".$row['poza_postare']."' class='preparat-img'>
        </div>";
        echo " <p class='denumire'>";
        echo $row['denumire'];
        echo "</p> 
        <div class='autor-post'>
        <div class='postarepic-div'> 
        <img src='pozeProfil/".$row['poza_utilizator']."' alt='poza profil' class='postarepic'>
        </div>
        <p>";
        echo "<form method='POST' action='profil.php'>
        <input type='hidden' name='email' value=";
        echo $row['email_autor'];echo ">
        <input type='hidden' name='tip' value=";
        echo $row['tip_utilizator'];echo ">
        <button type='submit' name='profil-submit' class='btn-autor-postare'>";echo $row['nume']; echo "</button>
        </form>  <p class='data'>";
        echo $row['data'];
        echo"</p>
        </div>
        <p class='pret'>";
        echo $row['pret']." Lei";
        echo "</p>";
        echo " <p class='descriere'>";
        echo $row['descriere'];
        echo "</p>";
       
        if($row['email_autor']==$email){
            echo "<form method='POST' action='includes/stergepostare.inc.php'>
            <input type='hidden' name='idpostare' value=";echo $row['id_postare'];echo ">
            <button type='submit' name='sterge-submit' class='btn-sterge'>Șterge postarea!</button>
            </form>";
        }
        
        // echo "Postat de: ";
        
        echo"<form method='POST' class='adauga-comm' action='includes/comentariu.inc.php'>
        <input type='hidden' name='idpostare' value=";echo $row['id_postare'];echo ">
        <textarea name='comm'></textarea>
        <br>
        <button type='submit' class='btn-adauga-comm'name='comentariu-submit'>Comentează!</button>
        </form>";
        echo "</div>";

    }
}
}

$sqlpostari="select c.id as id_comm, c.id_postare, c.autor, c.continut, c.data, email, nume, tip_utilizator, poza
 from comentariu c, utilizator u
where c.autor=u.email and  
id_postare=? 
order by data desc;";
$stmt= mysqli_stmt_init($conn);
//$result=mysqli_query($conn, $sqlpostari);
if(!mysqli_stmt_prepare($stmt, $sqlpostari)){
    header("Location: index.php?error=sqlerror");
    exit();
}else{
    mysqli_stmt_bind_param($stmt, "s",  $id);
    mysqli_stmt_execute($stmt);
    $result=mysqli_stmt_get_result($stmt);
    $resultCheck=mysqli_num_rows($result);
if($resultCheck>0){
    echo "<div class='comentarii'>";
    while($row=mysqli_fetch_assoc($result)){
        echo 
        "<div class='comentariu'>
        <div class='autor-comm'> 
        <div class='commpic-div'>
            <img src='pozeProfil/".$row['poza']."' alt='poza profil' class='commpic'>
            </div>";
            echo "<form method='POST' action='profil.php' class='form-profil'>
            <input type='hidden' name='email' value=";
            echo $row['email'];echo ">
            <input type='hidden' name='tip' value=";
            echo $row['tip_utilizator'];echo ">
            <button type='submit' name='profil-submit' class='btn-autor-comm'>";echo $row['nume']; echo "</button>
            </form>
         </div>
        <p class='data-comm'>";
        echo $row['data']; 
        echo "</p>";
        if($row['email']==$_SESSION['email']){
            echo "<form  class='sterge-comm' method='POST' action='includes/sterge-comm.inc.php'>
            <input type='hidden' name='idcomentariu' value=";echo $row['id_comm'];echo ">
            <button type='submit' name='submit-sterge-comm' class='btn-sterge'>Șterge!</button>
            </form>";
        }
        echo"<p class='continut'>";
        echo $row['continut']." ";
        echo "</p><br>";
        
        echo "</div> <br> <br>";
        

    }
}

}
echo "</div>";
?>
</div>
</body>
</html>