<script>
    $(function() {
        $(".anneeScolaire").click(function() {
            $.ajax({
                url: '../header/header_process.php',
                type: 'post',
                data: {
                    slctAnnee: "slctAnnee"
                },
                success: function(response) {
                    let anneeInfo = JSON.parse(response)
                    if (anneeInfo != false) {
                        $("#debutAnnee").val(anneeInfo.debut_annee);
                        $("#finAnnee").val(anneeInfo.fin_annee);
                    } else {
                        $("#debutAnnee").val("20");
                        $("#finAnnee").val("20");
                    }

                }
            })
        })

        // ENREGISTREMENT D'UN NOUVELLE ANNEE
        $('.nouvelleAnnee').on('click', function(e) {
            let formOrder = $("#formAnnee")
            let debutMois = $("#debutMois").val()
            let debutAnnee = $("#debutAnnee").val()
            let nbMois = $("#nbMois").val()
            let finAnnee = $("#finAnnee").val()

            if (formOrder[0].checkValidity()) {
                if (debutAnnee != "" && finAnnee != "" && nbMois != "") {
                    let reste = finAnnee - debutAnnee;
                    if (reste == 1) {
                        $.ajax({
                            url: '../header/header_process.php',
                            type: 'post',
                            data: formOrder.serialize() + '&action=nouvelleAnnee',
                            success: function(response) {
                                if (response == "") {
                                    $("#anneeModal").modal('hide');
                                    getAnnee()
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Enregistrement réussi',
                                        showConfirmButton: false,
                                        timer: 1500
                                    })
                                    formOrder[0].reset();
                                } else {
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Cette année est déjà utilisée',
                                        showConfirmButton: true
                                    });
                                }
                            }
                        })
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Seulement une année (1) de différence est acceptée',
                            showConfirmButton: true
                        });
                    }

                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Tous les champs doivent être remplis',
                        showConfirmButton: true
                    });
                }

            }
        })

        function getAnnee() {
            $.ajax({
                url: '../header/header_process.php',
                type: 'post',
                data: {
                    action: 'fetchAnnee'
                },
                success: function(response) {
                    $('.anneeScolaire').html(response);
                }
            })
        }

        getAnnee()

        function getDebutMois() {
            $.ajax({
                url: '../header/header_process.php',
                type: 'post',
                data: {
                    action: 'DebutMois'
                },
                success: function(response) {
                    $('#debutMois').html(response);
                }
            })
        }

        getDebutMois()

        function getNbMois() {
            $.ajax({
                url: '../header/header_process.php',
                type: 'post',
                data: {
                    action: 'finMois'
                },
                success: function(response) {
                    $('#nbMois').val(response);
                }
            })
        }

        getNbMois()

        // Mettre à jour l'année
        $("#updateAnnee").on("click", function() {
            let formOrder = $("#formAnnee")
            let debutAnnee = $("#debutAnnee").val()
            let finAnnee = $("#finAnnee").val()
            let nbMois = $("#nbMois").val()

            if (formOrder[0].checkValidity()) {
                if (debutAnnee != "" && finAnnee != "" && nbMois != "") {
                    let reste = finAnnee - debutAnnee;

                    if (reste == 1) {
                        $.ajax({
                            url: '../header/header_process.php',
                            type: 'post',
                            data: formOrder.serialize() + '&action=miseAjour',
                            success: function(response) {
                                if (response == "perfect") {
                                    $("#anneeModal").modal('hide');
                                    getAnnee()
                                    getDebutMois()
                                    getNbMois()
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Modification réussie',
                                        showConfirmButton: false,
                                        timer: 1500
                                    })
                                } else {
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Cette année est déjà utilisée',
                                        showConfirmButton: true
                                    });
                                }
                            }
                        })
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Seulement une année (1) de différence est acceptée',
                            showConfirmButton: true
                        });
                    }

                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Ces deux champs sont obligatoires',
                        showConfirmButton: true
                    });
                }

            }
        })
    })
</script>