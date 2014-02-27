$.extend($.validator.defaults, {            
//    errorPlacement: function(error, element) {
//        var $parent = element.parent();
//        element.removeClass(registrationErrorClasses)
//        $('.remove_before_place_next_error').remove();
//        error.insertAfter( $parent );
//    },
     errorElement : 'p'
    ,errorClass   : 'error-message'
});
