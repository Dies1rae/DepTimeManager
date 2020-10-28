<?php
    require_once 'credential.php';

    $conn = new mysqli($serverName, $userName, $passWord, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $conn->set_charset("utf8");
    $query = "SELECT account FROM root WHERE status LIKE '1' and account like 'spbtv/%'";
    $result = $conn->query($query);

    if($result->num_rows>0){
        while($row = $result->fetch_assoc()){
            
            echo '<div>'.$row["account"].'</div>';
        }
    }

    $conn->close();
?>