</div>
<footer class="footer footer-transparent d-print-none">
    <div class="container-xl">
        <div class="row text-center align-items-center flex-row-reverse">
            <div class="col-lg-auto ms-lg-auto">
                <ul class="list-inline list-inline-dots mb-0">
                    <li class="list-inline-item"><a href="./docs/" class="link-secondary">Termes et Services</a></li>
                    <li class="list-inline-item"><a href="./license.html" class="link-secondary">Politique de Confidentialité</a></li>
                </ul>
            </div>
            <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                <ul class="list-inline list-inline-dots mb-0">
                    <li class="list-inline-item">
                        Copyright &copy;
                        <script>
                            document.write(new Date().getFullYear())
                        </script>
                        <a href="#" class="link-secondary">Africa Express Cargo</a>.
                        Tous droits réservés. By <a href="#" class="link-secondary">logic;</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>
</div>

<!--THIS MODAL NOT WORKING YET-->

<?php
if (isset($packages_ingrouplistings) && !empty($packages_ingrouplistings)) {

    foreach ($packages_ingrouplistings as $key => $packages_ingroup) {

?>
        <div class="modal modal-blur fade" data-bs-backdrop='static' id="<?= "modal-packages-ingroup-detail" . $key ?>" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Détails Colis</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="datagrid">
                            <div class="datagrid-item">
                                <div class="datagrid-title">Description</div>
                                <div class="datagrid-content">
                                    <?= $packages_ingrouplistings[$key]["description"] ?>
                                </div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">Type d'Envoi</div>
                                <div class="datagrid-content">
                                    <?= !empty($packages_ingrouplistings[$key]["shipping_type"]) ? $packages_ingrouplistings[$key]["shipping_type"] : '-' ?>
                                </div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">Poids Net (KG)</div>
                                <div class="datagrid-content">
                                    <?= !empty($packages_ingrouplistings[$key]["net_weight"]) ? $packages_ingrouplistings[$key]["net_weight"] : '-' ?>
                                </div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">Poids Volumétrique (CBM)</div>
                                <div class="datagrid-content">
                                    <?= !empty($packages_ingrouplistings[$key]["metric_weight"]) ? $packages_ingrouplistings[$key]["metric_weight"] : '-' ?>
                                </div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">Valeur (FCFA)</div>
                                <div class="datagrid-content">
                                    <?= !empty($packages_ingrouplistings[$key]["worth"]) ? $packages_ingrouplistings[$key]["worth"] : '-' ?>
                                </div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">Nombre</div>
                                <div class="datagrid-content">
                                    <?= !empty($packages_ingrouplistings[$key]["package_units_number"]) ? $packages_ingrouplistings[$key]["package_units_number"] : '-' ?>
                                </div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">Coût Unitaire D'Expédition (CUE)</div>
                                <div class="datagrid-content">
                                    <?= !empty($packages_ingrouplistings[$key]["shipping_unit_cost"]) ? $packages_ingrouplistings[$key]["shipping_unit_cost"] . ' / pcs' : '-' ?>
                                </div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">Coût Expédition (CUE*Nombre)</div>
                                <div class="datagrid-content">
                                    <?= !empty($packages_ingrouplistings[$key]["shipping_cost"]) ? $packages_ingrouplistings[$key]["shipping_cost"] : '-' ?>
                                </div>
                            </div>
                        </div><br>
                        <div class="row row-cols g-3">
                            <?php
                            if (checkPackageIdInPackagesImagesTab($packages_ingrouplistings[$key]["id"])) {
                                $select_images = getPackageImages($packages_ingrouplistings[$key]["id"]);
                                if (!empty($select_images)) {
                                    foreach ($select_images as $_key => $value) {
                            ?>
                                        <div class="col">
                                            <a data-fslightbox="gallery" href='<?= $select_images[$_key]['images'] ?>'>
                                                <!-- Photo -->
                                                <div class="img-responsive img-responsive-1x1 rounded border" style="background-image: url(<?= $select_images[$_key]['images'] ?>)"></div>
                                            </a>
                                        </div>
                            <?php
                                    }
                                }
                            }
                            ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
<?php
    }
}
?>

<!--THIS MODAL NOT WORKING YET-->

