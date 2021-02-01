<?php
    class ScheduleOutput{

        public $cellDate, $startDate, $endDate, $ruid, $dtform, $guid, $hrs, $theme, $tdclass;

        

        function DRAW(){
            echo '<td class="'.$this->tdclass.'"><input type="submit" id="myBtn" class="'.$this->theme.'" onclick="printId('.$this->ruid.', `'.$this->dtform.'`, `'.$this->dtform.'`)" value="'.$this->hrs.'"></td>';
        }

        function DrawZeroCell(){
            $this->theme = 'b_main_time';
        }

        function DrawFreeGraph(){
            if($this->guid == 3){
                $this->theme = 'b_main_time_weekend';
                $this->tdclass = '';
            }
            if($this->guid == 1){
                $this->theme = 'b_main_time_work';
                $this->tdclass = '';
            }
            if($this->guid == 11){
                $this->theme = 'b_main_time_vacation';
                $this->tdclass = '';
            }
        }

        function AdminGraph(){
            $this->hrs = '';
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

        //1 через 3 по 24 с 08.00 с праздничными (котельная) - 1,2,3,4 смены 
        //1 через 3 по 24 с 09 с праздничными- 1,2,3,4 смены
        //1 через 3 по 24 с 10:00 с праздничными 
        function DrawFifteenGraph(){
            $this->hrs = '';
            $compareFirstDay = $this->cellDate->diff($this->startDate);
            $tempFC = $compareFirstDay->format('%a');
            if($this->cellDate == $this->startDate || $tempFC % 4 == 0){
                $this->theme = '';
                $this->hrs = 14;
            }elseif($tempFC % 2 != 0 && (($tempFC + 3) % 4 == 0)){
                $this->theme = '';
                $this->hrs = 8;
            }else{
                $this->theme = 'b_main_time_weekend';
                $this->hrs = '';
            }
        }

        function DrawFiveDayGraph(){
            $this->hrs = '';
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