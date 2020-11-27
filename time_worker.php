<?php 
    session_start();
    class time_worker{
        private $st_week_;
        private $en_week_;
        
        //calculate start end week data and time
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
    
        //return whole start-end
        public function get_start_week(){
            return $this->st_week_;
        }
        public function get_end_week(){
            return $this->en_week_;
        }

        //transform from DB to datetime
        public function transform_date_Ymd_DB($datetime_){
            $dt_ = date('Y-m-d', strtotime(substr($datetime_, 0, 10)));
            $dt_ret = new DateTime($dt_);
            return $dt_ret;
        }
        //transform from DB to datetime with time
        public function transform_date_Ymd_Hi_DB($datetime_){
            $dt_ = date('Y-m-d H:i', strtotime(substr($datetime_, 0, 16)));
            $dt_ret = new DateTime($dt_);
            return $dt_ret;
        }

        //transform start from datetime to YMD only
        public function Ymd_STweek_YMD(){
            $tmp_start_week_now_ = clone($this->st_week_);
            $tmp_start_week_now_ = $tmp_start_week_now_->format('Y-m-d');
            return $tmp_start_week_now_;
        }
        //transform end from datetime to YMD only
        public function Ymd_ENweek_YMD(){
            $tmp_end_week_now_ = clone($this->en_week_);
            $tmp_end_week_now_ = $tmp_end_week_now_->format('Y-m-d');
            return $tmp_end_week_now_;
        }

        //transform start from datetime to YMD H-I only
        public function Ymd_STweek_YMD_HI(){
            $tmp_start_week_now_ = clone($this->st_week_);
            $tmp_start_week_now_ = $tmp_start_week_now_->format('Y-m-d H:i');
            return $tmp_start_week_now_;
        }
        //transform end from datetime to YMD H-I only
        public function Ymd_ENweek_YMD_HI(){
            $tmp_end_week_now_ = clone($this->en_week_);
            $tmp_end_week_now_ = $tmp_end_week_now_->format('Y-m-d H:i');
            return $tmp_end_week_now_;
        }

        //transform start from datetime to YMD 00:00 only
        public function Ymd_STweek_YMD_0000(){
            $tmp_start_week_now_ = clone($this->st_week_);
            $tmp_start_week_now_ = $tmp_start_week_now_->format('Y-m-d 00:00');
            return $tmp_start_week_now_;
        }
        //transform end from datetime to YMD 00:00 only
        public function Ymd_ENweek_YMD_0000(){
            $tmp_end_week_now_ = clone($this->en_week_);
            $tmp_end_week_now_ = $tmp_end_week_now_->format('Y-m-d 00:00');
            return $tmp_end_week_now_;
        }

        //transform from DB datetime to YMD 00:00 only
        public function transform_date_Ymd_0000_DB($datetime_){
            $dt_ = date('Y-m-d 00:00', strtotime(substr($datetime_, 0, 16)));
            $dt_ret = new DateTime($dt_);
            return $dt_ret;
        }
    }
?>