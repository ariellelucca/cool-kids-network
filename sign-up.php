<?php
/**
 * Custom register page
 */

if (!defined('ABSPATH')) {
    die();
}

// Check if the user is already logged in
if (is_user_logged_in()) {
    // Redirect to the homepage or any other page
    wp_redirect(home_url());
    exit;
}

get_header(); ?>

<main id="sign-up">
    <div class="login-form"> 
        <h1>Join the club! Tell me your best email</h1>
        <form id="register-form" method="post">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div class="form-group">
                <input type="submit" value="Register">
            </div>
        </form>
        <p>Or get back to <a href="/sign-in" title="Link to login page" aria-label="Link to login page">login page</a></p>
        
    </div>
</main>

<?php
get_footer();
?>

<!-- Script added directly on the page, so it wont load when not needed - also allow to create a nonce for REST API -->
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
                        $('.request-response').html('Login created. <a href="/sign-in" title="Sign in page" aria-label="Sign in page">Click here</a> and go to login page');
                        $('input[type=submit]').prop('disabled', false);
                    }
                    else {
                        $('#modal-updated').modal('show');
                        $('.request-response').html('Oooops, something went wrong! Refresh the page and try again.');
                        $('input[type=submit]').prop('disabled', false);
                    }

                    $('#register-form')[0].reset();
                },
                error: function (error) {
                    $('#modal-updated').modal('show');
                    $('.request-response').html('Oooops, something went wrong!');
                }
            });
        });

        $('#modal-close').on('click', function (){
            $('#modal-updated').modal('hide');
        })
    });

</script>