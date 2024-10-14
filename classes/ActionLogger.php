<?php

/**
 * This file defines the class for Logger
 */

namespace CoolKidsNetwork\Classes\ActionLogger;

if (!defined('ABSPATH')) {
    die();
}

class ActionLogger {
    private $log_file;

    public function __construct() {
        $this->log_file = get_template_directory() . '/logs/customkidslog.log';

        add_action('after_switch_theme', [$this, 'file_checker']);
        add_action('admin_menu', [$this, 'menu_page']);
    }

    // Check if log file exists, if not, creates it
    public function file_checker()
    {
        if (!file_exists($this->log_file)) {
            if (!is_dir(dirname($this->log_file))) {
                error_log('Log directory does not exist: ' . dirname($this->log_file));
            }

            if (!fopen($this->log_file, 'w')) {
                error_log('Failed to create log file: ' . $this->log_file);
            }

            if (!is_writable(dirname($this->log_file))) {
                error_log('Log directory is not writable: ' . dirname($this->log_file));
            }

            return;
        }

        if (!is_writable($this->log_file)) {
            error_log('Log file is not writable: ' . $this->log_file);
            return;
        }

        error_log('Log file is ready: ' . $this->log_file);
    }


    public function log_message($message)
    {
        if (is_writable($this->log_file)) {
            $current_time = date('Y-m-d H:i:s');
            $log_message = "[$current_time] $message" . PHP_EOL;
            file_put_contents($this->log_file, $log_message, FILE_APPEND);
        } else {
            error_log('Cannot write to log file: ' . $this->log_file);
        }
    }


    // Add a menu page that displays content of log
    function menu_page()
     {
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