<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/



/* End of file hooks.php */
/* Location: ./application/config/hooks.php */

/// environment switch
$hook['pre_system'] = function(){
    
    if(!@defined("APPFOLDER")){ 
        @define("APPFOLDER", ltrim(str_replace('\\', '/', str_replace(trim(FCPATH,"/"),"",APPPATH) ) , "/" ) ); 
    }  
        
    if( strpos($_SERVER["HTTP_HOST"],"localhost") !== FALSE 
    || strpos($_SERVER["HTTP_HOST"],".ngrok.io") !== FALSE // tunnel
    || strpos($_SERVER["HTTP_HOST"],":8888") !== FALSE // external ip and port
    || @__env !== "local" // manual trigger
    ){
        define('my_env', "local" );
    }else{
        define('my_env', "live" );
    }  
                                    
};


$hook['post_controller_constructor'][] = array(
    'function' => 'redirect_ssl',
    'filename' => 'ssl.php',
    'filepath' => 'hooks'
);