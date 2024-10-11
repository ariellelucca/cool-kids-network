<?php

/**
 * This file defines the class for Logger
 */

namespace CoolKidsNetwork\Classes\ActionLogger;

if (!defined('ABSPATH')) {
    die();
}

class ActionLogger {

    protected static $log = null;

    public function __construct() {
        add_action('after_switch_theme', [$this, 'file_checker']);
        add_action('admin_menu', [$this, 'menu_page']);
    }

    // Check if log file exists, if not, creates it
    function file_checker(): void{
        $logFile = get_template_directory() . '/logs/customkidslog.log';

        if (!file_exists($logFile)) {
            touch($logFile);
            $permissions = 0755;
            $this->set_file_permissions($logFile, $permissions);
        }
    }
    function set_file_permissions($file_path, $permissions) {
        if (file_exists($file_path)) {
            if (chmod($file_path, $permissions)) {
                error_log("Changed permissions to $file_path.");
            } else {
                error_log("Failed to change permissions to $file_path.");
            }
        } else {
            error_log("File $file_path does not exists.");
        }
        die();
    }


    // Add a menu page that displays content of log
    function menu_page() {
        add_menu_page(
            'Activity Logs',
            'Activity Logs',
            'manage_options',
            'activity-logs',
            [$this, 'activity_logs_page'],
            'dashicons-edit',
            5
        );
    }

    public function activity_logs_page($message)
    {
        echo '<h2>User activity logs</h2>';
        $logFile = get_template_directory_uri() . '/logs/customkidslog.log';
        $logContents = file_get_contents($logFile);
        echo nl2br($logContents);
    }
}