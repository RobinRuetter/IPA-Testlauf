<!DOCTYPE html>
<html lang="de">
<html>
    <?php 
    // Connect to the database
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
if (isset($_POST['submit'])){
    $ausgebe = "";
    // Save input to file try.txt
    $myfile = fopen("try.txt", "w") or die("Unable to open file!");
    $txt = $_POST['Benutzername'];
    fwrite($myfile, $txt);
    $txt = $_POST['Passwort'];
    fwrite($myfile, $txt);
    fclose($myfile);

    // Check for empty fields
    if (empty($_POST['Benutzername']) || empty($_POST['Passwort'])) {
        $ausgebe .= "<br> -Bitte alle Felder ausfüllen";
    }

    // Check if Benutzername is 1-20 characters long
    if (strlen($_POST['Benutzername']) < 1 || strlen($_POST['Benutzername']) > 20) {
        $ausgebe .= "<br> -Bitte einen gültigen Benutzernamen eingeben";
    }

    // Check if Passwort is 8-20 characters long
    if (strlen($_POST['Passwort']) < 8 || strlen($_POST['Passwort']) > 20) {
        $ausgebe .= "<br> -Bitte ein gültiges Passwort eingeben";
    }
    
    // Delete spaces at the start and end of the string
    $Benutzername = trim($_POST['Benutzername']);
    $Passwort = trim($_POST['Passwort']);
    
    // Check if username is already used
    $stmt = $conn->prepare("SELECT Benutzername FROM users WHERE Benutzername = ?");
    $stmt->bind_param("s", $Benutzernametest);
    $Benutzernametest = $_POST['Benutzername'];
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $ausgebe .= "Benutzername already used"; 
    }
    
    if ($ausgebe == "") {
        // Delete spaces at the start and end of the string
        $Benutzername = trim($_POST['Benutzername']);
        $Passwort = trim($_POST['Passwort']);
        
        // Delete file try.txt
        unlink("try.txt");

        // Insert data into the database
        $stmt = $conn->prepare("INSERT INTO users (Benutzername, Passwort) VALUES (?, ?)");
        $stmt->bind_Param("ss", $Benutzername, $Passwort);

        // Get data from form and hash the password
        $Benutzername = $_POST['Benutzername'];
        $Passwort = $_POST['Passwort'];
        $Passwort = password_hash($Passwort, PASSWORD_DEFAULT);
        $stmt->execute();

        // Check if query was successful
        if ($stmt->affected_rows > 0) {
            echo "Neuer Benutzer wurde erfolgreich erstellt";
            echo "<br>";
            echo "<br>";
            // Wait 5 seconds
            header("refresh:5; url=login.php");
            echo "Sie werden in 5 Sekunden weitergeleitet";    
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo $ausgebe;
        echo "<br><br><input type=button name='go' value='Zurück um Ihre Eingaben zu prüfen' onclick='window.history.back()'>";
        die();
    }
}
?>

<div id="header">
    <h1>Wallet</h1>
    <div id="menu">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="login.php">Login</a></li>
        </ul>
    </div>
</div>

<h3 id="titel">Wallet</h3>
<div>
    <h3 id="titel">Anmelden</h3>
    <form action="" method="post">
        <label for="Benutzername">Benutzername*</label><br>
        <input type="text" id="Benutzername" name="Benutzername" value="" placeholder="Benutzername" required><br>
        <label for="Passwort">Passwort*</label><br>
        <input type="password" id="Passwort" name="Passwort" value="" placeholder="Passwort" required><br>
        <input type="submit" value="Anmelden" name="submit">
        <input type="reset" value="Zurücksetzen">
    </form>
    <br>
</div>    

<div id="impressum">
    Impressum:<br/><br/> Herausgeber: <br/>Robin Rütter <br/>Rüchiweg 21 <br/>CH-4106 Therwil <br/>E-Mail: robin.ruetter@bluewin.ch <br/> <br/> <br/> Inhalt: <br/> <br/> Von verschiedene Benutzern erstellte News. <br/> <br/> <br/>
</div>
</body>
</html>
