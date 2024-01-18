<?php

class Search_gate_model extends base{

    var $query_delimiter = '|';
    var $array_delimiter = ';';
    var $keyword_min_len = 3;        

    public function __construct(){
        parent::__construct();           
        $this->db = $this->load->database("frontend",true); 
    }     

    public function get_searchables(){

        return array(
            "operators" => $this->get_searchable_operators(),
            "fields" => $this->get_searchable_fields(),
            "matches" => $this->get_searchable_matches(),
            "formats" => $this->get_searchable_formats(),
            "prices" => $this->get_searchable_prices(),
            "date_range" => $this->get_searchable_date_range(),
            "sorts" => $this->get_searchable_sorts(),
            "bibs" => $this->get_biblio_types(),        
            "dewies" => $this->get_dewies(),
            "sources" => $this->get_sources(),            
        );

    }


    public function get_searchable_operators(){
        return array("and", "or", "not");
    }

    public function get_searchable_matches(){
        return array("partial", "exact");    
    }

    public function get_searchable_fields(){
        return array(
            "title",
            "author",
            "content",
            "publisher",
            "series",
            "subjects",
            "coauthors",
            "publication_year"
        );    
    }

    public function get_searchable_formats(){
        return array("file_pdf", "file_epub");    
    }

    public function get_searchable_prices(){
        return array("free", "paid");    
    }

    public function get_searchable_date_range(){
        return array( "min" => "1852", "max" => date("Y") );    
    }

    public function get_searchable_sorts(){
        return array(
            "none", 
            "publication_year", 
            "title", 
            "author", 
            "publisher", 
            //"score"
        );    
    }

    public function get_biblio_types(){
        return array(
            1  => "book",
            10 => "summary",
            14 => "chapter",
            3  => "journal",
            11 => "newspaper",
            2  => "article",
            4  => "report",
            6  => "conference",
            5  => "thesis",
            9  => "manuscript",
            7  => "audible",
            8  => "video",
            13 => "photos",
            12 => "kids"
        );
    }    

    public function get_dewies($locale = locale,$where_in=FALSE){
        $fields = $locale != 'ar' ? 'sq AS id,title_en AS title' : 'sq AS id,title';

        if(!$where_in || !is_array($where_in)){
            $dewies = $this->cache->get('dewies_'.$locale);        
            if ( !$dewies ){
                $this->db->where('total >', 0);
                $dewies = $this->db->select($fields)->order_by('title ASC')->get("subject01")->result();
                $this->cache->save('dewies_'.$locale, $dewies, 60*60*24);
            }                   
        }elseif($where_in && is_array($where_in)){
            $this->db->where_in("id",$where_in);
            $dewies = $this->db->select($fields)->order_by('title ASC')->get("subject01")->result();
        }


        $returned = array();
        foreach($dewies as $dewey){
            if($dewey->id == 0){
                $dewey->id = "000";
            }
            $returned[$dewey->id] = $dewey->title;
        }        

        return $returned;
    }    

    public function get_sources($locale = locale,$where_in=FALSE){        
        $fields = $locale != 'ar' ? 'id, title_en as title' : 'id, title_ar as title';                

        if(!$where_in || !is_array($where_in)){
            $sources = $this->cache->get('sources_'.$locale);        
            if ( !$sources ){
                $sources = $this->db->select($fields)->get("sources")->result();
                $this->cache->save('sources_'.$locale, $sources, 60*60*24);
            }                   
        }elseif($where_in && is_array($where_in)){
            $this->db->where_in("id",$where_in);
            $sources = $this->db->select($fields)->get("sources")->result();
        }        

        $returned = array();
        foreach($sources as $source){
            $returned[$source->id] = $source->title;
        }        
        return $returned;        
    }    

    public function get_publishers($locale = locale,$where_in=FALSE){        
        $fields = $locale != 'ar' ? 'id, publisherName_en as title' : 'id, publisherName as title';                
        if($where_in && is_array($where_in)) $this->db->where_in("id",$where_in);
        $publishers = $this->db->select($fields)->get("publishers")->result();
        $returned = array();
        foreach($publishers as $publisher){
            $returned[$publisher->id] = $publisher->title;
        }        
        return $returned;        
    }  

