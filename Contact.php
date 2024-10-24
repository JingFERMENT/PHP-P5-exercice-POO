<?php

class Contact {
    private ?int $id;
    private ?string $name;
    private ?string $email;
    private ?string $phone_number;


    // public function __construct(?int $id,?string $name,?string $email,?string $phone_number) {
    //     $this->id = $id;
    //     $this->name = $name;
    //     $this->email = $email;
    //     $this->phone_number = $phone_number;
    // }
    
        
   //*************** ID ***************//
    public function getId():?int
    {
        return $this->id;
    }

    public function setId(?int $id):void
    {
        $this->id = $id;
    }

    //*************** NAME ***************// 
    public function getName():?string
    {
        return $this->name;
    }

    public function setName(?string $name):void
    {
        $this->name = $name;

    }
    
    //*************** EMAIL***************//  
    public function getEmail(): ?string
    {
        return $this->email;
    }
 
    public function setEmail(?string $email):void
    {
        $this->email = $email;
    }

    //*************** PHONE NUMBER ***************// 
    public function getPhoneNumber():?string
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(?string $phone_number):void
    {
        $this->phone_number = $phone_number;

    }

    public function toString(): string {
        
        return $this->id.','. $this->name.','.$this->email.','.$this->phone_number;
    }

}