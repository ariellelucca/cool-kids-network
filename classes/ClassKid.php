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
        if (!empty($currentuser->user_firstname)) {
            $firstname = $currentuser->user_firstname;
            return $firstname;
        }
        return '';
    }

    function getLastname($currentuser) {
        if (!empty($currentuser->user_lastname)) {
            $user_lastname = $currentuser->user_lastname;
            return $user_lastname;
        }
        return '';
    }

    function getEmail($currentuser) {
        if (!empty($currentuser->user_email)) {
            $user_email = $currentuser->user_email;
            return $user_email;
        }
        return '';
    }

    function getCountry($currentuser) {
        $user_meta = get_userdata($currentuser->ID);
        if (!empty($user_meta)) {
            $country = $user_meta->country;
            return $country;
        }
        return '';
    }

    function getRole($currentuser) {
        $user_meta = get_userdata($currentuser->ID);
        $user_roles = $user_meta->roles;
        return $user_roles;
    }
}