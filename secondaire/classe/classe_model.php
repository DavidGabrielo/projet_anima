<?php
require_once "../../model/model.php";
class Model extends Database
{
    // SELECTION DE L'ID niveau
    // public function slctIdNiveau(){
    //     $slctId = $this->getconnexion()->prepare("SELECT * FROM ")
    // }

    // SELECTION DE NIVEAU
    public function slctNiveau()
    {
        return $this->getconnexion()->query("SELECT * FROM niveau WHERE categorie = 2 ORDER BY id")->fetchAll();
    }

    public function create(string $classe, int $niveau, int $nb)
    {
        $slctRedondance = $this->getconnexion()->prepare("SELECT * FROM classe WHERE classe = :classe");
        $slctRedondance->execute([
            "classe" => $classe
        ]);
        $tabClasse = $slctRedondance->fetchAll();
        $nbRedondance = count($tabClasse);
        if ($nbRedondance > 0) {
            return "echec";
        } else {
            $q = $this->getconnexion()->prepare("INSERT INTO classe(classe, niveau, nb_eleve_max, categorie) 
        VALUES(:classe, :niveau, :nb, :categorie)");

            return $q->execute([
                "classe" => $classe,
                "niveau" => $niveau,
                "nb" => $nb,
                "categorie" => 2
            ]);
        }
    }

    public function lectureAvecId(int $id)
    {
        return $this->getconnexion()->query("SELECT * FROM classe WHERE niveau = $id AND categorie = 2 ORDER BY id")->fetchAll(PDO::FETCH_OBJ);
    }

    public function lectureSansId()
    {
        $tabNiveau = $this->slctNiveau();
        if (count($tabNiveau) > 0) {
            $idNiveau = $tabNiveau[0]["id"];
            return $this->getconnexion()->query("SELECT * FROM classe WHERE niveau = $idNiveau AND categorie = 2 ORDER BY id")->fetchAll(PDO::FETCH_OBJ);
        }
    }

    public function countBills()
    {
        return (int)$this->getconnexion()->query("SELECT COUNT(id) as count FROM niveau WHERE categorie = 2")->fetch()[0];
    }

    public function getSingleClasse(int $id)
    {
        $q = $this->getconnexion()->prepare("SELECT * FROM classe WHERE id = :id");
        $q->execute(['id' => $id]);
        return $q->fetch(PDO::FETCH_OBJ);
    }

    public function update(string $classe, int $nb, int $id)
    {
        // SELECTION DE DOUBLON
        $slctDoublon = $this->getconnexion()->prepare("SELECT * FROM classe WHERE classe = :classe AND id <> :id");
        $slctDoublon->execute([
            "classe" => $classe,
            "id" => $id
        ]);
        if (count($slctDoublon->fetchAll()) > 0) {
            return "echec";
        } else {
            $q = $this->getconnexion()->prepare("UPDATE classe SET classe = :classe, nb_eleve_max = :nb WHERE id = :id");
            return $q->execute([
                "classe" => $classe,
                "nb" => $nb,
                "id" => $id
            ]);
        }
    }

    public function delete(int $id)
    {
        $q = $this->getconnexion()->prepare("DELETE FROM classe WHERE id = :id");
        return $q->execute(['id' => $id]);
    }
}
