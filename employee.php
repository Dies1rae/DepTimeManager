<?php
session_start();
class Credential{
    private $dep_query_;

    public function __construct($dep_query){
        $this->dep_query_ = $dep_query;
    }
    public function set_dep($dep_query){
        $this->dep_query_ = dep_query;
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

                // $_SESSION['name'] = $row["name"];
                // $_SESSION['position'] = $row["position"];
                // $_SESSION['dep'] = $row["dep"];
                // $_SESSION['email'] = $row["email"];
                // $_SESSION['mobile'] = $row["mobile"];
                // $_SESSION['extel'] = $row["extel"];

                // echo '<tr>';
                // echo '<td><a href="userpage.php"><div>'.$row["name"].'</div></a></td>';
                // echo '<td></td>';
                // echo '<td></td>';
                // echo '<td></td>';
                // echo '<td></td>';
                // echo '<td></td>';
                // echo '<td></td>';
                // echo '<td></td>';
                // echo '</tr>';
            }
            for($i=0; $i< count($data); $i++){
                $_SESSION['name'] = $data[$i]['name'];
                $_SESSION['position'] = $data[$i]['position'];
                $_SESSION['dep'] = $data[$i]['dep'];
                $_SESSION['email'] = $data[$i]['email'];
                $_SESSION['mobile'] = $data[$i]['mobile'];
                $_SESSION['extel'] = $data[$i]['extel'];

                echo '<tr>';
                echo '<td><a href="userpage.php"><div>'.$data[$i]['name'].'</div></a></td>';
                echo '<td></td>';
                echo '<td></td>';
                echo '<td></td>';
                echo '<td></td>';
                echo '<td></td>';
                echo '<td></td>';
                echo '<td></td>';
                echo '</tr>';
            }
        }
        $conn->close();
        
    }
}

?>