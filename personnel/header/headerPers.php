<div class="container">
    <nav class="navbar navbar-expand-lg ftco_navbar ftco-navbar-light" id="ftco-navbar">
        <div class="container">
            <a class="navbar-brand anneeScolaire" data-bs-toggle="modal" data-bs-target="#anneeModal" href="#">Année scolaire</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="fa fa-bars"></span> Menu
            </button>
            <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav ml-auto">
                    <?php
                    if (!isset($_GET["page"])) {
                    ?>
                        <li class="nav-item"><a href="#" class="nav-link text-warning">Fonction</a></li>
                        <li class="nav-item"><a href="../personnel/personnel.php?page=personnel" class="nav-link">Personnel</a></li>
                        <li class="nav-item"><a href="../matieres/matieres.php?page=matières" class="nav-link">Matières</a></li>
                        <li class="nav-item"><a href="../inscription/inscription.php?page=inscription" class="nav-link">Inscription</a></li>
                        <li class="nav-item"><a href="../ecolages/ecolages.php?page=ecolages" class="nav-link">Ecolages</a></li>
                        <li class="nav-item"><a href="../notes/notes.php?page=notes" class="nav-link">Notes</a></li>
                        <li class="nav-item"><a href="../bulletin/bulletin.php?page=bulletin" class="nav-link">Bulletin</a></li>
                        <li class="nav-item"><a href="../../deconnection/deconnection.php" class="nav-link">Se deconnecter</a></li>
                        <?php
                    } else {
                        if ($_GET["page"] == "fonction") {
                        ?>
                            <li class="nav-item"><a href="#" class="nav-link text-warning">Fonction</a></li>
                            <li class="nav-item"><a href="../personnel/personnel.php?page=personnel" class="nav-link">Personnel</a></li>
                            <li class="nav-item"><a href="../matieres/matieres.php?page=matières" class="nav-link">Matières</a></li>
                            <li class="nav-item"><a href="../inscription/inscription.php?page=inscription" class="nav-link">Inscription</a></li>
                            <li class="nav-item"><a href="../ecolages/ecolages.php?page=ecolages" class="nav-link">Ecolages</a></li>
                            <li class="nav-item"><a href="../notes/notes.php?page=notes" class="nav-link">Notes</a></li>
                            <li class="nav-item"><a href="../bulletin/bulletin.php?page=bulletin" class="nav-link">Bulletin</a></li>
                            <li class="nav-item"><a href="../../deconnection/deconnection.php" class="nav-link">Se deconnecter</a></li>
                        <?php
                        } elseif ($_GET["page"] == "personnel") {
                        ?>
                            <li class="nav-item"><a href="../fonction/fonction.php" class="nav-link">Fonction</a></li>
                            <li class="nav-item"><a href="#" class="nav-link text-warning">Personnel</a></li>
                            <li class="nav-item"><a href="../matieres/matieres.php?page=matières" class="nav-link">Matières</a></li>
                            <li class="nav-item"><a href="../inscription/inscription.php?page=inscription" class="nav-link">Inscription</a></li>
                            <li class="nav-item"><a href="../ecolages/ecolages.php?page=ecolages" class="nav-link">Ecolages</a></li>
                            <li class="nav-item"><a href="../notes/notes.php?page=notes" class="nav-link">Notes</a></li>
                            <li class="nav-item"><a href="../bulletin/bulletin.php?page=bulletin" class="nav-link">Bulletin</a></li>
                            <li class="nav-item"><a href="../../deconnection/deconnection.php" class="nav-link">Se deconnecter</a></li>
                        <?php
                        } elseif ($_GET["page"] == "matières") {
                        ?>
                            <li class="nav-item"><a href="../fonction/fonction.php" class="nav-link">Fonction</a></li>
                            <li class="nav-item"><a href="../personnel/personnel.php?page=personnel" class="nav-link">Personnel</a></li>
                            <li class="nav-item"><a href="#" class="nav-link text-warning">Matières</a></li>
                            <li class="nav-item"><a href="../inscription/inscription.php?page=inscription" class="nav-link">Inscription</a></li>
                            <li class="nav-item"><a href="../ecolages/ecolages.php?page=ecolages" class="nav-link">Ecolages</a></li>
                            <li class="nav-item"><a href="../notes/notes.php?page=notes" class="nav-link">Notes</a></li>
                            <li class="nav-item"><a href="../bulletin/bulletin.php?page=bulletin" class="nav-link">Bulletin</a></li>
                            <li class="nav-item"><a href="../../deconnection/deconnection.php" class="nav-link">Se deconnecter</a></li>
                        <?php
                        } elseif ($_GET["page"] == "inscription") {
                        ?>
                            <li class="nav-item"><a href="../fonction/fonction.php" class="nav-link">Fonction</a></li>
                            <li class="nav-item"><a href="../personnel/personnel.php?page=personnel" class="nav-link">Personnel</a></li>
                            <li class="nav-item"><a href="../matieres/matieres.php?page=matières" class="nav-link">Matières</a></li>
                            <li class="nav-item"><a href="#" class="nav-link text-warning">Inscription</a></li>
                            <li class="nav-item"><a href="../ecolages/ecolages.php?page=ecolages" class="nav-link">Ecolages</a></li>
                            <li class="nav-item"><a href="../notes/notes.php?page=notes" class="nav-link">Notes</a></li>
                            <li class="nav-item"><a href="../bulletin/bulletin.php?page=bulletin" class="nav-link">Bulletin</a></li>
                            <li class="nav-item"><a href="../../deconnection/deconnection.php" class="nav-link">Se deconnecter</a></li>
                        <?php
                        } elseif ($_GET["page"] == "ecolages") {
                        ?>
                            <li class="nav-item"><a href="../fonction/fonction.php" class="nav-link">Fonction</a></li>
                            <li class="nav-item"><a href="../personnel/personnel.php?page=personnel" class="nav-link">Personnel</a></li>
                            <li class="nav-item"><a href="../matieres/matieres.php?page=matières" class="nav-link">Matières</a></li>
                            <li class="nav-item"><a href="../inscription/inscription.php?page=inscription" class="nav-link">Inscription</a></li>
                            <li class="nav-item"><a href="#" class="nav-link text-warning">Ecolages</a></li>
                            <li class="nav-item"><a href="../notes/notes.php?page=notes" class="nav-link">Notes</a></li>
                            <li class="nav-item"><a href="../bulletin/bulletin.php?page=bulletin" class="nav-link">Bulletin</a></li>
                            <li class="nav-item"><a href="../../deconnection/deconnection.php" class="nav-link">Se deconnecter</a></li>
                        <?php
                        } elseif ($_GET["page"] == "notes") {
                        ?>
                            <li class="nav-item"><a href="../fonction/fonction.php" class="nav-link">Fonction</a></li>
                            <li class="nav-item"><a href="../personnel/personnel.php?page=personnel" class="nav-link">Personnel</a></li>
                            <li class="nav-item"><a href="../matieres/matieres.php?page=matières" class="nav-link">Matières</a></li>
                            <li class="nav-item"><a href="../inscription/inscription.php?page=inscription" class="nav-link">Inscription</a></li>
                            <li class="nav-item"><a href="../ecolages/ecolages.php?page=ecolages" class="nav-link">Ecolages</a></li>
                            <li class="nav-item"><a href="#" class="nav-link text-warning">Notes</a></li>
                            <li class="nav-item"><a href="../bulletin/bulletin.php?page=bulletin" class="nav-link">Bulletin</a></li>
                            <li class="nav-item"><a href="../../deconnection/deconnection.php" class="nav-link">Se deconnecter</a></li>
                        <?php
                        } elseif ($_GET["page"] == "bulletin") {
                        ?>
                            <li class="nav-item"><a href="../fonction/fonction.php" class="nav-link">Fonction</a></li>
                            <li class="nav-item"><a href="../personnel/personnel.php?page=personnel" class="nav-link">Personnel</a></li>
                            <li class="nav-item"><a href="../matieres/matieres.php?page=matières" class="nav-link">Matières</a></li>
                            <li class="nav-item"><a href="../inscription/inscription.php?page=inscription" class="nav-link">Inscription</a></li>
                            <li class="nav-item"><a href="../ecolages/ecolages.php?page=ecolages" class="nav-link">Ecolages</a></li>
                            <li class="nav-item"><a href="../notes/notes.php?page=notes" class="nav-link">Notes</a></li>
                            <li class="nav-item"><a href="#" class="nav-link text-warning">Bulletin</a></li>
                            <li class="nav-item"><a href="../../deconnection/deconnection.php" class="nav-link">Se deconnecter</a></li>
                    <?php
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>
    <!-- END nav -->
</div>

<!-- update Modal Années scolaires -->
<div class="modal fade" id="anneeModal" tabindex="-1" aria-labelledby="anneeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="anneeModalLabel">Année scolaire</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row" action="" method="post" id="formAnnee">
                    <input type="hidden" name="id" id="bill_id" />
                    <div class="col">
                        <label for="fonctionUpdate">Début du mois</label>
                        <select name="debutMois" id="debutMois" class="pt-2 pb-2 text-center">
                            <option value="janvier">janvier</option>
                            <option value="février">février</option>
                            <option value="mars">mars</option>
                            <option value="avril">avril</option>
                            <option value="mai">mai</option>
                            <option value="juin">juin</option>
                            <option value="juillet">juillet</option>
                            <option value="août">août</option>
                            <option value="septembre">septembre</option>
                            <option value="octobre">octobre</option>
                            <option value="novembre">novembre</option>
                            <option value="décembre">décembre</option>
                        </select>
                    </div>
                    <div class="form-floating col mt-2 contDebutAnnee">
                        <input type="number" class="form-control" id="debutAnnee" name="debutAnnee">
                        <label for="fonctionUpdate">Début de l'année</label>
                    </div>

                    <!-- <div class="form-floating col">
                        <h1 class="text-center">-</h1>
                    </div> -->

                    <div class="form-floating col mt-2">
                        <input type="number" class="form-control" id="finAnnee" name="finAnnee">
                        <label for="abrUpdate"> Fin de l'année</label>
                    </div>
                    <div class="form-floating col mt-2">
                        <input type="number" class="form-control" id="nbMois" name="nbMois">
                        <label for="nbMois">Nombre de mois scolaire</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" name="update" id="updateAnnee">Mettre à jour <i class="fas fa-sync"></i></button>
                <button class="btn btn-primary nouvelleAnnee"><i class="fas fa-folder-plus"></i> Nouvelle année scolaire</button>
            </div>
        </div>
    </div>
</div>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.13.6/datatables.min.js"></script>

<!-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script type="text/javascript" src="../../js/jquery-3.6.0.min.js"></script> -->
<!-- <script src="../../js/cdnjs/sweetalert.min.js"></script> -->
<!-- <script src="../../bootstrap/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script> -->
<!-- <script src="https://cdn.datatables.net/v/bs5/dt-1.13.6/datatables.min.js"></script> -->
<!-- <script type="text/javascript" src="../../js/DataTables-1.13.6/media/js/jquery.dataTables.min.js"></script> -->
<!-- <script type="text/javascript" src="process.js"></script> -->
<?php include("headerPers_js.php"); ?>