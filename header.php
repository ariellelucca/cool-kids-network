<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php bloginfo('name'); ?> | <?php is_front_page() ? bloginfo('description') : wp_title(''); ?></title>
    <meta name="description" content="<?php bloginfo('description'); ?>">
    <?php
    if (!is_front_page()) { ?>
        <link rel="preload" as="image" href="<?php echo esc_attr(get_template_directory_uri() . '/assets/img/home-bg.jpg') ?>"  />
    <?php }
    ?>
    <link rel="preload" as="image" href="<?php echo esc_attr(get_template_directory_uri() . '/assets/img/cool-kids-network-high-resolution-logo-transparent.png') ?>"  />

    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <header>
        <?php include_once 'includes/navbar.php'; ?>
    </header>