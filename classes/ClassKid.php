<?php

/**
 * This file defines the Kid class with basic methods
 */

namespace CoolKidsNetwork\Classes\ClassKid;

if (!defined('ABSPATH')) {
    die();
}


class ClassKid {

    function getName($currentuser) {
        if (empty($currentuser || !$currentuser)) {
            return '';
        }
        
        if (!empty($currentuser->user_firstname)) {
            $firstname = $currentuser->user_firstname;
            return $firstname;
        }
        return '';
    }

    function getLastname($currentuser) {
        if (empty($currentuser || !$currentuser)) {
            return '';
        }
        
        if (!empty($currentuser->user_lastname)) {
            $user_lastname = $currentuser->user_lastname;
            return $user_lastname;
        }
        return '';
    }

    function getEmail($currentuser) {
        if (empty($currentuser || !$currentuser)) {
            return '';
        }
        
        if (!empty($currentuser->user_email)) {
            $user_email = $currentuser->user_email;
            return $user_email;
        }
        return '';
    }

    function getCountry($currentuser) {
        if (empty($currentuser || !$currentuser)) {
            return '';
        }
        $user_meta = get_userdata($currentuser->ID);
        
        if ('0' == $user_meta) {
            return '';
        }
        
        if (!empty($user_meta)) {
            $country = $user_meta->country;
            return $country;
        }
        return '';
    }

    function getRole($currentuser) {
        if (empty($currentuser) || !$currentuser) {
            return '';
        }
        $user_meta = get_userdata($currentuser->ID);
        if ('0' == $user_meta) {
            return '';
        }
        
        $user_roles = $user_meta->roles;
        return $user_roles;
    }
}