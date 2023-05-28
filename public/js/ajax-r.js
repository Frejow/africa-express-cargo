$(document).ready(function() {
    $('#register').submit(function(event) {
        event.preventDefault();

        var nom = $('#nom').val();
        var prenom = $('#prenom').val();
        var pseudo = $('#pseudo').val();
        var mail = $('#mail').val();
        var tel = $('#tel').val();
        var country = $('#country').val();
        var pass = $('#pass').val();
        var repass = $('#repass').val();

        var $submitButton = $('#submitButton');
        var $loader = $submitButton.find('.loader');

        $submitButton.attr('disabled', true);
        $loader.addClass('show');

        $.ajax({
            url: 'register/register',
            method: 'POST',
            data: {
                nom: nom,
                prenom: prenom,
                pseudo: pseudo,
                mail: mail,
                tel: tel,
                country: country,
                pass: pass,
                repass: repass,
            },
            dataType: 'json',
            success: function(response) {
                var Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                });
                if (response.success) {
                    Toast.fire({
                        icon: 'success',
                        title: 'Succès',
                        text: response.message
                    })
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: 'Erreur',
                        text: response.message
                    });
                }

                $submitButton.attr('disabled', false);
                $loader.removeClass('show');
            },
            error: function(xhr, status, error) {
                console.log('Erreur lors de la requête AJAX : ' + error);

                $submitButton.attr('disabled', false);
                $loader.removeClass('show');
            }
        });
    });
});