<?php

class Arab extends MY_Controller
{
    public function index()
    {
         
        if (!$_POST) {
            $this->load->model('Arab_library','arab'); 
            $authors = $this->arab->authors();  
            $categories = $this->arab->categories();
            $data["views"]["title"] = word("search_arab_library");
            $data["views"]["header"] = 'inner';
            $data["views"]["footer"] = 'inner';
            $data["views"]["full_width"] = TRUE;
            $data["views"]["authors"] = $authors;
            $data["views"]["categories"] = $categories;
            $data["views"]["content"] = "search/forms/arab";
             $this->load->view(design_path . '/templates/main/search', $data);
        } else {
            //$this->handle_advanced();
        }
    }
    public function get_authors(){
        
        $this->load->model('Arab_library','arab'); 
        $authors = $this->arab->authors();  
        
        return $authors();
    }
    public function search($book_id = null,$term=null)
    {   
            
        if($book_id !=null) 
        {
             
            $this->load->model('Arab_library','arab');  
            
            $data["book_title"] = $this->arab->get_book($book_id)[0]->book_title;  
            if($_POST)
            { 
                 
                $term = $_POST['term'];
                if($_POST['searchcheck']=='content'){
                    $results = $this->arab->search_content($term,$book_id);  
                } 
                $data["results"]  = $results;
                $data["term"]  = $term; 
                $data['searchcheck'] = $_POST['searchcheck'];

            }
            else{ 
                 
                $term = urldecode($term); 
                $term = $term; 
                $results = $this->arab->search_content($term,$book_id);  
               
                $data["results"]  = $results; 
                $data["term"]  = $term; 
                $data['searchcheck'] = 'content';
            }
            // $results_summary = $this->arab->search_summary($term); 
            // $data["results_summary"]  = $results_summary; 
            $data["views"]["title"] = word("search_arab_library"); 
            $data["views"]["header"] = 'inner';
            $data["views"]["footer"] = 'inner';
            $data["views"]["full_width"] = TRUE;
            $data["views"]["content"] = "search/forms/arab";
            $data["book_id"] = $book_id;
            $this->load->view(design_path . '/templates/main/search', $data);
        }
        else{
            if ($_POST) {
                $this->load->model('Arab_library','arab');  
                $term = $_POST['term'];
                if($_POST['searchcheck']=='books')
                {
                    $results = $this->arab->search_books($term);  
                } else if($_POST['searchcheck']=='authors'){
                    $results = $this->arab->search_authors($term); 
                } else if($_POST['searchcheck']=='content'){
                    //$results = $this->arab->search_content($term,$book_id);  
                    $results_summary = $this->arab->search_summary($term);   
                } 
               
                $data["views"]["title"] = word("search_arab_library");
                //$data["results"]  = $results;
                $data["results_summary"]  = $results_summary; 
                $data["term"]  = $term; 
                $data["views"]["header"] = 'inner';
                $data["views"]["footer"] = 'inner';
                $data["views"]["full_width"] = TRUE;
                $data["views"]["content"] = "search/forms/arab";
                $data['searchcheck'] = $_POST['searchcheck'];
                $this->load->view(design_path . '/templates/main/search', $data);
            }
        }
    }

    public function search_submit()
    {

        $valid = $this->search_gate->validate_posted_data();

        /// logging
        if ($valid) {
            $this->access->log_search($valid);
        }
        /// logging

        $url = $this->search_gate->create_search_url($valid);

        redirect(base_url(front_base . "search/results/1?" . $url));
    }
}
