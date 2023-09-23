<?php
session_start();
if (isset($_SESSION["prenom"])) {
} else {
    header("location:../../index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matières</title>
    <link href="../../bootstrap/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.datatables.net/v/bs5/dt-1.13.6/datatables.min.css" rel="stylesheet" />
    <?php include("../header/header_primaire_style.php"); ?>
</head>

<body>
    <?php include("../header/header_primaire.php"); ?>
    <section class="container py-2">
        <div class="row">
            <div class="col-lg-10 col-md mb-2 mx-auto">
                <h1 class="fs-4 text-center lead text-primary">PARAMETRES DE MATIERE POUR LE NIVEAU : <span class="text-danger" id="niveauSlct"></span></h1>
            </div>
        </div>
        <div class="dropdown-divider border-warning"></div>
        <div class="row">
            <div class="col-md-6">
                <h5 class="fw-bold mb-0">Liste de matieres</h5>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-end">
                    <button class="btn btn-primary btn-sm me-3" data-bs-toggle="modal" data-bs-target="#createModal"><i class="fas fa-folder-plus"></i> Nouveau</button>
                    <a href="" class="btn btn-success btn-sm" id="export"><i class="fas fa-table"></i> Exporter</a>
                </div>
            </div>
        </div>
        <div class="dropdown-divider border-warning"></div>
        <div class="row">
            <div class="table-responsive" id="orderTable">
                <h3 class="text-success text-center">Chargement des matières...</h3>
            </div>
        </div>
    </section>

    <!-- insert Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="createModalLabel">Nouvelle matiere</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="formOrder">
                        <input type='number' id='idNiveau' name="niveau" hidden />
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="matiere" name="matiere">
                            <label for="matiere">Nom de la matiere</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="coeff" name="coeff">
                            <label for="coeff">Coéfficient de la matiere</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" name="create" id="create">Ajouter <i class="fas fa-plus"></i></button>
                </div>
            </div>
        </div>
    </div>

    <!-- update Modal -->
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="updateModalLabel">Modifier la matière</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="formUpdateOrder">
                        <input type="number" name="id" id="idUpdate" hidden />
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="matiereUpdate" name="matiereUpdate">
                            <label for="matiereUpdate">Nom de la matiere</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="coeffUpdate" name="coeffUpdate">
                            <label for="coeffUpdate"> Nombre d'élèves maximum dans la matiere</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" name="update" id="update">Mettre à jour <i class="fas fa-sync"></i></button>
                </div>
            </div>
        </div>
    </div>

    <?php include("matieres_js.php"); ?>
</body>

</html>