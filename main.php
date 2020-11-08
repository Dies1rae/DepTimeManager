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
                    include 'cal_table_get.php';   
                    include 'employee.php';
                    $result_dep = array();
                    $custId_ar = array();
                    $dep = new Credential($_SESSION['dep_key']);
                    $result_dep = $dep->sql_query_dep();
                    for($i=0; $i< count($result_dep); $i++){
                        $custId_ar[$i] = $result_dep[$i]['r_uid'];
                        $dt_user = clone($dt);
                        echo '<tr>';
                        echo '<td class = "td_fio"><form method = "POST" action="userpage.php"><input type="hidden" name="custId" value="'.$result_dep[$i]['account'].'"><input type="hidden" name="lname" value="'.$result_dep[$i]['name'].'" readonly="readonly"><input type="submit" class="b_main_name" value="'.$result_dep[$i]['name'].'"></form></td>';
                        echo '<td><input type="submit" id="myBtn" class="b_main_time" onclick="printId('.$custId_ar[$i].', `'.$dt_user->format('Y-m-d\TH:i').'`)" value=""></td>';
                        echo '<td><input type="submit" id="myBtn" class="b_main_time" onclick="printId('.$custId_ar[$i].', `'.$dt_user->modify('+1 day')->format('Y-m-d\TH:i').'`)" value=""></td>';
                        echo '<td><input type="submit" id="myBtn" class="b_main_time" onclick="printId('.$custId_ar[$i].', `'.$dt_user->modify('+1 day')->format('Y-m-d\TH:i').'`)" value=""></td>';
                        echo '<td><input type="submit" id="myBtn" class="b_main_time" onclick="printId('.$custId_ar[$i].', `'.$dt_user->modify('+1 day')->format('Y-m-d\TH:i').'`)" value=""></td>';
                        echo '<td><input type="submit" id="myBtn" class="b_main_time" onclick="printId('.$custId_ar[$i].', `'.$dt_user->modify('+1 day')->format('Y-m-d\TH:i').'`)" value=""></td>';
                        echo '<td><input type="submit" id="myBtn" class="b_main_time" onclick="printId('.$custId_ar[$i].', `'.$dt_user->modify('+1 day')->format('Y-m-d\TH:i').'`)" value=""></td>';
                        echo '<td><input type="submit" id="myBtn" class="b_main_time" onclick="printId('.$custId_ar[$i].', `'.$dt_user->modify('+1 day')->format('Y-m-d\TH:i').'`)" value=""></td>';
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
                                <option value="five" selected>Пятидневка</option>
                                <option value="1">Свободный</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="startTime">Начало <em>*</em></label></td>
                        <td><input type="datetime-local" name="startTime" id="startTime" value = "" required></td>
                    </tr>
                    <!-- <tr style="display: none;">
                        <td><label for="endTime">Окончание <em>*</em></label></td>
                        <td><input type="datetime-local" id="endTime" required></td>
                    </tr> -->
                    <tr>
                        <td><label for="graphHours">Часы <em>*</em></label></td>
                        <td><input type="number" name="graphHours" id="graphHours" required></td>
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

