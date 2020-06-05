<?php
include 'header.php';

use Ibd\Zamowienia;

// pobieranie kategorii
$zamownienia = new Zamowienia();
if(!empty($_SESSION['id_uzytkownika'])) {
    $lista = $zamownienia->znajdzZamownienia($_SESSION['id_uzytkownika']);
}
?>
<?php if(!empty($lista)): ?>
    <h1>Twoje zamowienia</h1>

    <table class="table table-striped table-condensed">
        <thead>
        <tr>
            <th>Numer zamówienia</th>
            <th>Ilość pozycji</th>
            <th>Ilość różnych książek</th>
            <th>Wartość zamówienia w PLN</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($lista as $ks): ?>
            <tr>
                <td><?= $ks['id'] ?></td>
                <td><?= $ks['ilosc_pozycji'] ?> </td>
                <td><?= $ks['ilosc_ksiazek'] ?></td>
                <td><?= $ks['wartosc_zamowienia'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p> Nie znaleziono żadnych zamówień</p>
<?php endif; ?>

<?php include 'footer.php'; ?>
