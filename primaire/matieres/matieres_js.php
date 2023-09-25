<script>
    $(document).ready(function() {
        $('table').DataTable();

        // SELECTION DE l'id DE NIVEAU
        function slctIdNiveau() {
            $.ajax({
                url: 'matieres_process.php',
                type: 'post',
                data: {
                    slctIdNiveau: 'slctIdNiveau'
                },
                success: function(response) {
                    $("#idNiveau").val(response)
                }
            })
        }
        slctIdNiveau();


        function getClasse() {
            let niveau = $(".optionNiveau").val();

            $.ajax({
                url: 'matieres_process.php',
                type: 'post',
                data: {
                    idNiveau: niveau,
                    slctId: "oui"
                },
                success: function(response) {
                    $('#orderTable').html(response);
                    $('table').DataTable();
                }
            })
        }

        getClasse()

        // SELECTION DE NIVEAU
        function slctNiveau() {
            $.ajax({
                url: 'matieres_process.php',
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

        // CHANGEMENT DE NIVEAU
        $(document).on("change", ".optionNiveau", function() {
            let idNiveau = $(this).val()
            $("#idNiveau").val(idNiveau)
            getClasse()
        })

        $('#create').on('click', function(e) {
            let formOrder = $("#formOrder")
            let matiere = $("#matiere").val()
            let coeff = $("#coeff").val()

            if (formOrder[0].checkValidity()) {
                if (matiere != "" && coeff != "") {
                    $.ajax({
                        url: 'matieres_process.php',
                        type: 'post',
                        data: formOrder.serialize() + '&action=create',
                        success: function(response) {
                            if (response == "aucun") {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Veuillez inserer de NIVEAU avant d\'insérer de MATIERE',
                                    showConfirmButton: true
                                })
                            } else if (response == "echec") {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Cette matiere existe déjà',
                                    showConfirmButton: true
                                })
                            } else {
                                $("#createModal").modal('hide');
                                getClasse()
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Enregistrement réussi',
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                                $("#matiere").val("")
                                $("#coeff").val("")
                            }
                        }
                    })
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Les deux champs sont obligatoires',
                        showConfirmButton: true
                    })
                }

            }
        })

        $('body').on('click', '.editBtn', function(e) {
            e.preventDefault();

            $.ajax({
                url: 'matieres_process.php',
                type: 'post',
                data: {
                    workingId: this.dataset.id
                },
                success: function(response) {
                    let billInfo = JSON.parse(response)
                    $("#idUpdate").val(billInfo.id)
                    $('#matiereUpdate').val(billInfo.matieres);
                    $('#coeffUpdate').val(billInfo.coeff);
                }
            })
        })

        // MODIFIER la facture
        $('#update').on('click', function(e) {
            let formOrderUpdate = $("#formUpdateOrder")

            if (formOrderUpdate[0].checkValidity()) {
                e.preventDefault();
                $.ajax({
                    url: 'matieres_process.php',
                    type: 'post',
                    data: formOrderUpdate.serialize() + '&action=update',
                    success: function(response) {
                        if (response == "echec") {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Cette matiere existe déjà',
                                showConfirmButton: true
                            })
                        } else {
                            $("#updateModal").modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Modification réussie',
                                showConfirmButton: false,
                                timer: 1500
                            })
                            formOrderUpdate[0].reset();
                            getClasse()
                        }
                    }
                })
            }
        })

        $('body').on('click', '.deleteBtn', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Vous allez supprimer la matière : ' + this.dataset.matiere + '?',
                text: "Cette action est irréversible",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, j\'en suis sûr'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'matieres_process.php',
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
                                getClasse();
                            }
                        }
                    })

                }
            })
        })
    })
</script>