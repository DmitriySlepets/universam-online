jQuery(document).ready(function() {
//  open login form
    jQuery(document).on('click', '#login-ajax', function(event) {
        jQuery('.masck').removeClass('none');
        jQuery('.login_box_center').removeClass('none');
        return false;
    });
//  close login form
    jQuery(document).on('click', '.close-form', function(event) {
        jQuery('.masck').addClass('none');
        jQuery('.login_box_center').addClass('none');
        return false;
    });

    jQuery('.login_box #login').on('submit', function(e) {
        jQuery('.login_box .status_login').show().text(ajax_login_object.loadingmessage);
        jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_login_object.ajaxurl,
            data: {
                'action': 'ajaxlogin', //calls wp_ajax_nopriv_ajaxlogin
                'username': jQuery('.login_box #username').val(),
                'password': jQuery('.login_box #password').val(),
                'security': jQuery('.login_box #security').val()
            },
            success: function(data) {
                jQuery('.login_box .status_login').text(data.message);
                if (data.loggedin == true) {
                    document.location.href = ajax_login_object.redirecturl;
                }
            }
        });
        e.preventDefault();
    });

});

