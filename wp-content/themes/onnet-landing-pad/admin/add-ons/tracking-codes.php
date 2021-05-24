<?php

/**
 * OnNet Framework Plugin: Tracking Codes
 * Description: Adds tracking codes for Google Analytics
 * Version: 1.0.0
 * Developer: Vince Kruger
 * Developer Email: vincent@onnet.co.za
 */
class OnNet_Admin_Tracking_Codes
{
	function __construct()
	{
		// Filters & Hooks
		add_filter('onnet_admin_options', array($this, 'add_settings'), -99);
		add_action('optionsframework_custom_scripts', array($this, 'optionsframework_custom_scripts'));

		if(of_get_option('tracking_codes_enabled'))
		{
			add_action('wp_footer', array($this, 'wp_footer'));
		}
	}

	function add_settings($current_options)
	{
		$options[] = array(
			'name' => __('Tracking Codes', 'admin-framework'),
			'type' => 'heading'
		);

		$options[] = array(
			'name' => __('Tracking Codes', 'admin-framework'),
			'desc' => __('Enable tracking codes', 'admin-framework'),
			'id'   => 'tracking_codes_enabled',
			'type' => 'checkbox'
		);

		$options[] = array(
			'name'  => __('Google Analytics Tracking Code', 'admin-framework'),
			'desc'  => __('UA-xxxxxxxx-x.', 'admin-framework'),
			'id'    => 'tracking_analytics_tracking_code',
			'std'   => '',
			'type'  => 'text',
			'class' => 'hidden'
		);

		$options[] = array(
			'name'  => __('Google Analytics Registered URL', 'admin-framework'),
			'desc'  => __('Please do not include http:// or www.', 'admin-framework'),
			'id'    => 'tracking_analytics_tracking_url',
			'std'   => '',
			'type'  => 'text',
			'class' => 'hidden'
		);

		return array_merge($options, $current_options);
	}

	function optionsframework_custom_scripts()
	{
		?>
		<script type="text/javascript">
			jQuery(document).ready(function () {

				jQuery('#tracking_codes_enabled').click(function () {
					jQuery('#section-tracking_analytics_tracking_code').fadeToggle(400);
					jQuery('#section-tracking_analytics_tracking_url').fadeToggle(400);
				});

				if (jQuery('#tracking_codes_enabled:checked').val() !== undefined) {
					jQuery('#section-tracking_analytics_tracking_code').show();
					jQuery('#section-tracking_analytics_tracking_url').show();
				}

			});
		</script>
	<?php
	}

	function wp_footer()
	{
		if ( '' != of_get_option('tracking_analytics_tracking_code') && '' != of_get_option('tracking_analytics_tracking_url') )
		{
			?>
			<script>
				(function (i, s, o, g, r, a, m) {
					i['GoogleAnalyticsObject'] = r;
					i[r] = i[r] || function () {
						(i[r].q = i[r].q || []).push(arguments)
					}, i[r].l = 1 * new Date();
					a = s.createElement(o),
						m = s.getElementsByTagName(o)[0];
					a.async = 1;
					a.src = g;
					m.parentNode.insertBefore(a, m)
				})(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
				ga('create', '<?php echo of_get_option('tracking_analytics_tracking_code'); ?>', '<?php echo of_get_option('tracking_analytics_tracking_url'); ?>');
				ga('send', 'pageview');
			</script>
		<?php
		}
	}
}

new OnNet_Admin_Tracking_Codes;

if(!function_exists('tracking_is_enabled')):
	function tracking_is_enabled(){
		return of_get_option('tracking_codes_enabled') ? true : false;
	}
endif;

