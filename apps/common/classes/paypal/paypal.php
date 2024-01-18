<?php
namespace MyPayments;

require_once("vendor/autoload.php");

//1. Import the PayPal SDK client that was created in `Set up the Server SDK`.

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Orders\OrdersGetRequest;
use PayPalCheckoutSdk\Payments\AuthorizationsCaptureRequest;

class MyPaypal{    

    var $client;

    public function setClient($params){
        $mode           = $params["PayPalMode"];
        $clientId       = $params[$mode]["PayPalClientID"];
        $clientSecret   = $params[$mode]["PayPalSecret"];        

        if($mode == "sandbox"){
            $env = new SandboxEnvironment($clientId, $clientSecret);           
        }else{
            $env = new ProductionEnvironment($clientId, $clientSecret);           
        }
        $this->client = new PayPalHttpClient($env);  
    }

    public function getOrder($order_id){
        $req = new OrdersGetRequest($order_id);        
        $response = $this->client->execute($req);        
        return $response;
    }

    public function capture($auth_id){

        $req = new AuthorizationsCaptureRequest($auth_id);
        $req->body = $this->buildRequestBody();
        $response = $this->client->execute($req);        

        return $response;
    }
    
    
    private function buildRequestBody(){
        return "{}";    
    }

}