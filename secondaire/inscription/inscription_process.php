<?php
require_once "inscription_model.php";
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

if (isset($_POST["slctId"])) {
    if (isset($_POST["idNiveau"]) && isset($_POST["idClasse"])) {
        $tabInscription = $db->lectureAvecId((int)$_POST["idNiveau"], (int)$_POST["idClasse"]);
    } else {
        $tabInscription = $db->lectureSansId();
    }
    $output = "";

    if ($tabInscription != "") {
        if (count($tabInscription) > 0) {
            $output .= "
            <table class='table table-striped'>
                <thead>
                    <tr>
                        <th scope='col'>#</th>
                        <th scope='col'>Numéro</th>
                        <th scope='col'>Prénom</th>
                        <th scope='col'>Nom</th>
                        <th scope='col'>Action</th>
                    </tr>
                </thead>
                <tbody>";
            $rang = 0;
            foreach ($tabInscription as $elmInscription) {
                $rang++;
                $output .= "
                <tr>
                    <th scope='col'>$rang</th>
                    <td>$elmInscription->numero</td>
                    <td>$elmInscription->prenom</td>
                    <td>$elmInscription->nom</td>
                    <td>
                        <a href=\"#\" class=\"text-primary me-2 infoBtn\" title=\"Plus de detail\" data-id=\"$elmInscription->id\"><i class=\"fas fa-info-circle\" data-bs-toggle='modal'  data-bs-target='#infoModal'></i></a>
                        <a href=\"#\" class=\"text-primary me-2 editBtn\" title=\"Modifier\" data-id=\"$elmInscription->id\"><i class=\"fas fa-edit\" data-bs-toggle='modal'  data-bs-target='#updateModal'></i></a>
                        <a href=\"#\" class=\"text-danger me-2 deleteBtn\" title=\"Supprimer\" data-id=\"$elmInscription->id\" data-prenom=\"$elmInscription->prenom\"><i class=\"fas fa-trash-alt\"></i></a>
                    </td>
                </tr>
            ";
            }
            $output .= "</tbody>
            </table>";
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
        $output .= "
            <table class='table table-striped'>
                <thead>
                    <tr>
                        <th scope='col'>#</th>
                        <th scope='col'>Numéro</th>
                        <th scope='col'>Prénom</th>
                        <th scope='col'>Nom</th>
                        <th scope='col'>Action</th>
                    </tr>
                </thead>
                <tbody>";
        $rang = 0;
        foreach ($tabInscription as $elmInscription) {
            $rang++;
            $output .= "
                <tr>
                    <th scope='col'>$rang</th>
                    <td>$elmInscription->numero</td>
                    <td>$elmInscription->prenom</td>
                    <td>$elmInscription->nom</td>
                    <td>
                        <a href=\"#\" class=\"text-primary me-2 editBtn\" title=\"Plus de details\" data-id=\"$elmInscription->id\"><i class=\"fas fa-info-circle\" data-bs-toggle='modal'  data-bs-target='#infoModal'></i></a>
                        <a href=\"#\" class=\"text-primary me-2 editBtn\" title=\"Modifier\" data-id=\"$elmInscription->id\"><i class=\"fas fa-edit\" data-bs-toggle='modal'  data-bs-target='#updateModal'></i></a>
                        <a href=\"#\" class=\"text-danger me-2 deleteBtn\" title=\"Supprimer\" data-id=\"$elmInscription->id\"><i class=\"fas fa-trash-alt\"></i></a>
                    </td>
                </tr>
            ";
        }
        $output .= "</tbody>
            </table>";
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

// MODIFICATION DE FACTURE
if (isset($_POST['action']) && $_POST['action'] == 'update') {
    echo $db->update($_POST["classeUpdate"], $_POST["nbUpdate"], (int)$_POST["id"]);
}

// Info pour detail de facture
if (isset($_POST['informationId'])) {
    $informationId = $_POST['informationId'];
    echo json_encode($db->getInfoEtudiant($informationId));
}

// SUPPRESSION DE FACTURE
if (isset($_POST['deletionId'])) {
    $deletionId = (int)$_POST["deletionId"];
    echo $db->delete($deletionId);
}
