<?php
    session_start();
    class ScheduleOutput{
        function DrawFiveDayGraph($guid, $startDate, $endDate){

            
            $interval = new DateInterval('P1D');
            $period = new DatePeriod($startDate, $interval, $endDate);
            $currentWeek = $startDate->format('W');

            foreach ($period as $date) {

                $dayOfWeek = $date->format('l');
                if($dayOfWeek == 'Sunday' || $dayOfWeek == 'Saturday'){
                    $class_deflt = 'b_main_time_warning';
                    $workHours = '';
                }else{
                    $class_deflt = 'b_main_time_work';
                    $workHours = 8;
                }
                echo '<td><input type="submit" id="myBtn" class="'.$class_deflt.'"
                    onclick="printId('.$custId_ar[$i].', `'.$temp_dt_form.'`, `'.$temp_dt_form.'`)"
                    value="'.$workHours.'"></td>';
            }
        }

        function DrawFreeGraph($guid, $startDate, $endDate){
            
        }
    }
?>