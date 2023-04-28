<?php
require __DIR__ . "/../config/constants.php";
function database_connect()
{
    // this for if any error happen in the database connect view in the browser and stop any codition'll happen
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); 
    // this fro connect to the database
    $connection = mysqli_connect(HOSTNAME, USERNAME, PASSWORD, DATABASE_NAME);
    return $connection; 
}

?>
