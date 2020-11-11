<?php 
    session_start();
    $ruid = $_SESSION['ruid'];
    $bWeek = $_SESSION['start_week']->format('Y-m-d');
    $eWeek = $_SESSION['end_week']->format('Y-m-d');

    include 'credential.php';
        
    $conn = new mysqli($serverName, $userName, $passWord, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $conn->set_charset("utf8");
    $query = "SELECT cal.g_uid, cal.start_date, cal.end_date FROM root INNER JOIN cal ON root.r_uid = cal.r_uid WHERE cal.r_uid LIKE '$ruid' AND (cal.start_date between '$bWeek' and '$eWeek' or '$bWeek' <= cal.end_date)";
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