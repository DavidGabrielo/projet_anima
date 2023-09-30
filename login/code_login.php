<?php
include("login/login_model.php");
$db = new Model();
if (isset($_POST["bouton"])) {
    if (!empty($_POST["prenom"]) && !empty($_POST["mot_passe"])) {
        $selection = $db->slctDoublon($_POST["prenom"]);
        $nb_select = count($selection);
        if ($nb_select > 0) {
            $id_employe = $selection[0]["id"];
            $passe = $_POST["mot_passe"];
            $pass_hash = $selection[0]["passe"];
            if (password_verify($passe, $pass_hash)) {
                $_SESSION["prenom"] = $_POST["prenom"];
                // header("Location: accueil/accueil.php");
?>
                <script>
                    window.open("accueil/accueil.php", "_self");
                </script>
            <?php
            } else {
            ?>
                <script>
                    let erreur = document.getElementById("erreur");
                    erreur.innerHTML = "Mot de passe incorrect";
                </script>
            <?php
            }
        } else {
            ?>
            <script type="text/javascript">
                $(document).ready(function() {
                    $("#erreur").text("Ce compte n'existe pas!!!")
                })
            </script>
        <?php
        }
    } else {
        ?>
        <script>
            let erreur = document.getElementById("erreur");
            erreur.innerHTML = "Veuillez tout remplir";
        </script>
<?php
    }
}
