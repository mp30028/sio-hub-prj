<?php
namespace siohub\app\websockets;
require (__DIR__ ."/../../../vendor/autoload.php");
require_once (__DIR__ ."/../utils/AppLogger.php");

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use siohub\app\utils\AppLogger;
use React\Http\HttpServer as Httpd;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;
use React\Socket\SocketServer;

class WebSocketServer{

    private AppLogger $appLogger;
    private IoServer $server;
    private int $websocketPort;
    private int $httpServerPort;
    private WebSocketHandler $handler;
    
    public function __construct(WebSocketHandler $handler, int $websocketPort, int $httpServerPort){
        $this->websocketPort = $websocketPort;
        $this->httpServerPort = $httpServerPort;
        $this->handler = $handler;
        $this->appLogger = new AppLogger("WebSocketServer");
        $this->instantiateWebsocketServer();
        $this->instantiateHttpServer();
    }
    
    private function instantiateWebsocketServer(){
        $this->appLogger->writeLog("Logger instantiated. Instantiating Web Server");
        $this->server = IoServer::factory(
            new HttpServer(
                new WsServer($this->handler)
                ),
            $this->websocketPort
            );
        $this->appLogger->writeLog("FROM Constructor: Web Server Instantiated and will listen on port {$this->websocketPort} when started");
    }
    
    private function instantiateHttpServer() {
        $http = new Httpd(function (ServerRequestInterface $request) {
            $this->appLogger->writeLog("FROM " . __METHOD__ . ": message received by http-server = {$request->getBody()}");
            $this->sendMessage($request->getBody());
            return Response::plaintext("OK\n");
        });
        $socket = new SocketServer('0.0.0.0:' . $this->httpServerPort);
        $http->listen($socket);
    }
    
    public function sendMessage(string $message) {
        $this->appLogger->writeLog("FROM " . __METHOD__ . ": Sever listening on port {$this->websocketPort} received message \"{$message}\" to send");
        $this->handler->sendMessage($message);
    }
    
    public function startServer(){
        $this->appLogger->writeLog("FROM " . __METHOD__ . ": Web Server listening on port {$this->websocketPort} started and should be running");
        $this->server->run();
        $this->appLogger->writeLog("FROM " . __METHOD__ . ": Web Server listening on port {$this->websocketPort} has stopped running");
    }
}

