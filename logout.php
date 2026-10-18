<?php
session_start();

$dades = require_once __DIR__ . '/inc/dades.php';
$_SESSION = [];
session_destroy();

header('Location: login.php');
exit;
