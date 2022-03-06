

<?php
session_start();
require 'includes/dbh.inc.php';
if(!isset($_SESSION['email'])){
    header("Location: welcome.php");
}
if(isset($_GET['stergere'])){
    $email=$_SESSION['email'];
    $tip = $_SESSION['tip'];
}else if(isset($_POST['profil-submit'])){
     $email=$_POST['email'];
     $tip=$_POST['tip'];
}else if(isset($_GET['id'])){
    $sqlmail="select * from utilizator
    where id= ?;";
    $stmt= mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sqlmail);
    mysqli_stmt_bind_param($stmt, "s",  $_GET['id']);
    mysqli_stmt_execute($stmt);
    $result=mysqli_stmt_get_result($stmt);
    $resultCheck=mysqli_num_rows($result);
    $row=mysqli_fetch_assoc($result);

    $email= $row['email'];
    $tip=$row['tip_utilizator'];
    
}
else{// if($_SESSION['tip']=='bucatar'){
    $email=$_SESSION['email'];
    $tip = $_SESSION['tip'];
}
// else{
//     header("Location: index.php");
// }

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
        <link type="text/css" rel="stylesheet" href="index.css">
        <link type="text/css" rel="stylesheet" href="profil.css">
        <link type="text/css" rel="stylesheet" href="queries-profil.css">
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ChefFinder - Profil</title>
        

</head>
<body>
<header>
        <nav>
        <div class="header">
                
                
                
                <div class="title"><a class="home" href="index.php"><h1>ChefFinder</h1></a></div>

                            <div class="dropdown">
                            <a href="profil.php"><p class="nume"><?php echo $nume ?></p><div class='poza-profil'><img class="profilepic" src= <?php echo"pozeProfil/".$poza;?> alt="profilepic"></div></a>
                            </div>
        
                        </div>
            </div>
            </nav>
        </header>


<?php

