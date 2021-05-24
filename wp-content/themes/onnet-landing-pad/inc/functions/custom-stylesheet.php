<?php
/*
* Add custom stylesheet
*/
function style_add_query_vars($query_vars) {
    $query_vars[] = 'stylesheet';

    return $query_vars;
}
add_filter('query_vars', 'style_add_query_vars');

function takeover_css() {
    if(!is_admin()){ 
        $style = get_query_var('stylesheet');
        if ( $style == "custom" ) {
            include_once(TEMPLATEPATH . '/style.php');
            exit;
        }
    }
}
add_action('template_redirect', 'takeover_css');
