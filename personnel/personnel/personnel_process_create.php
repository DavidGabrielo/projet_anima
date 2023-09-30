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

if ($_POST["fonction"] != "") {
    $fonction = $_POST["fonction"];
} else {
    $tabFonction = $db->slctFonction();
    if (count($tabFonction) > 0) {
        $fonction = $tabFonction[0]["id"];
    } else {
        $fonction = "";
    }
}

if ($fonction != "") {
    $retour = $db->create($_POST["code"], $_POST["prenom"], $_POST["nom"], $_POST["dtns"], $_POST["lieuns"], $_POST["adresse"], $photo, $_POST["contact"], $fonction);

    if ($retour == 1) {
        if (isset($chemin)) {
            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $chemin)) {
                echo "oui";
            } else {
                echo "non";
            }
        } else {
            echo "aucun chemin";
        }
    } else {
        echo "redondance";
    }
} else {
    echo "Veuillez enregistrer de fonction avant d'enregistrer de personnel";
}
