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
    
    
</head>
<body>
    <p>
    <?php
    //check username and password with passwortverify
    $stmt = $conn->prepare ("select Benutzername, Passwort from users where Benutzername = ?");
    $stmt->bind_param("s", $username);
    $username = $_POST['uname'];
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    if (empty($row)) {
        echo "Login fehlgeschlagen";
        echo "<br>";
        echo "<a href='login.php'>Zurück zum Loginseite</a>";
        
        die();
    }
    if (password_verify($_POST['pwort'], $row['Passwort'])) {
        echo "Login erfolgreich";
        echo "<br>";
        echo "<a href='index.php'>Zurück zur Startseite</a>";
    } else {
        echo "Login fehlgeschlagen";
        echo "<br>";
        echo "<a href='login.php'>Zurück zum Loginseite</a>";
        
        die();
    }
    //create session
    session_start();

    $_SESSION['loggedin'] = true;
    $_SESSION['Benutzername'] = $username;
    //get user id
    $stmt = $conn->prepare ("select nutzerid from users where Benutzername = ?");
    $stmt->bind_param("s", $Benutzername);
    $Benutzername = $_POST['uname'];
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $_SESSION['id'] = $row['nutzerid'];
    
    
    //automacticly redirect to index.php
    header("Location: loged_in_index.php");
    ?>
    
    </p>
</body>
</html>