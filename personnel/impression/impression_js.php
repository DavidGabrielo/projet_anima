<script>
    $(function() {
        // SELECTION DE l'id DE NIVEAU
        function slctIdFonction() {
            $.ajax({
                url: 'impression_process.php',
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
                url: 'impression_process.php',
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

        function getPersonnelAvecFonction() {
            let fonction = $(".optionFonction").val();

            $.ajax({
                url: 'impression_process.php',
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
                url: 'impression_process.php',
                type: 'post',
                data: {
                    slctFonction: 'slctFonction'
                },
                success: function(response) {
                    // alert(response)
                    $('#fonctionSlct').html(response);
                }
            })
        }
        slctFonction();

        // CHANGEMENT DE NIVEAU
        $(document).on("change", ".optionFonction", function() {
            // let idFonction = $(this).val()
            // alert(idFonction)
            getPersonnelAvecFonction();
        })
    })
</script>