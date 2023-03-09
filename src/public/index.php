<?php
use siohub\app\registries\ControllersRegistry as Registry;
use siohub\app\utils\AppLogger;
require_once (__DIR__ ."/../app/utils/AppLogger.php");
require_once (__DIR__ . "/../app/registries/ControllersRegistry.php");
    $appLogger = new AppLogger("index_php");
    Registry::frontController()->handleRequest();
    $appLogger->writeLog("FROM index.php: FrontController successfully invoked");
?>