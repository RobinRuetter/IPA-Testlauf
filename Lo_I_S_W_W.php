<?php
echo "es ist ein Fehler aufgetreten";
echo "<br>";
echo "Sie werden in 5 Sekunden weitergeleitet";
echo "<br>";
echo "geniesen Sie ein Bild von einem hübschen Otter während wir Sie abmelden";
echo "<br>";
echo "<img src='https://upload.wikimedia.org/wikipedia/commons/e/ee/Sea_otter.jpg' alt='Otter'>";
//delete session
session_start();
session_destroy();
//automacticly redirect to login.php after 5 seconds
header("refresh:5; url=login.php");
die();

?>