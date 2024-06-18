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
<body>
<div id="header">
        <h1>Wallet</h1>

        <div id="menu">
            <ul>
                <li><a href="./index.php">Home</a></li>
                <li><a href="./archiv.php">Archiv</a></li>
                
            </ul>
        </div>
    </div>
<h3 id="titel">Wallet</h3>
<h3 id="titel">Login</h3>
<form action="/ipa/IPA-Testlauf/after_login.php" method="post">
        <label for="uname">Benutzername</label><br>
        <input type="text" id="uname" name="uname" value="" placeholder="Username" required><br>
        <label for="pwort">Passwort</label><br>
        <input type="password" id="pwort" name="pwort" value="" placeholder="Passwort" required><br>
        <input type="submit" value="Login">
        <input type="reset" value="Zurücksetzen">
    </form>
    


    <div id="impressum">
         Impressum:<br/><br/> Herausgeber: <br/>Robin Rütter <br/>Rüchiweg 21 <br/>CH-4106 Therwil <br/>E-Mail: robin.ruetter@bluewin.ch <br/> <br/> <br/> Inhalt: <br/> <br/> Von verschiedene Benutzern erstellte News. <br/> <br/> <br/>
    </div>
   

</body>