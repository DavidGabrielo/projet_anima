<?php
require_once "impression_model.php";
$db = new Model();

if (isset($_POST["slctIdFonction"])) {
    $tabFonction = $db->slctFonction();
    if (count($tabFonction) > 0) {
        echo $tabFonction[0]["id"];
    } else {
        echo "";
    }
}

$tabMois = ["janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre"];
$moisRang = ["" => 0, "janvier" => 1, "février" => 2, "mars" => 3, "avril" => 4, "mai" => 5, "juin" => 6, "juillet" => 7, "août" => 8, "septembre" => 9, "octobre" => 10, "novembre" => 11, "décembre" => 12];
$moisFin = ["" => 0, "janvier" => 31, "février" => 28, "mars" => 31, "avril" => 30, "mai" => 31, "juin" => 30, "juillet" => 31, "août" => 31, "septembre" => 30, "octobre" => 31, "novembre" => 30, "décembre" => 31];

if (isset($_POST["slctId"])) {
    if (isset($_POST["mois"])) {
        $mois = $_POST["mois"];
    } else {
        $tabAnnee = $db->slctAnnee();
        if (count($tabAnnee) > 0) {
            $idAnnee = $tabAnnee[0]["id"];
        } else {
            $idAnnee = 0;
        }
        $tabPayement = $db->getPayement($idAnnee);
        if (count($tabPayement) > 0) {
            $moisSlct = $tabPayement[0]["mois"];
            $tabMois_1 = explode(" , ", $moisSlct);
            $mois = $tabMois_1[0];
        } else {
            $mois = "";
        }
    }

    $tabMois_2 = explode(" ", $mois);
    if (count($tabMois_2) == 2) {
        $moisSlct = $tabMois_2[0];
        $anneeSlct = $tabMois_2[1];
    } else {
        $moisSlct = "";
        $anneeSlct = 0;
    }


    $output = "";

    $tabPersonnel = $db->slctEmploye();
    if (count($tabPersonnel) > 0) {
        $array_annee = $db->slctAnnee();
        if (count($array_annee) > 0) {
            foreach ($tabPersonnel as $elmInscription) {
                $output .= "<div id='contPayement'>
                            <h6 class='card-header'><span>BULLETIN DE PAIE</span><span>Période du : 1/{$moisRang[$moisSlct]}/{$anneeSlct} au {$moisFin[$moisSlct]}/{$moisRang[$moisSlct]}/{$anneeSlct}</span></h6>
                        </div>";
            }
        } else {
            $output .= "<h3 class='mt-2 text-center'>Veuillez parametrer votre année scolaire pour vous permettre d'utiliser correctement cette page</h3>";
        }
    } else {
        $output .= "<h3 class='mt-2 text-center'>Aucun personnel enregistré</h3>";
    }

    echo $output;
}

if (isset($_POST["slctMois"])) {
    $output = "<select class='optionMois pt-2 pb-2 w-25 text-center'>";
    $tabAnnee = $db->slctAnnee();
    $aff = 0;
    $rangMois = 0;

    if (count($tabAnnee) > 0) {
        $idAnnee = $tabAnnee[0]["id"];
        $moisDebut = $tabAnnee[0]["mois_debut"];
        $anneeDebut = $tabAnnee[0]["debut_annee"];
        $anneeFin = $tabAnnee[0]["fin_annee"];
        $nbMois = $tabAnnee[0]["nb_mois"];

        for ($i = 0; $i < count($tabMois); $i++) {
            if ($tabMois[$i] == $moisDebut) {
                $aff = 1;
                $rangMois++;
            }

            if ($aff == 0) {
            } elseif ($aff == 1) {
                if ($rangMois <= $nbMois) {
                    $tabPayement = $db->getPayement((int)$idAnnee);
                    if (count($tabPayement) > 0) {
                        $moisPaye = $tabPayement[0]["mois"];
                        $tabMoisPaye = explode(" , ", $moisPaye);
                        if (in_array($tabMois[$i] . " " . $anneeDebut, $tabMoisPaye)) {
                            $output .= "<option value='{$tabMois[$i]} {$anneeDebut}'>{$tabMois[$i]} {$anneeDebut}</option>";
                        }
                    }
                }
            }

            if ($aff == 1) {
                $rangMois++;
            }
        }

        $resteMois = $nbMois - $rangMois;
        for ($iReste = 0; $iReste <= $resteMois; $iReste++) {
            if (count($tabPayement) > 0) {
                $moisPaye = $tabPayement[0]["mois"];
                $tabMoisPaye = explode(" , ", $moisPaye);
                if (in_array($tabMois[$iReste] . " " . $anneeFin, $tabMoisPaye)) {
                    $output .= "<option value='{$tabMois[$iReste]} {$anneeFin}'>{$tabMois[$iReste]} {$anneeFin}</option>";
                }
            }
        }
    }
    $tabFonction = $db->getMois();

    $output .= "</select>";
    echo $output;
}
