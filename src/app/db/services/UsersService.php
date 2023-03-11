<?php
namespace siohub\app\db\services;
use PDO as PDO;
use JMS\Serializer\SerializerBuilder as SerializerBuilder;
use siohub\app\entities\User;
use siohub\app\utils\AppLogger;
use siohub\app\db\events\DbEvent;
// use siohub\app\websockets\WebSocketServer;
use siohub\app\registries\WebSocketsRegistry;
// use siohub\app\registries\DataServicesRegistry;
require_once (__DIR__ . "/../../entities/User.php");


class UsersService{
    private AppLogger $appLogger;
    private const FIND_ALL_QUERY = "SELECT * FROM t_user";
    private const FIND_BY_ID_QUERY = "SELECT * FROM t_user WHERE id = :id";
    private const ADD_NEW_QUERY = "INSERT INTO t_user(lastname, firstname, email, username, password) VALUES (:lastname, :firstname, :email, :username, :password)";
    private const DELETE_QUERY = "DELETE FROM t_user WHERE id = :id";
    private const UPDATE_QUERY = "UPDATE t_user SET lastname = :lastname, firstname = :firstname, email = :email, username = :username, password = :password  WHERE id = :id";
    private PDO $connection;

    
    public function __construct(PDO $connection){
        $this->appLogger = new AppLogger("UsersService");
        $this->isTimedEventRunning = false;
        $this->connection = $connection;
    }
    
    public function findAll(){         
        $user = new User();
        $statement = $this->connection->query(UsersService::FIND_ALL_QUERY);
        $statement->setFetchMode(PDO::FETCH_INTO, $user);        
        $statement->execute();
        $fetchResult = $statement->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, get_class($user));
//         $event = new DbEvent(uniqid(),DbEvent::READ,$fetchResult);
//         WebSocketsRegistry::webSocketHttpClient()->sendMessage(json_encode($event));
        return $fetchResult;
    }
    
    public function findById(int $userId) : User{
        $this->appLogger->writeLog("FROM findById: userId =" . $userId);
        $user = new User();
        $statement = $this->connection->prepare(UsersService::FIND_BY_ID_QUERY);
        $statement->bindParam('id', $userId, PDO::PARAM_INT);
        $statement->setFetchMode(PDO::FETCH_INTO, $user);
        $statement->execute();
        $fetchResult = $statement->fetch();
//         $event = new DbEvent(uniqid(),DbEvent::READ,[$fetchResult]);
//         WebSocketsRegistry::webSocketHttpClient()->sendMessage(json_encode($event));
        return $fetchResult;
    }
    
    public function add(string $userJson) : User{
        $serializer = SerializerBuilder::create()->build();
        $user = new User();
        $user = $serializer->deserialize($userJson, get_class($user), 'json');
        $statement = $this->connection->prepare(UsersService::ADD_NEW_QUERY);
        $statement->bindParam('lastname', $user->lastname, PDO::PARAM_STR);
        $statement->bindParam('firstname', $user->firstname, PDO::PARAM_STR );
        $statement->bindParam('email', $user->email, PDO::PARAM_STR);
        $statement->bindParam('username', $user->username, PDO::PARAM_STR);
        $statement->bindParam('password', $user->password, PDO::PARAM_STR);
        $statement->execute();
        $newId = $this->connection->lastInsertId();
        $user->id = $newId;
        $this->appLogger->writeLog("inserted user = " . json_encode($user));
        $event = new DbEvent(uniqid(),DbEvent::CREATE,[$user]);
        WebSocketsRegistry::webSocketHttpClient()->sendMessage(json_encode($event));
        return $user;
    }
    
    public function delete(int $userId) : bool{
        $user = $this->findById($userId);
        $this->appLogger->writeLog("user-id of user to be deleted = " . $userId);
        $statement = $this->connection->prepare(UsersService::DELETE_QUERY);
        $statement->bindParam('id', $userId, PDO::PARAM_INT);
        $statement->execute();
        $event = new DbEvent(uniqid(),DbEvent::DELETE,[$user]);
        WebSocketsRegistry::webSocketHttpClient()->sendMessage(json_encode($event));
        return TRUE;
    }
    
    public function update(string $userJson) : User{
        $serializer = SerializerBuilder::create()->build();
        $user = new User();
        $user = $serializer->deserialize($userJson, get_class($user), 'json');
        $statement = $this->connection->prepare(UsersService::UPDATE_QUERY);
        $statement->bindParam('id', $user->id, PDO::PARAM_INT);
        $statement->bindParam('lastname', $user->lastname, PDO::PARAM_STR);
        $statement->bindParam('firstname', $user->firstname, PDO::PARAM_STR );
        $statement->bindParam('email', $user->email, PDO::PARAM_STR);
        $statement->bindParam('username', $user->username, PDO::PARAM_STR);
        $statement->bindParam('password', $user->password, PDO::PARAM_STR);
        $statement->execute();
        $event = new DbEvent(uniqid(),DbEvent::UPDATE,[$user]);
        WebSocketsRegistry::webSocketHttpClient()->sendMessage(json_encode($event));
        return $user;
    }
    
}

