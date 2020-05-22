<?php
use Ibd\Ksiazki;
// pobieranie książek
$ksiazki = new Ksiazki();
$lista = $ksiazki->pobierzBestsellery();

?>

<div class="col-md-3">
	<?php if (empty($_SESSION['id_uzytkownika'])): ?>
        <h1>Logowanie</h1>

        <form method="post" action="logowanie.php">
            <div class="form-group">
                <label for="login">Login:</label>
                <input type="text" id="login" name="login" class="form-control input-sm" />
            </div>
            <div class="form-group">
                <label for="haslo">Hasło:</label>
                <input type="password" id="haslo" name="haslo" class="form-control input-sm" />
            </div>
            <div class="form-group">
                <button type="submit" name="zaloguj" id="submit" class="btn btn-primary btn-sm">Zaloguj się</button>
                <a href="rejestracja.php" class="btn btn-link btn-sm">Zarejestruj się</a>
                <input type="hidden" name="powrot" value="<?= basename($_SERVER['SCRIPT_NAME']) ?>" />
            </div>
        </form>
    <?php else: ?>
        <p class="text-right">
            Zalogowany: <strong><?= $_SESSION['login'] ?></strong>
            &nbsp;
            <a href="wyloguj.php" class="btn btn-secondary btn-sm">wyloguj się</a>
        </p>
    <?php endif; ?>
	<h1>Bestsellery</h1>
	
	<ul>
		<?php foreach ($lista as $ks): ?>
			<a href="ksiazki.szczegoly.php?id=<?= $ks['id'] ?>" title="szczegóły">
			<li style="width: 300%">
				<p><div style="width: 30%">
                    <?php if (!empty($ks['zdjecie'])): ?>
                        <img src="zdjecia/<?= $ks['zdjecie'] ?>" alt="<?= $ks['tytul'] ?>" class="img-thumbnail"/>
                    <?php else: ?>
                        brak zdjęcia
                    <?php endif; ?>
                </div>
				<i><?= $ks['tytul'] ?></i>, <?= $ks['imie_autora'] ?> <?= $ks['nazwisko_autora'] ?></p>
			</li>
			</a>
		<?php endforeach; ?>
	</ul>
</div>
