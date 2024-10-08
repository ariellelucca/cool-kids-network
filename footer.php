<footer>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <p>&copy; <?php echo date('Y'); ?> Cool Kids Network. All rights reserved.</p>
                <p>Proudly developed by <a href="https://www.linkedin.com/in/arielle-lucca/"
                        title="Arielle Lucca LinkedIn Profile URL"
                        aria-label="Arielle Lucca LinkedIn Profile URL">Arielle</a></p>
            </div>
        </div>
    </div>
</footer>

<?php
wp_footer();

// Only displays if current user is admin
if (current_user_can('manage_options') && is_front_page()) { ?>
    <script>
        // Creates nonce for request
        var nonce = '<?php echo wp_create_nonce('wp_rest') ?>';

        jQuery(function ($) {
            // Closes modal
            $('#modal-close').on('click', function () {
                $('.modal').modal('hide');
            })

            // Performs the request to change user role, then shows modal
            $('.upgrade-kid-role').on('click', function (e) {
                e.preventDefault();


                let kid_email = $(this).data('kidemail');
                let new_role = $(this).data('role');

                let dataVals = new FormData();
                dataVals.append('email', kid_email);
                dataVals.append('role', new_role);

                var $this = jQuery(this);

                jQuery.ajax({
                    method: "POST",
                    url: '<?php echo get_rest_url(null, 'ckn/v1/manage-role'); ?>',
                    headers: { 'X-WP-Nonce': nonce },
                    data: dataVals,
                    processData: false,
                    contentType: false,
                    beforeSend: function () {

                    },
                    success: function (response) {
                        $('#modal-updated').modal('show');
                        $('.request-response').html('User role updated!');
                    },
                    error: function (error) {
                        $('#modal-updated').modal('show');
                        $('.request-response').html('Oooops, something went wrong!');
                    }

                });
            });
        });
    </script>
    <?php

} ?>

<div id="modal-updated" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <p class="request-response"></p>
            </div>
            <div class="modal-footer">
                <button type="button" id="modal-close" class="btn btn-secondary">Close</button>
            </div>
        </div>
    </div>
</div>