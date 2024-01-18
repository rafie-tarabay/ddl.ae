<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sections extends MY_Controller {

    var $locale;

    public function __construct() {
        parent::__construct();
        if(!logged_in){ redirect(base_url(admin_base."admins/login")); exit; }
        $this->locale = locale == "ar" ? "ar" : "en";
    }    


    public function index(){

        if( can("edit_sections") ){

            $this->db->select("sections.*, sec_title_".$this->locale." as title");
            $sections = $this->db->order_by("sec_order","ASC")->get("sections")->result();

            $data["data"]["sections"] = $sections;
            $data["views"]["content"] = 'sections/list_sections';   
            $data["data"]["title"] = "المكتبات";

            $this->load->view(style.'/templates/main/core',$data);    

        } 

    }


    public function add_section(){

        if( can("edit_sections") ){

            $data["views"]["content"] = 'sections/forms/add_edit_section';   
            $data["data"]["title"] = "اضافة مكتبة";

            $this->load->view(style.'/templates/main/core',$data);    

        }       

    }


    public function insert_section(){

        if( can("edit_sections") ){

            $sec_alias = $this->input->post("sec_alias");  
            $sec_title_ar = $this->input->post("sec_title_ar");  
            $sec_title_en = $this->input->post("sec_title_en");  
            $sec_desc_ar = $this->input->post("sec_desc_ar");  
            $sec_desc_en = $this->input->post("sec_desc_en"); 
            $sec_cover_ar = $this->input->post("sec_cover_ar");  
            $sec_cover_en = $this->input->post("sec_cover_en");               
            $sec_order = $this->input->post("sec_order");  

            $data = array(
                "sec_alias" => trim($sec_alias),
                "sec_title_ar" => trim($sec_title_ar),
                "sec_title_en" => trim($sec_title_en),
                "sec_desc_ar" => trim($sec_desc_ar),
                "sec_desc_en" => trim($sec_desc_en),                
                "sec_cover_ar" => trim($sec_cover_ar) ? trim($sec_cover_ar) : NULL,
                "sec_cover_en" => trim($sec_cover_en) ? trim($sec_cover_en) : NULL,
                "sec_order" => trim($sec_order) ? trim($sec_order) : 0,
            );

            $this->db->insert("sections",$data);

            redirect(base_url(admin_base."sections/"));

        }       

    }



    public function edit_section($sec_id){

        if( can("edit_sections") ){

            $this->db->where("sec_id",$sec_id);
            $section = $this->db->limit(1)->get("sections")->row();                        

            $data["data"]["section"] = $section;
            $data["views"]["content"] = 'sections/forms/add_edit_section';   
            $data["data"]["title"] = "اضافة مكتبة";            

            $this->load->view(style.'/templates/main/core',$data);    

        }       

    }


    public function update_section(){

        if( can("edit_sections") ){

            $sec_alias = $this->input->post("sec_alias");  
            $sec_title_ar = $this->input->post("sec_title_ar");  
            $sec_title_en = $this->input->post("sec_title_en");  
            $sec_desc_ar = $this->input->post("sec_desc_ar");  
            $sec_desc_en = $this->input->post("sec_desc_en");  
            $sec_cover_ar = $this->input->post("sec_cover_ar");  
            $sec_cover_en = $this->input->post("sec_cover_en");                           
            $sec_order = $this->input->post("sec_order");  
            $sec_id = $this->input->post("sec_id");  

            $data = array(
                "sec_alias" => trim($sec_alias),
                "sec_title_ar" => trim($sec_title_ar),
                "sec_title_en" => trim($sec_title_en),
                "sec_desc_ar" => trim($sec_desc_ar),
                "sec_desc_en" => trim($sec_desc_en),
                "sec_cover_ar" => trim($sec_cover_ar) ? trim($sec_cover_ar) : NULL,
                "sec_cover_en" => trim($sec_cover_en) ? trim($sec_cover_en) : NULL,                
                "sec_order" => trim($sec_order) ? trim($sec_order) : 0,
            );         
            $this->db->where("sec_id",$sec_id)->update("sections",$data);

            redirect(base_url(admin_base."sections/"));

        }       

    }





    //////////////////// Widgets


    public function widgets($sec_id){

        if( can("edit_sections") ){


            $this->db->select("widget_id, widget_title_".$this->locale." as title, widget_order");
            $this->db->where("widget_sec_id",$sec_id);
            $widgets = $this->db->order_by("widget_order","ASC")->get("sections_widgets")->result();            
            if($widgets){
                $w_ids = get_ids_array($widgets,"widget_id");

                $this->db->select("item_class,item_id,item_order,item_widget_id");
                $items = $this->db->where_in("item_widget_id",$w_ids)->order_by("item_order","ASC")->get("sections_widget_items")->result();
                if($items){
                    $i_ids = get_ids_array($items,"item_id");

                    $this->db->select("field_item_id, field_name as name, field_value_".$this->locale." as value");
                    $fields = $this->db->where_in("field_item_id",$i_ids)->get("sections_widget_fields")->result();

                    foreach($widgets as $widget){
                        $widget->items = array();
                        foreach($items as $item){
                            $item->fields = array();
                            foreach($fields as $field){
                                if($item->item_id == $field->field_item_id){
                                    $item->fields[$field->name] = $field->value;
                                }
                            }
                            if($widget->widget_id == $item->item_widget_id){
                                $widget->items[] = $item;
                            }
                        }                
                    }

                }
            }

            $data["data"]["widgets"] = $widgets;   

            /////////

            $classes = $this->db->order_by("class_id","DESC")->get("sections_content_classes")->result();            

            $data["data"]["classes"] = $classes;

            /////////

            $this->db->where("sec_id",$sec_id);
            $section = $this->db->limit(1)->get("sections")->row();             

            $data["data"]["section"] = $section;

            /////////  

            $data["views"]["content"] = 'sections/widgets';   
            $data["data"]["title"] = $section->sec_title_ar." - الويدجيتس";

            $this->load->view(style.'/templates/main/core',$data);   

        } 

    }



    public function add_widget($sec_id){

        if( can("edit_sections") ){

            $this->db->select("sections.*, sec_title_".$this->locale." as title");
            $sections = $this->db->order_by("sec_order","DESC")->get("sections")->result();

            $data["data"]["sections"] = $sections;
            $data["data"]["sec_id"] = $sec_id;
            $data["views"]["content"] = 'sections/forms/add_edit_widget';               
            $data["data"]["title"] = "اضافة ويدجيت";

            $this->load->view(style.'/templates/main/core',$data);    

        }       

    }


    public function insert_widget(){

        if( can("edit_sections") ){

            $widget_sec_id = $this->input->post("widget_sec_id");  
            $widget_show_title = $this->input->post("widget_show_title");  
            $widget_title_ar = $this->input->post("widget_title_ar");  
            $widget_title_en = $this->input->post("widget_title_en");  
            $widget_multiple_items = $this->input->post("widget_multiple_items");  
            $widget_max_items = $this->input->post("widget_max_items");  
            $widget_slider = $this->input->post("widget_slider");  
            $widget_grid_css_class = $this->input->post("widget_grid_css_class");  
            $widget_card_css_class = $this->input->post("widget_card_css_class");  
            $widget_order = $this->input->post("widget_order");  

            $data = array(
                "widget_sec_id" => trim($widget_sec_id),
                "widget_show_title" => trim($widget_show_title),
                "widget_title_ar" => trim($widget_title_ar),
                "widget_title_en" => trim($widget_title_en),
                "widget_multiple_items" => trim($widget_multiple_items),
                "widget_max_items" => trim($widget_max_items),
                "widget_slider" => trim($widget_slider),
                "widget_grid_css_class" => trim($widget_grid_css_class),
                "widget_card_css_class" => trim($widget_card_css_class),
                "widget_order" => trim($widget_order) ? trim($widget_order) : 0,
                "widget_timestamp" => time(),
            );

            $this->db->insert("sections_widgets",$data);

            redirect(base_url(admin_base."sections/widgets/".$widget_sec_id));

        }       

    }

    public function edit_widget($widget_id){

        if( can("edit_sections") ){

            $widget = $this->db->where("widget_id",$widget_id)->limit(1)->get("sections_widgets")->row();

            $this->db->select("sections.*, sec_title_".$this->locale." as title");
            $sections = $this->db->order_by("sec_order","DESC")->get("sections")->result();

            $data["data"]["widget"] = $widget;
            $data["data"]["sections"] = $sections;
            $data["views"]["content"] = 'sections/forms/add_edit_widget';               
            $data["data"]["title"] = "اضافة ويدجيت";

            $this->load->view(style.'/templates/main/core',$data);    

        }       

    }


    public function update_widget(){

        if( can("edit_sections") ){

            $widget_sec_id = $this->input->post("widget_sec_id");  
            $widget_show_title = $this->input->post("widget_show_title");  
            $widget_title_ar = $this->input->post("widget_title_ar");  
            $widget_title_en = $this->input->post("widget_title_en");  
            $widget_multiple_items = $this->input->post("widget_multiple_items");  
            $widget_max_items = $this->input->post("widget_max_items");  
            $widget_slider = $this->input->post("widget_slider");  
            $widget_grid_css_class = $this->input->post("widget_grid_css_class");  
            $widget_card_css_class = $this->input->post("widget_card_css_class");  
            $widget_order = $this->input->post("widget_order");  
            $widget_id = $this->input->post("widget_id");  

            $data = array(
                "widget_sec_id" => trim($widget_sec_id),
                "widget_show_title" => trim($widget_show_title),
                "widget_title_ar" => trim($widget_title_ar),
                "widget_title_en" => trim($widget_title_en),
                "widget_multiple_items" => trim($widget_multiple_items),
                "widget_max_items" => trim($widget_max_items),
                "widget_slider" => trim($widget_slider),
                "widget_grid_css_class" => trim($widget_grid_css_class),
                "widget_card_css_class" => trim($widget_card_css_class),
                "widget_order" => trim($widget_order) ? trim($widget_order) : 0,
                "widget_timestamp" => time(),
            );

            $this->db->where("widget_id",$widget_id)->update("sections_widgets",$data);

            redirect(base_url(admin_base."sections/widgets/".$widget_sec_id));

        }       

    }


    public function delete_widget($widget_id,$redirect = TRUE){

        if( can("edit_sections") ){

            $this->db->trans_start();

            $items = $this->db->where("item_widget_id",$widget_id)->get("sections_widget_items")->result();

            foreach($items as $item){
                $this->db->where("item_id",$item->item_id)->limit(1)->delete("sections_widget_items");
                $this->db->where("field_item_id",$item->item_id)->delete("sections_widget_fields");            
            }

            $this->db->where("widget_id",$widget_id)->limit(1)->delete("sections_widgets");

            if ( $this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
            }else{
                $this->db->trans_commit();
            }          

            if($redirect) redirect(go_back());

        }       


    }



    ////////////////// items

    public function add_item($class,$widget_id){

        if( can("edit_sections") ){

            $fields = $this->db->where("f_class_name",$class)->order_by("f_order")->get("sections_content_classes_fields")->result();

            $widget = $this->db->where("widget_id",$widget_id)->limit(1)->get("sections_widgets")->row();

            $data["data"]["fields"] = $fields;
            $data["data"]["widget"] = $widget;
            $data["data"]["class"] = $class;
            $data["views"]["content"] = 'sections/forms/add_edit_item';               
            $data["data"]["title"] = "اضافة محتوى لويدجيت";

            $this->load->view(style.'/templates/main/core',$data);    

        }       

    }


    public function insert_item(){

        if( can("edit_sections") ){

            $this->db->trans_start();

            $widget_sec_id = $this->input->post("widget_sec_id"); // for redirection

            $item_widget_id = $this->input->post("item_widget_id");                          
            $item_class = $this->input->post("item_class");                          
            $item_order = $this->input->post("item_order");                          

            $data = array(
                "item_widget_id" => trim($item_widget_id),
                "item_class" => trim($item_class),
                "item_order" => trim($item_order) ? trim($item_order) : 0,
            );
            $this->db->insert("sections_widget_items",$data);

            $item_id = $this->db->insert_id();


            $fields = $this->db->where("f_class_name",$item_class)->order_by("f_order")->get("sections_content_classes_fields")->result();

            foreach($fields as $field){ 

                $field_name = $field->f_name;                
                $field_value_ar = $_POST[$field_name]["ar"];   
                $field_value_en = $_POST[$field_name]["en"];   

                $data = array(
                    "field_item_id" => trim($item_id),
                    "field_name" => trim($field_name),
                    "field_value_ar" => trim($field_value_ar),
                    "field_value_en" => trim($field_value_en),
                );

                $this->db->insert("sections_widget_fields",$data);                

            }

            if ( !$item_id || !$fields || $this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
            }elseif($item_id && $fields){
                $this->db->trans_commit();
            }            
            redirect(base_url(admin_base."sections/widgets/".$widget_sec_id));

        }       

    }

    public function edit_item($item_id){

        if( can("edit_sections") ){

            $item = $this->db->where("item_id",$item_id)->limit(1)->get("sections_widget_items")->row();

            $fields = $this->db->where("f_class_name",$item->item_class)->order_by("f_order")->get("sections_content_classes_fields")->result();

            $_myfields = $this->db->where("field_item_id",$item->item_id)->get("sections_widget_fields")->result();

            $widget = $this->db->where("widget_id",$item->item_widget_id)->limit(1)->get("sections_widgets")->row();

            $myfields = array();
            foreach($_myfields as $myfield){
                $myfields[$myfield->field_name] = $myfield;
            }

            $data["data"]["fields"] = $fields;
            $data["data"]["myfields"] = $myfields;
            $data["data"]["widget"] = $widget;
            $data["data"]["class"] = $item->item_class;
            $data["data"]["item"] = $item;
            $data["views"]["content"] = 'sections/forms/add_edit_item';               
            $data["data"]["title"] = "تعديل محتوى لويدجيت";

            $this->load->view(style.'/templates/main/core',$data);    

        }       

    }


    public function update_item(){

        if( can("edit_sections") ){

            $this->db->trans_start();

            $widget_sec_id = $this->input->post("widget_sec_id"); // for redirection

            $item_widget_id = $this->input->post("item_widget_id");                          
            $item_class = $this->input->post("item_class");                          
            $item_order = $this->input->post("item_order");                          
            $item_id = $this->input->post("item_id");                          

            $data = array(
                "item_order" => trim($item_order) ? trim($item_order) : 0,
            );
            $this->db->where("item_id",$item_id)->update("sections_widget_items",$data);

            $fields = $this->db->where("f_class_name",$item_class)->order_by("f_order")->get("sections_content_classes_fields")->result();

            //prnt($fields);

            foreach($fields as $field){ 

                $field_name = $field->f_name;                
                $field_value_ar = $_POST[$field_name]["ar"];   
                $field_value_en = $_POST[$field_name]["en"];   

                $data = array(
                    "field_name" => trim($field_name),
                    "field_value_ar" => trim($field_value_ar),
                    "field_value_en" => trim($field_value_en),
                );                

                $this->db->where("field_item_id",$item_id)->where("field_name",$field_name);
                $field = $this->db->get("sections_widget_fields")->row();                                

                if($field){
                    $this->db->where("field_id",$field->field_id);
                    $field = $this->db->update("sections_widget_fields",$data);                                
                }else{
                    $data["field_item_id"] = $item_id;
                    $this->db->insert("sections_widget_fields",$data);      
                }   

                //lq( $this->db);
            }

            if ( !$item_id || !$fields || $this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
            }elseif($item_id && $fields){
                $this->db->trans_commit();
            }            
            redirect(base_url(admin_base."sections/widgets/".$widget_sec_id));

        }       


    }




    public function delete_item($item_id,$redirect = TRUE){

        if( can("edit_sections") ){

            $this->db->trans_start();

            $this->db->where("item_id",$item_id)->limit(1)->delete("sections_widget_items");

            $this->db->where("field_item_id",$item_id)->delete("sections_widget_fields");

            if ( $this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
            }else{
                $this->db->trans_commit();
            }          

            if($redirect) redirect(go_back());

        }       


    }




    //////////////////// Classes

    public function content_classes(){

        if( can("edit_sections_classes") ){

            $classes = $this->db->order_by("class_id","DESC")->get("sections_content_classes")->result();

            $data["data"]["classes"] = $classes;
            $data["views"]["content"] = 'sections/content_classes';   
            $data["data"]["title"] = "أنواع المحتوى";

            $this->load->view(style.'/templates/main/core',$data);    

        }       

    }


    public function class_fields($class){

        if( can("edit_sections_classes") ){

            $this->db->where("f_class_name",$class);
            $fields = $this->db->order_by("f_order","ASC")->get("sections_content_classes_fields")->result();

            $data["data"]["class"] = $class;
            $data["data"]["fields"] = $fields;
            $data["views"]["content"] = 'sections/class_fields';   
            $data["data"]["title"] = "حقول - ".$class;

            $this->load->view(style.'/templates/main/core',$data);    

        }       

    }


    public function add_class(){

        if( can("edit_sections_classes") ){

            $data["views"]["content"] = 'sections/forms/add_edit_class';   
            $data["data"]["title"] = "اضافة نوع";

            $this->load->view(style.'/templates/main/core',$data);    

        }       

    }


    public function insert_class(){

        if( can("edit_sections_classes") ){

            $class_name = $this->input->post("class_name");  

            $exists = $this->db->where("class_name",$class_name)->limit(1)->get("sections_content_classes")->row();

            if(!$exists){

                $data = array(
                    "class_name" => trim($class_name),
                );

                $this->db->insert("sections_content_classes",$data);

            }

            redirect(base_url(admin_base."sections/class_fields/".$class_name));

        }       

    }



    public function edit_class($class_id){

        if( can("edit_sections_classes") ){

            $this->db->where("class_id",$class_id);
            $class = $this->db->limit(1)->get("sections_content_classes")->row();                        

            $data["data"]["class"] = $class;
            $data["views"]["content"] = 'sections/forms/add_edit_class';   
            $data["data"]["title"] = "اضافة نوع";            

            $this->load->view(style.'/templates/main/core',$data);    

        }       

    }


    public function update_class(){

        if( can("edit_sections_classes") ){

            $class_name = $this->input->post("class_name");  
            $class_id = $this->input->post("class_id");  

            $class = $this->db->where("class_id",$class_id)->limit(1)->get("sections_content_classes")->row();

            $exists = $this->db->where("class_id !=",$class_id)->where("class_name",$class_name)->limit(1)->get("sections_content_classes")->row();

            if(!$exists){            

                $data = array(
                    "class_name" => trim($class_name),
                );            
                $this->db->where("class_id",$class_id)->update("sections_content_classes",$data);


                $data = array(
                    "f_class_name" => trim($class_name),
                );            
                $this->db->where("f_class_name",$class->class_name)->update("sections_content_classes_fields",$data);            

            }

            redirect(base_url(admin_base."sections/class_fields/".$class_name));

        }       

    }




    public function add_class_field($class){

        if( can("edit_sections_classes") ){

            $data["data"]["class"] = $class;
            $data["views"]["content"] = 'sections/forms/add_edit_class_field';   
            $data["data"]["title"] = "اضافة حقل - ".$class;

            $this->load->view(style.'/templates/main/core',$data);    

        }       

    }


    public function insert_class_field(){

        if( can("edit_sections_classes") ){

            $f_class_name = $this->input->post("f_class_name");  
            $f_name = $this->input->post("f_name");  
            $f_required = $this->input->post("f_required");  
            $f_element = $this->input->post("f_element");  
            $f_selectables = $this->input->post("f_selectables");  
            $f_order = $this->input->post("f_order");  

            $exists = $this->db->where("f_name",$f_name)->where("f_class_name",$f_class_name)->limit(1)->get("sections_content_classes_fields")->row();

            if(!$exists){             

                $data = array(
                    "f_class_name" => trim($f_class_name),
                    "f_name" => trim($f_name),
                    "f_required" => trim($f_required),
                    "f_element" => trim($f_element),
                    "f_selectables" => trim($f_selectables) ? trim($f_selectables) : NULL,
                    "f_order" =>  trim($f_order) ? trim($f_order) : 0,
                );

                $this->db->insert("sections_content_classes_fields",$data);

            }

            redirect(base_url(admin_base."sections/class_fields/".$f_class_name));

        }       

    }


    public function edit_class_field($f_id){

        if( can("edit_sections_classes") ){

            $this->db->where("f_id",$f_id);
            $field = $this->db->limit(1)->get("sections_content_classes_fields")->row();            

            $data["data"]["field"] = $field;
            $data["data"]["class"] = $field->f_class_name;
            $data["views"]["content"] = 'sections/forms/add_edit_class_field';   
            $data["data"]["title"] = "تعديل حقل - ".$field->f_class_name;

            $this->load->view(style.'/templates/main/core',$data);    

        }       

    }


    public function update_class_field(){

        if( can("edit_sections_classes") ){

            $f_class_name = $this->input->post("f_class_name");  
            $f_name = $this->input->post("f_name");  
            $f_required = $this->input->post("f_required");  
            $f_element = $this->input->post("f_element");  
            $f_selectables = $this->input->post("f_selectables");  
            $f_order = $this->input->post("f_order");  
            $f_id = $this->input->post("f_id");  

            $this->db->where("f_id !=",$f_id)->where("f_name",$f_name)->where("f_class_name",$f_class_name);
            $exists = $this->db->limit(1)->get("sections_content_classes_fields")->row();

            if(!$exists){              

                $data = array(
                    "f_class_name" => trim($f_class_name),
                    "f_name" => trim($f_name),
                    "f_required" => trim($f_required),
                    "f_element" => trim($f_element),
                    "f_selectables" => trim($f_selectables) ? trim($f_selectables) : NULL,
                    "f_order" => trim($f_order) ? trim($f_order) : 0,
                );

                $this->db->where("f_id",$f_id)->update("sections_content_classes_fields",$data);

            }

            redirect(base_url(admin_base."sections/class_fields/".$f_class_name));

        }       

    }




    public function delete_class_field($f_id){

        if( can("edit_sections_classes") ){

            $this->db->where("f_id",$f_id);
            $field = $this->db->limit(1)->get("sections_content_classes_fields")->row();                        

            $this->db->where("f_id",$f_id);
            $this->db->limit(1)->delete("sections_content_classes_fields");            

            redirect(base_url(admin_base."sections/class_fields/".$field->f_class_name));

        }       

    }




}