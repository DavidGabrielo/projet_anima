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

    public function confirmPayement(int $id, string $mois)
    {
        $tabPayement = $this->getPayement($id);
        if (count($tabPayement) > 0) {
            $moisSlct = $tabPayement[0]["mois"];
            $moisUpdate = $moisSlct . " , " . $mois;
            $update = $this->getconnexion()->prepare("UPDATE payement SET mois = :mois WHERE annee = :annee");
            return $update->execute([
                "mois" => $moisUpdate,
                "annee" => $id
            ]);
        } else {
            $insert = $this->getconnexion()->prepare("INSERT INTO payement(annee, mois) VALUES(:annee, :mois)");
            return $insert->execute([
                "annee" => $id,
                "mois" => $mois
            ]);
        }
    }
}
