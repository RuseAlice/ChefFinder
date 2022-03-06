<!DOCTYPE html>
<html>
    <head>
        <title>ChefFinder - Creează bucătar </title>
        <link  rel="stylesheet" href="creeaza.css">
        <link  rel="stylesheet" href="queries-creeaza.css">
        <link  rel="stylesheet" href="generalstyle.css">
       
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>  
        <!--  Nav bar etc  -->
        <header>
            <nav>
            <div class="header">
                <!-- <a href="index.php"><img class="logo" src="imagini/logo.jpg" alt="logo"></a> -->
               
                <div class="title"><a class="home" href="index.php"><h1>ChefFinder</h1></a></div>

                       
            </div>
            </nav>
        </header>
        <div class="centru bucatar">
            <h1 class="title-text">Devino bucătar la ChefFinder!</h1>
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
                    <li>Adaugă o descriere</li>
                    <li><textarea name="description" class=""></textarea></li>
                    <li>Date de contact</li>
                    <li><textarea name="contact" class=""></textarea></li>
                    <li>Adaugă o poză de profil</li>
                    <li><input type="file" name="profilepic"></li>
                    <li><input type="hidden" name="tiputilizator" value="bucatar"></li>
                    <li><label>Judet</label></li>
                    <li><select name='judet' id='Judet' class='judet' onchange="FetchJudet(this.value)">
                        <option selected='selected' disabled="">Alege judetul </option>
                        <?php 
                            include_once 'includes/dbh.inc.php';
                            $sql="select * from judet 
                            order by nume;";
                            $result=mysqli_query($conn, $sql);
                            $resultCheck=mysqli_num_rows($result);
                            if($resultCheck>0){
                                while($row=mysqli_fetch_assoc($result)){
                                    echo "<option value='";echo $row['id'];echo"'>";echo $row['nume'];echo"</option>";
                                }
                            }
                        ?>
                    </select></li>
                    <li><label>Oras</label></li>
                    <li><select name='Oras' id='oras'>
                        <option selected='selected' disabled="">Alege orasul </option>
                    </select>
                    </li>

                    </ul>
                    <button type="submit" class="btn" name="create-submit">Creează contul!</button>
                    
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


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="includes/filtrare.inc.js" type="text/javascript"></script>
    </body>

</html>