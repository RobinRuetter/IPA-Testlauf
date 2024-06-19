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
    
    not used annymore

    //check if sesion exists if not redirect to login.php after 5 seconds
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
    //check if $session['id'] is set if not redirect to login.php after 5 seconds
    if (!isset($_SESSION['id'])){
        echo "Sie sind nicht eingeloggt. Sie werden in 5 Sekunden weitergeleitet.";
        //redirect to login.php after 5 seconds
        header("refresh:5; url=login.php");
        exit;
    }
    //if $session['id'] is set, do nothing
    if ($_SESSION['id'] == true){
    }else{
        echo "Sie sind nicht eingeloggt. Sie werden in 5 Sekunden weitergeleitet.";
        //redirect to login.php after 5 seconds
        header("refresh:5; url=login.php");
        exit;
    }

    
    ?>
    <div id="header">
        <h1>News der IMS Basel</h1>

        <div id="menu">
            <ul>
                <li><a href="./loged_in_index.php">Home</a></li>
                <li><a href="./loged_in_archive.php">Archiv</a></li>
                <li><a href="./logout.php">Logout</a></li>

            </ul>
        </div>
    </div>
    <h3 id="titel">News der IMS Basel</h3>
    <div>
    <h3 id="titel">Paswort ändern</h3>
    <form action="" method="post">
        <input type="password" name="oldPassword" placeholder="Altes Passwort" required><br>
        <input type="password" name="newPassword" placeholder="Neues Passwort" required><br>
        <input type="password" name="newPassword2" placeholder="Neues Passwort wiederholen" required><br>
        <input type="submit" name="changePassword" value="Passwort ändern">
    </form>
    <?php
    if (isset($_POST['changePassword'])) {
        $oldPassword = $_POST['oldPassword'];
        $newPassword = $_POST['newPassword'];
        $newPassword2 = $_POST['newPassword2'];
        $stmt = $conn->prepare("SELECT Passwort FROM users WHERE nutzerid = ?");
        $stmt->bind_param("i", $bid);
        $bid = $_SESSION['id'];
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        if (password_verify($oldPassword, $row['Passwort'])) {
            if ($newPassword == $newPassword2) {
                $stmt = $conn->prepare("UPDATE users SET Passwort = ? WHERE nutzerid = ?");
                $stmt->bind_param("si", $passwort, $bid);
                $passwort = password_hash($newPassword, PASSWORD_DEFAULT);
                $stmt->execute();
                $stmt->close();
                echo "Passwort erfolgreich geändert";
            } else {
                echo "Die neuen Passwörter stimmen nicht überein";
            }
        } else {
            echo "Das alte Passwort ist falsch";
        }
    }
    ?>
    <br>
    <br>
    <br>
    </div>
    <h3 id="titel">Ticket Erstellen</h3>
<div>
<form action="" method="post" enctype="multipart/form-data">
    <label for="titel">Titel</label><br>
    <input type="text" id="titel" name="titel" placeholder="Titel"><br>
    <label for="gueltigVon">Gültig von</label><br>
    <input type="datetime-local" id="gueltigVon" name="gueltigVon" placeholder="Gültig von"><br>
    <label for="gueltigBis">Gültig bis</label><br>
    <input type="datetime-local" id="gueltigBis" name="gueltigBis" placeholder="Gültig bis"><br>
    <label for="link">Link</label><br>
    <input type="text" id="link" name="link" placeholder="Link"><br>
    <label for="datei">Datei (PDF)</label><br>
    <input type="file" id="datei" name="datei" accept="application/pdf"><br>
    <input type="submit" value="Submit" name='submit'>
</form>
<br><br>
<?php


