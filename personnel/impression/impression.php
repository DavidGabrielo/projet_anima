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
    <title>impression</title>
    <link href="../../bootstrap/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.datatables.net/v/bs5/dt-1.13.6/datatables.min.css" rel="stylesheet" />
    <?php include("../header/headerPers_style.php"); ?>
    <?php include("impression_style.php"); ?>
</head>

<body>
    <?php include("../header/headerPers.php"); ?>
    <section class="container py-2">
        <div class="row">
            <div class="col-lg-10 col-md mb-2 mx-auto">
                <h1 class="fs-4 text-center lead text-primary">PARAMETRE D'IMPRESSION POUR LA FONCTION : <span class="text-danger" id="fonctionSlct"></span></h1>
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

    <?php include("impression_js.php"); ?>
</body>

</html>