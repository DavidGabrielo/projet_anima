<?php
require_once "../../model/model.php";
class Model extends Database
{
    public function create(string $fonction, string $prix)
    {
        $slctRedondance = $this->getconnexion()->prepare("SELECT * FROM fonction WHERE fonction = :fonction");
        $slctRedondance->execute([
            "fonction" => $fonction
        ]);
        $tabFonction = $slctRedondance->fetchAll();
        $nbRedondance = count($tabFonction);
        if ($nbRedondance > 0) {
            return "echec";
        } else {
            $q = $this->getconnexion()->prepare("INSERT INTO fonction(fonction, prix) 
        VALUES(:fonction, :prix)");

            return $q->execute([
                "fonction" => $fonction,
                "prix" => $prix
            ]);
        }
    }

    public function read()
    {
        return $this->getconnexion()->query("SELECT * FROM fonction ORDER BY id")->fetchAll(PDO::FETCH_OBJ);
    }

    public function countBills()
    {
        return (int)$this->getconnexion()->query("SELECT COUNT(id) as count FROM fonction")->fetch()[0];
    }

    public function getSingleBill(int $id)
    {
        $q = $this->getconnexion()->prepare("SELECT * FROM fonction WHERE id = :id");
        $q->execute(['id' => $id]);
        return $q->fetch(PDO::FETCH_OBJ);
    }

    public function update($id, string $fonction, string $prix)
    {
        // SELECTION DE DOUBLON PAR fonction
        $slctDoublon = $this->getconnexion()->prepare("SELECT * FROM fonction WHERE fonction = :fonction AND id <> :id");
        $slctDoublon->execute([
            "fonction" => $fonction,
            "id" => $id
        ]);
        if (count($slctDoublon->fetchAll()) > 0) {
            return "echec";
        } else {
            $q = $this->getconnexion()->prepare("UPDATE fonction SET fonction = :fonction, prix = :prix WHERE id = :id");
            return $q->execute([
                "fonction" => $fonction,
                "prix" => $prix,
                "id" => $id
            ]);
        }
    }

    public function delete(int $id)
    {
        $q = $this->getconnexion()->prepare("DELETE FROM fonction WHERE id = :id");
        return $q->execute(['id' => $id]);
    }
}
