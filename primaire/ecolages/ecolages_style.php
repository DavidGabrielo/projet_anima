<style>
    #imagePreview,
    #imagePreviewUpdate {
        width: 256px;
        height: 320px;
        border-radius: 10px;
        margin-top: 10px;
    }

    .photoSlct {
        width: 256px;
        height: 320px;
    }

    .contPhotoUpdate {
        display: inline-block;
    }

    .lienClasse {
        display: inline-block;
        width: 250px;
        margin-bottom: 5px;
        padding: 5px 0;
        background-color: white;
        color: black;
        border-radius: 5px;
        box-shadow: 0 0 5px black;
    }

    .changement:first-child {
        background-color: rgb(28, 41, 56);
        color: white;
    }

    .propClick {
        background-color: rgb(28, 41, 56);
        color: white;
    }

    .contEtudiant:not(:first-child) {
        margin-top: 20px;
    }

    .infoEtudiant {
        border: 3px solid rgb(28, 41, 56);
        cursor: pointer;
    }

    .contEcolage {
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
    }

    .contMois {
        width: 150px;
        height: 100px;
        margin-bottom: 10px;
        border-radius: 5px;
        box-shadow: 0 0 5px black;
    }

    .mois {
        display: inline-block;
        border-bottom: 2px solid black;
        width: 100%;
        text-align: center;
    }

    .contPayement {
        height: 70px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .contPayement h5 {
        transform: rotate(-20deg);
    }

    .paye {
        color: blue;
    }

    .contNonPaye {
        display: flex;
        flex-direction: column;
        justify-content: space-around;
        align-items: center;
    }
</style>