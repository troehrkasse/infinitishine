<?php
if ( ! defined( 'ABSPATH' ) )  exit;

if(defined('WP_CLI') && WP_CLI) return;

/**
 * This file initiates and setup infinitishine Custom theme.
 *
 * infinitishine is a custom theme developed by {@author}. infinitishine comes with the following pre-packaged plugins: Custom Review Items Plugin (CRIP), Timber
 *
 * @author RADD Web Studio <developer@raddwebstudio.com>
 * @package infinitishine
 *
 * @version 1.0.0	
 */


/** Global Variables */
if(!defined('infinitishine_DIR')){
	/**
	* Theme's full top system path
	*/
	define('infinitishine_DIR', trailingslashit(get_template_directory() ));
}

if(!defined('infinitishine_URI')){
	/**
	* Theme's full top system path
	*/
	define('infinitishine_URI', trailingslashit(get_stylesheet_directory_uri()));
}


if(!defined('infinitishine_FRAMEWORK_URI')){
	/**
	* Theme's full top system path
	*/
	define('infinitishine_FRAMEWORK_URI', infinitishine_URI."framework");
} 

if(!defined('infinitishine_FRAMEWORK_DIR')){
	/**
	* Theme's full top system path
	*/
	define('infinitishine_FRAMEWORK_DIR', infinitishine_DIR."framework" );
}


if(!defined('infinitishine_ASSETS_URI')){
	/**
	* Theme's full top system path
	*/
	define('infinitishine_ASSETS_URI', trailingslashit( infinitishine_URI.'assets' ));
} 

if(!defined('infinitishine_ASSETS_DIR')){
	/**
	* Theme's full top system path
	*/
	define('infinitishine_ASSETS_DIR', trailingslashit( infinitishine_DIR."assets") );
}

if(!defined('HOME_URL')){
	/**
	* Wrapper constact for the Wordpress' ({@link http://codex.wordpress.org/Function_Reference/get_home_url})
	*/
	define('HOME_URL', get_home_url()); 
}

if(!defined('infinitishine_VER')){
	$my_theme = wp_get_theme();
	/**
	* Theme's full top system path
	*/
	define('infinitishine_VER', $my_theme->get( 'Version' ) );
}

if(!class_exists('infinitishine')) require_once('infinitishine.php');