if (isset($_POST['submit'])){
    // Überprüfen Sie, ob alle erforderlichen Felder ausgefüllt sind
    if (empty($_POST['titel']) || empty($_POST['gueltigVon']) || empty($_POST['gueltigBis'])) {
        echo "Bitte füllen Sie alle Felder aus";
        exit;
    }

    // Überprüfen Sie, ob die Datei hochgeladen wurde
    if (isset($_FILES['datei']) && $_FILES['datei']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['datei']['tmp_name'];
        $fileName = $_FILES['datei']['name'];
        $fileSize = $_FILES['datei']['size'];
        $fileType = $_FILES['datei']['type'];
        
        // Überprüfen Sie die Dateigröße (z.B. max 16MB)
        $maxFileSize = 16 * 1024 * 1024; // 16 MB
        if ($fileSize > $maxFileSize) {
            echo "Die Datei ist zu groß. Die maximale Dateigröße beträgt 16MB.";
            exit;
        }

        // Lesen Sie den Inhalt der Datei
        $fileContent = file_get_contents($fileTmpPath);
    } else {
        echo "Fehler beim Hochladen der Datei.";
        exit;
    }

    // Setzen Sie die Datenbankfelder
    $titel = $_POST['titel'];
    $gueltigVon = $_POST['gueltigVon'];
    $gueltigBis = $_POST['gueltigBis'];
    $erstelltam = date("Y-m-d H:i:s");
    $nutzerid = $_SESSION['id'];
    $link = $_POST['link'];

    // Bereiten Sie die SQL-Abfrage vor
    $stmt = $conn->prepare("INSERT INTO ticket (titel, gueltigVon, gueltigBis, erstelltam, nutzerid, link, datei) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssiss", $titel, $gueltigVon, $gueltigBis, $erstelltam, $nutzerid, $link, $null);
    $null = NULL; // Platzhalter für den Dateiinhalt

    // Fügen Sie die Datei mit send_long_data() ein
    $stmt->send_long_data(6, $fileContent);
    
    if ($stmt->execute()) {
        echo "Das Ticket wurde erfolgreich erstellt.";
    } else {
        echo "Fehler beim Erstellen des Tickets: " . $stmt->error;
    }
    $stmt->close();
    // Seite neu laden
    echo "<meta http-equiv='refresh' content='0'>";
}
/*
if (isset($_POST['submit'])){
    // Validate input
    if (empty($_POST['titel']) || empty($_POST['gueltigVon']) || empty($_POST['gueltigBis'])) {
        echo "Bitte füllen Sie alle erforderlichen Felder aus.";
        exit;
    }

    // Check if date is valid
    if ($_POST['gueltigVon'] > $_POST['gueltigBis']) {
        echo "Das Datum ist nicht gültig.";
        exit;
    }

    // Process the PDF file upload
    $datei = NULL;
    if (isset($_FILES['datei']) && $_FILES['datei']['error'] == 0) {
        $fileTmpPath = $_FILES['datei']['tmp_name'];
        $fileName = $_FILES['datei']['name'];
        $fileSize = $_FILES['datei']['size'];
        $fileType = $_FILES['datei']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        if ($fileExtension == 'pdf') {
            $datei = file_get_contents($fileTmpPath);
        } else {
            echo "Bitte laden Sie nur PDF-Dateien hoch.";
            exit;
        }
    }

    // Insert into DB
    $stmt = $conn->prepare("INSERT INTO ticket (titel, gueltigVon, gueltigBis, erstelltam, nutzerid, link, datei) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssiss", $titel, $gueltigVon, $gueltigBis, $erstelltam, $nutzerid, $link, $datei);

    $titel = $_POST['titel'];
    $gueltigVon = $_POST['gueltigVon'];
    $gueltigBis = $_POST['gueltigBis'];
    $erstelltam = date("Y-m-d H:i:s");
    $nutzerid = $_SESSION['id']; // Verwenden Sie die Nutzer-ID aus der Session
    $link = $_POST['link'];

    $stmt->send_long_data(6, $datei); // For the LONGBLOB field

    if ($stmt->execute()) {
        echo "Ticket erfolgreich erstellt.";
    } else {
        echo "Fehler beim Erstellen des Tickets: " . $stmt->error;
    }

    $stmt->close();
    // Reload page
    echo "<meta http-equiv='refresh' content='0'>";
*/
?>


<br>
<br>
<br>
</div>

<h3 id="titel">Ticket Löschen</h3>
<div>
    <?php
    
    $stmt = $conn->prepare("SELECT ticketID, titel, gueltigVon, gueltigBis, erstelltam, link FROM ticket WHERE nutzerid = ?");
    $stmt->bind_param("i", $nutzerid);
    $nutzerid = $_SESSION['id'];
    $stmt->execute();
    $result = $stmt->get_result();

    // Create table
    echo "<table>";
    echo "<tr>";
    echo "<th>Titel</th>";
    echo "<th>Gültig von</th>";
    echo "<th>Gültig bis</th>";
    echo "<th>Erstellt am</th>";
    echo "<th>Link</th>";
    echo "<th>Löschen</th>";
    echo "</tr>";

    // Fill table with data
    while ($row = $result->fetch_assoc()){
        echo "<tr>";
        echo "<td>" . $row['titel'] . "</td>";
        echo "<td>" . $row['gueltigVon'] . "</td>";
        echo "<td>" . $row['gueltigBis'] . "</td>";
        echo "<td>" . $row['erstelltam'] . "</td>";
        echo "<td>" . $row['link'] . "</td>";
        echo "<td><form action='' method='post'><input type='hidden' name='delID' value='" . $row['ticketID'] . "'><input type='submit' name='delete' value='Löschen'></form></td>";
        echo "</tr>";
    }

    echo "</table>";
    $stmt->close();

    // Make the table look nice
    echo "<style>table, th, td {border: 1px solid black; border-collapse: collapse; padding: 8px;} th {background-color: #f2f2f2;}</style>";

    // Delete ticket
    if (isset($_POST['delete'])){
        $stmt = $conn->prepare("DELETE FROM ticket WHERE ticketID = ?");
        $stmt->bind_param("i", $delID);
        $delID = $_POST['delID'];
        $stmt->execute();
        $stmt->close();
        // Reload page
        echo "<meta http-equiv='refresh' content='0'>";
    }
    ?>
    <br><br><br>
