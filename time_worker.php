<?php 
    session_start();
    class time_worker{
        private $st_week_;
        private $en_week_;
    
        public function __construct(){
            $this->st_week_ = new DateTime;
            if (isset($_GET['year']) && isset($_GET['week'])) {
                $this->st_week_->setISODate($_GET['year'], $_GET['week']);
            } else {
                $this->st_week_->setISODate($this->st_week_->format('o'), $this->st_week_->format('W'));
            }
            $this->en_week_ = clone($this->st_week_);
            $this->en_week_->modify('+6 days');
        }
    
        public function get_start_week(){
            return $this->st_week_;
        }
        
        public function get_end_week(){
            return $this->en_week_;
        }

        public function transform_date_Ymd_DB($datetime_){
            $dt_ = date('Y-m-d', strtotime(substr($datetime_, 0, 10)));
            $dt_ret = new DateTime($dt_);
            return $dt_ret;
        }

        public function transform_date_Ymd_Hi_DB($datetime_){
            $dt_ = date('Y-m-d H:i', strtotime(substr($datetime_, 0, 16)));
            $dt_ret = new DateTime($dt_);
            return $dt_ret;
        }
    }
?>