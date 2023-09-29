<?php
require_once "../../model/model.php";
class Model extends Database
{
    public function slctAnnee()
    {
        $slctAnnee = $this->getconnexion()->prepare("SELECT * FROM annee_scolaire WHERE activite = 1");
        $slctAnnee->execute();
        $tabAnnee = $slctAnnee->fetchAll();
        if (count($tabAnnee) > 0) {
        } else {
            return $this->getconnexion()->query("DELETE FROM inscription WHERE categorie = 1");
        }
    }
    public function create(string $niveau, string $abr)
    {
        $slctRedondance = $this->getconnexion()->prepare("SELECT * FROM niveau WHERE niveau = :niveau OR abr = :abr");
        $slctRedondance->execute([
            "niveau" => $niveau,
            "abr" => $abr
        ]);
        $tabNiveau = $slctRedondance->fetchAll();
        $nbRedondance = count($tabNiveau);
        if ($nbRedondance > 0) {
            return "echec";
        } else {
            $q = $this->getconnexion()->prepare("INSERT INTO niveau(niveau, abr, categorie) 
        VALUES(:niveau, :abr, :categorie)");

            return $q->execute([
                "niveau" => $niveau,
                "abr" => $abr,
                "categorie" => 1
            ]);
        }
    }

    public function read()
    {
        return $this->getconnexion()->query("SELECT * FROM niveau WHERE categorie = 1 ORDER BY id")->fetchAll(PDO::FETCH_OBJ);
    }

    public function countBills()
    {
        return (int)$this->getconnexion()->query("SELECT COUNT(id) as count FROM niveau WHERE categorie = 1")->fetch()[0];
    }

    public function getSingleBill(int $id)
    {
        $q = $this->getconnexion()->prepare("SELECT * FROM niveau WHERE id = :id");
        $q->execute(['id' => $id]);
        return $q->fetch(PDO::FETCH_OBJ);
    }

    public function update($id, string $niveau, string $abr)
    {
        // SELECTION DE DOUBLON PAR NIVEAU
        $slctDoublon = $this->getconnexion()->prepare("SELECT * FROM niveau WHERE niveau = :niveau AND id <> :id");
        $slctDoublon->execute([
            "niveau" => $niveau,
            "id" => $id
        ]);
        if (count($slctDoublon->fetchAll()) > 0) {
            return "echec";
        } else {
            // SELECTION DE DOUBLON PAR abr
            $slctDoublon2 = $this->getconnexion()->prepare("SELECT * FROM niveau WHERE abr = :abr AND id <> :id");
            $slctDoublon2->execute([
                "abr" => $abr,
                "id" => $id
            ]);
            if (count($slctDoublon2->fetchAll()) > 0) {
                return "echec";
            } else {
                $q = $this->getconnexion()->prepare("UPDATE niveau SET niveau = :niveau, abr = :abr WHERE id = :id");
                return $q->execute([
                    "niveau" => $niveau,
                    "abr" => $abr,
                    "id" => $id
                ]);
            }
        }
    }

    public function delete(int $id)
    {
        $q = $this->getconnexion()->prepare("DELETE FROM niveau WHERE id = :id");
        return $q->execute(['id' => $id]);
    }
}
