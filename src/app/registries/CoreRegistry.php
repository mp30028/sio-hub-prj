<?php
namespace siohub\app\registries;

use siohub\app\controllers\FrontController;
use siohub\app\controllers\UsersController;
use siohub\app\db\connection\DbConnection;
use siohub\app\db\services\UsersService;
require_once (__DIR__ . "/../db/services/UsersService.php");
require_once (__DIR__ . "/../db/connection/DbConnection.php");
require_once (__DIR__ . "/../controllers/FrontController.php");
require_once (__DIR__ . "/../controllers/UsersController.php");


class CoreRegistry{
    
    private static $connectionInstance;
    private static $frontControllerInstance;
    private static $usersServiceInstance;
    private static $usersControllerInstance;
        
    public static function connection(){
        if (!self::$connectionInstance) {
            self::$connectionInstance = (new DbConnection())->getConnection();
        }
        return self::$connectionInstance;
    }
    
    public static function frontController() {
        if (!self::$frontControllerInstance) {
            self::$frontControllerInstance = new FrontController();
        }        
        return self::$frontControllerInstance;
    }
    
    public static function usersService() {
        if (!self::$usersServiceInstance) {
            self::$usersServiceInstance = new UsersService(self::connection());
        }
        return self::$usersServiceInstance;
    }
    
    public static function homeService() {
        return NULL;
    }
    
    public static function usersController() {
        if (!self::$usersControllerInstance) {
            self::$usersControllerInstance = new UsersController(self::usersService());
        }
        return self::$usersControllerInstance;
    }
}

