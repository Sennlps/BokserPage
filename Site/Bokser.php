<?php

require_once '../DB/Database.php';

class Bokser
{
    private $db;
    public $voornaam;
    public $achternaam;
    public $leeftijd;
    public $titel;
    public $beschrijving;
    public $foto;

    public function __construct()
    {
        $this->db = new DB(); 
    }

    public function insertBokser($voornaam, $achternaam, $leeftijd, $titel, $beschrijving, $foto)
    {
        $sql = "INSERT INTO bokser (voornaam, achternaam, leeftijd, titel, beschrijving, foto) 
                VALUES (:voornaam, :achternaam, :leeftijd, :titel, :beschrijving, :foto)";

        $params = [
            ':voornaam' => $voornaam,
            ':achternaam' => $achternaam,
            ':leeftijd' => $leeftijd,
            ':titel' => $titel,
            ':beschrijving' => $beschrijving,
            ':foto' => $foto
        ];

        return $this->db->run($sql, $params);
    }

    public function getAllBoksers()
    {
        $sql = "SELECT * FROM bokser";
        $result = $this->db->run($sql);

        if ($result) {
            return $result->fetchAll(PDO::FETCH_ASSOC); 
        } else {
            echo "Fout bij het ophalen van de boksers.";
            return [];
        }
    }


    public function editBokser($bokserId, $voornaam, $achternaam, $leeftijd, $titel, $beschrijving, $foto = null)
    {
    if ($foto) {
        $sql = "UPDATE bokser 
                SET voornaam = :voornaam, achternaam = :achternaam, leeftijd = :leeftijd, 
                    titel = :titel, beschrijving = :beschrijving, foto = :foto 
                WHERE bokser_ID = :id";
        $params = [
            ':voornaam' => $voornaam,
            ':achternaam' => $achternaam,
            ':leeftijd' => $leeftijd,
            ':titel' => $titel,
            ':beschrijving' => $beschrijving,
            ':foto' => $foto,
            ':id' => $bokserId
        ];
    } else {
        $sql = "UPDATE bokser 
                SET voornaam = :voornaam, achternaam = :achternaam, leeftijd = :leeftijd, 
                    titel = :titel, beschrijving = :beschrijving 
                WHERE bokser_ID = :id";
        $params = [
            ':voornaam' => $voornaam,
            ':achternaam' => $achternaam,
            ':leeftijd' => $leeftijd,
            ':titel' => $titel,
            ':beschrijving' => $beschrijving,
            ':id' => $bokserId
        ];
    }

    return $this->db->run($sql, $params);
}
 

public function deleteBokser($bokserId)
{
    $sql = "SELECT foto FROM bokser WHERE bokser_ID = :id";
    $params = [':id' => $bokserId];
    $stmt = $this->db->run($sql, $params);
    $bokser = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($bokser) {
        $fotoPath = '../uploads/' . $bokser['foto'];
        if (!empty($bokser['foto']) && file_exists($fotoPath)) {
            unlink($fotoPath);
        }

        $sql = "DELETE FROM bokser WHERE bokser_ID = :id";
        return $this->db->run($sql, $params);
    }

    return false;
}
}

?>
