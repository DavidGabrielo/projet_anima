<?php
require_once "model/model.php";
class Model extends Database
{
    public function slctDoublon($prenom)
    {
        $selection = $this->getconnexion()->prepare("SELECT * FROM singin WHERE prenom = :prenom");
        $selection->execute([
            "prenom" => $prenom
        ]);
        return $selection->fetchAll();
    }
}
