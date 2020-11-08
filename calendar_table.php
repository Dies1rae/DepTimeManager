<?php

class ca_table{
    private $ruid_;

    public function __construct(){
        $this->ruid_ = 3147;
    }

    public function get_from_cal(){
        $st = new DateTime();
        $st->format(W);
        $bWeek = $st->format('Y-m-d H:i');
        $eWeek = $st->modify('+6 days');
    
       // include 'credential.php';
            
       // $conn = new mysqli($serverName, $userName, $passWord, $database);
        //if ($conn->connect_error) {
       //     die("Connection failed: " . $conn->connect_error);
       // }
        //$conn->set_charset("utf8");
        //$query = "SELECT cal.g_uid, cal.start_date, cal.end_date FROM root INNER JOIN cal ON root.r_uid = cal.r_uid WHERE cal.r_uid LIKE '%'"; // AND (cal.start_date between '$bWeek' and '$eWeek')
        //$result = $conn->query($query);
        $as = 0;
        if( $this->ruid_ === 3147){
            $as = 1;
        } else {
            $as = 0;
        }
    
       // if($result->num_rows>0){
       //     while($row = $result->fetch_assoc()){ 
        //        $data[] = $row;
       //     }
       // }
       // $conn->close();
        return $as;
    }