<?php

/*
Plugin Name: HootProof Like Box
Plugin URI: bit.ly/hootprooflikebox
Description: Datenschutzfreundliche Like Box für deine Facebook-Page mit optionaler Anzeige der letzten Posts
Version: 1.2.2
Author: Michelle Retzlaff
Author URI: https://hootproof.de
License: GPLv2
Prefix: htprfb
*/

if ( ! defined( 'ABSPATH' ) ) exit;

require_once('Htprfb_Widget.php');

add_action( 'widgets_init', function(){
	register_widget( 'Htprfb_Widget' );
});

// SET CONSTANT FOR PLUGIN PATH
define('HTPRFB_PLUGIN_PATH', plugins_url('/', __FILE__));

add_action( 'plugins_loaded', 'htprfb_load_textdomain' );
function htprfb_load_textdomain() {
  load_plugin_textdomain( 'htprfb_like_box', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' ); 
}

wp_register_style('htprfb_like_box_css', HTPRFB_PLUGIN_PATH.'style.css');
wp_enqueue_style('htprfb_like_box_css');
wp_register_style('htprfb_fontawesome', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css');
wp_enqueue_style('htprfb_fontawesome');


