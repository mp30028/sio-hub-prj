<?php
namespace siohub\app\websockets;
require (__DIR__ ."/../../../vendor/autoload.php");
require_once (__DIR__ ."/../../app/utils/AppLogger.php");
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use SplObjectStorage;
use siohub\app\utils\AppLogger;

class WebSocketHandler implements MessageComponentInterface{

    private SplObjectStorage $clients;
    private AppLogger $appLogger;
    
    public function __construct(){
        $this->appLogger = new AppLogger(__CLASS__);
        $this->clients = new SplObjectStorage;       
    }
    
    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
        $this->appLogger->writeLog("FROM " . __METHOD__ . ": A new client with id {$conn->resourceId} has successfully connected");
    }
    
    public function onMessage(ConnectionInterface $from, $message) { 
        $numberOfClients = count($this->clients);
        $this->appLogger->writeLog("FROM " . __METHOD__ . ": Client with id {$from->resourceId} sent the following messsage \"{$message}\" to " . ($numberOfClients - 1) . " other clients");        
        foreach ($this->clients as $client) {
            if ($from !== $client) {
                $client->send($message);
            }
        }
    }
    
    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
        $this->appLogger->writeLog("FROM " . __METHOD__ . ": Client with id {$conn->resourceId} has disconnected");
    }
    
    public function onError(ConnectionInterface $conn, \Exception $e) {
        $this->appLogger->writeLog("FROM " . __METHOD__ . ": Something has gone wrong. \n {$e->getMessage()} \n ");
    }
    
    public function sendMessage(string $message){
        $clientIds = "";
        foreach ($this->clients as $client) {            
            $client->send($message);
            $clientIds = $clientIds . " " . $client->resourceId;
        }
        $this->appLogger->writeLog("FROM " . __METHOD__ . ": The message, \" {$message} \", was sent to the following clients, {$clientIds}" );
    }
    
}

