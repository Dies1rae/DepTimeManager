<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <title>Department page</title>
    <link rel="stylesheet" type="text/css" href="style/schedulepage.css">
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
                        <span>Назад</span>
                    </a>
                </li> 
            </ul>
        </nav>
        <main>
        <a> SOME DATA</a>
        </main>

    </div>
</body>
<aside>
    <?php
        include 'calendar.php';
        $calendar = new Calendar();
        echo $calendar->show();
    ?>
</aside>
</html>
