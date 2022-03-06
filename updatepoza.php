<!DOCTYPE html>
<html>
    <head>
        <title>ChefFinder - Actualizare poză </title>
        <link  rel="stylesheet" href="updatepoza.css">
        <link  rel="stylesheet" href="queries-updatepoza.css">
        <link  rel="stylesheet" href="creeaza.css">
        <link  rel="stylesheet" href="generalstyle.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>  
        <!--  Nav bar etc  -->
        <header>
            <nav>
            <div class="header">
                <!-- <a href="index.php"><img class="logo" src="imagini/logo.png" alt="logo"></a> -->
               
                
                <div class="title"><a class="home" href="index.php"><h1>ChefFinder</h1></a></div>

                        
            </div>
            </nav>
        </header>
        <div class="centru">
            <h1 class="title-text">Încarcă o nouă poză pentru profilul tău!</h1>
            <form action="includes/updatepoza.inc.php" method="POST" enctype="multipart/form-data">
            
                <ul>
            
                    <li>Alege o poză:</li>
                    <li><input type="file" name="profilepic"></li>
                    </ul>
                     <button type="submit" class="btn" name="update-poza-submit">Adaugă!</button>
                    <p class="note">Sunt acceptate fișierele de tip .jpg, .jpeg și .png!</p>
                   
                
                    <?php 
                    if(isset($_GET["error"])){
                        if($_GET["error"]=="incorrectfiletype"){
                            echo"<p class='note'>Eroare: Tipul fișierului încărcat este incorect!</p>";
                        }else if($_GET["error"]=="filetoobig"){
                            echo"<p class='note'>Eroare: Fișierul ales de tine are o dimensiune prea mare!</p>";
                        }else{
                            echo"<p class='note'>Eroare:A apărut o problemă, te rugăm să încerci din nou!</p>";
                        }
                    }
                    
                    
                    ?>
                    
               
            </form>
            
           

        </div>


        <script src="creaza.js"></script>
    </body>

</html>