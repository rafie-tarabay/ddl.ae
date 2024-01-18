<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admins extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }    


    public function index(){

        if(logged_in == TRUE && can("view_admins") ){

            $data["data"]["admins"] = $admins = $this->db->get("admins")->result();

            $data["views"]["content"] = "admins/list_all";
            $data["data"]["title"] = "المشرفين";
            $this->load->view(style.'/templates/main/core',$data);          

        }else{                
            redirect(base_url(admin_base."home"));                
        }

    }        



    public function view_admin($admin_id){

        if(logged_in == TRUE && can("view_admins") ){

            $data["data"]["perms"] = $this->db->where("perm_admin_id",$admin_id)->get("admins_permissions")->row();
            $data["data"]["admin"] = $this->db->where("admin_id",$admin_id)->get("admins")->row();

            $data["views"]["content"] = "admins/view_admin";
            $data["data"]["title"] = "بيانات المشرف";
            $this->load->view(style.'/templates/main/core',$data);          

        }else{                
            redirect(base_url(admin_base."home"));                
        }

    }        

    public function edit_admin($admin_id){

        if(logged_in == TRUE && can("edit_admin_data") ){

            $data["data"]["perms"] = $this->db->where("perm_admin_id",$admin_id)->get("admins_permissions")->row();
            $data["data"]["admin"] = $admin = $this->db->where("admin_id",$admin_id)->get("admins")->row();

            if($admin){

                $data["views"]["content"] = "admins/forms/edit_admin";
                $data["data"]["title"] = "تعديل مشرف";
                $this->load->view(style.'/templates/main/core',$data);          

            }else{
                $this->base->response_page("خطأ","error","المشرف غير موجود",1,"auto");                              
            }

        }else{                
            redirect(base_url(admin_base."home"));                
        }

    }        


    public function update_admin_data(){

        if(logged_in == TRUE && can("edit_admin_data") ){

            $data = $this->input->post();

            $admin_id = $data["admin_id"];
            $admin_email = $data["admin_email"];
            $admin_personal_email = $data["admin_personal_email"];
            $admin_fullname = $data["admin_fullname"];
            $admin_username = $data["admin_username"];
            $admin_title = $data["admin_title"];
            $admin_signature = $data["admin_signature"];
            $pincode = $data["pincode"];

            if( 
                ( 
                    (settings("enable_login_pincode") == 1 && $pincode == settings("login_pincode") ) || 
                    (settings("enable_login_pincode") == 0 ) 
                ) &&
                $admin_id && 
                $admin_email && 
                $admin_personal_email && 
                $admin_fullname && 
                $admin_signature && 
                $admin_username
                ){       

                    $admin_data = array(
                        "admin_email" => trim($admin_email),
                        "admin_personal_email" => trim($admin_personal_email),
                        "admin_fullname" => trim($admin_fullname),
                        "admin_username" => trim($admin_username),
                        "admin_title" => trim($admin_title),
                        "admin_signature" => trim($admin_signature),
                    );

                    if(can("ban_admins") == 1){
                        $admin_data["admin_banned"] = $data["admin_banned"];
                    }

                    if($data["admin_password"]){
                        $admin_data["admin_password"] = md5($data["admin_password"]);
                    }

                    $this->db->where("admin_id",$admin_id)->update("admins",$admin_data);

                    $this->base->response_page("تم بنجاح","success","تم تحديث البيانات بنجاح",1,"admins/view_admin/".$admin_id);                              


            }else{
                $this->base->response_page("خطأ","error","يرجى ادخال كافة البيانات المطلوبة",1,"auto");                              
            }            


        }else{                
            redirect(base_url(admin_base."home"));                
        }

    }        



    public function update_admin_perms(){

        if(logged_in == TRUE && can("edit_admin_perms") ){

            $data = $this->input->post();

            @$pincode = @$data["pincode"];    
            $admin_id = $data["admin_id"];

            if( 
                ( 
                    (settings("enable_login_pincode") == 1 && $pincode == settings("login_pincode") ) || 
                    (settings("enable_login_pincode") == 0 ) 
                )
                ){  

                    unset($data["admin_id"]);
                    unset($data["pincode"]);  

                    $this->db->where("perm_admin_id",$admin_id)->update("admins_permissions",$data);

                    $this->base->response_page("تم بنجاح","success","تم تحديث الصلاحيات بنجاح",1,"admins/view_admin/".$admin_id);   

            }else{
                $this->base->response_page("خطأ","error","يرجى ادخال كافة البيانات المطلوبة",1,"auto");                              
            }  

        }else{                
            redirect(base_url(admin_base."home"));                
        }

    }        






    public function login(){

        if(logged_in == FALSE){

            $data["views"]["content"] = "admins/forms/login";
            $data["data"]["title"] = "تسجيل الدخول إلى لوحة التحكم";
            $this->load->view(style.'/templates/main/core',$data);          

        }else{                
            redirect(base_url(admin_base."home"));                
        }

    }

    public function login_submit(){

        if(logged_in == FALSE){

            $admin_username = strtolower($this->input->post("username"));
            $password = $this->input->post("password");
            $pincode =  $this->input->post("pincode");

            if( 
                ( 
                    (settings("enable_login_pincode") == 1 && $pincode == settings("login_pincode") ) || 
                    (settings("enable_login_pincode") == 0 ) 
                ) &&
                $admin_username && 
                $password
                ){

                    $admin = $this->db->where("admin_username",$admin_username)->where("admin_password",md5($password))->limit(1)->get("admins")->row();

                    if($admin){

                        if($admin->admin_banned == 0){

                            $data = array(
                                "admin_id" => $admin->admin_id,
                                "admin_level" => $admin->admin_level,
                                "admin_username" => $admin->admin_username,                
                                "admin_email" => strtolower($admin->admin_email),                
                                "logged_in" => TRUE
                            ); 

                            $this->session->set_userdata($data);

                            redirect(base_url(admin_base));

                        }else{
                            $this->base->response_page("خطأ","error","هذا الحساب لا يملك الصلاحيات لدخول لوحة التحكم",1,"admins/login");                              
                        }                        

                    }else{
                        $this->base->response_page("خطأ","error","خطأ فى بيانات الدخول",1,"admins/login");                              
                    }

            }else{
                $this->base->response_page("خطأ","error","خطأ فى بيانات الدخول",1,"admins/login");                              
            }

        }else{                
            redirect(base_url(admin_base."home"));                
        }            

    }


    public function logout(){

        $data = array("admin_id","admin_username","admin_email","logged_in");            

        $this->session->unset_userdata($data);

        redirect(base_url(admin_base));

    }



    public function change_password(){

        if(logged_in == TRUE){

            $data["views"]["content"] = "admins/forms/password";

            $data["data"]["title"] = "تغيير كلمة المرور";

            $this->load->view(style.'/templates/main/core',$data);          

        }

    }


    public function update_password(){


        if(logged_in == TRUE){            

            $old_password = $this->input->post("old_password");
            $new_password = $this->input->post("new_password");
            $pincode =  $this->input->post("pincode");

            if( 
                ( 
                    (settings("enable_login_pincode") == 1 && $pincode == settings("login_pincode") ) || 
                    (settings("enable_login_pincode") == 0 ) 
                ) &&
                $new_password && 
                $old_password
                ){                

                    if(strlen(utf8_decode($new_password)) >= 6){

                        $admin = $this->db->where("admin_id",admin_id)->limit(1)->get("admins")->row();

                        if(md5($old_password) == $admin->admin_password){

                            $this->db->where("admin_id",admin_id)->limit(1)->update("admins",array("admin_password" => md5($new_password)));

                            $this->base->response_page("تم بنجاح","success","تم تغيير كلمة المرور بنجاح",1);                               

                        }else{
                            $this->base->response_page("خطأ","error","كلمة المرور الحالية غير صحيحة",1,"auto");                               
                        }

                    }else{
                        $this->base->response_page("خطأ","error","كلمة المرور يجب أن تكون 6 أحرف على الأقل",1,"auto");                                    
                    }

            }else{
                $this->base->response_page("خطأ","error","خطأ فى البيانات المدخلة",1,"auto");                                   
            }


        }


    }



    public function profile(){

        if(logged_in == TRUE){

            $data["data"]["admin"] = $admin = $this->db->where("admin_id",admin_id)->get("admins")->row();

            $data["views"]["content"] = "admins/forms/edit_profile";

            $data["data"]["title"] = "تحديث البيانات";

            $this->load->view(style.'/templates/main/core',$data);          

        }

    }



    public function update_profile(){

        if(logged_in == TRUE ){            

            $email = $this->input->post("admin_email");
            $personal_email = $this->input->post("admin_personal_email");
            $signature = $this->input->post("admin_signature");
            $admin_password = $this->input->post("admin_password");
            $pincode =  $this->input->post("pincode");

            if( 
                ( 
                    (settings("enable_login_pincode") == 1 && $pincode == settings("login_pincode") ) || 
                    (settings("enable_login_pincode") == 0 ) 
                ) &&                
                $email && 
                $personal_email && 
                $signature && 
                $admin_password
                ){                

                    $admin = $this->db->where("admin_id",admin_id)->where("admin_password",md5($admin_password))->limit(1)->get("admins")->row();

                    if($admin){

                        $exist = $this->db->where("admin_id !=",admin_id)->where("admin_email",$email)->limit(1)->get("admins")->row();

                        if(!$exist){

                            $data = array(
                                "admin_email" => strtolower($email),
                                "admin_personal_email" => strtolower($personal_email),
                                "admin_signature" => $signature,
                            );                             

                            $this->db->where("admin_id",admin_id)->limit(1)->update("admins", $data );

                            $this->session->set_userdata($data);                            

                            $this->base->response_page("تم بنجاح","success","تم تحديث البيانات بنجاح",1);                               

                        }else{
                            $this->base->response_page("خطأ","error","هذا البريد مسجل لدى مستخدم آخر",1,"auto");                               
                        }

                    }else{
                        $this->base->response_page("خطأ","error","كلمة المرور الحالية غير صحيحة",1,"auto");                               
                    }


            }else{
                $this->base->response_page("خطأ","error","خطأ فى البيانات المدخلة",1,"auto");                                   
            }


        }else{
            $this->base->response_page("خطأ","error","غير مسموح بتحديث هذه البيانات",1,"auto");                                   
        }


    }



    public function view_logs($admin_id=0,$date="0000-00-00",$rel_id=0){

        if(logged_in == TRUE && can("view_admin_logs") ){

            if($admin_id) $this->db->where("log_admin_id",$admin_id);            
            if($date && $date != "0000-00-00") $this->db->where("log_date",$date);
            if($rel_id){            
                $this->db->group_start();
                $this->db->or_where("log_rel_id",$rel_id);
                $this->db->or_where("log_rel_id2",$rel_id);
                $this->db->group_end();
            }
            $count = $this->db->count_all_results("admins_logs");        

            $per_page = 50;                                    
            $pagination = $this->base->paginate_me($count,$per_page,"admins/view_logs/$admin_id/$date/$rel_id/",6);            

            $this->db->limit($per_page, $pagination["page"]);     

            if($admin_id) $this->db->where("log_admin_id",$admin_id);            
            if($date && $date != "0000-00-00") $this->db->where("log_date",$date);
            if($rel_id){            
                $this->db->group_start();
                $this->db->or_where("log_rel_id",$rel_id);
                $this->db->or_where("log_rel_id2",$rel_id);
                $this->db->group_end();
            }
            $this->db->join("admins","admin_id = log_admin_id","left");
            $data["data"]["logs"] = $this->db->order_by("log_id","DESC")->get("admins_logs")->result();
            
            $data["data"]["pagination"] = $pagination["links"];                

            $data["views"]["content"] = "admins/view_logs";

            $data["data"]["date"] = $date;
            $data["data"]["admin_id"] = $admin_id;
            $data["data"]["title"] = "مشاهدة السجلات";

            $this->load->view(style.'/templates/main/core',$data);          

        }

    }



}
