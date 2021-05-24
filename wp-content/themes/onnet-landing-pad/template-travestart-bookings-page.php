<?php
/**
 * Template Name: Travelstart Bookings Page
 */

get_header();

// Header variables
$logo = of_get_option('default_logo_image');
$logo = (!empty($logo)) ? $logo : "";
$home_url = home_url();
$site_description = get_bloginfo( 'description' );

// Social variables
$pinterest = of_get_option('social_pinterest');
$facebook = of_get_option('social_facebook');
$twitter = of_get_option('social_twitter');
$instagram = of_get_option('social_instagram');
$youtube = of_get_option('social_youtube');

// Closing background
$show = of_get_option('show_closing');
$background = of_get_option('background_image');
$message = of_get_option('closing_message');

global $wpdb;
$image_attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $logo));
$image_ID = '';
if (isset($image_attachment)) {
	$image_ID = $image_attachment[0];
}
$logo = wp_get_attachment_image_src( $image_ID, 'logo' );

?>

<main role="main">
	<div class="magazineLogo">
		<a href="<?php echo $home_url; ?>">
			<img src="<?php echo $logo[0]; ?>" alt="">
		</a>
		<span><?php if(!empty($site_description)) { echo $site_description; } ?></span>
	</div>

	<?php if (!empty($pinterest) || !empty($facebook) || !empty($twitter) || !empty($instagram)) { ?>

		<div class="socialLinks">
			<div class="socialLinks__body">
				<ul>
					<?php if (!empty($pinterest)) { ?>
						<li>
							<a href="http://www.pinterest.com/fairladymag" target="_blank">
								<span class="sprite-social_pinterest"></span>
							</a>
						</li>
						<?php }
						if (!empty($facebook)) { ?>
							<li>
								<a href="http://www.facebook.com/fairladymag" target="_blank">
									<span class="sprite-social_facebook"></span>
								</a>
							</li>
							<?php }
							if (!empty($twitter)) { ?>
								<li>
									<a href="http://www.twitter.com/fairladymag" target="_blank">
										<span class="sprite-social_twitter"></span>
									</a>
								</li>
								<?php }
								if (!empty($instagram)) { ?>
									<li>
										<a href="https://instagram.com/fairlady_magazine/" target="_blank">
											<span class="sprite-social_instagram"></span>
										</a>
									</li>
									<?php }
									if (!empty($youtube)) { ?>
										<li>
											<a href="<?php echo $youtube; ?>" target="_blank">
												<span class="sprite-social_youtube"></span>
											</a>
										</li>
										<?php } ?>
									</ul>
								</div>
							</div>

							<?php } ?>

							<?php if ( have_posts() ) : ?>

								<?php while ( have_posts() ) : the_post(); ?>

									<article itemscope itemtype="<?php the_permalink(); ?>">
										<?php echo get_the_post_thumbnail( get_the_ID(), 'single' ); ?>
										<header> <!-- Only use <header> elements when they contain more than just an h1 tag. -->
											<h1 itemprop="headline"><?php echo get_the_title(); ?></h1>
										</header>

										<div>
											<?php the_content(); ?>
										</div>

									</article>

								<?php endwhile; ?>

							<?php endif; ?>

							<div class="magazineLogoFooter">

								<?php $defaults = array(
									'theme_location'  => 'secondary',
									'menu'            => '',
									'container'       => 'div',
									'container_class' => 'magazineLogoFooter__menu',
									'container_id'    => 'magazineLogoFooter__menu',
									'menu_class'      => 'menu',
									'menu_id'         => '',
									'echo'            => true,
									'fallback_cb'     => 'wp_page_menu',
									'before'          => '',
									'after'           => '',
									'link_before'     => '',
									'link_after'      => '',
									'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
									'depth'           => 0,
									'walker'          => ''
								);

								wp_nav_menu( $defaults ); ?>

								<img src="<?php echo $logo[0]; ?>" alt="">

							</div>

						</main> <!-- End .body -->

						<?php get_footer(); ?>
