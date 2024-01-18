<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Base extends CI_Model {

    public function __construct()
    {
        parent::__construct();

        // loading cache driver
        $this->load->driver('cache', array('adapter' => 'file'));  
        if(isset($_GET["xcache"])) $this->cache->clean();        
        
        // getting info from session
        if(!@defined("logged_in")){ @define("logged_in",$this->session->userdata("logged_in")); }                         
        if(!@defined("admin_id")){ @define("admin_id",$this->session->userdata("admin_id")); }                                                 
        if(!@defined("admin_level")){ @define("admin_level",$this->session->userdata("admin_level")); }                                                 
        if(!@defined("locale")){ @define("locale","ar"); }                                                 

        date_default_timezone_set("Asia/Dubai");               
    }


    public function set_settings(){

        // saving settings into config items
        $settings = array();            
        $query = $this->db->get("settings");    
        foreach($query->result() as $result){
            $settings[$result->s_setting] = $result->s_value;                                        
        }
        $settings["langs"] = $_langs = $this->db->order_by("lang_alias","ASC")->get("langs")->result();

        $settings["upload"]["image"] = array("max_size"=>30720,"max_width"=>900,"max_thumb"=>96); //3 MB
        $settings["upload"]["video"] = array("max_size"=>30720); //30 MB


        $lang = "ar";

        if(isset($lang) && in_array($lang,$_langs)){
            $settings["lang_frontend"] = $lang;                                 
            $this->session->set_userdata("lang",$lang);
        }else{
            $this->session->set_userdata("lang",$settings["lang_frontend"]);
        }                      

        $this->lang->speak($settings["lang_frontend"]);                

        // localhost variable
        $settings["localhost"] = my_env == "local" ? TRUE : FALSE;    

        // defining constants
        if(!@defined("front_base")){ @define("front_base", $settings["front_base"] ? $settings["front_base"]."/" : "" ); }            
        if(!@defined("admin_base")){@define("admin_base", $settings["admin_base"]? $settings["admin_base"]."/" : "" ); }
        if(!@defined("engine_base")){@define("engine_base", $settings["engine_base"]? $settings["engine_base"]."/" : "" ); }
        if(!@defined("upload_base")){@define("upload_base", $settings["upload_base"]? $settings["upload_base"]."/" : "uploads/" ); }        

        if(!@defined("style")){ @define("style", $settings["style_backend"] ); }                         


        $this->config->set_item('settings', $settings);           


        if(logged_in){

            $this->db->where("admin_id",admin_id)->update("admins",array("admin_last_visit"=>time()));

            $admin = $this->db->where("admin_id",admin_id)->get("admins")->row();

            if($admin->admin_banned == 0){

                $permissions = array();            
                $perms = $this->db->where("perm_admin_id",admin_id)->get("admins_permissions")->row();    
                foreach($perms as $key => $val){
                    $permissions[$key] = $val;                                        
                }
                $this->config->set_item('permissions', $permissions);                                                                                                                                  

            }elseif(segment(2) != "logout"){
                redirect(base_url(admin_base."admins/logout"));
            }

        }                   


        // free memory
        unset($settings);
        unset($permissions);

        //return $settings;                                

    }   


    public function response_page($input,$type,$message,$show_button = 0,$url = ""){

        if($url == ""){
            $url = base_url(admin_base);

        }elseif($url == "auto"){
            $this->load->library('user_agent');
            $url = $this->agent->referrer();
        }else{
            $url = base_url(admin_base.$url);
        }

        $data["data"]["title"] = $input;
        $data["views"]["content"] = 'misc/response';        
        $data["data"]["url"] = $url;
        $data["data"]["type"] = $type;  
        $data["data"]["button"] = $show_button;
        $data["data"]["message"] = $message;
        $data["data"]["hide_breadcrumb"] = TRUE;

        $this->load->view(style.'/templates/main/core',$data);               

    }              



    public function paginate_me($count,$per_page,$controller,$segment = 3){

        $this->load->library("pagination");

        $config = array();
        $config["base_url"] = base_url(admin_base."$controller");
        $config["total_rows"] = $count;
        $config["per_page"] = $per_page;
        $config["uri_segment"] = $segment;    
        $config['num_links'] = 2;
        $config['use_page_numbers'] = FALSE;

        $config['full_tag_open'] = '<div class="pagging text-center"><nav><ul class="pagination m-0 p-0">';
        $config['full_tag_close'] = '</ul></nav></div>';
        $config['first_link'] = '<i class="fas fa-angle-double-right" title="الأولى" rel="tooltip"></i>';
        $config['last_link'] = '<i class="fas fa-angle-double-left" title="الأخيرة" rel="tooltip"></i>';
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

        $this->pagination->initialize($config);

        $page = ($this->uri->segment($segment)) ? $this->uri->segment($segment) : 0;          

        $links = $this->pagination->create_links();

        $pagination = array("page" => $page , "links" => $links);

        return $pagination;

    }     


    public function get_countries($mode){

        if($mode == "enabled-only"){
            $this->db->where("country_enabled",1);   
        }

        return $this->db->select("country_name_ar,country_code")->get("countries")->result();

    }

    public function get_page($alias){        
        return $this->db->where("page_alias",$alias)->get("pages")->row();
    }        




    public function upload_doc($data){

        $this->load->library('upload'); 

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
        $config['overwrite'] = false;               
        $config['file_ext_tolower'] = TRUE;                            
        $this->upload->initialize($config); 

        $uploaded = $this->upload->do_upload($field_name);        
        $upload_data =  $this->upload->data();

        //prnt($upload_data,FALSE);

        if($upload_data["file_type"] && $upload_data["file_ext"] && $upload_data["client_name"]){                            
            $file = $upload_data["orig_name"];                                                                                      
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
        }

        //prnt($_FILES,FALSE);
        //prnt($data);

        $returned = array(
            "result"=>$result, 
            "file_original_name"=>$upload_data["client_name"],
            "file_name"=>$upload_data["file_name"],
            "file_path"=>$upload_data["file_path"],
            "file_size"=>$file_size,
            "file_ext"=> str_replace(".","",$upload_data["file_ext"]) ,            
        );    

        
        //prnt($returned);
        
        return $returned;

    }



    public function upload_multi_docs($data){

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

        $filesCount = count($_FILES[$field_name]['name']);

        $success_uploads = array();                          

        for($i = 0; $i < $filesCount; $i++){

            $_FILES['file_'.$i]['name']     = $_FILES[$field_name]['name'][$i];
            $_FILES['file_'.$i]['type']     = $_FILES[$field_name]['type'][$i];
            $_FILES['file_'.$i]['tmp_name'] = $_FILES[$field_name]['tmp_name'][$i];
            $_FILES['file_'.$i]['error']    = $_FILES[$field_name]['error'][$i];
            $_FILES['file_'.$i]['size']     = $_FILES[$field_name]['size'][$i];                


            $signle_data = array(
                "file_name" => $file_name."_".$i,
                "folder" => $folder,
                "field_name" => "file_".$i,
                "ext" => $ext,
                "max_size" => $max_size,
            );            

            $uploaded = $this->upload_doc($signle_data);

            if($uploaded["result"] == 1 && $uploaded["file_size"] > 0) {

                $success_uploads[] = $uploaded;

            }            

        }

        return $success_uploads;         

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


    public function count_units($as_array=FALSE){        
        $units = $this->db->order_by("unit_order","ASC")->get("count_units")->result();
        return $as_array == TRUE ? get_ids_array($units,"unit_name") : $units;
    }    




    function get_MP3_data($filename){

        if (!file_exists($filename)) {
            return false;
        }

        $bitRates = array(
            array(0,0,0,0,0),
            array(32,32,32,32,8),
            array(64,48,40,48,16),
            array(96,56,48,56,24),
            array(128,64,56,64,32),
            array(160,80,64,80,40),
            array(192,96,80,96,48),
            array(224,112,96,112,56),
            array(256,128,112,128,64),
            array(288,160,128,144,80),
            array(320,192,160,160,96),
            array(352,224,192,176,112),
            array(384,256,224,192,128),
            array(416,320,256,224,144),
            array(448,384,320,256,160),
            array(-1,-1,-1,-1,-1),
        );
        $sampleRates = array(
            array(11025,12000,8000), //mpeg 2.5
            array(0,0,0),
            array(22050,24000,16000), //mpeg 2
            array(44100,48000,32000), //mpeg 1
        );
        $bToRead = 1024 * 12;

        $fileData = array('bitRate' => 0, 'sampleRate' => 0);
        $fp = fopen($filename, 'r');
        if (!$fp) {
            return false;
        }
        //seek to 8kb before the end of the file
        fseek($fp, -1 * $bToRead, SEEK_END);
        $data = fread($fp, $bToRead);

        $bytes = unpack('C*', $data);
        $frames = array();
        $lastFrameVerify = null;

        for ($o = 1; $o < count($bytes) - 4; $o++) {

            //http://mpgedit.org/mpgedit/mpeg_format/MP3Format.html
            //header is AAAAAAAA AAABBCCD EEEEFFGH IIJJKLMM
            if (($bytes[$o] & 255) == 255 && ($bytes[$o+1] & 224) == 224) {
                $frame = array();
                $frame['version'] = ($bytes[$o+1] & 24) >> 3; //get BB (0 -> 3)
                $frame['layer'] = abs((($bytes[$o+1] & 6) >> 1) - 4); //get CC (1 -> 3), then invert
                $srIndex = ($bytes[$o+2] & 12) >> 2; //get FF (0 -> 3)
                $brRow = ($bytes[$o+2] & 240) >> 4; //get EEEE (0 -> 15)
                $frame['padding'] = ($bytes[$o+2] & 2) >> 1; //get G
                if ($frame['version'] != 1 && $frame['layer'] > 0 && $srIndex < 3 && $brRow != 15 && $brRow != 0 &&
                (!$lastFrameVerify || $lastFrameVerify === $bytes[$o+1])) {
                    //valid frame header

                    //calculate how much to skip to get to the next header
                    $frame['sampleRate'] = $sampleRates[$frame['version']][$srIndex];
                    if ($frame['version'] & 1 == 1) {
                        $frame['bitRate'] = $bitRates[$brRow][$frame['layer']-1]; //v1 and l1,l2,l3
                    } else {
                        $frame['bitRate'] = $bitRates[$brRow][($frame['layer'] & 2 >> 1)+3]; //v2 and l1 or l2/l3 (3 is the offset in the arrays)
                    }

                    if ($frame['layer'] == 1) {
                        $frame['frameLength'] = (12 * $frame['bitRate'] * 1000 / $frame['sampleRate'] + $frame['padding']) * 4;
                    } else {
                        $frame['frameLength'] = 144 * $frame['bitRate'] * 1000 / $frame['sampleRate'] + $frame['padding'];
                    }

                    $frames[] = $frame;
                    $lastFrameVerify = $bytes[$o+1];
                    $o += floor($frame['frameLength'] - 1);
                } else {
                    $frames = array();
                    $lastFrameVerify = null;
                }
            }
            if (count($frames) < 3) { //verify at least 3 frames to make sure its an mp3
                continue;
            }

            $header = array_pop($frames);

            $fileData['sampleRate'] = $header['sampleRate'];
            $fileData['bitRate'] = $header['bitRate'];

            break;
        }

        return $fileData;
    }    







}