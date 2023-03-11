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
    
    function __construct(int $id=Constants::UNDEFINED_ENTITY_ID, string $lastname="", string $firstname="", string $email="", string $username="", string $password="") {
        $this->id = $id;
        $this->lastname = $lastname;
        $this->firstname = $firstname;
        $this->email=$email;
        $this->username=$username;
        $this->password=$password;
        
    }
    
}