</div>

<h3 id="titel">Ticket Bearbeiten</h3>
<div>
    <?php
  

    // Fügen Sie hier Ihre Datenbankverbindung ein
    // $conn = new mysqli('servername', 'username', 'password', 'database');

    // Get tickets created by the logged-in user
    $stmt = $conn->prepare("SELECT ticketID, titel, gueltigVon, gueltigBis, erstelltam, link FROM ticket WHERE nutzerid = ?");
    $stmt->bind_param("i", $nutzerid);
    $nutzerid = $_SESSION['id'];
    $stmt->execute();
    $result = $stmt->get_result();

    // Create table
    echo "<table>";
    echo "<tr>";
    echo "<th>Titel</th>";
    echo "<th>Gültig von</th>";
    echo "<th>Gültig bis</th>";
    echo "<th>Erstellt am</th>";
    echo "<th>Link</th>";
    echo "<th>Bearbeiten</th>";
    echo "</tr>";

    // Fill table with data
    while ($row = $result->fetch_assoc()){
        echo "<tr>";
        echo "<td>" . $row['titel'] . "</td>";
        echo "<td>" . $row['gueltigVon'] . "</td>";
        echo "<td>" . $row['gueltigBis'] . "</td>";
        echo "<td>" . $row['erstelltam'] . "</td>";
        echo "<td>" . $row['link'] . "</td>";
        echo "<td><form action='' method='post'><input type='hidden' name='editID' value='" . $row['ticketID'] . "'><input type='submit' name='edit' value='Bearbeiten'></form></td>";
        echo "</tr>";
    }

    echo "</table>";
    $stmt->close();

    // Make the table look nice
    echo "<style>table, th, td {border: 1px solid black; border-collapse: collapse; padding: 8px;} th {background-color: #f2f2f2;}</style>";

    // Check if the form is submitted for editing
    if (isset($_POST['edit'])) {
        $editID = $_POST['editID'];
        // Retrieve the ticket based on the editID
        $editStmt = $conn->prepare("SELECT * FROM ticket WHERE ticketID = ?");
        $editStmt->bind_param("i", $editID);
        $editStmt->execute();
        $editResult = $editStmt->get_result();
        $editRow = $editResult->fetch_assoc();
        $editStmt->close();

        // Display the form for updating the ticket
        echo "<h2>Update Ticket</h2>";
        echo "<form action='' method='post'>";
        echo "<input type='hidden' name='updateID' value='" . $editRow['ticketID'] . "'>";
        echo "Titel: <input type='text' name='titel' value='" . $editRow['titel'] . "'><br>";
        echo "Gültig von: <input type='datetime-local' name='gueltigVon' value='" . $editRow['gueltigVon'] . "'><br>";
        echo "Gültig bis: <input type='datetime-local' name='gueltigBis' value='" . $editRow['gueltigBis'] . "'><br>";
        echo "Link: <input type='text' name='link' value='" . $editRow['link'] . "'><br>";
        echo "<input type='submit' name='update' value='Update'>";
        echo "</form>";
    }

    // Check if the form is submitted for updating
    if (isset($_POST['update'])) {
        $updateID = $_POST['updateID'];
        $titel = $_POST['titel'];
        $gueltigVon = $_POST['gueltigVon'];
        $gueltigBis = $_POST['gueltigBis'];
        $link = $_POST['link'];

        // Update the ticket in the database
        $updateStmt = $conn->prepare("UPDATE ticket SET titel = ?, gueltigVon = ?, gueltigBis = ?, link = ? WHERE ticketID = ?");
        $updateStmt->bind_param("sssss", $titel, $gueltigVon, $gueltigBis, $link, $updateID);
        $updateStmt->execute();
        $updateStmt->close();

        // Reload page
        echo "<meta http-equiv='refresh' content='0'>";
    }
    ?>
    <br><br><br>
</div>

    
    <div id="impressum">
         Impressum:<br/><br/> Herausgeber: <br/>Robin Rütter <br/>Rüchiweg 21 <br/>CH-4106 Therwil <br/>E-Mail: robin.ruetter@bluewin.ch <br> 
    </div>



    
</body>