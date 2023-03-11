<?php
namespace siohub\app\websockets;
require (__DIR__ ."/../../../vendor/autoload.php");

use React\Http\Browser;
//use React\Http\Client;
use Psr\Http\Message\ResponseInterface;

class WebSocketHttpClient{
        
    private $client;
    private $headers;
    private $url;
    private $port;
    
    public function __construct(string $url="http://localhost", int $port = 82) {
        $this->client = new Browser();
        $this->headers = ['Content-Type' => 'application/json'];
        $this->url = $url;
        $this->port = $port;
    }
    
    public function sendMessage(string $message){
        $this->client
        ->post(
            $this->url . ':' . $this->port . '/',
            $this->headers,
            $message
        )->then(
                function (ResponseInterface $response) {
                    var_dump($response->getHeaders(), (string)$response->getBody());
                },
                function (\Exception $e) {
                    echo 'Error: ' . $e->getMessage() . PHP_EOL;
                });
    }
}

