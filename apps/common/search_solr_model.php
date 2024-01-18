<?php

class Search_solr_model extends base{

    var $default_sort = "none";
    var $default_core = "core_catalog_metadata_v2";

    public function get_facet_map(){
        return array(
            'dewies'     => 'subject_id',
            'publishers' => 'publisher_id',
            'authors'    => 'author_id',
            'bibs'       => 'biblo_type_id',
            'langs'      => 'language',
            'sources'    => 'source_id',
            'prices'     => 'price',
            'cities'     => 'city_id',
            'years'      => 'publication_year',
            'file_epub'  => "file_epub",
            'file_pdf'   => "file_pdf",
        );
    }

    public function generate_facet_map(){
        return array(
            'dewies'     => 'subject_id',
            'publishers' => 'publisher_id',
            'authors'    => 'author_id',
            'bibs'       => 'biblo_type_id',
            'langs'      => 'language',
            'sources'    => 'source_id',
            'prices'     => 'price',
            'cities'     => 'city_id',
            'years'      => 'publication_year',
            'date'       => 'publication_year',
            'formats'      => array(
                "file_epub" => "file_epub",
                "file_pdf" => "file_pdf"
            ),
        );
    }



    public function query_solr($_data){

        $data = @$_data["data"];
        $core = isset($_data["core"]) ? $_data["core"] : $this->default_core ;

        $_queries = @$data["queries"];
        $_filters = @$data["filters"];
        $_sort    = @$data["sort"];

        $query      = FALSE;
        $keywords   = array();
        $filters    = array();
        $faceting   = isset($_data["faceting"]) ? $_data["faceting"] : FALSE ;
        $page       = isset($_data["page"]) ? (int) $_data["page"] : 0 ;
        $limit      = isset($_data["limit"]) ? (int) $_data["limit"] : 10 ;
        $similar    = isset($_data["similar"]) ? (int) $_data["similar"] : FALSE ;
        $sort       = isset($_sort[0]) ? $_sort[0] : $this->default_sort ;
        $siblings   = isset($_data["siblings"])    ? $_data["siblings"]   : 1      ;
        $no_debug   = isset($_data["no_debug"])    ? $_data["no_debug"]   : FALSE  ;

        // Pagination
        $page  = $page ? $page : abs((int)$this->input->get("page"));
        $page  = $page > 1 ? $page : 1;
        $start = ($page - 1)*$limit;

        // build filters
        $params = array(
            "filters" => $_filters,
            "siblings" => $siblings,
        );
        $filters = $this->build_solr_filters($params);

        // build query
        if($_queries){
            $params = array(
                "queries" => $_queries,
                "filters" => $filters,
                "sort" => $sort,
            );
            $query = $this->build_solr_query($params);
        }

        // Do Query
        $solr_data = array(
            "core"      => $core,
            "query"     => $query,
            "filters"   => $filters,
            "faceting"  => $faceting,
            "start"     => $start,
            "limit"     => $limit,
            "similar"   => $similar,
            "sort"      => $sort,
        );
        $results = $this->do_solr_query($solr_data);

        $records = $results["records"];

        //// Debugging
        $debug = array();
        if (isset($_GET["xdebug"]) && $no_debug == FALSE) {
            $debug["url"]    = $results["debug"];
        }

        // Parse Results
        $parse_params = array(
            "records" => $records,
            "similar" => $similar,
            "API_mode" => FALSE,
        );
        $parsed = $this->search_parser->parse_solr_records($parse_params);

        /// Setting as an object
        $objects = $this->search_object->set_objects($parsed);

        // Get counts
        $total = $records->getNumFound();

        /// Get facets
        $facets = $faceting && $total ? $this->get_facet_results($records) : FALSE;

        // Get Pagination
        $pagination = $this->get_pagination($total,$page,$limit);

        /// keywords
        $_keywords = $this->extract_keywords($_queries);

        $returned = array(
            "debug"         => $debug,
            "queries"       => $_queries,
            "keywords"      => $_keywords,
            "filters"       => $_filters,
            "sort"          => $sort,
            "pagination"    => $pagination,
            "results"       => $objects,
            "facets"        => $facets,
        );

        $this->searcher->facets = $facets;

        if (isset($_GET["xdebug"]) && $no_debug == FALSE) {
            prnt($returned);
        }

        return $returned;

    }



