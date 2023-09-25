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

$retour = $db->update($_POST["id"], $_POST["codeUpdate"], $_POST["prenomUpdate"], $_POST["nomUpdate"], $_POST["dtnsUpdate"], $_POST["lieunsUpdate"], $_POST["adresseUpdate"], $photo, $_POST["contactUpdate"]);

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
