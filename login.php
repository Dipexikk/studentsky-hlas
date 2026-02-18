<?php
require_once "config/db.php";
session_start();
$error = "";

if($_SERVER["REQUEST_METHOD"]==="POST"){
    $email = $_POST["email"];
    $password = $_POST["password"];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email=?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if($user && password_verify($password,$user["password_hash"])){
        $_SESSION["user"] = $user;
        header("Location: index.php");
        exit;
    } else {
        $error = "Neplatné přihlášení.";
    }
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Přihlášení | Studentský Hlas</title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="container">
    <h1>Přihlášení</h1>
    <?php if($error): ?><p class="error"><?=$error?></p><?php endif; ?>
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Heslo" required>
        <button type="submit">Přihlásit se</button>
    </form>
</div>
</body>
</html>