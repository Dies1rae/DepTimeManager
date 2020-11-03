<?php
session_start();
class Credential{
    private $iternal_query_;

    public function __construct($insert_query){
        $this->iternal_query_ = $insert_query;
    }

    public function sql_query_dep(){
        require_once 'credential.php';
        
        $conn = new mysqli($serverName, $userName, $passWord, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $conn->set_charset("utf8");
        $query = "SELECT * FROM root WHERE status LIKE '1' and dep like '$this->iternal_query_'";
        $result = $conn->query($query);

        $data = array();

        if($result->num_rows>0){
            while($row = $result->fetch_assoc()){ 
                $data[] = $row;
            }
        }
        $conn->close();
        return $data;
    }

    public function sql_query_account(){
        require_once 'credential.php';
        
        $conn = new mysqli($serverName, $userName, $passWord, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $conn->set_charset("utf8");
        $query = "SELECT * FROM root WHERE status LIKE '1' and  account like '$this->iternal_query_'";
        $result = $conn->query($query);

        $data = array();

        if($result->num_rows>0){
            while($row = $result->fetch_assoc()){ 
                $data[] = $row;
            }
        }
        $conn->close();
        return $data;
    }

    public function set_user_time_free($r_uid, $g_uid, $hours, $start_date){
        require_once 'credential.php';
        
        $conn = new mysqli($serverName, $userName, $passWord, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $conn->set_charset("utf8");
        $end_date = $start_date->add(new DateInterval('PT'.$hours.'H'));
        $query = "insert into cal (NULL, '$r_uid', '$g_uid', '$start_date', '$end_date')";
        $conn->close();
    }
    
    public function get_user_time(){
        require_once 'credential.php';
        
        $conn = new mysqli($serverName, $userName, $passWord, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $conn->set_charset("utf8");
        $query = "SELECT * FROM cal WHERE r_uid like '$this->iternal_query_'";
        $result = $conn->query($query);

        $data = array();

        if($result->num_rows>0){
            while($row = $result->fetch_assoc()){ 
                $data[] = $row;
            }
        }
        $conn->close();
        return $data;
    }
}

?>