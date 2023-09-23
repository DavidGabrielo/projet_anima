<?php
require_once "notes_model.php";
$db = new Model();

if (isset($_POST["slctIdNiveau"])) {
    $tabNiveau = $db->slctNiveau();
    if (count($tabNiveau) > 0) {
        echo $tabNiveau[0]["id"];
    } else {
        echo "";
    }
}

if (isset($_POST["slctIdClasse"])) {
    if (isset($_POST["niveau"])) {
        $tabClasse = $db->slctClasse($_POST["niveau"]);
        if (count($tabClasse) > 0) {
            echo $tabClasse[0]["id"];
        } else {
            echo "";
        }
    } else {
        $tabNiveau = $db->slctNiveau();
        if (count($tabNiveau) > 0) {
            $idNiveau = $tabNiveau[0]["id"];

            $tabClasse = $db->slctClasse($idNiveau);
            if (count($tabClasse) > 0) {
                echo $tabClasse[0]["id"];
            } else {
                echo "";
            }
        } else {
            echo "";
        }
    }
}

if (isset($_POST["slctNiveau"])) {
    $tabNiveau = $db->slctNiveau();
    $liste = "";

    $liste .= "<select class='optionNiveau pt-2 pb-2 w-25 text-center'>";

    for ($i = 0; $i < count($tabNiveau); $i++) {
        $liste .= "<option value='{$tabNiveau[$i]['id']}'>{$tabNiveau[$i]['abr']}</option>";
    }
    $liste .= "</select>";
    echo $liste;
}

if (isset($_POST["slctClasse"])) {
    $tabNiveau = $db->slctNiveau();
    $liste = "";

    if (isset($_POST["niveau"])) {
        // SELECTION DE classe
        $tabClasse = $db->slctClasse($_POST["niveau"]);
        if (count($tabClasse) > 0) {
            $liste .= "<div class='pt-2 pb-2 w-25 text-center'>";

            for ($i = 0; $i < count($tabClasse); $i++) {
                $liste .= "<a href='#' class='lienClasse changement' data-id='{$tabClasse[$i]['id']}'>{$tabClasse[$i]['classe']}</a>";
            }
            $liste .= "</div>";
        }
    } elseif (count($tabNiveau) > 0) {
        $idNiveau = $tabNiveau[0]["id"];

        // SELECTION DE classe
        $tabClasse = $db->slctClasse($idNiveau);
        if (count($tabClasse) > 0) {
            $liste .= "<div class='pt-2 pb-2 w-25 text-center'  aria-labelledby='dropdown04'>";

            for ($i = 0; $i < count($tabClasse); $i++) {
                $liste .= "<a href='#' class='lienClasse changement' data-id='{$tabClasse[$i]['id']}'>{$tabClasse[$i]['classe']}</a>";
            }
            $liste .= "</div>";
        }
    }

    echo $liste;
}

$tabMoiSlct = $db->slctAnnee();
$annee = $tabMoiSlct[0]["id"];

