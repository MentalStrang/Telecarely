<?php
require __DIR__. "/connection.php"; 

function database_insert_patient_inquiry($dr_id, $patient_id, $inquiry_about){
    $connection = database_connect(); 
    // you should here using (...mysqli_prepare()...) but use it after you end the project
    $query = "insert into doctor_consultation_patient_tabel(dr_id, , patient_id, inquiry_about, "; 
    $insert = mysqli_query($connection,$query); 
    

}

?>
