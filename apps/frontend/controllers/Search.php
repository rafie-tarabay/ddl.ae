<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends MY_Controller {

    public function __construct() {
        parent::__construct(); // getting base constructor
    }


    public function index(){

        if(!$_POST){

            $data["data"]["searchables"] = $this->search_gate->get_searchables();
            $data["data"]["advanced_search"] = TRUE;
            $data["data"]["hide_cats"] = TRUE;

            $data["views"]["title"] = word("advanced_search");
            $data["views"]["header"] = 'inner';
            $data["views"]["footer"] = 'inner';
            $data["views"]["full_width"] = TRUE;
            $data["views"]["content"] = "search/forms/advanced";

            $this->load->view(design_path.'/templates/main/core',$data);

        }else{
            $this->handle_advanced();
        }

    }


    public function search_submit(){

        $valid = $this->search_gate->validate_posted_data();

        /// logging
        if($valid){
            $this->access->log_search($valid);
        }
        /// logging

        $url = $this->search_gate->create_search_url($valid);

        redirect(base_url(front_base."search/results/1?".$url));

    }


    public function results($page=1){

        $limit = 10;
        $sort  = $this->input->get("sort");

        //if($sort==null)
        //{
        //    $sort="language";
        //}

        $valid = $this->search_gate->validate_url_data();

        $data= array(
            "data"      => $valid,
            "faceting"  => TRUE,
            "page"      => $page, // could be set by get parameter
            "limit"     => $limit,
            "similar"   => FALSE,
            "sort"      => $sort,
        );
        $results = $this->search_solr->query_solr($data);


        $books_ids = $this->searcher->ids_array($results["results"]);

        $count = $results["pagination"]["total"];

        $pagination = $this->base->paginate_me($count,$limit,front_base."search/results/",3);

        $results["pagination"]["links"] = $pagination["links"];


        $this->load->model("Social_action","social");
        $books = @$results["results"];

        if(logged_in && $books){
            $books_ids = $this->searcher->ids_array($books);
            $data["data"]["favs"] = $this->social->fetch_favs($books_ids);
            $data["data"]["ratings"] =  $this->social->fetch_ratings($books_ids);
            $data["data"]["purchases"] = $this->shopping->get_purchased($books_ids);
        }


        $data["data"]["books"] = $books;

        $data["data"]["facets"] = $results["facets"];
        $data["data"]["pagination"] = $results["pagination"];

        $data["data"]["sort"] = $results["sort"];
        $data["data"]["filters"] = $results["filters"];
        $data["data"]["keywords"] = $results["keywords"];
        $data["data"]["queries"] = $results["queries"];

        $data["views"]["title"] = $page > 1 ? word("search_results").' - '.word("page")." ".$page : word("search_results");
        $data["views"]["header"] = 'inner';
        $data["views"]["footer"] = 'inner';
        $data["views"]["full_width"] = TRUE;
        $data["views"]["content"] = "search/metadata";

        $this->load->view(design_path.'/templates/main/core',$data);


    }




    public function subjectscloud(){

        if ( ! $subjectsCloudList = $this->cache->get('subjectsCloudList'))
        {
            set_time_limit(300);  //300 seconds = 5 minutes

            $header="";
            $result="\n <script>\n ";
            $string="المعارف العامة - الفلسفة وعلم النفس - الديانات - العلوم الاجتماعية - اللّغات - العلوم البحتة - العلوم التطبيقية - الفنون - الآداب - التاريخ، الجغرافيا ";

            $separator="-";

            $elements = explode($separator, $string);
            for ($i = 0; $i < count($elements); $i++) {
                $header=$header. "<li class='nav-item'><a class='nav-link' href='javascript:ShowCloud(wordsA".$i."XX)' >".$elements[$i]."</a></li>";
                $query = $this->db->query("SELECT `Tag650`, CNT FROM django.`Tag650` WHERE left(Tag650,1) in ('ا','أ','آ','ب','ت','ث','ج','ح','خ','د','ذ','ر','ز','س','ش','ص','ض','ط','ظ','ع','غ','ف','ق','ك','ل','م','ن','ه','و','ي') and `Dewey` like '" . $i . "%' order by CNT desc limit 100");
                $result=$result . "var wordsA".$i."XX=[";
                foreach ($query->result() as $row)
                {
                    $result= $result . "{text: '". str_replace("'", "’", $row->Tag650) ."', size: ". $row->CNT ."}, ";
                }
                $result= $result ."];\n";
            }



            $header2="";

            $separator="-";
            $string="Computer, general -  Philosophy - Religion - Social sciences - Language - Science - Technology - Arts - Literature - History & geography";
            $elements = explode($separator, $string);
            for ($i = 0; $i < count($elements); $i++) {
                $header2=$header2. "<li class='nav-item'><a class='nav-link' href='javascript:ShowCloud(wordsE".$i."XX)'>".$elements[$i]."</a></li>";
                $query = $this->db->query("SELECT `Tag650`,CNT FROM django.`Tag650` WHERE left(Tag650,1) in ('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z') and `Dewey` like '" . $i . "%' order by CNT desc limit 100");

                $result=$result . "var wordsE".$i."XX=[";
                foreach ($query->result() as $row)
                {
                    $result= $result . "{text: '". str_replace("'", "’", $row->Tag650) ."', size: ". $row->CNT ."}, ";
                }
                $result= $result ."];\n";
            }
            $result= $result ." </script>\n";

            $htmlTabs="". $result."
                        <script src='https://cdn.rawgit.com/wvengen/d3-wordcloud/master/lib/d3/d3.js'></script> \n
                        <script src='https://cdn.rawgit.com/wvengen/d3-wordcloud/master/lib/d3/d3.layout.cloud.js'></script> \n
                        <script src='https://cdn.rawgit.com/wvengen/d3-wordcloud/master/d3.wordcloud.js'></script> \n
                        <div class='alert alert-info' role='alert'> \n
                                سحابة رؤوس الموضوعات حسب التصنيف \n
                        </div>\n

                        <ul class='nav nav-fill' style='list-style: none;background-color: #f7f7f7;'>
                        ".$header."
                        </ul>\n
                        <ul class='nav nav-fill' style='list-style: none;background-color: #f7f7f7;'>
                        ".$header2."
                        </ul>


                        <div class='d-flex justify-content-center' id='wordcloud0'>\n

                        </div>\n


<script>
function ShowCloud(cloudArray)
{
	document.getElementById('wordcloud0').innerHTML='';
    d3.wordcloud()
        .size([900, 600])
        .selector('#wordcloud0')
        .words(cloudArray)
        .onwordclick(function(d, i) {
                                     window.location = \"/search/results/1?queries=or|subjects|\" + d.text;
                                     })
        .start()
		;
}
	ShowCloud(wordsA0XX);
    </script>
                    ";



            $subjectsCloudList=$htmlTabs;


            $this->cache->save('subjectsCloudList', $subjectsCloudList);
        }


        $data["views"]["content_view"] =$subjectsCloudList;
        $this->load->view(design_path.'/templates/main/core',$data);

    }
    public function subjects(){

        if ( ! $SubjectsList = $this->cache->get('SubjectsList'))
        {
            set_time_limit(300);  //300 seconds = 5 minutes

            $header="";
            $result="";
            $string="المعارف العامة - الفلسفة وعلم النفس - الديانات - العلوم الاجتماعية - اللّغات - العلوم البحتة - العلوم التطبيقية - الفنون - الآداب - التاريخ، الجغرافيا ";

            $separator="-";

            $elements = explode($separator, $string);
            for ($i = 0; $i < count($elements); $i++) {
                if($i!=4 && $i!=2)
                {
                    $header=$header. "<a class='nav-item nav-link ".(($i==0)?" active":"")."' id='nav-A".$i."-tab' data-toggle='tab' href='#nav-A".$i."' role='tab' aria-controls='nav-A".$i."' aria-selected='".(($i==0)?" true":"false")."'>".$elements[$i]."</a>";

                    $query = $this->db->query("SELECT `Tag650` FROM django.`Tag650` WHERE left(Tag650,1) in ('ا','أ','آ','ب','ت','ث','ج','ح','خ','د','ذ','ر','ز','س','ش','ص','ض','ط','ظ','ع','غ','ف','ق','ك','ل','م','ن','ه','و','ي') and `Dewey` like '" . $i . "%'  order by CNT desc limit 100");


                    $result=$result . " <div class='tab-pane fade ".(($i==0)?" show active":"")."' id='nav-A".$i."' role='tabpanel' aria-labelledby='nav-A".$i."-tab'>";
                    foreach ($query->result() as $row)
                    {
                        $result= $result . "<a style='margin:5px' href='/search/results/1?queries=or|subjects|". $row->Tag650 ."&dewies=". $i ."00' class='btn btn-outline-primary'>  <span class='badge badge-secondary'> ". $i ."XX </span> " . $row->Tag650 . "</a>";
                    }
                    $result= $result ." </div>";
                }
            }


            $header2="";

            $separator="-";
            $string="Computer, general -  Philosophy - Religion - Social sciences - Language - Science - Technology - Arts - Literature - History & geography";
            $elements = explode($separator, $string);
            for ($i = 0; $i < count($elements); $i++) {
                if($i!=4 && $i!=2)
                {
                    $header2=$header2. "<a class='nav-item nav-link' id='nav-B".$i."-tab' data-toggle='tab' href='#nav-B".$i."' role='tab' aria-controls='nav-B".$i."' aria-selected='false'>".$elements[$i]."</a>";


                    $query = $this->db->query("SELECT `Tag650` FROM django.`Tag650` WHERE left(Tag650,1) in ('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z') and `Dewey` like '" . $i . "%' order by CNT desc limit 100");

                    $result=$result . " <div class='tab-pane fade' id='nav-B".$i."' role='tabpanel' aria-labelledby='nav-B".$i."-tab'>";
                    foreach ($query->result() as $row)
                    {
                        $result= $result . "<a style='margin:5px' href='/search/results/1?queries=or|subjects|". $row->Tag650 ."&dewies=". $i ."00' class='btn btn-outline-primary'>  <span class='badge badge-secondary'> ". $i ."XX </span> " . $row->Tag650 . "</a>";
                    }
                    $result= $result ." </div>";
                }
            }


            $htmlTabs="
                        <div class='alert alert-info' role='alert'>
                                  تصفح اهم رؤوس الموضوعات المسجلين بقاعدة البيانات
                        </div>
                      <div class='row'>
                        <div class='col-xs-12 '>
                          <nav>
                            <div class='nav nav-tabs nav-fill' id='nav-tab' role='tablist'>
                                ".$header."
                            </div>

                            <div class='nav nav-tabs nav-fill' id='nav-tab' role='tablist'>
                                ".$header2."
                            </div>
                          </nav>
                          <div class='tab-content py-3 px-3 px-sm-0' id='nav-tabContent'>
                                ". $result."
                          </div>

                        </div>
                      </div>
                    ";



            $SubjectsList=$htmlTabs;


            $this->cache->save('SubjectsList', $SubjectsList);
        }


        $data["views"]["content_view"] =$SubjectsList;
        $this->load->view(design_path.'/templates/main/core',$data);

    }


    public function authors(){

        if ( ! $authorsList = $this->cache->get('authorsList'))
        {
            set_time_limit(300);  //300 seconds = 5 minutes

            $header="";
            $result="";
            $string="A B C D E F G H I J K L M N O P Q R S T U V W X Y Z";
            $separator=" ";

            $elements = explode($separator, $string);
            for ($i = 0; $i < count($elements); $i++) {
                $header=$header. "<a class='nav-item nav-link ".(($i==0)?" active":"")."' id='nav-".$elements[$i]."-tab' data-toggle='tab' href='#nav-".$elements[$i]."' role='tab' aria-controls='nav-".$elements[$i]."' aria-selected='".(($i==0)?" true":"false")."'>".$elements[$i]."</a>";


                $query = $this->db->query("SELECT id,title_ar,authority_type_id FROM `ddl_marc_authorities` WHERE title_ar like '".$elements[$i]."%' and authority_type_id<>0 order by authority_type_id desc limit 50");

                $result=$result . " <div class='tab-pane fade ".(($i==0)?" show active":"")."' id='nav-".$elements[$i]."' role='tabpanel' aria-labelledby='nav-".$elements[$i]."-tab'>";
                foreach ($query->result() as $row)
                {
                    $result= $result . "<a style='margin:5px' href='/search/results/?authors=". $row->id ."' class='btn btn-outline-primary'>  <span class='badge badge-secondary'> ". $row->authority_type_id ." </span> " . $row->title_ar . "</a>";
                }
                $result= $result ." </div>";
            }



            $header2="";
            $string="ا ب ت ث ج ح خ د ذ ر ز س ش ص ض ط ظ ع غ ف ق ك ل م ن ه و ي";
            $separator=" ";

            $elements = explode($separator, $string);
            for ($i = 0; $i < count($elements); $i++) {
                $header2=$header2. "<a class='nav-item nav-link' id='nav-".$elements[$i]."-tab' data-toggle='tab' href='#nav-".$elements[$i]."' role='tab' aria-controls='nav-".$elements[$i]."' aria-selected='false'>".$elements[$i]."</a>";


                $query = $this->db->query("SELECT id,title_ar,authority_type_id FROM `ddl_marc_authorities` WHERE title_ar like '".$elements[$i]."%' and authority_type_id<>0 order by authority_type_id desc limit 50");

                $result=$result . " <div class='tab-pane fade' id='nav-".$elements[$i]."' role='tabpanel' aria-labelledby='nav-".$elements[$i]."-tab'>";
                foreach ($query->result() as $row)
                {
                    $result= $result . "<a style='margin:5px' href='/search/results/?authors=". $row->id ."' class='btn btn-outline-primary'> <span class='badge badge-secondary'> ". $row->authority_type_id ." </span> " . $row->title_ar . "</a>";
                }
                $result= $result ." </div>";
            }


            $htmlTabs="
                        <div class='alert alert-info' role='alert'>
                                  تصفح اهم المؤلفين المسجلين بقاعدة البيانات
                        </div>
                      <div class='row'>
                        <div class='col-xs-12 '>
                          <nav>
                            <div class='nav nav-tabs nav-fill' id='nav-tab' role='tablist'>
                                ".$header."
                            </div>

                            <div class='nav nav-tabs nav-fill' id='nav-tab' role='tablist'>
                                ".$header2."
                            </div>
                          </nav>
                          <div class='tab-content py-3 px-3 px-sm-0' id='nav-tabContent'>
                                ". $result."
                          </div>

                        </div>
                      </div>
                    ";



            $authorsList=$htmlTabs;


            $this->cache->save('authorsList', $authorsList);
        }


        $data["views"]["content_view"] =$authorsList;
        $this->load->view(design_path.'/templates/main/core',$data);

    }



    public function journals()
    {
        set_time_limit(300);  //300 seconds = 5 minutes

        $header="";
        $header2="";
        $result="";
        $string="0 1 2 3 4 5 6 7 8 9";
        $separator=" ";

        $deweyA="
                    علم الحاسوب
                    |
                    الفلسفة
                    |
                    الأديان
                    |
                    العلوم الاجتماعية
                    |
                    اللغات
                    |
                    العلوم الطبيعية
                    |
                    العلوم التطبيقية
                    |
                    الفنون
                    |
                    الآداب
                    |
                    التاريخ والجغرافيا
            ";
        $deweyE="
                    Computer Science
                    |
                    Philosophy
                    |
                    Religions
                    |
                    Social Sciences
                    |
                    Languages
                    |
                    Natural Science
                    |
                    Applied Sciences
                    |
                    Arts
                    |
                    Literature
                    |
                    History & Geography
            ";



        $deweyArrayA= explode('|', $deweyA);
        $deweyArrayE= explode('|', $deweyE);

        $elements = explode($separator, $string);

        //Arabic
        for ($i = 0; $i < count($elements); $i++) {
            $header=$header. "<a class='nav-item nav-link' id='nav-".$elements[$i]."-tab' data-toggle='tab' href='#nav-".$elements[$i]."' role='tab' aria-controls='nav-".$elements[$i]."' aria-selected='".(($i==0)?" true":"false")."'>".$deweyArrayA[$i]."</a>";
            $query = $this->db->query("SELECT id,left(title_ar,50) title_ar
                                        FROM django.`z3950_marc_bibliographies`
                                        where biblio_type_id=3
                                        and source_id not in (5,23)
                                        and substring(title_ar,1,1) in ('ا','أ','إ','آ','ب','ت','ث','ج','ح','خ','د','ذ','ر','ز','س','ش','ص','ض','ط','ظ','ع','غ','ف','ق','ك','ل','م','ن','ه','و','ي')
                                        and `id` in (select BibID from django.z3950_rawmarc where `key`='082.a' and `value` like '".$elements[$i]."%')
                                        limit 50");
            $result=$result . " <div class='tab-pane fade' id='nav-".$elements[$i]."' role='tabpanel' aria-labelledby='nav-".$elements[$i]."-tab'>";

            foreach ($query->result() as $row)
            {
                $result= $result . "<a style='margin:5px' href='/book/". $row->id ."' class='btn btn-outline-primary'>  <span class='badge badge-secondary'> ". $row->id ." </span> " . $row->title_ar . "</a>";
            }
            $result= $result ." </div>";
        }
        //English
        for ($i = 0; $i < count($elements); $i++) {
            $header2=$header2. "<a class='nav-item nav-link ".(($i==0)?" active":"")."' id='nav-e".$elements[$i]."-tab' data-toggle='tab' href='#nav-e".$elements[$i]."' role='tab' aria-controls='nav-e".$elements[$i]."' aria-selected='".(($i==0)?" true":"false")."'>".$deweyArrayE[$i]."</a>";
            $query = $this->db->query("SELECT id,left(title_ar,50) title_ar
                                        FROM django.`z3950_marc_bibliographies`
                                        where biblio_type_id=3
                                        and source_id not in (5,23)
                                        and substring(title_ar,1,1) in ('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z')
                                        and `id` in (select BibID from django.z3950_rawmarc where `key`='082.a' and `value` like '".$elements[$i]."%')
                                        limit 50");
            $result=$result . " <div class='tab-pane fade ".(($i==0)?" show active":"")."' id='nav-e".$elements[$i]."' role='tabpanel' aria-labelledby='nav-e".$elements[$i]."-tab'>";

            foreach ($query->result() as $row)
            {
                $result= $result . "<a style='margin:5px' href='/book/". $row->id ."' class='btn btn-outline-primary'>  <span class='badge badge-secondary'> ". $row->id ." </span> " . $row->title_ar . "</a>";
            }
            $result= $result ." </div>";
        }

        $htmlTabs="
                      <div class='alert alert-info' role='alert'>
                                  تصفح الدوريات المسجلين بقاعدة البيانات
                      </div>
                      <div class='row'>
                        <div class='col-xs-12 '>
                          <nav>
                            <div class='nav nav-tabs nav-fill' id='nav-tab' role='tablist'>
                                ".$header."
                            </div>

                            <div class='nav nav-tabs nav-fill' id='nav-tab' role='tablist'>
                                ".$header2."
                            </div>
                          </nav>
                          <div class='tab-content py-3 px-3 px-sm-0' id='nav-tabContent'>
                                ". $result."
                          </div>

                        </div>
                      </div>
                    ";




        $data["views"]["content_view"] =$htmlTabs;
        $this->load->view(design_path.'/templates/main/core',$data);
    }
}