<script>
    $(document).ready(function() {
        // SELECTION DE l'id DE NIVEAU
        function slctIdNiveau() {
            $.ajax({
                url: 'bulletin_process.php',
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
                url: 'bulletin_process.php',
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
                url: 'bulletin_process.php',
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
                url: 'bulletin_process.php',
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
                url: 'bulletin_process.php',
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
                url: 'bulletin_process.php',
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

        let contEcolage = document.querySelector(".contEcolage")
        // contEcolage.slideUp(0);
        $(document).on("click", ".infoEtudiant ", function() {
            $(this).next().slideToggle();
        })
    })

    function telecharger() {
        var element = document.getElementById("orderTable");
        html2pdf(element, {
            margin: 10,
            fileName: "myfile.pdf",
            //                    image: {type: 'jpeg', quality: 0.98},
            html2canvas: {
                scale: 2,
                logging: true,
                dpi: 192,
                letterRendering: true
            },
            jsPDF: {
                unit: 'mm',
                format: 'a4',
                orientation: 'landscape'
            }
        });
    }
</script>
<!-- rmamitianaprisca@gmail.com -->