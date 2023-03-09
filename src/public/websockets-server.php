<?php

require_once (__DIR__ ."/../app/registries/WebSocketsRegistry.php");

use siohub\app\registries\WebSocketsRegistry;

WebSocketsRegistry::webSocketServer()->startServer();