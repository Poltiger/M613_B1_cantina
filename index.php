<?php
session_start();

$dades = require_once __DIR__ . '/inc/dades.php';

if (isset($_SESSION['email'])) {
    header('Location: cataleg.php');
    exit;
}

header('Location: login.php');
exit;
