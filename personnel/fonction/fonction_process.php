<?php
require_once "fonction_model.php";
$db = new Model();
if (isset($_POST['action']) && $_POST['action'] == 'create') {
    extract($_POST);
    echo $db->create($fonction, $prix);
}

if (isset($_POST["action"]) && $_POST['action'] == 'fetch') {
    $bills = $db->read();
    $output = '';

    if ($db->countBills() > 0) {
        $output .= "
            <table class='table table-striped'>
                <thead>
                    <tr>
                        <th scope='col'>#</th>
                        <th scope='col'>Fonction</th>
                        <th scope='col'>Prix</th>
                        <th scope='col'>Action</th>
                    </tr>
                </thead>
                <tbody>";
        $rang = 0;
        foreach ($bills as $bill) {
            $rang++;
            $output .= "
                <tr>
                    <th scope='col'>$rang</th>
                    <td>$bill->fonction</td>
                    <td>$bill->prix</td>
                    <td>
                        <a href=\"#\" class=\"text-primary me-2 editBtn\" title=\"Update\" data-id=\"$bill->id\"><i class=\"fas fa-edit\" data-bs-toggle='modal'  data-bs-target='#updateModal'></i></a>
                        <a href=\"#\" class=\"text-danger me-2 deleteBtn\" title=\"Delete\" data-id=\"$bill->id\" data-prix='$bill->prix'><i class=\"fas fa-trash-alt\"></i></a>
                    </td>
                </tr>
            ";
        }
        $output .= "</tbody>
            </table>";
    } else {
        echo "<h3 class='mt-5 offset-5'>Aucun fonction enregistré pour le moment</h3>";
    }
    echo $output;
}

// Info pour detail de facture
if (isset($_POST['workingId'])) {
    $workingId = $_POST['workingId'];
    echo json_encode($db->getSingleBill($workingId));
}

// MODIFICATION DE FACTURE
if (isset($_POST['action']) && $_POST['action'] == 'update') {
    echo $db->update((int)$_POST["id"], $_POST["fonctionUpdate"], $_POST["prixUpdate"]);
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
