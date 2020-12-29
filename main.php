<?php
session_start();
//check session or logoff
if(!isset($_SESSION['dep_key'])) {
    header('Location: /index.htm');
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <title>Shift schedule</title>
    <link rel="stylesheet" type="text/css" href="style/table_main.css">
    <link rel="stylesheet" type="text/css" href="style/schedulepage.css">
    <link rel="stylesheet" type="text/css" href="style/solid.css">
    <link rel="stylesheet" type="text/css" href="style/regular.css">
    <link rel="stylesheet" type="text/css" href="style/fontawesome.css">
    <link rel="stylesheet" type="text/css" href="style/calendar.css">
    <link rel="stylesheet" type="text/css" href="style/popupwindow.css">
</head>

<body>
    <div id="container" class="wrapper">
        <header>
            
        </header>
        <nav>
            <ul>
                <li>
                    <a href="#">
                        <i class="fas fa-qrcode" aria-hidden="true"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                    <i class="far fa-calendar-alt" aria-hidden="true"></i>
                        <span>Календарь</span>
                    </a>
                </li>
                <li>
                    <a href="department.php">
                    <i class="fas fa-users" aria-hidden="true"></i>
                        <span>Сотрудники</span>
                    </a>
                </li>
                
                <li>
                    <a href="#">
                    <i class="far fa-copy" aria-hidden="true"></i>
                        <span>Отчеты</span>
                    </a>
                </li>
                <li>
                    <a href="help.php">
                        <i class="far fa-question-circle" aria-hidden="true"></i>
                        <span>Помощь</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                    <i class="fas fa-info-circle" aria-hidden="true"></i>
                        <span>О нас</span>
                    </a>
                </li>
                <li>
                    <a href="index.htm">
                    <i class="fas fa-door-open" aria-hidden="true"></i>
                        <span>Выход</span>
                    </a>
                </li>
            </ul>
        </nav>
        <main>
            <div class="tableschedule">
                <div class="schedule-box">
                    <div class="schedule-box-content">
                        <?php
                            include 'time_worker.php';
                            $week_time_worker = new time_worker;
                            $dt = new DateTime;
                            $dt = $week_time_worker->get_start_week();
        
                            $year = $dt->format('o');
                            $week = $dt->format('W');
                        ?>
                        <a href="<?php echo $_SERVER['PHP_SELF'].'?week='.($week-1).'&year='.$year; ?>" class="pr"><i class="fas fa-angle-left"></i></a>
                        <span class="title">
                            <?php
                                $dt_endweek = new DateTime;
                                $dt_endweek = $week_time_worker->get_end_week();
                                echo $dt->format('l') . ' ' . $dt->format('d M Y') . '-' . $dt_endweek->format('l') . ' ' . $dt_endweek->format('d M Y');
                            ?>
                        </span>
                        <a href="<?php echo $_SERVER['PHP_SELF'].'?week='.($week+1).'&year='.$year; ?>" class="n"><i class="fas fa-angle-right"></i></a>
                    </div>
                </div>
                <div class="switchbtns">
                    <input type="submit" class="schedule-day" value="День">
                    <input type="submit" class="schedule-week" value="Неделя">
                    <input type="submit" class="schedule-today" value="Сегодня">
                </div>
            </div>
            <table style="width:100%">
                <tr>
                    <th>ФИО</th>
                    <th>ПН</th>
                    <th>ВТ</th>
                    <th>СР</th>
                    <th>ЧТ</th>
                    <th>ПТ</th>
                    <th class = "th_weekend">СБ</th>
                    <th class = "th_weekend">ВС</th>
                </tr>
                <?php
                    //начало и конец недели для запросов в БД
                    $_SESSION['start_week'] = $dt;
                    $_SESSION['end_week'] = $dt_endweek;
                    //--------------

                    //вызов емплоей - по сути гет в таблицу по юзерам ОТДЕЛА деп_кей
                    include 'employee.php';
                    //тут будет ООП по всему расчету дней и графиков для упрощения мейн
                    include 'scheduleOutput.php';

                    $result_dep = array();
                    $custId_ar = array();
                    $dep = new Credential($_SESSION['dep_key']);
                    $result_dep = $dep->sql_query_dep();
                    //--------------

                    //цикл по юзверям
                    for($i=0; $i< count($result_dep); $i++){
                        //тут мы мередаем рутайди юзера в сессию чтобы отдать на запрос БД в кал_тейбл_гет.пхп
                        $_SESSION['ruid'] = $result_dep[$i]['r_uid'];
                        //--------------

                        //функция запроса в БД на время работы юзвере
                        require 'cal_table_get.php';
                        //--------------

                        //это ВСЕ данные юзверя из root получаются через employee.php
                        $custId_ar[$i] = $result_dep[$i]['r_uid'];
                        //--------------

                        //это по идее надо убирать в класс в формирование начала-конца недели + разные виды форматирования(я временем и без)
                        $dt_user = $week_time_worker->get_start_week();//clone($dt);

                        $tmp_start_week_now_ = $week_time_worker->Ymd_STweek_YMD_HI();
                        $tmp_start_week_now_tmp_second_suka = new DateTime($week_time_worker->Ymd_STweek_YMD());

                        $tmp_end_week_now_tmp_second_suka = new DateTime;
                        $tmp_end_week_now_tmp_second_suka = $week_time_worker->Ymd_ENweek_YMD();
                        //--------------

                        //тут отрисовка таблицы ФИО с кнопками и запросом в БД
                        echo '<tr>';
                        echo '<td class = "td_fio"><form method = "POST" action="userpage.php"><input type="hidden" name="custId" value="'.$result_dep[$i]['account'].'"><input type="hidden" name="lname" value="'.$result_dep[$i]['name'].'" readonly="readonly"><input type="submit" class="b_main_name" value="'.$result_dep[$i]['name'].'"></form></td>';
                        //--------------
                        if(count($uniqueData)>0){
                            //СУКА!!!!!!
                            //цикл по дням недели
                            $myResultArray = array_fill(0, 7, '');
                            for ($k=0; $k < 7; $k++) { 
                                $seconDate = clone($dt_user);
                                $temp_dt_form = clone($dt_user);
                                $class_deflt = 'b_main_time';
                                $working_hours = '';

                                if($k > 1){
                                    $seconDate = $seconDate->modify('+'.$k.' days')->format('Y-m-d');
                                    $temp_dt_form = $temp_dt_form->modify('+'.$k.' days')->format('Y-m-d\TH:i');
                                } else {
                                    $seconDate = $seconDate->modify('+'.$k.' day')->format('Y-m-d');
                                    $temp_dt_form = $temp_dt_form->modify('+'.$k.' day')->format('Y-m-d\TH:i');
                                }
                                $temp_cellDate = new DateTime($seconDate);

                                for ($j=0; $j < count($uniqueData); $j++) { 
                                    //СУКА!!!!!!
                                    //соот. это все перегонки дат в разные форматы, часто повторяются в логике ниже - однозначно вынос в функции
                                    $startDateFromdb = $uniqueData[$j]['start_date'];
                                    $endDateFromdb = $uniqueData[$j]['end_date'];

                                    $temp_startDate = $week_time_worker->transform_date_Ymd_DB($startDateFromdb);
                                    $temp_endDate = $week_time_worker->transform_date_Ymd_DB($endDateFromdb);

                                    //free graph with g_uid = 1
                                    
                                    if($uniqueData[$j]['g_uid'] == '1'){
                                        
                                        $temp_firstCompare =  $week_time_worker->transform_date_Ymd_Hi_DB($startDateFromdb);
                                        $temp_secondCompare = $week_time_worker->transform_date_Ymd_Hi_DB($endDateFromdb);
                                        
                                        $intervalDiff = $temp_secondCompare->diff($temp_firstCompare);
                                        $hours = $intervalDiff->format('%H');
                                        $days_to = $intervalDiff->format('%a');
                                        $hoursDiff = $days_to * 24 + $hours; 
                                        //тут логика расчета свободных дней
                                        //по сути описаны все ситуации на графике, убрать в отдельную функцию, частично применять для других графиков
                                        //СУКА!!!!!!
                                        if(($temp_cellDate == $temp_startDate) && ($hoursDiff < 24)){
                                            if($temp_startDate == $temp_endDate){
                                                $myResultArray[$k] = $hoursDiff;
                                            } elseif ($temp_startDate <= $temp_endDate) {
                                                $startPoint=$temp_firstCompare->format('H'); //little bit of PHPHPHPH magick here
                                                $customPoint = 24 - $startPoint;
                                                $myResultArray[$k] = $customPoint;
                                            } else {
                                                $myResultArray[$k] = 0;
                                            }
                                            $class_deflt = 'b_main_time_work';
                                            continue;
                                        }
                                        if (($temp_cellDate == $temp_endDate) && ($hoursDiff < 24)){
                                            $startPoint=$temp_secondCompare->format('H') - 0; //and here MAGIC PIZDES
                                            $myResultArray[$k] = $startPoint;
                                            $class_deflt = 'b_main_time_work';
                                            continue;
                                        } elseif (($temp_startDate < $tmp_start_week_now_tmp_second_suka) && ($tmp_start_week_now_tmp_second_suka == $temp_cellDate) && ($hoursDiff >= 24)){
                                            $tmp_start_week_now_compare = new DateTime;
                                            $tmp_start_week_now_compare = $week_time_worker->transform_date_Ymd_0000_DB($tmp_start_week_now_);

                                            $tmp_diff_all = $temp_secondCompare->diff($tmp_start_week_now_compare);
                                            $tmp_diff_hours = $tmp_diff_all->format('%H');
                                            $tmp_diff_days = $tmp_diff_all->format('%a');
                                            $z = $k;
                                            if($tmp_diff_days > 0){
                                                while($tmp_diff_days > 0){
                                                    $myResultArray[$z] = 24;
                                                    $tmp_diff_days = $tmp_diff_days - 1;
                                                    $z++;
                                                }
                                            }
                                            $myResultArray[$z] = $tmp_diff_hours;
                                            $class_deflt = 'b_main_time_warning';
                                            continue;
                                            
                                        } elseif (($temp_cellDate == $temp_startDate) && ($hoursDiff >= 24)) {
                                            if($tmp_end_week_now_tmp_second_suka != $temp_cellDate){
                                                $z = $k;
                                                $startPoint=$temp_firstCompare->format('H'); //little bit of PHPHPHPH magick here
                                                $customPoint = 24 - $startPoint;
                                                $myResultArray[$k] = $customPoint;
                                                $hoursDiff = $hoursDiff - $customPoint;
                                                while($hoursDiff > 24){
                                                    $z++;
                                                    $customPoint = 24;
                                                    $myResultArray[$z] = $customPoint;
                                                    $hoursDiff = $hoursDiff - 24;
                                                }
                                                $z++;
                                                $myResultArray[$z]= $hoursDiff;
                                            } else {
                                                $startPoint=$temp_firstCompare->format('H'); //and here
                                                $customPoint = 24 - $startPoint;
                                                $myResultArray[$k] = $customPoint;
                                            }
                                            $class_deflt = 'b_main_time_work';
                                            continue;
                                        }
                                    }// end free graph
                                    
                                    //fiveday graph g_uid = 1 (after WARNING)
                                    if($uniqueData[$j]['g_uid'] == '1' && ($temp_cellDate >= $temp_startDate) && ($temp_cellDate <= $temp_endDate)){
                                        $dayOfWeek = $temp_cellDate->format('l');
                                        $class_deflt = 'b_main_time_work';
                                    }

                                    //weekend graph g_uid = 3
                                    if($uniqueData[$j]['g_uid'] == '3' && ($temp_cellDate >= $temp_startDate) && ($temp_cellDate <= $temp_endDate)){
                                        $class_deflt = 'b_main_time_weekend';
                                        $myResultArray[$k] = '';
                                    }

                                    //fiveday graph g_uid = 5
                                    if($uniqueData[$j]['g_uid'] == '5' && ($temp_cellDate >= $temp_startDate) && ($temp_cellDate <= $temp_endDate)){
                                        $dayOfWeek = $temp_cellDate->format('l');
                                        if($dayOfWeek == 'Sunday'||$dayOfWeek =='Saturday'){
                                            $class_deflt = 'b_main_time_weekend';
                                            $myResultArray[$k] = '';
                                        }else{
                                            $class_deflt = 'b_main_time_FiveDay_10hrs';
                                            $myResultArray[$k] = 8;
                                        }
                                    }

                                    //fiveday graph g_uid = 6
                                    if($uniqueData[$j]['g_uid'] == '6' && ($temp_cellDate >= $temp_startDate) && ($temp_cellDate <= $temp_endDate)){
                                        $dayOfWeek = $temp_cellDate->format('l');
                                        if($dayOfWeek == 'Sunday'||$dayOfWeek =='Saturday'){
                                            $class_deflt = 'b_main_time_weekend';
                                            $myResultArray[$k] = '';
                                        }else{
                                            $class_deflt = 'b_main_time_FiveDay_9hrs';
                                            $myResultArray[$k] = 8;
                                        }
                                    }

                                    //fiveday graph g_uid = 7
                                    if($uniqueData[$j]['g_uid'] == '7' && ($temp_cellDate >= $temp_startDate) && ($temp_cellDate <= $temp_endDate)){
                                        $dayOfWeek = $temp_cellDate->format('l');
                                        if($dayOfWeek == 'Sunday'||$dayOfWeek =='Saturday'){
                                            $class_deflt = 'b_main_time_weekend';
                                            $myResultArray[$k] = '';
                                        }else{
                                            $class_deflt = 'b_main_time_FiveDay_11hrs';
                                            $myResultArray[$k] = 8;
                                        }
                                    }

                                    //fiveday graph g_uid = 8
                                    if($uniqueData[$j]['g_uid'] == '8' && ($temp_cellDate >= $temp_startDate) && ($temp_cellDate <= $temp_endDate)){
                                        $dayOfWeek = $temp_cellDate->format('l');
                                        if($dayOfWeek == 'Sunday'||$dayOfWeek =='Saturday'){
                                            $class_deflt = 'b_main_time_weekend';
                                            $myResultArray[$k] = '';
                                        } else {
                                            $class_deflt = 'b_main_time_FiveDay_6hrs';
                                            $myResultArray[$k] = 8;
                                        }
                                    }

                                    //fiveday graph g_uid = 9
                                    if($uniqueData[$j]['g_uid'] == '9' && ($temp_cellDate >= $temp_startDate) && ($temp_cellDate <= $temp_endDate)){
                                        $dayOfWeek = $temp_cellDate->format('l');
                                        if($dayOfWeek == 'Sunday'||$dayOfWeek =='Monday'){
                                            $class_deflt = 'b_main_time_weekend';
                                            $myResultArray[$k] = '';
                                        } else {
                                            $class_deflt = 'b_main_time_FiveDay_tue_10hrs';
                                            $myResultArray[$k] = 8;
                                        }
                                    }

                                    //fiveday graph g_uid = 10
                                    if($uniqueData[$j]['g_uid'] == '10' && ($temp_cellDate >= $temp_startDate) && ($temp_cellDate <= $temp_endDate)){
                                        $dayOfWeek = $temp_cellDate->format('l');
                                        if($dayOfWeek == 'Tuesday'||$dayOfWeek =='Saturday'){
                                            $class_deflt = 'b_main_time_weekend';
                                            $myResultArray[$k] = '';
                                        } else {
                                            $class_deflt = 'b_main_time_FiveDay_wed_saturd_10hrs';
                                            $myResultArray[$k] = 8;
                                        }
                                    }
                                    if($uniqueData[$j]['g_uid'] == '11' && ($temp_cellDate >= $temp_startDate) && ($temp_cellDate <= $temp_endDate)){
                                        $class_deflt = 'b_main_time_vacation';
                                        $myResultArray[$k] = '';
                                    }
                                }
                                //--------------
                                //тут мы в зависимости от числа часов и GUID выбераем тему(цвет) дня
                                if($myResultArray[$k] >= 24){
                                    if($uniqueData[$j]['g_uid'] == '3'){ 
                                        $class_deflt = 'b_main_time_weekend';
                                    }
                                    if($uniqueData[$j]['g_uid'] == '11'){
                                        $class_deflt = 'b_main_time_vacation';
                                    }
                                    else {
                                        $class_deflt = 'b_main_time_warning';
                                    }
                                }
                                if($myResultArray[$k] < 24){
                                    if($uniqueData[$j]['g_uid'] == '1'){
                                        $class_deflt = 'b_main_time_work';
                                    }
                                    if($uniqueData[$j]['g_uid'] == '3'){ 
                                        $class_deflt = 'b_main_time_weekend';
                                    }
                                    if($uniqueData[$j]['g_uid'] == '5'){
                                        $class_deflt = 'b_main_time_FiveDay_10hrs';
                                    }
                                    if($uniqueData[$j]['g_uid'] == '6'){
                                        $class_deflt = 'b_main_time_FiveDay_9hrs';
                                    }
                                    if($uniqueData[$j]['g_uid'] == '7'){
                                        $class_deflt = 'b_main_time_FiveDay_11hrs';
                                    }
                                    if($uniqueData[$j]['g_uid'] == '8'){
                                        $class_deflt = 'b_main_time_FiveDay_6hrs';
                                    }
                                    if($uniqueData[$j]['g_uid'] == '9'){
                                        $class_deflt = 'b_main_time_FiveDay_tue_10hrs';
                                    }
                                    if($uniqueData[$j]['g_uid'] == '10'){
                                        $class_deflt = 'b_main_time_FiveDay_wed_saturd_10hrs';
                                    }
                                    if($uniqueData[$j]['g_uid'] == '11'){
                                        $class_deflt = 'b_main_time_vacation';
                                    }
                                }
                                //отрисовка
                                echo '<td><input type="submit" id="myBtn" class="'.$class_deflt.'" onclick="printId('.$custId_ar[$i].', `'.$temp_dt_form.'`, `'.$temp_dt_form.'`)" value="'.$myResultArray[$k].'"></td>';
                                //--------------
                            }
                        //если в запросе из БД время нет нихуя то просто ресуем табличку с днями с прозрачной темой
                        }else{
                            for ($k=0; $k < 7; $k++) { 
                                $temp_dt_form = clone($dt_user);
                                $class_deflt = 'b_main_time';
                                if($k > 1){
                                    $temp_dt_form = $temp_dt_form->modify('+'.$k.' days')->format('Y-m-d\TH:i');
                                }else{
                                    $temp_dt_form = $temp_dt_form->modify('+'.$k.' day')->format('Y-m-d\TH:i');
                                }
                                echo '<td><input type="submit" id="myBtn" class="'.$class_deflt.'" onclick="printId('.$custId_ar[$i].', `'.$temp_dt_form.'`, `'.$temp_dt_form.'`)" value=""></td>';
                            }
                        }
                        echo '</tr>';
                    }
                    //--------------
                ?>
            </table>
        </main>
        <aside>
            <?php
                include 'calendar.php';
                $calendar = new Calendar();
                echo $calendar->show();
		    ?>
        </aside>
    </div>


    <!-- The Modal -->
    <div id="myModal" class="modal">
        
        <form class="modal-content" action="cal_table_funk.php" method="POST">
        
        <span class="close">&times;</span>
            <fieldset id="graphs">
                <legend>График работы</legend>
                <table border="5px" width="100%">
                <tr>
                        <td><label for="user_id">ID <em>*</em></label></td>
                        <td><input type="text" name="user_id" id="user_id" required readonly></td>
                    </tr>
                    <tr>
                        <td><label for="graphType">Тип графика <em>*</em></label></td>
                        <td>
                            <select id="graphType" required name="graph_type">
                                <option value="1">Свободный</option>
                                <option value="3">Выходной</option>
                                <option value="5">Пятидневка Тип 1</option>
                                <option value="6">Пятидневка Тип 2</option>
                                <option value="7">Пятидневка Тип 3</option>
                                <option value="8">Пятидневка Тип 4</option>
                                <option value="9">Пятидневка Тип 5</option>
                                <option value="10">Пятидневка Тип 6</option>
                                <option value="11">Отпуск</option>
                                <option value="12">Удаление</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="startTime">Начало <em>*</em></label></td>
                        <td><input type="datetime-local" name="startTime" id="startTime" value = "" required></td>
                    </tr>
                    <tr>
                        <td><label for="endTime">Окончание <em>*</em></label></td>
                        <td><input type="datetime-local" name="endTime" id="endTime" value = "" required></td>
                    </tr> 
                </table>
            </fieldset>
            <!-- <fieldset id="advanced">
                <legend>Дополнительные параметры</legend>
                <table border="5px" width="100%">
                    <tr>
                        <td><label for="repeatField">Повтор графика <em>*</em></label></td>
                        <td>
                            <select id="repeatField" required>
                                <option value="nonrepeat">неповторяющийся</option>
                                <option value="daily">день</option>
                                <option value="weekly">неделя</option>
                                <option value="monthly">месяц</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="repeatEvery">Повторять <em>*</em></label></td>
                        <td><input type="number" id="repeatEvery" required></td>
                    </tr>
                </table>
            </fieldset> -->
            <fieldset id="gInfo">
                <legend>Информация о графике</legend>
                <table border="5px" width="100%">
                    <tr>
                        <td><textarea id="graphInfoTextArea" class="graphInfo" readonly></textarea></td>
                    </tr>
                </table>
            </fieldset>
            <fieldset id="gButtons">
                <table border="5px" width="100%">
                    <tr>
                        <td colspan="2"><input type="submit" id="testRuid" value="Сохранить"></td>
                    </tr>
                </table>
            </fieldset>
        </form>
    </div>
    <script>
        // Get the modal
        let modal = document.getElementById("myModal");
        // Get the button that opens the modal
        let btnArray = document.querySelectorAll("[id='myBtn']");

        // Get the <span> element that closes the modal
        let span = document.getElementsByClassName("close")[0];

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
        modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        document.getElementById("graphType").addEventListener('change', function(e){
            let dateValue = new Date(document.getElementById("startTime").value);
            switch(e.target.value){
                case '1':
                    document.getElementById("graphInfoTextArea").value = "";
                    break;
                case '3':
                    document.getElementById("graphInfoTextArea").value = "Выходной";
                    document.getElementById("startTime").value = dateValue.getFullYear() + "-" + zeroAdd(dateValue.getMonth()+1) + "-" + zeroAdd(dateValue.getDate()) + "T" + "00" + ":" + "00";
                    document.getElementById("endTime").value = dateValue.getFullYear() + "-" + zeroAdd(dateValue.getMonth()+1) + "-" + zeroAdd(dateValue.getDate()) + "T" + "23" + ":" + "00";
                    break;
                case '5':
                    document.getElementById("graphInfoTextArea").value = "5-дневная рабочая неделя с выходными днями в субботу и воскресенье с 10.00 ч.";
                    document.getElementById("startTime").value = dateValue.getFullYear() + "-" + zeroAdd(dateValue.getMonth()+1) + "-" + zeroAdd(dateValue.getDate()) + "T" + "10" + ":" + "00";
                    document.getElementById("endTime").value = dateValue.getFullYear() + "-" + zeroAdd(dateValue.getMonth()+1) + "-" + zeroAdd(dateValue.getDate()) + "T" + "19" + ":" + "00";
                    break;
                case '6':
                    document.getElementById("graphInfoTextArea").value = "5-дневная рабочая неделя с выходными днями в субботу и воскресенье с 09.00 ч.";
                    document.getElementById("startTime").value = dateValue.getFullYear() + "-" + zeroAdd(dateValue.getMonth()+1) + "-" + zeroAdd(dateValue.getDate()) + "T" + "09" + ":" + "00";
                    document.getElementById("endTime").value = dateValue.getFullYear() + "-" + zeroAdd(dateValue.getMonth()+1) + "-" + zeroAdd(dateValue.getDate()) + "T" + "18" + ":" + "00";
                    break;
                case '7':
                    document.getElementById("graphInfoTextArea").value = "5-дневная рабочая неделя с выходными днями в субботу и воскресенье с 11.00 ч.";
                    document.getElementById("startTime").value = dateValue.getFullYear() + "-" + zeroAdd(dateValue.getMonth()+1) + "-" + zeroAdd(dateValue.getDate()) + "T" + "11" + ":" + "00";
                    document.getElementById("endTime").value = dateValue.getFullYear() + "-" + zeroAdd(dateValue.getMonth()+1) + "-" + zeroAdd(dateValue.getDate()) + "T" + "20" + ":" + "00";
                    break;
                case '8':
                    document.getElementById("graphInfoTextArea").value = "5-дневная рабочая неделя с выходными днями в субботу и воскресенье с 06.00 ч.";
                    document.getElementById("startTime").value = dateValue.getFullYear() + "-" + zeroAdd(dateValue.getMonth()+1) + "-" + zeroAdd(dateValue.getDate()) + "T" + "06" + ":" + "00";
                    document.getElementById("endTime").value = dateValue.getFullYear() + "-" + zeroAdd(dateValue.getMonth()+1) + "-" + zeroAdd(dateValue.getDate()) + "T" + "15" + ":" + "00";
                    break;
                case '9':
                    document.getElementById("graphInfoTextArea").value = "5-дневная рабочая неделя с выходными днями в понедельник и воскресенье";
                    document.getElementById("startTime").value = dateValue.getFullYear() + "-" + zeroAdd(dateValue.getMonth()+1) + "-" + zeroAdd(dateValue.getDate()) + "T" + "10" + ":" + "00";
                    document.getElementById("endTime").value = dateValue.getFullYear() + "-" + zeroAdd(dateValue.getMonth()+1) + "-" + zeroAdd(dateValue.getDate()) + "T" + "19" + ":" + "00";
                    break;
                case '10':
                    document.getElementById("graphInfoTextArea").value = "5-дневная рабочая неделя с выходными днями в среду и субботу";
                    document.getElementById("startTime").value = dateValue.getFullYear() + "-" + zeroAdd(dateValue.getMonth()+1) + "-" + zeroAdd(dateValue.getDate()) + "T" + "10" + ":" + "00";
                    document.getElementById("endTime").value = dateValue.getFullYear() + "-" + zeroAdd(dateValue.getMonth()+1) + "-" + zeroAdd(dateValue.getDate()) + "T" + "19" + ":" + "00";
                    break;
                case '11':
                    document.getElementById("graphInfoTextArea").value = "Отпуск";
                    document.getElementById("startTime").value = dateValue.getFullYear() + "-" + zeroAdd(dateValue.getMonth()+1) + "-" + zeroAdd(dateValue.getDate()) + "T" + "00" + ":" + "00";
                    document.getElementById("endTime").value = dateValue.getFullYear() + "-" + zeroAdd(dateValue.getMonth()+1) + "-" + zeroAdd(dateValue.getDate()) + "T" + "23" + ":" + "00";
                    break;
                case '12':
                    document.getElementById("graphInfoTextArea").value = "Отчищает выбранный промежуток";
                    document.getElementById("startTime").value = dateValue.getFullYear() + "-" + zeroAdd(dateValue.getMonth()+1) + "-" + zeroAdd(dateValue.getDate()) + "T" + "00" + ":" + "00";
                    document.getElementById("endTime").value = dateValue.getFullYear() + "-" + zeroAdd(dateValue.getMonth()+1) + "-" + zeroAdd(dateValue.getDate()) + "T" + "23" + ":" + "00";
                    break;
                    
            }
        });

        for(let i=0; i < btnArray.length; i++){
            btnArray[i].addEventListener('contextmenu', function(e){
            e.preventDefault();
            switch(btnArray[i].getAttribute("class")){
                case "b_main_time_weekend":
                    infoMsg("Выходной");
                    break;
                case "b_main_time_work":
                    infoMsg("Свободный");
                    break;
                case "b_main_time_warning":
                    infoMsg("Свободный");
                    break;
                case "b_main_time_FiveDay_10hrs":
                    infoMsg("5-дневная рабочая неделя с выходными днями в субботу и воскресенье с 10.00 ч.");
                    break;
                case "b_main_time_FiveDay_9hrs":
                    infoMsg("5-дневная рабочая неделя с выходными днями в субботу и воскресенье с 09.00 ч.");
                    break;
                case "b_main_time_FiveDay_11hrs":
                    infoMsg("5-дневная рабочая неделя с выходными днями в субботу и воскресенье с 11.00 ч.");
                    break;
                case "b_main_time_FiveDay_6hrs":
                    infoMsg("5-дневная рабочая неделя с выходными днями в субботу и воскресенье с 06.00 ч.");
                    break;
                case "b_main_time_FiveDay_tue_10hrs":
                    infoMsg("5-дневная рабочая неделя с выходными днями в понедельник и воскресенье");
                    break;
                case "b_main_time_FiveDay_wed_saturd_10hrs":
                    infoMsg("5-дневная рабочая неделя с выходными днями в среду и субботу");
                    break;
                case "b_main_time_vacation":
                    infoMsg("Отпуск");
                    break;

            }
            }, false);
        }
        
        // document.getElementById("graphType").addEventListener('change', function(e){
        //     if(e.target.value === 'freedom') document.getElementById("advanced").style.display = "block";
        //     else document.getElementById("advanced").style.display = "none";
        // });
        function printId(vasya,dtValue,dtValu2){
            modal.style.display = "block";
            document.getElementById("graphs").style.display = "block";
            document.getElementById("gButtons").style.display = "block";
            document.getElementById("graphInfoTextArea").value = "";
            document.querySelector('#graphType').getElementsByTagName('option')[0].selected = true;
            let myBtn = document.getElementById("user_id");
            let getElem = document.getElementById("startTime");
            let getElem2 = document.getElementById("endTime");
            myBtn.value = vasya;
            getElem.value = dtValue;
            getElem2.value = dtValu2;
        }

        function infoMsg(displayMSG){
            modal.style.display = "block";
            document.getElementById("graphs").style.display = "none";
            document.getElementById("gButtons").style.display = "none";
            document.getElementById("graphInfoTextArea").value = displayMSG;
        }
        function zeroAdd(val){
            if(val >= 10) return val;
            else return '0' + val;
        }
</script>
</body>
</html>

