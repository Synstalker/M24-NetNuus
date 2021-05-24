<?php

function setup_theme_menu_locations() {
    register_nav_menus(
        array(
            'primary' => __( 'Header Menu' ),
            'secondary' => __( 'Footer Menu' )
        )
    );
}