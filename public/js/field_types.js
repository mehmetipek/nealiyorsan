$(function () {
    $('[data-toggle="popover"]').popover();

    $('#type').on('change', function () {
        var templates = $('#field_options_template');
        $('#field_options').html('');

        switch (this.value) {
            case 'text':
                break;
            case 'number':
                break;
            case 'select':
            case 'select-multi':

                $('#field_options').append(templates.find('#static_values_field').html());
                $('#field_options').append(templates.find('#seperator').html());
                $('#field_options').append(templates.find('#related_field').html());
                break;
            case 'range':
                $('#field_options').append(templates.find('#range_field').html());
                break;
            case 'checkbox':
                $('#field_options').append(templates.find('#checkbox_field').html());

                break;
            case 'radio':
                $('#field_options').append(templates.find('#radio_field').html());

                break;


        }
    })
});
