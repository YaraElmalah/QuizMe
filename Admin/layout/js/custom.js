//Remove Placeholder on Focus
$('[placeholder]').focus(function() {
    $(this).attr('data-text', $(this).attr('placeholder'));
    $(this).attr('placeholder', '');
}).blur(function() {
    $(this).attr('placeholder', $(this).attr('data-text'));
});