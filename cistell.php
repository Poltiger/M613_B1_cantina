<?php
session_start();
require_once __DIR__ . '/inc/protegeix.php';

$dades = require_once __DIR__ . '/inc/dades.php';
require_once __DIR__ . '/inc/funcions.php';
$productes = $dades['productes'];
$cistell = $_SESSION['cistell'] ?? [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accio = $_POST['accio'] ?? '';

    if ($accio === 'treure') {
        $id = $_POST['id'] ?? '';
        if (is_string($id) && isset($_SESSION['cistell'][$id])) {
            unset($_SESSION['cistell'][$id]);
        }
    } elseif ($accio === 'buidar') {
        $_SESSION['cistell'] = [];
    } elseif ($accio === 'finalitzar' && $cistell !== []) {
        $total = totalCistell($cistell, $productes);
        $_SESSION['comandes'][] = [
            'hora' => time(),
            'linies' => $cistell,
            'total' => $total,
        ];
        $_SESSION['cistell'] = [];
        afegeixMissatge('Comanda enviada: ' . number_format($total, 2, ',', '.') . ' €');
    }

    header('Location: cistell.php');
    exit;
}

$titol = 'Cistell';
require_once __DIR__ . '/inc/capcalera.php';
?>
<h2>Cistell</h2>
<?php if ($cistell === []): ?>
    <p>El cistell és buit. <a href="cataleg.php">Anar al catàleg</a></p>
<?php else: ?>
    <table>
        <tr><th>Producte</th><th>Preu</th><th>Quantitat</th><th>Subtotal</th><th></th></tr>
        <?php foreach ($cistell as $id => $quantitat): ?>
            <tr>
                <td><?= htmlspecialchars($productes[$id]['nom'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars(number_format($productes[$id]['preu'], 2, ',', '.'), ENT_QUOTES, 'UTF-8') ?> €</td>
                <td><?= htmlspecialchars((string) $quantitat, ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars(number_format($productes[$id]['preu'] * $quantitat, 2, ',', '.'), ENT_QUOTES, 'UTF-8') ?> €</td>
                <td>
                    <form method="post">
                        <input type="hidden" name="accio" value="treure">
                        <input type="hidden" name="id" value="<?= htmlspecialchars((string) $id, ENT_QUOTES, 'UTF-8') ?>">
                        <button type="submit">Treure</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <p>Total: <?= htmlspecialchars(number_format(totalCistell($cistell, $productes), 2, ',', '.'), ENT_QUOTES, 'UTF-8') ?> €</p>
    <form method="post">
        <button type="submit" name="accio" value="buidar">Buidar el cistell</button>
        <button type="submit" name="accio" value="finalitzar">Finalitzar comanda</button>
    </form>
<?php endif; ?>

<h2>Comandes de la sessió</h2>
<?php foreach ($_SESSION['comandes'] ?? [] as $comanda): ?>
    <p><?= htmlspecialchars(date('H:i', $comanda['hora']), ENT_QUOTES, 'UTF-8') ?> - <?= htmlspecialchars(number_format($comanda['total'], 2, ',', '.'), ENT_QUOTES, 'UTF-8') ?> €</p>
<?php endforeach; ?>
<?php require_once __DIR__ . '/inc/peu.php'; ?>
