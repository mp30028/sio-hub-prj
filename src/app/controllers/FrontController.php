<?php
namespace siohub\app\controllers;    
    use siohub\app\utils\AppLogger;
    require_once (__DIR__ ."/../utils/AppLogger.php");
        
  class FrontController {
    private $appLogger;
    private $selectedControllerName;
    private $selectedController = 'Home';
    private $selectedMethod = 'GET';
    private $params = [];
    private $body = '';
    

    public function __construct(){
        $this->appLogger = new AppLogger("FrontController");
        $this->appLogger->writeLog("FROM Constructor. AT-START: selectedController=" . $this->selectedControllerName . ", selectedMethod=" . $this->selectedMethod . ", parameters=[" . implode(" | ", $this->params) . "]");        
        $this->extractHttpMethod();
        $parsedUrl = $this->parseUrl();
        $this->selectController($parsedUrl);
        $this->extractUrlParameters($parsedUrl);
        $this->extractBody();
        $this->forwardRequest();
        $this->appLogger->writeLog("FROM Constructor. AT-END: selectedController=" . $this->selectedControllerName . ", selectedMethod=" . $this->selectedMethod . ", parameters=[" . implode(" | ", $this->params) . "]");
    }       

    private function extractHttpMethod(){
        if(isset($_SERVER['REQUEST_METHOD'])){
            $trimmedMethod = rtrim($_SERVER['REQUEST_METHOD'], '/');
            $cleanedMethod = filter_var($trimmedMethod, FILTER_SANITIZE_SPECIAL_CHARS);
            $this->selectedMethod =  $cleanedMethod;
        }
    }
    
    private function parseUrl(){
        if (isset($_GET['url'])) {
            $trimmedUrl = rtrim($_GET['url'], '/');
            $cleanedUrl = filter_var($trimmedUrl, FILTER_SANITIZE_URL);
            $parsedUrl = explode('/', $cleanedUrl);
            return $parsedUrl;
        } else {
            return ["Home"];
        }
    }    
    
    private function selectController($parsedUrl){
        $this->selectedControllerName = ucwords($parsedUrl[0]) . 'Controller.php';
        if (file_exists(__DIR__ . '/' . $this->selectedControllerName)) {
            $this->selectedController = ucwords($parsedUrl[0]) . 'Controller';
            unset($parsedUrl[0]);
        }else{
            $this->selectedController = 'HomeController';
            unset($parsedUrl[0]);
        }
        require_once (__DIR__ . '/' . $this->selectedController . '.php');
        $this->selectedController = new $this->selectedController();
    }
    
    private function extractUrlParameters($parsedUrl){
        $this->appLogger->writeLog("FROM extractUrlParameters: parsedUrl = " . implode("|", $parsedUrl));
        $this->params = $parsedUrl ? array_values($parsedUrl) : [];
        $this->appLogger->writeLog("FROM extractUrlParameters: params = " . implode("|", $this->params));
        $this->appLogger->writeLog("FROM extractUrlParameters: params-is-array = " . is_array($this->params) );
    }
    
    private function extractBody(){
            $this->body = file_get_contents('php://input');
    }
    
    private function forwardRequest(){
//         $params = implode("|", $this->params);
        $this->appLogger->writeLog("FROM forwardRequest: selectedController=" . $this->selectedControllerName . ", selectedMethod=" . $this->selectedMethod . ", params=" . implode("|", $this->params) . ", body=" . $this->body);
        call_user_func_array([$this->selectedController, $this->selectedMethod], [$this->params, $this->body]);
    }
  } 
  
  