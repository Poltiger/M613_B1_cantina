<?php
session_start();
require_once __DIR__ . '/inc/protegeix.php';

$dades = require_once __DIR__ . '/inc/dades.php';
require_once __DIR__ . '/inc/funcions.php';
$productes = $dades['productes'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $quantitat = $_POST['quantitat'] ?? '';

    if (is_string($id) && is_string($quantitat) && isset($productes[$id])
        && in_array($quantitat, ['1', '2', '3', '4', '5'], true)) {
        $_SESSION['cistell'][$id] = ($_SESSION['cistell'][$id] ?? 0) + (int) $quantitat;
        afegeixMissatge("S'han afegit $quantitat × " . $productes[$id]['nom']);
    }

    header('Location: cataleg.php');
    exit;
}

$titol = 'Catàleg';
require_once __DIR__ . '/inc/capcalera.php';
?>
<h2>Catàleg</h2>
<table>
    <tr><th>Producte</th><th>Preu</th><th>Quantitat</th></tr>
    <?php foreach ($productes as $id => $producte): ?>
        <tr>
            <td><?= htmlspecialchars($producte['nom'], ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars(number_format($producte['preu'], 2, ',', '.'), ENT_QUOTES, 'UTF-8') ?> €</td>
            <td>
                <form method="post">
                    <input type="hidden" name="id" value="<?= htmlspecialchars((string) $id, ENT_QUOTES, 'UTF-8') ?>">
                    <input type="number" name="quantitat" min="1" max="5" value="1" required>
                    <button type="submit">Afegir</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php require_once __DIR__ . '/inc/peu.php'; ?>
