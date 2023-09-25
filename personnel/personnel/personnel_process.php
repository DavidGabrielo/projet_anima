<?php
require_once "personnel_model.php";
$db = new Model();

if (isset($_POST["slctFonction"])) {
    $tabFonction = $db->slctFonction();
    $output = "";

    $output .= "<select class='optionFonction pt-2 pb-2 w-25 text-center'>";
    if (count($tabFonction) > 0) {
        for ($i = 0; $i < count($tabFonction); $i++) {
            $output .= "<option value='{$tabFonction[$i]["id"]}'>{$tabFonction[$i]["fonction"]}</option>";
        }
    }
    $output .= "</select>";
    echo $output;
}

if (isset($_POST["slctIdFonction"])) {
    $tabFonction = $db->slctFonction();
    if (count($tabFonction) > 0) {
        echo $tabFonction[0]["id"];
    } else {
        echo "";
    }
}


if (isset($_POST["slctId"])) {
    if (isset($_POST["idFonction"])) {
        $tabPersonnel = $db->lectureAvecId((int)$_POST["idFonction"]);
    } else {
        $tabPersonnel = $db->lectureSansId();
    }
    $output = "";

    if ($tabPersonnel != "") {
        if (count($tabPersonnel) > 0) {
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
            foreach ($tabPersonnel as $elmInscription) {
                $rang++;
                $output .= "
                <tr>
                    <th scope='col'>$rang</th>
                    <td>$elmInscription->code</td>
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

if (isset($_POST["slctIdClasseAvecFonction"])) {
    if (isset($_POST["idFonction"])) {
        $tabPersonnel = $db->lectureAvecId((int)$_POST["idFonction"]);
    } else {
        $tabPersonnel = $db->lectureSansId();
    }

    $output = "";
    if (count($tabPersonnel) > 0) {
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
        foreach ($tabPersonnel as $elmInscription) {
            $rang++;
            $output .= "
                <tr>
                    <th scope='col'>$rang</th>
                    <td>$elmInscription->code</td>
                    <td>$elmInscription->prenom</td>
                    <td>$elmInscription->nom</td>
                    <td>
                        <a href=\"#\" class=\"text-primary me-2 infoBtn\" title=\"Plus de details\" data-id=\"$elmInscription->id\"><i class=\"fas fa-info-circle\" data-bs-toggle='modal'  data-bs-target='#infoModal'></i></a>
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
    echo json_encode($db->getInfoPersonnel($informationId));
}

// SUPPRESSION DE FACTURE
if (isset($_POST['deletionId'])) {
    $deletionId = (int)$_POST["deletionId"];
    echo $db->delete($deletionId);
}
