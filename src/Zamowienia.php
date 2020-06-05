<?php

namespace Ibd;

class Zamowienia
{
    /**
     * Instancja klasy obsługującej połączenie do bazy.
     *
     * @var Db
     */
    private $db;

    public function __construct()
    {
        $this->db = new Db();
    }

    /**
     * Dodaje zamówienie.
     * 
     * @param int $idUzytkownika
     * @return int Id zamówienia
     */
    public function dodaj($idUzytkownika)
    {
        return $this->db->dodaj('zamowienia', [
            'id_uzytkownika' => $idUzytkownika,
            'id_statusu' => 1
        ]);
    }

    /**
     * Dodaje szczegóły zamówienia.
     * 
     * @param int $idZamowienia
     * @param array $dane Książki do zamówienia
     */
    public function dodajSzczegoly($idZamowienia, $dane)
    {
        foreach ($dane as $ksiazka) {
            $this->db->dodaj('zamowienia_szczegoly', [
                'id_zamowienia' => $idZamowienia,
                'id_ksiazki' => $ksiazka['id'],
                'cena' => $ksiazka['cena'],
                'liczba_sztuk' => $ksiazka['liczba_sztuk']
            ]);
        }
    }

     /**
     * Znajdz zamowienia
     * 
     * @param int $idUzytkownika
     * @return
     */
    public function znajdzZamownienia($idUzytkownika)
    {
        $dane = $this->db->pobierzWszystko(
            "SELECT z.id, z.id_uzytkownika, count(*) ilosc_pozycji, SUM(ROUND(zs.cena*zs.liczba_sztuk,2)) as wartosc_zamowienia, sum(zs.liczba_sztuk) as ilosc_ksiazek FROM zamowienia z 
            JOIN zamowienia_szczegoly zs ON zs.id_zamowienia = z.id 
            JOIN zamowienia_statusy zstatus on zstatus.id = z.id_statusu 
            GROUP BY z.id 
            HAVING z.id_uzytkownika = :id", ['id' => $idUzytkownika]
        );

        return $dane;
    }

    /**
     * Pobiera wszystkie zamówienia.
     *
     * @return array
     */
    public function pobierzWszystkie()
    {
        $sql = "
			SELECT z.*, u.login, s.nazwa AS status,
			ROUND(SUM(sz.cena*sz.liczba_sztuk), 2) AS suma,
			COUNT(sz.id) AS liczba_produktow,
			SUM(sz.liczba_sztuk) AS liczba_sztuk
			FROM zamowienia z JOIN uzytkownicy u ON z.id_uzytkownika = u.id
			JOIN zamowienia_statusy s ON z.id_statusu = s.id
			JOIN zamowienia_szczegoly sz ON z.id = sz.id_zamowienia
			GROUP BY z.id
	    ";

        return $this->db->pobierzWszystko($sql);
    }
}
