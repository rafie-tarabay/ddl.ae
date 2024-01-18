<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Books extends MY_Controller{


    public function view_book($id){

        $params = array(
            "filters" => array(
                "ids"=>array($id)
            ),
            "similar" => 4
        );
        $returned = $this->searcher->get_records($params);      
        
        if ($book = @$returned["results"][0]){

            /// logging
            $log = array(
                "action"        => "view_book",
                "rel_id"        => $id,                
                "rel_text"      => json_encode(
                    array(
                        "id"        => $book->getId(), 
                        "url"       => base_url("book/".$book->getId()),  
                        "cover"     => $book->getFileCover("thumb"), 
                        "title"     => $book->getTitle(),  
                        "author"    => $book->getAuthorLink(TRUE),          
                        "reader"    => logged_in ? "user" : "guest",          
                        "reader_data"   => array(
                            "fullname"  => logged_in ? fullname  : "",  
                            "u_photo"   => logged_in ? u_photo   : "",  
                            "u_country" => logged_in ? u_country : "",
                        )
                    )
                ),
                "dewey" => $book->getDewey(),
            );   
            $this->access->log_action($log);
            /// logging               

            //$this->load->model("Social_action","social");
            //$data["data"]["favs"] = $this->social->fetch_favs([$id]);        
            //$data["data"]["ratings"] =  $this->social->fetch_ratings([$id]);        
            //$data["data"]["purchases"] = $this->social->fetch_purchases([$id]);              

            $data["data"]["book"] = $book;        
            $data["views"]["header"] = 'inner';           
            $data["views"]["footer"] = 'inner';     

            $data["views"]["page_desc"] = $book->getTitle();  
            $data["views"]["biblo_type"] = $book->getBibloType()['en'];  
            $data["views"]["page_image"] = $book->getFileCover("thumb");            
           
            // foreach($book->getSubjects() as $item1)
            // {
            //     foreach($item1 as $item)
            //     {
            //         $data["views"]["page_keywords"] .= $item['text'].',';
            //     }
            //     //$data["views"]["page_keywords"] .= $item;           
            // }

            //echo $data["views"]["page_keywords"];
            $data["views"]["page_keywords"] = $book->getTitle();
            $data["views"]["title"] = $book->getTitle();         
            $data["views"]["full_width"] = TRUE;
            $data["views"]["content"] = "books/show_book";

            $this->load->view(design_path.'/templates/main/core',$data);  

        }else{
            $this->base->response_page(word("error"),"error",word("content_not_found"));
        }         

    }



    public function read_book($id){

       

        $params = array(
            "filters" => array(
                "ids"=>array($id)
            )
        );
        $returned = $this->searcher->get_records($params);      

        if ($book = @$returned["results"][0]){

            $files = array();
            //disabled temberoray to enable reading with no need to register
            //if(logged_in){
            if (true) {

                if ($book->isFree() || $book->isPurchased() || (free_access && $this->access->hasAccessOnItem($book))) { 
                    /// logging
                    $log = array(
                        "action"        => "view_book_files",
                        "rel_id"        => $id,
                        "rel_text"      => json_encode(
                            array(
                                "id"        => $book->getId(),
                                "url"       => base_url("book/" . $book->getId()),
                                "cover"     => $book->getFileCover("thumb"),
                                "title"     => $book->getTitle(),
                                "author"    => $book->getAuthorLink(TRUE),
                                "reader"    => logged_in ? "user" : "guest",
                                "reader_data"   => array(
                                    "fullname"  => logged_in ? fullname  : "",
                                    "u_photo"   => logged_in ? u_photo   : "",
                                    "u_country" => logged_in ? u_country : "",
                                )
                            )
                        ),
                        "dewey" => $book->getDewey(),
                    );
                    $this->access->log_action($log);
                    /// logging               

                    if ($mainfiles = $book->metadata["files"]) {
                        $files["main"]  = $mainfiles;
                    }
                    if ($relatedfiles = $book->metadata["related_files"]) {
                        $files["related"]  = $relatedfiles;
                    }

                    $data["data"]["book"] = $book;
                    $data["data"]["files"] = $files;
                    $data["views"]["header"] = 'inner';
                    $data["views"]["footer"] = 'inner';
                    $data["views"]["title"] = $book->getTitle() . " - " . word("files");
                    $data["views"]["full_width"] = TRUE;
                    $data["views"]["content"] = "books/show_book_files";
                    
                    if(username=='FrontEndAdmin'){
                        echo "Dev Mode";
                        $data["views"]["content"] = "books/show_book_files_dev";

                    }
                     


                    $this->load->view(design_path . '/templates/main/core', $data);
                } else {
                    $this->setFlashMessage(word("need_purchase_to_access"));
                    redirect(go_back());
                }

            }else{
                $this->setFlashMessage(word("need_login_to_access"));
                redirect(go_back());
            }

        }

    }



    public function similar_books($id){

        $params = array(
            "filters" => array(
                "ids"=>array($id)
            ),
            "similar"=>20
        );        
        $returned = $this->searcher->get_records($params);      

        if ($book = @$returned["results"][0]){

            /// logging
            $log = array(
                "action"        => "view_similar_books",
                "rel_id"        => $id,                
                "rel_text"      => json_encode(
                    array(
                        "id"        => $book->getId(), 
                        "url"       => base_url("book/".$book->getId()),  
                        "cover"     => $book->getFileCover("thumb"), 
                        "title"     => $book->getTitle(),  
                        "author"    => $book->getAuthorLink(TRUE),          
                        "reader"    => logged_in ? "user" : "guest",          
                        "reader_data"   => array(
                            "fullname"  => logged_in ? fullname  : "",  
                            "u_photo"   => logged_in ? u_photo   : "",  
                            "u_country" => logged_in ? u_country : "",
                        )
                    )
                ),
                "dewey" => $book->getDewey(),
            );   
            $this->access->log_action($log);
            /// logging                    

            $similar_books = $book->getSimilar();
            $books_ids = $this->searcher->ids_array($similar_books);                        
            $books_ids[] = $id; // main book
            //$this->load->model("Social_action","social");
            //$data["data"]["favs"] = $this->social->fetch_favs($books_ids);        
            //$data["data"]["purchases"] = $this->social->fetch_purchases($books_ids);              

            $data["data"]["book"] = $book;        
            $data["views"]["header"] = 'inner';           
            $data["views"]["footer"] = 'inner';           
            $data["views"]["title"] = $book->getTitle()." - ".word("similar_items");           
            $data["views"]["full_width"] = TRUE;
            $data["views"]["content"] = "books/similar_books";

            $this->load->view(design_path.'/templates/main/core',$data);  

        }else{
            $this->base->response_page(word("error"),"error",word("content_not_found"));
        }         

    }




    public function view_journal($journal_id,$page=1){

        $params = array(
            "filters" => array(
                "ids"=>array($journal_id),
            )
        );                
        $returned = $this->searcher->get_records($params);      

        if ($journal = @$returned["results"][0]){

            /// logging
            $log = array(
                "action" => "view_book",
                "rel_id" => $journal_id,                
                "rel_text" => $journal->getTitle(),
                "dewey" => $journal->getDewey(),
            );   
            $this->access->log_action($log);
            /// logging               


            $data["data"]["journal"] = $journal;                  

            /////////////////////
            //$_GET["xdebug"] = 1;
            $params = array(
                "filters" => array(
                    "parents" => array($journal_id)
                ),
                "limit"=>20
            );                
            $returned = $this->searcher->get_records($params);      
            
            $results = $returned["results"];        

            //$results["sourcesList"] = $this->Source->findListAsArray();        

            $paging     = $returned["pagination"];        

            $count      = $paging["total"] ;        
            $per_page   = $paging["limit"] ;                                    
            $page       = $paging["page"] ;                                    

            $pagination = $this->base->paginate_me($count,$per_page,front_base."journal/$journal_id/",3);            

            
            if($results){
                //$this->load->model("Social_action","social");
                //$issues_ids = $this->searcher->ids_array($issues);                        
                //$issues_ids[] = $journal_id;
                //$data["data"]["favs"] = $this->social->fetch_favs($issues_ids);        
                //$data["data"]["ratings"] =  $this->social->fetch_ratings($issues_ids);        
                //$data["data"]["purchases"] = $this->social->fetch_purchases($issues_ids);        
            }    

            $data["data"]["issues"] = $results;        
            $data["data"]["pagination"] = $pagination["links"];  

            $data["views"]["title"] = $journal->getTitle()." - ".word("issues");  
            $data["views"]["header"] = 'inner';           
            $data["views"]["footer"] = 'inner'; 
            $data["views"]["full_width"] = TRUE;
            $data["views"]["content"] = "books/show_journal";

            $this->load->view(design_path.'/templates/main/core',$data);  

        }else{
            $this->base->response_page(word("error"),"error",word("content_not_found"));
        }         

    }








}