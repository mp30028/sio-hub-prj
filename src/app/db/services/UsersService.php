<?php
namespace siohub\app\db\services;
use PDO as PDO;
use JMS\Serializer\SerializerBuilder as SerializerBuilder;
use siohub\app\db\connection\DbConnection;
use siohub\app\entities\User;
use siohub\app\utils\AppLogger;
require(__DIR__ . "/../connection/DbConnection.php");
require(__DIR__ . "/../../entities/User.php");


class UsersService{
    private AppLogger $appLogger;
    private const FIND_ALL_QUERY = "SELECT * FROM t_user";
    private const FIND_BY_ID_QUERY = "SELECT * FROM t_user WHERE id = :id";
    private const ADD_NEW_QUERY = "INSERT INTO t_user(lastname, firstname, email, username, password) VALUES (:lastname, :firstname, :email, :username, :password)";
    private const DELETE_QUERY = "DELETE FROM t_user WHERE id = :id";
    private const UPDATE_QUERY = "UPDATE t_user SET lastname = :lastname, firstname = :firstname, email = :email, username = :username, password = :password  WHERE id = :id";
    private $connection;
    
    public function __construct(){
        $this->appLogger = new AppLogger("UsersService");
    }
    
    private function checkAndGetConnection(){
        if (is_null($this->connection)){
            $dbConnection = new DbConnection();
            $this->connection = $dbConnection->getConnection();
        }
        return $this->connection;
    }
    
    public function findAll(){
        $conn = $this->checkAndGetConnection();         
        $user = new User();
        $statement = $conn->query(UsersService::FIND_ALL_QUERY);
        $statement->setFetchMode(PDO::FETCH_INTO, $user);        
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, get_class($user));
    }
    
    public function findById($userId){
        $this->appLogger->writeLog("FROM findById: userId =" . $userId);
        $conn = $this->checkAndGetConnection();
        $user = new User();
        $statement = $conn->prepare(UsersService::FIND_BY_ID_QUERY);
        $statement->bindParam('id', $userId, PDO::PARAM_INT);
        $statement->setFetchMode(PDO::FETCH_INTO, $user);
        $statement->execute();
        return $statement->fetch();
    }
    
    public function add($userJson){
        $conn = $this->checkAndGetConnection();
        $serializer = SerializerBuilder::create()->build();
        $user = new User();
        $user = $serializer->deserialize($userJson, get_class($user), 'json');
        $statement = $conn->prepare(UsersService::ADD_NEW_QUERY);
        $statement->bindParam('lastname', $user->lastname, PDO::PARAM_STR);
        $statement->bindParam('firstname', $user->firstname, PDO::PARAM_STR );
        $statement->bindParam('email', $user->email, PDO::PARAM_STR);
        $statement->bindParam('username', $user->username, PDO::PARAM_STR);
        $statement->bindParam('password', $user->password, PDO::PARAM_STR);
        $statement->execute();
        $newId = $conn->lastInsertId();
        $user->id = $newId;
        $this->appLogger->writeLog("inserted user = " . json_encode($user));
        return $user;
    }
    
    public function delete($userId){
        $conn = $this->checkAndGetConnection();
        $this->appLogger->writeLog("user-id of user to be deleted = " . $userId);
        $statement = $conn->prepare(UsersService::DELETE_QUERY);
        $statement->bindParam('id', $userId, PDO::PARAM_INT);
        $statement->execute();
        return TRUE;
    }
    
    public function update($userJson){
        $conn = $this->checkAndGetConnection();
        $serializer = SerializerBuilder::create()->build();
        $user = new User();
        $user = $serializer->deserialize($userJson, get_class($user), 'json');
        $statement = $conn->prepare(UsersService::UPDATE_QUERY);
        $statement->bindParam('id', $user->id, PDO::PARAM_INT);
        $statement->bindParam('lastname', $user->lastname, PDO::PARAM_STR);
        $statement->bindParam('firstname', $user->firstname, PDO::PARAM_STR );
        $statement->bindParam('email', $user->email, PDO::PARAM_STR);
        $statement->bindParam('username', $user->username, PDO::PARAM_STR);
        $statement->bindParam('password', $user->password, PDO::PARAM_STR);
        $statement->execute();
        return $user;
    }
}

