<?php
namespace MoonBoy;

/**
 * Class Device
 * @see     http://mobiledetect.net/
 * @package MoonBoy
 * @todo    what to do when mobile detect
 */
class Device {
	
	public static $_device;
	static $isiOS = false;
	
	public static function get() {
		self::$_device = self::$_device ?? ( class_exists( '\Mobile_Detect' ) ? new \Mobile_Detect() : false );
		
		return self::$_device;
	}
	
	/**
	 * Detects if the device is using an iOS device,
	 * sends back false positive when the Mobile Detect library is not present
	 * @return bool
	 */
	public static function isiOS() {
		return self::get() ? self::get()->isiOS() : true;
	}
	
	/**
	 * Detects if the device is using an Android device,
	 * sends back false positive when the Mobile Detect library is not present
	 * @return bool
	 */
	public static function isAndroidOS() {
		return self::get() ? self::get()->isAndroidOS() : true;
	}
}

/**
 * Send device info to the frontend, purely for debugging purposes
 */
add_filter( 'MoonBoy\Enqueues\localized_info', function ( $data ) {
	
	$data = wp_parse_args( $data, [
		'Device' => [
			'Mobile_Detect' => [
				'available' => class_exists( '\Mobile_Detect') ? true : false,
				'userAgent' => class_exists( '\Mobile_Detect') ? Device::get()->getUserAgent() : NULL
			]
		]
	]);
	
	return $data;
}, DEFAULT_FILTER_PRIORITY );

