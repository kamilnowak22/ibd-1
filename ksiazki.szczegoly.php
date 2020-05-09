<?php

// jesli nie podano parametru id, przekieruj do listy książek
if (empty($_GET['id'])) {
    header("Location: ksiazki.lista.php");
    exit();
}

$id = (int)$_GET['id'];

include 'header.php';

use Ibd\Ksiazki;

$ksiazki = new Ksiazki();
$dane = $ksiazki->pobierz($id);
?>

    <h2><?= $dane['tytul'] ?></h2>

    <p>
        <a href="ksiazki.lista.php"><i class="fas fa-chevron-left"></i> Powrót</a>
    </p>

    <div>
        <div class="card flex-md-row mb-4 box-shadow h-md-250">
            <div class="card-body d-flex flex-column align-items-start">
                <strong class="d-inline-block mb-2 text-primary"><?=$dane['tytul']?></strong>
                <div class="mb-1 text-muted">ISBN: <?=$dane['isbn']?></div>
                <h6 class="mb-0">
                    Cena: <?=$dane['cena']?> PLN</br>
                    Liczba Stron: <?=$dane['liczba_stron']?>
                </h6>
                <p></p>
                <p class="card-text mb-auto"><?=$dane['opis']?></p>
            </div>
            <?php if(!empty($dane['zdjecie'])): ?>
                <img class="card-img-right flex-auto d-none d-md-block" style="width: 300px; height: 450px;" src="zdjecia/<?=$dane['zdjecie']?>" alt="<?=$dane['tytul']?>" />
            <?php else: ?>
                <img class="card-img-right flex-auto d-none d-md-block" style="width: 300px; height: 450px;" src="zdjecia/noimage.jpg" alt="Brak Obrazka" />
            <?php endif; ?>
           </div>
    </div>

<?php include 'footer.php'; ?>