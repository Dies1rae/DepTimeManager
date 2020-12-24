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
        $SD_q = $SD->format('Y-m-d');
        $EDT_q = $EDT->format('Y-m-d');
        $query = "SELECT cal.g_uid, cal.start_date, cal.end_date FROM root INNER JOIN cal ON root.r_uid = cal.r_uid WHERE cal.r_uid LIKE '$ruid' AND (cal.start_date between '$SD_q' and '$EDT_q' or '$SD_q' <= cal.end_date)";
        $result = $link->query($query);

        $uniqueData = array();

        if($result->num_rows>0){
            while($row = $result->fetch_assoc()){ 
                $uniqueData[] = $row;
            }
        }

    } else {
        $query="INSERT INTO cal (c_uid, r_uid, g_uid, start_date, end_date) VALUES (NULL, '$ruid', '$guid', '$s_d', '$e_d')";
        mysqli_query($link, $query);
    }
    $link->close();
    header('Location: ' . $_SERVER['HTTP_REFERER']);
?>