$(document).ready(function () {
    $(window).on('ajaxInvalidField', function (event, fieldElement, fieldName, errorMsg, isFirst) {
        $(fieldElement).closest('.form-field').addClass('form-field_error');
    });

    $(document).on('ajaxPromise', '[data-request]', function () {
        $(this).closest('form').find('.form-field.form-field_error').removeClass('form-field_error');
    });
});


