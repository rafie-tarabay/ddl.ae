<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Onesignal {


    function sendMessage($_heading,$_content,$url,$players){

        $app_id = "2b6c3ad3-9365-49ea-9973-2c76b1055da8";
        $RESET_key = "ZGFmNTg0ZWQtNGI5Mi00MjFiLTg2MmQtZjA1ZTcyNzAzMWZj";        

        $contents = $_content ? array("en" => $_content) : FALSE;
        $headings = $_heading ? array("en" => $_heading) : FALSE;

        $fields = array(
            'app_id' => $app_id,
            'include_player_ids' => $players,
            //'data' => array("foo" => "bar"),
            'contents' => $contents,            
            'url' => $url,
        );
        
        if($headings) $fields["headings"] = $headings;

        $fields = json_encode($fields);
        //print($fields);

        $http_header = array(
            'Content-Type: application/json; charset=utf-8',
            'Authorization: Basic '.$RESET_key
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }




}
