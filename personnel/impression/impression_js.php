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
            let mois = $(".optionMois").val();

            $.ajax({
                url: 'impression_process.php',
                type: 'post',
                data: {
                    mois: mois,
                    slctId: "oui"
                },
                success: function(response) {
                    $('#orderTable').html(response);
                }
            })
        }
        getPersonnel()

        // SELECTION DE NIVEAU
        function slctMois() {
            $.ajax({
                url: 'impression_process.php',
                type: 'post',
                data: {
                    slctMois: 'slctMois'
                },
                success: function(response) {
                    $('#moisSlct').html(response);
                }
            })
        }
        slctMois();

        // CHANGEMENT DE NIVEAU
        $(document).on("change", ".optionMois", function() {
            getPersonnel()
        })
    })
</script>