    public function get_authors($locale = locale,$where_in=FALSE){        
        $fields = $locale != 'ar' ? 'id, title_en as title' : 'id, title_ar as title';                
        if($where_in && is_array($where_in)) $this->db->where_in("id",$where_in);
        $authors = $this->db->select($fields)->get("marc_authorities")->result();
        $returned = array();
        foreach($authors as $author){
            $returned[$author->id] = $author->title;
        }        
        return $returned;        
    }    

    public function get_langs($locale = locale,$where_in=FALSE){        
        $returned = array();
        $fields = $locale != 'ar' ? 'lang_iso_639_2 as id, lang_name_en as title' : 'lang_iso_639_2 as id, lang_name_ar as title';                
        if($where_in && is_array($where_in)) $this->db->where_in("lang_iso_639_2",$where_in);
        $langs = $this->db->select($fields)->get("languages")->result();        
        foreach($langs as $lang){
            $returned[$lang->id] = $lang->title;
        }        
        return $returned;        
    }    

    public function get_cities($locale = locale,$where_in=FALSE){        
        $fields = $locale != 'ar' ? 'id, title_en as title' : 'id, title_ar as title';                
        if($where_in && is_array($where_in)) $this->db->where_in("id",$where_in);
        $cities = $this->db->select($fields)->get("cities")->result();
        $returned = array();
        foreach($cities as $city){
            $returned[$city->id] = $city->title;
        }        
        return $returned;        
    }    


    public function get_disabled_sources(){
        $sources = $this->cache->get('disables_sources');        
        if ( !$sources ){
            $sources = $this->db->select("id")->where("disabled",1)->get("sources")->result();
            $this->cache->save('disables_sources', $sources, 60*60*24);
        }
        $returned = array();
        foreach($sources as $source){
            $returned[] = $source->id;
        }        
        return $returned; 
    }

    ///////////////////////////////////////

    public function post_fields(){
        return array(            
            "boxes"         => array(), // Queries
            "ids"           => array(), // ids
            "bibs"          => array(), // Biblo types
            "dewies"        => array(), // dewies
            "publishers"    => array(), // publishers
            "authors"       => array(), // authors
            "sources"       => array(), // sources
            "langs"         => array(), // languages
            "formats"       => array(), // formats
            "prices"        => array(), // price
            "date"          => array(), // date range
            "years"         => array(), // years
            "cities"        => array(), // cities
            "sort"          => array(), // sort
        ); 
    }

    public function get_fields(){
        return array(
            "queries"       => array(), // Queries
            "ids"           => array(), // ids            
            "bibs"          => array(), // Biblo types
            "dewies"        => array(), // dewies
            "publishers"    => array(), // publishers
            "authors"       => array(), // authors
            "sources"       => array(), // sources
            "langs"         => array(), // languages
            "formats"       => array(), // formats
            "prices"        => array(), // price
            "date"          => array(), // date range
            "years"         => array(), // years
            "cities"        => array(), // cities
            "sort"          => array(), // sort
        ); 
    }



    //////////////////// Validation    

    public function validate_posted_data(){
        $returned = array();        
        $post_fields = $this->post_fields();
        foreach($post_fields as $key => $val){
            $data = $this->input->post($key);                              
            if(method_exists($this,"validate_".$key) && $data ){
                $valid = $this->{"validate_".$key}($data);
                if($valid){
                    $returned[$key] = $valid;
                }                
            }
        }               
        return $returned;
    }


    public function validate_url_data(){           
        $validated = array();
        $get_fields = $this->get_fields();
        foreach($get_fields as $key => $val){
            $data = $this->input->get($key);
            if(is_array($val) && $data){
                $data = explode($this->array_delimiter,$data);
            }
            if(method_exists($this,"validate_".$key) && $data ){                
                $valid = $this->{"validate_".$key}($data);
                if($valid){
                    $validated[$key] = $valid;
                }
            }
        }        

        $returned["sort"] = isset($validated["sort"]) ? $validated["sort"] : array();
        $returned["queries"] = isset($validated["queries"]) ? $validated["queries"] : array();        
        unset($validated["queries"]);
        unset($validated["sort"]);
        $returned["filters"] = $validated;

        return $returned;        
    }



