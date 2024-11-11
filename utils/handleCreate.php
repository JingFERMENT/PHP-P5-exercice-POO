<?php 

function handleCreate($email, $phoneNumber, $name) {
    // name, email and phone number validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.\n";
    } elseif (!preg_match('/^(?:(?:\+33|0)[1-9])(?:[ .-]?\d{2}){4}$/', $phoneNumber)) {
        echo "Invalid phone number format.\n";
    } elseif (!preg_match('/^[A-Za-zÀ-ÿ]{2,}$/', $name)) {
        echo "Invalid name format.It should be only characters and a minimum of 2 characters long!\n";
    } else {
        $contact = new Command();
        $contact->create($name, $email, $phoneNumber);
        echo "Contact created successfully.\n";
    }
}