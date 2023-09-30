<?php
require_once "payement_model.php";
$db = new Model();

$tabMois = ["janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre"];
if (isset($_POST["slctPayement"])) {
    $aff = 0;
    $rangMois = 0;
    $output = "";

    $tabAnnee = $db->slctAnnee();
    if (count($tabAnnee) > 0) {
        $idAnnee = $tabAnnee[0]["id"];
        $moisDebut = $tabAnnee[0]["mois_debut"];
        $anneeDebut = $tabAnnee[0]["debut_annee"];
        $anneeFin = $tabAnnee[0]["fin_annee"];
        $nbMois = $tabAnnee[0]["nb_mois"];

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
                    $tabPayement = $db->getPayement($idAnnee);
                    if (count($tabPayement) > 0) {
                        $moisPaye = $tabPayement[0]["mois"];
                        $tabMoisPaye = explode(" , ", $moisPaye);
                        if (in_array($tabMois[$i] . " " . $anneeDebut, $tabMoisPaye)) {
                            $output .= "
                                        <div class='contPayement'>
                                            <h5 class='paye'>Disponible</h5>
                                        </div>";
                        } else {
                            $output .= "
                                    <div class='contNonPaye'>
                                        <h6>non disponible</h6>
                                        <button class='btn btn-success btn-sm me-3 payementBtn' data-id='{$idAnnee}' data-mois='{$tabMois[$i]} {$anneeDebut}'> Activer</button>
                                    </div>";
                        }
                    } else {
                        $output .= "
                                <div class='contNonPaye'>
                                    <h6>non disponible</h6>
                                    <button class='btn btn-success btn-sm me-3 payementBtn' data-id='{$idAnnee}' data-mois='{$tabMois[$i]} {$anneeDebut}'> Activer</button>
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

            if (count($tabPayement) > 0) {
                $moisPaye = $tabPayement[0]["mois"];
                $tabMoisPaye = explode(" , ", $moisPaye);
                if (in_array($tabMois[$iReste] . " " . $anneeFin, $tabMoisPaye)) {
                    $output .= "
                                <div class='contPayement'>
                                    <h5 class='paye'>Disponible</h5>
                                </div>";
                } else {
                    $output .= "
                                <div class='contNonPaye'>
                                    <h6>non disponible</h6>
                                    <button class='btn btn-success btn-sm me-3 payementBtn' data-id='{$idAnnee}' data-mois='{$tabMois[$iReste]} {$anneeFin}'> Activer</button>
                                </div>";
                }
            } else {
                $output .= "
                                <div class='contNonPaye'>
                                    <h6>non disponible</h6>
                                    <button class='btn btn-success btn-sm me-3 payementBtn' data-id='{$idAnnee}' data-mois='{$tabMois[$iReste]} {$anneeFin}'> Activer</button>
                                </div>";
            }
            $output .= "</div>";
        }
    } else {
        $output .= "<h3 class='mt-2 text-center'>Veuillez parametrer votre année scolaire pour vous permettre d'utiliser correctement cette page</h3>";
    }

    echo $output;
}

if (isset($_POST["idAnnee"]) && isset($_POST["mois"])) {
    echo $db->confirmPayement($_POST["idAnnee"], $_POST["mois"]);
}
