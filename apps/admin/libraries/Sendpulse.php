<?php

require_once( 'sendpulse/sendpulseInterface.php' );
require_once( 'sendpulse/sendpulse.php' );

// https://login.sendpulse.com/settings/#api
define( 'API_USER_ID', 'f3ebb832852241c9df681e866de12dff' );
define( 'API_SECRET', 'de2a0d56dfcebddc5639b5c14c9c64d0' );

define( 'TOKEN_STORAGE', 'session' );


class Sendpulse{

    var $SPApiProxy;
    
    public function __construct( ) {

        $this->SPApiProxy = new SendpulseApi( API_USER_ID, API_SECRET, TOKEN_STORAGE );            
    }        

    public function send_push($title , $text , $link , $u_id){

        $task = array(
            'title'      => $title,
            'body'       => $text,
            'website_id' => 17011,
            'ttl'        => 60*60*24,
            'stretch_time' => 60
        );
        // This is optional
        $additionalParams = array(
            'link' => $link,
            //'filter_browsers' => 'Chrome,Safari',
            //'filter_lang' => '',
            //'filter' => '{"id":"'.$u_id.'"}',
            
            'filter' => '{"variable_name":"id","operator":"and","conditions":[{"condition":"equal","value":"'.$u_id.'"}]}'
        );
        //prnt($this->SPApiProxy->createPushTask($task, $additionalParams));            
        $this->SPApiProxy->createPushTask($task, $additionalParams);          


    }

}    