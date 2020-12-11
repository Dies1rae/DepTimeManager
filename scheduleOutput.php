<?php
    session_start();
    class ScheduleOutput{

        function DrawFiveDayGraph($guid, $ruid, $startDate, $endDate, $cellDate, $weekends){
            if (($cellDate >= $startDate) && ($cellDate <= $endDate)) {
                $dayOfWeek = $cellDate->format('l');
                if($guid == 5){
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
            }
            echo '<td><input type="submit" id="myBtn" class="'.$class_deflt.'"
                    onclick="printId('.$ruid.', `'.$cellDate.'`, `'.$cellDate.'`)"
                    value="'.$workHours.'"></td>';
        }

        //ITS NOT FUCKING DONE!
        function DrawFreeGraph($startDate, $endDate, $week_arrays, $temp_cellDate, $tmp_start_week_now_tmp_second_suka, $tmp_end_week_now_tmp_second_suka){
            include_once 'time_worker.php';
            $week_time_worker = new time_worker;
            $temp_startDate = $week_time_worker->transform_date_Ymd_DB($startDate);
            $temp_endDate = $week_time_worker->transform_date_Ymd_DB($endDate);

            $temp_firstCompare =  $week_time_worker->transform_date_Ymd_Hi_DB($startDate);
            $temp_secondCompare = $week_time_worker->transform_date_Ymd_Hi_DB($endDate);

            for ($k=0; $k < 7; $k++) { 
                $intervalDiff = $temp_secondCompare->diff($temp_firstCompare);
                $hours = $intervalDiff->format('%H');
                $days_to = $intervalDiff->format('%a');
                $hoursDiff = $days_to * 24 + $hours; 
                //тут логика расчета свободных дней
                //по сути описаны все ситуации на графике, убрать в отдельную функцию, частично применять для других графиков
                //СУКА!!!!!!
                if(($temp_cellDate == $temp_startDate) && ($hoursDiff < 24)){
                    if($temp_startDate == $temp_endDate){
                        $week_arrays[$k] = $hoursDiff;
                    } elseif ($temp_startDate <= $temp_endDate) {
                        $startPoint=$temp_firstCompare->format('H'); //little bit of PHPHPHPH magick here
                        $customPoint = 24 - $startPoint;
                        $week_arrays[$k] = $customPoint;
                    } else {
                        $week_arrays[$k] = 0;
                    }
                    break 1;
                }
                if (($temp_cellDate == $temp_endDate) && ($hoursDiff < 24)){
                    $startPoint=$temp_secondCompare->format('H') - 0; //and here MAGIC PIZDES
                    $week_arrays[$k] = $startPoint;
                    break 1;
                } elseif (($temp_startDate < $tmp_start_week_now_tmp_second_suka) && ($tmp_start_week_now_tmp_second_suka == $temp_cellDate) && ($hoursDiff >= 24)){
                    $tmp_start_week_now_compare = new DateTime;
                    $tmp_start_week_now_compare = $week_time_worker->transform_date_Ymd_0000_DB($tmp_start_week_now_);

                    $tmp_diff_all = $temp_secondCompare->diff($tmp_start_week_now_compare);
                    $tmp_diff_hours = $tmp_diff_all->format('%H');
                    $tmp_diff_days = $tmp_diff_all->format('%a');
                    $z = $k;
                    if($tmp_diff_days > 0){
                        while($tmp_diff_days > 0){
                            $week_arrays[$k] = 24;
                            $tmp_diff_days = $tmp_diff_days - 1;
                            $z++;
                        }
                    }
                    $week_arrays[$k]  = $tmp_diff_hours;
                    break 1;
                } elseif (($temp_cellDate == $temp_startDate) && ($hoursDiff >= 24)) {
                    if($tmp_end_week_now_tmp_second_suka != $temp_cellDate){
                        $z = $k;
                        $startPoint=$temp_firstCompare->format('H'); //little bit of PHPHPHPH magick here
                        $customPoint = 24 - $startPoint;
                        $week_arrays[$k] = $customPoint;
                        $hoursDiff = $hoursDiff - $customPoint;
                        while($hoursDiff > 24){
                            $z++;
                            $customPoint = 24;
                            $week_arrays[$z] = $customPoint;
                            $hoursDiff = $hoursDiff - 24;
                        }
                        $z++;
                        $week_arrays[$k]= $hoursDiff;
                    } else {
                        $startPoint=$temp_firstCompare->format('H'); //and here
                        $customPoint = 24 - $startPoint;
                        $week_arrays[$k]  = $customPoint;
                    }
                    break 1;
                }
                if($week_arrays[$k] >= 24){
                    $class_deflt = 'b_main_time_warning';
                }
                if($week_arrays[$k] > 0 && $week_arrays[$k] < 24 ){
                    $class_deflt = 'b_main_time_work';
                }
                
                echo '<td><input type="submit" id="myBtn" class="'.$class_deflt.'" onclick="printId('.$custId_ar[$i].', `'.$temp_dt_form.'`, `'.$temp_dt_form.'`)" value="'.$week_arrays[$k].'"></td>';        
            }
            
            
            
        }
    }
?>