<?php
require_once "config/db.php";
session_start();
$error = "";

if($_SERVER["REQUEST_METHOD"]==="POST"){
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $birth_date = $_POST["birth_date"];

    if(empty($email)||empty($password)||empty($birth_date)){
        $error = "Vyplň všechna pole.";
    } else {
        $passwordHash = password_hash($password,PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (email,password_hash,birth_date) VALUES (?,?,?)");
        try{
            $stmt->execute([$email,$passwordHash,$birth_date]);
            header("Location: login.php");
            exit;
        }catch(PDOException $e){
            $error = "Email už existuje.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Registrace | Studentský Hlas</title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="container">
    <h1>Registrace</h1>
    <?php if($error): ?><p class="error"><?=$error?></p><?php endif; ?>
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Heslo" required>
        <label>Datum narození</label>
        <input type="date" name="birth_date" required>
        <button type="submit">Registrovat</button>
    </form>
</div>
</body>
</html>