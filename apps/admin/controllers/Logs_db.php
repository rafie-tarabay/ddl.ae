<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logs_db extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if(!logged_in ){ redirect(base_url(admin_base."admins/login")); exit; }
        $this->db = $this->load->database("frontend",true);         
        $this->logsDB = $this->load->database("logs",true);  
    }    

    public function index(){

        if(can("view_logs_db")){

            $data["views"]["content"] = 'logs_db/types';   
            $data["data"]["title"] = "السجلات";

            $this->load->view(style.'/templates/main/core',$data);   

        }

    }


    public function ViewBookSummary()
    {

        if ( ! $ViewBookSummary = $this->cache->get('ViewBookSummary'))
        {

           set_time_limit(300);  //300 seconds = 5 minutes
           $query = $this->logsDB->query("SELECT year(from_unixtime(floor(`log_timestamp`))) as y,month(from_unixtime(floor(`log_timestamp`))) as m,count(*) as c FROM `ddl_guest_logs` group by year(from_unixtime(floor(`log_timestamp`))),month(from_unixtime(floor(`log_timestamp`))) order by year(from_unixtime(floor(`log_timestamp`))) desc,month(from_unixtime(floor(`log_timestamp`))) desc");

                $result="  
                                    <script src='https://code.jquery.com/jquery-3.5.1.js'></script>
                                    <script src='https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js'></script>
                                    <script src='https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js'></script>
                                    <script src='https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js'></script>
                                    <script src='https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js'></script>
                                    <script src='https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js'></script>
                                    <script src='https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js'></script>

                                    <link rel='stylesheet' type='text/css' href='https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css'>
                                    <link rel='stylesheet' type='text/css' href='https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css'>



                                   <div class='card card-default'>
                                        <div class='card-header'>
                                            <div class='row'>
                                                <div class='col-sm-8 no-padding'>                
                                                    <h5 class='card-title'> عدد مرات الاطلاع حسب الاشهر</h5>
                                                </div>
                                                <div class='col-sm-4  no-padding text-left'>
                                                    <a class='btn btn-info' href='". base_url(admin_base.ctrl()) ."'>الرجوع</a>                
                                                </div>            
                                            </div>
                                        </div>  
                                    </div>
                                    <br>
                                    <table id='example' class='table table-striped'>
                                        <thead>
                                          <tr>
                                            <th style='text-align: right;'>الشهر</th>
                                            <th style='text-align: right;'>عدد مرات الاطلاع</th>
                                            <th style='text-align: right;'>السنه</th>
                                          </tr>
                                        </thead>
                                        <tbody>";
                foreach ($query->result() as $row)
                {
                    $result= $result . "      <tr>
                                                <td>". $row->y ."</td>
                                                <td>". $row->m ."</td>
                                                <td>". $row->c ."</td>
                                              </tr>";

                }
                $result= $result ." </tbody>
                                    </table>

                                    <script>
                                    $(document).ready(function() {
                                        $('#example').DataTable( {
                                            dom: 'B',
                                            paging: false,
                                            ordering: false,
                                            info: false,
                                            searching: false,
                                            buttons: [
                                                'copyHtml5',
                                                'excelHtml5',
                                                'csvHtml5'
                                            ]
                                        } );
                                    } );
                                    </script>";

           $ViewBookSummary=$result;
           $this->cache->save('ViewBookSummary', $ViewBookSummary);

        }

        $data["data"]["title"] = "View Items Summary";

        $data["views"]["content_view"] =$ViewBookSummary;
        $this->load->view(style.'/templates/main/core',$data);            

        
     }

    public function DownloadSummary()
    {

        if ( ! $DownloadSummary = $this->cache->get('DownloadSummary'))
        {

           set_time_limit(300);  //300 seconds = 5 minutes
           $query = $this->logsDB->query("SELECT year(from_unixtime(floor(`download_timestamp`))) as y,month(from_unixtime(floor(`download_timestamp`))) as m,count(*) as c FROM `ddl_downloads` group by year(from_unixtime(floor(`download_timestamp`))),month(from_unixtime(floor(`download_timestamp`))) order by year(from_unixtime(floor(`download_timestamp`))) desc,month(from_unixtime(floor(`download_timestamp`))) desc");

                $result="           <script src='https://code.jquery.com/jquery-3.5.1.js'></script>
                                    <script src='https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js'></script>
                                    <script src='https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js'></script>
                                    <script src='https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js'></script>
                                    <script src='https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js'></script>
                                    <script src='https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js'></script>
                                    <script src='https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js'></script>

                                    <link rel='stylesheet' type='text/css' href='https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css'>
                                    <link rel='stylesheet' type='text/css' href='https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css'>

                                   <div class='card card-default'>
                                        <div class='card-header'>
                                            <div class='row'>
                                                <div class='col-sm-8 no-padding'>                
                                                    <h5 class='card-title'> عدد مرات تحميل النص الكامل حسب الاشهر</h5>
                                                </div>
                                                <div class='col-sm-4  no-padding text-left'>
                                                    <a class='btn btn-info' href='". base_url(admin_base.ctrl()) ."'>الرجوع</a>                
                                                </div>            
                                            </div>
                                        </div>  
                                    </div>
                                    <br>
                                    <table id='example' class='table table-striped'>
                                        <thead>
                                          <tr>
                                            <th style='text-align: right;'>السنه</th>
                                            <th style='text-align: right;'>الشهر</th>
                                            <th style='text-align: right;'>عدد مرات التحميل</th>
                                          </tr>
                                        </thead>
                                        <tbody>";
                foreach ($query->result() as $row)
                {
                    $result= $result . "      <tr>
                                                <td>". $row->y ."</td>
                                                <td>". $row->m ."</td>
                                                <td>". $row->c ."</td>
                                              </tr>";

                }
                $result= $result ." </tbody>
                                    </table>
                                    <script>
                                    $(document).ready(function() {
                                        $('#example').DataTable( {
                                            dom: 'B',
                                            paging: false,
                                            ordering: false,
                                            info: false,
                                            searching: false,
                                            buttons: [
                                                'copyHtml5',
                                                'excelHtml5',
                                                'csvHtml5'
                                            ]
                                        } );
                                    } );
                                    </script>";


           $DownloadSummary=$result;
           $this->cache->save('DownloadSummary', $DownloadSummary);

        }

        $data["data"]["title"] = "Download Summary";

        $data["views"]["content_view"] =$DownloadSummary;
        $this->load->view(style.'/templates/main/core',$data);            

        
     }

     public function Searchsummary(){

        if ( ! $Searchsummary = $this->cache->get('Searchsummary'))
        {

           set_time_limit(300);  //300 seconds = 5 minutes
           $query = $this->logsDB->query("SELECT year(from_unixtime(floor(`log_timestamp`))) as y,month(from_unixtime(floor(`log_timestamp`))) as m,count(*) as c FROM `ddl_search` group by year(from_unixtime(floor(`log_timestamp`))),month(from_unixtime(floor(`log_timestamp`))) order by year(from_unixtime(floor(`log_timestamp`))) desc,month(from_unixtime(floor(`log_timestamp`))) desc");

                $result="           <script src='https://code.jquery.com/jquery-3.5.1.js'></script>
                                    <script src='https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js'></script>
                                    <script src='https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js'></script>
                                    <script src='https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js'></script>
                                    <script src='https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js'></script>
                                    <script src='https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js'></script>
                                    <script src='https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js'></script>
                                    <link rel='stylesheet' type='text/css' href='https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css'>
                                    <link rel='stylesheet' type='text/css' href='https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css'>

                                   <div class='card card-default'>
                                        <div class='card-header'>
                                            <div class='row'>
                                                <div class='col-sm-8 no-padding'>                
                                                    <h5 class='card-title'> عدد مرات البحث حسب الاشهر</h5>
                                                </div>
                                                <div class='col-sm-4  no-padding text-left'>
                                                    <a class='btn btn-info' href='". base_url(admin_base.ctrl()) ."'>الرجوع</a>                
                                                </div>            
                                            </div>
                                        </div>  
                                    </div>
                                    <br>
                                    <table id='example' class='table table-striped'>
                                        <thead>
                                          <tr>
                                            <th style='text-align: right;'>السنه</th>
                                            <th style='text-align: right;'>الشهر</th>
                                            <th style='text-align: right;'>عدد مرات البحث</th>
                                          </tr>
                                        </thead>
                                        <tbody>";
                foreach ($query->result() as $row)
                {
                    $result= $result . "      <tr>
                                                <td>". $row->y ."</td>
                                                <td>". $row->m ."</td>
                                                <td>". $row->c ."</td>
                                              </tr>";

                }
                $result= $result ." </tbody>
                                    </table>
                                    <script>
                                    $(document).ready(function() {
                                        $('#example').DataTable( {
                                            dom: 'B',
                                            paging: false,
                                            ordering: false,
                                            info: false,
                                            searching: false,
                                            buttons: [
                                                'copyHtml5',
                                                'excelHtml5',
                                                'csvHtml5'
                                            ]
                                        } );
                                    } );
                                    </script>";


           $Searchsummary=$result;
           $this->cache->save('Searchsummary', $Searchsummary);

        }

        $data["data"]["title"] = "Search Summary";

        $data["views"]["content_view"] =$Searchsummary;
        $this->load->view(style.'/templates/main/core',$data);            

        
     }

    public function downloads(){

        if(can("view_logs_db")){

            $count = $this->logsDB->count_all_results("downloads"); 

            $per_page = 20;                                    
            $pagination = $this->base->paginate_me($count,$per_page,"logs_db/downloads/",3);            

            $this->logsDB->limit($per_page, $pagination["page"]); 
            $this->logsDB->order_by("download_id","DESC");
            $records = $this->logsDB->get("downloads")->result();

            foreach($records as $record){
                if(!is_null($record->download_u_id)){
                    $this->db->select("u_id,u_fullname");
                    $this->db->where("u_id",$record->download_u_id)->limit(1);
                    $record->user = $this->db->get("users")->row();
                }
            }

            $data["data"]["pagination"] = $pagination["links"];

            $data["data"]["count"] = $count;
            $data["data"]["records"] = $records;
            $data["views"]["content"] = 'logs_db/downloads';   
            $data["data"]["title"] = "السجلات | سجلات التحميل ";

            $this->load->view(style.'/templates/main/core',$data);            

        }
    }


    public function search(){

        if(can("view_logs_db")){

            $count = $this->logsDB->count_all_results("search"); 

            $per_page = 30;                                    
            $pagination = $this->base->paginate_me($count,$per_page,"logs_db/search/",3);            

            $this->logsDB->limit($per_page, $pagination["page"]); 
            $this->logsDB->order_by("log_id","DESC");
            $records = $this->logsDB->get("search")->result();

            $data["data"]["pagination"] = $pagination["links"];

            $data["data"]["count"] = $count;
            $data["data"]["records"] = $records;
            $data["views"]["content"] = 'logs_db/search';   
            $data["data"]["title"] = "السجلات | سجلات البحث ";

            $this->load->view(style.'/templates/main/core',$data);            

        }
    }


    public function remove_search_log(){

        $keywords = trim($this->input->post("keywords"));
        $field = $this->input->post("field");

        if($field == "all"){
            $this->logsDB->or_like("log_title_keywords",$keywords,"both");
            $this->logsDB->or_like("log_author_keywords",$keywords,"both");
            $this->logsDB->or_like("log_publisher_keywords",$keywords,"both");
            $this->logsDB->or_like("log_content_keywords",$keywords,"both");
            $this->logsDB->or_like("log_series_keywords",$keywords,"both");
            $this->logsDB->or_like("log_subjects_keywords",$keywords,"both");
        }else{
            $this->logsDB->or_like($field,$keywords,"both");
        }

        $this->logsDB->delete("search");

        redirect(base_url(admin_base."logs_db/search"));

    }    




    public function actions($users = 0){

        if(can("view_logs_db")){

            $table = $users ? "user_logs" : "guest_logs"; 

            $count = $this->logsDB->count_all_results($table); 

            $per_page = 30;                                    
            $pagination = $this->base->paginate_me($count,$per_page,"logs_db/actions/$users/",4);            

            $this->logsDB->limit($per_page, $pagination["page"]); 
            $this->logsDB->order_by("log_id","DESC");
            $records = $this->logsDB->get($table)->result();

            $data["data"]["pagination"] = $pagination["links"];

            $data["data"]["users"] = $users;
            $data["data"]["count"] = $count;
            $data["data"]["records"] = $records;
            $data["views"]["content"] = 'logs_db/actions';   
            $data["data"]["title"] = "السجلات | سجلات المستخدمين ";

            $this->load->view(style.'/templates/main/core',$data);            

        }
    }








    public function sources(){

        if( $limit = can("view_sources") ){        

            $sources = $this->cache->get("admin_sources_$limit");       
            if ( !$sources ){                

                if($limit != "all"){   
                    $this->db->where("id",$limit);
                }            
                $sources = $this->db->order_by("title_ar","DESC")->get("sources")->result();

                foreach($sources as $source){

                    $this->logsDB->where("download_free_access",1);
                    $source->count_free_access = $this->logsDB->where("download_source_id",$source->id)->count_all_results("downloads"); 

                    $this->logsDB->where("download_purchased",1);
                    $source->count_purchased = $this->logsDB->where("download_source_id",$source->id)->count_all_results("downloads"); 

                    if($limit == "all"){
                        $this->logsDB->where("download_free_material",1);
                        $source->count_free_material = $this->logsDB->where("download_source_id",$source->id)->count_all_results("downloads"); 
                        $source->count = $this->logsDB->where("download_source_id",$source->id)->count_all_results("downloads");      
                    }

                }
                
                $this->cache->save("admin_sources_$limit", $sources, 60*60*2);
            }

            $data["data"]["sources"] = $sources;
            $data["views"]["content"] = 'logs_db/sources/list_sources';   
            $data["data"]["title"] = "المصادر";
            $this->load->view(style.'/templates/main/core',$data);           
        }

    }

    public function source_statistics($source_id = 0){

        if( $limit = can("view_sources") && in_array(can("view_sources") , array("all",$source_id))){        

            $this->logsDB->where("download_free_access",1);
            $count_free_access = $this->logsDB->where("download_source_id",$source_id)->count_all_results("downloads"); 

            $this->logsDB->where("download_purchased",1);
            $count_purchased = $this->logsDB->where("download_source_id",$source_id)->count_all_results("downloads"); 

            if($limit != "all"){
                $this->logsDB->group_start();
                $this->logsDB->or_where("download_free_access",1);
                $this->logsDB->or_where("download_purchased",1);                
                $this->logsDB->group_end();
            }
            $count = $this->logsDB->where("download_source_id",$source_id)->count_all_results("downloads"); 

            $per_page = 20;                                    
            $pagination = $this->base->paginate_me($count,$per_page,"logs_db/source_statistics/$source_id/",4);            

            $this->logsDB->limit($per_page, $pagination["page"]); 
            $this->logsDB->order_by("download_id","DESC");
            if($limit != "all"){
                $this->logsDB->group_start();
                $this->logsDB->or_where("download_free_access",1);
                $this->logsDB->or_where("download_purchased",1);                
                $this->logsDB->group_end();            
            }
            $records = $this->logsDB->where("download_source_id",$source_id)->get("downloads")->result();

            foreach($records as $record){
                if(!is_null($record->download_u_id)){
                    $this->db->select("u_id,u_fullname");
                    $this->db->where("u_id",$record->download_u_id)->limit(1);
                    $record->user = $this->db->get("users")->row();
                }
            }

            $data["data"]["pagination"] = $pagination["links"];

            $data["data"]["count_free_access"] = $count_free_access;
            $data["data"]["count_purchased"] = $count_purchased;
            $data["data"]["records"] = $records;
            $data["views"]["content"] = 'logs_db/sources/source_statistics';   
            $data["data"]["title"] = "المصادر | احصائيات التحميلات ";

            $this->load->view(style.'/templates/main/core',$data);  

        }else{
            redirect(base_url(admin_base));
        }          

    }


    public function toggle_source($source_id,$disabled){

        if( can("control_sources") ){        

            $this->db->where("id",$source_id)->update("sources",array("disabled"=>$disabled));
            redirect(base_url(admin_base."logs_db/sources"));

        }else{
            redirect(base_url(admin_base));
        } 
    }


    
    
    public function refresh_source_revenues(){

        $sources = $this->db->get("sources")->result();

        foreach($sources as $source){
            $this->db->select('rev_source_id');
            $this->db->select_sum('rev_amount');            
            $source_rev = $this->db->where("rev_source_id",$source->id)->get("sources_revenues")->row(); 

            $source_data = array(
                "revenues" => $source_rev->rev_amount ? $source_rev->rev_amount : 0,
            );
            $this->db->where("id",$source->id)->update("sources",$source_data);
            
            //prntf($this->db->last_query());
            
        }

        redirect(base_url(admin_base."logs_db/sources/?xcache=1"));
        
    } 




    public function top_viewed_books($table="users"){

        $table = $table == "users" ? "user_logs" :"guest_logs" ;

        $records = $this->cache->get("top_viewed_books_".$table);        
        if ( !$records ){           

            //SELECT count(`log_rel_id`) as `repeats` , `log_rel_id` FROM `ddl_user_logs` WHERE `log_action` = 'view_book' group by `log_rel_id` order by `repeats` DESC     
            $this->logsDB->select("count(`log_rel_id`) as `repeats` , $table.*");
            $this->logsDB->where("log_action","view_book");
            $this->logsDB->group_by("log_rel_id")->order_by("repeats","DESC");
            $records = $this->logsDB->limit(500)->get($table)->result();

            $this->cache->save("top_viewed_books_".$table, $records, 60*60*24);

            //prnt($this->logsDB->last_query());
        }

        $data["data"]["records"] = $records;
        $data["views"]["content"] = 'logs_db/top_viewed_books';   
        $data["data"]["title"] = "السجلات | الأكثر مشاهدة "; 
        $this->load->view(style.'/templates/main/core',$data);         


    }    





}