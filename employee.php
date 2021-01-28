<?php
session_start();
class Credential{
    private $iternal_query_;

    public function __construct($insert_query = array()){
        $this->iternal_query_ = implode("' or dep like'", $insert_query);
    }

    public function sql_query_dep(){
        require_once 'credential.php';
        
        $conn = new mysqli($serverName, $userName, $passWord, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $conn->set_charset("utf8");
        $query = "SELECT * FROM root WHERE status = 1 and (account like 'spbtv/%' and dep like '$this->iternal_query_')";
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

    public function sql_query_account($acc_name){
        require_once 'credential.php';
        
        $conn = new mysqli($serverName, $userName, $passWord, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $conn->set_charset("utf8");
        $query = "SELECT * FROM root WHERE status LIKE '1' and  account like '$acc_name'";
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