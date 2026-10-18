<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($titol, ENT_QUOTES, 'UTF-8') ?> - Cantina</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 20px auto; padding: 0 12px; }
        nav a { margin-right: 12px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #aaa; padding: 8px; text-align: left; }
    </style>
</head>
<body>
<header>
    <h1>Cantina</h1>
    <?php if (isset($_SESSION['email'])): ?>
        <p><?= htmlspecialchars($_SESSION['nom'], ENT_QUOTES, 'UTF-8') ?></p>
        <nav>
            <a href="cataleg.php">Catàleg</a>
            <a href="cistell.php">Cistell (<?= unitatsCistell($_SESSION['cistell'] ?? []) ?>)</a>
            <a href="logout.php">Tancar sessió</a>
        </nav>
    <?php endif; ?>
</header>
<?php $missatge = llegeixMissatge(); ?>
<?php if ($missatge !== null): ?>
    <p><?= htmlspecialchars($missatge, ENT_QUOTES, 'UTF-8') ?></p>
<?php endif; ?>
<main>
