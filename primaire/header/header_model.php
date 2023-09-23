<?php
require_once "../../model/model.php";
class Model extends Database
{
    // PARAMETRE DE L'ANNEE
    public function createNouvelleAnnee(int $debut, int $fin, string $debutMois, string $nbMois)
    {
        // VERIFIER SI L'annee EXISTE DEJA
        $slctAnnee = $this->getconnexion()->prepare("SELECT * FROM annee_scolaire WHERE debut_annee = :debut AND fin_annee = :fin");
        $slctAnnee->execute([
            "debut" => $debut,
            "fin" => $fin
        ]);
        $tabAnnee = $slctAnnee->fetchAll();
        if (count($tabAnnee) > 0) {
            echo 0;
        } else {
            $this->getconnexion()->query("UPDATE annee_scolaire SET activite = 0");
            $q = $this->getconnexion()->prepare("INSERT INTO annee_scolaire(debut_annee, fin_annee, activite, mois_debut, nb_mois) 
        VALUES(:debut_annee, :fin_annee, :activite, :mois_debut, :nb_mois)");

            return $q->execute([
                "debut_annee" => $debut,
                "fin_annee" => $fin,
                "activite" => 1,
                "mois_debut" => $debutMois,
                "nb_mois" => $nbMois
            ]);
        }
    }

    public function readAnnee()
    {
        return $this->getconnexion()->query("SELECT * FROM annee_scolaire WHERE activite = 1")->fetchAll();
    }

    public function countAnnee()
    {
        return (int)$this->getconnexion()->query("SELECT COUNT(id) as count FROM annee_scolaire WHERE activite = 1")->fetch()[0];
    }

    public function getAnnee()
    {
        $q = $this->getconnexion()->prepare("SELECT * FROM annee_scolaire WHERE activite = 1");
        $q->execute();
        return $q->fetch(PDO::FETCH_OBJ);
    }

    public function slctDoublon(int $debut, int $fin)
    {
        $q = $this->getconnexion()->prepare("SELECT * FROM annee_scolaire WHERE debut_annee = :debut AND fin_annee = :fin AND activite <> 1");
        $q->execute([
            "debut" => $debut,
            "fin" => $fin
        ]);
        return count($q->fetchAll());
    }

    public function updateAnnee(int $debut, int $fin, string $debutMois, string $nbMois)
    {
        $q = $this->getconnexion()->prepare("UPDATE annee_scolaire SET debut_annee = :debut, fin_annee = :fin, mois_debut = :mois_debut, nb_mois = :nb_mois WHERE activite = 1");
        return $q->execute([
            "debut" => $debut,
            "fin" => $fin,
            "mois_debut" => $debutMois,
            "nb_mois" => $nbMois
        ]);
    }
}
