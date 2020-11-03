<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <title>Department page</title>
    <link rel="stylesheet" type="text/css" href="style/schedulepage.css">
    <link rel="stylesheet" type="text/css" href="style/department_page.css">
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
                    <a href="main.php">
                        <i class="far fa-arrow-alt-circle-left"></i>
                        <span>Дашборд</span>
                    </a>
                </li> 
            </ul>
        </nav>
        <main>
        <?php
            session_start();
            include 'employee.php';
            $result_dep = array();
            $dep = new Credential($_SESSION['dep_key']);
            $result_dep = $dep->sql_query_dep();
            echo '<div id = "multipleuserlayout">';
            for($i=0; $i< count($result_dep); $i++){
                echo '<form method = "POST" action="userpage.php">';
                    echo '<div id = "singleuserlayout">';
                        echo'<img id="userpic" src="'.$result_dep[$i]['photo'].'">';
                        $NAME_ARR = explode(' ',trim($result_dep[$i]['name']));
                        echo '<input type="hidden" name="custId" value="'.$result_dep[$i]['account'].'"><input type="hidden" name="lname" value="'.$result_dep[$i]['name'].'" readonly="readonly"><input type="submit" class="b_department_name" value="'.$NAME_ARR[0].'">';
                    echo '</div>';
                echo '</form>';
            }
            echo '</div>';
        ?>
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
