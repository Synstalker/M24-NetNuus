<?php
namespace MoonBoy\YouTube;

const thumbnailBase = "https://img.youtube.com/vi/%s/";
const thumbnailEndpoints = [
	"maxresdefault.jpg",
	"sddefault.jpg",
	"mqdefault.jpg",
	"hqdefault.jpg",
	"default.jpg",
	"3.jpg",
	"2.jpg",
	"1.jpg",
	"0.jpg"
];

/**
 * @param string $videoURL
 *
 * @return false|string     Returns false on failure otherwise URL of the youtube thumbnail
 */
function get_thumbnail_url( $videoURL = '' ){
	
	if( !$videoURL ){
		return false;
	}
	
	$parsedURL = parse_url( $videoURL );
	
	/**
	 * An invalid youtube url was received,
	 * bounce
	 */
	if( !isset( $parsedURL['query'] ) ){
		return false;
	}
		
	$urlQueries = explode( 'v=', $parsedURL['query'] );
	/**
	 * Reset key index
	 */
	$urlQueries = array_values( array_filter( $urlQueries ) );
	$videoID = $urlQueries[0];
	
	/**
	 * Strip out extra queries
	 */
	if( false !== strpos($videoID,'&') ){
		$videoID = substr($videoID,0, strpos($videoID,'&'));
	}
	
	/**
	 * Go to the next article if a youtube video ID could not be extracted
	 */
	if( !$videoID ){
		return false;
	}
		
	foreach(thumbnailEndpoints as $endpoint){
		$thumbnailURL = sprintf( thumbnailBase, $videoID ). $endpoint;
		$thumbnailRequest = wp_remote_head($thumbnailURL);
		
		if( is_wp_error( $thumbnailRequest ) ){
			continue;
		}
		
		$requestResponse = wp_remote_retrieve_response_code($thumbnailRequest);
		if( 200 !== (int) $requestResponse ){
			continue;
		}
		
		return $thumbnailURL;
	}
	
	return false;
}