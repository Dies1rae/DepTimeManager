<?php 
    class time_worker{
        private $start_week_;
        private $end_week_;
    
        public function __construct(){
            $start_week_ = new DateTime;
            if (isset($_GET['year']) && isset($_GET['week'])) {
                $dt->setISODate($_GET['year'], $_GET['week']);
            } else {
                $dt->setISODate($dt->format('o'), $dt->format('W'));
            }
            $end_week_ = clone($start_week);
            $end_week_ ->modify('+6 days');

        }
    
        public function get_start_week(){
            return $start_week_;
        }
        
        public function get_end_week(){
            return $end_week_;
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