<?php
require_once "../header/headerPers_model.php";
$db = new Model();

// ENREGISTREMENT D'UNE NOUVELLE ANNEE
if (isset($_POST['action']) && $_POST['action'] == 'nouvelleAnnee') {
    extract($_POST);
    $db->createNouvelleAnnee($debutAnnee, $finAnnee, $debutMois, $nbMois);
}

// Info pour detail de facture
if (isset($_POST['slctAnnee'])) {
    echo json_encode($db->getAnnee());
}

if (isset($_POST["action"]) && $_POST['action'] == 'fetchAnnee') {
    $tabAnnee = $db->readAnnee();
    $output = '';

    if ($db->countAnnee() > 0) {
        $output = $tabAnnee[0]["debut_annee"] . " - " . $tabAnnee[0]["fin_annee"];
    } else {
        echo "ANNEE SCOLAIRE";
    }
    echo $output;
}

if (isset($_POST["action"]) && $_POST['action'] == 'DebutMois') {
    $tabAnnee = $db->readAnnee();
    $tabMois = ["janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre"];
    $output = '';

    if ($db->countAnnee() > 0) {
        $moisDebut = $tabAnnee[0]["mois_debut"];
        for ($i = 0; $i < count($tabMois); $i++) {
            if ($tabMois[$i] == $moisDebut) {
                $output .= "<option value='{$tabMois[$i]}' selected>{$tabMois[$i]}</option>";
            } else {
                $output .= "<option value='{$tabMois[$i]}'>{$tabMois[$i]}</option>";
            }
        }
    } else {
        for ($i = 0; $i < count($tabMois); $i++) {
            $output .= "<option value='{$tabMois[$i]}'>{$tabMois[$i]}</option>";
        }
    }
    echo $output;
}

if (isset($_POST["action"]) && $_POST['action'] == 'finMois') {
    $tabAnnee = $db->readAnnee();
    $nb_mois = $tabAnnee[0]["nb_mois"];
    echo $nb_mois;
}

if (isset($_POST["action"]) && $_POST['action'] == 'miseAjour') {
    if ($db->slctDoublon($_POST["debutAnnee"], $_POST["finAnnee"]) > 0) {
        echo $db->slctDoublon($_POST["debutAnnee"], $_POST["finAnnee"]);
    } else {
        $db->updateAnnee($_POST["debutAnnee"], $_POST["finAnnee"], $_POST["debutMois"], $_POST["nbMois"]);
        echo "perfect";
    }
}
