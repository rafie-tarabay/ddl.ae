<?php

class Search_parser_model extends base{

    function parse_solr_records($data){

        $records  = @$data["records"];
        $similar    = @$data["similar"];
        $API_mode   = @$data["API_mode"];

        if($similar){
            $mlt = $records->getMoreLikeThis();
        }

        $_data =[];
        $DeweyIds =[];

        //prnt($records);

        foreach($records as $record){

            // Getting record Data
            $data = $this->get_record_data($record);

            $new_DeweyIds = $data["dewey"]["classifications"];

            if($new_DeweyIds){
                $DeweyIds = array_merge($DeweyIds , $new_DeweyIds);
            }

            // Getting More Like this
            $mltItems = array();
            if($similar && $mlt){
                $mltResults = $mlt->getResult($record->id);
                if($mltResults){
                    foreach($mltResults as $mltResult){
                        $mltItems[] = $this->get_record_data($mltResult);
                        $new_DeweyIds = $data["dewey"]["classifications"];

                        if($new_DeweyIds){
                            $DeweyIds = array_merge($DeweyIds , $new_DeweyIds);
                        }
                    }
                }
            }

            $data["similar"] = $mltItems;

            $_data[] = $data;

        }


        //prnt($_data);


        $DeweyIds = array_unique($DeweyIds);
        if($DeweyIds){
            $classifications = $this->get_classifications($DeweyIds);
            if($classifications){
                $_data = $this->attach_classifications($_data , $classifications);
                foreach($_data as $index => $single_item){
                    //prnt($single_item["similar"]);
                    //prnt($_data["data"]);
                    //prnt($_single_item["similar"]);
                    $_data[$index]["similar"] = $this->attach_classifications($single_item["similar"] , $classifications);
                }
            }
        }

        return $_data;
    }


    function get_record_data($record){

        //prnt($record);

        $dewey = $record->dewey;
        if(is_array($dewey)){
            $dewey = @$record->dewey[0];
        }


        $data = [
            //'biblo_id'  => $record->marc_bibliographies_id,
            'biblo_id'  => $record->biblo_id,
            //'dump_id'  => $record->biblo_id,
            'biblo_type_id'  => $record->biblo_type_id,
            'biblo_type'  => $this->biblo_types($record->biblo_type_id),

            'title'      => $record->title,
            'price'      => $record->price / 100,
            'language'      => $record->language,
            'publication_year'      => $record->publication_year,

            'place' => array(
                "city_id" => $record->city_id,
                "publication_place" => $record->publication_place,
            ),

            'publisher' => array(
                "publisher_id" => $record->publisher_id,
                "publisher" => $record->publisher,
            ),

            'author' => array(
                "author_id" => $record->author_id,
                "author" => $record->author,
            ),

            'coauthors'  => $this->parse_coauthors($record->coauthors) ,

            'ISBN' => array(
                "ISBN" => $record->ISBN,
                "ISSN" => $record->ISSN,
            ),

            'files' => array(
                "file_cover" => $record->file_cover,
                "file_pdf" => $record->file_pdf,
                "file_epub" => $record->file_epub,
                "file_msword" => $record->file_msword,
                "file_video" => $record->file_video,
                "file_audio" => $record->file_audio,
            ),

            'summary'  => $record->summary,
            'citation' => $record->citation,
            'series'  => $record->series,
            'edition'  => $record->edition,
            'source_id'  => $record->source_id,
            'status_id'  => $record->status_id,
            'format_id'  => $record->format_id,

            'row_id'    => isset($record->row_id)?$record->row_id:null,
            'part'      => isset($record->part)?$record->part:null,
            'page'      => isset($record->page)?$record->page:null,

            "dewey" => array(
                "number" => $dewey,
                "classifications" => $this->parse_dewey($dewey),
            ),

            "subjects" => $this->parse_tag650($record->subjects),

            "properties" => array(
                "pages" => $record->tag300a,
                "words" => $record->tag300b,
                "reading_time" => $record->tag307a,
            ),

            "advanced_data" => array(
                "tag362a" => $record->tag362a,
            ),

            "related_parts" => $this->parse_tag773a($record->tag773a)  ,

            "related_files" => $record->related_files   ,
            "related_files_loc" => $record->related_files_loc  ,

            "parent_bibliography_id" => isset($record->parent_bibliography_id) ? $record->parent_bibliography_id : NULL,

            "score" => $record->score,
            "BrowseFT" => $record->BrowseFT,
            "HardcopyPrice" => $record->HardcopyPrice,

        ];

        // Temp solution
        //$data["related_files"] = str_replace("ethraadl.com:809","CDN.ethraadl.com",$record->related_files);

        //if(u_id == 11) prnt($record);

        return $data;

    }


    function parse_tag650($subjects){

        $all650tags = explode("_Tag650_",$subjects);
        $data = array();
        if($all650tags){
            foreach($all650tags as $tag){
                $tagdata = array();
                $tag = trim($tag);
                if($tag){
                    $fields = explode('__$$',$tag);
                    if($fields){
                        foreach($fields as $field){
                            $field = trim($field);
                            if($field){
                                $parts    = explode('$$__',$field);
                                $subfield =  trim($parts[0]);
                                $text     =  trim($parts[1]);
                                $tagdata[] = array(
                                    "text" => $text,
                                    "subfield" => $subfield,
                                );
                            }
                        }
                    }
                }

                if($tagdata) $data[] = $tagdata;
            }
        }

        return $data;
    }



