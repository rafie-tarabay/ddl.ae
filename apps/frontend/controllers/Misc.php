<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Misc extends MY_Controller {

    public function index(){}

    public function maintenance(){

        if(settings('site_offline') == 1){                    

            $data["views"]["content"] = 'misc/maintenance';   
            $data["views"]["title"] = word("page_maintenance"); 

            $this->load->view(design_path.'/templates/main/core',$data);     

        }else{
            redirect(base_url());
        }        

    }


    public function disableOneSignal(){
        $this->session->set_userdata("disableOneSignal",TRUE);
    }

    public function disablePopupWidget(){
        $this->session->set_userdata("disablePopupWidget",TRUE);
    }


    public function not_found(){
        $this->output->set_status_header('404');               
        $data["views"]["hide_layout"] = TRUE;
        $data["views"]["title"] = word("page_404");
        $data["views"]["content"] = 'misc/custom_404';        
        $this->load->view(design_path.'/templates/main/core',$data);               

    }   



    public function disclaimer(){
        $this->session->set_userdata("hide_disclaimer",TRUE);
        if(u_id > 0 && logged_in){
            $this->db->where("data_u_id",u_id)->update("users_data",array("disclaimer_notice"=>1));
        }
    }



    public function night_mode($status="on"){
        if($status == "on"){
            $this->session->set_userdata("night_mode",TRUE);
        }else{
            $this->session->set_userdata("night_mode",FALSE);
        }
        redirect(go_back());
    }



    public function change_language($lang="ar"){
        if(!in_array($lang , array("en","ar"))){
            $lang = "ar";
        }
        $this->session->set_userdata("locale",$lang);
        redirect(go_back());
    }



    public function sharing_content(){

        $url = $this->agent->referrer();    
        if(!$url){
            $url = $this->input->post("url");
        }
        if($url){
            $short_url = $this->access->shorten_url($url);            
            if($short_url){
                $view = $this->load->view(style.'/templates/misc/sharing_modal',array("url"=>$short_url),TRUE);               
                $returned = array("status"=>"success","view"=>$view);
            }else{
                $returned = array("status"=>"error");
            }
        }else{
            $returned = array("status"=>"error");
        }

        echo json_encode($returned);

    }    


    /*
    public function fix1(){

    $this->db->trans_begin();


    $payments = array();



    $orders = $this->db->get("xxx_orders")->result();

    foreach($orders as $order){

    $old_order_id = $order->id;

    $old_items = $this->db->where("order_id",$old_order_id)->get("xxx_order_items")->result();

    //// new order
    $order_data = array(
    "order_u_id" => $order->customer_id,
    "order_type" => "digital_items",
    "order_status" => $order->paid == 1? "paid" : "unpaid",
    "order_total_price" => $order->total,
    "order_timestamp" => strtotime($order->created_at),
    );
    $this->db->insert("orders",$order_data);
    $new_order_id = $this->db->insert_id();

    if($new_order_id){

    $items = array();
    foreach($old_items as $item){

    $_GET["xstatus"] = 1;
    $params = array(
    "filters" => array(
    "ids"=>array($item->product_id)
    ),
    "similar" => FALSE
    );
    $returned = $this->searcher->get_records($params);                 

    $item_data = array();
    $book = @$returned["results"][0];

    $item_data = array(
    "title" => $book ? $book->getTitle() : "TITLE",
    "cover" => $book ? $book->getFileCover() : FALSE,
    "price" => $book ? $book->getPrice() : 3,
    );                        

    $items[] = array(
    "item_id" => $item->product_id,
    "item_order_id" => $new_order_id,
    "item_type" => "digital_item",
    "item_u_id" => $order->customer_id,
    "item_price" => $item_data["price"],
    "item_data" => json_encode($item_data),
    );       
    }

    $this->db->insert_batch("order_items",$items);

    }

    if($order->paid == 1){

    $old_payment = $this->db->where("order_id",$order->id)->where("failed",0)->limit(1)->get("xxx_payments")->row();

    if($old_payment){

    $details    = array(
    "invoice_id" => $old_payment->transaction_id
    );                    

    $payments[] = array(
    "payment_u_id"      => $order->customer_id,
    "payment_order_id"  => $new_order_id,
    "payment_method"    => "paypal",
    "payment_account"   => "info@ddl.ae",
    "payment_ref_id"    => $old_payment->transaction_id,
    "payment_amount"    => $order->total,
    "payment_currency"  => "USD",
    "payment_status"    => "captured",
    "payment_details"   => json_encode($details),
    "payment_timestamp" => time(),
    );

    }


    }

    }

    $this->db->insert_batch("payments",$payments);


    prntf($payments);

    if ($this->db->trans_status() === FALSE)
    {
    $this->db->trans_rollback();

    die("error");
    }
    else
    {
    $this->db->trans_commit();
    }          

    }

    */

    /*
    public function fix_logs(){


    $this->db = $this->load->database("logs",true);

    $logs = $this->db->where("flag",0)->limit(1000)->order_by("log_id","DESC")->get("user_logs")->result();

    foreach($logs as $log){

    if($log->log_rel_id){

    $params = array(
    "filters" => array(
    "ids"=>array($log->log_rel_id)
    ),
    "similar" => FALSE,
    "limit" => 1,
    );
    $returned = $this->searcher->get_records($params);              

    $book = @$returned["results"][0];


    if($book && @$book->getId()){

    $text = json_encode(
    array(
    "id"        => $book->getId(), 
    "url"       => base_url("book/".$book->getId()),  
    "cover"     => $book->getFileCover("thumb"), 
    "title"     => $book->getTitle(),  
    "author"    => $book->getAuthorLink(TRUE),          
    "reader"    => "user",          
    "reader_data"   => array(
    "fullname"  =>  "",  
    "u_photo"   =>  "",  
    "u_country" =>  "",
    )
    )
    );

    $updated = array(
    "log_rel_text"=>$text,
    "flag"=>1
    );

    $this->db->where("log_rel_id",$log->log_rel_id)->update("user_logs",$updated);

    @prntf($book->getId());

    }else{
    $this->db->where("log_rel_id",$log->log_rel_id)->delete("user_logs");                
    @prntf("Deleted > ".$log->log_rel_id);
    }

    }else{
    $this->db->where("log_id",$log->log_id)->delete("user_logs");                
    @prntf("Deleted > ".$log->log_id);                
    }
    }



    }
    */


    /*

    public function fix_logs_2(){


    $this->db = $this->load->database("logs",true);

    $logs = $this->db->where("flag",0)->limit(10000)->order_by("log_id","DESC")->get("guest_logs")->result();

    foreach($logs as $log){

    if($log->log_rel_id){

    $params = array(
    "filters" => array(
    "ids"=>array($log->log_rel_id)
    ),
    "similar" => FALSE,
    "limit" => 1,
    );
    $returned = $this->searcher->get_records($params);              

    $book = @$returned["results"][0];

    if($book && @$book->getId()){

    $text = json_encode(
    array(
    "id"        => $book->getId(), 
    "url"       => base_url("book/".$book->getId()),  
    "cover"     => $book->getFileCover("thumb"), 
    "title"     => $book->getTitle(),  
    "author"    => $book->getAuthorLink(TRUE),          
    "reader"    => "guest",          
    "reader_data"   => array(
    "fullname"  =>  "",  
    "u_photo"   =>  "",  
    "u_country" =>  "",
    )
    )
    );

    $updated = array(
    "log_rel_text"=>$text,
    "flag"=>1
    );

    $this->db->where("log_rel_id",$log->log_rel_id)->update("guest_logs",$updated);

    @prntf($book->getId());

    }else{
    $this->db->where("log_rel_id",$log->log_rel_id)->delete("guest_logs");                
    @prntf("Deleted > ".$log->log_rel_id);
    }

    }else{
    $this->db->where("log_id",$log->log_id)->delete("guest_logs");                
    @prntf("Deleted > ".$log->log_id);                
    }            

    }



    }

    */


    /*
    public function fix_search_logs(){

    $this->db = $this->load->database("logs",true);

    $this->db->or_where("log_title_keywords IS NOT NULL");
    $this->db->or_where("log_author_keywords IS NOT NULL");
    $this->db->or_where("log_publisher_keywords IS NOT NULL");
    $this->db->or_where("log_content_keywords IS NOT NULL");
    $this->db->or_where("log_series_keywords IS NOT NULL");
    $this->db->or_where("log_subjects_keywords IS NOT NULL");
    $logs = $this->db->limit(50000)->get("search")->result();  

    foreach($logs as $log){

    $delete = FALSE;

    if(strlen($log->log_title_keywords) > 8 && strpos($log->log_title_keywords," ") !== FALSE){
    $delete = TRUE;    
    }

    if(strlen($log->log_author_keywords) > 8 && strpos($log->log_author_keywords," ") !== FALSE){
    $delete = TRUE;    
    }

    if(strlen($log->log_publisher_keywords) > 8 && strpos($log->log_publisher_keywords," ") !== FALSE){
    $delete = TRUE;    
    }

    if(strlen($log->log_content_keywords) > 8 && strpos($log->log_content_keywords," ") !== FALSE){
    $delete = TRUE;    
    }

    if(strlen($log->log_series_keywords) > 8 && strpos($log->log_series_keywords," ") !== FALSE){
    $delete = TRUE;    
    } 

    if(strlen($log->log_subjects_keywords) > 8 && strpos($log->log_subjects_keywords," ") !== FALSE){
    $delete = TRUE;    
    }                                                

    if($delete == TRUE){
    $this->db->where("log_id",$log->log_id)->delete("search");
    }

    }

    }

    */


    public function fix_orders(){


        $orders = $this->db->where("order_type","digital_items")->get("orders")->result();

        foreach($orders as $order){

            $items = $this->db->where('item_source_id IS NULL')->where("item_order_id",$order->order_id)->get("order_items")->result();

            if($items){
                foreach($items as $item){
 
                    $params = array(
                        "filters" => array(
                            "ids"=>array($item->item_id)
                        ),
                    );
                    $returned = $this->searcher->get_records($params);  

                    if ($book = @$returned["results"][0]){               

                        $source = $book->getSource();

                        if($source["id"]){

                            $item_data = array(
                                "item_source_id" => $source["id"],
                            );

                            $this->db->where("item_id",$item->item_id)->update("order_items",$item_data);

                        }

                    }else{
                        prntf($item);
                    }


                }   
            }

        }


    }

    public function fix_revenues(){

        $orders = $this->db->where("order_type","digital_items")->where("order_status","paid")->get("orders")->result();

        foreach($orders as $order){

            $items = $this->db->where("item_order_id",$order->order_id)->get("order_items")->result();

            foreach($items as $item){

                if($order->order_original_price){
                    $discount_percent = $order->order_total_price / $order->order_original_price;
                }else{
                    $discount_percent = 1;
                }
                
                $rev = array(
                    "rev_source_id" => $item->item_source_id,
                    "rev_order_id" => $order->order_id,
                    "rev_item_id" => $item->item_id,
                    "rev_amount" => $discount_percent * $item->item_price,
                    "rev_timestamp" => $order->order_timestamp,
                );

                $this->db->insert("sources_revenues",$rev);


            }

        }



    }

    
    public function report(){
        
        $data= array(
            "data"      => array(
                "queries"=> array(
                    array(
                     "field" => "subjects",
                     "operator" => "or",
                     "keywords" => '"القضاء"',
                    ),
                    array(
                     "field" => "subjects",
                     "operator" => "or",
                     "keywords" => '"القانون"',
                    ),
                )
            ),            
            "limit"     => 10000,            
            "similar"   => false,            
        );
        $returned = $this->search_solr->query_solr($data);   
        
        
        $data["data"]["books"] = $returned["results"];
        $data["views"]["hide_layout"] = TRUE;
        $data["views"]["title"] = word("report");
        $data["views"]["content"] = 'misc/report';        
        $this->load->view(design_path.'/templates/main/core',$data);          

        
    }
    
    
    
}