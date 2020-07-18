$(function() {
    'use strict';
    //Toggle The Panel
    $('.toggle-show').on('click', function() {
            $(this).toggleClass('selected').parent().next('.panel-body').fadeToggle(300);
            ($(this).hasClass('selected')) ? $(this).html("<i class='fas fa-minus'></i>"): $(this).html("<i class='fas fa-plus'></i>");
        })
        //make the Radio Button take the value from beside Field
    $("input[type='text']").on('keyup', function() {
        $($(this).data('radio')).attr('value', $(this).data('value'));
    })

    //Remove Placeholder on Focus
    $('[placeholder]').focus(function() {
        $(this).attr('data-text', $(this).attr('placeholder'));
        $(this).attr('placeholder', '');
    }).blur(function() {
        $(this).attr('placeholder', $(this).attr('data-text'));
    });
    //Add Asterisk on Required Files
    $('input').each(function() {
            if ($(this).attr('required') === 'required') {
                $(this).after('<span class="asterisk">*</span>');
            }
        })
        //Confirm Message On Delete Member Button
    $('.confirm').on('click', function() {
        return confirm('Are You Sure?');
    })

});