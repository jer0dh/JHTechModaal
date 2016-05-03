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
			'type' 				=> 	'inline',  // inline, image, video, iframe. (ajax, confirm, instagram - not implemented yet)
			'button_class' 		=> 	'',
			'button_text'		=>  '',
			'button_image'		=>	'',
			'attribs'			=>  '',
			'inline_config'		=> 	true, // use -data-modaal-*.  If false, must call $().modaal manually with config, especially, if calling js functions for any modaal events
		), $atts));

		if ($inline_config === 'false') {
			$inline_config = false;
		} else {
			$inline_config = true;
		}

		$type = strtolower( $type );
		$options = '';  //markup containing any data-modaal-* options
		$classes = ($inline_config? 'modaal ' : '') . $button_class;

		//attribs to be string that will be converted to assoc. array - list of modaal options to expand to data-modaal-* attributes
		// see: http://stackoverflow.com/questions/14133780/explode-a-string-to-associative-array

		if($attribs != '' && $inline_config ){
			$dataAttribs = array();  //assoc array of modaal options to be put as data-modaal-* attributes in the markup.
			$partial = explode(',', $attribs);
			
			foreach ($partial as $pair) {
				$temp = explode(':', $pair);
				$dataAttribs[ $temp[0] ] = $temp[1];
			}
			if( $type === 'images') $type = 'image';
			$dataAttribs['type'] = $type;

			//Create the data-modaal-* options

			foreach($dataAttribs as $key => $value) {
				$options .= 'data-modaal-' . $key . '="' . $value . '" ';
			}
		}
		//inline
		//image
		//image gallery
		//video
		//iframe
		

		//TODO images #http://stackoverflow.com/questions/138313/how-to-extract-img-src-title-and-alt-from-html-using-php
		if($type === 'image') {
			$imgs = array();
			$doc = new DOMDocument();
			@$doc->loadHTML($content);

			$tags = $doc->getElementsByTagName('img');
			$gallery = 'gallery-' . $modalNum;
			$i=0;
			foreach ($tags as $tag) {
					$output .= '<a href="' . $tag->getAttribute('src') . '" class="'. $classes .'" rel="' . $gallery . '" ' . $options . '>' . ($i==0? $button_text : ''). '</a>';
					$i++;
			}

		} else if($type === 'inline') {
			
		}
		$modalNum++;  // used if shortcode called again in same post or page.
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
