<?php
// URL's to Font families
function theme_font_url()
{
	$font_url = add_query_arg('family', 'Lato:300,400,700', "//fonts.googleapis.com/css");

	return $font_url;
}