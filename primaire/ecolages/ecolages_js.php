<script>
    $(document).ready(function() {
        // SELECTION DE l'id DE NIVEAU
        function slctIdNiveau() {
            $.ajax({
                url: 'ecolages_process.php',
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
                url: 'ecolages_process.php',
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
                url: 'ecolages_process.php',
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
                url: 'ecolages_process.php',
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
                url: 'ecolages_process.php',
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
                url: 'ecolages_process.php',
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

        $('body').on('click', '.payementBtn', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Confirmer le payement  d\'écolage du mois : ' + this.dataset.mois + '?',
                text: "Cette actin est irréversible",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, j\'en suis sûr'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'ecolages_process.php',
                        type: 'post',
                        data: {
                            idEtudiant: this.dataset.id,
                            mois: this.dataset.mois
                        },
                        success: function(response) {
                            if (response == 1) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Payé avec succés',
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

        let contEcolage = document.querySelector(".contEcolage")
        // contEcolage.slideUp(0);
        $(document).on("click", ".infoEtudiant ", function() {
            $(this).next().slideToggle();
        })
    })
</script>
<!-- rmamitianaprisca@gmail.com -->