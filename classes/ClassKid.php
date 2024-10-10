<?php

class ClassKid {

    function getName($currentuser) {
        $firstname = $currentuser->user_firstname;
        return $firstname;
    }

    function getLastname($currentuser) {
        $lastname = $currentuser->user_lastname;
        return $lastname;
    }

    function getEmail($currentuser) {
        $email = $currentuser->user_email;
        return $email;
    }

    function getCountry($currentuser) {
        $user_meta = get_userdata($currentuser->ID);

        $country = $user_meta->country;
        return $country;
    }

    function getRole($currentuser) {
        $user_meta = get_userdata($currentuser->ID);
        $user_roles = $user_meta->roles;
        return $user_roles;
    }
}