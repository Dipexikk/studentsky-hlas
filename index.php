<?php
require_once "config/db.php";
session_start();

$stmt = $pdo->query("SELECT * FROM schools ORDER BY created_at DESC");
$schools = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="cs">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Studentský Hlas</title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>
<header>
    <h1>Studentský Hlas</h1>
    <div class="nav">
        <?php if(isset($_SESSION['user'])): ?>
            <span class="user"><?= htmlspecialchars($_SESSION['user']['email']) ?></span>
            <a href="add-school.php">Přidat školu</a>
            <a href="logout.php">Odhlásit se</a>
        <?php else: ?>
            <a href="login.php">Přihlášení</a>
            <a href="register.php">Registrace</a>
        <?php endif; ?>
    </div>
</header>

<div class="container">
    <h2>Nejnovější školy</h2>
    <?php if(empty($schools)): ?>
        <p>Žádné školy zatím nejsou přidány.</p>
    <?php endif; ?>

    <?php foreach($schools as $school): ?>
        <div class="card">
            <h3><a href="school.php?id=<?=$school['id']?>"><?= htmlspecialchars($school['name']) ?></a></h3>
            <p><?= htmlspecialchars($school['city']) ?> | <?= htmlspecialchars($school['category']) ?></p>
        </div>
    <?php endforeach; ?>
</div>
</body>
</html>