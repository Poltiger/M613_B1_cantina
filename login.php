<?php
session_start();

$dades = require_once __DIR__ . '/inc/dades.php';
require_once __DIR__ . '/inc/funcions.php';

if (isset($_SESSION['email'])) {
    header('Location: cataleg.php');
    exit;
}

$email = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $contrasenya = $_POST['contrasenya'] ?? '';
    $usuari = is_string($email) ? buscaUsuari($dades['usuaris'], $email) : null;

    if ($usuari !== null && $usuari['contrasenya'] === $contrasenya) {
        session_regenerate_id(true);
        $_SESSION['nom'] = $usuari['nom'];
        $_SESSION['email'] = $usuari['email'];
        $_SESSION['rol'] = $usuari['rol'];
        $_SESSION['hora_login'] = time();
        $_SESSION['ultima_activitat'] = time();
        $_SESSION['cistell'] = [];
        $_SESSION['comandes'] = [];
        header('Location: cataleg.php');
        exit;
    }

    $error = 'Credencials incorrectes';
}

$titol = 'Entrar';
require_once __DIR__ . '/inc/capcalera.php';
?>
<h2>Iniciar sessió</h2>
<?php if (isset($_GET['expirada'])): ?>
    <p>La sessió ha caducat per inactivitat</p>
<?php endif; ?>
<?php if ($error !== ''): ?>
    <p><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
<?php endif; ?>
<form method="post">
    <p><label for="email">Email</label><br>
    <input type="email" name="email" id="email" value="<?= htmlspecialchars(is_string($email) ? $email : '', ENT_QUOTES, 'UTF-8') ?>" required></p>
    <p><label for="contrasenya">Contrasenya</label><br>
    <input type="password" name="contrasenya" id="contrasenya" required></p>
    <button type="submit">Entrar</button>
</form>
<?php require_once __DIR__ . '/inc/peu.php'; ?>
