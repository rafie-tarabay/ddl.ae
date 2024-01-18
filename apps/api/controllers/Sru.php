<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sru extends MY_Controller {

    function __construct(){
        // Construct the parent class
        parent::__construct();

    }  


    public function index_get(){

        /// Getting Parameters        
        $version = $this->input->get("version") ;                    // Mandatory       
        $operation = $this->input->get("operation") ;                // Mandatory #The string: 'searchRetrieve'.        
        $maximumRecords = $this->input->get("maximumRecords");       // Optional
        $recordSchema = $this->input->get("recordSchema");           // Optional
        $recordXPath = $this->input->get("recordXPath");             // Optional
        $resultSetTTL = $this->input->get("resultSetTTL");           // Optional
        $sortKeys = $this->input->get("sortKeys");                   // Optional
        $stylesheet = $this->input->get("stylesheet");               // Optional
        $extraRequestData = $this->input->get("extraRequestData");   // Optional

        // Getting Query
        $q = $this->input->get("query") ;   

        $recordSchema = in_array($recordSchema,array("xml")) ? $recordSchema : "xml";

        $q = str_replace("dc.","driver.",$q);
        $q = str_replace("bath.","driver.",$q);
        $q = str_replace("cql.","driver.",$q);        
        $q = str_replace(" AND "," and ",$q);
        $q = str_replace(" OR "," or ",$q);
        $q = str_replace("=",":",$q);

        $fields_mapping = array(
            "title" => "title",
            "author" => "author",
        );

        foreach($fields_mapping as $key => $val){
            $q = str_replace("driver.$key","$val",$q);    
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://".solr_host.":8983/solr/ZING/select?q=".urlencode($q));
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        $result = curl_exec($ch);
        curl_close($ch);    

        $json_array = @json_decode( $result , true );

        //prnt($json_array);
        if( !is_null($json_array) && is_array($json_array) ){   //check if it was invalid json string        
            
            $i = 0; 
                
            $output = '<?xml version="1.0"?>
            <zs:searchRetrieveResponse xmlns:zs="http://www.loc.gov/zing/srw/">
            <zs:version>1.1</zs:version>
            <zs:numberOfRecords>'.$json_array["response"]["numFound"].'</zs:numberOfRecords>
            <zs:records>';               

            foreach($json_array["response"]["docs"] as $doc){

                $output .= '
                <zs:record>
                <zs:recordSchema>info:srw/schema/1/marcxml-v1.1</zs:recordSchema>
                <zs:recordPacking>xml</zs:recordPacking>
                <zs:recordData>';                               

                $output .= $doc["content"];

                $output .= '
                </zs:recordData>
                <zs:recordPosition>'.$i++.'</zs:recordPosition>
                </zs:record>';
            }

            $output .='
            </zs:records>
            </zs:searchRetrieveResponse>';

            $this->output->set_content_type('text/xml')->set_output($output);
            //echo $output; 

        }




    }



    public function index_get_old(){

        /// Getting Parameters        
        $version = $this->input->get("version") ;                    // Mandatory       
        $operation = $this->input->get("operation") ;                // Mandatory #The string: 'searchRetrieve'.        
        $maximumRecords = $this->input->get("maximumRecords");       // Optional
        $recordSchema = $this->input->get("recordSchema");           // Optional
        $recordXPath = $this->input->get("recordXPath");             // Optional
        $resultSetTTL = $this->input->get("resultSetTTL");           // Optional
        $sortKeys = $this->input->get("sortKeys");                   // Optional
        $stylesheet = $this->input->get("stylesheet");               // Optional
        $extraRequestData = $this->input->get("extraRequestData");   // Optional

        // Getting Query
        $q = $this->input->get("query") ;     
        $q = urldecode($q);
        $q = str_replace(" and "," AND ",$q);
        $q = str_replace(" or "," OR ",$q);

        prnt($q,FALSE);

        $query_parts = $this->exploder(" NOT ",$q);

        $parts= array();
        foreach($query_parts as $part){
            $parts[] = $this->exploder(" OR ",$part);            
        }

        $results = array();
        foreach($parts as $array){
            $p = join(" OR ",$array);
            $results[] = $p;
        }

        $result = join(" NOT ",$results);      



        prnt($result,FALSE);

        $o = $this->parse($q);    


        echo "<hr>";
        echo htmlentities($q);
        prnt(htmlentities($o->toCQL()) ,FALSE);
        prnt(htmlentities($o->toTxt()) ,FALSE);
        prnt(htmlentities($o->toXCQL()) ,FALSE);

        die();

        /// dc.subject+=+"cabin"+and+dc.title+=+"road"    
        /// dc.subject+%3D+"cabin"+and+dc.title+%3D+"road"    




    }   

    public function parse($query) {
        $this->load->library("Cql");       
        $p = new CQLParser($query);
        return $p->query();
    }

    public function exploder($delimiter,$text){

        $ex = explode($delimiter,$text);
        $final = array();
        $i = 1;
        if(count($ex) > 1){
            foreach( $ex as $x ){
                $f = "(".trim($x).")";    
                $final[] = $f;
            }
        }else{
            $final[] = $text;
        }

        return $final;
    }

}