<?php
/**
 * Custom login page
 */

if (is_user_logged_in()) {
    wp_redirect(home_url());
    exit;
}

require __DIR__ . '/autoloader.php' ;

get_header(); ?>

<main id="sign-in">
    <div class="login-form">
        <h1>Get in, kid!</h1>
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