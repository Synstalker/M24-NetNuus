<?php
/**
 * The Header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 */
?>

<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>

    <!--[if IE]>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <![endif]-->

    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0" />
    <meta name="apple-mobile-web-app-title" content="<?php wp_title('|', true, 'right'); ?>">
    <title><?php echo get_bloginfo( 'name' ); ?> | <?php echo get_bloginfo( 'description' ); ?></title>
    <link rel="author" href="/humans.txt"/>
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <link rel="icon" type="image/png" href="<?php echo of_get_option( 'theme_favicon' ); ?>">

    <!--[if lt IE 9]>
    <script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
    <![endif]-->

    <?php wp_head(); ?>

</head>

<body <?php body_class('preload'); ?>>
<?php if ( is_active_sidebar( 'mtf_koos_bar_sb' ) ) : ?>
    <!--Koos bar sidebar - start-->
    <?php dynamic_sidebar( 'mtf_koos_bar_sb' ); ?>
    <!--Koos bar sidebar - end-->
<?php endif; ?>
    <div class="siteContainer" id="siteContainer">

        <div class="notification">
            <a href="#" class="notification__msg">
                <span>Notification msg</span>
            </a>

            <div class="notification__close" id="notificationClose">
                <span class="sprite-exit_cross_white"></span>
            </div>
        </div>

        <div class="modal mfp-hide" id="modalGlobal">
            <header class="modal__header">
                <div class="modal__title"><h2>Modal Title</h2></div>
                <div class="modal__close"><span class="sprite-exit_cross_black"></span></div>
            </header>

            <div class="modal__body">
                <p>Modal Body</p>
            </div>

            <footer class="modal__footer">
                <button class="button--grey">Continue</button>
            </footer>
        </div>

        <div class="siteContainer__content" id="siteContainerInner">
