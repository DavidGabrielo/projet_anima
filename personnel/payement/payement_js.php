<script>
    $(function() {
        function getPayement() {
            $.ajax({
                url: 'payement_process.php',
                type: 'post',
                data: {
                    slctPayement: "slctPayement"
                },
                success: function(response) {
                    $('#orderTable').html(response);
                }
            })
        }
        getPayement()

        $('body').on('click', '.payementBtn', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Confirmer le payement  de salaire du mois : ' + this.dataset.mois + '?',
                text: "Cette actin est irréversible",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, j\'en suis sûr'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'payement_process.php',
                        type: 'post',
                        data: {
                            idAnnee: this.dataset.id,
                            mois: this.dataset.mois
                        },
                        success: function(response) {
                            if (response == 1) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Payement avec succés',
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                                getPayement();
                            }
                        }
                    })

                }
            })
        })
    })
</script>