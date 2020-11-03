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
                include 'employee.php';
                $result_dep = array();
                $dep = new Credential($_SESSION['dep_key']);
                $result_dep = $dep->sql_query_dep();
                for($i=0; $i< count($result_dep); $i++){
                    echo '<tr>';
                    echo '<td class = "td_fio"><form method = "POST" action="userpage.php"><input type="hidden" name="custId" value="'.$result_dep[$i]['account'].'"><input type="hidden" name="lname" value="'.$result_dep[$i]['name'].'" readonly="readonly"><input type="submit" class="b_main_name" value="'.$result_dep[$i]['name'].'"></form></td>';
                    echo '<td><input type="submit" id="myBtn" class="b_main_time" value="+"></td>';
                    echo '<td><input type="submit" id="myBtn" class="b_main_time" value="+"></td>';
                    echo '<td><input type="submit" id="myBtn" class="b_main_time" value="+"></td>';
                    echo '<td><input type="submit" id="myBtn" class="b_main_time" value="+"></td>';
                    echo '<td><input type="submit" id="myBtn" class="b_main_time" value="+"></td>';
                    echo '<td><input type="submit" id="myBtn" class="b_main_time" value="+"></td>';
                    echo '<td><input type="submit" id="myBtn" class="b_main_time" value="+"></td>';
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
       
        <form class="modal-content">
        <span class="close">&times;</span>
            <fieldset>
                <legend>График работы</legend>
                <table border="5px" width="100%">
                    <tr>
                        <td><label for="graphType">Тип графика <em>*</em></label></td>
                        <td><input type="text" id="graphType" required></td>
                    </tr>
                    <tr>
                        <td><label for="graphHours">Часы <em>*</em></label></td>
                        <td><input type="text" id="graphHours" required></td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="reset" value="Очистить форму"><input type="submit" value="Отправить запрос"></td>
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
        for (let i = 0; i <btnArray.length; i++) {
            // let btn = document.getElementById("myBtn");
            btnArray[i].onclick = function() {
            modal.style.display = "block";
            }
        }

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
</script>
</body>
</html>
