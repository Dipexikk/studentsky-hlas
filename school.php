<?php
require_once "config/db.php";
session_start();

if(!isset($_GET['id'])){
    header("Location: index.php");
    exit;
}

$school_id = (int)$_GET['id'];

// Načtení školy
$stmt = $pdo->prepare("SELECT * FROM schools WHERE id=?");
$stmt->execute([$school_id]);
$school = $stmt->fetch(PDO::FETCH_ASSOC);
if(!$school) die("Škola nenalezena.");

// Přidání recenze
$error = "";
$success = "";

if(isset($_SESSION['user']) && $_SERVER["REQUEST_METHOD"]==="POST"){
    $rating = (int)$_POST['rating'];
    $difficulty = (int)$_POST['difficulty'];
    $atmosphere = (int)$_POST['atmosphere'];
    $content = trim($_POST['content']);
    $year_of_study = (int)$_POST['year_of_study'];

    if($rating<1||$rating>5||$difficulty<1||$difficulty>5||$atmosphere<1||$atmosphere>5||empty($content)){
        $error = "Vyplň všechna pole správně.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO reviews (user_id, school_id, rating, difficulty, atmosphere, content, year_of_study) VALUES (?,?,?,?,?,?,?)");
        $stmt->execute([$_SESSION['user']['id'],$school_id,$rating,$difficulty,$atmosphere,$content,$year_of_study]);
        $success = "Recenze byla přidána.";
    }
}

// Načtení recenzí – anonymně
$stmt = $pdo->prepare("SELECT * FROM reviews WHERE school_id=? ORDER BY created_at DESC");
$stmt->execute([$school_id]);
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="cs">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($school['name']) ?> | Studentský Hlas</title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>
<header>
    <h1>Studentský Hlas</h1>
    <div class="nav">
        <?php if(isset($_SESSION['user'])): ?>
            <span class="user"><?= htmlspecialchars($_SESSION['user']['email']) ?></span>
            <a href="index.php">Domů</a>
            <a href="logout.php">Odhlásit se</a>
        <?php else: ?>
            <a href="login.php">Přihlášení</a>
            <a href="register.php">Registrace</a>
        <?php endif; ?>
    </div>
</header>

<div class="container">
    <a href="index.php" class="back">← Zpět</a>
    <h2><?= htmlspecialchars($school['name']) ?></h2>
    <p><?= htmlspecialchars($school['city']) ?> | <?= htmlspecialchars($school['category']) ?></p>

    <?php if($error): ?><p class="error"><?=$error?></p><?php endif; ?>
    <?php if($success): ?><p class="success"><?=$success?></p><?php endif; ?>

    <?php if(isset($_SESSION['user'])): ?>
        <form method="POST">
            <input type="number" name="rating" min="1" max="5" placeholder="Hodnocení (1–5)" required>
            <input type="number" name="difficulty" min="1" max="5" placeholder="Náročnost (1–5)" required>
            <input type="number" name="atmosphere" min="1" max="5" placeholder="Atmosféra (1–5)" required>
            <textarea name="content" rows="4" placeholder="Text recenze" required></textarea>
            <input type="number" name="year_of_study" min="1" placeholder="Ročník">
            <button type="submit">Přidat recenzi</button>
        </form>
    <?php else: ?>
        <p>Pro přidání recenze se <a href="login.php">přihlas</a>.</p>
    <?php endif; ?>

    <h2>Recenze</h2>
    <?php $anon_count = 1; ?>
    <?php foreach($reviews as $r): ?>
        <div class="card">
            <p class="review-meta"><strong>Anonym #<?=$anon_count++?></strong> napsal/a <?= date('d.m.Y', strtotime($r['created_at'])) ?></p>
            <p>Hodnocení: <?= $r['rating'] ?> | Náročnost: <?= $r['difficulty'] ?> | Atmosféra: <?= $r['atmosphere'] ?></p>
            <p><?= htmlspecialchars($r['content']) ?></p>
        </div>
    <?php endforeach; ?>

    <a href="index.php" class="back">← Zpět</a>
</div>
</body>
</html>