    private function extract_keywords($_queries){
        $keywords = array();
        if($_queries){
            foreach($_queries as $q){
                $keywords[]= $q["keywords"];
            }
        }
        return $keywords;
    }


    /////////////////////////////////////////

    private function build_solr_query($params){

        $queries = $params["queries"];
        $filters = $params["filters"];
        $sort    = $params["sort"];

        if($sort == "score"){
            return $this->group_for_score($queries,$filters);
        }else{
            $i = 1;
            $qs = array();
            foreach($queries as $segments){
                if($i > 1) $qs[] = $segments["operator"];
                $qs[] = $segments["field"].":(".$segments["keywords"].")";
                $i++;
            }
            $qs = join(" ",$qs);
            return $qs;
        }
    }


    private function group_for_score($queries,$filters){

        $maps = array(
            "filters"=>array(
                "dewies" => "0.8",
            ),
            "queries"=>array(
                "title" => "1.0",
                "author" => "0.6",
                "content" => "0.7",
                "publisher" => "0.6",
                "series" => "1.0",
                "subjects" => "1.0",
            )
        );

        $qs = array();

        foreach($maps as $type => $map){
            if($type == "filters"){
                foreach($map as $param => $weight){
                    if(isset($filters[$param])){
                        $qs[] = "(".$filters[$param].")^".$weight;
                    }
                }
            }elseif($type == "queries"){
                foreach($map as $param => $weight){
                    foreach($queries as $query){
                        if($query["field"] == $param){
                            $qs[] = "(".$query["field"].":".$query["keywords"].")^".$weight;
                        }
                    }
                }
            }
        }

        return join(" OR ",$qs);

    }




