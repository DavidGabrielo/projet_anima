<?php
require_once "../../model/model.php";
class Model extends Database
{
    public function slctFonction()
    {
        return $this->getconnexion()->query("SELECT * FROM fonction ORDER BY id")->fetchAll();
    }

    public function create(string $code, string $prenom, string $nom, string $dtns, string $lieuns, string $adresse, string $photo, string $contact, int $fonction)
    {
        $slctRedondance = $this->getconnexion()->prepare("SELECT * FROM personnel WHERE code = :code");
        $slctRedondance->execute([
            "code" => $code
        ]);
        $tabPersonnel = $slctRedondance->fetchAll();
        $nbRedondance = count($tabPersonnel);

        if ($nbRedondance > 0) {
            return "redondance";
        } else {
            $insert = $this->getconnexion()->prepare("INSERT INTO personnel(code, prenom, nom, dtns, lieuns, adresse, photo, contact, fonction) 
            VALUES(:code, :prenom, :nom, :dtns, :lieuns, :adresse, :photo, :contact, :fonction)");

            return $insert->execute([
                "code" => $code,
                "prenom" => $prenom,
                "nom" => $nom,
                "dtns" => $dtns,
                "lieuns" => $lieuns,
                "adresse" => $adresse,
                "photo" => $photo,
                "contact" => $contact,
                "fonction" => $fonction
            ]);
        }
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

    public function getInfoPersonnel(int $id)
    {
        $q = $this->getconnexion()->prepare("SELECT * FROM personnel WHERE id = :id");
        $q->execute(['id' => $id]);
        return $q->fetch(PDO::FETCH_OBJ);
    }

    public function getPhotoEtudiant(int $id)
    {
        $q = $this->getconnexion()->prepare("SELECT * FROM inscription WHERE id = :id");
        $q->execute(['id' => $id]);
        return $q->fetch();
    }

    public function update(int $id, string $code, string $prenom, string $nom, string $dtns, string $lieuns, string $adresse, string $photo, string $contact)
    {
        // $tabPhotoSlct = $this->getPhotoEtudiant($id);
        // $photoSlct = $tabPhotoSlct["photo"];
        // unlink("photos/" . $photoSlct);

        $slctRedondance = $this->getconnexion()->prepare("SELECT * FROM personnel WHERE code = :code  AND id <> :id");
        $slctRedondance->execute([
            "code" => $code,
            "id" => $id
        ]);
        $tabClasse = $slctRedondance->fetchAll();
        $nbRedondance = count($tabClasse);

        if ($nbRedondance > 0) {
            return "echec";
        } else {
            $update = $this->getconnexion()->prepare("UPDATE personnel SET code = :code, prenom = :prenom, nom = :nom, dtns = :dtns, lieuns = :lieuns, adresse = :adresse, photo = :photo, contact = :contact  WHERE id = :id");

            return $update->execute([
                "code" => $code,
                "prenom" => $prenom,
                "nom" => $nom,
                "dtns" => $dtns,
                "lieuns" => $lieuns,
                "adresse" => $adresse,
                "photo" => $photo,
                "contact" => $contact,
                "id" => $id
            ]);
        }
    }

    public function delete(int $id)
    {
        $q = $this->getconnexion()->prepare("DELETE FROM personnel WHERE id = :id");
        return $q->execute(['id' => $id]);
    }
}
