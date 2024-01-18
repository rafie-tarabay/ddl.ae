<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Settings extends MY_Controller {

        public function __construct() {
            parent::__construct();            
            if(!logged_in ||  can("edit_site_settings") == FALSE ){ redirect(base_url(admin_base."admins/login")); exit; }
        }    


        public function index(){
            $data["views"]["content"] = 'settings/main';   
            $data["data"]["title"] = "إعدادات الموقع";
            $this->load->view(style.'/templates/main/core',$data);
        }


        public function update_main(){
            if($_POST){
                $data = array();

                //$data[] = array("s_setting" => "lang_frontend" , "s_value" => $this->input->post("lang_frontend"));               
                //$data[] = array("s_setting" => "style_frontend" , "s_value" => $this->input->post("style_frontend"));               

                //$data[] = array("s_setting" => "admin_lang" , "s_value" => $this->input->post("admin_lang"));               
                //$data[] = array("s_setting" => "admin_style" , "s_value" => $this->input->post("admin_style"));                               

                $data[] = array("s_setting" => "site_offline" , "s_value" => $this->input->post("site_offline"));                               

                $data[] = array("s_setting" => "refresh" , "s_value" => $this->input->post("refresh"));               
                $data[] = array("s_setting" => "login_token" , "s_value" => $this->input->post("login_token"));               

                $data[] = array("s_setting" => "google_analytic_enabled" , "s_value" => $this->input->post("google_analytic_enabled"));               
                $data[] = array("s_setting" => "google_analytic_id" , "s_value" => $this->input->post("google_analytic_id")); 
 
                @$this->db->update_batch('settings', $data, 's_setting'); 

            }                  
            redirect(base_url(admin_base."settings"));
        }        


        public function payments(){
            $data["views"]["content"] = 'settings/payments';   
            $data["data"]["title"] = "إعدادات الدفع";
            $this->load->view(style.'/templates/main/core',$data);
        }




        public function email(){
            
            $data["data"]["admins"] = $admins = $this->db->get("admins")->result();
            
            $data["views"]["content"] = 'settings/email';   
            $data["data"]["title"] = "إعدادات البريد";
            $this->load->view(style.'/templates/main/core',$data);                 
        }

        public function update_email(){

            if($_POST){
                $data = array();


                $data[] = array("s_setting" => "site_email" , "s_value" => $this->input->post("site_email"));                                                     
                
                @$this->db->update_batch('settings', $data, 's_setting'); 
                                                                            
            }            
            redirect(base_url(admin_base."settings/email"));    
        }        






        public function urls(){
            $data["views"]["content"] = 'settings/urls';   
            $data["data"]["title"] = "إعدادات الروابط";
            $this->load->view(style.'/templates/main/core',$data);                 
        }

        public function update_urls(){
            if($_POST){
                $data = array();

                $data[] = array("s_setting" => "front_base" , "s_value" => $this->input->post("front_base"));                           
                $data[] = array("s_setting" => "admin_base" , "s_value" => $this->input->post("admin_base"));                     

                @$this->db->update_batch('settings', $data, 's_setting'); 

            }            
            redirect(base_url(admin_base."settings/urls"));    
        }        



          


        public function security(){
            $data["views"]["content"] = 'settings/security';   
            $data["data"]["title"] = "إعدادات الأمان";
            $this->load->view(style.'/templates/main/core',$data);                 
        }

        public function update_security(){
            if($_POST){
                $data = array();

                $enable_login_pincode = $this->input->post("enable_login_pincode");
                $login_pincode = $this->input->post("login_pincode");

                $enable_recaptcha = $this->input->post("enable_recaptcha");
                $recaptcha_site_key = $this->input->post("recaptcha_site_key");
                $recaptcha_secret_key = $this->input->post("recaptcha_secret_key");

                if(
                    ($enable_login_pincode == 0 || ( $enable_login_pincode == 1 &&  strlen($login_pincode) > 0 ) ) &&
                    ($enable_recaptcha == 0 || ( $enable_recaptcha == 1 && $recaptcha_site_key && $recaptcha_secret_key ) )
                ){

                    $data[] = array("s_setting" => "enable_login_pincode" , "s_value" => $enable_login_pincode);                           
                    if(strlen($login_pincode) > 0){
                        $data[] = array("s_setting" => "login_pincode" , "s_value" => $login_pincode);                           
                    }

                    $data[] = array("s_setting" => "enable_recaptcha" , "s_value" => $enable_recaptcha);                           
                    if($enable_recaptcha){
                        $data[] = array("s_setting" => "recaptcha_site_key" , "s_value" => $recaptcha_site_key);                           
                        $data[] = array("s_setting" => "recaptcha_secret_key" , "s_value" => $recaptcha_secret_key);                                               
                    }


                    @$this->db->update_batch('settings', $data, 's_setting'); 


                }else{
                    $this->settings_model->response_page("خطأ","error","يجب إدخال كافة البيانات",1,"auto");                                                  
                }
            }
            redirect(base_url(admin_base."settings/security"));    
        }                






              


          
        public function php_info(){

            echo phpinfo();

        }




}