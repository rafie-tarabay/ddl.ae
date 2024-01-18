<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Arab_library extends base{
     
    public function search_content($term = null,$book_id = null)
    {
        if($term!=null)
        {
            $this->db = $this->load->database("arab", true); 
            if ($book_id != null) {
                $sql = "SELECT * FROM section_content c JOIN book_sections sec ON c.sec_id = sec.sec_id JOIN books b ON b.book_id = sec.book_id " .
                " WHERE content like '%" . $term . "%' and sec.sec_id !='cover' and sec.sec_id !='intro' and b.book_id = '".$book_id."' ";
                 $sql = 'SELECT c.* FROM section_content c JOIN books b ON b.book_id = c.book_id '.
                'WHERE MATCH(content) AGAINST(\''."\"".$term."\"".'\' IN BOOLEAN MODE) and b.book_id = "'.$book_id.'"';
                //echo $sql;


            } else {
                $sql = "SELECT * FROM section_content c " .
                "JOIN book_sections sec on sec.sec_id = c.sec_id " .
                "JOIN books b on b.book_id = sec.book_id " .
                "WHERE content like '%" . $term . "%' and sec.sec_id !='cover' and sec.sec_id !='intro' order by b.book_title";
            } 
            $query = $this->db->query($sql);
            if ($query != null) {
                return $query->result();
            } else {
                return null;
            }
        }
        
    }
    public function authors(){
        $this->db = $this->load->database("arab", true);         
        $sql = "SELECT `book_author`,count(*) as count FROM `books` WHERE 1 GROUP BY `book_author` order by count(*) DESC";
        
        $query = $this->db->query($sql);
        
            if ($query != null) {
                return $query->result();
            } else {
                return null;
            }
    }
    public function categories(){
        $sql = "SELECT `sub_category` as category,count(*) as count FROM `books` GROUP by `sub_category` ORDER BY count(*) DESC";
        $query = $this->db->query($sql);
        if ($query != null) {
            return $query->result();
        } else {
            return null;
        }
    }
    public function search_summary($term = null){
        $this->db = $this->load->database("arab", true); 
        $sql = "SELECT b.book_author,b.book_title,b.book_id,COUNT(c.sec_id) as Count FROM section_content c JOIN book_sections sec on sec.sec_id = c.sec_id ".
               "JOIN books b on b.book_id = sec.book_id WHERE content like '%".$term."%' and sec.sec_id !='cover' and sec.sec_id !='intro'  group by b.book_title order by COUNT(c.sec_id) DESC"; 
        
        $sql = 'SELECT b.book_title, b.book_id,b.book_author,COUNT(c.sec_id) as count FROM section_content c JOIN books b ON b.book_id = c.book_id '.
               'WHERE MATCH(content) AGAINST(\''."\"".$term."\"".'\' IN BOOLEAN MODE) GROUP BY c.book_id order by COUNT(c.sec_id) DESC';

        //echo $sql;

        $query = $this->db->query($sql);
        if ($query != null) {
            return $query->result();
        } else {
            return null;
        }
    }
    public function get_book($book_id = null)
    {
        if($book_id!=null)
        {
            $this->db = $this->load->database("arab", true);
            // $this->db->like('content', $term);
            // $this->db->or_like('author', $term);
            // $this->db->or_like('date', $term);
            if ($book_id != null) {
                $sql = "SELECT * FROM books WHERE book_id = '".$book_id."' ";
            } 
            $query = $this->db->query($sql);
            if ($query != null) {
                return $query->result();
            } else {
                return null;
            }
        } 
    }
    public function search_books($term = null)
    {
        if($term!=null)
        {
            $this->db = $this->load->database("arab", true);  
           // $this->db->like('content', $term);
            // $this->db->or_like('author', $term);
            // $this->db->or_like('date', $term);
            $sql = "SELECT * FROM books b ". 
                     
                     "WHERE  b.book_title like '%".$term."%' ";         
            $query = $this->db->query($sql); 
            if($query !=null){
            return $query->result();
            }
            else{
                return null;
            }
         }
        
    }
    public function search_authors($term = null)
    {
        if($term!=null)
        {
            $this->db = $this->load->database("arab", true);  
           // $this->db->like('content', $term);
            // $this->db->or_like('author', $term);
            // $this->db->or_like('date', $term);
            $sql =      "SELECT * FROM books b ".  
                        "WHERE b.book_author like '%".$term."%'";

            $query = $this->db->query($sql); 
            if($query !=null){
                return $query->result();
                }
                else{
                    return null;
                }
         }
        
    }
    public function getbooks()
    {
        $this->db = $this->load->database("arab", true);
        $query = $this->db->get('books');
        return $query->result();
    }
    public function sort_result_by($books, $books_ids)
    {
        foreach ($books as $book) {
            $id = (string) $book->getId();
            $found = array_search($id, $books_ids);
            $books_ids[$found] = $book;
        }
        return $books_ids;
    }
}
