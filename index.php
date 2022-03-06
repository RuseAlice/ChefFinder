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
    $poza=$row['poza'];
}
?>
<!DOCTYPE html>
<html>
<head>
<link type="text/css" rel="stylesheet" href="generalstyle.css">
        <link type="text/css" rel="stylesheet" href="index.css">
        <link type="text/css" rel="stylesheet" href="queries-index.css">
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

<!-- FILTRE -->

<div class="filtre">

<p class="titlu-filtre">Aplică filtre!</p>
<form action="includes/filtrare.inc.php" method="POST">
<ul id="cauta-nume"> 
       <li><p>Caută un preparat după nume</p></li>
       <li> <input name="cuvant-cheie" type="text"></li>
</ul>
<ul id="locatie">
        <li><label>Județ</label></li>
        <li><select name='judet' id='Judet' class='judet' onchange="FetchJudet(this.value)">
        <option selected='selected' disabled="">Alege județul </option>
        <?php 
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
    </select>
    </li>
    <li><label>Oraș</label></li>
    <li> <select name='Oras' id='oras'>
        <option selected='selected' disabled="">Alege orașul </option>
        
    </select>
    </li>
    </ul>
    <ul id="filtre-butoane">
    <li><button type="submit" name ="submit-toate" class="btn-filtru">Toate</button></li>
    <li><button type="submit" name ="submit-aperitiv" class="btn-filtru">Aperitiv/Gustare</button></li>
    <li><button type="submit" name ="submit-felprincipal" class="btn-filtru">Fel principal</button></li>
    <li><button type="submit" name ="submit-desert" class="btn-filtru">Desert</button></li>
    <li><button type="submit" name ="submit-altele" class="btn-filtru">Altele</button></li>
</ul>
</form>

</div>

<!-- AFISARE CONTINUT -->


