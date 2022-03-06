<!DOCTYPE html>
<html>
    <head>
        <title>ChefFinder - Intră în cont</title>
        <link type="text/css" rel="stylesheet" href="generalstyle.css">
        <link type="text/css" rel="stylesheet" href="login.css">
        <link type="text/css" rel="stylesheet" href="creeaza.css">
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
            
        <h1 class="title-text">Resetează-ți parola!</h1>
                <p id="info">Vei primi un email pentru a-ți crea o nouă parolă.</p>
                <form class="reset-form"action="includes/reset-cerere.inc.php" method="POST">
                <ul>
                    
                    <li> <p>Adresa ta de email</p> </li>
                
                <li><input type="text" name="email"></input></li>
                <li><button type="submit" name="reset-request-submit">Trimite email!</button></li>
                </form>
                <?php
                if(isset($_GET['reset'])){
                    if($_GET['reset']=="successful"){
                        echo"<p>Verifică-ți emailul!</p>";
                    }
                }
                
                ?>

        </div>
    </body>

</html>