<?php
/**
 * Custom register page
 */

if (!defined('ABSPATH')) {
    die();
}

// Check if the user is already logged in
/* if (is_user_logged_in()) {
    // Redirect to the homepage or any other page
    wp_redirect(home_url());
    exit;
} */

wp_head();

?>
<main id="sign-up">
    <div class="login-form">
        <h2>Join the club! Tell me your best email</h2>
        <form id="register-form" method="post">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div class="form-group">
                <input type="submit" value="Register">
            </div>
        </form>
    </div>
</main>

<?php
get_footer();

?>

<!-- Script added directly on the page, so it wont load when not needed -->
<script>

    jQuery(function ($) {
        var nonce = '<?php echo wp_create_nonce('wp_rest') ?>';

        $('#register-form').on('submit', function (e) {
            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                method: "POST",
                url: '<?php echo get_rest_url(null, 'cool-kids-network/v1/user-register'); ?>',
                headers: { 'X-WP-Nonce': nonce },
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    // Disable button send
                    $('input[type=submit]').prop('disabled', true);
                },
                success: function (response) {
                    if ('User created successfully' === response) {
                        $('#modal-updated').modal('show');
                        $('.request-response').html('Login created. <a href="/sign-in" title="Sign in page" aria-label="Sign in page">Click here</a> and go to signin page');
                    }
                    else {
                        $('#modal-updated').modal('show');
                        $('.request-response').html('Oooops, something went wrong!');
                    }

                    $('#register-form')[0].reset();
                    $('input[type=submit]').prop('disabled', false);
                },
                error: function (error) {
                    $('#modal-updated').modal('show');
                    $('.request-response').html('Oooops, something went wrong!');
                }
            });
        });
    });

</script>