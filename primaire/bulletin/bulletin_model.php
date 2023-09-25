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

    public function slctNomClasse($idClasse)
    {
        return $this->getconnexion()->query("SELECT * FROM classe WHERE id = $idClasse")->fetchAll();
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
            if (count($tabClasse) > 0) {
                $idClasse = $tabClasse[0]["id"];
                return $this->getconnexion()->query("SELECT * FROM inscription WHERE categorie = 1 AND niveau = $idNiveau AND classe = $idClasse ORDER BY id")->fetchAll(PDO::FETCH_OBJ);
            }
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

    public function getMatiere(int $niveau)
    {
        return $q = $this->getconnexion()->query("SELECT * FROM matieres WHERE niveau = $niveau")->fetchAll();
    }

    public function getNotes(int $etudiant, int $matiere, int $niveau, int $classe, int $annee)
    {
        return $q = $this->getconnexion()->query("SELECT * FROM notes WHERE etudiant = $etudiant AND matiere = $matiere AND categorie = 1 AND  niveau = $niveau AND classe = $classe AND annee = $annee")->fetchAll();
    }

    public function getNotesPrecise(int $etudiant, int $matiere, string $type, int $niveau, int $classe, int $annee)
    {
        $tabNotes = $this->getNotes($etudiant, $matiere, $niveau, $classe, $annee);
        if (count($tabNotes) > 0) {
            return $tabNotes[0][$type];
        } else {
            return 0;
        }
    }

    public function insertNote(int $etudiant, int $matiere, string $type, int $niveau, int $classe, int $annee, int $note)
    {
        $tabNotes = $this->getNotes($etudiant, $matiere, $niveau, $classe, $annee);
        if (count($tabNotes) > 0) {
            if ($type == "interro_1") {
                return $this->getconnexion()->query("UPDATE notes SET $type = $note, conf_interro_1 = 1 WHERE etudiant = $etudiant AND matiere = $matiere AND categorie = 1 AND niveau = $niveau AND classe = $classe AND annee = $annee");
            } elseif ($type == "exam_1") {
                return $this->getconnexion()->query("UPDATE notes SET $type = $note, conf_exam_1 = 1 WHERE etudiant = $etudiant AND matiere = $matiere AND categorie = 1 AND niveau = $niveau AND classe = $classe AND annee = $annee");
            } elseif ($type == "interro_2") {
                return $this->getconnexion()->query("UPDATE notes SET $type = $note, conf_interro_2 = 1 WHERE etudiant = $etudiant AND matiere = $matiere AND categorie = 1 AND niveau = $niveau AND classe = $classe AND annee = $annee");
            } elseif ($type == "exam_2") {
                return $this->getconnexion()->query("UPDATE notes SET $type = $note, conf_exam_2 = 1 WHERE etudiant = $etudiant AND matiere = $matiere AND categorie = 1 AND niveau = $niveau AND classe = $classe AND annee = $annee");
            } elseif ($type == "interro_3") {
                return $this->getconnexion()->query("UPDATE notes SET $type = $note, conf_interro_3 = 1 WHERE etudiant = $etudiant AND matiere = $matiere AND categorie = 1 AND niveau = $niveau AND classe = $classe AND annee = $annee");
            } elseif ($type == "exam_3") {
                return $this->getconnexion()->query("UPDATE notes SET $type = $note, conf_exam_3 = 1 WHERE etudiant = $etudiant AND matiere = $matiere AND categorie = 1 AND niveau = $niveau AND classe = $classe AND annee = $annee");
            }
        } else {
            if ($type == "interro_1") {
                return $this->getconnexion()->query("INSERT INTO notes(etudiant, matiere, interro_1, conf_interro_1, exam_1, conf_exam_1, interro_2, conf_interro_2, exam_2, conf_exam_2, interro_3, conf_interro_3, exam_3, conf_exam_3, categorie, niveau, classe, annee) VALUES($etudiant, $matiere, $note, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, $niveau, $classe, $annee)");
            } elseif ($type == "exam_1") {
                return $this->getconnexion()->query("INSERT INTO notes(etudiant, matiere, interro_1, conf_interro_1, exam_1, conf_exam_1, interro_2, conf_interro_2, exam_2, conf_exam_2, interro_3, conf_interro_3, exam_3, conf_exam_3, categorie, niveau, classe, annee) VALUES($etudiant, $matiere, 0, 0, $note, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, $niveau, $classe, $annee)");
            } elseif ($type == "interro_2") {
                return $this->getconnexion()->query("INSERT INTO notes(etudiant, matiere, interro_1, conf_interro_1, exam_1, conf_exam_1, interro_2, conf_interro_2, exam_2, conf_exam_2, interro_3, conf_interro_3, exam_3, conf_exam_3, categorie, niveau, classe, annee) VALUES($etudiant, $matiere, 0, 0, 0, 0, $note, 1, 0, 0, 0, 0, 0, 0, 1, $niveau, $classe, $annee)");
            } elseif ($type == "exam_2") {
                return $this->getconnexion()->query("INSERT INTO notes(etudiant, matiere, interro_1, conf_interro_1, exam_1, conf_exam_1, interro_2, conf_interro_2, exam_2, conf_exam_2, interro_3, conf_interro_3, exam_3, conf_exam_3, categorie, niveau, classe, annee) VALUES($etudiant, $matiere, 0, 0, 0, 0, 0, 0, $note, 1, 0, 0, 0, 0, 1, $niveau, $classe, $annee)");
            } elseif ($type == "interro_3") {
                return $this->getconnexion()->query("INSERT INTO notes(etudiant, matiere, interro_1, conf_interro_1, exam_1, conf_exam_1, interro_2, conf_interro_2, exam_2, conf_exam_2, interro_3, conf_interro_3, exam_3, conf_exam_3, categorie, niveau, classe, annee) VALUES($etudiant, $matiere, 0, 0, 0, 0, 0, 0, 0, 0, $note, 1, 0, 0, 1, $niveau, $classe, $annee)");
            } elseif ($type == "exam_3") {
                return $this->getconnexion()->query("INSERT INTO notes(etudiant, matiere, interro_1, conf_interro_1, exam_1, conf_exam_1, interro_2, conf_interro_2, exam_2, conf_exam_2, interro_3, conf_interro_3, exam_3, conf_exam_3, categorie, niveau, classe, annee) VALUES($etudiant, $matiere, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, $note, 1, 1, $niveau, $classe, $annee)");
            }
        }
    }
}
