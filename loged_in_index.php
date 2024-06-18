<!DOCTYPE html>
<html lang="de">
<html>
    <?php 
    //conect to db
    include ('include.php');
    ?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="colors.css">
    
</head>
<body>
    <?php
    //verify sesion created in after_login.php
    session_start();
    if (isset($_SESSION['loggedin']) && ($_SESSION['loggedin'] == true)){
        
    }else{
    echo "Sie sind nicht eingeloggt";
    echo "<br>";
    //redirect to login page after 5 seconds
    header("refresh:5; url=Lo_I_S_W_W.php");
    echo "Sie werden in 5 Sekunden weitergeleitet";
    die();
    
    }
    
    /*
    
    disused code
    
    //check if sesion exists
    if (!isset($_SESSION['loggedin'])){
        echo "Sie sind nicht eingeloggt. Sie werden in 5 Sekunden weitergeleitet.";
        //redirect to login.php after 5 seconds
        header("refresh:5; url=login.php");
        exit;
    }
    //if session is true, do nothing
    if ($_SESSION['loggedin'] == true){
        
    }else{
        echo "Sie sind nicht eingeloggt. Sie werden in 5 Sekunden weitergeleitet.";
        //redirect to login.php after 5 seconds
        header("refresh:5; url=login.php");
        exit;
        
    }*/
    ?>
    <div id="header">
        <h1>News der IMS Basel</h1>

        <div id="menu">
            <ul>
                <li><a href="./admin.php">Adminseite</a></li>
                <li><a href="./loged_in_archive.php">Archiv</a></li>
                <li><a href="./logout.php">Logout</a></li>

            </ul>
        </div>
    </div>
    <div>
    <h3 id="titel">News der IMS Basel</h3>
    <?php

// Prepare the SQL statement to retrieve tickets for the user with ID 1
$stmt = $conn->prepare("
    SELECT 
        t.ticketID,
        t.titel,
        t.gueltigVon,
        t.gueltigBis,
        t.erstelltam,
        t.nutzerid,
        t.link,
        t.datei,
        u.Benutzername,
        u.Passwort
    FROM 
        ticket t
    JOIN 
        users u ON t.nutzerid = u.nutzerid
    WHERE 
        t.nutzerid = 1
    ORDER BY 
        t.erstelltam DESC
");
$stmt->execute();
$result = $stmt->get_result();

// Check if there are any tickets for the user with ID 1
if ($result->num_rows > 0) {
    echo "<h2>Tickets für Nutzer mit ID 1</h2>";

    while ($row = $result->fetch_assoc()) {
        echo "<div class='ticket'>";
        echo "<h3>Ticket ID: " . $row['ticketID'] . "</h3>";
        echo "<p>Titel: " . $row['titel'] . "</p>";
        echo "<p>Gültig von: " . $row['gueltigVon'] . "</p>";
        echo "<p>Gültig bis: " . $row['gueltigBis'] . "</p>";
        echo "<p>Erstellt am: " . $row['erstelltam'] . "</p>";
        echo "<p>Nutzername: " . $row['Benutzername'] . "</p>";
        if ($row['link']) {
            echo "<p>Link: <a href='" . $row['link'] . "'>" . $row['link'] . "</a></p>";
        }
        if ($row['datei']) {
            echo "<p>Datei: <a href='data:application/octet-stream;base64," . base64_encode($row['datei']) . "' download='datei'>Download Datei</a></p>";
        }
        echo "</div>";
    }
} else {
    echo "<p>Keine Tickets für Nutzer mit ID 1 verfügbar.</p>";
}

$stmt->close();
?>


<!-- Kategorie-Filter -->
<h2>Nach Kategorie filtern</h2>
<form action="" method="post">
    <label for="category">Wähle eine Kategorie:</label>
    <select name="category" id="category">
        <option value="">Alle Kategorien</option>
        <!-- Populate the options with the specific categories -->
        <option value="1">Schule</option>
        <option value="2">Freizeit</option>
        <option value="3">Sport</option>
        <option value="4">Sonstiges</option>
    </select>
    <input type="submit" name="filter" value="Filtern">
</form>


<?php
// Filter the news by category
if (isset($_POST['filter'])) {
    $category = $_POST['category'];

    // Check if the user has selected a category
    if ($category != "") {
        $stmt = $conn->prepare("SELECT n.newsID, n.titel, n.bild, n.gueltigBis, k.kategorie FROM news AS n INNER JOIN kategories AS k ON n.kid = k.kid WHERE n.gueltigBis >= NOW() AND n.kid = ? ORDER BY n.erstelltam DESC");
        $stmt->bind_param("i", $category);
    } else {
        $stmt = $conn->prepare("SELECT n.newsID, n.titel, n.bild, n.gueltigBis, k.kategorie FROM news AS n INNER JOIN kategories AS k ON n.kid = k.kid WHERE n.gueltigBis >= NOW() ORDER BY n.erstelltam DESC");
    }

    $stmt->execute();
    $result = $stmt->get_result();
    // Check if there are any news
    if ($result->num_rows > 0) {
        echo "<h2>Gefilterte News</h2>";

        while ($row = $result->fetch_assoc()) {
            echo "<div class='news'>";
            echo "<a href='li_news_detail.php?newsID=" . $row['newsID'] . "'><h3>" . $row['titel'] . "</h3></a>";
            echo "<img src='" . $row['bild'] . "' alt='Bild zur News'>";
            echo "<p>Kategorie: " . $row['kategorie'] . "</p>";
            echo "</div>";
        }
    } else {
        echo "<p>Keine aktuellen News verfügbar.</p>";
    }}
    ?>

    </div>
    <div id="impressum">
         Impressum:<br/><br/> Herausgeber: <br/>Robin Rütter <br/>Rüchiweg 21 <br/>CH-4106 Therwil <br/>E-Mail: robin.ruetter@bluewin.ch <br> 
    </div>



    
</body>