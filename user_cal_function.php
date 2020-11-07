<?php
    require_once 'credential.php';

    $ruid = $_POST["user_id"];
    $guid = $_POST["graph_type"];
    $start_date = new DateTime($_POST["startTime"]);
    $end_date = clone($start_date);
    $H = $_POST["graphHours"];

    $test = array ('ruid' => ''.$ruid.'', 'sd' => ''.$start_date.'');

    print_r($test);
    // end_date->date_modify('+'.$H.' hour');
   
    // $conn = new mysqli($serverName, $userName, $passWord, $database);
    // if ($conn->connect_error) {
    //     die("Connection failed: " . $conn->connect_error);
    // }

    // $conn->set_charset("utf8");
    // $query = "insert into cal values (NULL, '.$ruid.', '.$guid.', '.$start_date.', '.$end_date.')";
    // $result = $conn->query($query);
    // $conn->close();
?>