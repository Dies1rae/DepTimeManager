<?php 
    $ruid = $_POST['user_id'];
    $guid = $_POST['graph_type'];
    $SD = $_POST['startTime'];
    $s_d = date('Y-m-d H:i', strtotime(substr($SD,0,16)));
    $e_d = $s_d;
    $e_d = date('Y-m-d H:i', strtotime('+'.$_POST['graphHours'].'hours'));

    include 'credential.php';
    $link = new mysqli($serverName, $userName, $passWord, $database);
    
    if ($link->connect_error) {
        die("Connection failed: " . $link->connect_error);
    }

    $link->set_charset("utf8");

    
    $query="INSERT INTO cal (c_uid, r_uid, g_uid, start_date, end_date) VALUES (NULL, "'.$ruid.'", "'.$guid.'", "'.$s_d.'", "'.$e_d.'")";
    mysqli_query($link, $query);

    $link->close();
?>