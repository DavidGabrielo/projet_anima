<?php
require_once "../../model/model.php";
class Model extends Database
{
    public function slctNiveau()
    {
        return $this->getconnexion()->query("SELECT * FROM niveau WHERE categorie = 1 ORDER BY id")->fetchAll();
    }

    public function create(string $matiere, int $niveau, int $coeff)
    {
        $slctRedondance = $this->getconnexion()->prepare("SELECT * FROM matieres WHERE matieres = :matiere AND niveau = :niveau AND categorie = 1");
        $slctRedondance->execute([
            "matiere" => $matiere,
            "niveau" => $niveau
        ]);
        $tabClasse = $slctRedondance->fetchAll();
        $nbRedondance = count($tabClasse);
        if ($nbRedondance > 0) {
            return "echec";
        } else {
            $q = $this->getconnexion()->prepare("INSERT INTO matieres(matieres, coeff, niveau, categorie) 
        VALUES(:matiere, :coeff, :niveau, :categorie)");

            return $q->execute([
                "matiere" => $matiere,
                "coeff" => $coeff,
                "niveau" => $niveau,
                "categorie" => 1
            ]);
        }
    }

    public function lectureAvecId(int $id)
    {
        return $this->getconnexion()->query("SELECT * FROM matieres WHERE niveau = $id AND categorie = 1 ORDER BY id")->fetchAll(PDO::FETCH_OBJ);
    }

    public function lectureSansId()
    {
        $tabNiveau = $this->slctNiveau();
        if (count($tabNiveau) > 0) {
            $idNiveau = $tabNiveau[0]["id"];
            return $this->getconnexion()->query("SELECT * FROM matieres WHERE niveau = $idNiveau AND categorie = 1 ORDER BY id")->fetchAll(PDO::FETCH_OBJ);
        }
    }

    public function countBills()
    {
        return (int)$this->getconnexion()->query("SELECT COUNT(id) as count FROM niveau WHERE categorie = 1")->fetch()[0];
    }

    public function getSingleMatiere(int $id)
    {
        $q = $this->getconnexion()->prepare("SELECT * FROM matieres WHERE id = :id");
        $q->execute(['id' => $id]);
        return $q->fetch(PDO::FETCH_OBJ);
    }

    public function update(string $matieres, int $coeff, int $id)
    {
        // SELECTION DE DOUBLON
        $slctDoublon = $this->getconnexion()->prepare("SELECT * FROM matieres WHERE matieres = :matieres AND id <> :id");
        $slctDoublon->execute([
            "matieres" => $matieres,
            "id" => $id
        ]);
        if (count($slctDoublon->fetchAll()) > 0) {
            return "echec";
        } else {
            $q = $this->getconnexion()->prepare("UPDATE matieres SET matieres = :matieres, coeff = :coeff WHERE id = :id");
            return $q->execute([
                "matieres" => $matieres,
                "coeff" => $coeff,
                "id" => $id
            ]);
        }
    }

    public function delete(int $id)
    {
        $q = $this->getconnexion()->prepare("DELETE FROM matieres WHERE id = :id");
        return $q->execute(['id' => $id]);
    }
}
