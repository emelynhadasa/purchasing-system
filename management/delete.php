<?php
if ( isset($_GET["id"]) ) {
    $id = $_GET["id"];
    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "expenditure";

    //create connection
    $connection = new mysqli($servername, $username, $password, $database);

    $sql ="DELETE FROM exp where id=$id";
    $connection->query($sql);
}

header("location: ./coba.php");
exit;
?>
