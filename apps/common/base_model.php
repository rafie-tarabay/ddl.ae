<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Base extends CI_Model {

    public function __construct()
    {
        parent::__construct();   

        if(!defined("loaded")){
            
            //loading Datase
            $this->frontend = $this->load->database('frontend', TRUE);

            // loading cache driver
            $this->load->driver('cache', array('adapter' => 'file'));  
            if(isset($_GET["xcache"])) $this->cache->clean();

            $free_access = $this->session->userdata("free_access");      
            $customer = $this->session->userdata("customerSession");      

            //$this->output->enable_profiler(TRUE);

            // getting info from session
            if(!@defined("loaded")){ @define("loaded", 1 ); }                                     
            if(!@defined("logged_in")){ @define("logged_in", @$customer["logged_in"] ); }                         
            if(!@defined("u_id")){ @define("u_id", @$customer["id"] ); }                                                 
            if(!@defined("fullname")){ @define("fullname",@$customer["full_name"] ); }                                                 
            if(!@defined("username")){ @define("username",@$customer["username"] ); }                                                 
            if(!@defined("u_photo")){ @define("u_photo",@$customer["u_photo"] ); }                                                 
            if(!@defined("u_country")){ @define("u_country",@$customer["u_country"] ); }                                                 
            if(!@defined("email")){ @define("email",@$customer["email"] ); }                                                 
            if(!@defined("sync_admin")){ @define("sync_admin",@$this->session->userdata("sync_admin") ); }                                                 

            date_default_timezone_set("Asia/Dubai");        

            // lang                        
            if(isset($_GET["locale"])){
                $locale = $this->input->get("locale");     
                if(in_array($locale , array("ar","en"))){          
                    $this->session->set_userdata("locale",$locale);        
                }            
            }elseif($this->session->userdata("locale")){     
                $locale = $this->session->userdata("locale");            
            }else{
                $locale = "ar";
            }
            if(!@defined("locale")){ @define("locale", $locale ); }                         
            // lang              

        }                                   

    }

    public function set_settings(){             
                  
        if(u_id == 2 || u_id == 11){
            error_reporting(E_ALL);
            ini_set('display_errors', 1);            
        }
        
        $settings = array();            

        // getting main contents
        $settings["site_contents"]= $this->site_content();

        // saving settings into config items        
        $_settings = $this->get_settings();
        foreach($_settings as $result){
            $settings[$result->s_setting] = $result->s_value;                                        
        }        

        /// User referrer
        if(!@defined("user_referrer")){ 
            $referrer = FALSE;
            $last_out_referrer = $this->session->userdata("referrer");
            $user_referrer = $this->agent->is_referral() ? $this->agent->referrer() : FALSE;
            if( $user_referrer && strpos($user_referrer,$_SERVER["SERVER_NAME"]) === FALSE && strpos($user_referrer,$_SERVER["HTTP_HOST"]) === FALSE ){                
                $referrer = $user_referrer;                
                $this->session->set_userdata("referrer",$referrer);
            }elseif($last_out_referrer){
                $referrer = $last_out_referrer;
            }            
            @define("user_referrer", $referrer ); 
        }

        // loading language
        $this->lang->speak(locale);     
        if(!@defined("style_dir")){ 
            @define("style_dir", ( word("style_dir") ? word("style_dir") : "rtl"  )  ); 
            @define("MyAlign", ( style_dir == "rtl" ? "right" : "left"  )  ); 
            @define("OppAlign", ( style_dir == "rtl" ? "left" : "right"  )  );             
        }                         



        // localhost variable
        $settings["localhost"] = my_env == "local" ? TRUE : FALSE ;    

        // defining constants
        if(!@defined("front_base")){ @define("front_base", $settings["front_base"] ? $settings["front_base"]."/" : "" ); }            
        if(!@defined("admin_base")){@define("admin_base", $settings["admin_base"]? $settings["admin_base"]."/" : "admin.php/" ); }
        if(!@defined("engine_base")){@define("engine_base", $settings["engine_base"]? $settings["engine_base"]."/" : "engine.php/" ); }
        if(!@defined("upload_base")){@define("upload_base", $settings["upload_base"]? $settings["upload_base"]."/" : "uploads/" ); }
        if(!@defined("sync_base")){@define("sync_base", $settings["sync_base"]? $settings["sync_base"]."/" : "sync.php/" ); }
        if(!@defined("style")){ @define("style", $settings["style_frontend"] ); }                                         
        if(!@defined("design")){ @define("design", "apps/common/design/".style."/" ); }                         
        if(!@defined("design_path")){ @define("design_path", "../../../".design ); }                         

        /// free access verifier
        $free_access = $this->session->userdata("free_access");

        if(!$free_access && in_array(u_id,array(11))){
            // forced free access 
            $obj = new stdClass();
            $obj->access_id = 17;
            $free_access = $this->access->give("token",$obj);
        }

        if($free_access && logged_in){ 
                     
            $access_id = $free_access["access_id"];
            $method = $free_access["method"];
        //    echo "<pre>";
        //    print_r($this->session->userdata("free_access"));
        //    print_r($free_access);
        //    echo 'IP '.$this->access->ip."<br>";
           if($this->session->userdata("proxy")){
                $access = $this->access->verify('proxy' , $access_id,$this->session->userdata("proxy")); 
           }else{
                $access = $this->access->verify($method , $access_id);

           }
            // print_r($this->session->userdata("free_access"));
            // print_r($free_access);
            // echo "here<br>";
            // echo $access_id."<br>";
            // echo $method."<br>";
            // if($access){echo "true";};
            // echo $this->access->ip."<br>";
             
            // exit;
            if(!@defined("free_access")){ @define("free_access", @$access ? TRUE : FALSE ); }                                                                    
            if(!@$access){ 
                redirect(base_url("access/expired"));
            }                                                                    
        }else{
            @define("free_access", FALSE );
        }        

        
        //// Active Packages 
        $packs_ids = $this->package->get_active_packs(TRUE);    
        if($packs_ids){
            $books = $this->package->get_packages_books($packs_ids);    
            if(!@defined("active_packs")){ @define("active_packs", $packs_ids ); }              
            if(!@defined("packs_books")){ @define("packs_books", $books ); }              
        }else{
            if(!@defined("active_packs")){ @define("active_packs", FALSE ); }               
            if(!@defined("packs_books")){ @define("packs_books", FALSE ); }                          
        }

        //// update user data        
        if(logged_in && !segment(1) == "logout"){                  
            if(u_id){
                $this->frontend->join("users_data","data_u_id = u_id","right");
                $user = $this->frontend->where("u_id",u_id)->limit(1)->get("users")->row();
                if($user && $user->u_banned == 0){
                    $this->frontend->where("u_id",u_id)->update("users",array("u_lastvisit"=>time()));                
                    /// renew session
                    $this->load->model("user");
                    $this->user->login_session($user);
                }else{
                    redirect(base_url("logout"));
                }
            }else{
                redirect(base_url("logout"));
            }
        }

        
        if(isset($_GET["mobile_view"])){
            $this->session->set_userdata("mobile_view",TRUE);
        }


        // search_url
        $settings["search_url"]= base_url(engine_base."search");        

        // site offline redirecting
        if($settings["site_offline"] == 1){                    
            if($this->uri->segment(1) != "misc"){
                redirect(base_url(front_base."misc/maintenance"));    
            }            
        }
        $this->config->set_item('settings', $settings);           

        // free memory
        unset($settings);   

        //return $settings;   

        /// keeping connection alive
        $this->db->reconnect();                             

    }   


    public function response_page($input,$type,$message,$show_button = 0,$url = ""){

        if($url == ""){
            $url = base_url(front_base);

        }elseif(strpos($url,"http://") !== FALSE || strpos($url,"https://") !== FALSE){
            $url = $url;
        }elseif($url == "auto"){
            //$this->load->library('user_agent');
            $url = $this->agent->referrer();
            if(strpos($url,base_url()) === FALSE){
                $url = base_url(front_base);
            }
        }else{
            $url = base_url(front_base.$url);
        }

        $data["data"]["url"] = $url;
        $data["data"]["type"] = $type;  
        $data["data"]["button"] = $show_button;
        $data["data"]["message"] = $message;

        $data["views"]["title"] = $input;
        $data["views"]["content"] = 'misc/response';                
        $data["views"]["header"] = "inner";
        $data["views"]["footer"] = "inner";

        $this->load->view(design_path.'/templates/main/core',$data);               

    }              


    public function valid_email($email){
        return preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $email);
    }          


    public function paginate_me($count,$per_page,$controller,$segment = 3,$page_numbers = TRUE){

        $this->load->library("pagination");

        $config = array();                                   
        $config["base_url"] = base_url(front_base."$controller");
        $config["total_rows"] = $count;
        $config["per_page"] = $per_page;
        $config["uri_segment"] = $segment;    
        $config['num_links'] = 3;
        $config['use_page_numbers'] = $page_numbers == TRUE ? TRUE : FALSE;

        $config['full_tag_open'] = '<div class="pagging text-center"><nav><ul class="pagination m-0 p-0">';
        $config['full_tag_close'] = '</ul></nav></div>';
        $config['first_link'] = '<i class="fas fa-angle-double-'.MyAlign.'" title="الأولى" rel="tooltip"></i>';
        $config['last_link'] = '<i class="fas fa-angle-double-'.OppAlign.'" title="الأخيرة" rel="tooltip"></i>';
        $config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['first_tag_close'] = '</span></li>';

        $config['prev_link'] = FALSE; //'<i class="fas fa-angle-right"></i>';
        $config['next_link'] = FALSE; //'<i class="fas fa-angle-left"></i>';

        $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close'] = '</span></li>';        

        $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['next_tag_close'] = '</span></li>';
        $config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['last_tag_close'] = '</span></li>';

        $config['cur_tag_open'] =  '<li class="page-item active"><span class="page-link"><a>';
        $config['cur_tag_close'] = '</a></span></li>';

        $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close'] = '</span></li>';    
        $config["reuse_query_string"] = TRUE;

        //$query = http_build_query($_GET);
        //if($query) $config["suffix"] = "?".$query;        


        $this->pagination->initialize($config);

        $page = ($this->uri->segment($segment)) ? $this->uri->segment($segment) : 0;          

        $links = $this->pagination->create_links();            

        $pagination = array("page" => $page , "links" => $links);

        return $pagination;

    }     


    public function upload_doc($data){

        $file_name = @$data["file_name"];
        $folder = @$data["folder"];
        $field_name = @$data["field_name"] ? $data["field_name"] : "file";
        $ext = @$data["ext"] ? $data["ext"] : FALSE;
        $max_size = @$data["max_size"] ? $data["max_size"] : 2048;


        $path = FCPATH.$folder;

        if(!is_dir($path)){ mkdir($path); }

        if($ext){
            $ext = join("|", array( strtolower($ext),strtoupper($ext) ) );
        }

        $config['upload_path'] = $path;
        $config['allowed_types'] = $ext ? $ext : 'JPG|PNG|jpg|png|doc|DOC|docx|DOCX|pdf|PDF|ZIP|zip|RAR|rar|JPEG|jpeg|mp3|MP3|WAV|wav';
        $config['max_size']    = $max_size;
        $config['file_name'] = $file_name;
        $config['overwrite'] = true;               
        $config['file_ext_tolower'] = TRUE;                    
        $this->load->library('upload', $config); 

        $uploaded = $this->upload->do_upload($field_name);        
        $upload_data =  $this->upload->data();

        if($upload_data["file_type"] && $upload_data["file_ext"] && $upload_data["client_name"]){                            
            $file = $upload_data["orig_name"];     

            if(@$data["resize"] && @$data["resize"]["width"] && @$data["resize"]["height"]){
                $this->load->library('image_lib');
                $source = $upload_data["full_path"];
                // resize
                $config2['image_library'] = 'gd2';
                $config2['source_image'] = $source;
                $config2['maintain_ratio'] = false;                        
                $config2['width'] = $data["resize"]["width"];            
                $config2['height'] = $data["resize"]["height"];             
                $config2['quality'] = '100%';             
                $this->image_lib->initialize($config2);
                $this->image_lib->resize();                   
                //prnt($this->image_lib->display_errors());                              
            }

        }else{
            $file = false;
        }

        if($file){
            $result = 1;    
            $file_size = $upload_data["file_size"];
        }else{
            $result = 0;    
            $file = "";
            $file_size = 0;

            //echo $this->upload->display_errors();
        }

        return array("result"=>$result, "file"=>$file , "file_size"=>$file_size);    


    }




    public function upload_resize_image($file_name,$folder,$width,$height,$input_name = "file",$quality=100,$thumb = FALSE,$th_ratio=50){

        $path = FCPATH.$folder ;

        if(!is_dir($path)){ mkdir($path); @file_put_contents($path."index.html","Forbidden"); }

        $config['upload_path'] = $path;
        $config['allowed_types'] = 'JPG|PNG|jpg|png|jpeg|JPEG';
        $config['max_size']    = '2048';
        $config['file_name'] = $file_name;     
        $config['overwrite'] = TRUE;          
        $config['file_ext_tolower'] = TRUE;                         
        $this->load->library('upload');
        $this->upload->initialize($config);

        $uploaded = $this->upload->do_upload($input_name);        
        $upload_data =  $this->upload->data();

        if($upload_data["file_type"] && $upload_data["file_ext"] && $upload_data["client_name"]){                            

            $this->load->library('image_lib');

            $source = $upload_data["full_path"];

            // resize
            $config2['image_library'] = 'gd2';
            $config2['source_image'] = $source;
            $config2['maintain_ratio'] = false;                        
            $config2['width'] = $width;            
            $config2['height'] = $height;             
            $config2['quality'] = $quality.'%';             
            $this->image_lib->initialize($config2);
            $this->image_lib->resize();                   
            // resize                    

            if($thumb){       

                $width = round(($width*$th_ratio)/100);
                $height = round(($height*$th_ratio)/100);                
                // resize
                $config3['image_library'] = 'gd2';
                $config3['source_image'] = $source;
                $config3['maintain_ratio'] = false;                        
                $config3['width'] = $width;            
                $config3['height'] = $height;             
                $config3['quality'] = $quality.'%';             

                // new file
                $filename = basename($source);
                $config3['new_image'] = str_replace($filename,"thumb_".$filename,$source);

                $this->image_lib->initialize($config3);
                $this->image_lib->resize();                   
                // resize
            }


            $photo = $upload_data["orig_name"];                                                                                      

        }else{
            $photo = false;
        }
        /// uploading               

        if($photo){
            $result = 1;    
            $file = $photo;
        }else{
            $result = 0;    
            $file = "";
        }

        return array("result"=>$result, "file"=>$file);          

    }



    public function get_settings(){

        $settings = $this->cache->get('settings');        
        if ( !$settings ){
            $settings = $this->frontend->get("settings")->result();            
            $this->cache->save('settings', $settings, 60*60*24);
        }             
        return $settings;
    }   
    
    
    public function site_content($main = TRUE){

        $main = $main == 1 ? 1 : 0;
        
        $types = $this->cache->get('site_content_'.$main);
        
        if ( !$types ){
            
            $this->frontend->order_by("cat_order ASC, content_order ASC");
            $this->frontend->join("landing_cats","content_cat = cat_name","left");
            $this->frontend->where("cat_main",$main);                                               
            $this->frontend->where("content_disabled",0);   
            $contents = $this->frontend->get("landing_content")->result(); 

            $types = array();
            foreach($contents as $content){
                $types[$content->cat_type][$content->cat_name][] = $content;
            }

            $this->cache->save('site_content_'.$main, $types, 60*60*24);

        }     
        
        return $types;

    }    


    public function send_to_digitalocean($data){

        $space_name = $data["space_name"];
        $path = $data["path"];
        $filename = $data["filename"];
        $do_path = $data["do_path"];
        $do_filename = @$data["do_filename"] ? $data["do_filename"] : $filename;

        $this->load->config("digitalocean", TRUE);
        $config = $this->config->item( $space_name,'digitalocean');

        require_once(FCPATH."apps/common/classes/digitalocean/spaces.php");

        $space = new SpacesConnect($config["key"], $config["secret"], $config["space_name"], $config["region"]);                   

        $object = $space->UploadFile($path.$filename, "public" ,$do_path.$do_filename);        

        if($object){

            $object = $space->GetObject($do_path.$do_filename);        

            if( $object && 
            ( $object["ContentLength"] > 0 || $object["@metadata"]["headers"]["content-length"] > 0)&&                
            $object["@metadata"]["statusCode"] == 200 ){
                $url = @$object["ObjectURL"] ? @$object["ObjectURL"] : @$object["@metadata"]["effectiveUri"];                
                return $url;
            }else{
                return FALSE;    
            }

        }else{
            return FALSE;
        }

    }



    public function temp_link_digitalocean($data){

        $space_name = $data["space_name"];
        $do_filepath = $data["do_filepath"];
        $valid = $data["valid"];

        $this->load->config("digitalocean", TRUE);
        $config = $this->config->item( $space_name,'digitalocean');

        require_once(FCPATH."apps/common/classes/digitalocean/spaces.php");

        $space = new SpacesConnect($config["key"], $config["secret"], $config["space_name"], $config["region"]);                   

        $link = $space->CreateTemporaryURL($do_filepath, $valid);                                                    

        return $link;    

    }






    public function enable_inspectlet(){

        $exact_match = array(
            "https://ddl.ae/search/advanced",
            "https://ddl.ae/free-access",
        );

        $contains = array(
            "/results/",
            "/book/",
            "/book/read/",
            "/file/handler/",
            "/cart/",
            "/orders",
            "/packages",
        );            


        if( in_array( current_url() , $exact_match ) ){
            return TRUE;
        }

        foreach($contains as $c){
            if(strpos(current_url(),$c) !== FALSE){
                return TRUE;
            }
        }

        return FALSE;
    }


}