    private function build_solr_filters($params){

        $filters = $params["filters"];
        $siblings = $params["siblings"];

        $fs = array();

        /// biblo_id
        if(isset($filters["ids"]) && $items = @$filters["ids"]){
            $fs["ids"] = 'biblo_id:('.implode(' OR ',$items).')';
        }

        /// biblo_type_id
        if(isset($filters["bibs"]) && $items = @$filters["bibs"]){
            $fs["bibs"] = 'biblo_type_id:('.implode(' OR ',$items).')';
        }

        /// subject_id
        if(isset($filters["dewies"]) && $items = @$filters["dewies"]){
            $fs["dewies"] = 'subject_id:('.implode(' OR ',$items).')'." OR ".'dewey:('.implode(' OR ',$items).')';
        }

        /// publisher_id
        if(isset($filters["publishers"]) && $items = @$filters["publishers"]){
            $fs["publishers"] = 'publisher_id:('.implode(' OR ',$items).')';
        }

        /// author_id
        if(isset($filters["authors"]) && $items = @$filters["authors"]){
            $fs["authors"] = 'author_id:('.implode(' OR ',$items).')';
        }

        /// source_id
        if(isset($filters["sources"]) && $items = @$filters["sources"]){
            $fs["sources"] = 'source_id:('.implode(' OR ',$items).')';
        }
        /// Disabled Sources
        $vip_users = array(8846,9544,9,9675);

        // $free_access = $this->session->userdata("free_access");
        // $vip_access  = false;
        // if($free_access)
        // {
        //     $method = $free_access["method"];
        //     if($method=="ip")
        //     {
        //         $vip_access = true;
        //     }
        // }




        if (!in_array(@$_SESSION["customerSession"]["id"], $vip_users)) {
            //echo "here1";
            if (!$this->input->get("purchased")) {
                $disabled_sources = $this->search_gate->get_disabled_sources();
                if ($disabled_sources) {
                    $ds = join(" ", $disabled_sources);
                    $exclude = "-source_id:(" . $ds . ")";
                    $fs["sources"] = isset($fs["sources"]) ? $fs["sources"] . " AND " . $exclude : $exclude;
                }
            }
        }





        /// language
        if(isset($filters["langs"]) && $items = @$filters["langs"]){
            $fs["langs"] = 'language:('.implode(' OR ',$items).')';
        }

        /// city_id
        if(isset($filters["cities"]) && $items = @$filters["cities"]){
            $fs["cities"] = 'city_id:('.implode(' OR ',$items).')';
        }

        /// Formats
        if(isset($filters["formats"]) && $items = @$filters["formats"]){
            $ft = array();
            foreach($items as $item){
                $ft[] = $item.":1";
            }
            $fs["formats"] = implode(' OR ',$ft);
        }

        /// Prices
        if(isset($filters["prices"]) && $items = @$filters["prices"]){
            $paid=FALSE;
            $free=FALSE;
            $prices = array();
            foreach($items as $price ){
                if($price == "paid") $paid = TRUE;
                if($price == "free") $free = TRUE;
                if(is_numeric($price) && $price > 0){
                    $prices[] = $price;
                }
            }
            if($paid && $free){
            }elseif($paid && !$prices){
                $fs["prices"] = '!price:(0)';
            }elseif($prices){
                $fs["prices"] = 'price:('.implode(' OR ',$prices).')';
            }elseif($free){
                $fs["prices"] = 'price:(0)';
            }
        }

        /// Date
        if(isset($filters["date"]) && $items = @$filters["date"]){
            if(@$items["from"] > 0 && @$items["to"] > 0){
                $fs["date"] = 'publication_year:['.@$items["from"].' TO '.@$items["to"].']';
            }elseif(@$items["from"] > 0){
                $fs["date"] = 'publication_year:['.@$items["from"].' TO '.date("Y").']';
            }elseif(@$items["to"] > 0){
                $fs["date"] = 'publication_year:[ 1900 TO '.@$items["to"].']';
            }
        }

        // Years
        if(isset($filters["years"]) && $items = @$filters["years"]){
            $fs["years"] = 'publication_year:('.implode(' OR ',$items).')';
        }


        /// Parent
        if(isset($filters["parents"]) && $items = @$filters["parents"]){
            $fs["parents"] = 'parent_bibliography_id:('.implode(' OR ',$items).')';
        }

        /// Status
        if( ( isset($filters["parents"]) && $items = @$filters["parents"] ) || ( @$siblings == 1 ) ){
            $fs["status"] = 'status_id:(1  2)';
        }elseif(isset($_GET["xstatus"])){
            $fs["status"] = 'status_id:(0 1 2)';
        }else{
            $fs["status"] = 'status_id:(1)';
        }

        return $fs;
    }



    private function do_solr_query($data){

        $returned = array();

        $core       = @$data["core"];
        $q          = @$data["query"];
        $filters    = @$data["filters"];
        $faceting   = @$data["faceting"];
        $start      = @$data["start"];
        $limit      = @$data["limit"];
        $similar    = @$data["similar"];
        $sort       = @$data["sort"];

        $this->load->library("solarium");

        $config = array(
            'endpoint' => array(
                'localhost' => array(
                    'host' => solr_host,
                    'port' => 8983,
                    'path' => '/solr/'.$core.'/',
                    'timeout' => 60*3
                )
            )
        );

        $client = new Solarium\Client($config);
        $query = $client->createSelect();

        // Query
        if($q) $query->setQuery($q);


        // Relevance
        //$sort = !isset($sort) ? "publication_year" : $sort;
        if($sort === "score"){
            $query->addSort('score', "DESC");
            // Title A-Z
        }elseif($sort === "title"){
            $query->addSort('language', "ASC");
            $query->addSort('title', "ASC");
            $query->addSort('publication_year', "DESC");
            // Publisher A-Z
        }elseif($sort === "publisher"){
            $query->addSort('language', "ASC");
            $query->addSort('publisher', "ASC");
            $query->addSort('title', "ASC");
            $query->addSort('publication_year', "DESC");
            // Year > Title
        }elseif($sort === "publication_year"){
            $query->addSort('language', "ASC");
            $query->addSort('publication_year', "DESC");
            $query->addSort('title', "ASC");
            // Author > Yead > Title A-Z
        }elseif($sort === "author"){
            $query->addSort('language', "ASC");
            $query->addSort('author', "ASC");
            $query->addSort('title', "ASC");
            $query->addSort('publication_year', "DESC");
        }
/*	else
        {
            $query->addSort('language', "ASC");
			$query->addSort('publication_year', "DESC");

        }
*/
        /// More like this
        $similar = (int) @$similar;
        if($similar > 0){
            $query->getMoreLikeThis()
            ->setFields('dewey,author_id,publisher_id')
            ->setQueryFields('status_id^10,dewey^2,author_id^1,publisher_id^0.5')
            ->setMinimumDocumentFrequency(1)
            ->setMinimumTermFrequency(1)
            ->setBoost(TRUE)
            ->setCount($similar);
        }

        /// Pagination
        $start = !isset($start) ? 0 : $start;
        $limit = !isset($limit) ? 10 : $limit;
        $query->setStart($start)->setRows($limit);


        /// Filters
        foreach($filters as $key => $filterQuery){
            if ( !empty($filterQuery) ){
                $query->createFilterQuery($key)->setQuery($filterQuery);
            }
        }

        // Facets
        if($faceting){
            $facet_map = $this->get_facet_map();
            foreach ($facet_map as $key => $field) {
                $query->getFacetSet()->createFacetField($key)->addExclude($key)->setField($field)->setMinCount(1);
            }
        }



        /// Debug
        $request = $client->createRequest($query);
        $returned["debug"] = urldecode($client->getEndpoint()->getBaseUri() . $request->getUri());

        $returned["records"] = $client->execute($query);

        unset($client);

        return $returned;

    }




