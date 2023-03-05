<?php
namespace siohub\app\db\connection;

use PDO as PDO;
use PDOException;

class DbConnection{
//     public $host = '127.0.0.1';
    public $host = '172.17.0.2';
    public $schema   = 'sio_hub_db';
    public $username = 'sio-hub-app';
    public $password = 'P^ssWord*0009';
    public $charset = 'utf8mb4';       
    
    private function getConnectionString(){
        $connectionString = "mysql:host=$this->host;dbname=$this->schema;charset=$this->charset;port=3306";
        return $connectionString;
    }
    
    private $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    
//     public function getConnectionWithDefaultCredentials(){
//         return $this->getConnection($this->username, $this->password);
//     }
    
    public function getConnection(){
        try {
            $pdo = new PDO($this->getConnectionString(), $this->username, $this->password, $this->options);
            return $pdo;
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }
    
}

