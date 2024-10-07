<?php

if (!defined('ABSPATH')) {
    return;
}

include __DIR__ . '/autoloader.php' ;

// Create new roles
$customRoles = new CustomKidRoles;

// Create new routes
$customRoutes = new CustomRoutes;

// Handle user registry
$userRegister = new NewUserRegister;
$userRegister->register_routes();


add_action('wp_enqueue_scripts', 'al_enqueues');
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
		get_stylesheet_directory_uri() . '/assets/css/style.css',
	);

	wp_enqueue_script(
		'theme-js',
		get_stylesheet_directory_uri() . '/assets/js/scripts.min.js',
		array('jquery')
	);
}

function al_register_menus()
{
	register_nav_menus(array(
		'header-menu' => __('Header Menu', 'cool-kids-network'),
	));
}
add_action('after_setup_theme', 'al_register_menus');

function al_theme_setup()
{
	add_theme_support('menus');
	add_theme_support('post-thumbnails', ['posts', 'projects']);
	add_theme_support('widgets');
}
add_action('after_setup_theme', 'al_theme_setup');

function al_register_navwalker()
{
	if (!file_exists(get_template_directory() . '/assets/bootstrap/navwalker.php')) {
		// file does not exist... return an error.
		return new WP_Error('class-wp-bootstrap-navwalker-missing', __('It appears the class-wp-bootstrap-navwalker.php file may be missing.', 'wp-bootstrap-navwalker'));
	} else {
		// file exists... require it.
		require_once get_template_directory() . '/assets/bootstrap/navwalker.php';;
	}
}
add_action('after_setup_theme', 'al_register_navwalker');




// Sign in page - if the user enters wrong login/pwd, dont redirect to wp-login 
add_action( 'wp_login_failed', 'al_redirect_login_fail' );  // hook failed login

function al_redirect_login_fail( $username ) {
   $referrer = $_SERVER['HTTP_REFERER'];  // where did the post submission come from?
   // if there's a valid referrer, and it's not the default log-in screen
   if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') ) {
      wp_redirect( $referrer . '?login=failed' );  // let's append some information (login=failed) to the URL for the theme to use
      exit;
   }
}