if (isset($_POST["slctId"])) {
    if (isset($_POST["idNiveau"]) && isset($_POST["idClasse"])) {
        $tabInscription = $db->lectureAvecId((int)$_POST["idNiveau"], (int)$_POST["idClasse"]);
    } else {
        $tabInscription = $db->lectureSansId();
    }

    $output = "";

    if ($tabInscription != "") {
        if (count($tabInscription) > 0) {
            foreach ($tabInscription as $elmInscription) {
                $idEtudiant = $elmInscription->id;
                $niveau = $elmInscription->niveau;
                $classe = $elmInscription->classe;

                $tabMatieres = $db->getMatiere($niveau);
                $output .= "
                <div class='contEtudiant'>
                    <h4 class='text-center infoEtudiant'>$elmInscription->prenom $elmInscription->nom (N° : $elmInscription->numero)</h4>
                    <div class='contNotes'>
                    <table border='1'>
                        <tr>
                            <td></td>
                            <th colspan='2'>Premier semestre</th>
                            <th colspan='2'>Deuxième semestre</th>
                            <th colspan='2'>Troisième semestre</th>
                        </tr>
                        <tr>
                            <th>Matières</th>
                            <th>1er Bulletin</th>
                            <th>2è Bulletin</th>
                            <th>1er Bulletin</th>
                            <th>2è Bulletin</th>
                            <th>1er Bulletin</th>
                            <th>2è Bulletin</th>
                        </tr>";
                for ($iMat = 0; $iMat < count($tabMatieres); $iMat++) {
                    $idMatiere = $tabMatieres[$iMat]["id"];
                    $tabNotes = $db->getNotes($idEtudiant, $idMatiere, $niveau, $classe, $annee);

                    if (count($tabNotes) > 0) {
                        $output .= "<tr>
                            <th>{$tabMatieres[$iMat]["matieres"]}</th>";
                        if ($tabNotes[0]['conf_interro_1'] == 1) {
                            $output .= "<th><button class='btn btn-primary btn-sm me-3 btnNote' data-idetudiant='{$idEtudiant}' data-idmatiere='{$tabMatieres[$iMat]["id"]}' data-type='interro_1' data-niveau='{$niveau}' data-classe='{$classe}' data-annee='{$annee}' data-bs-toggle='modal' data-bs-target='#createModal'>{$tabNotes[0]['interro_1']} </button></th>";
                        } else {
                            $output .= "<th><button class='btn btn-primary btn-sm me-3 btnNote' data-idetudiant='{$idEtudiant}' data-idmatiere='{$tabMatieres[$iMat]["id"]}' data-type='interro_1' data-niveau='{$niveau}' data-classe='{$classe}' data-annee='{$annee}' data-bs-toggle='modal' data-bs-target='#createModal'><i class='fas fa-folder-plus'></i> </button></th>";
                        }

                        if ($tabNotes[0]['conf_exam_1'] == 1) {
                            $output .= "<th><button class='btn btn-primary btn-sm me-3 btnNote' data-idetudiant='{$idEtudiant}' data-idmatiere='{$tabMatieres[$iMat]["id"]}' data-type='exam_1' data-niveau='{$niveau}' data-classe='{$classe}' data-annee='{$annee}' data-bs-toggle='modal' data-bs-target='#createModal'>{$tabNotes[0]['exam_1']} </button></th>";
                        } else {
                            $output .= "<th><button class='btn btn-primary btn-sm me-3 btnNote' data-idetudiant='{$idEtudiant}' data-idmatiere='{$tabMatieres[$iMat]["id"]}' data-type='exam_1' data-niveau='{$niveau}' data-classe='{$classe}' data-annee='{$annee}' data-bs-toggle='modal' data-bs-target='#createModal'><i class='fas fa-folder-plus'></i> </button></th>";
                        }

                        if ($tabNotes[0]['conf_interro_2'] == 1) {
                            $output .= "<th><button class='btn btn-primary btn-sm me-3 btnNote' data-idetudiant='{$idEtudiant}' data-idmatiere='{$tabMatieres[$iMat]["id"]}' data-type='interro_2' data-niveau='{$niveau}' data-classe='{$classe}' data-annee='{$annee}' data-bs-toggle='modal' data-bs-target='#createModal'>{$tabNotes[0]['interro_2']} </button></th>";
                        } else {
                            $output .= "<th><button class='btn btn-primary btn-sm me-3 btnNote' data-idetudiant='{$idEtudiant}' data-idmatiere='{$tabMatieres[$iMat]["id"]}' data-type='interro_2' data-niveau='{$niveau}' data-classe='{$classe}' data-annee='{$annee}' data-bs-toggle='modal' data-bs-target='#createModal'><i class='fas fa-folder-plus'></i> </button></th>";
                        }

                        if ($tabNotes[0]['conf_exam_2'] == 1) {
                            $output .= "<th><button class='btn btn-primary btn-sm me-3 btnNote' data-idetudiant='{$idEtudiant}' data-idmatiere='{$tabMatieres[$iMat]["id"]}' data-type='exam_2' data-niveau='{$niveau}' data-classe='{$classe}' data-annee='{$annee}' data-bs-toggle='modal' data-bs-target='#createModal'>{$tabNotes[0]['exam_2']} </button></th>";
                        } else {
                            $output .= "<th><button class='btn btn-primary btn-sm me-3 btnNote' data-idetudiant='{$idEtudiant}' data-idmatiere='{$tabMatieres[$iMat]["id"]}' data-type='exam_2' data-niveau='{$niveau}' data-classe='{$classe}' data-annee='{$annee}' data-bs-toggle='modal' data-bs-target='#createModal'><i class='fas fa-folder-plus'></i> </button></th>";
                        }

                        if ($tabNotes[0]['conf_interro_3'] == 1) {
                            $output .= "<th><button class='btn btn-primary btn-sm me-3 btnNote' data-idetudiant='{$idEtudiant}' data-idmatiere='{$tabMatieres[$iMat]["id"]}' data-type='interro_3' data-niveau='{$niveau}' data-classe='{$classe}' data-annee='{$annee}' data-bs-toggle='modal' data-bs-target='#createModal'>{$tabNotes[0]['interro_3']} </button></th>";
                        } else {
                            $output .= "<th><button class='btn btn-primary btn-sm me-3 btnNote' data-idetudiant='{$idEtudiant}' data-idmatiere='{$tabMatieres[$iMat]["id"]}' data-type='interro_3' data-niveau='{$niveau}' data-classe='{$classe}' data-annee='{$annee}' data-bs-toggle='modal' data-bs-target='#createModal'><i class='fas fa-folder-plus'></i> </button></th>";
                        }

                        if ($tabNotes[0]['conf_exam_3'] == 1) {
                            $output .= "<th><button class='btn btn-primary btn-sm me-3 btnNote' data-idetudiant='{$idEtudiant}' data-idmatiere='{$tabMatieres[$iMat]["id"]}' data-type='exam_3' data-niveau='{$niveau}' data-classe='{$classe}' data-annee='{$annee}' data-bs-toggle='modal' data-bs-target='#createModal'>{$tabNotes[0]['exam_3']} </button></th>";
                        } else {
                            $output .= "<th><button class='btn btn-primary btn-sm me-3 btnNote' data-idetudiant='{$idEtudiant}' data-idmatiere='{$tabMatieres[$iMat]["id"]}' data-type='exam_3' data-niveau='{$niveau}' data-classe='{$classe}' data-annee='{$annee}' data-bs-toggle='modal' data-bs-target='#createModal'><i class='fas fa-folder-plus'></i> </button></th>";
                        }
                        $output .= "</tr>";
                    } else {
                        $output .= "<tr>
                            <th>{$tabMatieres[$iMat]["matieres"]}</th>
                            <th><button class='btn btn-primary btn-sm me-3 btnNote' data-idetudiant='{$idEtudiant}' data-idmatiere='{$tabMatieres[$iMat]["id"]}' data-type='interro_1' data-niveau='{$niveau}' data-classe='{$classe}' data-annee='{$annee}' data-bs-toggle='modal' data-bs-target='#createModal'><i class='fas fa-folder-plus'></i> </button></th>
                            <th><button class='btn btn-primary btn-sm me-3 btnNote' data-idetudiant='{$idEtudiant}' data-idmatiere='{$tabMatieres[$iMat]["id"]}' data-type='interro_2' data-niveau='{$niveau}' data-classe='{$classe}' data-annee='{$annee}' data-bs-toggle='modal' data-bs-target='#createModal'><i class='fas fa-folder-plus'></i> </button></th>
                            <th><button class='btn btn-primary btn-sm me-3 btnNote' data-idetudiant='{$idEtudiant}' data-idmatiere='{$tabMatieres[$iMat]["id"]}' data-type='interro_2' data-niveau='{$niveau}' data-classe='{$classe}' data-annee='{$annee}' data-bs-toggle='modal' data-bs-target='#createModal'><i class='fas fa-folder-plus'></i> </button></th>
                            <th><button class='btn btn-primary btn-sm me-3 btnNote' data-idetudiant='{$idEtudiant}' data-idmatiere='{$tabMatieres[$iMat]["id"]}' data-type='exam_2' data-niveau='{$niveau}' data-classe='{$classe}' data-annee='{$annee}' data-bs-toggle='modal' data-bs-target='#createModal'><i class='fas fa-folder-plus'></i> </button></th>
                            <th><button class='btn btn-primary btn-sm me-3 btnNote' data-idetudiant='{$idEtudiant}' data-idmatiere='{$tabMatieres[$iMat]["id"]}' data-type='interro_3' data-niveau='{$niveau}' data-classe='{$classe}' data-annee='{$annee}' data-bs-toggle='modal' data-bs-target='#createModal'><i class='fas fa-folder-plus'></i> </button></th>
                            <th><button class='btn btn-primary btn-sm me-3 btnNote' data-idetudiant='{$idEtudiant}' data-idmatiere='{$tabMatieres[$iMat]["id"]}' data-type='exam_3' data-niveau='{$niveau}' data-classe='{$classe}' data-annee='{$annee}' data-bs-toggle='modal' data-bs-target='#createModal'><i class='fas fa-folder-plus'></i> </button></th>
                        </tr>";
                    }
                }
                $output .= "</table>
                    ";

                $output .= "</div>
                </div>
            ";
            }
        } else {
            $output .= "<h3 class='mt-2 text-center'>Aucun étudiant enregistré</h3>";
        }
    } else {
        $output .= "<h3 class='mt-2 text-center'>Aucun étudiant enregistré</h3>";
    }

    echo $output;
}

