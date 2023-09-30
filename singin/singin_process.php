<?php
include "singin_model.php";
$db = new Model();

echo $db->creationCompte($_POST["prenom"], $_POST["nom"], $_POST["motPasse"]);
