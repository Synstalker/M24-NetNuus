<?php header('Content-type: text/css');
wp_reset_postdata();

// Logo
$logo_size = of_get_option("logo_size");

// General Colors
$primary_color = of_get_option("theme_color");
$secondary_color = of_get_option("theme_color_2");
$tertiary_color = of_get_option("theme_color_3");

// Font colors
$font_color = of_get_option("font_color");
$font_color_secondary = of_get_option("font_color_secondary");
$font_color_hover = of_get_option("font_color_hover");

// General Layout
$full_width_container = of_get_option("full_width_container");

// Widget / General Options
$gradient_magazine_styling = of_get_option("gradient_styling");
$custom_styling = of_get_option("custom_styling");

?>

<?php // Body background general styling ?>

.siteContainer {
	background: <?php echo $primary_color; ?>;
}

.magazineLogo span {
	color: <?php echo $font_color_secondary; ?>;
}

.socialLinks {
  background: <?php echo $primary_color; ?>;
}

<?php // Header general stlying ?>

.magazineLogo, .magazineLogoFooter {
	background: <?php echo $tertiary_color; ?>;
}

.siteContainer__content .magazineLogo a img {
	width: <?php echo $logo_size; ?>;
	border-bottom: 1px solid <?php echo $secondary_color; ?>;
}

.siteContainer__content .magazineLogoFooter img {
	width: <?php echo $logo_size; ?>;
}

<?php // Magazine widget ?>

.getLatestMag__body a:hover {
	background: <?php echo $secondary_color; ?>;
	color: <?php echo $font_color_hover; ?>;
}

.getLatestMag, .getLatestMag--greytint {
	<?php echo $gradient_magazine_styling; ?>
}

<?php // Newsletter / contact widget ?>

.subscribeToNewsletter__form input[type=submit]:hover,
.subscribeToNewsletter__form--left input[type=submit]:hover,
.subscribeToNewsletter__form--right input[type=submit]:hover {
	background: <?php echo $secondary_color; ?>;
	color: <?php echo $font_color_hover; ?>;
}

.getInTouch__form input[type=submit]:hover,
.getInTouch__form--left input[type=submit]:hover,
.getInTouch__form--right input[type=submit]:hover {
	background: <?php echo $secondary_color; ?>;
	color: <?php echo $font_color_hover; ?>;
}

<?php if ($full_width_container == 1) { ?>

	@media screen and (min-width: 620px) {
		.siteContainer [role=main] {
		  padding: 0;
		}
	}

<?php } ?>

<?php // Footer general styling ?>

.magazineLogoFooter__menu ul li {
	border-left: 1px solid <?php echo $font_color_secondary; ?>;
}

.magazineLogoFooter__menu ul li a {
	color: <?php echo $font_color_secondary; ?>;
}

<?php // Custom styling ?>

<?php echo $custom_styling; ?>
