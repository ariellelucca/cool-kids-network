<?php

/**
 * This file defines the class for basic log functionality
 */

namespace CoolKidsNetwork\Classes\Logger;

if (!defined('ABSPATH')) {
    die();
}

class Logger {

    // Adds a new entry to logfile
    public function add_entry($message)
    {
        $log_file = get_template_directory() . '/logs/customkidslog.log';
        $current_time = date('Y-m-d H:i:s');
        $log_message = "[$current_time] $message" . PHP_EOL;
        $contents = file_put_contents($log_file, $log_message, FILE_APPEND);
        if (!$contents) {
            error_log("Error while writing to $log_file");
        }
    }
}