<script src="<?= PROJECT ?>public/jquery/jquery.js"></script>
<script src="<?= PROJECT ?>public/select2/js/select2.full.js"></script>
<script src="<?= PROJECT ?>public/libs/tinymce/tinymce.js?1674944402" defer></script>
<script src="<?= PROJECT ?>public/libs/dropzone/dist/dropzone-min.js?202302251230" defer></script>
<script src="<?= PROJECT ?>public/libs/fslightbox/index.js?1674944402" defer></script>
<!-- Core -->
<script src="<?= PROJECT ?>public/js/tabler.js?202302251230" defer></script>
<script src="<?= PROJECT ?>public/js/demo.js?202302251230" defer></script>
<script src='<?= PROJECT ?>public/sweetalert2/sweetalert2.min.js'></script>


<!--toast-->

<script>
    $(function() {
        var Toast = Swal.mixin({
            toast: true,
            position: 'top',
            showConfirmButton: false,
            timer: 20000
        });

        if ($('.swalDefaultSuccess').length) {
            Toast.fire({
                icon: 'success',
                title: '<?= $msg ?>'
            });
        }

        if ($('.swalDefaultError').length) {
            Toast.fire({
                icon: 'error',
                title: '<?= $msg ?>'
            });
        }
    });
</script>

<!--loader-->

<script>
    window.onload = function() {
        document.getElementById("loader-wrapper").style.display = "none";
    }
</script>

<!--password toggle-->

<script>
    // Récupération des éléments HTML
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.querySelector('.password-toggle i');
    const repasswordInput = document.getElementById('repassword');
    const eyeSlashIcon = document.querySelector('.repassword-toggle i');

    // Écouteur d'événement sur le champ de mot de passe
    passwordInput.addEventListener('input', function() {
        // Vérification si le champ est vide
        if (passwordInput.value === '') {
            eyeIcon.style.display = 'none'; // masquage de l'icône de l'œil barré
        } else {
            eyeIcon.style.display = 'inline-block'; // affichage de l'icône de l'œil barré
        }
    });

    repasswordInput.addEventListener('input', function() {
        // Vérification si le champ est vide
        if (repasswordInput.value === '') {
            eyeSlashIcon.style.display = 'none'; // masquage de l'icône de l'œil barré
        } else {
            eyeSlashIcon.style.display = 'inline-block'; // affichage de l'icône de l'œil barré
        }
    });

    // Écouteur d'événement sur l'icône de l'œil
    eyeIcon.addEventListener('click', function() {
        // Affichage ou masquage de la valeur du champ de mot de passe
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.remove('far', 'fa-eye-slash');
            eyeIcon.classList.add('fas', 'fa-eye');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('fas', 'fa-eye');
            eyeIcon.classList.add('far', 'fa-eye-slash');
        }
    });

    eyeSlashIcon.addEventListener('click', function() {
        // Affichage ou masquage de la valeur du champ de mot de passe
        if (repasswordInput.type === 'password') {
            repasswordInput.type = 'text';
            eyeSlashIcon.classList.remove('far', 'fa-eye-slash');
            eyeSlashIcon.classList.add('fas', 'fa-eye');
        } else {
            repasswordInput.type = 'password';
            eyeSlashIcon.classList.remove('fas', 'fa-eye');
            eyeSlashIcon.classList.add('far', 'fa-eye-slash');
        }
    });
</script>

<!--password fields events-->

<script>
    const clicktoChange = document.getElementById("clicktoChange");
    const updatePasswordBlock = document.getElementById("updatePasswordBlock");
    const clicktoUpdate = document.getElementById("clicktoUpdate");

    clicktoChange.addEventListener("click", function() {
        clicktoChange.style.display = "none";
        updatePasswordBlock.style.display = "flex";
        clicktoUpdate.style.display = "inline";
    });
</script>

<!--personal informations form-->

<script>
    const click = document.getElementById("click");
    const formAppear = document.getElementById("form_appear");
    const divNone = document.getElementById("div_none");
    const abort = document.getElementById("abort");

    click.addEventListener("click", function() {
        click.style.display = "none";
        formAppear.style.display = "flex";
        divNone.style.display = "none";
    });
    abort.addEventListener("click", function() {
        abort.style.display = "none";
        formAppear.style.display = "none";
        divNone.style.display = "flex";
    });
</script>

<!--add package in created group form-->

<script>
    const clickToAdd = document.getElementById("click_to_add");
    const blockAppear = document.getElementById("block_appear");
    const buttonNone = document.getElementById("click_to_add");
    const aborted = document.getElementById("aborted");

    clickToAdd.addEventListener("click", function() {
        clickToAdd.style.display = "none";
        blockAppear.style.display = "flex";
        buttonNone.style.display = "none";
    });
    aborted.addEventListener("click", function() {
        aborted.style.display = "none";
        blockAppear.style.display = "none";
        buttonNone.style.display = "flex";
    });
