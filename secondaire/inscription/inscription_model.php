<?php
require_once "../../model/model.php";
class Model extends Database
{
    public function slctNiveau()
    {
        return $this->getconnexion()->query("SELECT * FROM niveau WHERE categorie = 2 ORDER BY id")->fetchAll();
    }

    public function slctClasse($idNiveau)
    {
        $slctClasse = $this->getconnexion()->prepare("SELECT * FROM classe WHERE categorie = 2 AND niveau = :niveau ORDER BY id");
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
        if (count($tabAnnee) > 0) {
            return $tabAnnee[0]["id"];
        } else {
            return "aucune annee";
        }
    }

    public function slctNbClasse($classe)
    {
        $slct = $this->getconnexion()->prepare("SELECT * FROM classe WHERE id = :id");
        $slct->execute([
            "id" => $classe
        ]);
        $tabClasse = $slct->fetchAll();
        return $tabClasse[0]["nb_eleve_max"];
    }

    public function create(string $numero, string $prenom, string $nom, string $dtns, string $lieuns, string $adresse, string $photo, string $pere, string $professionPere, string $contactPere, string $mere, string $professionMere, string $contactMere, string $repondant, string $professionRepondant, string $contactRepondant, int $niveau, int $classe, int $annee)
    {
        $slctRedondance = $this->getconnexion()->prepare("SELECT * FROM inscription WHERE numero = :numero AND categorie = 2 AND niveau = :niveau AND classe = :classe AND annee = :annee");
        $slctRedondance->execute([
            "numero" => $numero,
            "niveau" => $niveau,
            "classe" => $classe,
            "annee" => $annee
        ]);
        $tabClasse = $slctRedondance->fetchAll();
        $nbRedondance = count($tabClasse);

        if ($nbRedondance > 0) {
            return "echec";
        } else {
            $tabNiveau = $this->slctNiveau();
            if (count($tabNiveau) > 0) {
                $tabClasse = $this->slctClasse($niveau);
                if (count($tabClasse) > 0) {
                    if ($this->slctAnnee() == "aucune annee") {
                        return "aucune annee";
                    } else {
                        $nbElevesMax = $this->slctNbClasse($classe);
                        $tabInscription = $this->lectureAvecId($niveau, $classe);
                        $nbInscrits = count($tabInscription);

                        if ($nbInscrits < $nbElevesMax) {
                            $insert = $this->getconnexion()->prepare("INSERT INTO inscription(numero, prenom, nom, dtns, lieuns, adresse, photo, pere, profession_pere, contact_pere, mere, profession_mere, contact_mere, repondant, profession_repondant, contact_repondant, categorie, niveau, classe, annee) 
            VALUES(:numero, :prenom, :nom, :dtns, :lieuns, :adresse, :photo, :pere, :profession_pere, :contact_pere, :mere, :profession_mere, :contact_mere, :repondant, :profession_repondant, :contact_repondant, :categorie, :niveau, :classe, :annee)");

                            return $insert->execute([
                                "numero" => $numero,
                                "prenom" => $prenom,
                                "nom" => $nom,
                                "dtns" => $dtns,
                                "lieuns" => $lieuns,
                                "adresse" => $adresse,
                                "photo" => $photo,
                                "pere" => $pere,
                                "profession_pere" => $professionPere,
                                "contact_pere" => $contactPere,
                                "mere" => $mere,
                                "profession_mere" => $professionMere,
                                "contact_mere" => $contactMere,
                                "repondant" => $repondant,
                                "profession_repondant" => $professionRepondant,
                                "contact_repondant" => $contactRepondant,
                                "categorie" => 2,
                                "niveau" => $niveau,
                                "classe" => $classe,
                                "annee" => $annee
                            ]);
                        } else {
                            return $nbElevesMax;
                        }
                    }
                } else {
                    return "aucune classe";
                }
            } else {
                return "aucun niveau";
            }
        }
    }

    public function lectureAvecId(int $idNiveau, int $idClasse)
    {
        return $this->getconnexion()->query("SELECT * FROM inscription WHERE categorie = 2 AND niveau = $idNiveau AND classe = $idClasse ORDER BY id")->fetchAll(PDO::FETCH_OBJ);
    }

    public function lectureSansId()
    {
        $tabNiveau = $this->slctNiveau();
        if (count($tabNiveau) > 0) {
            // SELECT DE L'id DE niveau
            $idNiveau = $tabNiveau[0]["id"];

            // SELECTION DE L'id DE classe
            $tabClasse = $this->slctClasse($idNiveau);
            if (count($tabClasse) > 0) {
                $idClasse = $tabClasse[0]["id"];
                return $this->getconnexion()->query("SELECT * FROM inscription WHERE categorie = 2 AND niveau = $idNiveau AND classe = $idClasse ORDER BY id")->fetchAll(PDO::FETCH_OBJ);
            }
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

    public function update(int $id, string $numero, string $prenom, string $nom, string $dtns, string $lieuns, string $adresse, string $photo, string $pere, string $professionPere, string $contactPere, string $mere, string $professionMere, string $contactMere, string $repondant, string $professionRepondant, string $contactRepondant, int $niveau, int $classe, int $annee)
    {
        // $tabPhotoSlct = $this->getPhotoEtudiant($id);
        // $photoSlct = $tabPhotoSlct["photo"];
        // unlink("photos/" . $photoSlct);

        $slctRedondance = $this->getconnexion()->prepare("SELECT * FROM inscription WHERE numero = :numero AND categorie = 2 AND niveau = :niveau AND classe = :classe AND annee = :annee AND id <> :id");
        $slctRedondance->execute([
            "numero" => $numero,
            "niveau" => $niveau,
            "classe" => $classe,
            "annee" => $annee,
            "id" => $id
        ]);
        $tabClasse = $slctRedondance->fetchAll();
        $nbRedondance = count($tabClasse);

        if ($nbRedondance > 0) {
            return "echec";
        } else {
            $update = $this->getconnexion()->prepare("UPDATE inscription SET numero = :numero, prenom = :prenom, nom = :nom, dtns = :dtns, lieuns = :lieuns, adresse = :adresse, photo = :photo, pere = :pere, profession_pere = :profession_pere, contact_pere = :contact_pere, mere = :mere, profession_mere = :profession_mere, contact_mere = :contact_mere, repondant = :repondant, profession_repondant = :profession_repondant, contact_repondant = :contact_repondant, categorie = :categorie, niveau = :niveau, classe = :classe, annee = :annee WHERE id = :id");

            return $update->execute([
                "numero" => $numero,
                "prenom" => $prenom,
                "nom" => $nom,
                "dtns" => $dtns,
                "lieuns" => $lieuns,
                "adresse" => $adresse,
                "photo" => $photo,
                "pere" => $pere,
                "profession_pere" => $professionPere,
                "contact_pere" => $contactPere,
                "mere" => $mere,
                "profession_mere" => $professionMere,
                "contact_mere" => $contactMere,
                "repondant" => $repondant,
                "profession_repondant" => $professionRepondant,
                "contact_repondant" => $contactRepondant,
                "categorie" => 2,
                "niveau" => $niveau,
                "classe" => $classe,
                "annee" => $annee,
                "id" => $id
            ]);
        }
    }

    public function delete(int $id)
    {
        $q = $this->getconnexion()->prepare("DELETE FROM inscription WHERE id = :id");
        return $q->execute(['id' => $id]);
    }
}
