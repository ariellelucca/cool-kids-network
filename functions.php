<?php


if (!defined('ABSPATH')) {
    return;
}

require __DIR__ . '/autoloader.php' ;

use CoolKidsNetwork\Classes\RestAPIEndpoints\RestAPIEndpoints;
use CoolKidsNetwork\Classes\CustomRoutes\CustomRoutes;
use CoolKidsNetwork\Classes\CustomRoles\CustomRoles;
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


/**
 * Summary of user_login_success
 * @param mixed $user_login
 * @param mixed $user
 * @return void
 */
function user_login_success($user_login, $user): void {
	\LOGGER->add_entry("User login successful $user_login");
}
add_action( 'wp_login', 'user_login_success', 10, 2 );

// Enqueues Bootstrap and custom js and css files
/**
 * Summary of al_enqueues
 * @return void
 */
function al_enqueues(): void
{
	wp_enqueue_style(
		'bootstrap-style',
		get_stylesheet_directory_uri() . '/assets/bootstrap/css/bootstrap.min.css'
	);

	wp_enqueue_style(
		'bootstrap-reboot',
		get_stylesheet_directory_uri() . '/assets/bootstrap/css/bootstrap-reboot.min.css'
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
		'bootstrap-js',
		get_stylesheet_directory_uri() . '/assets/bootstrap/js/bootstrap.min.js',
		array('jquery'),
		'1.0.0',
		[ 
			'footer' => true,
			'strategy' => 'defer'
		]
	);
}
add_action('wp_enqueue_scripts', 'al_enqueues');

/**
 * Summary of al_register_menus
 * @return void
 */
function al_register_menus(): void
{
	register_nav_menus(array(
		'header-menu' => __('Header Menu', 'cool-kids-network'),
	));
}
add_action('after_setup_theme', 'al_register_menus');

// Sign in page - if the user enters wrong login/pwd, dont redirect to wp-login 
/**
 * Summary of al_redirect_login_fail
 * @return void
 */
function al_redirect_login_fail(): void {
   $referrer = $_SERVER['HTTP_REFERER'];
   if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') ) {
      wp_redirect( $referrer . '?login=failed' );
      exit;
   }
}
add_action( 'wp_login_failed', 'al_redirect_login_fail' );


// When kid logout, redirect to home
/**
 * Summary of al_redirect_after_logout
 * @return never
 */
function al_redirect_after_logout(): never{
	wp_safe_redirect( home_url() );
	exit;
}
add_action('wp_logout','al_redirect_after_logout');

/**
 * Summary of al_user_logout_log
 * @return void
 */
function al_user_logout_log(): void {
	$user = wp_get_current_user();
	LOGGER->add_entry("User ID $user->ID logged out");
}
add_action('clear_auth_cookie', 'al_user_logout_log', 10);


// Preload font CSS file
/**
 * Summary of al_font_preload
 * @param mixed $html
 * @param mixed $handle
 * @return mixed
 */
function al_font_preload( $html, $handle ): mixed{
    if (strcmp($handle, 'theme-fonts') == 0) {
        $html = str_replace("rel='stylesheet'", "rel='preload' as='style' onload='this.rel=\"stylesheet\"'", $html);
    }
    return $html;
}
add_filter( 'style_loader_tag',  'al_font_preload', 10, 2 );

/**
 * Summary of al_login_failed
 * @param mixed $username
 * @param mixed $error
 * @return void
 */
function al_login_failed($username, $error): void{
	LOGGER->add_entry("Login attempt failed for user $username");
	wp_redirect( home_url() . '/?login=failed' );
}
add_action( 'wp_login_failed', 'al_login_failed', 1, 2);