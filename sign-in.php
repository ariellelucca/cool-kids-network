<?php
/**
 * Custom login page
 */

if (is_user_logged_in()) {
    wp_redirect(home_url());
    exit;
}

require __DIR__ . '/autoloader.php' ;

use CoolKidsNetwork\Classes\ClassKid\ClassKid;
$kid = new ClassKid;

$current_user = wp_get_current_user();
$name = $kid->getName($current_user);
$lastname = $kid->getLastname($current_user);
$country = $kid->getCountry($current_user);
$email = $kid->getEmail($current_user);
$role = $kid->getRole($current_user);
$rolelist = '';

if (is_array($role)) {
    foreach ($role as $ro) {
        $ro = str_replace('_', ' ', $ro);
        $rolelist .= "$ro ";
    }
}

get_header(); ?>

<main id="sign-in">
    <div class="login-form">
        <h2>Get in, kid!</h2>
        <?php
        // Display the login form
        wp_login_form(array(
            'redirect' => home_url(), // Redirect to home page after login
            'label_username' => __('Username', 'custom-kid-roles'),
            'label_password' => __('Password'),
            'label_remember' => __('Remember Me'),
            'label_log_in' => __('Log In'),
            'remember' => true
        ));
        ?>

    </div>
    <div class="register-form">
        <h2>Not a cool member yet? <a href="/sign-up" title="Go to signup page" aria-label="Go to signup page">Join us!</a></h2>
    </div>

</main>

<?php
get_footer();
?>