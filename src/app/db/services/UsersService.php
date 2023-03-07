<?php
namespace siohub\app\db\services;
use PDO as PDO;
use JMS\Serializer\SerializerBuilder as SerializerBuilder;
use siohub\app\entities\User;
use siohub\app\utils\AppLogger;
require(__DIR__ . "/../../entities/User.php");


class UsersService{
    private AppLogger $appLogger;
    private const FIND_ALL_QUERY = "SELECT * FROM t_user";
    private const FIND_BY_ID_QUERY = "SELECT * FROM t_user WHERE id = :id";
    private const ADD_NEW_QUERY = "INSERT INTO t_user(lastname, firstname, email, username, password) VALUES (:lastname, :firstname, :email, :username, :password)";
    private const DELETE_QUERY = "DELETE FROM t_user WHERE id = :id";
    private const UPDATE_QUERY = "UPDATE t_user SET lastname = :lastname, firstname = :firstname, email = :email, username = :username, password = :password  WHERE id = :id";
    private $connection;
    private $isTimedEventRunning;
    private $shouldTimedEventRun;
    
    public function __construct($connection){
        $this->appLogger = new AppLogger("UsersService");
        $this->isTimedEventRunning = false;
        $this->connection = $connection;
    }
    
    public function findAll(){         
        $user = new User();
        $statement = $this->connection->query(UsersService::FIND_ALL_QUERY);
        $statement->setFetchMode(PDO::FETCH_INTO, $user);        
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, get_class($user));
    }
    
    public function findById($userId){
        $this->appLogger->writeLog("FROM findById: userId =" . $userId);
        $user = new User();
        $statement = $this->connection->prepare(UsersService::FIND_BY_ID_QUERY);
        $statement->bindParam('id', $userId, PDO::PARAM_INT);
        $statement->setFetchMode(PDO::FETCH_INTO, $user);
        $statement->execute();
        return $statement->fetch();
    }
    
    public function add($userJson){
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
        return $user;
    }
    
    public function delete($userId){
        $this->appLogger->writeLog("user-id of user to be deleted = " . $userId);
        $statement = $this->connection->prepare(UsersService::DELETE_QUERY);
        $statement->bindParam('id', $userId, PDO::PARAM_INT);
        $statement->execute();
        return TRUE;
    }
    
    public function update($userJson){
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
        return $user;
    }
    
//     public function raiseTimedEvents(bool $shouldRun){
//         if ($this->shouldRun != $shouldRun ){
//             $this->shouldRun = $shouldRun;
//         }
//         $this->shouldRun = $shouldRun;
        
//     }
    
//     public function timedEvents($shouldRun){
//         $this->shouldTimedEventRun = $shouldRun;
//         if ($shouldRun){
//             if ($this->isTimedEventRunning == FALSE){
//                 startTimedEvents();
//             }
//         }
//     }
    
//     private function startTimedEvent(){
//             $pid = pcntl_fork();
//             if ($pid == -1) {
//                 die('could not fork');
//             } else if ($pid) {
//                 // we are the parent, do nothing
//             } else {                
//                 $controller  = new UsersController($usersService);                
//                 while ($this->shouldTimedEventRun){
//                     $this->isTimedEventRunning = TRUE;
//                     $time = date('r');
//                     $message = "FROM sendTimedEvents: Event raised at {$time}";
//                     $this->appLogger->writeLog($message);
//                     call_user_func_array([$controller, "streamEvents"], [$message]);
//                     sleep(2);
//                 }
//                 $this->isTimedEventRunning = FALSE;
//             }
//     }
        

        
        
        
        
//         // Set file mime type event-stream
//         header('Content-Type: text/event-stream');
//         header('Cache-Control: no-cache');
        
        // Loop until the client close the stream
//         $controller = new \UsersController();
//         while ($this->shouldRun) {
            
//             // Echo time
//             $time = date('r');
// //             echo "data: The server time is: {$time}\n\n";
//             $message = "FROM sendTimedEvents: Event raised at {$time}";
//             $this->appLogger->writeLog($message);
//             call_user_func_array([$controller, "streamEvents"], [$message]);
            
//             // Flush buffer (force sending data to client)
// //             flush();
            
//             // Wait 2 seconds for the next message / event
//             sleep(2);
//         }
//     }
}