</script>

<!--tinymce-->

<script>
    // @formatter:off
    document.addEventListener("DOMContentLoaded", function() {
        let options = {
            selector: '#tinymce-mytextarea',
            height: 300,
            menubar: false,
            statusbar: false,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount'
            ],
            toolbar: 'undo redo | formatselect | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat',
            content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif; font-size: 14px; -webkit-font-smoothing: antialiased; }'
        }
        if (localStorage.getItem("tablerTheme") === 'dark') {
            options.skin = 'oxide-dark';
            options.content_css = 'dark';
        }
        tinyMCE.init(options);
    })
    // @formatter:on
</script>

<!--package group modal-->

<script>
    $('<?= "#modal-packages-ingroup-detail" . $key ?>').on('hidden.bs.modal', function() {
        $('#modal-packages-group-detail').modal('show');
    })
</script>

<!--select2-->

<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

        //Bootstrap Duallistbox
        $('.duallistbox').bootstrapDualListbox()

        //Colorpicker
        $('.my-colorpicker1').colorpicker()
        //color picker with addon
        $('.my-colorpicker2').colorpicker()

        $('.my-colorpicker2').on('colorpickerChange', function(event) {
            $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
        })

        $("input[data-bootstrap-switch]").each(function() {
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        })

    })
    // BS-Stepper Init
    document.addEventListener('DOMContentLoaded', function() {
        window.stepper = new Stepper(document.querySelector('.bs-stepper'))
    })

    // DropzoneJS Demo Code Start
    Dropzone.autoDiscover = false

    // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
    var previewNode = document.querySelector("#template")
    previewNode.id = ""
    var previewTemplate = previewNode.parentNode.innerHTML
    previewNode.parentNode.removeChild(previewNode)

    var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
        url: "/target-url", // Set the url
        thumbnailWidth: 80,
        thumbnailHeight: 80,
        parallelUploads: 20,
        previewTemplate: previewTemplate,
        autoQueue: false, // Make sure the files aren't queued until manually added
        previewsContainer: "#previews", // Define the container to display the previews
        clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
    })

    myDropzone.on("addedfile", function(file) {
        // Hookup the start button
        file.previewElement.querySelector(".start").onclick = function() {
            myDropzone.enqueueFile(file)
        }
    })

    // Update the total progress bar
    myDropzone.on("totaluploadprogress", function(progress) {
        document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
    })

    myDropzone.on("sending", function(file) {
        // Show the total progress bar when upload starts
        document.querySelector("#total-progress").style.opacity = "1"
        // And disable the start button
        file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
    })

    // Hide the total progress bar when nothing's uploading anymore
    myDropzone.on("queuecomplete", function(progress) {
        document.querySelector("#total-progress").style.opacity = "0"
    })

    // Setup the buttons for all transfers
    // The "add files" button doesn't need to be setup because the config
    // `clickable` has already been specified.
    document.querySelector("#actions .start").onclick = function() {
        myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
    }
    document.querySelector("#actions .cancel").onclick = function() {
        myDropzone.removeAllFiles(true)
    }
    // DropzoneJS Demo Code End
</script>

<!--profile pic import-->

<script>
    function updateButtonLabel() {
        var fileInput = document.getElementById('fileToUpload');
        var fileName = fileInput.value.split('\\').pop();
        var importButton = document.getElementById('importbutton');
        var profileBlock1 = document.getElementById("pBlock1");
        var profileBlock2 = document.getElementById("pBlock2");
        var fileBlock = document.getElementById("fileBlock");
        var submissionBlock = document.getElementById("submissionBlock");

        importButton.value = fileName;

        if (fileName.length !== 0) {
            profileBlock1.style.display = "block";
            profileBlock2.style.display = "none";
            fileBlock.style.display = "none";
            submissionBlock.style.display = "block";
        }
        previewImage(fileInput.files);
    }

    function previewImage(files) {
        var preview = document.getElementById('preview');
        preview.innerHTML = "";
        for (var i = 0; i < files.length && i < 1; i++) {
            var reader = new FileReader();
            reader.onload = function(event) {
                var img = document.createElement('img');
                img.src = event.target.result;
                preview.appendChild(img);
            }
            reader.readAsDataURL(files[i]);
        }
    }
</script>

<!--file import-->

