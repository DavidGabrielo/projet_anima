<script>
    $(document).ready(function() {
        // AFFICHER L'IMAGE APRES LA SELECTION
        // Sélectionnez l'élément input de type file et l'élément img d'affichage
        const fileInput = document.getElementById('fileInput');
        const imagePreview = document.getElementById('imagePreview');
        $('#imagePreview').hide();

        // Écoutez l'événement "change" sur le champ de fichier
        fileInput.addEventListener('change', function() {
            $(".contPhotoUpdate").hide();
            $('#imagePreview').show();
            const selectedFile = fileInput.files[0]; // Récupérez le fichier sélectionné

            if (selectedFile) {
                const reader = new FileReader(); // Créez un objet FileReader

                // Définissez une fonction de rappel pour exécuter lorsque la lecture du fichier est terminée
                reader.onload = function(e) {
                    // Mettez à jour l'attribut src de l'élément img pour afficher l'image sélectionnée
                    imagePreview.src = e.target.result;
                };

                // Lisez le fichier en tant que URL de données (data URL)
                reader.readAsDataURL(selectedFile);
            } else {
                // Si aucun fichier n'est sélectionné, effacez l'élément img
                imagePreview.src = '';
            }
        });

        // Affichage de photo selectionnée
        const fileInputUpdate = document.getElementById('fileInputUpdate');
        const imagePreviewUpdate = document.getElementById('imagePreviewUpdate');
        $("#imagePreviewUpdate").hide();

        // Écoutez l'événement "change" sur le champ de fichier
        fileInputUpdate.addEventListener('change', function() {
            $(".contPhotoUpdate").hide()
            $("#imagePreviewUpdate").show();
            const selectedFile = fileInputUpdate.files[0]; // Récupérez le fichier sélectionné

            if (selectedFile) {
                const reader = new FileReader(); // Créez un objet FileReader

                // Définissez une fonction de rappel pour exécuter lorsque la lecture du fichier est terminée
                reader.onload = function(e) {
                    // Mettez à jour l'attribut src de l'élément img pour afficher l'image sélectionnée
                    imagePreviewUpdate.src = e.target.result;
                };

                // Lisez le fichier en tant que URL de données (data URL)
                reader.readAsDataURL(selectedFile);
            } else {
                // Si aucun fichier n'est sélectionné, effacez l'élément img
                imagePreviewUpdate.src = '';
            }
        });


        $('table').DataTable();

        // SELECTION DE l'id DE NIVEAU
        function slctIdNiveau() {
            $.ajax({
                url: 'inscription_process.php',
                type: 'post',
                data: {
                    slctIdNiveau: 'slctIdNiveau'
                },
                success: function(response) {
                    $(".idNiveau").val(response)
                }
            })
        }
        slctIdNiveau();

        function slctIdClasse() {
            let niveau = $(".optionNiveau").val()
            $.ajax({
                url: 'inscription_process.php',
                type: 'post',
                data: {
                    slctIdClasse: 'slctIdClasse',
                    niveau: niveau
                },
                success: function(response) {
                    $(".idClasse").val(response)
                }
            })
        }
        slctIdClasse();


        function getInscription() {
            let niveau = $(".optionNiveau").val();
            let classe = $(".idClasse").val();

            $.ajax({
                url: 'inscription_process.php',
                type: 'post',
                data: {
                    idNiveau: niveau,
                    idClasse: classe,
                    slctId: "oui"
                },
                success: function(response) {
                    $('#orderTable').html(response);
                    $('table').DataTable();
                }
            })
        }
        getInscription()

        // 
        function getInscriptionAvecNiveau() {
            let niveau = $(".optionNiveau").val();

            $.ajax({
                url: 'inscription_process.php',
                type: 'post',
                data: {
                    idNiveau: niveau,
                    slctIdClasseAvecNiveau: "oui"
                },
                success: function(response) {
                    $('#orderTable').html(response);
                    $('table').DataTable();
                }
            })
        }

        // SELECTION DE NIVEAU
        function slctNiveau() {
            $.ajax({
                url: 'inscription_process.php',
                type: 'post',
                data: {
                    slctNiveau: 'slctNiveau'
                },
                success: function(response) {
                    $('#niveauSlct').html(response);
                }
            })
        }
        slctNiveau();

        function slctClasse() {
            let niveau = $(".optionNiveau").val();
            $.ajax({
                url: 'inscription_process.php',
                type: 'post',
                data: {
                    slctClasse: 'slctClasse',
                    niveau: niveau
                },
                success: function(response) {
                    $('#contClasse').html(response);
                }
            })
        }
        slctClasse();

        // CHANGEMENT DE NIVEAU
        $(document).on("change", ".optionNiveau", function() {
            let idNiveau = $(this).val()
            $(".idNiveau").val(idNiveau)
            slctIdClasse();
            slctClasse();
            getInscriptionAvecNiveau();
        })

        // CHANGER DE classe
        $(document).on("click", ".lienClasse", function() {
            let id = $(this).data("id")
            $(".idClasse").val(id)
            $(".lienClasse").removeClass('propClick')
            $(".lienClasse").removeClass('changement')
            $(this).addClass('propClick')
            getInscription();
        })

        $("#formOrder").submit(function(e) {
            e.preventDefault()

            // let formOrder = $("#formOrder")
            let numero = $("#numero").val()
            let prenom = $("#prenom").val()
            let dtns = $("#dtns").val()
            let lieuns = $("#lieuns").val()
            let adresse = $("#adresse").val()
            if (numero != "" && prenom != "" && dtns != "" && lieuns != "" && adresse != "") {
                var formData = new FormData(this);
                $.ajax({
                    url: 'inscription_process_create.php',
                    type: 'post',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response == "aucun niveau") {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Veuillez inserer de NIVEAU avant d\'inscrire des étudiants ',
                                showConfirmButton: true
                            })
                        } else if (response == "aucune classe") {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Veuillez inserer de CLASSE avant d\'inscrire des étudiants ',
                                showConfirmButton: true
                            })
                        } else if (response == "aucune annee") {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Veuillez inserer de l\'année avant de parametrer de l\'inscription',
                                showConfirmButton: true
                            })
                        } else if (response == "echec") {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Ce numéro d\'inscription existe déjà dans cette classe',
                                showConfirmButton: true
                            })
                        } else if (response == "oui" || response == "chemin") {
                            $("#createModal").modal('hide');
                            getInscription()
                            $('#imagePreview').hide();
                            Swal.fire({
                                icon: 'success',
                                title: 'Enregistrement réussi',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            $("#numero").val("");
                            $("#prenom").val("");
                            $("#nom").val("");
                            $("#dtns").val("");
                            $("#lieuns").val("");
                            $("#adresse").val("");
                            $("#pere").val("");
                            $("#professionPere").val("");
                            $("#contactPere").val("");
                            $("#mere").val("");
                            $("#professionMere").val("");
                            $("#contactMere").val("");
                            $("#repondant").val("");
                            $("#professionRepondant").val("");
                            $("#contactRepondant").val("");
                            $("#fileInput").val("");
                        } else {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Le nombre d\'élèves maximum pour cette classe est : ' + response,
                                showConfirmButton: true
                            })
                        }
                    }
                })
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Ces champs doivent être remplis : Numéro, prenom, date de naissance, lieu de naissance, adresse',
                    showConfirmButton: true
                })
            }
        })

        // INFORMATION EN DETAIL SUR LES ETUDIANTS
        $('body').on("click", ".infoBtn", function(e) {
            e.preventDefault();
            $.ajax({
                url: "inscription_process.php",
                type: "post",
                data: {
                    informationId: this.dataset.id
                },
                success: function(response) {
                    let informations = JSON.parse(response)

                    $("#numeroSlct").text(informations.numero)
                    $("#prenomSlct").text(informations.prenom)
                    $("#nomSlct").text(informations.nom)
                    $("#dtnsSlct").text(informations.dtns)
                    $("#lieunsSlct").text(informations.lieuns)
                    $("#adresseSlct").text(informations.adresse)

                    let photo = informations.photo;
                    if (photo != "") {
                        $(".contPhoto").html("<img src='photos/" + photo + "' class='photoSlct' alt='photo de létudiant'/>")
                    } else {
                        $(".contPhoto").html("<img src='photos/etudiant.png' class='photoSlct' alt='photo de létudiant'/>")
                    }

                    $("#pereSlct").text(informations.pere)
                    $("#professionPereSlct").text(informations.profession_pere)
                    $("#contactPereSlct").text(informations.contact_pere)
                    $("#mereSlct").text(informations.mere)
                    $("#professionMereSlct").text(informations.profession_mere)
                    $("#contactMereSlct").text(informations.contact_mere)
                    $("#repondantSlct").text(informations.repondant)
                    $("#professionRepondantSlct").text(informations.profession_repondant)
                    $("#contactRepondantSlct").text(informations.contact_repondant)
                }
            })
        })

        $('body').on("click", ".editBtn", function(e) {
            $("#imagePreviewUpdate").hide();
            e.preventDefault();
            $(".contPhotoUpdate").show()
            $("#fileInputUpdate").val("")
            const imagePreviewUpdate = document.getElementById('imagePreviewUpdate');
            imagePreviewUpdate.src = '';
            $.ajax({
                url: "inscription_process.php",
                type: "post",
                data: {
                    informationId: this.dataset.id
                },
                success: function(response) {
                    let informations = JSON.parse(response)

                    $("#id").val(informations.id)
                    $("#numeroUpdate").val(informations.numero)
                    $("#prenomUpdate").val(informations.prenom)
                    $("#nomUpdate").val(informations.nom)
                    $("#dtnsUpdate").val(informations.dtns)
                    $("#lieunsUpdate").val(informations.lieuns)
                    $("#adresseUpdate").val(informations.adresse)

                    let photo = informations.photo;
                    if (photo != "") {
                        $(".contPhotoUpdate").html("<img src='photos/" + photo + "' class='photoSlct' alt='photo de létudiant'/>")
                    } else {
                        $(".contPhotoUpdate").html("<img src='photos/etudiant.png' class='photoSlct' alt='photo de létudiant'/>")
                    }

                    $("#pereUpdate").val(informations.pere)
                    $("#professionPereUpdate").val(informations.profession_pere)
                    $("#contactPereUpdate").val(informations.contact_pere)
                    $("#mereUpdate").val(informations.mere)
                    $("#professionMereUpdate").val(informations.profession_mere)
                    $("#contactMereUpdate").val(informations.contact_mere)
                    $("#repondantUpdate").val(informations.repondant)
                    $("#professionRepondantUpdate").val(informations.profession_repondant)
                    $("#contactRepondantUpdate").val(informations.contact_repondant)
                }
            })
        })

        $("#formOrderUpdate").submit(function(e) {
            e.preventDefault()

            // let formOrder = $("#formOrder")
            let numero = $("#numeroUpdate").val()
            let prenom = $("#prenomUpdate").val()
            let dtns = $("#dtnsUpdate").val()
            let lieuns = $("#lieunsUpdate").val()
            let adresse = $("#adresseUpdate").val()
            if (numero != "" && prenom != "" && dtns != "" && lieuns != "" && adresse != "") {
                var formData = new FormData(this);
                $.ajax({
                    url: 'inscription_process_update.php',
                    type: 'post',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        // alert(response)
                        if (response == "echec") {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Ce numéro d\'inscription existe déjà dans cette classe',
                                showConfirmButton: true
                            })
                        } else {
                            $("#updateModal").modal('hide');
                            getInscription()
                            Swal.fire({
                                icon: 'success',
                                title: 'Modification réussie',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            $("#numeroUpdate").val("");
                            $("#prenomUpdate").val("");
                            $("#nomUpdate").val("");
                            $("#dtnsUpdate").val("");
                            $("#lieunsUpdate").val("");
                            $("#adresseUpdate").val("");
                            $("#pereUpdate").val("");
                            $("#professionPereUpdate").val("");
                            $("#contactPereUpdate").val("");
                            $("#mereUpdate").val("");
                            $("#professionMereUpdate").val("");
                            $("#contactMereUpdate").val("");
                            $("#repondantUpdate").val("");
                            $("#professionRepondantUpdate").val("");
                            $("#contactRepondantUpdate").val("");
                            $("#fileInputUpdate").val("");
                        }
                    }
                })
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Ces champs doivent être remplis : Numéro, prenom, date de naissance, lieu de naissance, adresse',
                    showConfirmButton: true
                })
            }
        })

        $('body').on('click', '.deleteBtn', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Vous allez retirer l\'étudiant : ' + this.dataset.prenom + '?',
                text: "Cette action est irréversible",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, j\'en suis sûr'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'inscription_process.php',
                        type: 'post',
                        data: {
                            deletionId: this.dataset.id
                        },
                        success: function(response) {
                            if (response == 1) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Suppréssion réussie',
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                                getInscription();
                            }
                        }
                    })

                }
            })
        })
    })
</script>
<!-- rmamitianaprisca@gmail.com -->