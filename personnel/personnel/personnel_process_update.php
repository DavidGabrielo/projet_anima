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
$retour = $db->update($_POST["id"], $_POST["numeroUpdate"], $_POST["prenomUpdate"], $_POST["nomUpdate"], $_POST["dtnsUpdate"], $_POST["lieunsUpdate"], $_POST["adresseUpdate"], $photo, $_POST["pereUpdate"], $_POST["professionPereUpdate"], $_POST["contactPereUpdate"], $_POST["mereUpdate"], $_POST["professionMereUpdate"], $_POST["contactMereUpdate"], $_POST["repondantUpdate"], $_POST["professionRepondantUpdate"], $_POST["contactRepondantUpdate"], (int)$_POST["niveau"], (int)$_POST["classe"], (int)$annee);

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
