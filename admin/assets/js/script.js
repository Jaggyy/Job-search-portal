toastr.options =
{
    "closeButton": true,
    "progressBar": true,
    "positionClass": "toast-top-right"
}

/***************************Form Validation************************************/
$(document).ready(function () {
    _formValidation();
});
var _formValidation = function (form_id = '#content_form') {
    let form = $(form_id);
    if (form.length > 0) {
        form.on('submit', function (e) {
            e.preventDefault();
            form.find('.submit').hide();
            form.find('.submitting').show();
            const submit = $('#submit');
            const submit_val = submit.val();
            const submit_url = form.attr('action');
            //Start Ajax
            const formData = new FormData(form[0]);
            formData.append('submit', submit_val);
            $.ajax({
                url: submit_url,
                type: 'POST',
                data: formData,
                contentType: false, // The content type used when sending data to the server.
                cache: false, // To unable request pages to be cached
                processData: false,
                dataType: 'JSON',
                success: function (data) {
                    if(data.message)
                    {
                        form[0].reset();
                        form.find('.submit').show();
                        form.find('.submitting').hide();
                        toastr.success(data.message, data.title);
                    }
                    else if(data.error)
                    {
                        form.find('.submit').show();
                        form.find('.submitting').hide();
                        toastr.error(data.error);
                    }
                }
            });
        });
    }
};