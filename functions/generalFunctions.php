<?php
function connect() {
    //temp setup, will need to change once we have it hosted on codd
    $servername = "127.0.0.1";  
    $username = "root";         
    $password = "";             
    $dbname = "realty";  

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

?>
