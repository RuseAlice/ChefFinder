<!DOCTYPE html>
<html>
    <head>
        <title>ChefFinder - Intră în cont</title>
        <link type="text/css" rel="stylesheet" href="generalstyle.css">
        <link type="text/css" rel="stylesheet" href="login.css">
        <link type="text/css" rel="stylesheet" href="creeaza.css">
        <link type="text/css" rel="stylesheet" href="queries-creeaza.css">
        <!-- <link rel="icon" href="imagini/contur_soseta.png">
        <link rel="stylesheet" href="queries-login.css">
        <link rel="stylesheet" href="queries-general.css"> -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

    </head>
    <body>  
        <!--  Nav bar etc  -->
        <header>
        <nav>
        <div class="header">
                
                
                
        <div class="title"><a class="home" href="index.php"><h1>ChefFinder</h1></a></div>

                       
            </div>
            </nav>
        </header>
        <div class="centru">
            
            <form class="formular" action="includes/login.inc.php" method="POST">
                <h1 class="title-text">Bine ai revenit!</h1>
                <ul>
                    
                    <li> Email </li>
                    <li><input type="email" class="" name="mail" value="adress@email.com"></li>
                    <li> Parolă </li>
                    <li><input type="password" class="" name="parola"></textarea></li>
                    <li><button type="submit" class="btn" id="btn-login" name="login-submit">Intră în cont!</button>
                     <a href="welcome.php" id="btn-create" class="btn">Nu am cont!</a></li>
                    <li><a id="forgot"href="reset-parola.php">Mi-am uitat parola</a></li>
               </ul>
               <?php
               if(isset($_GET['mail'])){
                   if($_GET['mail']=='unverified'){
                       echo'<p class="note">Eroare: te rugăm să îți validezi emailul!</p>';
                   }
               }
               if(isset($_GET['error'])){
                if($_GET['error']=='wronguser'|| $_GET['error']=='wrongpassword'){
                    echo'<p class="note">Eroare: Nume de utlizator sau parolă incorecte!</p>';
                }else if($_GET['error']=='emptyfields'){
                    echo'<p class="note">Eroare: Completează toate căsuțele!</p>';
                }
            }
            
               
               ?>
            </form>

        </div>
    </body>

</html>