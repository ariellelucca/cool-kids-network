<?php

/**
 * Template for front page
 */

if (!is_user_logged_in()) {
    wp_redirect('/sign-in/');
    exit;
} 

get_header(); ?>

<main id="primary" class="site-main">
    <div id="content">
        <?php the_content(); ?>        
    </div>
</main>

<?php get_footer(); ?>