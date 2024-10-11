<?php


if (!defined('ABSPATH')) {
    return;
}

require __DIR__ . '/autoloader.php' ;

use CoolKidsNetwork\Classes\RestAPIEndpoints\RestAPIEndpoints;
use CoolKidsNetwork\Classes\CustomRoutes\CustomRoutes;
use CoolKidsNetwork\Classes\NewUserRegister\NewUserRegister; 
use CoolKidsNetwork\Classes\ActionLogger\ActionLogger;
use CoolKidsNetwork\Classes\Logger\Logger;

// Instantiate logger
$logger = new ActionLogger;

const LOGGER = new Logger();


// Create new routes
$customRoutes = new CustomRoutes;

// Test Endpoints
$customEndpoints = new RestAPIEndpoints;

// Handle user registry
$userRegister = new NewUserRegister;
$userRegister->register_routes();

add_action( 'wp_login', 'user_login_success', 10, 2 );

function user_login_success($user_login, $user): void {
	\LOGGER->add_entry("User login successful $user_login");
}


// Enqueues Bootstrap and custom js and css files
function al_enqueues()
{
	wp_enqueue_style(
		'bootstrap-style',
		get_stylesheet_directory_uri() . '/assets/bootstrap/css/bootstrap.min.css'
	);

	wp_enqueue_style(
		'bootstrap-reboot',
		get_stylesheet_directory_uri() . '/assets/bootstrap/css/bootstrap-reboot.min.css'
	);

	wp_enqueue_script(
		'bootstrap-js',
		get_stylesheet_directory_uri() . '/assets/bootstrap/js/bootstrap.min.js',
		array('jquery')
	);

	wp_enqueue_style(
		'theme-style',
		get_stylesheet_directory_uri() . '/assets/css/style.min.css',
	);

	wp_enqueue_style(
		'theme-fonts',
		get_stylesheet_directory_uri() . '/assets/css/fonts.min.css',
	);

	wp_enqueue_script(
		'theme-js',
		get_stylesheet_directory_uri() . '/assets/js/scripts.js',
		array('jquery')
	);
}
add_action('wp_enqueue_scripts', 'al_enqueues');

function al_register_menus()
{
	register_nav_menus(array(
		'header-menu' => __('Header Menu', 'cool-kids-network'),
	));
}
add_action('after_setup_theme', 'al_register_menus');

// Sign in page - if the user enters wrong login/pwd, dont redirect to wp-login 
function al_redirect_login_fail( $username ) {
   $referrer = $_SERVER['HTTP_REFERER'];  // where did the post submission come from?
   // if there's a valid referrer, and it's not the default log-in screen
   if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') ) {
      wp_redirect( $referrer . '?login=failed' );  // let's append some information (login=failed) to the URL for the theme to use
      exit;
   }
}
add_action( 'wp_login_failed', 'al_redirect_login_fail' );  // hook failed login


// When kid logout, redirect to home
function al_redirect_after_logout(){
	wp_safe_redirect( home_url() );
	exit;
}
add_action('wp_logout','al_redirect_after_logout');

function al_user_logout_log() {
	$user = wp_get_current_user();
	LOGGER->add_entry("User ID $user->ID logged out");
}
add_action('clear_auth_cookie', 'al_user_logout_log', 10);


// Preload font CSS file
function al_font_preload( $html, $handle ){
    if (strcmp($handle, 'theme-fonts') == 0) {
        $html = str_replace("rel='stylesheet'", "rel='preload' as='style' onload='this.rel=\"stylesheet\"'", $html);
    }
    return $html;
}
add_filter( 'style_loader_tag',  'al_font_preload', 10, 2 );

function al_login_failed($username, $error){
	LOGGER->add_entry("Login attempt failed for user $username");
	wp_redirect( home_url() . '/?login=failed' );
}
add_action( 'wp_login_failed', 'al_login_failed', 1, 2);