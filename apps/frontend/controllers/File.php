<?php
/**
* Created by PhpStorm.
* User: abed
* Date: 4/26/16
* Time: 1:09 PM
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class File extends MY_Controller{

    var $ContentUrl;

    function __construct(){
        parent::__construct();
    }

    public function test(){
        $data['book_url'] = 'https://ddl-storage-server.sgp1.digitaloceanspaces.com/book_in_minutes/203_dewal_raeda.pdf';
        
        $this->load->view('../../../apps/frontend/views/default/templates/books/pdf',$data);  
        
    }
    public function handler(){

        $encrypted_string = $_GET["file"]; 

        if($encrypted_string){          

            $data["data"]["encrypted_string"] = $encrypted_string;        
            $data["views"]["header"] = 'inner';           
            $data["views"]["footer"] = 'inner';           
            $data["views"]["title"] = word("files")." - ".word("download_file");           
            $data["views"]["full_width"] = TRUE;
            $data["views"]["content"] = "books/download_page"; 

            $this->load->view(design_path.'/templates/main/core',$data);  

        }else{
            $this->base->response_page(word("error"),"error",word("content_not_found"));
        }
    } 

    public function handler_ajax($encrypted_string = FALSE){

        $error = "";

        if(!$encrypted_string){
            $encrypted_string = $this->input->post("encrypted_string");
        }   

        if($encrypted_string){  

            $encrypted_string = base64_decode($encrypted_string);

            ///// encryption Library //// 
            $this->load->library('encryption');            
            $params = array(
                'cipher' => 'aes-256',
                'mode' => 'ctr',
                'key' => defined("encryption_key") ? encryption_key : "af5ecf59d0a8f4ae1d74d8c7155ba7b5"
            );
            $this->encryption->initialize($params);              
            ///// encryption Library ////         
            $string = $this->encryption->decrypt($encrypted_string);            

            $exploded = explode("@#@",$string);
            $url = $original_url = @$exploded[0];
            $url = str_replace('sgp1.','sgp1.cdn.',$url);
            $time = @$exploded[1];
            $book_id = @$exploded[2];    
            $book_title = @$exploded[3];    

            $back_url = base_url(front_base."book/read/".$book_id);

            if( $time && time() <= @$time && $book_id > 0 && $book_title){

                // To override any hidden content
                $_GET["purchased"] = TRUE;                       
                
                $params = array(
                    "filters" => array(
                        "ids" => array($book_id)
                    ),
                );                 
                $returned = $this->searcher->get_records($params);  
                $book = $returned["results"][0];

                if ($book){   

                    // if( logged_in ){

                       if( true ){ 
                        if ($book->isFree() || $book->isPurchased() || ( free_access && $this->access->hasAccessOnItem($book) ) ){                                

                            $time_left = $time - time();

                            $may_have_error_msg = '<i class="fa fa-warning text-danger"></i> '.word("file_may_have_errors").' !';                

                            if(strpos($url,"digitaloceanspaces.com") !== FALSE){ // it is already on digital ocean
                                
                                $view_url = base_url(front_base."file/viewer/".base64_encode(urlencode($url)))."?book_id=$book_id";

                                $returned = array(
                                    "status"=>"success", 
                                    "msg1"=>'<a target="_blank" class="btn btn-info bordered" href="'.$url.'">'.word("download").'</a>  <!--a target="_blank" class="btn btn-warning bordered" href="'.$view_url.'">'.word("reading").'</a-->' , 
                                    "msg2"=> word("you_have").' <code><span id="valid_timer" data-timer="'.$time_left.'">'.$time_left."</span></code> ".word("seconds_b4_download_expires") , 
                                    //"msg3"=>$may_have_error_msg.$error , 
                                    "back_url"=>$back_url , 
                                ); 

                            }else{                            

                                if( valid_url($url) || filter_var($url, FILTER_VALIDATE_URL) !== FALSE ){        
									/* commented by rafie 
                                    $result = teleport($url);           

                                    //prnt($result)

                                    $result = json_decode($result);

                                    //$error = ( u_id == 2 && isset($result->error) ) ?  join('\n',$result) : ""; 

                                    if($result->status == "success"){
                                        $url = $result->do_file;
                                    }elseif( @$result->error == "Digital_Ocean_Error"){                   
                                        $url = $result->teleporter_file;
                                    }else{
                                        $url = $result->main_file;
                                    }
									*/
                                    $view_url = base_url(front_base."file/viewer/".base64_encode(urlencode($url)))."?book_id=$book_id";

                                    $returned = array(
                                        "status"=>"success", 
                                        "msg1"=>'<a target="_blank" class="btn btn-info bordered" href="'.$url.'">'.word("download").'</a>  <!--a target="_blank" class="btn btn-warning bordered" href="'.$view_url.'">'.word("reading").'</a-->' , 
                                        "msg2"=> word("you_have").' <code><span id="valid_timer" data-timer="'.$time_left.'">'.$time_left."</span></code> ".word("seconds_b4_download_expires") , 
                                        //"msg3"=>$result->status != "success" ? $may_have_error_msg.$error : 0, 
                                        "back_url"=>$back_url , 
                                    );



                                }else{

                                    $returned = array(
                                        "status"=>"success", 
                                        "msg1"=>'<a target="_blank" class="btn btn-info bordered" href="'.$url.'">'.word("download").'</a>  <!--a target="_blank" class="btn btn-warning bordered" href="'.$view_url.'">'.word("reading").'</a-->' , 
                                        "msg2"=> word("you_have").' <code><span id="valid_timer" data-timer="'.$time_left.'">'.$time_left."</span></code> ".word("seconds_b4_download_expires") , 
                                        //"msg3"=>$may_have_error_msg.$error , 
                                        "back_url"=>$back_url , 
                                    );

                                }

                            }

                            //// logging Download
                            $source = $book->getSource();
                            $book_data = (object) array(
                                "item_id" => $book_id,
                                "source_id" => $source ? @$source["id"] : NULL,
                                "download_url" => $original_url,
                                "title" => $book_title,
                                "free" => $book->isFree(),
                                "purchased" => $book->isPurchased(),
                                "freeaccess" => free_access,
                            );        
                            $this->access->log_download($book_data);                
                            //// logging Download


                        }else{                                                     
                            $returned = array(
                                "status"=>"error",        
                                "msg1"=>word("insufficient_download_permissions") , 
                                "msg2"=>'<a href="'.$back_url.'">'.word("please_contact_support").'</a>' , 
                            );
                        }    

                    }else{                                                     
                        $returned = array(
                            "status"=>"error",        
                            "msg1"=>word("need_login_to_access") , 
                            "msg2"=>'<a href="'.$back_url.'">'.word("login").'</a>' , 
                        );
                    }    

                }else{                                                     
                    $returned = array(
                        "status"=>"error", 
                        "msg1"=> word("digital_item_unavailable") , 
                        "msg2"=>'<a href="'.$back_url.'">'.word("please_contact_support").'</a>' , 
                    );
                }     

            }else{                      
                $returned = array(
                    "status"=>"error", 
                    "msg1"=> word("link_expired") , 
                    "msg2"=>'<a href="'.$back_url.'">'.word("go_back_refresh_page").'</a>' , 
                );
            }

        }else{
            $returned = array("status"=>"error", 
                "msg1"=>word("file_not_found") , 
                "msg2"=>'<a href="'.$back_url.'">'.word("please_contact_support").'</a>' , 
            );
        }

        echo json_encode($returned);

    }


    public function viewer($file="")
    {

       

        $file = urldecode( base64_decode($file) );

        if($file){          

            $book_id = isset($_GET["book_id"]) ? $_GET["book_id"] : FALSE ;

            if(is_numeric($book_id) && $book_id > 0){
                $data["data"]["back_url"] = base_url(front_base."store/read/".$book_id);    
            }

            $data["data"]["file"] = $file;        
            $data["views"]["hide_layout"] = TRUE;           
            $data["views"]["header"] = 'inner';           
            $data["views"]["footer"] = 'inner';           
            $data["views"]["title"] = word("files")." - ".word("view_file");           
            $data["views"]["full_width"] = TRUE;
            $data["views"]["content"] = "books/iframe_viewer"; 

            $this->load->view(design_path.'/templates/main/core',$data);  

        }else{
            $this->base->response_page(word("error"),"error",word("content_not_found"));
        }
    }     

}