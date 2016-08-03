$(function() {
    $(document).on('change', '#users-data-grid :input', function() {
        var $input = $(this),
            data   = {};

        data[$input.attr('name')] = $input.val();

        $.ajax({
            url: '/user/update/' + $input.closest('[data-key]').data('key'),
            method: 'POST',
            data: data,
            success: function(data) {
                showResponse($input, data && data.error ? data.error : false);
            },
            error: function(error) {
                showResponse($input, error);
            }
        });

        function showResponse($input, error) {
            if (error) {
                error = getErrors(error);
                showAlert(error, 'alert-danger');

                $input.parent().addClass('has-error');
                $input.nextAll('.help-block').remove();

                $('<div class="help-block"/>').insertAfter($input).append(error.clone());
            } else {
                showAlert('Data successfully updated', 'alert-success');
                $input.parent().removeClass('has-error');
                $input.nextAll('.help-block').remove();
            }
        }

        function getErrors(text) {
            var ul = $('<ul/>');

            if (typeof text === 'string') {
                $('<li/>').text(text).appendTo(ul);
            } else {
                for (var i in text) {
                    var err = text[i];

                    if (typeof err === 'string') {
                        $('<li/>').text(err).appendTo(ul);
                    } else {
                        for (var j in err) {
                            $('<li/>').text(err[j]).appendTo(ul);
                        }
                    }
                }
            }

            return ul;
        }

        function showAlert(text, className) {
            var alert = $('<div class="alert" role="alert"/>')
                .addClass(className)
                .append(text)
                .appendTo('#alert-container')
                .alert()
                .hide()
                .fadeIn(120);

            setTimeout(function() {
                alert.animate({
                    marginTop: - alert.outerHeight(),
                    marginBottom: 0,
                    opacity: 0
                }, 300, undefined, function() {
                    alert.remove();
                })
            }, 3000)
        }
    });
});