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
                <td class="td_fio">Свободный(Free)</td>
                <td class="td_fio">ID 1(Green - #728c69)</td>
            </tr>

            <tr>
                <td class="td_fio">Выходной(Weekend)</td>
                <td class="td_fio">ID 3(Blue - #052888)</td>
            </tr>

            <tr>
                <td class="td_fio">Отпуск(Vacation)</td>
                <td class="td_fio">ID 4(///)</td>
            </tr>

            <tr>
                <td class="td_fio">Стандартная пятидневка СБ\ВС(FiveDay_10hrs)</td>
                <td class="td_fio">ID 5(///)</td>
            </tr>

            <tr>
                <td class="td_fio">Пятидневка с 9 утра СБ\ВС(FiveDay_9hrs)</td>
                <td class="td_fio">ID 6(///)</td>
            </tr>

            <tr>
                <td class="td_fio">Пятидневка с 11 утра СБ\ВС(FiveDay_11hrs)</td>
                <td class="td_fio">ID 7(///)</td>
            </tr>

            <tr>
                <td class="td_fio">Пятидневка с 6 утра СБ\ВС(FiveDay_6hrs)</td>
                <td class="td_fio">ID 8(///)</td>
            </tr>

            <tr>
                <td class="td_fio">Пятидневка с 10 утра ПН\ВС(FiveDay_tue_10hrs)</td>
                <td class="td_fio">ID 9(///)</td>
            </tr>

            <tr>
                <td class="td_fio">Пятидневка с 10 утра СР\СБ(FiveDay_wed_saturd_10hrs)</td>
                <td class="td_fio">ID 10(///)</td>
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
