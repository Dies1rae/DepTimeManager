<?php
session_start();
class Credential{
    private $dep_query_;

    public function __construct($dep_query){
        $this->dep_query_ = $dep_query;
    }
    public function set_dep($dep_query){
        $this->dep_query_ = $dep_query;
    }

    public function sql_query(){
        require_once 'credential.php';
        
        $conn = new mysqli($serverName, $userName, $passWord, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $conn->set_charset("utf8");
        $query = "SELECT * FROM root WHERE status LIKE '1' and dep like '$this->dep_query_'";
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