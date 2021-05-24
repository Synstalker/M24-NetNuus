<section id="hero" class="section yellow-background">
	<div class="container">
		<div class="row landing_section vertical-align">
			<div class="col-md-7">
                <div class="logo-container">
                    <div class="brand">
                        <?php the_custom_logo(); ?>
                    </div>
                </div>
            
				<div class="description">
					<h5>Kry die kern van die nuus: raakgevat, kraakvars en sonder die geraas.</h5>
					<h5>Dis vinnig, eenvoudig, verniet en Afrikaans.</h5>
					<h5>Rol deur die nuus en gesels saam.</h5>
					<h2>Laai die app af en spring weg!</h2>
				</div>
				<?php get_template_part( 'template-parts/front-page/store/button-links'); ?>
			</div>
            <div class="col-md-5">
	            <?php dynamic_sidebar('sidebar' ); ?>
            </div>
		</div>
	</div>
</section>