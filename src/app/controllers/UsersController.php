<?php
namespace siohub\app\controllers;

require_once (__DIR__ ."/../utils/AppLogger.php");
use siohub\app\utils\AppLogger;

class UsersController{
     private $appLogger;
     private $usersService;
    
     public function __construct($usersService){
        $this->appLogger = new AppLogger("UsersController");
        $this->usersService = $usersService;
    }
    
    public function GET($params, $body){
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        $this->appLogger->writeLog("FROM GET: params=" . implode("|", $params));
        $this->appLogger->writeLog("FROM GET: body=" . $body);        
        if (isset($params[1])){
            if ($params[1] == "persistence-events"){
                $shouldRun = TRUE;
//                 if(isset($params[2])){
//                     $shouldRun = $params[2];
//                 }
                $this->usersService->timedEvents($shouldRun);
            }else{
                echo json_encode($this->usersService->findById($params[1]));
            }
        }else{
            echo json_encode($this->usersService->findAll());
        }
    }
    
    public function POST($params, $body){
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        $this->appLogger->writeLog("FROM POST: params=" . implode("|", $params));
        $this->appLogger->writeLog("FROM POST: body=" . $body);        
        echo json_encode($this->usersService->add($body));
    }
    
    public function DELETE($params, $body){
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        $this->appLogger->writeLog("FROM DELETE: params=" . implode("|", $params));
        $this->appLogger->writeLog("FROM DELETE: body=" . $body);
        echo json_encode($this->usersService->delete($params[1]));
    }
    
    public function PUT($params, $body){
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        $this->appLogger->writeLog("FROM PUT: params=" .  implode("|", $params));
        $this->appLogger->writeLog("FROM PUT: body=" . $body);
        echo json_encode($this->usersService->update($body));
    }
}
?>