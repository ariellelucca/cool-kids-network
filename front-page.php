<?php

/**
 * Template for front page
 */

if (!is_user_logged_in()) {
    wp_redirect('/sign-in/');
    exit;
}

include __DIR__ . '/autoloader.php';

$current_user = wp_get_current_user();

$kid = new ClassKid;
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


<div id="home-main" class="site-main">
    <div class="container-fluid">
        <div class="row">
            <aside class="col-sm-12 col-md-4 kid-info">
                <div class="container">
                    <h1>Bonjour, <?php echo $rolelist; ?></h1>
                    <ul>
                        <li><strong>Name:</strong> <?php echo wp_kses_post($name) ?></li>
                        <li><strong>Lastname:</strong> <?php echo wp_kses_post($lastname) ?></li>
                        <li><strong>Email:</strong> <?php echo wp_kses_post($email) ?></li>
                        <li><strong>Country:</strong> <?php echo wp_kses_post($country) ?></li>
                    </ul>
                </div>
            </aside>
            <main class="col-sm-12 col-md-8 kid-list">
                <div class="container">
                    <?php
                    if (in_array('cool_kid', $role)) { ?>
                        <p>Want to check other kid's info? Click the button below and become a Cooler Kid!</p>
                        <button type="button" id="upgradeCoolerKid" aria-label="Become a Cooler Kid"
                            name="Become a Cooler Kid">Click me and pay to upgrade</button>
                    <?php }
                    ?>
                    <?php
                    if (in_array('cooler_kid', $role)) { ?>
                        <p>Want to upgrade and be a Coolest Kid and check all other user's info? Click the button below!</p>
                        <button type="button" id="upgradeCoolerKid" aria-label="Become a Cooler Kid"
                            name="Become a Cooler Kid">Click me and pay to upgrade</button>

                    <?php }

                    if (in_array('cooler_kid', $role) || in_array('coolest_kid', $role)) { ?>
                        
                        <?php get_template_part('template-parts/list', 'kids'); ?>
                    <?php }
                    ?>
                </div>
            </main>
        </div>
    </div>

</div>

<?php get_footer(); ?>