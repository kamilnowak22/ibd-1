<?php
include 'header.php';

use Ibd\Ksiazki;

$ksiazki = new Ksiazki();
$lista = $ksiazki->pobierzWszystkie();
?>

<h1>Witamy w księgarni internetowej IBD!</h1>

<p>
    Projekt na zaliczenie przedmiotu Internetowe Bazy Danych w roku akademickim <?= ROK_AKADEMICKI ?>.
</p>

<?php include 'footer.php'; ?>
