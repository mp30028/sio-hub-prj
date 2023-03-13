<?php


class OptionsController{
    
    public static function getResponse() {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header('Content-Type: application/json');
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 60');
        header('Access-Control-Allow-Headers: AccountKey,x-requested-with, Content-Type, origin, authorization, accept, client-security-token, host, date, cookie, cookie2');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        echo json_encode("{'result': 'cool'}");
    }
}