<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Language extends MY_Controller {

        public function __construct() {
            parent::__construct();
            if(!logged_in || can("edit_langauge") == FALSE ){ redirect(base_url(admin_base."admins/login")); exit; }
        }    



        public function index(){

            $data["views"]["content"] = 'language/list_langs';   
            $data["data"]["title"] = "اللغات";

            $this->load->view(style.'/templates/main/core',$data);   

        }        


        public function words(){

            if($this->input->get("empty") == 1){
                $this->db->or_where("word_ar","");
                $this->db->or_where("word_ar IS NULL");
            }            
            
            $words = $this->db->order_by("word_alias","ASC")->get("lang_words")->result();
            $data["data"]["words"] = $words;
            $data["views"]["content"] = 'language/list_words';   
            $data["data"]["title"] = "العبارات";

            $this->load->view(style.'/templates/main/core',$data);   

        }

        public function search($keyword = ""){

            if(!$keyword){
                $keyword = $this->input->post("keyword");
            }

            if($keyword){

                foreach(settings("langs") as $lang){
                    $this->db->or_like("word_".$lang->lang_alias,$keyword);
                }

                $words = $this->db->order_by("word_alias","ASC")->get("lang_words")->result();

                $data["data"]["words"] = $words;
                $data["data"]["keyword"] = $keyword;
                $data["views"]["content"] = 'language/list_words';   
                $data["data"]["title"] = "نتائج البحث عن : ".$keyword;

                $this->load->view(style.'/templates/main/core',$data);                  

            }else{
                redirect(base_url(admin_base."language/words"));
            }

        }


        public function add_word(){

            $data["views"]["content"] = "language/add_word";   
            $data["data"]["title"] = "إضافة عبارة";

            $this->load->view(style.'/templates/main/core',$data);

        }

        public function insert_word(){

            $word_alias = get_alias($this->input->post("word_alias"));            

            foreach(settings("langs") as $lang){            
                ${"word_".$lang->lang_alias} = htmlspecialchars(addslashes($this->input->post("word_".$lang->lang_alias)));                
            }

            if($word_alias){

                $count = $this->db->where("word_alias",$word_alias)->count_all_results("lang_words");

                if($count == 0){

                    $data = array(
                        "word_alias"=>$word_alias                        
                    );

                    foreach(settings("langs") as $lang){
                        $data["word_".$lang->lang_alias] = ${"word_".$lang->lang_alias};
                    }

                    $this->db->insert("lang_words",$data);

                    $word_id = $this->db->insert_id();

                    $this->create_files();

                    $this->base->response_page("تم بنجاح","success","تم إضافة العبارة بنجاح",1,"language/add_word");                              

                }else{
                    $this->base->response_page("خطأ","error","دليل العبارة مستخدم من قبل",1,"language/add_word");                              
                }

            }else{
                $this->base->response_page("خطأ","error","يجب إدخال كافة البيانات",1,"language/add_word");                              
            }

        }


        public function update_word(){

            $word_alias = $this->input->post("word_alias");
            $trans = $this->input->post("trans");

            $data = array();

            foreach(settings("langs") as $lang){
                $data["word_".$lang->lang_alias] = htmlspecialchars(addslashes(($trans[$lang->lang_alias])));
            }                        

            if($word_alias && $_POST){

                $this->db->where("word_alias",$word_alias)->limit(1)->update("lang_words",$data);

                $this->create_files();

            }

        }        




        public function delete_word($word_alias){

            $protected = array("style_dir");

            if(!in_array($word_alias,$protected)){

                if(strlen($word_alias) > 0){
                    $this->db->limit(1)->where("word_alias",$word_alias)->delete("lang_words");
                }

                $this->create_files();

                redirect(base_url(admin_base."language/words"));

            }else{
                $this->base->response_page("خطأ","error","لا يمكن حذف هذه العبارة",1,"auto");                              
            }

        }








        public function add_lang(){
            $data["views"]["content"] = "language/add_edit_lang";   
            $data["data"]["title"] = "إضافة لغة";

            $this->load->view(style.'/templates/main/core',$data);            

        }


        public function insert_lang(){
            $lang_alias = get_alias($this->input->post("lang_alias"));
            $lang_title = $this->input->post("lang_title");
            $lang_flag = $this->input->post("lang_flag");
            $lang_dir = $this->input->post("lang_dir");

            if($lang_title && $lang_alias && $lang_dir && $lang_flag){

                $exists = $this->db->where("lang_alias",$lang_alias)->get("langs")->row();

                if(!$exists){                

                    //$this->base->move_temp_upload("langs",$lang_flag);                                      

                    $data = array(
                        "lang_alias"=>$lang_alias,
                        "lang_title"=>$lang_title,
                        "lang_flag"=>$lang_flag,
                        "lang_dir"=>$lang_dir
                    );
                    $this->db->insert("langs",$data);

                    // columns
                    $this->load->dbforge();
                    // words            
                    $fields = array("word_".$lang_alias => array('type' => 'TEXT'));
                    $this->dbforge->add_column('lang_words', $fields);            
                     
                    // direction string
                    $this->db->where("word_alias","style_dir")->update("lang_words",array("word_$lang_alias"=>$lang_dir));                                        

                    $this->create_files();

                    redirect(base_url(admin_base."language/instructions"));

                }else{
                    $this->base->response_page("خطأ","error","الإسم المختصر للغة مستخدم من قبل",1,"auto");                              
                }

            }else{
                $this->base->response_page("خطأ","error","يجب إدخال كافة البيانات",1,"auto");                              
            }
        }


        public function instructions(){

            $data["views"]["content"] = "language/instructions";   
            $data["data"]["title"] = "إرشادات";

            $this->load->view(style.'/templates/main/core',$data);              

        }


        public function edit_lang($lang_alias){

            $lang = $this->db->where("lang_alias",$lang_alias)->get("langs")->row();

            $data["data"]["lang"] = $lang;

            $data["views"]["content"] = "language/add_edit_lang";   
            $data["data"]["title"] = "تعديل لغة";

            $this->load->view(style.'/templates/main/core',$data);                

        }


        public function update_lang(){

            $old_alias = $this->input->post("old_alias");
            $lang_alias = get_alias($this->input->post("lang_alias"));
            $lang_title = $this->input->post("lang_title");
            $lang_flag = $this->input->post("lang_flag");
            $lang_dir = $this->input->post("lang_dir");            

            if($lang_title && $lang_alias && $lang_dir && $old_alias){

                $error = FALSE;

                $data = array(                    
                    "lang_title"=>$lang_title,                
                    "lang_dir"=>$lang_dir
                );                  

                if($old_alias != $lang_alias){

                    $exists = $this->db->where("lang_alias",$lang_alias)->get("langs")->row();

                    if(!$exists){

                        // set new alias field
                        $data["lang_alias"] = $lang_alias;

                        // columns
                        $this->load->dbforge();
                        // words
                        $fields = array("word_".$old_alias => array( 'name' => 'word_'.$lang_alias , "type"=>"TEXT" ));
                        $this->dbforge->modify_column('lang_words', $fields);                                                   

                    }else{
                        $error = TRUE;
                    }

                }       

                if($error == FALSE){

                    $this->db->where("lang_alias",$old_alias)->update("langs",$data);  

                    // direction string
                    $this->db->where("word_alias","style_dir")->update("lang_words",array("word_$lang_alias"=>$lang_dir));                    

                    $this->create_files();

                    redirect(base_url(admin_base."language/instructions"));                

                }else{
                    $this->base->response_page("خطأ","error","الإسم المختصر للغة مستخدم من قبل",1,"auto");                              
                }


            }else{
                $this->base->response_page("خطأ","error","يجب إدخال كافة البيانات",1,"auto");                              
            }

        }



        public function delete_lang($lang_alias){

            if(settings("lang_frontend") != $lang_alias){

                $lang = $this->db->where("lang_alias",$lang_alias)->get("langs")->row();

                // lang
                $this->db->where("lang_alias",$lang_alias)->limit(1)->delete("langs");

                // columns
                $this->load->dbforge();                

                // words
                $this->dbforge->drop_column('lang_words', "word_".$lang_alias);              

                redirect(base_url(admin_base."language"));

            }else{
                $this->base->response_page("خطأ","error","هذه اللغة هى اللغة الإفتراضية الحالية",1,"auto");                              
            }            

        }        


        public function import($lang_alias = "ar"){

            $lang = $this->db->where("lang_alias",$lang_alias)->get("langs")->row();

            if($lang){

                $data["data"]["lang"] = $lang;

                $data["views"]["content"] = "language/import_lang";   
                $data["data"]["title"] = "استيراد ملف لغة";

                $this->load->view(style.'/templates/main/core',$data);   

            }

        }

        public function upload(){

            $lang_alias = $this->input->post("lang_alias");

            $result = $this->db->select("word_alias")->get("lang_words")->result();

            $current_aliases = get_ids_array($result,"word_alias");

            if($lang_alias){

                $file_name = "lang_".$lang_alias."_".time(); 
                $folder = upload_base."temp/";
                $result = $this->base->upload_doc($file_name,$folder,'json|JSON');
                //prnt($this->upload->display_errors());
                if($result["file"]){

                    $json = file_get_contents(FCPATH.$folder.$result["file"]);

                    $arr = json_decode($json);

                    $words = array();
                    $new_words = array();
                    foreach($arr as $alias => $trans){

                        $trans = stripslashes($trans);
                        $trans = htmlspecialchars(addslashes($trans));

                        if($alias){
                            if(in_array($alias,$current_aliases)){
                                $words[] = array("word_alias" => $alias , "word_".$lang_alias => $trans);                           
                            }else{
                                $new_words[] = array("word_alias" => $alias , "word_".$lang_alias => $trans);                           
                            }
                        }
                    }


                    if($words){
                        $this->db->update_batch('lang_words', $words, 'word_alias'); 
                    }

                    if($new_words){                    
                        $this->db->insert_batch('lang_words', $new_words, 'word_alias'); 
                    }

                    if($words || $new_words){
                        $this->create_files();   

                        $this->base->response_page("تم بنجاح","success","تم تحديث عبارات اللغة بنجاح ",1,"language");                              
                    }else{
                        $this->base->response_page("خطأ","error","الملف المرفوع لا يحتوى على عبارات",1,"auto");                              
                    }

                }else{
                    $this->base->response_page("خطأ","error","خطأ فى رفع الملف , من فضلك تأكد من إمتداد ومحتوى الملف",1,"auto");                              
                }


            }

        }




        public function download($lang_alias){

            $file = FCPATH."langs/lang_".$lang_alias.".php";

            // get $lang array
            require($file);


            // save as temp JSON array
            if(defined('JSON_UNESCAPED_UNICODE')){            
                $encoded = json_encode($lang,JSON_UNESCAPED_UNICODE);                
            }else{
                $encoded = json_encode($lang);                
                $fixed = $this->base->json_fix($encoded);
                if($fixed){
                    $encoded = $fixed;
                }
            }            
                              
            file_put_contents(FCPATH.upload_base."temp/lang_".$lang_alias.".txt",$encoded); 

            $temp = FCPATH.upload_base."temp/lang_".$lang_alias.".txt";

            $fp = fopen($temp, 'rb');

            $fakeFileName= "lang_".$lang_alias."_".time().".json";

            header("Content-Type: application/octet-stream");
            header("Content-Disposition: attachment; filename=$fakeFileName");
            header("Content-Length: " . filesize($temp));
            fpassthru($fp);               


        }


        public function rebuild(){

            $this->create_files();

            $error = FALSE;

            foreach(settings("langs") as $lang){

                if(!file_exists(FCPATH.'langs/lang_'.$lang->lang_alias.'.php')){
                    $this->base->response_page("خطأ","error","ملف اللغة [ ".$lang->lang_title." ] غير موجود",1,"auto");                              
                    $error = TRUE;
                    break;
                }

            }

            if($error == FALSE){
                $this->base->response_page("تم بنجاح","success","تم إعادة بناء ملفات اللغة بنجاح",1,"auto");                              
            }

        }



        public function create_files(){

            $words = $this->db->order_by("word_alias","ASC")->get("lang_words")->result();

            foreach(settings("langs") as $lang){
                ${"text_".$lang->lang_alias} = "<?php ";    
            }    

            foreach($words as $word){
                foreach(settings("langs") as $lang){      

                    $__w = stripslashes($word->{"word_".$lang->lang_alias});

                    ${"text_".$lang->lang_alias} .= "
".'$lang['."'".$word->word_alias."'".'] = '."'".htmlspecialchars(addslashes($__w))."'".';';

                }                                                                          
            }

            foreach(settings("langs") as $lang){                                                       
                file_put_contents(FCPATH."langs/lang_".$lang->lang_alias.".php",${"text_".$lang->lang_alias});                            
            }

        }



}