<?php
session_start();
require 'dbh.inc.php';
if(isset($_POST['submit-adauga'])){
    $email=$_POST['email_b'];
    $sql = "insert into favorit values(? ,?);";
    $stmt= mysqli_stmt_init($conn);
          if(!mysqli_stmt_prepare($stmt, $sql)){
                $sqlmail="select * from utilizator
                where email= ?;";
                $stmt= mysqli_stmt_init($conn);
                mysqli_stmt_prepare($stmt, $sqlmail);
                mysqli_stmt_bind_param($stmt, "s",  $email);
                mysqli_stmt_execute($stmt);
                $result=mysqli_stmt_get_result($stmt);
                $row=mysqli_fetch_assoc($result);
                    
                $id= $row['id'];
                header("Location: ../index.php?id=".$id."&favorit=err");
          }else{
            mysqli_stmt_bind_param($stmt, "ss",$_SESSION['email'],  $email);
            mysqli_stmt_execute($stmt);

            $sqlmail="select * from utilizator
            where email= ?;";
            $stmt= mysqli_stmt_init($conn);
            mysqli_stmt_prepare($stmt, $sqlmail);
            mysqli_stmt_bind_param($stmt, "s",  $email);
            mysqli_stmt_execute($stmt);
            $result=mysqli_stmt_get_result($stmt);
            $row=mysqli_fetch_assoc($result);
            
            $id= $row['id'];

            header("Location: ../profil.php?id=".$id."&favorit=adaugat");
          }
            
}else if(isset($_POST['submit-elimina'])||isset($_POST['submit-elimina-lista']) ){
    $email=$_POST['email_b'];
    $sql = "delete from favorit where id_utilizator=? and id_bucatar=?;";
    $stmt= mysqli_stmt_init($conn);
           if(! mysqli_stmt_prepare($stmt, $sql)){

                $sqlmail="select * from utilizator
                where email= ?;";
                $stmt= mysqli_stmt_init($conn);
                mysqli_stmt_prepare($stmt, $sqlmail);
                mysqli_stmt_bind_param($stmt, "s",  $email);
                mysqli_stmt_execute($stmt);
                $result=mysqli_stmt_get_result($stmt);
                $row=mysqli_fetch_assoc($result);
                    
                $id= $row['id'];
                if(isset($_POST['submit-elimina'])){
                    header("Location: ../profil.php?id=".$id."&favorit=err");
                }else{
                    header("Location: ../profil.php?favorit=err");
                }
                
           }else{
               mysqli_stmt_bind_param($stmt, "ss",$_SESSION['email'],  $email);
                mysqli_stmt_execute($stmt);

                $sqlmail="select * from utilizator
                where email= ?;";
                $stmt= mysqli_stmt_init($conn);
                mysqli_stmt_prepare($stmt, $sqlmail);
                mysqli_stmt_bind_param($stmt, "s",  $email);
                mysqli_stmt_execute($stmt);
                $result=mysqli_stmt_get_result($stmt);
                $row=mysqli_fetch_assoc($result);
                
                $id= $row['id'];

                if(isset($_POST['submit-elimina'])){
                    header("Location: ../profil.php?id=".$id."&favorit=eliminat");
                }else{
                    header("Location: ../profil.php?favorit=eliminat");
                }
                
           }
            

}else{
    header("Location: ../index.php");
}