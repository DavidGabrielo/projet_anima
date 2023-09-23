<?php
require_once "inscription_model.php";
$db = new Model();

// extract($_POST);

if ($_FILES["photo"]["name"]) {
    $fichier = $_FILES["photo"]["name"];
    $extension = pathinfo($fichier, PATHINFO_EXTENSION);

    $extension_valide = ["jpg", "jpeg", "png", "gif"];
    if (in_array($extension, $extension_valide)) {
        $photo = rand() . "_" . $fichier;
        $chemin = "photos/" . $photo;
    }
} else {
    $photo = "";
}

$annee = $db->slctAnnee();
$retour = $db->create($_POST["numero"], $_POST["prenom"], $_POST["nom"], $_POST["dtns"], $_POST["lieuns"], $_POST["adresse"], $photo, $_POST["pere"], $_POST["professionPere"], $_POST["contactPere"], $_POST["mere"], $_POST["professionMere"], $_POST["contactMere"], $_POST["repondant"], $_POST["professionRepondant"], $_POST["contactRepondant"], (int)$_POST["niveau"], (int)$_POST["classe"], (int)$annee);

if ($retour == 1) {
    if (isset($chemin)) {
        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $chemin)) {
            echo "oui";
        } else {
            echo "non";
        }
    }
} else {
    echo "echec";
}
