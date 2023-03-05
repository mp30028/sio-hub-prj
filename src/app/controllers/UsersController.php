<?php
// namespace siohub\app\controllers;
use siohub\app\db\services\UsersService;

require_once (__DIR__ ."/../db/services/UsersService.php");
require_once (__DIR__ ."/../utils/AppLogger.php");
use siohub\app\utils\AppLogger;

class UsersController{
     private $appLogger;
    
    public function __construct(){
        $this->appLogger = new AppLogger("UsersController");
    }
    
    public function GET($params, $body){
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        $this->appLogger->writeLog("FROM GET: params=" . implode("|", $params));
        $this->appLogger->writeLog("FROM GET: body=" . $body);        
        $usersService = new UsersService();
        if (isset($params[1])){        
            echo json_encode($usersService->findById($params[1]));
        }else{
            echo json_encode($usersService->findAll());
        }
    }
    
    public function POST($params, $body){
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        $this->appLogger->writeLog("FROM POST: params=" . implode("|", $params));
        $this->appLogger->writeLog("FROM POST: body=" . $body);        
        $usersService = new UsersService();
        echo json_encode($usersService->add($body));
    }
    
    public function DELETE($params, $body){
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        $this->appLogger->writeLog("FROM DELETE: params=" . implode("|", $params));
        $this->appLogger->writeLog("FROM DELETE: body=" . $body);
        $usersService = new UsersService();
        echo json_encode($usersService->delete($params[1]));
    }
    
    public function PUT($params, $body){
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        $this->appLogger->writeLog("FROM PUT: params=" .  implode("|", $params));
        $this->appLogger->writeLog("FROM PUT: body=" . $body);
        $usersService = new UsersService();
        echo json_encode($usersService->update($body));
    }
}
?>