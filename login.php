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
if (isset ($_POST['submit'])){
    $ausgebe = "";
    //save input to file try.txt
    $myfile = fopen("try.txt", "w") or die("Unable to open file!");
    $txt = $_POST['Benutzername'];
    fwrite($myfile, $txt);
    $txt = $_POST['Passwort'];
    fwrite($myfile, $txt);
    fclose($myfile);


    //check for empty fields
    if (empty($_POST['Benutzername']) || empty($_POST['Passwort'])) {
        $ausgebe .= "<br> -Bitte alle Felder ausfüllen";
        
    }
    
    //check if Benuzername is 1-20 characters long
    if (strlen($_POST['Benutzername']) < 1 || strlen($_POST['Benutzername']) > 20) {
        $ausgebe .= "<br> -Bitte einen gültigen Benutzernamen eingeben";

    }

    //check if Passwort is 8-20 characters long
    if (strlen($_POST['Passwort']) < 8 || strlen($_POST['Passwort']) > 20) {
        $ausgebe .= "<br> -Bitte ein gültiges Passwort eingeben";
    }
    
   
    //check if username is already used with $stmt
    $stmt = $conn->prepare ("select Benutzername from users where Benutzername = ?");

    $stmt->bind_param("s", $Benutzernametest);
    $Benutzernametest = $_POST['Benutzername'];
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result == $Benutzernametest) {

      $ausgebe .= "Benutzername already used"; 
     
    }
    if ( $ausgebe == "" ) {
    //delete spaces at the start and end of the string
    $Benutzername = trim($_POST['Benutzername']);
    $Passwort = trim($_POST['Passwort']);
    
    


    //delete file try.txt
    unlink("try.txt");
    //insert data into db
    $stmt = $conn->prepare ("insert into users (Benutzername, Passwort ) values (?, ?)");
    $stmt->bind_Param("ss", $Benutzername, $Passwort);
    
    //get data from form
    $Benutzername = $_POST['Benutzername'];
    $Passwort = $_POST['Passwort'];
    $Passwort = password_hash($Passwort, PASSWORD_DEFAULT);
    $stmt->execute();
    //check if querry was successful
    if ($stmt->affected_rows > 0) {
        echo "Neuer Benutzer wurde erfolgreich erstellt";
        echo "<br>";
        echo "<br>";
        //wait 5 seconds
        header("refresh:5; url=login.php");
        echo "Sie werden in 5 Sekunden weitergeleitet";    
        
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
}
else {
    echo $ausgebe;
    echo "<br><br><input type=button name = 'go' value='Zurück um Ihre Eingeben zu Prüfen' onclick= window.history.back() >";
    die();
} }
?>

<div id="header">
        <h1>Wallet</h1>

        <div id="menu">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="archive.php">Archiv</a></li>
                
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