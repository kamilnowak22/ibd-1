<?php

namespace Ibd;

class Ksiazki
{
   
    private $db;

    public function __construct()
    {
        $this->db = new Db();
    }

    /**
     * Pobiera wszystkie książki.
     *
     * @return array
     */
    public function pobierzWszystkie()
    {
        $sql = "SELECT ksiazki.id, id_autora, id_kategorii, tytul, nazwa, imie, nazwisko, opis, cena, liczba_stron, isbn, zdjecie FROM ksiazki 
		 join kategorie on ksiazki.id_kategorii=kategorie.id
		 join autorzy  on ksiazki.id_autora=autorzy.id";

        return $this->db->pobierzWszystko($sql);
    }

    /**
     * Pobiera zapytanie SELECT oraz jego parametry;
     *
     * @param $params
     * @return array
     */
    
    public function pobierzZapytanie($params)
    {
        $parametry = [];
        $sql = "SELECT k.*, a.imie as imie_autora, a.nazwisko as nazwisko_autora, kat.nazwa as nazwa_kategorii FROM ksiazki k 
        JOIN autorzy a ON k.id_autora = a.id
        JOIN kategorie kat on k.id_kategorii = kat.id";

        // dodawanie warunków do zapytanie
        if (!empty($params['fraza'])) {
            $sql .= " AND (k.tytul LIKE :fraza OR k.opis LIKE :fraza OR CONCAT(a.imie, ' ', a.nazwisko) LIKE :fraza) ";
            $parametry['fraza'] = "%$params[fraza]%";
        }
        if (!empty($params['id_kategorii'])) {
            $sql .= " AND k.id_kategorii = :id_kategorii ";
            $parametry['id_kategorii'] = $params['id_kategorii'];
        }

        // dodawanie sortowania
        if (!empty($params['sortowanie'])) {
            $kolumny = ['k.tytul', 'k.cena', 'a.nazwisko'];
            $kierunki = ['ASC', 'DESC'];
            [$kolumna, $kierunek] == explode(' ', $params['sortowanie']);

            if (in_array($kolumna, $kolumny) && in_array($kierunek, $kierunki)) {
                $sql .= " ORDER BY " . $params['sortowanie'];
            }
        }
        return ['sql' => $sql, 'parametry' => $parametry];
    }

    /**
     * Pobiera stronę z danymi książek.
     *
     * @param string $select
     * @param array $params
     * @return array
     */
    public function pobierzStrone($select, $params)
    {
        return $this->db->pobierzWszystko($select, $params);
    }

    /**
     * Pobiera dane książki o podanym id.
     *
     * @param int $id
     * @return array
     */
    public function pobierz($id)
    {
        return $this->db->pobierz('ksiazki', $id);
    }

    /**
     * Pobiera najlepiej sprzedające się książki.
     *
     */
    public function pobierzBestsellery()
    {
        
	$sql = "SELECT k.id, k.tytul, a.imie, a.nazwisko, k.opis, k.isbn, k.cena, k.liczba_stron, k.zdjecie FROM ksiazki k, autorzy a JOIN autorzy WHERE k.id_autora=a.id ORDER BY RAND() LIMIT 5";
	return $this->db->pobierzWszystko($sql);
        // uzupełnić funkcję
    }
}
