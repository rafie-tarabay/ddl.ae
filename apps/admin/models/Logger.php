<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Logger extends Base {        

    public function create($data2){

        $data1 = array(
            "log_admin_id" => admin_id,
            "log_date" => date("Y-m-d"),
            "log_timestamp" => time(),
        );
        
        $data = $data1 + $data2;
        
        $this->db->insert("admins_logs",$data);
    }


}