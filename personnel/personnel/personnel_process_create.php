<?php
require_once "personnel_model.php";
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

$retour = $db->create($_POST["code"], $_POST["prenom"], $_POST["nom"], $_POST["dtns"], $_POST["lieuns"], $_POST["adresse"], $photo, $_POST["contact"], $_POST["fonction"]);

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