    private function get_facet_results($results){
        $facets = array();
        $facet_map = $this->generate_facet_map();
        foreach ($facet_map as $key => $field) {
            // in case of an array
            if(is_array($field)){
                $facet = array();
                foreach($field as $k => $f){
                    $facet[$k] = $results->getFacetSet()->getFacet($k);
                }
                // in case of single item
            }else{
                $facet = $results->getFacetSet()->getFacet($key);
            }
            if(method_exists($this,"facet_data_".$key) && $facet ){
                $facets[$key] = $this->{"facet_data_".$key}($facet);
            }
        }
        return $facets;
    }


    private function facet_data_dewies($facets){
        $items = array();
        foreach ($facets as $value => $count) {
            $items[$value] = array("value"=>$value,"count"=>$count,"title"=>$value);
        }
        $ids = array_column($items,"value");
        $fcs = $this->search_gate->get_dewies(locale,$ids);

        foreach($items as $key => $item){
            foreach($fcs as $fc => $title){
                if((int)$item["value"] == (int)$fc){
                    $items[$key]["title"] = $title;
                }
            }
            if(!$items[$key]["title"]) $items[$key]["title"] = word("undefined");
        }
        return $items;
    }

    private function facet_data_publishers($facets){
        $items = array();
        foreach ($facets as $value => $count) {
            $items[$value] = array("value"=>$value,"count"=>$count,"title"=>$value);
        }
        $ids = array_column($items,"value");
        $fcs = $this->search_gate->get_publishers(locale,$ids);

        foreach($items as $key => $item){
            foreach($fcs as $fc => $title){
                if((int)$item["value"] == (int)$fc){
                    $items[$key]["title"] = $title;
                }
            }
            if(!$items[$key]["title"]) $items[$key]["title"] = word("undefined");
        }
        return $items;
    }

    private function facet_data_authors($facets){
        $items = array();
        foreach ($facets as $value => $count) {
            $items[$value] = array("value"=>$value,"count"=>$count,"title"=>$value);
        }
        $ids = array_column($items,"value");
        $fcs = $this->search_gate->get_authors(locale,$ids);

        foreach($items as $key => $item){
            foreach($fcs as $fc => $title){
                if((int)$item["value"] == (int)$fc){
                    $items[$key]["title"] = $title;
                }
            }
            if(!$items[$key]["title"]) $items[$key]["title"] = word("undefined");
        }
        return $items;
    }

