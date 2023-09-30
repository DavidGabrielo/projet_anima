<script>
    $(function() {
        $('.btn').on('click', function(e) {
            e.preventDefault()
            let formOrder = $("#formOrder")
            let prenom = $("#prenom").val()
            let motPasse = $("#motPasse").val()
            let confMotPasse = $("#confMotPasse").val()

            if (formOrder[0].checkValidity()) {
                if (prenom != "" && motPasse != "" && confMotPasse != "") {
                    if (motPasse == confMotPasse) {
                        $.ajax({
                            url: 'singin_process.php',
                            type: 'post',
                            data: formOrder.serialize(),
                            success: function(response) {
                                if (response == 1) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Création de compte réussie',
                                        showConfirmButton: false,
                                        timer: 1500
                                    }).then((result) => {
                                        window.open("../index.php", "_self");
                                    })
                                } else {
                                    Swal.fire({
                                        icon: 'warning',
                                        title: response,
                                        showConfirmButton: true,
                                        timer: 1500
                                    })
                                }
                            }
                        })
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Mot de passe incorrect',
                            showConfirmButton: true
                        })
                    }

                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Vous devez remplir le prénom, le nom, le mot de passe et la confirmation du mot de passe',
                        showConfirmButton: true
                    })
                }

            }
        })
    })
</script>