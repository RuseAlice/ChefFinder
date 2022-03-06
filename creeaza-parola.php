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
        <?php 

                $selector=$_GET["selector"]; 
                $validator=$_GET["validator"];  
               
                if(empty($selector)||empty($validator)){
                    echo "eroare";
                }else{
                    if(ctype_xdigit($selector) ==true && ctype_xdigit($validator)==true){
                        ?>
                        <form action="includes/reset-parola.inc.php" method="POST">
                        <h1 class="title-text">Introdu noua ta parolă!</h1>
                        <ul>
                            <li><input type="hidden" name="selector" value="<?php echo $selector;?>"></li>
                            <li><input type="hidden" name="validator" value="<?php echo $validator;?>"></li>
                            <li><input type="password" name="parola" placeholder="Noua parolă"></li>
                            <li><input type="password" name="parola-repetata" placeholder="Repetă parola"></li>
                            <li><button type="submit" class="btn" name="reset-parola-submit">Resetează parola!</button></li>
                        </ul>
                        </form>
                        <?php
                    }
                }

               
               ?>

        </div>
    </body>

</html>