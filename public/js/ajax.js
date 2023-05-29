$(document).ready(function() {

    var $submitButton = $('#submitButton');
    var $loader = $submitButton.find('.loader');

    $('#login').submit(function(event) {
        event.preventDefault();

        var m_ps = $('#m_ps').val();
        var pass = $('#pass').val();

        $submitButton.attr('disabled', true);
        $loader.addClass('show');

        $.ajax({
            url: 'login/login',
            method: 'POST',
            data: {
                m_ps: m_ps,
                pass: pass,
            },
            dataType: 'json',
            success: function(response) {
                var Toast = Swal.mixin({
                    toast: true,
                    position: 'top',
                    showConfirmButton: false,
                });
                if (response.success) {
                    Toast.fire({
                        icon: 'success',
                        title: 'Succès',
                        text: response.message,
                        timer: 500
                    }).then(function() {
                        window.location.href= response.redirectUrl;
                    });
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