if($tip=="bucatar"){

    $sqlpostari="select * from utilizator u, bucatar b
    where u.email=b.email 
    and u.email= ?;";
    $stmt= mysqli_stmt_init($conn);
    //$result=mysqli_query($conn, $sqlpostari);
    if(!mysqli_stmt_prepare($stmt, $sqlpostari)){
        header("Location: index.php?error=sqlerror");
        exit();
    }else{
        mysqli_stmt_bind_param($stmt, "s",  $email);
        mysqli_stmt_execute($stmt);
        $result=mysqli_stmt_get_result($stmt);
        // $resultCheck=mysqli_num_rows($result);
        $row=mysqli_fetch_assoc($result);
        echo"<div class='profil'> ";
        if($email==$_SESSION['email']){
            echo "<form class='logout' method='POST' action='includes/logout.inc.php'>
            <button type='submit' name='submit-logout' class='logout-btn'>Delogare</button>
            </form>
            <form class='edit' method='POST' action='edit.php'>
            <button type='submit' name='submit-edit' class='edit-btn'>Modifică!</button>
            </form>
            <a  href='postare.php'>
            <button class='postare-btn'>Adaugă o postare!</button>
            </a>";
        }else{
            echo "<form class='logout' method='POST' action='contact.php'>
            <input type='hidden' value='".$email."' name='email_b'>
            <button type='submit' name='submit-contact' class='contact-btn'>Contactează!</button>
            </form>";
            $email_u=$_SESSION['email'];
            $sql = "select * from favorit where id_utilizator=? and id_bucatar=?;";
            mysqli_stmt_prepare($stmt, $sql);
            mysqli_stmt_bind_param($stmt, "ss",$email_u,  $email);
            mysqli_stmt_execute($stmt);
            $res=mysqli_stmt_get_result($stmt);
            $resultCheck=mysqli_num_rows($res);

            if($_SESSION['tip']=="client"){

           
                if($resultCheck==0){
                    echo" <form class='fav-btn-dr' method='POST' action='includes/favorit.inc.php'>
                    <input type='hidden' value='".$email."' name='email_b'>
                    <button type='submit' name='submit-adauga' class='contact-btn fav'>Adaugă favorit!</button>
                    </form>";
                }else if($resultCheck>0){
                    echo"<form class='fav-btn-dr' method='POST' action='includes/favorit.inc.php'>
                    <input type='hidden' value='".$email."' name='email_b'>
                    <button type='submit' name='submit-elimina' class='contact-btn fav'>Elimină favorit!</button>
                    </form>";
                } 
            }
           
            

        }
        
        echo"<br><br><br><h1 class='nume-bucatar'>";
        echo $row['nume'];
        
        echo "</h1>
        <div class='pozaprofil-div'>
        <img class='pozaprofil' src='pozeProfil/".$row['poza']."' alt='profil'>
        </div>
        <p class='descriere'>";
        echo $row['descriere'];
        echo "</p> 
        <div class ='contact'>
        <p class='titlu-contact'>Date de contact</p>
        <p>";
        echo $row['contact'];
        echo "</p>
        </div>
        </div>";
        
    }
    echo "<div class='postari'>";

       $sqlpostari= "select p.id,email_autor, denumire, p.descriere descriere_prep, poza, pret, tip,data,b.id_judet, id_localitate, l.nume as localitate, j.nume as judet  
        from postare p, bucatar b, localitate l, judet j 
        where p.email_autor = b.email and l.id=b.id_localitate and j.id=b.id_judet
        and email_autor= ?
        order by data desc;";
    $stmt= mysqli_stmt_init($conn);
    //$result=mysqli_query($conn, $sqlpostari);
    if(!mysqli_stmt_prepare($stmt, $sqlpostari)){
        header("Location: index.php?error=sqlerror");
        exit();
    }else{
        mysqli_stmt_bind_param($stmt, "s",  $email);
        mysqli_stmt_execute($stmt);
        $result=mysqli_stmt_get_result($stmt);
        $resultCheck=mysqli_num_rows($result);
        if($resultCheck>0){
            while($row=mysqli_fetch_assoc($result)){
                echo "<div class='preparat'>
                    <div class='img-prep'>
                    <img src='pozePostare/";echo $row['poza']; echo"' alt='preparat' class='imagine-preparat'>
                    </div>
                    <p class='denumire'>";
                    echo $row['denumire'];
                    echo"</p>
                    <p class='locatie'>".$row['localitate'].", ".$row['judet'];
                    echo "</p>
                    <p class='pret'>";
                    echo $row['pret'];
                    echo " Lei</p>";
                    // echo "<br>";
                    echo
                    "<form class='detalii' method='GET' action='detaliipostare.php'>
                    <input type='hidden' name='idpostare' value=";echo $row['id']; echo ">
                    <button type='submit' name='detalii-submit' class='btn-detalii'>Detalii</button>
                    </form>";
                    
                    echo "</div>";

            }
        }
    }
}else{
    //tip client
    $sqlpostari="select * from utilizator
    where email= ?;";
    $stmt= mysqli_stmt_init($conn);
    //$result=mysqli_query($conn, $sqlpostari);
    if(!mysqli_stmt_prepare($stmt, $sqlpostari)){
        header("Location: index.php?error=sqlerror");
        exit();
    }else{
        mysqli_stmt_bind_param($stmt, "s",  $email);
        mysqli_stmt_execute($stmt);
        $result=mysqli_stmt_get_result($stmt);
        $resultCheck=mysqli_num_rows($result);
        $row=mysqli_fetch_assoc($result);
        echo"<div class='profil'> ";
        if($email==$_SESSION['email']){
            echo "<form class='logout' method='POST' action='includes/logout.inc.php'>
            <button type='submit' name='submit-logout' class='logout-btn'>Delogare</button>
            </form>
            <form class='edit' method='POST' action='updatepoza.php'>
            <button type='submit' name='submit-edit' class='edit-btn'>Schimbă poza!</button>
            </form>";
        }
        
        echo"<br><br><br><h1 class='nume-bucatar'>";
        echo $row['nume'];
        echo "</h1>
        <div class='pozaprofil-div'>
        <img class='pozaprofil' src='pozeProfil/".$row['poza']."' alt='profil'>
        </div>";
        
        
    }
    echo "<div class='activitate'>";
//favoriti

$sqlpostari="select *   
                from utilizator u, favorit f
                where email= id_bucatar 
                and id_utilizator= ?;";
    $stmt= mysqli_stmt_init($conn);
    //$result=mysqli_query($conn, $sqlpostari);
    if(!mysqli_stmt_prepare($stmt, $sqlpostari)){
        header("Location: index.php?error=sqlerror");
        exit();
    }else{
        mysqli_stmt_bind_param($stmt, "s",  $email);
        mysqli_stmt_execute($stmt);
        $result=mysqli_stmt_get_result($stmt);
        $resultCheck=mysqli_num_rows($result);
        if($resultCheck>0){
            echo "<div class='favoriti'>
            <p class='titlu-fav'>Bucătarii mei favoriți</p>";
            while($row=mysqli_fetch_assoc($result)){
                echo 
                "<div class='favorit'>
                <div class='autor-comm'> 
                <div class='div-favpic'>
                    <img src='pozeProfil/".$row['poza']."' alt='poza profil' class='favpic'>
                </div>";
                    echo "<form method='POST' action='profil.php' class='profil-fav'>
                    <input type='hidden' name='email' value=";
                    echo $row['email'];echo ">
                    <input type='hidden' name='tip' value='bucatar'>
                    <button type='submit' name='profil-submit' class='btn-autor-comm'>";echo $row['nume']; echo "</button>
                    </form>

                </div>";
                if($email==$_SESSION['email']){
                    echo "<form class='elimina-fav' method='POST' action='includes/favorit.inc.php'>
                    <input type='hidden' name='email_b' value=";echo $row['id_bucatar'];echo ">
                    <button type='submit' name='submit-elimina-lista' class='fav-btn'>Elimină!</button>
                    </form>";
                }
                echo "</div>";
            }
            echo "</div>";
        }
    }

//comentarii
    $sqlpostari="select u.email, u.nume, u.poza, u.tip_utilizator, c.id,
                        c.id_postare, c.autor, c.continut, c.data    
                from utilizator u, comentariu c, postare p
                where u.email=c.autor and c.id_postare=p.id 
                and u.email= ?
                order by c.data desc;";
    $stmt= mysqli_stmt_init($conn);
    //$result=mysqli_query($conn, $sqlpostari);
    if(!mysqli_stmt_prepare($stmt, $sqlpostari)){
        header("Location: index.php?error=sqlerror");
        exit();
    }else{
        mysqli_stmt_bind_param($stmt, "s",  $email);
        mysqli_stmt_execute($stmt);
        $result=mysqli_stmt_get_result($stmt);
        $resultCheck=mysqli_num_rows($result);
        if($resultCheck>0){
            echo "<div class='comentarii'>
            <p class='titlu-comm'>Activitatea mea</p>";
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
                    <button type='submit' name='profil-submit' class='btn-autor-comm'>";echo $row['nume']; echo "</button>
                    </form>

                </div>";
                if($email==$_SESSION['email']){
                    echo "<form class='logout' method='POST' action='includes/sterge-comm.inc.php'>
                    <input type='hidden' name='idcomentariu' value=";echo $row['id'];echo ">
                    <button type='submit' name='submit-sterge-comm' class='logout-btn'>Șterge!</button>
                    </form>";
                }
                echo
                "<form class='detalii-postare-orig' method='GET' action='detaliipostare.php'>
                <input type='hidden' name='idpostare' value=";echo $row['id_postare']; echo ">
                <button type='submit' name='detalii-submit'>Postarea orginală</button>
                </form>";
                echo "<p class='data-comm'>";
                echo $row['data']; 
                echo "</p>
                    
                    <p class='continut'>";
                echo $row['continut']." ";
                echo "</p>
                   
                    <br>";
                echo "</div>";
            }
            echo "</div>";
        }
    }
    echo "</div>";
}

?>
</body>
</html>
