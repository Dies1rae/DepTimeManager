# DepTimeManager
This is repo for web department time manager. Front: php, html5; Back: mysql and C\C++
<br>
<b>Web parts: </b><br>
1)Auth page <br>
2)Main page <br>
3)Department page<br>
4)Worker page<br>
5)Settings page <br>
<b>Back parts: </b><br>
1)Service for merge files with MYSQL base <br>
2)MYSQL base <br>
3)setting ini part <br>
//------------
<b>Back parts:</b><br>
  *1) service done, starts from root folder of program, init settings from .\settings.ini. Gets login/pass and address of SQL server and file with users data(*csv).
  Then load USdata to class *USER and in array *company, next clean each of USER data field from restricted chars like % / \ and others.
  Next sort in by LOGIN NAME. Next connect to SQL DB and drop root table, than create it with 0 data, next load all users from *company array. Next close all sql     connects, and copy *csv USData file to root with _bckp renaming. <b> TODO - property logging of every stage</b>
