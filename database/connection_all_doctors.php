<?php
require __DIR__ . "/connection.php"; 

function database_get_all_doctors(){
    $connection = database_connect(); 
    $resutl = mysqli_query($connection, "select * from doctor");
    $doctors = mysqli_fetch_all($resutl, MYSQLI_ASSOC); 
    return $doctors ; 

}


?>
