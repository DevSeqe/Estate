function html_entity_decode(s) {
    var t = jQuery('<textarea>').html(s);
    return t.val();
}
function printAlert(type, msg, clear) {
    if (clear) {
        $('.alertCont .alert').remove();
    }
    var icon = '';
    switch (type) {
        case 'success':
            icon = '<i class="fa fa-check-square-o"></i>';
            break;
        case 'info':
            icon = '<i class="fa fa-info-circle"></i>';
            break;
        case 'warning':
            icon = '<i class="fa fa-warning"></i>';
            break;
        case 'danger':
            icon = '<i class="fa fa-close"></i>';
            break;
    }
    var alertBox = $('<div class="alert alert-dismissible alert-' + type + '">' + icon + ' ' + html_entity_decode(msg) + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    $('.alertCont').append(alertBox);
}
