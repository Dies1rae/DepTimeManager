<?php 
    session_start();
    // $ruid = $_POST['user_id'];
    $st = new DateTime();
    $st->format(W);
    $bWeek = $st->format('Y-m-d H:i');
    $eWeek = $st->modify('+6 days');

    include 'credential.php';
        
    $conn = new mysqli($serverName, $userName, $passWord, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $conn->set_charset("utf8");
    $query = "SELECT cal.g_uid, cal.start_date, cal.end_date FROM root INNER JOIN cal ON root.r_uid = cal.r_uid WHERE cal.r_uid LIKE '$uniqueUser' AND (cal.start_date between '$bWeek' and '$eWeek')" ;
    $result = $conn->query($query);

    $uniqueData = array();

    if($result->num_rows>0){
        while($row = $result->fetch_assoc()){ 
            $uniqueData[] = $row;
        }
    }
    $conn->close();
    return $uniqueData;
?>