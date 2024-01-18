<?php

class Sms extends base{

    
    public function forces_countries(){
        //return array("ARE");
        return array();
    }

    public function can_send_sms($last_sms , $sms_count){
                
        $time_limit = 60;
        $count_limit = 3;

        if($sms_count < $count_limit){
            if($last_sms == 0){
                return TRUE;
            }elseif($last_sms > 0){
                if( ( time() - $last_sms  ) > $time_limit  ){
                    return TRUE;
                }else{
                    return  time() - $last_sms;
                }            
            }
        }else{
            return FALSE;
        }
    }

    public function send_mobile_verification($params){
                         
        $last_sms = @$params["last_sms"];
        $sms_count = @$params["sms_count"];
        
        if($this->can_send_sms($last_sms , $sms_count) === TRUE){

            $url = 'https://api.authy.com/protected/json/phones/verification/start';
            $AUTHY_API_K = "mhrJ5IbARrT6reSZgxuI90pguPnIqTdp"; // https://www.twilio.com/console/verify/applications

            $query_array = array(
                "via" => "sms",
                "phone_number" => $params["mobile"],
                "country_code" => $params["country_code"],        
                "locale" => "en",        
            );

            $fields_string = http_build_query($query_array);
            $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL, $url);
            curl_setopt($ch,CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'X-Authy-API-Key: '.$AUTHY_API_K
            ));        
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CAINFO, APPPATH.'config/cacert.pem');

            curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
            $result = curl_exec($ch);        

            curl_close($ch);  

            $result = json_decode($result);
             
            if($result->success == 1){
                $this->db->where("reference",$params["reference"]);
                $this->db->set("mobile_sms_count",'mobile_sms_count+1',FALSE);
                $this->db->set("mobile_last_sms",time());            
                $this->db->update("users_temp");
            }
                
            return $result;

        }else{
            return FALSE;
        }

    }   



    public function verify_code($params){

        $url = 'https://api.authy.com/protected/json/phones/verification/check';
        $AUTHY_API_K = "mhrJ5IbARrT6reSZgxuI90pguPnIqTdp"; // https://www.twilio.com/console/verify/applications

        $params = array(
            "phone_number" => $params["mobile"],
            "country_code" => $params["country_code"],        
        ); 

        $fields_string = http_build_query($params);       

        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'X-Authy-API-Key: '.$AUTHY_API_K
        ));        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CAINFO, APPPATH.'config/cacert.pem');        
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        $result = curl_exec($ch);        

        curl_close($ch);  

        $result = json_decode($result);


        return $result;        

    }   

    public function is_valid_mobile($params){
        $mobile = $params["mobile"];
        $country_code = $params["country_code"];
        
        $APIkey = "b1466495a5d6a2699b5ae93b4cd83312";
        $response = json_decode(file_get_contents("http://apilayer.net/api/validate?access_key=".$APIkey."&number=".$mobile."&country_code=".$country_code."&format=1"));        
        
        //prnt($response);
        
        if($response->valid == 1 && $response->line_type == "mobile"){
            return TRUE;
        }else{
            return FALSE;
        }

    }
    
        




}