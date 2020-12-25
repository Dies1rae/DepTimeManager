<?php 
    session_start();
    $ruid = $_POST['user_id'];
    $guid = $_POST['graph_type'];
    $SD = $_POST['startTime'];
    $EDT = $_POST['endTime'];
    $s_d = date('Y-m-d H:i', strtotime(substr($SD,0,16)));
    $e_d = date('Y-m-d H:i', strtotime(substr($EDT,0,16)));

    include 'credential.php';
    $link = new mysqli($serverName, $userName, $passWord, $database);
    
    if ($link->connect_error) {
        die("Connection failed: " . $link->connect_error);
    }

    $link->set_charset("utf8");

    if($guid == 11){
        $query = "SELECT cal.g_uid, cal.start_date, cal.end_date FROM root INNER JOIN cal ON root.r_uid = cal.r_uid WHERE cal.r_uid LIKE '$ruid' AND (cal.start_date between '$bWeek' and '$eWeek' or '$bWeek' <= cal.end_date)";
        $result = $link->query($query);
        $user_data_cal = array();
        if($result->num_rows>0){
            while($row = $result->fetch_assoc()){ 
                $user_data_cal[] = $row;
            }
        }
        $result->free();
        if($user_data_cal['g_uid'] == '1' || $user_data_cal['g_uid'] == '3' || $user_data_cal['g_uid'] == '5'){
            $s_d = date('Y-m-d', strtotime(substr($SD,0,16)));
            $e_d = date('Y-m-d', strtotime(substr($EDT,0,16)));
            $query="delete from cal where r_uid like '$ruid' and (start_date like '$s_d%' and end_date like '$e_d%')";
            mysqli_query($link, $query);  
        } else {
            $s_d = date('Y-m-d', strtotime(substr($SD,0,16)));
            $query="delete from cal where r_uid like '$ruid' and (start_date <= '$s_d%' or start_date like '$s_d%')";
            mysqli_query($link, $query);  
        }

    } else {
        $query="INSERT INTO cal (c_uid, r_uid, g_uid, start_date, end_date) VALUES (NULL, '$ruid', '$guid', '$s_d', '$e_d')";
        mysqli_query($link, $query);
    }
    $link->close();
    header('Location: ' . $_SERVER['HTTP_REFERER']);
?>