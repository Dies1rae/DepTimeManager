<?php
    session_start();
    class ScheduleOutput{
        function DrawFiveDayGraph($guid, $ruid, $startDate, $endDate, $cellDate, $weekends){
           
            if (($cellDate >= $startDate) && ($cellDate <= $endDate)) {
                $dayOfWeek = $cellDate->format('l');
                if($dayOfWeek == 'Sunday'||$dayOfWeek =='Saturday'){
                    $class_deflt = 'b_main_time_warning';
                    $workHours = '';
                }else{
                    $class_deflt = 'b_main_time_work';
                    $workHours = 8;
                }
            }elseif(($cellDate < $startDate) || ($cellDate > $endDate)){
                $class_deflt = 'b_main_time';
            }
            echo '<td><input type="submit" id="myBtn" class="'.$class_deflt.'"
                    onclick="printId('.$ruid.', `'.$cellDate.'`, `'.$cellDate.'`)"
                    value="'.$workHours.'"></td>';
        }

        function DrawFreeGraph($guid, $startDate, $endDate){
            
        }
    }
?>