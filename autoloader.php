<?php

if (!defined('ABSPATH')) {
    die();
}

spl_autoload_register(function($class) {
    include get_stylesheet_directory() . '/classes/' . str_replace('\\', '/', $class) . '.php';
});