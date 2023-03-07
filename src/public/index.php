<?php
use siohub\app\registries\CoreRegistry as Registry;
use siohub\app\utils\AppLogger;
require_once (__DIR__ ."/../app/utils/AppLogger.php");
require_once (__DIR__ . "/../app/registries/CoreRegistry.php");
    $appLogger = new AppLogger("index_php");
    Registry::frontController()->handleRequest();
    $appLogger->writeLog("FROM index.php: FrontController successfully invoked");
?>