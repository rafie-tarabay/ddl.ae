<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sections extends MY_Controller {

    var $locale;

    public function __construct() {
        parent::__construct();
        $this->locale = locale == "ar" ? "ar" : "en";
    }    


    public function load($book_name)
    {
        $data["data"]["hide_simple_search"] = TRUE;   
        $data["data"]["hide_cats"] = TRUE;                 
        $data["views"]["content_url"] = 'https://ddl.ae/uploads/books/'.$book_name;   
        $data["views"]["title"] = "Test";
        $this->load->view(design_path.'/templates/main/core',$data);   
    }
    public function index($sec_alias){

        $this->db->select("sec_title_".$this->locale." as title, sec_desc_".$this->locale." as desc, sec_cover_".$this->locale." as cover, sections.*");
        $this->db->where("sec_alias",$sec_alias);
        $section = $this->db->limit(1)->get("sections")->row();                     
        
        $this->db->select("widget_id, widget_title_".$this->locale." as title, widget_grid_css_class, widget_card_css_class, widget_show_title");
        $this->db->where("widget_sec_id",$section->sec_id);
        $widgets = $this->db->order_by("widget_order","ASC")->get("sections_widgets")->result();            
        if($widgets){
            $w_ids = get_ids_array($widgets,"widget_id");

            $this->db->select("item_class,item_id,item_widget_id");
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

        $data["data"]["hide_simple_search"] = TRUE;   
        $data["data"]["hide_cats"] = TRUE;   
        $data["data"]["widgets"] = $widgets;   
        $data["data"]["section"] = $section;        
        $data["views"]["content"] = 'sections/widgets';   
        $data["views"]["title"] = $section->{"sec_title_".$this->locale};

        $this->load->view(design_path.'/templates/main/core',$data);   

    }



}