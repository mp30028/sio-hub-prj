<?php

class HomeController{
    private const MESSAGE = 
        array('message' => 'Request reached the application successfully. ' . 
                            'However the resources requested are not valid. ' . 
                            'Check that the URL is correct and that you are ' . 
                            'authorized to request the resource.');
    public function GET(){
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");        
        echo json_encode(HomeController::MESSAGE);
    }
}
?>