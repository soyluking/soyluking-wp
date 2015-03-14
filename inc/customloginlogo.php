<?php
/*-----------------------------------------------------------------------------------*/
/*	Custom Login Logo Support
/*-----------------------------------------------------------------------------------*/

if( !function_exists( 'custom_login_logo' ) ) {
    function custom_login_logo() {
    	if (ot_get_option('loginlogo', '')) {
    	$loginlogo = ot_get_option('loginlogo', '');
        echo '<style type="text/css">
            h1 a { background-image:url('. $loginlogo .') !important; background-size:auto !important;}
        </style>';
        }
    }
    
    add_action('login_head', 'custom_login_logo');
}
?>