if (isset($_POST["slctIdClasseAvecNiveau"])) {
    if (isset($_POST["idNiveau"])) {
        $tabClasse = $db->slctClasse($_POST["idNiveau"]);
        if (count($tabClasse) > 0) {
            $idClasse = $tabClasse[0]["id"];
            $tabInscription = $db->lectureAvecId((int)$_POST["idNiveau"], (int)$idClasse);
        } else {
            $tabInscription = [];
        }
    } else {
        $tabInscription = $db->lectureSansId();
    }

    $output = "";
    if (count($tabInscription) > 0) {

        foreach ($tabInscription as $elmInscription) {
            $idEtudiant = $elmInscription->id;
            $niveau = $elmInscription->niveau;
            $classe = $elmInscription->classe;

            $tabMatieres = $db->getMatiere($niveau);
            $output .= "
                <div class='contEtudiant'>
                    <h4 class='text-center infoEtudiant'>$elmInscription->prenom $elmInscription->nom (N° : $elmInscription->numero)</h4>
                    <div class='contNotes'>
                    <table border='1'>
                        <tr>
                            <td></td>
                            <th colspan='2'>Premier semestre</th>
                            <th colspan='2'>Deuxième semestre</th>
                            <th colspan='2'>Troisième semestre</th>
                        </tr>
                        <tr>
                            <th>Matières</th>
                            <th>1er Bulletin</th>
                            <th>2è Bulletin</th>
                            <th>1er Bulletin</th>
                            <th>2è Bulletin</th>
                            <th>1er Bulletin</th>
                            <th>2è Bulletin</th>
                        </tr>";
            for ($iMat = 0; $iMat < count($tabMatieres); $iMat++) {
                $idMatiere = $tabMatieres[$iMat]["id"];
                $tabNotes = $db->getNotes($idEtudiant, $idMatiere, $niveau, $classe, $annee);

                if (count($tabNotes) > 0) {
                    $output .= "<tr>
                            <th>{$tabMatieres[$iMat]["matieres"]}</th>";
                    if ($tabNotes[0]['conf_interro_1'] == 1) {
                        $output .= "<th><button class='btn btn-primary btn-sm me-3 btnNote' data-idetudiant='{$idEtudiant}' data-idmatiere='{$tabMatieres[$iMat]["id"]}' data-type='interro_1' data-niveau='{$niveau}' data-classe='{$classe}' data-annee='{$annee}' data-bs-toggle='modal' data-bs-target='#createModal'>{$tabNotes[0]['interro_1']} </button></th>";
                    } else {
                        $output .= "<th><button class='btn btn-primary btn-sm me-3 btnNote' data-idetudiant='{$idEtudiant}' data-idmatiere='{$tabMatieres[$iMat]["id"]}' data-type='interro_1' data-niveau='{$niveau}' data-classe='{$classe}' data-annee='{$annee}' data-bs-toggle='modal' data-bs-target='#createModal'><i class='fas fa-folder-plus'></i> </button></th>";
                    }

                    if ($tabNotes[0]['conf_exam_1'] == 1) {
                        $output .= "<th><button class='btn btn-primary btn-sm me-3 btnNote' data-idetudiant='{$idEtudiant}' data-idmatiere='{$tabMatieres[$iMat]["id"]}' data-type='exam_1' data-niveau='{$niveau}' data-classe='{$classe}' data-annee='{$annee}' data-bs-toggle='modal' data-bs-target='#createModal'>{$tabNotes[0]['exam_1']} </button></th>";
                    } else {
                        $output .= "<th><button class='btn btn-primary btn-sm me-3 btnNote' data-idetudiant='{$idEtudiant}' data-idmatiere='{$tabMatieres[$iMat]["id"]}' data-type='exam_1' data-niveau='{$niveau}' data-classe='{$classe}' data-annee='{$annee}' data-bs-toggle='modal' data-bs-target='#createModal'><i class='fas fa-folder-plus'></i> </button></th>";
                    }

                    if ($tabNotes[0]['conf_interro_2'] == 1) {
                        $output .= "<th><button class='btn btn-primary btn-sm me-3 btnNote' data-idetudiant='{$idEtudiant}' data-idmatiere='{$tabMatieres[$iMat]["id"]}' data-type='interro_2' data-niveau='{$niveau}' data-classe='{$classe}' data-annee='{$annee}' data-bs-toggle='modal' data-bs-target='#createModal'>{$tabNotes[0]['interro_2']} </button></th>";
                    } else {
                        $output .= "<th><button class='btn btn-primary btn-sm me-3 btnNote' data-idetudiant='{$idEtudiant}' data-idmatiere='{$tabMatieres[$iMat]["id"]}' data-type='interro_2' data-niveau='{$niveau}' data-classe='{$classe}' data-annee='{$annee}' data-bs-toggle='modal' data-bs-target='#createModal'><i class='fas fa-folder-plus'></i> </button></th>";
                    }

                    if ($tabNotes[0]['conf_exam_2'] == 1) {
                        $output .= "<th><button class='btn btn-primary btn-sm me-3 btnNote' data-idetudiant='{$idEtudiant}' data-idmatiere='{$tabMatieres[$iMat]["id"]}' data-type='exam_2' data-niveau='{$niveau}' data-classe='{$classe}' data-annee='{$annee}' data-bs-toggle='modal' data-bs-target='#createModal'>{$tabNotes[0]['exam_2']} </button></th>";
                    } else {
                        $output .= "<th><button class='btn btn-primary btn-sm me-3 btnNote' data-idetudiant='{$idEtudiant}' data-idmatiere='{$tabMatieres[$iMat]["id"]}' data-type='exam_2' data-niveau='{$niveau}' data-classe='{$classe}' data-annee='{$annee}' data-bs-toggle='modal' data-bs-target='#createModal'><i class='fas fa-folder-plus'></i> </button></th>";
                    }

                    if ($tabNotes[0]['conf_interro_3'] == 1) {
                        $output .= "<th><button class='btn btn-primary btn-sm me-3 btnNote' data-idetudiant='{$idEtudiant}' data-idmatiere='{$tabMatieres[$iMat]["id"]}' data-type='interro_3' data-niveau='{$niveau}' data-classe='{$classe}' data-annee='{$annee}' data-bs-toggle='modal' data-bs-target='#createModal'>{$tabNotes[0]['interro_3']} </button></th>";
                    } else {
                        $output .= "<th><button class='btn btn-primary btn-sm me-3 btnNote' data-idetudiant='{$idEtudiant}' data-idmatiere='{$tabMatieres[$iMat]["id"]}' data-type='interro_3' data-niveau='{$niveau}' data-classe='{$classe}' data-annee='{$annee}' data-bs-toggle='modal' data-bs-target='#createModal'><i class='fas fa-folder-plus'></i> </button></th>";
                    }

                    if ($tabNotes[0]['conf_exam_3'] == 1) {
                        $output .= "<th><button class='btn btn-primary btn-sm me-3 btnNote' data-idetudiant='{$idEtudiant}' data-idmatiere='{$tabMatieres[$iMat]["id"]}' data-type='exam_3' data-niveau='{$niveau}' data-classe='{$classe}' data-annee='{$annee}' data-bs-toggle='modal' data-bs-target='#createModal'>{$tabNotes[0]['exam_3']} </button></th>";
                    } else {
                        $output .= "<th><button class='btn btn-primary btn-sm me-3 btnNote' data-idetudiant='{$idEtudiant}' data-idmatiere='{$tabMatieres[$iMat]["id"]}' data-type='exam_3' data-niveau='{$niveau}' data-classe='{$classe}' data-annee='{$annee}' data-bs-toggle='modal' data-bs-target='#createModal'><i class='fas fa-folder-plus'></i> </button></th>";
                    }
                    $output .= "</tr>";
                } else {
                    $output .= "<tr>
                            <th>{$tabMatieres[$iMat]["matieres"]}</th>
                            <th><button class='btn btn-primary btn-sm me-3 btnNote' data-idetudiant='{$idEtudiant}' data-idmatiere='{$tabMatieres[$iMat]["id"]}' data-type='interro_1' data-niveau='{$niveau}' data-classe='{$classe}' data-annee='{$annee}' data-bs-toggle='modal' data-bs-target='#createModal'><i class='fas fa-folder-plus'></i> </button></th>
                            <th><button class='btn btn-primary btn-sm me-3 btnNote' data-idetudiant='{$idEtudiant}' data-idmatiere='{$tabMatieres[$iMat]["id"]}' data-type='interro_2' data-niveau='{$niveau}' data-classe='{$classe}' data-annee='{$annee}' data-bs-toggle='modal' data-bs-target='#createModal'><i class='fas fa-folder-plus'></i> </button></th>
                            <th><button class='btn btn-primary btn-sm me-3 btnNote' data-idetudiant='{$idEtudiant}' data-idmatiere='{$tabMatieres[$iMat]["id"]}' data-type='interro_2' data-niveau='{$niveau}' data-classe='{$classe}' data-annee='{$annee}' data-bs-toggle='modal' data-bs-target='#createModal'><i class='fas fa-folder-plus'></i> </button></th>
                            <th><button class='btn btn-primary btn-sm me-3 btnNote' data-idetudiant='{$idEtudiant}' data-idmatiere='{$tabMatieres[$iMat]["id"]}' data-type='exam_2' data-niveau='{$niveau}' data-classe='{$classe}' data-annee='{$annee}' data-bs-toggle='modal' data-bs-target='#createModal'><i class='fas fa-folder-plus'></i> </button></th>
                            <th><button class='btn btn-primary btn-sm me-3 btnNote' data-idetudiant='{$idEtudiant}' data-idmatiere='{$tabMatieres[$iMat]["id"]}' data-type='interro_3' data-niveau='{$niveau}' data-classe='{$classe}' data-annee='{$annee}' data-bs-toggle='modal' data-bs-target='#createModal'><i class='fas fa-folder-plus'></i> </button></th>
                            <th><button class='btn btn-primary btn-sm me-3 btnNote' data-idetudiant='{$idEtudiant}' data-idmatiere='{$tabMatieres[$iMat]["id"]}' data-type='exam_3' data-niveau='{$niveau}' data-classe='{$classe}' data-annee='{$annee}' data-bs-toggle='modal' data-bs-target='#createModal'><i class='fas fa-folder-plus'></i> </button></th>
                        </tr>";
                }
            }
            $output .= "</table>
                    ";

            $output .= "</div>
                </div>
            ";
        }
    } else {
        $output .= "<h3 class='mt-2 text-center'>Aucun étudiant enregistré</h3>";
    }
    echo $output;
}

