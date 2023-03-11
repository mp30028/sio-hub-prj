<?php
namespace siohub\app\registries;
require_once (__DIR__ . "/../db/services/UsersService.php");
require_once (__DIR__ . "/../db/connection/DbConnection.php");

use siohub\app\db\connection\DbConnection;
use siohub\app\db\services\UsersService;

class DataServicesRegistry{
    private static $connectionInstance;
    private static $usersServiceInstance;
    
    private static function connection() : \PDO{
        if (!self::$connectionInstance) {
            self::$connectionInstance = (new DbConnection())->getConnection();
        }
        return self::$connectionInstance;
    }
    
    public static function usersService() : UsersService {
        if (!self::$usersServiceInstance) {
            self::$usersServiceInstance = new UsersService(self::connection());
        }
        return self::$usersServiceInstance;
    }
}

