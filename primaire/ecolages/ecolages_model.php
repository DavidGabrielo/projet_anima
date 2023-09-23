<?php
require_once "../../model/model.php";
class Model extends Database
{
    public function slctNiveau()
    {
        return $this->getconnexion()->query("SELECT * FROM niveau WHERE categorie = 1 ORDER BY id")->fetchAll();
    }

    public function slctClasse($idNiveau)
    {
        $slctClasse = $this->getconnexion()->prepare("SELECT * FROM classe WHERE categorie = 1 AND niveau = :niveau ORDER BY id");
        $slctClasse->execute([
            "niveau" => $idNiveau
        ]);
        return $slctClasse->fetchAll();
    }

    public function slctAnnee()
    {
        $slctAnnee = $this->getconnexion()->prepare("SELECT * FROM annee_scolaire WHERE activite = 1");
        $slctAnnee->execute();
        $tabAnnee = $slctAnnee->fetchAll();
        return $tabAnnee;
        // if (count($tabAnnee) > 0) {
        //     return $tabAnnee[0]["id"];
        // }
    }

    public function lectureAvecId(int $idNiveau, int $idClasse)
    {
        return $this->getconnexion()->query("SELECT * FROM inscription WHERE categorie = 1 AND niveau = $idNiveau AND classe = $idClasse ORDER BY id")->fetchAll(PDO::FETCH_OBJ);
    }

    public function lectureSansId()
    {
        $tabNiveau = $this->slctNiveau();
        if (count($tabNiveau) > 0) {
            // SELECT DE L'id DE niveau
            $idNiveau = $tabNiveau[0]["id"];

            // SELECTION DE L'id DE classe
            $tabClasse = $this->slctClasse($idNiveau);
            $idClasse = $tabClasse[0]["id"];

            return $this->getconnexion()->query("SELECT * FROM inscription WHERE categorie = 1 AND niveau = $idNiveau AND classe = $idClasse ORDER BY id")->fetchAll(PDO::FETCH_OBJ);
        }
    }

    public function countBills()
    {
        return (int)$this->getconnexion()->query("SELECT COUNT(id) as count FROM niveau WHERE categorie = 1")->fetch()[0];
    }

    public function getSingleClasse(int $id)
    {
        $q = $this->getconnexion()->prepare("SELECT * FROM classe WHERE id = :id");
        $q->execute(['id' => $id]);
        return $q->fetch(PDO::FETCH_OBJ);
    }

    public function getInfoEtudiant(int $id)
    {
        $q = $this->getconnexion()->prepare("SELECT * FROM inscription WHERE id = :id");
        $q->execute(['id' => $id]);
        return $q->fetch(PDO::FETCH_OBJ);
    }

    public function getPhotoEtudiant(int $id)
    {
        $q = $this->getconnexion()->prepare("SELECT * FROM inscription WHERE id = :id");
        $q->execute(['id' => $id]);
        return $q->fetch();
    }

    public function getEcolage(int $id)
    {
        return $q = $this->getconnexion()->query("SELECT * FROM ecolages WHERE etudiant = $id")->fetchAll();
    }

    public function confirmEcolage(int $id, string $mois)
    {
        $tabEcolage = $this->getEcolage($id);
        if (count($tabEcolage) > 0) {
            $moisSlct = $tabEcolage[0]["mois"];
            $moisUpdate = $moisSlct . " , " . $mois;
            $update = $this->getconnexion()->prepare("UPDATE ecolages SET mois = :mois WHERE etudiant = :etudiant");
            return $update->execute([
                "mois" => $moisUpdate,
                "etudiant" => $id
            ]);
        } else {
            $insert = $this->getconnexion()->prepare("INSERT INTO ecolages(etudiant, mois) VALUES(:etudiant, :mois)");
            return $insert->execute([
                "etudiant" => $id,
                "mois" => $mois
            ]);
        }
    }
}
