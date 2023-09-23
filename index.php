<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <title>Login</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background: url(resources/photo_login/6845078.png) no-repeat;
            height: 100vh;
            font-family: sans-serif;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            overflow: hidden
        }

        @media screen and (max-width: 600px) {
            body {
                background-size: cover;
                position: fixed
            }
        }

        #particles-js {
            height: 100%
        }

        .loginBox {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 350px;
            min-height: 200px;
            background: #000000;
            border-radius: 10px;
            padding: 40px;
            box-sizing: border-box
        }

        .user {
            margin: 0 auto;
            display: block;
            margin-bottom: 20px
        }

        h3 {
            margin: 0;
            padding: 0 0 20px;
            color: #59238F;
            text-align: center
        }

        .loginBox input {
            width: 100%;
            margin-bottom: 20px
        }

        .loginBox input[type="text"],
        .loginBox input[type="password"] {
            border: none;
            border-bottom: 2px solid #262626;
            outline: none;
            height: 40px;
            color: #fff;
            background: transparent;
            font-size: 16px;
            padding-left: 20px;
            box-sizing: border-box
        }

        .loginBox input[type="text"]:hover,
        .loginBox input[type="password"]:hover {
            color: #42F3FA;
            border: 1px solid #42F3FA;
            box-shadow: 0 0 5px rgba(0, 255, 0, .3), 0 0 10px rgba(0, 255, 0, .2), 0 0 15px rgba(0, 255, 0, .1), 0 2px 0 black
        }

        .loginBox input[type="text"]:focus,
        .loginBox input[type="password"]:focus {
            border-bottom: 2px solid #42F3FA
        }

        .inputBox {
            position: relative
        }

        .inputBox span {
            position: absolute;
            top: 10px;
            color: #262626
        }

        .loginBox input[type="submit"] {
            border: none;
            outline: none;
            height: 40px;
            font-size: 16px;
            background: #59238F;
            color: #fff;
            border-radius: 20px;
            cursor: pointer
        }

        .loginBox a {
            color: #262626;
            font-size: 14px;
            font-weight: bold;
            text-decoration: none;
            text-align: center;
            display: block
        }

        a:hover {
            color: #00ffff
        }

        p {
            color: #0000ff
        }
    </style>
</head>

<body>
    <div class="loginBox">
        <img class="user" src="resources/photo_login/2.png" height="100px" width="100px">
        <h3>Sign in here</h3>
        <form method="post">
            <div class="inputBox">
                <input id="uname" type="text" name="prenom" placeholder="Username">
                <input id="pass" type="password" name="mot_passe" placeholder="Password">
            </div>
            <input type="submit" name="bouton" value="Login">
        </form>
        <!-- <a href="#">Forget Password<br> </a>
        <div class="text-center">
            <p style="color: #59238F;">Sign-Up</p>
        </div> -->
        <div class="text-center erreur text-danger" id="erreur"></div>
    </div>
    <?php
    if (isset($_POST["bouton"])) {
        if (!empty($_POST["prenom"]) && !empty($_POST["mot_passe"])) {
            if ($_POST["mot_passe"] == "logiciel_anima") {
                $_SESSION["prenom"] = $_POST["prenom"];
                // header("accueil/accueil.php");
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
            <script>
                let erreur = document.getElementById("erreur");
                erreur.innerHTML = "Veuillez tout remplir";
            </script>
    <?php
        }
    }
    ?>

    <!-- <script src="js/jquery-3.6.0.min.js"></script> -->
</body>

</html>