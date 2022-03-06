<?php 
require 'dbh.inc.php';
if(isset($_POST['id_judet'])){
    $sqlorase="select * from localitate
    where id_judet= ?;";
    $id_j=$_POST['id_judet'];
    $stmt= mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sqlorase);
    mysqli_stmt_bind_param($stmt, "s",  $id_j);
    mysqli_stmt_execute($stmt);
    $result=mysqli_stmt_get_result($stmt);
    echo "<option value='' selected='selected'>Alege orasul</option>";
    $resultCheck=mysqli_num_rows($result);
    while($row=mysqli_fetch_assoc($result)){
         echo "<option value='".$row['id']."'>".$row['nume']."</option>";
    }
    
   
}