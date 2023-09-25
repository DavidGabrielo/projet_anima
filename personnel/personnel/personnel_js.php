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

        // AFFICHAGE DES FONCTION 
        $(".nouveau").click(function() {
            $.ajax({
                url: 'personnel_process.php',
                type: 'post',
                data: {
                    slctFonction: 'slctFonction'
                },
                success: function(response) {
                    $("#fonction").html(response)
                }
            })
        })

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
        function slctIdFonction() {
            $.ajax({
                url: 'personnel_process.php',
                type: 'post',
                data: {
                    slctIdFonction: 'slctIdFonction'
                },
                success: function(response) {
                    $(".idFonction").val(response)
                }
            })
        }
        slctIdFonction();

        function getPersonnel() {
            let fonction = $(".optionFonction").val();

            $.ajax({
                url: 'personnel_process.php',
                type: 'post',
                data: {
                    idFonction: fonction,
                    slctId: "oui"
                },
                success: function(response) {
                    $('#orderTable').html(response);
                    $('table').DataTable();
                }
            })
        }
        getPersonnel()

        // 
        function getPersonnelAvecFonction() {
            let fonction = $(".optionFonction").val();

            $.ajax({
                url: 'personnel_process.php',
                type: 'post',
                data: {
                    idFonction: fonction,
                    slctIdClasseAvecFonction: "oui"
                },
                success: function(response) {
                    $('#orderTable').html(response);
                    $('table').DataTable();
                }
            })
        }

        // SELECTION DE NIVEAU
        function slctFonction() {
            $.ajax({
                url: 'personnel_process.php',
                type: 'post',
                data: {
                    slctFonction: 'slctFonction'
                },
                success: function(response) {
                    $('#fonctionSlct').html(response);
                }
            })
        }
        slctFonction();

        // CHANGEMENT DE NIVEAU
        $(document).on("change", ".optionFonction", function() {
            let idFonction = $(this).val()
            $(".idFonction").val(idFonction)
            getPersonnelAvecFonction();
        })

        $("#formOrder").submit(function(e) {
            e.preventDefault()

            // let formOrder = $("#formOrder")
            let code = $("#code").val()
            let prenom = $("#prenom").val()
            let dtns = $("#dtns").val()
            let lieuns = $("#lieuns").val()
            let adresse = $("#adresse").val()
            let contact = $("#contact").val()
            if (code != "" && prenom != "" && dtns != "" && lieuns != "" && adresse != "" && contact != "") {
                var formData = new FormData(this);
                $.ajax({
                    url: 'personnel_process_create.php',
                    type: 'post',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response == "echec") {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Ce numéro de code existe déjà',
                                showConfirmButton: true
                            })
                        } else {
                            $("#createModal").modal('hide');
                            getPersonnel()
                            $('#imagePreview').hide();
                            Swal.fire({
                                icon: 'success',
                                title: 'Enregistrement réussi',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            $("#code").val("");
                            $("#prenom").val("");
                            $("#nom").val("");
                            $("#dtns").val("");
                            $("#lieuns").val("");
                            $("#adresse").val("");
                            $("#contact").val("");
                            $("#fileInput").val("");
                        }
                    }
                })
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Ces champs doivent être remplis : Code, prenom, date de naissance, lieu de naissance, adresse, contact',
                    showConfirmButton: true
                })
            }
        })

        // INFORMATION EN DETAIL SUR LES ETUDIANTS
        $('body').on("click", ".infoBtn", function(e) {
            e.preventDefault();
            $.ajax({
                url: "personnel_process.php",
                type: "post",
                data: {
                    informationId: this.dataset.id
                },
                success: function(response) {
                    let informations = JSON.parse(response)

                    $("#codeSlct").text(informations.code)
                    $("#prenomSlct").text(informations.prenom)
                    $("#nomSlct").text(informations.nom)
                    $("#dtnsSlct").text(informations.dtns)
                    $("#lieunsSlct").text(informations.lieuns)
                    $("#adresseSlct").text(informations.adresse)
                    $("#contactSlct").text(informations.contact)

                    let photo = informations.photo;
                    if (photo != "") {
                        $(".contPhoto").html("<img src='photos/" + photo + "' class='photoSlct' alt='photo de létudiant'/>")
                    } else {
                        $(".contPhoto").html("<img src='photos/etudiant.png' class='photoSlct' alt='photo de létudiant'/>")
                    }
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
                url: "personnel_process.php",
                type: "post",
                data: {
                    informationId: this.dataset.id
                },
                success: function(response) {
                    let informations = JSON.parse(response)

                    $("#id").val(informations.id)
                    $("#codeUpdate").val(informations.code)
                    $("#prenomUpdate").val(informations.prenom)
                    $("#nomUpdate").val(informations.nom)
                    $("#dtnsUpdate").val(informations.dtns)
                    $("#lieunsUpdate").val(informations.lieuns)
                    $("#adresseUpdate").val(informations.adresse)
                    $("#contactUpdate").val(informations.contact)

                    let photo = informations.photo;
                    if (photo != "") {
                        $(".contPhotoUpdate").html("<img src='photos/" + photo + "' class='photoSlct' alt='photo de létudiant'/>")
                    } else {
                        $(".contPhotoUpdate").html("<img src='photos/etudiant.png' class='photoSlct' alt='photo de létudiant'/>")
                    }
                }
            })
        })

        $("#formOrderUpdate").submit(function(e) {
            e.preventDefault()

            // let formOrder = $("#formOrder")
            let code = $("#codeUpdate").val()
            let prenom = $("#prenomUpdate").val()
            let dtns = $("#dtnsUpdate").val()
            let lieuns = $("#lieunsUpdate").val()
            let adresse = $("#adresseUpdate").val()
            let contact = $("#contactUpdate").val()
            if (code != "" && prenom != "" && dtns != "" && lieuns != "" && adresse != "" && contact != "") {
                var formData = new FormData(this);
                $.ajax({
                    url: 'personnel_process_update.php',
                    type: 'post',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response == "echec") {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Ce code de personnel existe déjà',
                                showConfirmButton: true
                            })
                        } else {
                            $("#updateModal").modal('hide');
                            getPersonnel()
                            Swal.fire({
                                icon: 'success',
                                title: 'Modification réussie',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            $("#codeUpdate").val("");
                            $("#prenomUpdate").val("");
                            $("#nomUpdate").val("");
                            $("#dtnsUpdate").val("");
                            $("#lieunsUpdate").val("");
                            $("#adresseUpdate").val("");
                            $("#contactUpdate").val("");
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
                        url: 'personnel_process.php',
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
                                getPersonnel();
                            }
                        }
                    })

                }
            })
        })
    })
</script>
<!-- rmamitianaprisca@gmail.com -->