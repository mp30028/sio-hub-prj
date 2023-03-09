<?php
namespace siohub\app\websockets;
require (__DIR__ ."/../../../vendor/autoload.php");
require_once (__DIR__ ."/../utils/AppLogger.php");

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use siohub\app\utils\AppLogger;

class WebSocketServer{

    private AppLogger $appLogger;
    private IoServer $server;
    private int $port;
    private WebSocketHandler $handler;
    
    public function __construct(WebSocketHandler $handler, int $port){
        $this->port = $port;
        $this->handler = $handler;
        $this->appLogger = new AppLogger("WebSocketServer");
        $this->appLogger->writeLog("Logger instantiated. Instantiating Web Server");
        $this->server = IoServer::factory(
            new HttpServer(
                new WsServer($this->handler)
            ),
            $this->port
            );        
        $this->appLogger->writeLog("FROM Constructor: Web Server Instantiated and will listen on port {$this->port} when started");
    }
    
    public function sendMessage(string $message) {
        $this->appLogger->writeLog("FROM " . __METHOD__ . ": Sever listening on port {$this->port} received message \"{$message}\" to send");
        $this->handler->sendMessage($message);
    }
    
    public function startServer(){
        $this->appLogger->writeLog("FROM " . __METHOD__ . ": Web Server listening on port {$this->port} started and should be running");
        $this->server->run();
        $this->appLogger->writeLog("FROM " . __METHOD__ . ": Web Server listening on port {$this->port} has stopped running");
    }
}

