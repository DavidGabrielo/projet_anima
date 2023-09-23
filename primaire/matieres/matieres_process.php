<?php
require_once "matieres_model.php";
$db = new Model();

if (isset($_POST["slctIdNiveau"])) {
    $tabNiveau = $db->slctNiveau();
    if (count($tabNiveau) > 0) {
        echo $tabNiveau[0]["id"];
    } else {
        echo "";
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

if (isset($_POST["slctId"])) {
    if (isset($_POST["idNiveau"])) {
        $tabClasse = $db->lectureAvecId($_POST["idNiveau"]);
    } else {
        $tabClasse = $db->lectureSansId();
    }

    $output = "";

    if ($tabClasse != "") {
        if (count($tabClasse) > 0) {
            $output .= "
            <table class='table table-striped'>
                <thead>
                    <tr>
                        <th scope='col'>#</th>
                        <th scope='col'>Matières</th>
                        <th scope='col'>Coéfficient</th>
                        <th scope='col'>Action</th>
                    </tr>
                </thead>
                <tbody>";
            $rang = 0;
            foreach ($tabClasse as $elmClasse) {
                $rang++;
                $output .= "
                <tr>
                    <th scope='col'>$rang</th>
                    <td>$elmClasse->matieres</td>
                    <td>$elmClasse->coeff</td>
                    <td>
                        <a href=\"#\" class=\"text-primary me-2 editBtn\" title=\"Update\" data-id=\"$elmClasse->id\"><i class=\"fas fa-edit\" data-bs-toggle='modal'  data-bs-target='#updateModal'></i></a>
                        <a href=\"#\" class=\"text-danger me-2 deleteBtn\" title=\"Delete\" data-id=\"$elmClasse->id\" data-matiere='$elmClasse->matieres'><i class=\"fas fa-trash-alt\"></i></a>
                    </td>
                </tr>
            ";
            }
            $output .= "</tbody>
            </table>";
        } else {
            $output .= "<h3 class='mt-2 text-center'>Aucune matière enregistrée pour le moment</h3>";
        }
    } else {
        $output .= "<h3 class='mt-2 text-center'>Aucune matière enregistrée pour le moment</h3>";
    }

    echo $output;
}

if (isset($_POST['action']) && $_POST['action'] == 'create') {
    extract($_POST);
    echo $db->create($matiere, (int)$niveau, (int)$coeff);
}

// Info pour detail de facture
if (isset($_POST['workingId'])) {
    $workingId = $_POST['workingId'];
    echo json_encode($db->getSingleMatiere($workingId));
}

// MODIFICATION DE FACTURE
if (isset($_POST['action']) && $_POST['action'] == 'update') {
    echo $db->update($_POST["matiereUpdate"], $_POST["coeffUpdate"], (int)$_POST["id"]);
}

// Info pour detail de facture
if (isset($_POST['informationId'])) {
    $informationId = $_POST['informationId'];
    echo json_encode($db->getSingleBill($informationId));
}

// SUPPRESSION DE FACTURE
if (isset($_POST['deletionId'])) {
    $deletionId = (int)$_POST["deletionId"];
    $db->delete($deletionId);
    echo $db->delete($deletionId);
}
