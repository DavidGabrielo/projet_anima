<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <title>Création de compte</title>
</head>

<body>
    <div class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-header">
                            <h5>Registration form</h5>
                        </div>
                        <div class="card-body">
                            <form id="formOrder">
                                <div class="form-group mb-3">
                                    <label for="">Prénom</label>
                                    <input type="text" name="prenom" id="prenom" class="form-control">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="">Nom</label>
                                    <input type="text" name="nom" id="nom" class="form-control">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="">Mot de passe</label>
                                    <input type="password" name="motPasse" id="motPasse" class="form-control">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="">Confirmation du mot de passe</label>
                                    <input type="password" name="confMotPasse" id="confMotPasse" class="form-control">
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="register_btn" class="btn btn-primary">Enregistrer</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="../js/jquery-3.6.0.min.js"></script>
    <?php include("singin_js.php"); ?>
</body>

</html>