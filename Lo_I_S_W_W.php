<?php
echo "es ist ein Fehler aufgetreten";
echo "<br>";
echo "Sie werden in 5 Sekunden weitergeleitet";
echo "<br>";
echo "geniesen Sie ein Bild von einem hübschen Otter während wir Sie abmelden";
echo "<br>";
echo "<img src=\"https://th.bing.com/th?id=ABTE090A2D04140E39D6FAE428D9A0661D58E65496A87392F02AA6B89CD7E92AA71&w=608&h=200&c=2&rs=1&o=6&dpr=1.3&pid=SANGAM\" alt=\"error 404 Sie sind nicht mit dem Internet verbunden\">";
//delete session
session_start();
session_destroy();
//automacticly redirect to login.php after 5 seconds
header("refresh:5; url=login.php");
die();

?>