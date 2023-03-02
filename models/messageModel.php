<?php

class MessageModel{
    public int $id_message;
    public string $content;
    public ?string $company;
    public string $firstname;
    public string $datetime;
    public string $email;
    public string $lastname;
    public string $object;
    public ?string $phone;

    
    public function displayDate(){
        $dateTime = DateTime::createFromFormat("Y-m-d",$this->datetime);
        return $dateTime->format("d-m-Y");
    }
}


?>