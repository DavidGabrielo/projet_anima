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
    <title>Classe</title>
    <link href="../../bootstrap/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.datatables.net/v/bs5/dt-1.13.6/datatables.min.css" rel="stylesheet" />
    <?php include("../header/header_primaire_style.php"); ?>
    <?php include("bulletin_style.php"); ?>
    <script src="../../js/html2pdf.bundle.min.js"></script>
</head>

<body>
    <?php include("../header/header_primaire.php"); ?>
    <section class="py-2 contBull">
        <div class="row">
            <div class="col-lg-8 col-md mb-2 mx-auto">
                <h1 class="fs-4 text-center lead text-primary">PARAMETRES D'ECOLAGE DANS LE NIVEAU : <span class="text-danger" id="niveauSlct"></span></h1>
            </div>
        </div>
        <div class="dropdown-divider border-warning"></div>

        <div class="row">
            <div onclick='telecharger();' class='contBtnImpression'><button class='btn btn-primary'>Exporter en PDF</button></div>
            <div>
                <div class="col-lg-12" id="contClasse">
                    <h5>Chargement des classes</h5>
                </div>
                <div class="table-responsive col-lg-12" id="orderTable">
                    <h3 class="text-success text-center">Chargement des étudiants...</h3>
                </div>
            </div>
        </div>
    </section>

    <!-- insert Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="createModalLabel">Paramètre de note</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="formOrder">
                        <input type='number' class='idetudiant' name="idetudiant" hidden />
                        <input type='number' class='idmatiere' name="idmatiere" hidden />
                        <input type='text' class='type' name="type" hidden />
                        <input type='number' class='niveau' name="niveau" hidden />
                        <input type='number' class='classe' name="classe" hidden />
                        <input type='number' class='annee' name="annee" hidden />
                        <div class="form-floating mb-1 row">
                            <div class="form-floating mb-1">
                                <input type="number" class="form-control" id="note" name="number">
                                <label for="note">Note</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="create" id="appliquer">Appliquer</button>
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
                        <input type='number' class='idNiveau' name="niveau" hidden />
                        <input type='number' class='idClasse' name="classe" hidden />
                        <div class="row">
                            <div class="col">
                                <div class="form-floating mb-1">
                                    <input type="text" class="form-control" id="numeroUpdate" name="numeroUpdate">
                                    <label for="numeroUpdate">Numéro</label>
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
                        <div class="form-floating mb-1 row">
                            <div class="col">
                                <div class="form-floating mb-1">
                                    <input type="text" class="form-control" id="pereUpdate" name="pereUpdate">
                                    <label for="pereUpdate">Père</label>
                                </div>
                                <div class="form-floating mb-1">
                                    <input type="text" class="form-control" id="professionPereUpdate" name="professionPereUpdate">
                                    <label for="professionPereUpdate">Proféssion</label>
                                </div>
                                <div class="form-floating mb-1">
                                    <input type="text" class="form-control" id="contactPereUpdate" name="contactPereUpdate">
                                    <label for="contactPereUpdate">Contact</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating mb-1">
                                    <input type="text" class="form-control" id="mereUpdate" name="mereUpdate">
                                    <label for="mereUpdate">Mère</label>
                                </div>
                                <div class="form-floating mb-1">
                                    <input type="text" class="form-control" id="professionMereUpdate" name="professionMereUpdate">
                                    <label for="professionMereUpdate">Proféssion</label>
                                </div>
                                <div class="form-floating mb-1">
                                    <input type="text" class="form-control" id="contactMereUpdate" name="contactMereUpdate">
                                    <label for="contactMereUpdate">Contact</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating mb-1">
                                    <input type="text" class="form-control" id="repondantUpdate" name="repondantUpdate">
                                    <label for="repondantUpdate">Répondant</label>
                                </div>
                                <div class="form-floating mb-1">
                                    <input type="text" class="form-control" id="professionRepondantUpdate" name="professionRepondantUpdate">
                                    <label for="professionRepondantUpdate">Proféssion</label>
                                </div>
                                <div class="form-floating mb-1">
                                    <input type="text" class="form-control" id="contactRepondantUpdate" name="contactRepondantUpdate">
                                    <label for="contactRepondantUpdate">Contact</label>
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
    <?php include("bulletin_js.php"); ?>
</body>

</html>