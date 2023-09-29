<?php
require_once "bulletin_model.php";
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
            $liste .= "<div class='contClasse text-center'>";

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
            $liste .= "<div class='text-center contClasse '  aria-labelledby='dropdown04'>";

            for ($i = 0; $i < count($tabClasse); $i++) {
                $liste .= "<a href='#' class='lienClasse changement' data-id='{$tabClasse[$i]['id']}'>{$tabClasse[$i]['classe']}</a>";
            }
            $liste .= "</div>";
        }
    }

    echo $liste;
}

$tabMoiSlct = $db->slctAnnee();
if (count($tabMoiSlct) > 0) {
    $tabMoiSlct = $db->slctAnnee();
    $annee = $tabMoiSlct[0]["id"];
    $anneeComplete = $tabMoiSlct[0]["debut_annee"] . " - " . $tabMoiSlct[0]["fin_annee"];
} else {
    $annee = "";
    $anneeComplete = "";
}

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
                $tabNomClasse = $db->slctNomClasse($classe);
                $nomClasse = $tabNomClasse[0]["classe"];

                $tabMatieres = $db->getMatiere($niveau);
                $output .= "
                <div class='contEtudiant'>
                    <div class='teteBull'>
                        <p><b>ANNEE </b>: <u>$anneeComplete</u></p>
                        <p><b>Nom et Prénom</b> : <u>$elmInscription->prenom $elmInscription->nom</u></p>
                        <p><b>N° </b>: <u>$elmInscription->numero</u></p>
                        <p><b>Classe </b>: <u>$nomClasse</u></p>
                    </div>
                    <div class='contNotes'>
                    <table border='1'>
                        <tr>
                            <th rowspan='2'>MATIERES</th>
                            <th rowspan='2'>Coef</th>
                            <th colspan='3'>1er semestre</th>
                            <th rowspan='2'>Observations</th>
                            <th colspan='3'>2ème semestre</th>
                            <th rowspan='2'>Observations</th>
                            <th colspan='3'>3ème semestre</th>
                            <th rowspan='2'>Observations</th>
                        </tr>
                        <tr>
                            <th>1er Bul</th>
                            <th>2è Bul</th>
                            <th>Moyenne</th>
                            <th>1er Bul</th>
                            <th>2è Bul</th>
                            <th>Moyenne</th>
                            <th>1er Bul</th>
                            <th>2è Bul</th>
                            <th>Moyenne</th>
                        </tr>";
                $totalCoeff = 0;
                $sommeCoeff = 0;

                $total_interro_1 = 0;
                $total_exam_1 = 0;
                $total_interro_2 = 0;
                $total_exam_2 = 0;
                $total_interro_3 = 0;
                $total_exam_3 = 0;

                for ($iMat = 0; $iMat < count($tabMatieres); $iMat++) {
                    $idMatiere = $tabMatieres[$iMat]["id"];
                    $tabNotes = $db->getNotes($idEtudiant, $idMatiere, $niveau, $classe, $annee);
                    $coeff = $tabMatieres[$iMat]["coeff"] * 20;


                    $totalCoeff += $coeff;
                    $sommeCoeff += $tabMatieres[$iMat]["coeff"];

                    if (count($tabNotes) > 0) {
                        $total_interro_1 += $tabNotes[0]['interro_1'];
                        $total_exam_1 += $tabNotes[0]['exam_1'];
                        $total_interro_2 += $tabNotes[0]['interro_2'];
                        $total_exam_2 += $tabNotes[0]['exam_2'];
                        $total_interro_3 += $tabNotes[0]['interro_3'];
                        $total_exam_3 += $tabNotes[0]['exam_3'];

                        $output .= "<tr>
                            <th>{$tabMatieres[$iMat]["matieres"]}</th>
                            <th>{$coeff}</th>";
                        if ($tabNotes[0]['conf_interro_1'] == 1) {
                            $output .= "<td>{$tabNotes[0]['interro_1']}</td>";
                        } else {
                            $output .= "<td></td>";
                        }

                        if ($tabNotes[0]['conf_exam_1'] == 1) {
                            $output .= "<td>{$tabNotes[0]['exam_1']}</td>";
                        } else {
                            $output .= "<td></td>";
                        }

                        $output .= "<td></td>";
                        $output .= "<td></td>";

                        if ($tabNotes[0]['conf_interro_2'] == 1) {
                            $output .= "<td>{$tabNotes[0]['interro_2']}</td>";
                        } else {
                            $output .= "<td></td>";
                        }

                        if ($tabNotes[0]['conf_exam_2'] == 1) {
                            $output .= "<td>{$tabNotes[0]['exam_2']}</td>";
                        } else {
                            $output .= "<td></td>";
                        }

                        $output .= "<td></td>";
                        $output .= "<td></td>";

                        if ($tabNotes[0]['conf_interro_3'] == 1) {
                            $output .= "<td>{$tabNotes[0]['interro_3']}</td>";
                        } else {
                            $output .= "<td></td>";
                        }

                        if ($tabNotes[0]['conf_exam_3'] == 1) {
                            $output .= "<td>{$tabNotes[0]['exam_3']}</td>";
                        } else {
                            $output .= "<td></td>";
                        }

                        $output .= "<td></td>";
                        $output .= "<td></td>";
                        $output .= "</tr>";
                    } else {
                        $output .= "<tr>
                                    <th>{$tabMatieres[$iMat]["matieres"]}</th>
                                    <th>{$coeff}</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>";
                    }
                }
                $output .= "<tr>
                            <th>TOTAL</th>
                            <th>{$totalCoeff}</th>";

                ($total_interro_1 != 0) ? $output .= "<th>{$total_interro_1}</th>" : $output .= "<th></th>";
                ($total_exam_1 != 0) ? $output .= "<th>{$total_exam_1}</th>" : $output .= "<th></th>";
                $output .= "<th></th>
                        <th></th>";

                ($total_interro_2 != 0) ? $output .= "<th>{$total_interro_2}</th>" : $output .= "<th></th>";
                ($total_exam_2 != 0) ? $output .= "<th>{$total_exam_2}</th>" : $output .= "<th></th>";
                $output .= "<th></th>
                        <th></th>";

                ($total_interro_3 != 0) ? $output .= "<th>{$total_interro_3}</th>" : $output .= "<th></th>";
                ($total_exam_3 != 0) ? $output .= "<th>{$total_exam_3}</th>" : $output .= "<th></th>";
                $output .= "<th></th>
                        <th></th>
                    </tr>";

                // MOYENNE
                if ($sommeCoeff != 0) {
                    $moyenne = $totalCoeff / $sommeCoeff;

                    $moyenne_interro_1 = round($total_interro_1 / $sommeCoeff, 2);
                    $moyenne_exam_1 = round($total_exam_1 / $sommeCoeff, 2);

                    $moyenne_interro_2 = round($total_interro_2 / $sommeCoeff, 2);
                    $moyenne_exam_2 = round($total_exam_2 / $sommeCoeff, 2);

                    $moyenne_interro_3 = round($total_interro_3 / $sommeCoeff, 2);
                    $moyenne_exam_3 = round($total_exam_3 / $sommeCoeff, 2);
                } else {
                    $moyenne = 0;

                    $moyenne_interro_1 = 0;
                    $moyenne_exam_1 = 0;

                    $moyenne_interro_2 = 0;
                    $moyenne_exam_2 = 0;

                    $moyenne_interro_3 = 0;
                    $moyenne_exam_3 = 0;
                }

                $output .= "<tr>
                            <th>Moyenne</th>
                            <th>{$moyenne}</th>";

                ($total_interro_1 != 0) ? $output .= "<th>{$moyenne_interro_1}</th>" : $output .= "<th></th>";
                ($total_exam_1 != 0) ? $output .= "<th>{$moyenne_exam_1}</th>" : $output .= "<th></th>";
                $output .= "<th></th>
                        <th></th>";

                ($total_interro_2 != 0) ? $output .= "<th>{$moyenne_interro_2}</th>" : $output .= "<th></th>";
                ($total_exam_2 != 0) ? $output .= "<th>{$moyenne_exam_2}</th>" : $output .= "<th></th>";
                $output .= "<th></th>
                        <th></th>";

                ($total_interro_3 != 0) ? $output .= "<th>{$moyenne_interro_3}</th>" : $output .= "<th></th>";
                ($total_exam_3 != 0) ? $output .= "<th>{$moyenne_exam_3}</th>" : $output .= "<th></th>";
                $output .= "<th></th>
                        <th></th>
                    </tr>";
                $output .= "<tr>
                            <th>Rang</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>";
                $output .= "<tr>
                            <td></td>
                            <td colspan='5' class='nbRetard'>Nb de retard : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nb d'absence :</td>
                            <td colspan='4' class='nbRetard'>Nb de retard : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nb d'absence :</td>
                            <td colspan='4' class='nbRetard'>Nb de retard : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nb d'absence :</td>
                        </tr>";
                $output .= "<tr class='petitTexte'>
                            <td>Responsable</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>";
                $output .= "<tr class='petitTexte'>
                            <td>Signature des parents</td>
                            <td colspan='4'></td>
                            <td></td>
                            <td colspan='3'></td>
                            <td></td>
                            <td colspan='3'></td>
                            <td></td>
                        </tr>";
                $output .= "<tr>
                            <th colspan='6' class='gauche'>Moyenne Générale : </th>
                            <th colspan='8' class='gauche'>Décision finale : </th>
                        </tr>";
                $output .= "</table>";
                $output .= "</div>
                </div>
                <div class='html2pdf__page-break'></div>
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
            $tabNomClasse = $db->slctNomClasse($classe);
            $nomClasse = $tabNomClasse[0]["classe"];

            $tabMatieres = $db->getMatiere($niveau);
            $output .= "
                <div class='contEtudiant'>
                    <h4 class='text-center infoEtudiant'>$elmInscription->prenom $elmInscription->nom (N° : $elmInscription->numero)</h4>
                    <div class='teteBull'>
                        <p><b>ANNEE </b>: <u>$anneeComplete</u></p>
                        <p><b>Nom et Prénom</b> : <u>$elmInscription->prenom $elmInscription->nom</u></p>
                        <p><b>N° </b>: <u>$elmInscription->numero</u></p>
                        <p><b>Classe </b>: <u>$nomClasse</u></p>
                    </div>
                    <div class='contNotes'>
                    <table border='1'>
                        <tr>
                            <th rowspan='2'>MATIERES</th>
                            <th rowspan='2'>Coef</th>
                            <th colspan='3'>1er semestre</th>
                            <th rowspan='2'>Observations</th>
                            <th colspan='3'>2ème semestre</th>
                            <th rowspan='2'>Observations</th>
                            <th colspan='3'>3ème semestre</th>
                            <th rowspan='2'>Observations</th>
                        </tr>
                        <tr>
                            <th>1er Bul</th>
                            <th>2è Bul</th>
                            <th>Moyenne</th>
                            <th>1er Bul</th>
                            <th>2è Bul</th>
                            <th>Moyenne</th>
                            <th>1er Bul</th>
                            <th>2è Bul</th>
                            <th>Moyenne</th>
                        </tr>";
            $totalCoeff = 0;
            $sommeCoeff = 0;

            $total_interro_1 = 0;
            $total_exam_1 = 0;
            $total_interro_2 = 0;
            $total_exam_2 = 0;
            $total_interro_3 = 0;
            $total_exam_3 = 0;

            for ($iMat = 0; $iMat < count($tabMatieres); $iMat++) {
                $idMatiere = $tabMatieres[$iMat]["id"];
                $tabNotes = $db->getNotes($idEtudiant, $idMatiere, $niveau, $classe, $annee);
                $coeff = $tabMatieres[$iMat]["coeff"] * 20;


                $totalCoeff += $coeff;
                $sommeCoeff += $tabMatieres[$iMat]["coeff"];

                if (count($tabNotes) > 0) {
                    $total_interro_1 += $tabNotes[0]['interro_1'];
                    $total_exam_1 += $tabNotes[0]['exam_1'];
                    $total_interro_2 += $tabNotes[0]['interro_2'];
                    $total_exam_2 += $tabNotes[0]['exam_2'];
                    $total_interro_3 += $tabNotes[0]['interro_3'];
                    $total_exam_3 += $tabNotes[0]['exam_3'];

                    $output .= "<tr>
                            <th>{$tabMatieres[$iMat]["matieres"]}</th>
                            <th>{$coeff}</th>";
                    if ($tabNotes[0]['conf_interro_1'] == 1) {
                        $output .= "<td>{$tabNotes[0]['interro_1']}</td>";
                    } else {
                        $output .= "<td></td>";
                    }

                    if ($tabNotes[0]['conf_exam_1'] == 1) {
                        $output .= "<td>{$tabNotes[0]['exam_1']}</td>";
                    } else {
                        $output .= "<td></td>";
                    }

                    $output .= "<td></td>";
                    $output .= "<td></td>";

                    if ($tabNotes[0]['conf_interro_2'] == 1) {
                        $output .= "<td>{$tabNotes[0]['interro_2']}</td>";
                    } else {
                        $output .= "<td></td>";
                    }

                    if ($tabNotes[0]['conf_exam_2'] == 1) {
                        $output .= "<td>{$tabNotes[0]['exam_2']}</td>";
                    } else {
                        $output .= "<td></td>";
                    }

                    $output .= "<td></td>";
                    $output .= "<td></td>";

                    if ($tabNotes[0]['conf_interro_3'] == 1) {
                        $output .= "<td>{$tabNotes[0]['interro_3']}</td>";
                    } else {
                        $output .= "<td></td>";
                    }

                    if ($tabNotes[0]['conf_exam_3'] == 1) {
                        $output .= "<td>{$tabNotes[0]['exam_3']}</td>";
                    } else {
                        $output .= "<td></td>";
                    }

                    $output .= "<td></td>";
                    $output .= "<td></td>";
                    $output .= "</tr>";
                } else {
                    $output .= "<tr>
                                    <th>{$tabMatieres[$iMat]["matieres"]}</th>
                                    <th>{$coeff}</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>";
                }
            }
            $output .= "<tr>
                            <th>TOTAL</th>
                            <th>{$totalCoeff}</th>";

            ($total_interro_1 != 0) ? $output .= "<th>{$total_interro_1}</th>" : $output .= "<th></th>";
            ($total_exam_1 != 0) ? $output .= "<th>{$total_exam_1}</th>" : $output .= "<th></th>";
            $output .= "<th></th>
                        <th></th>";

            ($total_interro_2 != 0) ? $output .= "<th>{$total_interro_2}</th>" : $output .= "<th></th>";
            ($total_exam_2 != 0) ? $output .= "<th>{$total_exam_2}</th>" : $output .= "<th></th>";
            $output .= "<th></th>
                        <th></th>";

            ($total_interro_3 != 0) ? $output .= "<th>{$total_interro_3}</th>" : $output .= "<th></th>";
            ($total_exam_3 != 0) ? $output .= "<th>{$total_exam_3}</th>" : $output .= "<th></th>";
            $output .= "<th></th>
                        <th></th>
                    </tr>";

            // MOYENNE
            if ($sommeCoeff != 0) {
                $moyenne = $totalCoeff / $sommeCoeff;

                $moyenne_interro_1 = round($total_interro_1 / $sommeCoeff, 2);
                $moyenne_exam_1 = round($total_exam_1 / $sommeCoeff, 2);

                $moyenne_interro_2 = round($total_interro_2 / $sommeCoeff, 2);
                $moyenne_exam_2 = round($total_exam_2 / $sommeCoeff, 2);

                $moyenne_interro_3 = round($total_interro_3 / $sommeCoeff, 2);
                $moyenne_exam_3 = round($total_exam_3 / $sommeCoeff, 2);
            } else {
                $moyenne = 0;

                $moyenne_interro_1 = 0;
                $moyenne_exam_1 = 0;

                $moyenne_interro_2 = 0;
                $moyenne_exam_2 = 0;

                $moyenne_interro_3 = 0;
                $moyenne_exam_3 = 0;
            }

            $output .= "<tr>
                            <th>Moyenne</th>
                            <th>{$moyenne}</th>";

            ($total_interro_1 != 0) ? $output .= "<th>{$moyenne_interro_1}</th>" : $output .= "<th></th>";
            ($total_exam_1 != 0) ? $output .= "<th>{$moyenne_exam_1}</th>" : $output .= "<th></th>";
            $output .= "<th></th>
                        <th></th>";

            ($total_interro_2 != 0) ? $output .= "<th>{$moyenne_interro_2}</th>" : $output .= "<th></th>";
            ($total_exam_2 != 0) ? $output .= "<th>{$moyenne_exam_2}</th>" : $output .= "<th></th>";
            $output .= "<th></th>
                        <th></th>";

            ($total_interro_3 != 0) ? $output .= "<th>{$moyenne_interro_3}</th>" : $output .= "<th></th>";
            ($total_exam_3 != 0) ? $output .= "<th>{$moyenne_exam_3}</th>" : $output .= "<th></th>";
            $output .= "<th></th>
                        <th></th>
                    </tr>";
            $output .= "<tr>
                            <th>Rang</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>";
            $output .= "<tr>
                            <td></td>
                            <td colspan='5' class='nbRetard'>Nb de retard : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nb d'absence :</td>
                            <td colspan='4' class='nbRetard'>Nb de retard : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nb d'absence :</td>
                            <td colspan='4' class='nbRetard'>Nb de retard : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nb d'absence :</td>
                        </tr>";
            $output .= "<tr class='petitTexte'>
                            <td>Responsable</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>";
            $output .= "<tr class='petitTexte'>
                            <td>Signature des parents</td>
                            <td colspan='4'></td>
                            <td></td>
                            <td colspan='3'></td>
                            <td></td>
                            <td colspan='3'></td>
                            <td></td>
                        </tr>";
            $output .= "<tr>
                            <th colspan='6' class='gauche'>Moyenne Générale : </th>
                            <th colspan='8' class='gauche'>Décision finale : </th>
                        </tr>";
            $output .= "</table>";
            $output .= "</div>
                </div>
                <div class='html2pdf__page-break'></div>
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
