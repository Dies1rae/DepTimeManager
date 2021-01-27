<?php
    class ScheduleOutput{

        public $cellDate, $startDate, $ruid, $dtform, $guid, $wrkngHours;

        function __construct($cellDate, $startDate, $ruid, $dtform, $guid, $w_Hourse){
            $this->cellDate = $cellDate;
            $this->startDate = $startDate;
            $this->ruid = $ruid;
            $this->dtform = $dtform;
            $this->guid = $guid;
            $this->wrkngHours = $w_Hourse;
        }

        function DRAW($hrs, $theme){
            $class_deflt = 'b_main_time';
            echo '<td><input type="submit" id="myBtn" class="'.$theme.'" onclick="printId('.$this->ruid.', `'.$this->dtform.'`, `'.$this->dtform.'`)" value="'.$hrs.'"></td>';
        }

        function DrawZeroCell(){
            $class_deflt = 'b_main_time';
            $h;
            $this->DRAW($h,$class_deflt);
        }

        function DrawFreeGraph(){
            $class_deflt = 'b_main_time_work';
            $this->DRAW($this->wrkngHours,$class_deflt);
        }

        function AdminGraph(){
            $compareFirstDay = $this->cellDate->diff($this->startDate);
            $tempFC = $compareFirstDay->format('%a');
            if($this->cellDate == $this->startDate || $tempFC % 4 == 0){
                 $class_deflt = 'b_main_time_work';
                 $wrkH = 12;
            }elseif($tempFC % 2 == 0 && !($tempFC % 4 == 0)){
                 $class_deflt = 'b_main_time_work_snight';
                 $td_class = 'b_cell_bg';
                 $wrkH = 7;
            }elseif($tempFC % 2 != 0 && (($tempFC + 3) % 4 == 0)){
                 $class_deflt = 'b_main_time_work_fnight';
                 $td_class = 'b_cell_bg';
                 $wrkH = 3;
            }else{
                 $class_deflt = 'b_main_time_weekend';
                 $wrkH = '';
            }
            echo '<td class="'.$td_class.'"><input type="submit" id="myBtn" class="'.$class_deflt.'" onclick="printId('.$this->ruid.', `'.$this->dtform.'`, `'.$this->dtform.'`)" value="'.$wrkH.'"></td>';
        }

        function DrawFiveDayGraph(){
            $dayOfWeek = $this->cellDate->format('l');
            if($this->guid == 5){
                if($dayOfWeek == 'Sunday'||$dayOfWeek =='Saturday'){ 
                    $class_deflt = 'b_main_time_weekend';
                    $workHours = '';
                }else{
                    $class_deflt = 'b_main_time_FiveDay_10hrs';
                    $workHours = 8;
                }
            }
            if($this->guid == 6){
                if($dayOfWeek == 'Sunday'||$dayOfWeek =='Saturday'){ 
                    $class_deflt = 'b_main_time_weekend';
                    $workHours = '';
                }else{
                    $class_deflt = 'b_main_time_FiveDay_9hrs';
                    $workHours = 8;
                }
            }
            if($this->guid == 7){
                if($dayOfWeek == 'Sunday'||$dayOfWeek =='Saturday'){ 
                    $class_deflt = 'b_main_time_weekend';
                    $workHours = '';
                }else{
                    $class_deflt = 'b_main_time_FiveDay_11hrs';
                    $workHours = 8;
                }
            }
            if($this->guid == 8){
                if($dayOfWeek == 'Sunday'||$dayOfWeek =='Saturday'){ 
                    $class_deflt = 'b_main_time_weekend';
                    $workHours = '';
                }else{
                    $class_deflt = 'b_main_time_FiveDay_6hrs';
                    $workHours = 8;
                }
            }
            if($this->guid == 9){
                if($dayOfWeek == 'Sunday'||$dayOfWeek =='Monday'){ 
                    $class_deflt = 'b_main_time_weekend';
                    $workHours = '';
                }else{
                    $class_deflt = 'b_main_time_FiveDay_tue_10hrs';
                    $workHours = 8;
                }
            }
            if($this->guid == 10){
                if($dayOfWeek == 'Wednesday'||$dayOfWeek =='Saturday'){ 
                    $class_deflt = 'b_main_time_weekend';
                    $workHours = '';
                }else{
                    $class_deflt = 'b_main_time_FiveDay_wed_saturd_10hrs';
                    $workHours = 8;
                }
            }
            echo '<td><input type="submit" id="myBtn" class="'.$class_deflt.'"
            onclick="printId('.$this->ruid.', `'.$this->dtform.'`, `'.$this->dtform.'`)"
            value="'.$workHours.'"></td>';
        }
    }
?>