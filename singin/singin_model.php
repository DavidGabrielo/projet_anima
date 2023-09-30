<?php
require_once "../model/model.php";
class Model extends Database
{
    public function slctDoublon($prenom)
    {
        $slctDoublon = $this->getconnexion()->prepare("SELECT * FROM singin WHERE prenom = :prenom");
        $slctDoublon->execute([
            "prenom" => $prenom
        ]);
        return $slctDoublon->fetchAll();
        // return $this->getconnexion()->query("SELECT * FROM singin WHERE prenom = $prenom")->fetchAll();
    }
    public function creationCompte($prenom, $nom, $passe)
    {
        $tabSingin = $this->slctDoublon($prenom);
        if (count($tabSingin) > 0) {
            return "Ce prénom est déjà utilisé";
        } else {
            $passeHash = password_hash($passe, PASSWORD_BCRYPT);
            $insert = $this->getconnexion()->prepare("INSERT INTO singin(prenom, nom, passe) VALUES(:prenom, :nom, :passeHash)");
            return $insert->execute([
                "prenom" => $prenom,
                "nom" => $nom,
                "passeHash" => $passeHash
            ]);
        }
    }
}
