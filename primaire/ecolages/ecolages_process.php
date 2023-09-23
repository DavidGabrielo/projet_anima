<?php
require_once "ecolages_model.php";
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

$tabMois = ["janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre"];
$tabMois_index = ["janvier" => 0, "février" => 1, "mars" => 2, "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre"];
if (isset($_POST["slctId"])) {
    if (isset($_POST["idNiveau"]) && isset($_POST["idClasse"])) {
        $tabInscription = $db->lectureAvecId((int)$_POST["idNiveau"], (int)$_POST["idClasse"]);
    } else {
        $tabInscription = $db->lectureSansId();
    }

    $output = "";

    if ($tabInscription != "") {
        if (count($tabInscription) > 0) {
            $tabMoiSlct = $db->slctAnnee();
            $moisDebut = $tabMoiSlct[0]["mois_debut"];
            $anneeDebut = $tabMoiSlct[0]["debut_annee"];
            $anneeFin = $tabMoiSlct[0]["fin_annee"];
            $nbMois = $tabMoiSlct[0]["nb_mois"];

            foreach ($tabInscription as $elmInscription) {
                $idEtudiant = $elmInscription->id;
                $tabEcolage = $db->getEcolage($idEtudiant);
                $output .= "
                <div class='contEtudiant'>
                    <h4 class='text-center infoEtudiant'>$elmInscription->prenom $elmInscription->nom (N° : $elmInscription->numero)</h4>
                    <div class='contEcolage'>";
                $aff = 0;

                $rangMois = 0;
                for ($i = 0; $i < count($tabMois); $i++) {
                    // Si le mois de la BDD correspond à celui dans la variable
                    if ($tabMois[$i] == $moisDebut) {
                        $aff = 1;
                        $rangMois++;
                    }

                    if ($aff == 0) {
                    } elseif ($aff == 1) {
                        if ($rangMois <= $nbMois) {
                            $output .= "<div class='contMois'>
                                <span class='mois'>{$tabMois[$i]} {$anneeDebut}</span>";
                            if (count($tabEcolage) > 0) {
                                $moisPaye = $tabEcolage[0]["mois"];
                                $tabMoisPaye = explode(" , ", $moisPaye);
                                if (in_array($tabMois[$i], $tabMoisPaye)) {
                                    $output .= "
                                        <div class='contPayement'>
                                            <h5 class='paye'>Payé</h5>
                                        </div>";
                                } else {
                                    $output .= "
                                    <div class='contNonPaye'>
                                        <h6>non payé</h6>
                                        <button class='btn btn-success btn-sm me-3 payementBtn' data-id='{$idEtudiant}' data-mois='{$tabMois[$i]}'> Payer</button>
                                    </div>";
                                }
                            } else {
                                $output .= "
                                <div class='contNonPaye'>
                                    <h6>non payé</h6>
                                    <button class='btn btn-success btn-sm me-3 payementBtn' data-id='{$idEtudiant}' data-mois='{$tabMois[$i]}'> Payer</button>
                                </div>";
                            }
                            $output .= "</div>";
                        } else {
                        }
                    }

                    if ($aff == 1) {
                        $rangMois++;
                    }
                }
                $resteMois = $nbMois - $rangMois;
                for ($iReste = 0; $iReste <= $resteMois; $iReste++) {
                    $output .= "<div class='contMois'>
                                <span class='mois'>{$tabMois[$iReste]}  {$anneeFin}</span>";

                    if (count($tabEcolage) > 0) {
                        $moisPaye = $tabEcolage[0]["mois"];
                        $tabMoisPaye = explode(" , ", $moisPaye);
                        if (in_array($tabMois[$iReste], $tabMoisPaye)) {
                            $output .= "
                                <div class='contPayement'>
                                    <h5 class='paye'>Payé</h5>
                                </div>";
                        } else {
                            $output .= "
                                <div class='contNonPaye'>
                                    <h6>non payé</h6>
                                    <button class='btn btn-success btn-sm me-3 payementBtn' data-id='{$idEtudiant}' data-mois='{$tabMois[$iReste]}'> Payer</button>
                                </div>";
                        }
                    } else {
                        $output .= "
                                <div class='contNonPaye'>
                                    <h6>non payé</h6>
                                    <button class='btn btn-success btn-sm me-3 payementBtn' data-id='{$idEtudiant}' data-mois='{$tabMois[$iReste]}'> Payer</button>
                                </div>";
                    }
                    $output .= "</div>";
                }
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
        $tabMoiSlct = $db->slctAnnee();
        $moisDebut = $tabMoiSlct[0]["mois_debut"];
        $anneeDebut = $tabMoiSlct[0]["debut_annee"];
        $anneeFin = $tabMoiSlct[0]["fin_annee"];
        $nbMois = $tabMoiSlct[0]["nb_mois"];

        foreach ($tabInscription as $elmInscription) {
            $idEtudiant = $elmInscription->id;
            $tabEcolage = $db->getEcolage($idEtudiant);
            $output .= "
                <div class='contEtudiant'>
                    <h4 class='text-center infoEtudiant'>$elmInscription->prenom $elmInscription->nom (N° : $elmInscription->numero)</h4>
                    <div class='contEcolage'>";
            $aff = 0;

            $rangMois = 0;
            for ($i = 0; $i < count($tabMois); $i++) {
                // Si le mois de la BDD correspond à celui dans la variable
                if ($tabMois[$i] == $moisDebut) {
                    $aff = 1;
                    $rangMois++;
                }

                if ($aff == 0) {
                } elseif ($aff == 1) {
                    if ($rangMois <= $nbMois) {
                        $output .= "<div class='contMois'>
                                <span class='mois'>{$tabMois[$i]} {$anneeDebut}</span>";
                        if (count($tabEcolage) > 0) {
                            $moisPaye = $tabEcolage[0]["mois"];
                            $tabMoisPaye = explode(" , ", $moisPaye);
                            if (in_array($tabMois[$i], $tabMoisPaye)) {
                                $output .= "
                                        <div class='contPayement'>
                                            <h5 class='paye'>Payé</h5>
                                        </div>";
                            } else {
                                $output .= "
                                    <div class='contNonPaye'>
                                        <h6>non payé</h6>
                                        <button class='btn btn-success btn-sm me-3 payementBtn' data-id='{$idEtudiant}' data-mois='{$tabMois[$i]}'> Payer</button>
                                    </div>";
                            }
                        } else {
                            $output .= "
                                <div class='contNonPaye'>
                                    <h6>non payé</h6>
                                    <button class='btn btn-success btn-sm me-3 payementBtn' data-id='{$idEtudiant}' data-mois='{$tabMois[$i]}'> Payer</button>
                                </div>";
                        }
                        $output .= "</div>";
                    } else {
                    }
                }

                if ($aff == 1) {
                    $rangMois++;
                }
            }
            $resteMois = $nbMois - $rangMois;
            for ($iReste = 0; $iReste <= $resteMois; $iReste++) {
                $output .= "<div class='contMois'>
                                <span class='mois'>{$tabMois[$iReste]}  {$anneeFin}</span>";
                if (count($tabEcolage) > 0) {
                    $moisPaye = $tabEcolage[0]["mois"];
                    $tabMoisPaye = explode(" , ", $moisPaye);
                    if (in_array($tabMois[$iReste], $tabMoisPaye)) {
                        $output .= "
                                <div class='contPayement'>
                                    <h5 class='paye'>Payé</h5>
                                </div>";
                    } else {
                        $output .= "
                                <div class='contNonPaye'>
                                    <h6>non payé</h6>
                                    <button class='btn btn-success btn-sm me-3 payementBtn' data-id='{$idEtudiant}' data-mois='{$tabMois[$iReste]}'> Payer</button>
                                </div>";
                    }
                } else {
                    $output .= "
                                <div class='contNonPaye'>
                                    <h6>non payé</h6>
                                    <button class='btn btn-success btn-sm me-3 payementBtn' data-id='{$idEtudiant}' data-mois='{$tabMois[$iReste]}'> Payer</button>
                                </div>";
                }
                $output .= "</div>";
            }
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
