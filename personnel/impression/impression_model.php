<?php
require_once "../../model/model.php";
class Model extends Database
{
    public function slctFonction()
    {
        return $this->getconnexion()->query("SELECT * FROM fonction ORDER BY id")->fetchAll();
    }

    public function lectureAvecId(int $idFonction)
    {
        return $this->getconnexion()->query("SELECT * FROM personnel WHERE fonction = $idFonction ORDER BY id")->fetchAll(PDO::FETCH_OBJ);
    }

    public function lectureSansId()
    {
        $tabFonction = $this->slctFonction();
        if (count($tabFonction) > 0) {
            // SELECT DE L'id DE niveau
            $idFonction = $tabFonction[0]["id"];
            return $this->getconnexion()->query("SELECT * FROM personnel WHERE fonction = $idFonction ORDER BY id")->fetchAll(PDO::FETCH_OBJ);
        }
    }
}
