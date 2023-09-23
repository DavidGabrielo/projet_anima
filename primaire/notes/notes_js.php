<script>
    $(document).ready(function() {
        // SELECTION DE l'id DE NIVEAU
        function slctIdNiveau() {
            $.ajax({
                url: 'notes_process.php',
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
                url: 'notes_process.php',
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
                url: 'notes_process.php',
                type: 'post',
                data: {
                    idNiveau: niveau,
                    idClasse: classe,
                    slctId: "oui"
                },
                success: function(response) {
                    $('#orderTable').html(response);
                }
            })
        }
        getInscription()

        // 
        function getInscriptionAvecNiveau() {
            let niveau = $(".optionNiveau").val();

            $.ajax({
                url: 'notes_process.php',
                type: 'post',
                data: {
                    idNiveau: niveau,
                    slctIdClasseAvecNiveau: "oui"
                },
                success: function(response) {
                    $('#orderTable').html(response);
                }
            })
        }

        // SELECTION DE NIVEAU
        function slctNiveau() {
            $.ajax({
                url: 'notes_process.php',
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
                url: 'notes_process.php',
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

        $('body').on('click', '.btnNote', function(e) {
            e.preventDefault();
            let idetudiant = this.dataset.idetudiant;
            let idmatiere = this.dataset.idmatiere;
            let type = this.dataset.type;
            let niveau = this.dataset.niveau;
            let classe = this.dataset.classe;
            let annee = this.dataset.annee;

            $.ajax({
                url: 'notes_process.php',
                type: 'post',
                data: {
                    idetudiant: this.dataset.idetudiant,
                    idmatiere: this.dataset.idmatiere,
                    type: this.dataset.type,
                    niveau: this.dataset.niveau,
                    classe: this.dataset.classe,
                    annee: this.dataset.annee
                },
                success: function(response) {
                    $('#note').val(response);
                    $(".idetudiant").val(idetudiant);
                    $(".idmatiere").val(idmatiere);
                    $(".type").val(type);
                    $(".niveau").val(niveau);
                    $(".classe").val(classe);
                    $(".annee").val(annee);
                }
            })
        })

        $("#appliquer").click(function(e) {
            e.preventDefault()
            let note = $("#note").val()
            if (note != "") {
                if (note >= 0) {
                    $.ajax({
                        url: 'notes_process.php',
                        type: 'post',
                        data: {
                            idetudiant: $(".idetudiant").val(),
                            idmatiere: $(".idmatiere").val(),
                            type: $(".type").val(),
                            niveau: $(".niveau").val(),
                            classe: $(".classe").val(),
                            annee: $(".annee").val(),
                            note: note
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Insertion de note réussie',
                                showConfirmButton: false,
                                timer: 1500
                            })
                            $("#createModal").modal('hide');
                            getInscription()
                            getInscriptionAvecNiveau()
                        }
                    })
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Vous ne pouvez pas inserer de valeur négative',
                        showConfirmButton: true
                    })
                }
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Veuillez remplir la note',
                    showConfirmButton: true
                })
            }
        })

        let contEcolage = document.querySelector(".contEcolage")
        // contEcolage.slideUp(0);
        $(document).on("click", ".infoEtudiant ", function() {
            $(this).next().slideToggle();
        })
    })
</script>
<!-- rmamitianaprisca@gmail.com -->