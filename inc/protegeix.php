<?php

if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit;
}

// Tanquem la sessió després de 10 minuts sense activitat.
if (isset($_SESSION['ultima_activitat']) && time() - $_SESSION['ultima_activitat'] > 600) {
    $_SESSION = [];
    session_destroy();
    header('Location: login.php?expirada=1');
    exit;
}

$_SESSION['ultima_activitat'] = time();
