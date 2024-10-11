<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php bloginfo('name'); ?> | <?php is_front_page() ? bloginfo('description') : wp_title(''); ?></title>
    <?php if (!empty(bloginfo('description'))) { ?>
        <meta name="description" content="<?php bloginfo('description'); ?>">
    <?php } else { ?>
        <meta name="description" content="<?php bloginfo('name'); ?> | <?php is_front_page() ? bloginfo('description') : wp_title(''); ?>">
    <?php } ?>
    <?php
    if (!is_front_page()) { ?>
        <?php if (file_exists(get_template_directory() . '/assets/img/home-bg.jpg')) { ?>
            <link rel="preload" as="image" href="<?php echo esc_attr(get_template_directory_uri() . '/assets/img/home-bg.jpg') ?>"  />
        <?php } ?>
    <?php }
    ?>
    <?php if (file_exists(get_template_directory() . '/assets/img/cool-kids-network-high-resolution-logo-transparent.png')) { ?>
        <link rel="preload" as="image" href="<?php echo esc_attr(get_template_directory_uri() . '/assets/img/cool-kids-network-high-resolution-logo-transparent.png') ?>"  />
    <?php } ?>

    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <header>
        <?php if (file_exists(get_template_directory() . '/includes/navbar.php')) {
            include_once get_template_directory() . '/includes/navbar.php';
        } ?>
    </header>