    private function facet_data_bibs($facets){
        $items = array();
        foreach ($facets as $value => $count) {
            $items[$value] = array("value"=>$value,"count"=>$count,"title"=>$value);
        }
        $ids = array_column($items,"value");
        $fcs = $this->search_gate->get_biblio_types();

        foreach($items as $key => $item){
            foreach($fcs as $fc => $title){
                if((int)$item["value"] == (int)$fc){
                    $items[$key]["title"] = word($title);
                }
            }
            if(!$items[$key]["title"]) $items[$key]["title"] = word("undefined");
        }
        return $items;
    }


    private function facet_data_langs($facets){
        $items = array();
        foreach ($facets as $value => $count) {
            $items[$value] = array("value"=>$value,"count"=>$count,"title"=>$value);
        }
        $ids = array_column($items,"value");
        $fcs = $this->search_gate->get_langs(locale,$ids);
        foreach($items as $key => $item){
            foreach($fcs as $fc => $title){
                if($item["value"] == $fc){
                    $items[$key]["title"] = $title;
                }
            }
            if(!$items[$key]["title"]) $items[$key]["title"] = word("undefined");
        }
        return $items;
    }

    private function facet_data_sources($facets){
        $items = array();
        foreach ($facets as $value => $count) {
            $items[$value] = array("value"=>$value,"count"=>$count,"title"=>$value);
        }
        $ids = array_column($items,"value");
        $fcs = $this->search_gate->get_sources(locale,$ids);

        foreach($items as $key => $item){
            foreach($fcs as $fc => $title){
                if((int)$item["value"] == (int)$fc){
                    $items[$key]["title"] = $title;
                }
            }
            if(!$items[$key]["title"]) $items[$key]["title"] = word("undefined");
        }
        return $items;
    }

    private function facet_data_cities($facets){
        $items = array();
        foreach ($facets as $value => $count) {
            $items[$value] = array("value"=>$value,"count"=>$count,"title"=>$value);
        }
        $ids = array_column($items,"value");
        $fcs = $this->search_gate->get_cities(locale,$ids);

        foreach($items as $key => $item){
            foreach($fcs as $fc => $title){
                if((int)$item["value"] == (int)$fc){
                    $items[$key]["title"] = $title;
                }
            }
            if(!$items[$key]["title"]) $items[$key]["title"] = word("undefined");
        }
        return $items;
    }

    private function facet_data_prices($facets){

        $items = array();
        $paid_count = 0;
        foreach ($facets as $value => $count) {
            if($value == 0){
                $items["free"] = array("value"=>"free","count"=>$count,"title"=>word("free"));
            }else{
                $paid_count += $count;
                $items[$value] = array("value"=>$value,"count"=>$count,"title"=>'$'.($value/100));
            }
        }
        if($paid_count){
            $items["paid"] = array("value"=>"paid","count"=>$paid_count,"title"=>word("paid"));
        }

        return $items;
    }


    private function facet_data_years($facets){
        $items = array();
        foreach ($facets as $value => $count) {
            $items[$value] = array("value"=>$value,"count"=>$count,"title"=>$value);
        }
        return $items;
    }

    private function facet_data_formats($facets){

        $items = array();
        foreach ($facets as $type => $data) {
            foreach($data as $count){
                $items[$type] = array("value"=>$type,"count"=>$count,"title"=>word($type));
            }
        }
        return $items;
    }



    private function get_pagination($total,$start,$limit){
        $restTotal  = $total - ($start*$limit);
        $restTotal  = ($restTotal< 0)?0:$restTotal;
        return array(
            'total'         => $total,
            'page'          => $start+1,
            'limit'         => $limit,
            'rest'          => $restTotal,
            'total_pages'   => $limit > 0 ? ceil($total/$limit) : $total,
        );
    }


    public function remove_record($data){

        $core = isset($data["core"]) ? $data["core"] : $this->default_core ;

        if(isset($data["query"])){

            $query = @$data["query"];

            $this->load->library("solarium");

            $config = array(
                'endpoint' => array(
                    'localhost' => array(
                        'host' => solr_host,
                        'port' => 8983,
                        'path' => '/solr/'.$core.'/',
                        'timeout' => 60*3
                    )
                )
            );

            $client = new Solarium\Client($config);
            $update = $client->createUpdate();
            $update->addDeleteQuery($query);
            $update->addCommit();
            $result = $client->update($update);

            return $result->getStatus();

        }

    }

}