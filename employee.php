<?php
    require_once 'credential.php';

    $conn = new mysqli($serverName, $userName, $passWord, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query = "SELECT name FROM root";
    $result = $conn->query($query);

    if($result->num_rows>0){
        $rows = $result->fetch_assoc();
        for($i = 0; $i < $rows; ++$i){
            $row = mysqli_fetch_row($result);
            echo '<div>'.$row.'</div>';
        }
    }

    $conn->close();
?>