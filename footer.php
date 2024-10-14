<footer>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <p>&copy; <?php echo date('Y'); ?> Cool Kids Network. All rights reserved.</p>
                <p class="dev-arielle">Proudly developed by <a href="https://www.linkedin.com/in/arielle-lucca/"
                        title="Arielle Lucca LinkedIn Profile URL"
                        aria-label="Arielle Lucca LinkedIn Profile URL">Arielle</a>
                    <svg fill="#000000" height="14px" width="14px" version="1.1" id="Capa_1"
                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                        viewBox="0 0 471.701 471.701" xml:space="preserve">
                        <g>
                            <path
                                d="M433.601,67.001c-24.7-24.7-57.4-38.2-92.3-38.2s-67.7,13.6-92.4,38.3l-12.9,12.9l-13.1-13.1		c-24.7-24.7-57.6-38.4-92.5-38.4c-34.8,0-67.6,13.6-92.2,38.2c-24.7,24.7-38.3,57.5-38.2,92.4c0,34.9,13.7,67.6,38.4,92.3		l187.8,187.8c2.6,2.6,6.1,4,9.5,4c3.4,0,6.9-1.3,9.5-3.9l188.2-187.5c24.7-24.7,38.3-57.5,38.3-92.4		C471.801,124.501,458.301,91.701,433.601,67.001z M414.401,232.701l-178.7,178l-178.3-178.3c-19.6-19.6-30.4-45.6-30.4-73.3		s10.7-53.7,30.3-73.2c19.5-19.5,45.5-30.3,73.1-30.3c27.7,0,53.8,10.8,73.4,30.4l22.6,22.6c5.3,5.3,13.8,5.3,19.1,0l22.4-22.4		c19.6-19.6,45.7-30.4,73.3-30.4c27.6,0,53.6,10.8,73.2,30.3c19.6,19.6,30.3,45.6,30.3,73.3		C444.801,187.101,434.001,213.101,414.401,232.701z">
                            </path>
                        </g>
                    </svg>
                </p>
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
            jQuery('#modal-close').on('click', function (e) {
                jQuery('.modal').modal('hide');
                location.reload();
            });

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