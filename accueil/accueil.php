<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        * {
            padding: 0;
            margin: 0;
            font-family: Arial;
        }

        html,
        body {
            width: 100%;
            height: 100%;
        }

        body {
            background-color: rgb(28, 41, 56);
        }

        #cont {
            color: white;
            height: 250px;
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            align-items: center;
        }

        #contLien {
            display: flex;
            justify-content: space-around;
            margin-top: 50px;
        }

        #contLien a {
            color: yellow;
            font-size: 30px;
        }
    </style>
</head>

<body>
    <div id="cont">
        <h1>Bienvenu cher utilisateur!</h1>
        <h3>Ce logiciel vous permet de gerer les informations importantes de votre établissement scolaire</h3>
        <h3>Vous pouvez choisir entre les deux liens ci-dessous</h3>
    </div>

    <div id="contLien">
        <a href="../primaire/niveau/niveau.php">NIVEAU PRIMAIRE</a>
        <a href="../secondaire/niveau/niveau.php">NIVEAU SECONDAIRE</a>
    </div>

</body>

</html>