<div class="row pb-3">
       
    
    <div class="col-md-12">
        <?php $this->load->view(style.'/templates/home/parts/special_libraries' , array("content"=>$content) );   ?>   
    </div>
               
               
               
    <div class="col-md-8">
              
        <?php if(@$content["sliders"]["recent_books"] || $content["sliders"]["featured_books"]){ ?>      
            <div class="mt-2">
                <?php $this->load->view(style.'/templates/home/parts/books_widget' , array("content"=>$content) );   ?>   
            </div>
        <?php } ?>

        
        <?php if(@$content["widgets"]["book-in-minutes"]){ ?>
            <div class="mt-4">                
                <?php 
                    $data = array(
                        "slider_id"=>"book-in-minutes" , 
                        "slider_title"=>word("Book_minutes"), 
                        "books"=>$content["widgets"]["book-in-minutes"]
                    );
                ?>                
                <?php $this->load->view(style.'/templates/home/parts/general_slider',$data);   ?>                                            
            </div>
        <?php } ?>

        
        <?php if(@$content["widgets"]["magazines"]){ ?>
            <div class="mt-4">                
                <?php 
                    $data = array(
                        "slider_id"=>"magazines" , 
                        "slider_title"=>word("magazines_publications"), 
                        "books"=>$content["widgets"]["magazines"]
                    );
                ?>                
                <?php $this->load->view(style.'/templates/home/parts/general_slider',$data);   ?>                                            
            </div>
        <?php } ?>

 
    </div>

    
    

    <div class="col-md-4">
                        
                        
        <div class="mt-2 mb-4">
            <?php $this->load->view(style.'/templates/home/parts/top_views');   ?> 
            <?php $this->load->view(style.'/templates/home/parts/now_reading');   ?>
        </div>
                    
        <?php if(@$content["widgets"]["arts"]){ ?>
            <div class="mt-4">
                <?php $this->load->view(style.'/templates/home/parts/arts_slider' , array("arts"=>$content["widgets"]["arts"]) );   ?>
            </div>
        <?php } ?>

        
        <?php if(@$content["widgets"]["rare_manuscripts"]){ ?>
            <div class="mt-2">
                <?php 
                    $data = array(
                        "list_id"=>"rare_files" , 
                        "list_title"=>word("rare_manuscripts"), 
                        "items"=>$content["widgets"]["rare_manuscripts"]
                    );
                ?>                
                <?php $this->load->view(style.'/templates/home/parts/rare_widget',$data);   ?>                                
            </div>              
        <?php } ?>
              
        <?php if(@$content["sliders"]["news"]){ ?>
            <div class="mt-4">
                <?php $this->load->view(style.'/templates/home/parts/news_slider' , array("news"=>$content["sliders"]["news"]));   ?>                    
            </div>
        <?php } ?>              
              
               
                  
        <?php if(isset($content["widgets"]["twitter_post"][0])){ ?>      
            <div class="mt-4">
                <?php $this->load->view(style.'/templates/home/parts/twitter_post' , array("post"=>$content["widgets"]["twitter_post"][0]) );   ?>
            </div>                     
        <?php } ?>
        
        <?php if(@$content["widgets"]["events"]){ ?>
            <div class="mt-4">
                <?php $this->load->view(style.'/templates/home/parts/events_widget' , array("events"=>$content["widgets"]["events"]) );   ?>                                                                    
            </div>
        <?php } ?>            
                           
                                
    </div>        
         
         
         
    <div class="col-12">
    
        <?php if(@$content["sponsors"]["sponsors"]){ ?>
            <div class="mt-4">
                <?php $this->load->view(style.'/templates/home/parts/sponsors' , array("sponsors"=>$content["sponsors"]["sponsors"]) );   ?>                            
            </div>                     
        <?php } ?>
    
    </div>
    
    
</div>
       
<script type="text/javascript">
    <?php if ($mobile_view == FALSE) {  ?>    
        $(document).ready(function(){
                // $('#knowledgesummit').modal('show');
        });
    <?php } ?>
</script>