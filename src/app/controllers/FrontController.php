<?php
namespace siohub\app\controllers;    
use Exception;
use siohub\app\utils\AppLogger;

  class FrontController {
    private $appLogger;

    public function __construct(){
        $this->appLogger = new AppLogger(__CLASS__);
    }
    
    public function handleRequest(){        
        $controllerInstance = NULL;
        $requestedResourceName = 'home';
        $requestMethod = 'GET';
        $requestParams = [];
        $requesBody = '';
        $this->appLogger->writeLog("FROM " . __METHOD__ . ". AT-START: requestMethod=" . $requestMethod . ", requestParams=[" . implode(" | ", $requestParams) . "]");
        $requestMethod = $this->extractHttpMethod();
        $parsedUrl = $this->parseUrl();
        $requestedResourceName = $this->extractResourceName($parsedUrl);
        $controllerInstance = $this->instantiateController($requestedResourceName);
        $requestParams = $this->extractUrlParameters($parsedUrl);
        $requesBody = $this->extractBody();
        $this->forwardRequest($controllerInstance, $requestMethod, $requestParams, $requesBody);
        $this->appLogger->writeLog("FROM " . __METHOD__ . ". AT-END: requestMethod=" . $requestMethod . ", requestParams=[" . implode(" | ", $requestParams) . "]");        
    }

    private function extractHttpMethod(){
        if(isset($_SERVER['REQUEST_METHOD'])){
            $trimmedMethod = rtrim($_SERVER['REQUEST_METHOD'], '/');
            $cleanedMethod = filter_var($trimmedMethod, FILTER_SANITIZE_SPECIAL_CHARS);
            return $cleanedMethod;
        }else{
            return "GET";
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

    private function extractResourceName($parsedUrl){
        $resourceName = $parsedUrl[0];
        unset($parsedUrl[0]);
        return $resourceName;
    }
    
    private function instantiateController($resourceName){
        $controllerInstance = NULL;
        try {
            $controllerFactory = 'siohub\\app\\registries\\ControllersRegistry::' . $resourceName . 'Controller';
            $controllerInstance = $controllerFactory();
        } catch (\Exception|\Throwable $e) {
            $this->appLogger->writeLog("FROM " . __METHOD__ . ": EXCEPTION THROWN {$e->getMessage()}");
            $this->appLogger->writeLog("FROM " . __METHOD__ . ": request will be forwarded to HomeController due to the exception");
            $controllerFactory = 'siohub\\app\\registries\\ControllersRegistry::homeController';
            $controllerInstance =  $controllerFactory();
        }
        return $controllerInstance;
    }
    
    private function extractUrlParameters($parsedUrl){
        $this->appLogger->writeLog("FROM " . __METHOD__ . ": parsedUrl = " . implode("|", $parsedUrl));
        $params = $parsedUrl ? array_values($parsedUrl) : [];
        $this->appLogger->writeLog("FROM " . __METHOD__ . ": params = " . implode("|", $params));
        $this->appLogger->writeLog("FROM " . __METHOD__ . ": params-is-array = " . is_array($params) );
        return $params;
    }
    
    private function extractBody(){
        $body = file_get_contents('php://input');
        return $body;    
    }
    
    private function forwardRequest($controllerInstance, $requestMethod, $requestParams, $requestBody){
        $this->appLogger->writeLog("FROM " . __METHOD__ . ": requestMethod=" . $requestMethod . ", requestParams=" . implode("|", $requestParams) . ", requestBody=" . $requestBody);
        $controllerInstance->$requestMethod($requestParams, $requestBody);
    }
  } 
  