<?php
session_start();
class AccFinder{
    private $account_;

    public function __construct($account){
        $this->account_ = $account;
    }
    public function set_dep($account){
        $this->account_ = $account;
    }

    public function sql_query(){
        require_once 'credential.php';
        
        $conn = new mysqli($serverName, $userName, $passWord, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $conn->set_charset("utf8");
        $query = "SELECT * FROM root WHERE name like '$_POST['lname']'";
        $result = $conn->query($query);

        $data = array();

        if($result->num_rows>0){
            while($row = $result->fetch_assoc()){ 
                $data[] = $row;
            }
        }
        $conn->close();

        $_SESSION['name'] = $data[0]['name'];
        $_SESSION['position'] = $data[0]['position'];
        $_SESSION['dep'] = $data[0]['dep'];
        $_SESSION['email'] = $data[0]['email'];
        $_SESSION['mobile'] = $data[0]['mobile'];
        $_SESSION['extel'] = $data[0]['extel'];
        echo '<a>'.$data[0]['name'];.'</a>'
        include 'userpage.php';
    }
}

?>