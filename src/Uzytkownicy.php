<?php

namespace Ibd;

class Uzytkownicy
{
    private $options_password = [
        'cost' => 11
    ];
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
     * Dodaje użytkownika do bazy.
     * 
     * @param array $dane
     * @param string $grupa
     * @return int
     */
    public function dodaj($dane, $grupa = 'użytkownik')
    {


        return $this->db->dodaj('uzytkownicy', [
            'imie' => $dane['imie'],
            'nazwisko' => $dane['nazwisko'],
            'adres' => $dane['adres'],
            'telefon' => $dane['telefon'],
            'email' => $dane['email'],
            'login' => $dane['login'],
            'haslo' => password_hash($dane['haslo'], PASSWORD_BCRYPT, $this->options_password),
            'grupa' => $grupa
        ]);
    }

    /**
     * Loguje użytkownika do systemu. Zapisuje dane o autoryzacji do sesji.
     *
     * @param string $login
     * @param string $haslo
     * @param string $grupa
     * @return bool
     */
    public function zaloguj($login, $haslo, $grupa)
    {
        $dane = $this->db->pobierzWszystko(
            "SELECT * FROM uzytkownicy WHERE login = :login AND grupa = '$grupa'", ['login' => $login]
        );

        /**
         * Ważna rzecz, kolumna w bazie ze skryptu Pana Zawadzkiego jest za mała (varchar 50) aby zmieścić bcrypt. (zmienilem na 100)
         */
        if ($dane && password_verify($haslo, $dane[0]['haslo'])) {
            $_SESSION['id_uzytkownika'] = $dane[0]['id'];
            $_SESSION['grupa'] = $dane[0]['grupa'];
            $_SESSION['login'] = $dane[0]['login'];

            return true;
        }

        return false;
    }

    /**
     * Sprawdza czy istnieje uzytkownik o podanym loginie lub emailu
     *
     * @param string $login
     * @param string $email
     * @return bool
     */
    public function czyIstniejeJuzTakiUzytkownik($login, $email)
    {
        $dane = $this->db->pobierzWszystko(
            "SELECT * FROM uzytkownicy WHERE login = :login OR email = :email", ['login' => $login, 'email' => $email]
        );

        if ($dane) {
            return true;
        }
        return false;
    }


}
