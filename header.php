<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title(); ?></title>
    <link rel="preload" href="<?php echo esc_attr(get_template_directory_uri() . '/assets/img/home-bg.jpg') ?>" as="image" />
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <header>
        <?php include_once 'includes/navbar.php'; ?>
    </header>