<script>
    $(function() {
        $('table').DataTable();

        $('#create').on('click', function(e) {
            let formOrder = $("#formOrder")
            let fonction = $("#fonction").val()
            let prix = $("#prix").val()

            if (formOrder[0].checkValidity()) {
                if (fonction != "" && prix != "") {
                    $.ajax({
                        url: 'fonction_process.php',
                        type: 'post',
                        data: formOrder.serialize() + '&action=create',
                        success: function(response) {
                            if (response == "echec") {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Cette fonction existe déjà',
                                    showConfirmButton: true
                                })
                            } else {
                                $("#createModal").modal('hide');
                                getBills()
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Enregistrement réussi',
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                                formOrder[0].reset();
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

        getBills()

        function getBills() {
            $.ajax({
                url: 'fonction_process.php',
                type: 'post',
                data: {
                    action: 'fetch'
                },
                success: function(response) {
                    $('#orderTable').html(response);
                    $('table').DataTable();
                    // $('table').DataTable({
                    //     order: [0, 'desc']   //C'est pour ordonner le premier champs par ordre décroissant
                    // });
                }
            })
        }

        $('body').on('click', '.editBtn', function(e) {
            e.preventDefault();

            $.ajax({
                url: 'fonction_process.php',
                type: 'post',
                data: {
                    workingId: this.dataset.id
                },
                success: function(response) {
                    let billInfo = JSON.parse(response)
                    $("#idUpdate").val(billInfo.id)
                    $('#fonctionUpdate').val(billInfo.fonction);
                    $('#prixUpdate').val(billInfo.prix);
                }
            })
        })

        // MODIFIER la facture
        $('#update').on('click', function(e) {
            let formOrderUpdate = $("#formUpdateOrder")

            if (formOrderUpdate[0].checkValidity()) {
                e.preventDefault();
                $.ajax({
                    url: 'fonction_process.php',
                    type: 'post',
                    data: formOrderUpdate.serialize() + '&action=update',
                    success: function(response) {
                        if (response == "echec") {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Cette classe existe déjà',
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
                            getBills()
                        }
                    }
                })
            }
        })

        $('body').on('click', '.deleteBtn', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Vous allez supprimer le fonction : ' + this.dataset.prix + '?',
                text: "Cette action est irréversible",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, j\'en suis sûr'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'fonction_process.php',
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
                                getBills();
                            }
                        }
                    })

                }
            })
        })
    })
</script>