<script>
    function updatebuttonlabel() {
        var fileInput = document.getElementById('filetoupload');
        var fileName = fileInput.value.split('\\').pop();
        var importButton = document.getElementById('import_button');
        importButton.value = fileName;
        previewimage(fileInput.files);
    }

    function previewimage(files) {
        var preview = document.getElementById('_preview');
        preview.innerHTML = "";
        for (var i = 0; i < files.length && i < 1; i++) {
            var reader = new FileReader();
            reader.onload = function(event) {
                var img = document.createElement('img');
                img.src = event.target.result;
                preview.appendChild(img);
            }
            reader.readAsDataURL(files[i]);
        }
    }
</script>

<!--files import-->

<script>
    function updatebuttonLabel() {
        var fileInput = document.getElementById('filesToUpload');
        var fileName = "";
        for (var i = 0; i < fileInput.files.length && i < 3; i++) {
            fileName += fileInput.files[i].name + ", ";
        }
        fileName = fileName.substring(0, fileName.length - 2);
        var importButton = document.getElementById('importButton');
        importButton.value = fileName;
        previewImages(fileInput.files);
    }

    function previewImages(files) {
        var preview = document.getElementById('previews');
        preview.innerHTML = "";
        for (var i = 0; i < files.length && i < 3; i++) {
            var reader = new FileReader();
            reader.onload = function(event) {
                var img = document.createElement('img');
                img.src = event.target.result;
                preview.appendChild(img);
            }
            reader.readAsDataURL(files[i]);
        }
    }
</script>

<!--select options to submit form-->

<script>
    $(document).ready(function() {
        $('#mySelect option').click(function() {
            var value = $(this).val();
            if (value) {
                $('#myForm').submit();
            }
        });
    });
</script>

<!--select options to submit form-->

<script>
    $(document).ready(function() {
        $('#mySelect2 option').click(function() {
            var value = $(this).data('value');
            if (value) {
                $('#myForm').submit();
            }
        });
    });
</script>

<!--select options to submit form-->

<script>
    $(document).ready(function() {
        $('#mySelect3 option').click(function() {
            var value = $(this).data('value');
            if (value) {
                $('#myForm').submit();
            }
        });
    });
</script>

<!--Display block for package addition-->

<script>
    function updateBlockVisibility() {
        var selection = document.getElementById("selection");
        var block1 = document.getElementById("block1");
        var block2 = document.getElementById("block2");

        if (selection.value === "<?= ANONYMOUS_ID ?>") {
            block1.style.display = "block";
            block2.style.display = "none";
        } else {
            block1.style.display = "none";
            block2.style.display = "block";
        }

        updateBlockVisibility();
    }
</script>

<!--Display block for insurance billing-->

<script>
    function insuranceBlockVisibility() {
        var radio = document.getElementById("radio");
        var insuranceBlock = document.getElementById("insuranceBlock");

        if (radio.checked) {
            insuranceBlock.style.display = "block";
        } else {
            insuranceBlock.style.display = "none";
        }

        insuranceBlockVisibility();
    }
</script>

<!--Display block for -->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var selectElement = document.getElementById('products');
        var insurBlock = document.getElementById('insurance');

        selectElement.addEventListener('change', function() {
            var selectedOption = selectElement.options[selectElement.selectedIndex];
            var targetBlockId = selectedOption.getAttribute('data-target');

            if (targetBlockId === 'insurance') {
                insurBlock.style.display = 'block';
            } else {
                insurBlock.style.display = 'none';
            }
        });
    });
</script>

<!-- Checkboxes -->

<script>
    window.addEventListener("DOMContentLoaded", function() {
        var checkAll = document.getElementById("check-all");
        var checkboxes = document.querySelectorAll(".ischecked");

        checkAll.addEventListener("change", function() {
            var isChecked = checkAll.checked;

            checkboxes.forEach(function(checkbox) {
                checkbox.checked = isChecked;
            });
        });

        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener("change", function() {
                if (checkbox.checked && checkAll.checked) {
                    checkAll.checked = false;
                }
            });
        });
    });
</script>

<!-- Notifications -->

<script>
    var elements = document.getElementsByClassName("notification");
    var elementsArray = Array.from(elements);

    for (var i = 0; i < elementsArray.length; i++) {
        elementsArray[i].addEventListener("click", function() {
            for (var j = 0; j < elementsArray.length; j++) {
                elementsArray[j].classList.remove("notification", "text-danger", "badge-blink");
            }
        });
    }

    if (elementsArray.length === 0) {
        var deactivate = '<?php echo deactivatedNotifications($data['id']); ?>';
    }
</script>


</body>

</html>