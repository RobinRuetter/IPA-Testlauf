<?php
//delete session
session_start();
session_destroy();
//automacticly redirect to index.php
header("Location: index.php");
?>