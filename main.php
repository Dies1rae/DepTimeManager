<?php
session_start();
if(!session_id() || session_status() !== PHP_SESSION_ACTIVE) {
    header('Location: index.htm');
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
                    <a href="#">
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
                            $dt = new DateTime;
                            if (isset($_GET['year']) && isset($_GET['week'])) {
                                $dt->setISODate($_GET['year'], $_GET['week']);
                            } else {
                                $dt->setISODate($dt->format('o'), $dt->format('W'));
                            }
                            $year = $dt->format('o');
                            $week = $dt->format('W');
                        ?>
                        <a href="<?php echo $_SERVER['PHP_SELF'].'?week='.($week-1).'&year='.$year; ?>" class="pr"><i class="fas fa-angle-left"></i></a>
                        <span class="title">
                            <?php
                                $dt_endweek = clone($dt);
                                $dt_endweek ->modify('+6 days');
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
                    $_SESSION['start_week'] = $dt;
                    $_SESSION['end_week'] = $dt_endweek;

                    include 'employee.php';
                    $result_dep = array();
                    $custId_ar = array();
                    $dep = new Credential($_SESSION['dep_key']);
                    $result_dep = $dep->sql_query_dep();
                    for($i=0; $i< count($result_dep); $i++){
                        $_SESSION['ruid'] = $result_dep[$i]['r_uid'];
                        
                        require 'cal_table_get.php';
                        
                        $custId_ar[$i] = $result_dep[$i]['r_uid'];
                        $dt_user = clone($dt);
                        echo '<tr>';
                        echo '<td class = "td_fio"><form method = "POST" action="userpage.php"><input type="hidden" name="custId" value="'.$result_dep[$i]['account'].'"><input type="hidden" name="lname" value="'.$result_dep[$i]['name'].'" readonly="readonly"><input type="submit" class="b_main_name" value="'.$result_dep[$i]['name'].'"></form></td>';
                        
                        if(count($uniqueData)>0){
                            
                            for ($k=0; $k < 7; $k++) { 
                                $seconDate = clone($dt_user);
                                $temp_dt_form = clone($dt_user);
                                $class_deflt = 'b_main_time';
                                $working_hours = '';
                                if($k > 1){
                                    $seconDate = $seconDate->modify('+'.$k.' days')->format('Y-m-d');
                                    $temp_dt_form = $temp_dt_form->modify('+'.$k.' days')->format('Y-m-d\TH:i');
                                }else{
                                    $seconDate = $seconDate->modify('+'.$k.' day')->format('Y-m-d');
                                    $temp_dt_form = $temp_dt_form->modify('+'.$k.' days')->format('Y-m-d\TH:i');
                                }
                                
                                $temp_cellDate = new DateTime($seconDate);
                                for ($j=0; $j < count($uniqueData); $j++) { 
                                   
                                    $startDateFromdb = $uniqueData[$j]['start_date'];
                                    $endDateFromdb = $uniqueData[$j]['end_date'];
                                    $firstDate = date('Y-m-d', strtotime(substr($startDateFromdb, 0, 10)));
                                    $startCompareValue = date('Y-m-d H:i', strtotime(substr($startDateFromdb, 0, 16)));
                                    $endCompareValue = date('Y-m-d H:i', strtotime(substr($endDateFromdb, 0, 16)));
                                    $temp_startDate = new DateTime($firstDate);
                                    $temp_firstCompare = new DateTime($startCompareValue);
                                    $temp_secondCompare = new DateTime($endCompareValue);
                                    $intervalDiff = $temp_secondCompare->diff($temp_firstCompare);
                                    $hours = $intervalDiff->format('%H');
                                    $days_to = $intervalDiff->format('%a');
                                    $hoursDiff = $days_to * 24 + $hours;

                                    if(($temp_cellDate == $temp_startDate) && ($hoursDiff < 24)){
                                        $class_deflt = 'b_main_time_work';
                                        $working_hours = $hoursDiff;
                                        break 1;
                                    }
                                    elseif (($temp_cellDate == $temp_startDate) && ($hoursDiff > 24)) {
                                        $class_deflt = 'b_main_time_warning';
                                        $working_hours = $hoursDiff;
                                        break 1;
                                    }
                                }
                                echo '<td><input type="submit" id="myBtn" class="'.$class_deflt.'" onclick="printId('.$custId_ar[$i].', `'.$temp_dt_form.'`, `'.$temp_dt_form.'`)" value="'.$working_hours.'"></td>';
                            }
                        }else{
                            for ($k=0; $k < 7; $k++) { 
                                $temp_dt_form = clone($dt_user);
                                $class_deflt = 'b_main_time';
                                if($k > 1){
                                    $temp_dt_form = $temp_dt_form->modify('+'.$k.' days')->format('Y-m-d\TH:i');
                                }else{
                                    $temp_dt_form = $temp_dt_form->modify('+'.$k.' days')->format('Y-m-d\TH:i');
                                }
                                echo '<td><input type="submit" id="myBtn" class="'.$class_deflt.'" onclick="printId('.$custId_ar[$i].', `'.$temp_dt_form.'`, `'.$temp_dt_form.'`)" value=""></td>';
                            }
                        }
                        echo '</tr>';
                    }
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
            <fieldset>
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
                                <option value="five">Пятидневка</option>
                                <option value="1" selected>Свободный</option>
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
                    <!-- <tr>
                        <td><label for="graphHours">Часы <em>*</em></label></td>
                        <td><input type="number" name="graphHours" id="graphHours" required></td>
                    </tr> -->
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
            <fieldset>
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
        // for (let i = 0; i <btnArray.length; i++) {
        //     btnArray[i].onclick = function() {
        //     modal.style.display = "block";
            
        //     }
        // }

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
        
        // document.getElementById("graphType").addEventListener('change', function(e){
        //     if(e.target.value === 'freedom') document.getElementById("advanced").style.display = "block";
        //     else document.getElementById("advanced").style.display = "none";
        // });
        function printId(vasya,dtValue){
            modal.style.display = "block";
            let myBtn = document.getElementById("user_id");
            let getElem = document.getElementById("startTime");
            myBtn.value = vasya;
            getElem.value = dtValue;
        }
        
</script>
</body>
</html>

