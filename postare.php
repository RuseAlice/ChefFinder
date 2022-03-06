<?php 
session_start();
        include_once 'includes/dbh.inc.php';
        if(!isset($_SESSION['email']) || $_SESSION['tip']=="client"){
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
        <link type="text/css" rel="stylesheet" href="postare.css">
        <link type="text/css" rel="stylesheet" href="creeaza.css">
        
        <!-- <link rel="icon" href="imagini/contur_soseta.png">
        <link rel="stylesheet" href="queries-login.css">
        <link rel="stylesheet" href="queries-general.css"> -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ChefFinder - Postează</title>
        

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
        <div class="centru">
            <h1 class="title-text">Adaugă o nouă postare!</h1>
            <form action="includes/posteaza.inc.php" method="POST" enctype="multipart/form-data">
            
                <ul>
                    <li> Denumire preparat</li>
                    <li><input type="text" class="" name="denumire" ></li>
                    <li>Descriere</li>
                    <li><textarea name="descriere" class=""></textarea></li>
                    <li>Preț</li>
                    <li><input type="number" step="0.1" name="pret" class=""></li>
                    <li>Poza produsului:</li>
                    <li><input type="file" name="poza"></li>
                    
                    <li><select name="tip">
                        <option value="aperitiv">Aperitiv/Gustare</option>
                        <option value="felprincipal">Fel principal</option>
                        <option value="desert">Desert</option>
                        <option value="altele">Altele</option>
                    </select>
                    </li>
                    
                    </ul>
                    <button type="submit" class="btn" name="posteaza-submit">Postează!</button>
                    <a href="index.php" class="btn">Renunță!</a>
            
                    <?php 
                    if(isset($_GET["error"])){
                        if($_GET["error"]=="emptyfields"){
                            echo"<p class='note'>Eroare: Completează toate căsuțele!</p>";
                        }else if($_GET["error"]=="pretnegativ"){
                            echo"<p class='note'>Eroare: Nu poți alege un preț negativ!</p>";
                        }else if($_GET["error"]=="incorrectfiletype"){
                            echo"<p class='note'>Eroare: Poti alege doar poze de tipul .jpg, .jpeg și .png!</p>";
                        }else if($_GET["error"]=="filetoobig"){
                            echo"<p class='note'>Eroare: Fișierul ales de tine are o dimensiune prea mare!</p>";
                        }else if($_GET["error"]=="uloaderror"){
                            echo"<p class='note'>Eroare: A apărut o eroare la încărcarea fișierului!</p>";
                        }else{
                            echo"<p class='note'>Eroare: Ceva nu a mers bine, te rugăm să încerci din nou!</p>";
                        }
                    }
                    
                    
                    ?>
                    
               
            </form>
            
           

        </div>


        <!-- <script src="creeaza.js"></script> -->
    </body>

</html>