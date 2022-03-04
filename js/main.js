(function ($) {

    'use strict';

    // Form
    var contactForm = function () {
        $('#cpf').mask('000.000.000-00', {reverse: true});

        if ($('#contactForm').length > 0) {
            $('#contactForm').validate({
                rules: {
                    name: 'required',
                    subject: 'required',
                    email: {
                        required: true,
                        email: true
                    },
                    message: {
                        required: true,
                        minlength: 5
                    }
                },
                messages: {
                    name: 'Please enter your name',
                    subject: 'Please enter your subject',
                    email: 'Please enter a valid email address',
                    message: 'Please enter a message'
                },
                /* submit via ajax */

                submitHandler: function (form) {
                    var $submit = $('.submitting'),
                        waitText = 'Resgatando....';

                    $.ajax({
                        type: 'POST',
                        url: 'php/getCupom.php',
                        data: $(form).serialize(),

                        beforeSend: function () {
                            $submit.css('display', 'block').text(waitText);
                        },
                        success: function (msg) {
                            if (msg !== 'Matrícula não possui cupom disponível.') {
                                msg += '<br> Resgate em: App IFood > Perfil > Pagamentos > Resgatar IFood Card'
                                $('#form-message-success').html(msg);
                                $('#form-message-warning').hide();
                                setTimeout(function () {
                                    $('#contactForm').fadeIn();
                                }, 1000);

                                setTimeout(function () {
                                    $('#form-message-success').fadeIn();
                                }, 1400);

                                setTimeout(function () {
                                    $submit.css('display', 'none').text(waitText);
                                }, 1400);

                                setTimeout(function () {
                                    $('#contactForm').each(function () {
                                        this.reset();
                                    });
                                }, 1400);

                            } else {
                                $('#form-message-warning').html(msg);
                                $('#form-message-warning').fadeIn();
                                $submit.css('display', 'none');
                            }
                        },
                        error: function () {
                            $('#form-message-warning').html('Something went wrong. Please try again.');
                            $('#form-message-warning').fadeIn();
                            $submit.css('display', 'none');
                        }
                    });
                } // end submitHandler

            });
        }
    };
    contactForm();



})(jQuery);


