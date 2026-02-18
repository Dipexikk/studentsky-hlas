<?php
require_once "config/db.php";
session_start();

if(!isset($_SESSION["user"])){
    header("Location: login.php");
    exit;
}

$error = "";
$success = "";

if($_SERVER["REQUEST_METHOD"]==="POST"){
    $name = trim($_POST['name']);
    $city = trim($_POST['city']);
    $category = $_POST['category'];

    if(empty($name) || empty($city) || empty($category)){
        $error = "Vyplň všechna pole.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO schools (name, city, category) VALUES (?,?,?)");
        $stmt->execute([$name,$city,$category]);
        $success = "Škola byla úspěšně přidána.";
    }
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Přidat školu | Studentský Hlas</title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>
<header>
    <h1>Studentský Hlas</h1>
    <div class="nav">
        <span class="user"><?= htmlspecialchars($_SESSION['user']['username']) ?> (<?= htmlspecialchars($_SESSION['user']['email']) ?>)</span>
        <a href="index.php">Domů</a>
        <a href="logout.php">Odhlásit se</a>
    </div>
</header>

<div class="container">
    <h2>Přidat školu</h2>

    <?php if($error): ?><p class="error"><?=$error?></p><?php endif; ?>
    <?php if($success): ?><p class="success"><?=$success?></p><?php endif; ?>

    <form method="POST">
        <input type="text" name="name" placeholder="Název školy" required>
        <input type="text" name="city" placeholder="Město" required>
        <select name="category" required>
            <option value="">Vyber kategorii</option>
            <option value="ZŠ">ZŠ</option>
            <option value="SŠ">SŠ</option>
            <option value="Gymnázium">Gymnázium</option>
            <option value="SOŠ">SOŠ</option>
            <option value="VŠ">VŠ</option>
            <option value="Soukromá škola">Soukromá škola</option>
        </select>
        <button type="submit">Přidat školu</button>
    </form>
    <a href="index.php" class="back">← Zpět</a>
</div>
</body>
</html>