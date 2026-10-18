<?php

function buscaUsuari(array $usuaris, string $email): ?array
{
    foreach ($usuaris as $usuari) {
        if ($usuari['email'] === $email) {
            return $usuari;
        }
    }
    return null;
}

function unitatsCistell(array $cistell): int
{
    $unitats = 0;
    foreach ($cistell as $quantitat) {
        $unitats += $quantitat;
    }
    return $unitats;
}

function totalCistell(array $cistell, array $productes): float
{
    $total = 0;
    foreach ($cistell as $id => $quantitat) {
        $total += $productes[$id]['preu'] * $quantitat;
    }
    return $total;
}

function afegeixMissatge(string $text): void
{
    $_SESSION['missatge'] = $text;
}

function llegeixMissatge(): ?string
{
    $missatge = $_SESSION['missatge'] ?? null;
    unset($_SESSION['missatge']);
    return $missatge;
}
