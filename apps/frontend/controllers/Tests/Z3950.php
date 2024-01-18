<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Z3950 extends MY_Controller {
   
    function __construct(){
        // Construct the parent class
        parent::__construct();

    }     
    
    public function index(){
        
        
        prnt($_REQUEST);
        
        $input_query_map = array(
            
            1 => array( // Use 
                4 => "title",
                5 => "title series",
                6 => "title uniform",
                7 => "ISBN",
                8 => "ISSN",
                12 => "local number",
                13 => "Dewey classification",
                16 => "LC call number",                
                21 => "subject heading",
                25 => "MESH subject",
                27 => "LC subject heading",
                31 => "date of publication",
                32 => "date of acquisition",
                54 => "language",
                63 => "notes",
                1003 => "author",
                1007 => "identifier-standard",
                1008 => "Subject-LC Children's",
                1016 => "any",
                1018 => "publisher",
                1031 => "material-type",
                1035 => "anywhere",
            ),            
            
            2 => array( // Relation 
                1 => "less than",
                2 => "less than or equal",
                3 => "equal",
                4 => "greater than or equal",
                5 => "greater than",
            ),
                        
            3 => array( // Position 
                1 => "first in field",
                3 => "any position in field",
            ),
                                    
            4 => array( // Structure 
                1 => "phrase",
                2 => "word",
                101 => "normalized",
            ),
                                                
            5 => array( // Truncation 
                1 => "right truncation",
                100 => "do not truncate",
            ),
                                                            
            6 => array( // Completeness 
                1 => "incomplete subfield",
                3 => "complete field",
            ),
            
        );
        
        
    }
    
}