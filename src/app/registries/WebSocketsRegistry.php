<?php
namespace siohub\app\registries;
require_once (__DIR__ . "/../websockets/WebSocketServer.php");
require_once (__DIR__ . "/../websockets/WebSocketHandler.php");
require_once(__DIR__ . "/../constants/Constants.php");

use siohub\app\websockets\WebSocketServer;
use siohub\app\websockets\WebSocketHandler;
use siohub\app\constants\Constants;
use siohub\app\utils\AppLogger;
use siohub\app\websockets\WebSocketHttpClient;

class WebSocketsRegistry{
    private static ?AppLogger $appLogger = NULL;
    private static ?WebSocketServer $webSocketServerInstance = NULL;
    private static ?WebSocketHttpClient $webSocketHttpClientInstance = NULL;
    
    private static function appLogger(){
        if (is_null(self::$appLogger)) {
            self::$appLogger = new AppLogger(__CLASS__);
        }
        return self::$appLogger;
    }
    
    public static function webSocketServer() {
        self::appLogger()->writeLog("FROM " . __METHOD__ . ": request for instance received");
        
        if (is_null(self::$webSocketServerInstance)) {
            self::appLogger()->writeLog("FROM " . __METHOD__ . ": a new instance of WebSocketServer will be instantiated");
            self::$webSocketServerInstance = new WebSocketServer(new WebSocketHandler(), Constants::DEFAULT_WEBSOCKET_SERVER_PORT, Constants::DEFAULT_HTTP_SERVER_PORT );
        }else{
            self::appLogger()->writeLog("FROM " . __METHOD__ . ": an instance of WebSocketServer already exists. Instantiation will be skipped");
        }
        return self::$webSocketServerInstance;
    }
    
    public static function webSocketHttpClient() {
        self::appLogger()->writeLog("FROM " . __METHOD__ . ": request for instance received");
        
        if (is_null(self::$webSocketHttpClientInstance)) {
            self::appLogger()->writeLog("FROM " . __METHOD__ . ": a new instance of WebSocketHttpClient will be instantiated");
            self::$webSocketHttpClientInstance = new WebSocketHttpClient(Constants::DEFAULT_HTTP_SERVER_URL, Constants::DEFAULT_HTTP_SERVER_PORT );
        }else{
            self::appLogger()->writeLog("FROM " . __METHOD__ . ": an instance of WebSocketHttpClient already exists. Instantiation will be skipped");
        }
        return self::$webSocketHttpClientInstance;
    }
}