// Info pour detail de facture
if (isset($_POST['workingId'])) {
    $workingId = $_POST['workingId'];
    echo json_encode($db->getSingleClasse($workingId));
}

if (isset($_POST["idEtudiant"]) && isset($_POST["mois"])) {
    echo $db->confirmEcolage($_POST["idEtudiant"], $_POST["mois"]);
}

if (isset($_POST["idetudiant"]) && isset($_POST["idmatiere"]) && isset($_POST["type"]) && isset($_POST["niveau"]) && isset($_POST["classe"]) && isset($_POST["annee"])) {
    echo $db->getNotesPrecise((int)$_POST["idetudiant"], (int)$_POST["idmatiere"], (string)$_POST["type"], (int)$_POST["niveau"], (int)$_POST["classe"], (int)$_POST["annee"]);
}

if (isset($_POST["idetudiant"]) && isset($_POST["idmatiere"]) && isset($_POST["type"]) && isset($_POST["niveau"]) && isset($_POST["classe"]) && isset($_POST["annee"]) && isset($_POST["note"])) {
    $db->insertNote((int)$_POST["idetudiant"], (int)$_POST["idmatiere"], (string)$_POST["type"], (int)$_POST["niveau"], (int)$_POST["classe"], (int)$_POST["annee"], (int)$_POST["note"]);
    echo "perfect";
}
