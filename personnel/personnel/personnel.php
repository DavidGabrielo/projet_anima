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
    <title>Personnel</title>
    <link href="../../bootstrap/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.datatables.net/v/bs5/dt-1.13.6/datatables.min.css" rel="stylesheet" />
    <?php include("../header/headerPers_style.php"); ?>
    <?php include("personnel_style.php"); ?>
</head>

<body>
    <?php include("../header/headerPers.php"); ?>
    <section class="container py-2">
        <div class="row">
            <div class="col-lg-10 col-md mb-2 mx-auto">
                <h1 class="fs-4 text-center lead text-primary">PARAMETRE DE PERSONNEL POUR LA FONCTION : <span class="text-danger" id="fonctionSlct"></span></h1>
            </div>
        </div>
        <div class="dropdown-divider border-warning"></div>
        <div class="row">
            <div class="col-md-6">
                <h5 class="fw-bold mb-0">Liste de classe</h5>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-end">
                    <button class="btn btn-primary btn-sm me-3 nouveau" data-bs-toggle="modal" data-bs-target="#createModal"><i class="fas fa-folder-plus"></i> Nouveau</button>
                    <a href="" class="btn btn-success btn-sm" id="export"><i class="fas fa-table"></i> Exporter</a>
                </div>
            </div>
        </div>
        <div class="dropdown-divider border-warning"></div>
        <div class="row">
            <div class="row">
                <div class="table-responsive" id="orderTable">
                    <h3 class="text-success text-center">Chargement des étudiants...</h3>
                </div>
            </div>
        </div>
    </section>

    <!-- insert Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="createModalLabel">Nouveau personnel</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="formOrder">
                        <input type='number' class='idFonction' name="fonction" hidden />
                        <div class="row">
                            <div class="col">
                                <div class="form-floating mb-1">
                                    <input type="text" class="form-control" id="code" name="code">
                                    <label for="code">Code</label>
                                </div>
                                <div class="form-floating mb-1">
                                    <input type="text" class="form-control" id="prenom" name="prenom">
                                    <label for="prenom">Prénom</label>
                                </div>
                                <div class="form-floating mb-1">
                                    <input type="text" class="form-control" id="nom" name="nom">
                                    <label for="nom">Nom</label>
                                </div>
                                <div class="form-floating mb-1">
                                    <input type="date" class="form-control" id="dtns" name="dtns">
                                    <label for="dtns">Date de naissance</label>
                                </div>
                                <div class="form-floating mb-1">
                                    <input type="text" class="form-control" id="lieuns" name="lieuns">
                                    <label for="lieuns">Lieu de naissance</label>
                                </div>
                                <div class="form-floating mb-1">
                                    <input type="text" class="form-control" id="adresse" name="adresse">
                                    <label for="adresse">Adresse</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating mb-1">
                                    <!-- <input type="file"> -->
                                    <input type="file" id="fileInput" name="photo" />
                                    <img src="" id="imagePreview" alt="Image Preview">
                                </div>
                            </div>
                        </div>
                        <div class="form-floating mb-1 row">
                            <div class="col">
                                <div class="form-floating mb-1">
                                    <input type="text" class="form-control" id="contact" name="contact">
                                    <label for="contact">Contact</label>
                                </div>
                            </div>
                            <div class="col">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="create" id="create">Ajouter <i class="fas fa-plus"></i></button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- insert Modal -->
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="updateModalLabel">Nouveau étudiant</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="formOrderUpdate">
                        <input type="number" id="id" name="id" hidden />
                        <input type='number' class='idFonction' name="niveau" hidden />
                        <div class="row">
                            <div class="col">
                                <div class="form-floating mb-1">
                                    <input type="text" class="form-control" id="codeUpdate" name="codeUpdate">
                                    <label for="codeUpdate">Code</label>
                                </div>
                                <div class="form-floating mb-1">
                                    <input type="text" class="form-control" id="prenomUpdate" name="prenomUpdate">
                                    <label for="prenomUpdate">Prénom</label>
                                </div>
                                <div class="form-floating mb-1">
                                    <input type="text" class="form-control" id="nomUpdate" name="nomUpdate">
                                    <label for="nomUpdate">Nom</label>
                                </div>
                                <div class="form-floating mb-1">
                                    <input type="date" class="form-control" id="dtnsUpdate" name="dtnsUpdate">
                                    <label for="dtnsUpdate">Date de naissance</label>
                                </div>
                                <div class="form-floating mb-1">
                                    <input type="text" class="form-control" id="lieunsUpdate" name="lieunsUpdate">
                                    <label for="lieunsUpdate">Lieu de naissance</label>
                                </div>
                                <div class="form-floating mb-1">
                                    <input type="text" class="form-control" id="adresseUpdate" name="adresseUpdate">
                                    <label for="adresseUpdate">Adresse</label>
                                </div>
                                <div class="form-floating mb-1">
                                    <input type="text" class="form-control" id="contactUpdate" name="contactUpdate">
                                    <label for="contactUpdate">Adresse</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating mb-1">
                                    <!-- <input type="file"> -->
                                    <input type="file" id="fileInputUpdate" name="photo" />
                                    <img src="" id="imagePreviewUpdate" alt="Image Preview" />
                                    <span class="contPhotoUpdate"></span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="create" id="update">Mettre à jour <i class="fas fa-sync"></i></button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- INFO DE L'ETUDIANT -->
    <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="createModalLabel">Nouveau étudiant</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="row">
                            <div class="col">
                                <div class="mb-1">
                                    <label for="">Code : </label> <span id="codeSlct"></span>
                                </div>
                                <div class="mb-1">
                                    <label for="">Prénom : </label> <span id="prenomSlct"></span>
                                </div>
                                <div class="mb-1">
                                    <label for="">Nom : </label> <span id="nomSlct"></span>
                                </div>
                                <div class="mb-1">
                                    <label for="">Date de naissance : </label> <span id="dtnsSlct"></span>
                                </div>
                                <div class="mb-1">
                                    <label for="">Lieu de naissance : </label> <span id="lieunsSlct"></span>
                                </div>
                                <div class="mb-1">
                                    <label for="">Adresse : </label> <span id="adresseSlct"></span>
                                </div>
                                <div class="mb-1">
                                    <label for="">Contact : </label> <span id="contactSlct"></span>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-1">
                                    <div class="contPhoto"></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <?php include("personnel_js.php"); ?>
</body>

</html>