    <script src="<?= PROJECT ?>public/jquery/jquery.js"></script>
    <script src="<?= PROJECT ?>public/js/tabler.js?202302251230" defer></script>
    <script src="<?= PROJECT ?>public/js/demo.js?202302251230" defer></script>
    <script src='<?= PROJECT ?>public/vendor/jquery/jquery-3.2.1.min.js'></script>
    <script src='<?= PROJECT ?>public/vendor/bootstrap/js/popper.js'></script>
    <script src='<?= PROJECT ?>public/vendor/bootstrap/js/bootstrap.min.js'></script>
    <script src='<?= PROJECT ?>public/vendor/select2/select2.min.js'></script>
    <script src='<?= PROJECT ?>public/vendor/tilt/tilt.jquery.min.js'></script>
    <script src='<?= PROJECT ?>public/js/main.js'></script>
    <script src='<?= PROJECT ?>public/sweetalert2/sweetalert2.min.js'></script>
    <script src="./dist/js/tabler.min.js?1674944402" defer></script>
    <script src="./dist/js/demo.min.js?1674944402" defer></script>

    <script>
        $(function() {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 20000
            });

            if ($('.swalDefaultSuccess').length) {
                Toast.fire({
                    icon: 'success',
                    title: 'Succès',
                    text: '<?= $msg ?>'
                });
            }

            if ($('.swalDefaultError').length) {
                Toast.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: '<?= $msg ?>'
                });
            }
        });
    </script>

    <script>
        $('.js-tilt').tilt({
            scale: 1.1
        })
    </script>

    <script>
        function activeButton() {
            var boxChecked = document.getElementById("myBox");
            var button = document.getElementById("submitButton");

            if (boxChecked.checked) {
                button.disabled = false; // Activer le bouton
            } else {
                button.disabled = true; // Désactiver le bouton
            }
        }
    </script>