    /// validate ids
    public function validate_ids($ids){    
        $returned = array();                
        if($ids){
            foreach($ids as $id){
                $id = (int) $id;
                if($id > 0){
                    $returned[] = $id;   
                }
            }        
        }
        return $returned;
    }

    /// validate boxes
    public function validate_boxes($boxes){    
        $returned = array();                
        if($boxes){
            foreach($boxes as $box){
                if($query = $this->box_to_query($box)){
                    $returned[] = $query;   
                }
            }        
        }
        return $returned;
    }

    /// validate Queries
    public function validate_queries($queries){    
        $returned = array();                
        if($queries){   
            foreach($queries as $query){
                $exq = explode($this->query_delimiter ,$query);
                $operator = in_array($exq[0],$this->get_searchable_operators()) ?  $exq[0] : "or";
                $field    = in_array($exq[1],$this->get_searchable_fields()) || $exq[1] == "all" ?  $exq[1] : "all";                
                if( strlen($exq[2]) >= $this->keyword_min_len && $keywords = $exq[2] ){

                    $keywords = $this->clear_keywords($keywords);

                    if($field == "all"){
                        foreach($this->get_searchable_fields() as $fld){
                            $returned[] = array(
                                "operator" => "or",
                                "field" => $fld,
                                "keywords" => $keywords,
                            );                                          
                        }
                    }else{
                        $returned[] = array(
                            "operator" => $operator,
                            "field" => $field,
                            "keywords" => $keywords,
                        );                        
                    }
                }                
            }        
        }
        return $returned;
    }


    // validate biblo Types            
    public function validate_bibs($bibs){            
        $returned = array();                
        if($bibs){
            $bts = $this->get_biblio_types();
            foreach($bibs as $bib){
                if(@$bts[$bib]){
                    $returned[] = $bib;
                }
            }        
        }
        return $returned;
    }


    // validate dewies
    public function validate_dewies($entries){            

        $returned = array();                
        if($entries){            
            $dewies = array_numeric($entries);
            if($dewies){
                $_dewies = $this->get_dewies(locale,$dewies);                        
                foreach($dewies as $dewey){                                
                    if(isset($_dewies[$dewey])){
                        $returned[] = $dewey;        
                    }     
                }
            }
        }     

        return $returned;
    }


    // validate publishers
    public function validate_publishers($entries){            
        $returned = array();         
        if($entries){            
            $publishers = array_numeric($entries);
            if($publishers){
                $_publishers = $this->get_publishers(locale,$publishers);            
                foreach($publishers as $publisher){
                    if(isset($_publishers[$publisher])){
                        $returned[] = $publisher;         
                    }    
                }
            }
        }
        return $returned;
    }


    // validate authors
    public function validate_authors($entries){            
        $returned = array();         
        if($entries){            
            $authors = array_numeric($entries);
            if($authors){
                $_authors = $this->get_authors(locale,$authors);            
                foreach($authors as $author){
                    if(isset($_authors[$author])){
                        $returned[] = $author;         
                    }    
                }
            }
        }
        return $returned;
    }

    // validate sources
    public function validate_sources($entries){            
        $returned = array();         
        if($entries){            
            $sources = array_numeric($entries);
            if($sources){
                $_sources = $this->get_sources(locale,$sources);            
                foreach($sources as $source){
                    if(isset($_sources[$source])){
                        $returned[] = $source;         
                    }    
                }
            }
        }
        return $returned;
    }



    // validate languages
    public function validate_langs($entries){            
        $returned = array();         
        if($entries){            
            $langs = array_alpha($entries,3);
            if($langs){             
                $_langs = $this->get_langs(locale,$langs);               
                foreach($langs as $lang){
                    if(isset($_langs[$lang])){
                        $returned[] = $lang;         
                    }    
                }
            }
        }
        return $returned;
    }


    // validate formats
    public function validate_formats($formats){            
        $returned = array();                 
        if($formats){
            $_formats = $this->get_searchable_formats();
            foreach($formats as $f){
                if(in_array($f,$_formats)){
                    $returned[] = $f;
                }
            }        
        }
        return $returned;
    }



    // validate price
    public function validate_prices($prices){            
        $returned = array();                 
        if($prices){
            $_prices = $this->get_searchable_prices();
            foreach($prices as $price){
                if(in_array($price,$_prices) || (is_numeric($price) && $price > 0) ){
                    $returned[] = $price;
                }
            }        
        }
        return $returned;
    }    


