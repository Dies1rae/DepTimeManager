<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <title>Shift schedule</title>
    <link rel="stylesheet" type="text/css" href="style/style.css">
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
                    <a href="#">
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
            </ul>
        </nav>
        <main></main>
        <aside>
            <?php
                include 'calendar.php';
                $calendar = new Calendar();
                echo $calendar->show();
		?>
        </aside>
    </div>
    <!-- <script>
        function openNavMenu(){
            document.getElementById("closeBtn").style.display = "block";
            document.getElementById("openBtn").style.display = "none";
            document.getElementById("mainMenu").style.width = "250px";
            let elemArray = document.querySelectorAll("a.menuBtn");
            for(let i = 0; i < elemArray.length; i++){
                elemArray[i].querySelector("span").style.display = "inline-bloke";
				elemArray[i].classList.remove("menuBtn");
			}
        }
        function closeNavMenu(){
            document.getElementById("closeBtn").style.display = "none";
            document.getElementById("openBtn").style.display = "block";
            document.getElementById("mainMenu").style.width = "75px";
            let elemArray = document.querySelectorAll("li>a");
            for(let i = 0; i < elemArray.length; i++){
                if(elemArray[i].id !== "closeBtn" && elemArray[i].id !== "openBtn"){
                    elemArray[i].querySelector("span").style.display = "";
                    elemArray[i].classList.add("menuBtn");
                }
			}
        }
    </script> -->
</body>
</html>
