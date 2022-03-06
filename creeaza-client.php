<!DOCTYPE html>
<html>
    <head>
        <title>ChefFinder - Creează client </title>
        <link  rel="stylesheet" href="creeaza.css">
        <link  rel="stylesheet" href="generalstyle.css">
        <link rel="icon" href="imagini/contur_soseta.png">
        <link rel="stylesheet" href="queries-creeaza.css">
        <link rel="stylesheet" href="queries-general.css">
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
        <div class="centru client">
            <h1 class="title-text">Creează un cont de client!</h1>
            <form action="includes/creeaza.inc.php" method="POST" enctype="multipart/form-data">
            
                <ul>
                    <li> Nume </li>
                    <li><input type="text" class="" name="name" ></li>
                    <li> Email </li>
                    <li><input type="email" class="" name="email" value="adresa@email.com"></li>
                    <li> Parolă </li>
                    <li><input type="password" class="" name="pwd"></textarea></li>
                    <li> Repetă parola </li>
                    <li><input type="password" class="" name="pwd-repeat"></textarea></li>
                    <li>Alege o poză de profil:</li>
                    <li><input type="file" name="profilepic"></li>
                    <li><input type="hidden" name="tiputilizator" value="client"></li>
                    
                    </ul>
                     <button type="submit" class="btn" name="create-submit">Creează contul!</button>
                    
                   
                
            
            
            <div class="butoane">
               
                <!-- <a href="login.php" class="btn">I already have an account!</a> -->
            </div>
                
                    <?php 
                    if(isset($_GET["error"])){
                        if($_GET["error"]=="emptyfields"){
                            echo"<p class='note'>Eroare: Nu uita să completezi toate căsuțele!</p>";
                        }else if($_GET["error"]=="invalidmail"){
                            echo"<p class='note'>Eroare: Adresa de email nu este validă!</p>";
                        }else if($_GET["error"]=="passwordcheck"){
                            echo"<p class='note'>Eroare: Parolele nu se potrivesc!</p>";
                        }else if($_GET["error"]=="incorrectfiletype"){
                            echo"<p class='note'>Eroare: File type not supported!</p>";
                        }else if($_GET["error"]=="mailtaken"){
                            echo"<p class='note'>Eroare: Această adresă de email este deja asociată unui cont!</p>";
                        }else if($_GET["error"]=="sqlerror"){
                            echo"<p class='note'>Eroare: A apărut o problemă, te rugăm să încerci din nou!</p>";
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