<?php
session_start();
if(!isset($_SESSION['dep_key'])) {
    header('Location: /index.htm');
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <title>Help</title>
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
                    <a href="main.php">
                        <i class="far fa-arrow-alt-circle-left"></i>
                        <span>Дашборд</span>
                    </a>
                </li> 
            </ul>
        </nav>
        <main>
        <table style="width:100%">
            <tr>
                <th>Название графика</th>
                <th>Цветовое обозначение</th>
            </tr>

            <tr>
                <td class="td_fio">Свободный c 8:00 до 20:00(Free - Day)</td>
                <td class="td_fio" bgcolor="#728c69">ID 1(#728c69)</td>
            </tr>

            <tr>
                <td class="td_fio">Свободный c 20:00 до 08:00 (Free - Night)</td>
                <td class="td_fio" bgcolor="#3d4d38">ID 1(#728c69)</td>
            </tr>

            <tr>
                <td class="td_fio">Выходной(Weekend)</td>
                <td class="td_fio" bgcolor="#3399ffc0">ID 3(#3399ffc0)</td>
            </tr>

            <tr>
                <td class="td_fio">Отпуск(Vacation)</td>
                <td class="td_fio" bgcolor="#34495E">ID 4(#34495E)</td>
            </tr>

            <tr>
                <td class="td_fio">Стандартная пятидневка СБ\ВС(FiveDay_10hrs)</td>
                <td class="td_fio" bgcolor="#41a893c7">ID 5(#41a893c7)</td>
            </tr>

            <tr>
                <td class="td_fio">Пятидневка с 9 утра СБ\ВС(FiveDay_9hrs)</td>
                <td class="td_fio" bgcolor="#16A085">ID 6(#16A085)</td>
            </tr>

            <tr>
                <td class="td_fio">Пятидневка с 11 утра СБ\ВС(FiveDay_11hrs)</td>
                <td class="td_fio" bgcolor="#138D75">ID 7(#138D75)</td>
            </tr>

            <tr>
                <td class="td_fio">Пятидневка с 6 утра СБ\ВС(FiveDay_6hrs)</td>
                <td class="td_fio" bgcolor="#117A65">ID 8(#117A65)</td>
            </tr>

            <tr>
                <td class="td_fio">Пятидневка с 10 утра ПН\ВС(FiveDay_tue_10hrs)</td>
                <td class="td_fio" bgcolor="#0E6655">ID 9(#0E6655)</td>
            </tr>

            <tr>
                <td class="td_fio">Пятидневка с 10 утра СР\СБ(FiveDay_wed_saturd_10hrs)</td>
                <td class="td_fio" bgcolor="#0B5345">ID 10(#0B5345)</td>
            </tr>

            <tr>
                <td class="td_fio">ВНИМАНИЕ(WARNING)</td>
                <td class="td_fio" bgcolor="#60100B">ID ~(#60100B)</td>
            </tr>
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
</body>
</html>
