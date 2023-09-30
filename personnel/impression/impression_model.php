<?php
require_once "../../model/model.php";
class Model extends Database
{
    public function slctAnnee()
    {
        $slctAnnee = $this->getconnexion()->prepare("SELECT * FROM annee_scolaire WHERE activite = 1");
        $slctAnnee->execute();
        $tabAnnee = $slctAnnee->fetchAll();
        return $tabAnnee;
    }

    public function getPayement(int $annee)
    {
        return $q = $this->getconnexion()->query("SELECT * FROM payement WHERE annee = $annee")->fetchAll();
    }

    public function getMois()
    {
        $tabAnnee = $this->slctAnnee();
        if (count($tabAnnee) > 0) {
            $annee = $tabAnnee[0]["id"];
        } else {
            $annee = 0;
        }
        return $q = $this->getconnexion()->query("SELECT * FROM payement WHERE annee = $annee")->fetchAll();
    }

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

    public function slctEmploye()
    {
        return $this->getconnexion()->query("SELECT * FROM personnel ORDER BY id")->fetchAll();
    }
}
