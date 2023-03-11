<?php
namespace siohub\app\registries;
require_once (__DIR__ . "/../controllers/FrontController.php");
require_once (__DIR__ . "/../controllers/UsersController.php");

use siohub\app\controllers\FrontController;
use siohub\app\controllers\UsersController;
use siohub\app\controllers\HomeController;

class ControllersRegistry{
    
    private static $frontControllerInstance;
    private static $usersControllerInstance;
    private static $homeControllerInstance;
    
    public static function frontController() {
        if (!self::$frontControllerInstance) {
            self::$frontControllerInstance = new FrontController();
        }        
        return self::$frontControllerInstance;
    }
    
    public static function homeController() {
        if (!self::$homeControllerInstance) {
            self::$homeControllerInstance = new HomeController();
        }
        return self::$homeControllerInstance;
    }
    
    public static function usersController() {
        if (!self::$usersControllerInstance) {
            self::$usersControllerInstance = new UsersController(DataServicesRegistry::usersService());
        }
        return self::$usersControllerInstance;
    }
}

