<?php 
    session_start();
    $ruid = $_POST['user_id'];
    

    include 'credential.php';
        
    $conn = new mysqli($serverName, $userName, $passWord, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $conn->set_charset("utf8");
    $query = "SELECT root.name, cal.* FROM root INNER JOIN cal ON root.r_uid = cal.r_uid WHERE cal.r_uid LIKE '$ruid'";
    $result = $conn->query($query);

    $data = array();

    if($result->num_rows>0){
        while($row = $result->fetch_assoc()){ 
            $data[] = $row;
        }
    }
    $conn->close();
    return $data;
?>