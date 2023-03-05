<?php declare(strict_types=1);
namespace siohub\app\entities;
use siohub\app\constants\Constants;
require(__DIR__ . "/../constants/Constants.php");

class User{   
    public int $id;
    public string $lastname;
    public string $firstname;
    public string $email;
    public string $username;
    public string $password;
    
    function __construct($id=Constants::UNDEFINED_ENTITY_ID, $lastname="not-set", $firstname="not-set", $email="not-set", $username="not-set", $password="not-set") {
        $this->id = $id;
        $this->lastname = $lastname;
        $this->firstname = $firstname;
        $this->email=$email;
        $this->username=$username;
        $this->password=$password;
        
    }
    
}

