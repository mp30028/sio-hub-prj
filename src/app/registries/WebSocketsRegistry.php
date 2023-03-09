<?php
namespace siohub\app\registries;
require_once (__DIR__ . "/../websockets/WebSocketServer.php");
require_once (__DIR__ . "/../websockets/WebSocketHandler.php");
require_once(__DIR__ . "/../constants/Constants.php");

use siohub\app\websockets\WebSocketServer;
use siohub\app\websockets\WebSocketHandler;
use siohub\app\constants\Constants;

class WebSocketsRegistry{
    private static $webSocketServerInstance;
    
    public static function webSocketServer() {
        if (!self::$webSocketServerInstance) {
            self::$webSocketServerInstance = new WebSocketServer(new WebSocketHandler(), Constants::DEFAULT_WEBSOCKET_SERVER_PORT );
        }
        return self::$webSocketServerInstance;
    }
}