    function parse_tag773a($tag_content){

        $data = array();
        if($tag_content){
            $alltags = explode("_Tag773_",$tag_content);
            if($alltags){
                foreach($alltags as $tag){
                    $tagdata = array();
                    $tag = trim($tag);
                    if($tag){
                        $fields = explode('__$$',$tag);
                        if($fields){
                            foreach($fields as $field){
                                $field = trim($field);
                                if($field){
                                    $parts    = explode('$$__',$field);
                                    $subfield =  trim($parts[0]);
                                    $text     =  trim($parts[1]);
                                    $tagdata[] = array(
                                        "text" => $text,
                                        "subfield" => $subfield,
                                    );
                                }
                            }
                        }
                    }

                    if($tagdata) $data[] = $tagdata;
                }
            }

        }

        return $data;
    }



    function parse_coauthors($coauthors){

        //prnt($coauthors);

        $data = array(
            110 => [ "title"=> "main_entry_corporate" , "content"=>array() ], // هيئة
            111 => [ "title"=> "main_entry_meeting" , "content"=>array() ], // مؤتمر
            700 => [ "title"=> "added_entry_personal" , "content"=>array() ], //  مؤلف مشارك
            710 => [ "title"=> "added_entry_corporate" , "content"=>array() ], // هيئة مشاركة
            711 => [ "title"=> "added_entry_meeting" , "content"=>array() ], //  مؤتمر مشارك
        );

        $tags = explode("_Tag",$coauthors);

        foreach($tags as $tag){
            $tag = trim($tag);
            if($tag){

                $tag_number = 0;

                foreach($data as $tag_no => $tag_array){
                    if(strpos($tag,$tag_no."_") !== FALSE){
                        $tag = str_replace($tag_no."_","",$tag);
                        $tag = trim($tag);
                        $tag_number = $tag_no;
                        break;
                    }
                }

                if($tag_number){

                    $fields = explode('__$$a$$__',$tag);
                    if($fields){
                        foreach($fields as $field){
                            $field = trim($field);
                            if($field){
                                $parts    = explode('__$$e$$__',$field);
                                $name     =  isset($parts[0]) ? trim($parts[0]) : "";
                                $role     =  isset($parts[1]) ? trim($parts[1]) : "";
                                if($name){
                                    $data[$tag_number]["content"][] = array(
                                        "name" => $name,
                                        "role" => $role,
                                    );
                                }
                            }
                        }
                    }
                }

            }
        }

        foreach($data as $tag_no => $tag_array){
            if(!count($tag_array["content"])) unset($data[$tag_no]);
        }

        return $data;
    }




    function parse_dewey($dewy_id){

        $dewy_id = (int) $dewy_id;

        $classes = array();

        if($dewy_id){

            $s3 = $dewy_id;
            $s2 = substr($dewy_id,0,2) * 10;
            $s1 = substr($dewy_id,0,1) * 100;

            $classes[1] = $s1;
            if($s2 && $s1 != $s2) $classes[2] = $s2;
            if($s3 && !in_array($s2,array($s1,$s3)) ) $classes[3] = $s3;
        }

        return $classes;
    }

    function get_classifications($subjects_ids){
       return $this->search_gate->get_dewies(locale,$subjects_ids);
    }


    function attach_classifications($data , $classifications){
        foreach($data as &$item){

            if(count(@$item["dewey"]["classifications"]) > 0){
                $new_classes = array();
                foreach($item["dewey"]["classifications"] as $key => $sub_id){
                    if(@$classifications[$sub_id]){
                        $new_classes[ $key ] = array(
                            "dewey_id" => $sub_id,
                            "title" => $classifications[$sub_id]
                        );
                    }
                }
                $item["dewey"]["classifications"] = $new_classes;
            }
        }
        return $data;
    }




    function biblo_types($biblo_type_id){

        $types = array(
            "1" => array("en"=>"Book" ,"ar"=>"كتاب"),
            "2" => array("en"=>"Article" ,"ar"=>"مقالة"),
            "3" => array("en"=>"Journal" ,"ar"=>"مجلة"),
            "4" => array("en"=>"Report" ,"ar"=>"تقرير"),
            "5" => array("en"=>"Thesis" ,"ar"=>"نظرية"),
            "6" => array("en"=>"Conference" ,"ar"=>"مؤتمر"),
            "7" => array("en"=>"Audible" ,"ar"=>"صوتي"),
            "8" => array("en"=>"Video" ,"ar"=>"فيديو"),
            "9" => array("en"=>"Manuscripts" ,"ar"=>"مخطوطة"),
            "10" => array("en"=>"Summary" ,"ar"=>"ملخص"),
            "11" => array("en"=>"Newspaper" ,"ar"=>"صحيفة"),
            "12" => array("en"=>"kids" ,"ar"=>"أطفال"),

        );

        return isset($types[$biblo_type_id] ) ? $types[$biblo_type_id]  : NULL ;

    }

}
