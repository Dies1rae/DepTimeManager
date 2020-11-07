
<?php
    include 'credential.php';
    $link = new mysqli($serverName, $userName, $passWord, $database);
    if ($link->connect_error) {
        die("Connection failed: " . $link->connect_error);
    }
    $link->set_charset("utf8");

    $ruid = $_POST['user_id'];
    $guid = $_POST['graph_type'];
    $SD = $_POST['startTime'];
    $start_date = ate('Y-m-d H:i', strtotime(substr($SD,0,16)));
    $end_date = clone($start_date);
    $end_date = date("Y-m-d H:i", strtotime('+'.$_POST['graphHours'].'hours'));
   


    $query="INSERT INTO cal (c_uid, r_uid, g_uid, start_date, end_date) VALUES (NULL, $ruid, $guid, $start_date, $end_date)";
    mysqli_query($link, $query);
    $link->close();

?>