<div class="continut">
    <?php
 if(isset($_GET["filter"]) && isset($_GET["id_j"]) && isset($_GET["id_o"])){
    $tipMancare=$_GET["filter"];
    $judet=$_GET["id_j"];
    $oras=$_GET["id_o"];
    $stmt= mysqli_stmt_init($conn);
    if($tipMancare=="toate"){
        //bucatarii prefrati
        $sql="select p.id, email_autor, denumire, p.descriere descriere_prep, poza, pret, tip,data,b.id_judet, id_localitate, l.nume as localitate, j.nume as judet  
        from postare p, bucatar b, localitate l, judet j 
        where p.email_autor = b.email 
        and p.email_autor != ?
        and l.id=b.id_localitate and j.id=b.id_judet
        and b.id_judet = ?
        and b.id_localitate = ?
        and lower(denumire) like '%".$_GET['denumire']."%'
        and p.email_autor in (select id_bucatar from favorit where id_utilizator=?)
        order by data desc;";
        mysqli_stmt_prepare($stmt, $sql);

        mysqli_stmt_bind_param($stmt, "ssss",$_SESSION['email'], $judet, $oras, $_SESSION['email']);
        mysqli_stmt_execute($stmt);
        $result=mysqli_stmt_get_result($stmt);
        $resultCheck=mysqli_num_rows($result);
        if($resultCheck>0){
            while($row=mysqli_fetch_assoc($result)){
                echo "<div class='preparat'>
                
                <div class='img-prep'>
                    <img src='pozePostare/";echo $row['poza']; echo"' alt='preparat' class='imagine-preparat'>
                </div>
                <div class='info'>
                <p class='denumire'>";
                echo $row['denumire'];
                echo "</p>
                <p class='locatie'>".$row['localitate'].", ".$row['judet'];
                echo "</p><p class='pret'>";
                echo $row['pret'];
                echo " Lei</p>";
                // echo "<br>";
                echo
                "<form class='detalii' method='GET' action='detaliipostare.php'>
                <input type='hidden' name='idpostare' value=";echo $row['id']; echo ">
                <button type='submit' name='detalii-submit' class='btn-detalii'>Detalii</button>
                </form>";
                
                echo "</div></div>";
            }
            
        }


        //restul bucatarilor
        $sql="select p.id, email_autor, denumire, p.descriere descriere_prep, poza, pret, tip,data,b.id_judet, id_localitate, l.nume as localitate, j.nume as judet  
        from postare p, bucatar b, localitate l, judet j 
        where p.email_autor = b.email 
        and p.email_autor != ?
        and l.id=b.id_localitate and j.id=b.id_judet
        and b.id_judet = ?
        and b.id_localitate = ?
        and lower(denumire) like '%".$_GET['denumire']."%'
        and p.email_autor not in (select id_bucatar from favorit where id_utilizator=?)
        order by data desc;";
        mysqli_stmt_prepare($stmt, $sql);

        mysqli_stmt_bind_param($stmt, "ssss",$_SESSION['email'], $judet, $oras, $_SESSION['email']);
        mysqli_stmt_execute($stmt);
        $result=mysqli_stmt_get_result($stmt);
        $resultCheck=mysqli_num_rows($result);
        if($resultCheck>0){
            while($row=mysqli_fetch_assoc($result)){
                echo "<div class='preparat'>
                
                <div class='img-prep'>
                    <img src='pozePostare/";echo $row['poza']; echo"' alt='preparat' class='imagine-preparat'>
                </div>
                <div class='info'>
                <p class='denumire'>";
                echo $row['denumire'];
                echo "</p>
                <p class='locatie'>".$row['localitate'].", ".$row['judet'];
                echo "</p><p class='pret'>";
                echo $row['pret'];
                echo " Lei</p>";
                // echo "<br>";
                echo
                "<form class='detalii' method='GET' action='detaliipostare.php'>
                <input type='hidden' name='idpostare' value=";echo $row['id']; echo ">
                <button type='submit' name='detalii-submit' class='btn-detalii'>Detalii</button>
                </form>";
                
                echo "</div></div>";
            }
            
        }


    }else{
        //bucatarii preferati
        $sql="select p.id,email_autor, denumire, p.descriere descriere_prep, poza, pret, tip,data,b.id_judet, id_localitate, l.nume as localitate, j.nume as judet  
        from postare p, bucatar b, localitate l, judet j 
        where p.email_autor = b.email 
        and p.email_autor != ?
        and l.id=b.id_localitate and j.id=b.id_judet
        and tip = ?
        and b.id_judet = ?
        and b.id_localitate = ?
        and lower(denumire) like '%".$_GET['denumire']."%'
        and p.email_autor in (select id_bucatar from favorit where id_utilizator=?)
        order by data desc;";

        mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_bind_param($stmt, "sssss",$_SESSION['email'],  $tipMancare, $judet, $oras, $_SESSION['email']);
        mysqli_stmt_execute($stmt);
        $result=mysqli_stmt_get_result($stmt);
        $resultCheck=mysqli_num_rows($result);
        if($resultCheck>0){
            while($row=mysqli_fetch_assoc($result)){
                echo "<div class='preparat'>
                
                <div class='img-prep'>
                    <img src='pozePostare/";echo $row['poza']; echo"' alt='preparat' class='imagine-preparat'>
                </div>
                <div class='info'>
                <p class='denumire'>";
                echo $row['denumire'];
                echo "</p>
                <p class='locatie'>".$row['localitate'].", ".$row['judet'];
                echo "</p><p class='pret'>";
                echo $row['pret'];
                echo " Lei</p>";
                // echo "<br>";
                echo
                "<form class='detalii' method='GET' action='detaliipostare.php'>
                <input type='hidden' name='idpostare' value=";echo $row['id']; echo ">
                <button type='submit' name='detalii-submit' class='btn-detalii'>Detalii</button>
                </form>";
                
                echo "</div></div>";
            }
            
        }

        //restul bucatarilor
        $sql="select p.id,email_autor, denumire, p.descriere descriere_prep, poza, pret, tip,data,b.id_judet, id_localitate, l.nume as localitate, j.nume as judet  
        from postare p, bucatar b, localitate l, judet j 
        where p.email_autor = b.email 
        and p.email_autor != ?
        and l.id=b.id_localitate and j.id=b.id_judet
        and tip = ?
        and b.id_judet = ?
        and b.id_localitate = ?
        and lower(denumire) like '%".$_GET['denumire']."%'
        and p.email_autor not in (select id_bucatar from favorit where id_utilizator=?)
        order by data desc;";

        mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_bind_param($stmt, "sssss", $_SESSION['email'], $tipMancare, $judet, $oras, $_SESSION['email']);
        mysqli_stmt_execute($stmt);
        $result=mysqli_stmt_get_result($stmt);
        $resultCheck=mysqli_num_rows($result);
        if($resultCheck>0){
            while($row=mysqli_fetch_assoc($result)){
                echo "<div class='preparat'>
                
                <div class='img-prep'>
                    <img src='pozePostare/";echo $row['poza']; echo"' alt='preparat' class='imagine-preparat'>
                </div>
                <div class='info'>
                <p class='denumire'>";
                echo $row['denumire'];
                echo "</p>
                <p class='locatie'>".$row['localitate'].", ".$row['judet'];
                echo "</p><p class='pret'>";
                echo $row['pret'];
                echo " Lei</p>";
                // echo "<br>";
                echo
                "<form class='detalii' method='GET' action='detaliipostare.php'>
                <input type='hidden' name='idpostare' value=";echo $row['id']; echo ">
                <button type='submit' name='detalii-submit' class='btn-detalii'>Detalii</button>
                </form>";
                
                echo "</div></div>";
            }
            
        }
    }
        

    
}else{
        //bucatarii preferati
        $sql="select p.id,email_autor, denumire, p.descriere descriere_prep, poza, pret, tip,data,b.id_judet, id_localitate, l.nume as localitate, j.nume as judet  
        from postare p, bucatar b, localitate l, judet j 
        where p.email_autor = b.email 
        and p.email_autor != ?
        and l.id=b.id_localitate and j.id=b.id_judet
        and p.email_autor in (select id_bucatar from favorit where id_utilizator=?)
        order by data desc;";
        mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_bind_param($stmt, "ss",$_SESSION['email'], $_SESSION['email']);
        mysqli_stmt_execute($stmt);
        $result=mysqli_stmt_get_result($stmt);
        $resultCheck=mysqli_num_rows($result);
        if($resultCheck>0){
            while($row=mysqli_fetch_assoc($result)){
                echo "<div class='preparat'>
                <div class='img-prep'>
                    <img src='pozePostare/";echo $row['poza']; echo"' alt='preparat' class='imagine-preparat'>
                </div>
                <div class='info'>
                <p class='denumire'>";
                echo $row['denumire'];
                echo"<p class='locatie'>".$row['localitate'].", ".$row['judet'];
                echo "</p><p class='pret'>";
                echo $row['pret'];
                echo " Lei</p>";
                // echo "<br>";
                echo
                "<form class='detalii' method='GET' action='detaliipostare.php'>
                <input type='hidden' name='idpostare' value=";echo $row['id']; echo ">
                <button type='submit' name='detalii-submit' class='btn-detalii'>Detalii</button>
                </form>
                </div>";
                
                echo "</div>";

            }
        }


        //restul bucatarilor

        $sql="select p.id,email_autor, denumire, p.descriere descriere_prep, poza, pret, tip,data,b.id_judet, id_localitate, l.nume as localitate, j.nume as judet  
        from postare p, bucatar b, localitate l, judet j 
        where p.email_autor = b.email 
        and p.email_autor != ?
        and l.id=b.id_localitate and j.id=b.id_judet
        and p.email_autor  not in (select id_bucatar from favorit where id_utilizator=?)
        order by data desc;";
        mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_bind_param($stmt, "ss",$_SESSION['email'], $_SESSION['email']);
        mysqli_stmt_execute($stmt);
        $result=mysqli_stmt_get_result($stmt);
        $resultCheck=mysqli_num_rows($result);
        if($resultCheck>0){
            while($row=mysqli_fetch_assoc($result)){
                echo "<div class='preparat'>
                <div class='img-prep'>
                    <img src='pozePostare/";echo $row['poza']; echo"' alt='preparat' class='imagine-preparat'>
                </div>
                <div class='info'>
                <p class='denumire'>";
                echo $row['denumire'];
                echo"<p class='locatie'>".$row['localitate'].", ".$row['judet'];
                echo "</p><p class='pret'>";
                echo $row['pret'];
                echo " Lei</p>";
                // echo "<br>";
                echo
                "<form class='detalii' method='GET' action='detaliipostare.php'>
                <input type='hidden' name='idpostare' value=";echo $row['id']; echo ">
                <button type='submit' name='detalii-submit' class='btn-detalii'>Detalii</button>
                </form>
                </div>";
                
                echo "</div>";

            }
        }

    }
    ?>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="includes/filtrare.inc.js" type="text/javascript"></script>
</body>
</html>