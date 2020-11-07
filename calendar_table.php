<?php
session_start();
class ca_table{
    private $ruid_;
    private $guid_;
    private $start_date_;
    private $hours_;
    private $end_date_;

    public function __construct($ruid, $guid, $sd, $H){
        $this->ruid_ = $ruid;
        $this->guid_ = $guid;
        $this->$hours_ = $H;
        $this->start_date = new DateTime($sd);
    }

    public function __construct($ruid){
        $this->ruid_ = $ruid;
    }

    public function __construct(){ }

    public function calculate_end_date(){
        $this->end_date_ = clone $this->start_date;
        $this->end_date_->date_modify('+'.$this->$hours_.' hour');
    }

    public function insert_into_cal($ruid, $guid, $sd, $H){
        $this->ruid_ = $ruid;
        $this->guid_ = $guid;
        $this->$hours_ = $H;
        $this->start_date = new DateTime($sd);
        calculate_end_date();
        require_once 'credential.php';
        
        $conn = new mysqli($serverName, $userName, $passWord, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $conn->set_charset("utf8");
        $query = "insert into cal values (NULL, '.$this->ruid_.', '.$this->guid_.', '.$this->start_date_.', '.$this->end_date_.');";
        $result = $conn->query($query);
        $conn->close();
    }


    public function insert_into_cal(){
        calculate_end_date();
        require_once 'credential.php';
        
        $conn = new mysqli($serverName, $userName, $passWord, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $conn->set_charset("utf8");
        $query = "insert into cal values (NULL, '.$this->ruid_.', '.$this->guid_.', '.$this->start_date_.', '.$this->end_date_.');";
        $result = $conn->query($query);
        $conn->close();
    }

    public function get_from_cal(){
        require_once 'credential.php';
        
        $conn = new mysqli($serverName, $userName, $passWord, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $conn->set_charset("utf8");
        $query = "select root.name, cal.* from root inner join cal on root.r_uid = cal.r_uid where cal.r_uid like ''.$this->ruid_.''";
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