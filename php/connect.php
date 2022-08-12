<?php
$conn = ["mysql-scascian2.alwaysdata.net","scascian2", "######", "scascian2_kbbd"];
//server name, username, password and DB name

function executeQuery($sql){
    global $conn;
    $connection = new mysqli($conn[0], $conn[1], $conn[2], $conn[3]);
    $result = $connection->query($sql);
    $connection->close();
    return $result;
}