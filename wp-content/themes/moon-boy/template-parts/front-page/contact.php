<?php
$contact_us_form_id = get_theme_mod('contact_us_form');

if( !$contact_us_form_id ){
    return;
}

?>
<section id="contact" class="section text-center grey-background">
	<div class="container">
		<div class="row">
			<div class="col-sm-8 col-sm-offset-2">
                <?php echo do_shortcode('[gravityform id="'.$contact_us_form_id.'" title="true" description="true" ajax="true"]' ); ?>
			</div>
		</div>
	</div>
</section>