<?php 
require_once(__DIR__.'/../config/init.php');

function handleCreate($email, $phoneNumber, $name) {
    // name, email and phone number validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.\n";
    } elseif (!preg_match(PHONE_PATTERN, $phoneNumber)) {
        echo "Invalid phone number format.\n";
    } elseif (!preg_match(NAME_PATTERN, $name)) {
        echo "Invalid name format.It should be only characters and a minimum of 2 characters long!\n";
    } else {
        $contact = new Command();
        $contact->create($name, $email, $phoneNumber);
        echo "Contact created successfully.\n";
    }
}