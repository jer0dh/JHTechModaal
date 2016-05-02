<?php
//* Start the engine
/*
Plugin Name: jhtechModaal
Plugin URI: http://jhtechservices.com
Description: Addes Modaaljs by Humaan to Wordpress
Author: Jerod Hammerstein
Version: 0.1
Author URI: http://jhtechservices.com
*/
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly


class jhtechModaalPlugin {

	
	public function __construct() {
		
		// Set Plugin Path
		
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue'));
		
		add_shortcode( 'modaal', array( $this, 'shortcode'));
		
		
		
	}
	
	public function shortcode($atts, $content="") {
		static $modalNum = 0;
		$output = '';

		extract(shortcode_atts(array(
			'type' 				=> 	'inline',
			'buttonClass' 		=> 	'button',
			'buttonText'		=>  '',
			'buttonImage'		=>	'',
			'attribs'			=>  '',
		), $atts));

		
		//attribs to be string that will be converted to assoc. array - list of modaal options to expand to data-modaal-* attributes
		// see: http://stackoverflow.com/questions/14133780/explode-a-string-to-associative-array
		
		//inline
		//image
		//image gallery
		//video
		//iframe
		
		//TODO attribs
		
		
		return $output;
	}
	
	public function enqueue() {

		wp_enqueue_script('modaal', plugins_url( '/js/dist/modaalAndInitiate.min.js', __FILE__), array('jquery'),'1.0.0',true);
		wp_enqueue_style('modaalcss', plugins_url( '/css/modaal.css', __FILE__));


	}

	/**
	 * Activate Plugin
	 */
	public static function activate()
	{
		// Do nothing
	} // END public static function activate

	/**
	 * Deactivate the plugin
	 */
	public static function deactivate()
	{
		// Do nothing
	} // END public static function deactivate
}

if(class_exists('jhtechModaalPlugin')) {
	register_activation_hook(__FILE__, array( 'jhtechModaalPlugin', 'activate' ));
	register_deactivation_hook(__FILE__, array( 'jhtechModaalPlugin', 'deactivate'));
	
	$jhtechModaalPlugin = new jhtechModaalPlugin();
}
