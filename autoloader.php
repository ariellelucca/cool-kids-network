<?php
/**
 * This file is responsible for autoloading the files from used classes
 */

if (!defined('ABSPATH')) {
    die();
}

spl_autoload_register(function($classname){

    $classname = substr($classname, strrpos($classname, "\\") + 1);
    $classFile = get_stylesheet_directory() . '/classes/' . $classname . '.php';
    
    if (file_exists($classFile) && !class_exists($classname, false)) {
        error_log("Loading class: $classname from file: $classFile");
        include $classFile;
    }
});
