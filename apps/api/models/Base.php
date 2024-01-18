<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Base extends CI_Model {

    public function __construct(){
        parent::__construct();   
        
        // loading cache driver
        $this->load->driver('cache', array('adapter' => 'file'));  
        if(isset($_GET["xcache"])) $this->cache->clean();        
        
        if(!@defined("locale")){ @define("locale", "ar" ); }                         
        
    }
    
}