<?php
    class ScheduleOutput{

        public $cellDate, $startDate, $ruid, $dtform, $guid, $hrs, $theme, $tdclass;

        

        function DRAW(){
            $class_deflt = 'b_main_time';
            echo '<td class="'.$this->tdclass.'"><input type="submit" id="myBtn" class="'.$this->theme.'" onclick="printId('.$this->ruid.', `'.$this->dtform.'`, `'.$this->dtform.'`)" value="'.$this->hrs.'"></td>';
        }

        function DrawZeroCell(){
            $this->theme = 'b_main_time';
        }

        function DrawFreeGraph(){
            $this->theme = 'b_main_time_work';
            $this->tdclass = '';
        }

        function AdminGraph(){
            $compareFirstDay = $this->cellDate->diff($this->startDate);
            $tempFC = $compareFirstDay->format('%a');
            if($this->cellDate == $this->startDate || $tempFC % 4 == 0){
                 $this->theme = 'b_main_time_work';
                 $this->hrs = 12;
            }elseif($tempFC % 2 == 0 && !($tempFC % 4 == 0)){
                 $this->theme = 'b_main_time_work_snight';
                 $this->tdclass = 'b_cell_bg';
                 $this->hrs= 7;
            }elseif($tempFC % 2 != 0 && (($tempFC + 3) % 4 == 0)){
                 $this->theme = 'b_main_time_work_fnight';
                 $this->tdclass = 'b_cell_bg';
                 $this->hrs = 3;
            }else{
                 $this->theme = 'b_main_time_weekend';
                 $this->hrs = '';
            }
        }

        function DrawFiveDayGraph(){
            $dayOfWeek = $this->cellDate->format('l');
            $this->tdclass = '';
            if($this->guid == 5){
                if($dayOfWeek == 'Sunday'||$dayOfWeek =='Saturday'){ 
                    $this->theme = 'b_main_time_weekend';
                    $this->hrs = '';
                }else{
                    $this->theme = 'b_main_time_FiveDay_10hrs';
                    $this->hrs = 8;
                }
            }
            if($this->guid == 6){
                if($dayOfWeek == 'Sunday'||$dayOfWeek =='Saturday'){ 
                    $this->theme = 'b_main_time_weekend';
                    $this->hrs = '';
                }else{
                    $this->theme = 'b_main_time_FiveDay_9hrs';
                    $this->hrs = 8;
                }
            }
            if($this->guid == 7){
                if($dayOfWeek == 'Sunday'||$dayOfWeek =='Saturday'){ 
                    $this->theme = 'b_main_time_weekend';
                    $this->hrs = '';
                }else{
                    $this->theme = 'b_main_time_FiveDay_11hrs';
                    $this->hrs = 8;
                }
            }
            if($this->guid == 8){
                if($dayOfWeek == 'Sunday'||$dayOfWeek =='Saturday'){ 
                    $this->theme = 'b_main_time_weekend';
                    $this->hrs = '';
                }else{
                    $this->theme  = 'b_main_time_FiveDay_6hrs';
                    $this->hrs = 8;
                }
            }
            if($this->guid == 9){
                if($dayOfWeek == 'Sunday'||$dayOfWeek =='Monday'){ 
                    $this->theme = 'b_main_time_weekend';
                    $this->hrs = '';
                }else{
                    $this->theme = 'b_main_time_FiveDay_tue_10hrs';
                    $this->hrs = 8;
                }
            }
            if($this->guid == 10){
                if($dayOfWeek == 'Wednesday'||$dayOfWeek =='Saturday'){ 
                    $this->theme = 'b_main_time_weekend';
                    $this->hrs = '';
                }else{
                    $this->theme = 'b_main_time_FiveDay_wed_saturd_10hrs';
                    $this->hrs = 8;
                }
            }
        }
    }
?>