    // validate Dates
    public function validate_date($_date){            
        $returned = array();        
        $date = array();
        $date[1] = isset($_date[1]) ? $_date[1] : 0;
        $date[0] = isset($_date[0]) ? $_date[0] : 0;
        if($date && ( $date[0] || $date[1] ) ){      
            $returned["from"] =  min( (int) $date[0] , (int) $date[1] );
            $returned["to"] = max( (int) $date[0] , (int) $date[1] );
        }
        return $returned;
    }    

    /// validate Years
    public function validate_years($years){    
        $returned = array();                
        if($years){
            foreach($years as $year){
                if(strlen($year) == 4){
                    $returned[] = (int) $year;   
                }
            }        
        }
        return $returned;
    }    


    // validate cities
    public function validate_cities($entries){            
        $returned = array();         
        if($entries){            
            $cities = array_numeric($entries);
            if($cities){            
                $_cities = $this->get_cities(locale,$cities);            
                foreach($cities as $city){
                    if(isset($_cities[$city])){
                        $returned[] = $city;         
                    }    
                }
            }
        }
        return $returned;
    }


    // validate sort
    public function validate_sort($sort){            
        $returned = array();         
        if($sort = @$sort[0]){
            if(in_array($sort,$this->get_searchable_sorts() ) ){
                $returned[] = $sort;
            }
        }
        return $returned;
    }


    public function box_to_query($box){

        $query = array();

        $operator = $this->input->post($box."_operator");
        $keywords = $this->input->post($box."_keywords");
        $match    = $this->input->post($box."_match");
        $field    = $this->input->post($box."_field");

        $keywords = strlen($keywords) >= $this->keyword_min_len ? $keywords : FALSE;

        $keywords = str_replace($this->array_delimiter," ",$keywords);
        $keywords = str_replace($this->query_delimiter," ",$keywords);
        $keywords = trim($keywords);

        if($keywords){
            $operator = in_array($operator,$this->get_searchable_operators()) ?  $operator : "or";
            $field    = in_array($field,$this->get_searchable_fields()) || $field == "all" ?  $field : "all";
            $match    = in_array($match,$this->get_searchable_matches()) ?  $match : "partial";            

            $keywords = $this->clear_keywords($keywords);

            $query["operator"] = $operator; 
            $query["field"] = $field; 
            $query["keywords"] = $match == "exact" ? '"'.$keywords.'"' : $keywords; 

            return $query;

        }else{    
            return FALSE;
        }


    }


    private function clear_keywords($text){

        $allowed = array(
            "1","2","3","4","5","6","7","8","9","0",
            "a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z",
            "A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z",
            "ا","أ","إ","آ","ض","ص","ث","ق","ف","غ","ع","ه","خ","ح","ج","د","ش","س","ي","ب","ل","ت","ن","م","ك","ط","ئ","ء","ؤ","ر","ى","ة","و","ز","ظ","ذ"
            ," ","-","_",'"'
        );
        $splitted = str_split_utf8($text);
        $text = "";
        foreach($splitted as $letter){
            if(in_array($letter,$allowed)){
                $text .= $letter;
            }
        }

        $text = str_replace("AND"," ",$text);
        $text = str_replace("OR"," ",$text);
        $text = str_replace("NOT"," ",$text);

        return $text;        

    }









    ///////////////////////////////////////

    public function  create_search_url($data){

        $segments = array();
        $queries = array();
        foreach($data as $key => $value){

            if($value){

                if($key == "boxes"){
                    foreach($value as $val){
                        $queries[] = $val["operator"].$this->query_delimiter.$val["field"].$this->query_delimiter.urldecode($val["keywords"]);
                    }                                
                    $segments["queries"] =  join($this->array_delimiter,$queries);
                }else{                        
                    if(is_array($value)){
                        $segments[$key] = join($this->array_delimiter,$value);
                    }else{
                        $segments[$key] = $value;
                    }
                }
            }
        }        

        $url = array();     

        foreach($segments as $key => $val){
            $url[] = $key."=".$val;
        }

        $url = join("&",$url);

        return $url;

    }



}
