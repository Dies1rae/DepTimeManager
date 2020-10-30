<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <title>Employer page</title>
    <link rel="stylesheet" type="text/css" href="style/style_userpage.css">
    <link rel="stylesheet" type="text/css" href="style/solid.css">
    <link rel="stylesheet" type="text/css" href="style/regular.css">
    <link rel="stylesheet" type="text/css" href="style/fontawesome.css">
    <link rel="stylesheet" type="text/css" href="style/calendar.css">
</head>
<body>
    <div id="container" class="wrapper">
        <header>
            
        </header>
        <nav>
            <ul>
                <li>
                    <a class="no_click" pointer-events: none; href="#">
                        <i class="fas fa-user-tie"></i>
                        <span>Ф.И.О</span>
                    </a>
                </li>
                <li>
                    <a class="no_click" href="#">
                        <i class="fas fa-address-card"></i>
                        <span>Должность</span>
                    </a>
                </li>
                <li>
                    <a class="no_click" href="#">
                    <i class="fas fa-users" aria-hidden="true"></i>
                        <span>Подразделение</span>
                    </a>
                </li>
                
                <li>
                    <a class="no_click" href="#">
                    <i class="fas fa-envelope"></i>
                        <span>Почтовый адрес</span>
                    </a>
                </li>
                <li>
                    <a class="no_click"  href="#">
                        <i class="fas fa-mobile"></i>
                        <span>Мобильный телефон</span>
                    </a>
                </li>
                <li>
                    <a class="no_click" href="#">
                        <i class="fas fa-phone-square"></i>
                        <span>Рабочий телефон</span>
                    </a>
                </li>
                <li>
                    <a href="department.php">
                        <i class="far fa-arrow-alt-circle-left"></i>
                        <span>Назад</span>
                    </a>
                </li> 
                <li>
                    <a href="main.php">
                        <i class="far fa-arrow-alt-circle-left"></i>
                        <span>Дашборд</span>
                    </a>
                </li> 
            </ul>
        </nav>
        <main>
            <img src="https://www.iconhot.com/icon/png/rrze/720/user-employee.png">
            <?php
            session_start();
            $_SESSION['account'] = $_POST['custId'];
            include 'employee.php';
            $result_acc = array();
            $acc = new Credential( $_SESSION['account']);
            $result_acc = $dep->sql_query_account();
            echo '<li>';
                echo '<a>';
                    echo '<span>'.$result_acc[0].'</span>';
                echo '</a>';
            echo '</li>';
            echo '<li>';
                echo '<a>';
                    echo '<span>'.$result_acc[1].'</span>';
                echo '</a>';
            echo '</li>';
            echo '<li>';
                echo '<a>';
                    echo '<span>'.$result_acc[2].'</span>';
                echo '</a>';
            echo '</li>';
            echo '<li>';
                echo '<a>';
                    echo '<span>'.$result_acc[3].'</span>';
                echo '</a>';
            echo '</li>';
            echo '<li>';
                echo '<a>';
                    echo '<span>'.$result_acc[4].'</span>';
                echo '</a>';
            echo '</li>';
            echo '<li>';
                echo '<a>';
                    echo '<span>'.$result_acc[5].'</span>';
                echo '</a>';
            echo '</li>';
            ?>
        </main>

    </div>
</body>
</html>
