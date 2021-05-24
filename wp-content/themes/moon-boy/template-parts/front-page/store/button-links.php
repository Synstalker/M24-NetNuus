<?php
use MoonBoy\Device;

/**
 * @todo these links should be dynamic
 * @todo the language used on android link should come from the site language
 * @todo see the plugin suggested by francois for the
 */
$storeLinkAndroid = get_theme_mod('app_store_link_android') ?: '#';
$storeLinkiOS = get_theme_mod('app_store_link_ios') ?: '#';

?>
<div class="buttons">
    <?php if( !wp_is_mobile() || ( wp_is_mobile() && Device::isiOS() ) ): ?>
	<a href="<?php echo $storeLinkiOS; ?>" target="_blank" onclick="ga('send', 'event', 'Download App', 'Click', 'iOS Download');" class="ios">
		<button class="btn btn-neutral btn-md" style="padding:8px 30px;">
			<i class="fa fa-lg fa-apple"></i> App Store
		</button>
	</a>
    <?php endif; ?>
	<?php if( !wp_is_mobile() || ( wp_is_mobile() && Device::isAndroidOS() ) ): ?>
    <a href="<?php echo $storeLinkAndroid; ?>" target="_blank" onclick="ga('send', 'event', 'Download App', 'Click', 'Android Download');" class="android">
		<button class="btn btn-neutral btn-md" style="padding:8px 30px;">
			<i class="fa fa-lg fa-android"></i> Play Store
		</button>
	</a>
	<?php endif; ?>
	<a href="https://appgallery.huawei.com/#/app/C100385501?locale=en_US&source=appshare&subsource=C100385501"  class="android">
		<button class="btn btn-neutral btn-md" style="padding:8px 30px;">
		<img src="/wp-content/uploads/2021/02/appgallery-md.png" style="height:17px;padding-right:2px;"/>  AppGallery
		</button>
	</a>
</div>
<!-- OneTrust Cookies Consent Notice start for netnuus.com -->

<script src="https://cdn.cookielaw.org/scripttemplates/otSDKStub.js"  type="text/javascript" charset="UTF-8" data-domain-script="0aee3a34-2186-46eb-9fd9-2b523bd46a8f" ></script>
<script type="text/javascript">
function OptanonWrapper() { }
</script>
<!-- OneTrust Cookies Consent Notice end for netnuus.com -->