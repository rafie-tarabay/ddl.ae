<div class="card card-default rounded-0  " id="now_reading_header">
    <div class="card-header">    
        <div class="text-center">
            <a href="<?php echo base_url(); ?>"><img style="height:120px;" class="img-fluid p-2 logo" src="<?php echo base_url("assets/images/logos/ddl_logo.png") ?>" alt="site logo" /></a>                    
            <a href="<?php echo base_url("live"); ?>"><img style="height:120px;" class="img-fluid p-2 logo" src="<?php echo base_url("assets/images/logos/ddl_live.png") ?>" alt="live logo" /></a>                    
        </div>            
    </div>
</div>
    

<div class="mx-auto my-2"  id="now_reading">

    <div class="grid row no-gutters mt-3" id="results">

        <?php foreach($logs as $log){ ?>
        
            <?php $book = json_decode($log->log_rel_text); ?>
            
            <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-1 grid-item">
                
                <div class="single_item  book_<?php if(isset($book->id)){ echo $book->id;} ?>">
                    
                    <div class="card rounded-0">
                      <?php
                        $cover='';
                        if(isset($book->cover))
                        { 

                            $cover = str_replace("sgp1","sgp1.cdn", $book->cover);;
                        } 
                     ?>
                        <a target="_blank" class="cover" href="<?php if(isset($book->id)){ echo base_url(front_base."book/".$book->id) ;}?>">
                            <img class="card-img-top " src="<?php  echo  $book->cover; ?>"  alt=" ">
                        </a>
                        
                        <div class="card-body">                            
                            
                            <h5 class="card-title book_title">
                                <a target="_blank" href="<?php  if(isset($book->id)){ echo base_url(front_base."book/".$book->id);} ?>">
                                    <div class="title_gradient"></div>                                
                                    <?php if(isset($book->title)){  echo $book->title;} ?>
                                </a>
                            </h5>                            
                            
                            <?php if(isset($book) && isset($book->author)){ ?>
                                <p class="card-text author"><?php echo $book->author ?></p>
                            <?php } ?>
                            
                            <p class="card-text timestamp"><i class="fa fa-clock"></i> <span class="timeago small"><?php echo date("c",$log->log_timestamp) ?></span></p>
                            
                        </div>
                        
                    </div>                
                    
                </div>                
                
            </div>

        <?php } ?>       

    </div>

</div>  


<script src="//cdnjs.cloudflare.com/ajax/libs/socket.io/2.2.0/socket.io.js" type="text/javascript"></script>
<script type="text/javascript">

    function append_content(new_content){   
        $(new_content).hide().prependTo('#results').fadeIn();           
    }
    
    
    
    var socket = io.connect('//socket.ddl.ae:8080',{ 
        secure: true,
        reconnection: true,
        reconnectionDelay: 1000,
        reconnectionDelayMax : 5000,        
        reconnectionAttempts: Infinity
    });
    
    /// Getting From Server
    socket.emit('set_room_id', "view_book_readers" );
    
    socket.on('book_data', function(data) {
        console.log(data);
        var time_now = new Date();
        var msg = '';
        
        
        msg +='<div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-1 grid-item">';
            msg +='<div class="single_item book_'+data.id+'">';
                msg +='<div class="card rounded-0">';
                    msg +='<a target="_blank" href="'+data.url+'">';
                        msg +='<img class="card-img-top cover" src="'+data.cover+'" alt="<?php echo word("cover") ?> '+data.title+'">';
                    msg +='</a>';
                    msg +='<div class="card-body">';
                        msg +='<h5 class="card-title book_title">';
                            msg +='<a target="_blank" href="'+data.url+'">';
                                msg +='<div class="title_gradient"></div>';
                                msg += data.title;
                            msg +='</a>';
                        msg +='</h5>';
                        msg +='<p class="card-text author">'+data.author+'</p>';
                        msg +='<p class="card-text timestamp"><i class="fa fa-clock"></i> <span class="timeago small">'+time_now+'</span></p>';
                    msg +='</div>';
                msg +='</div>';
            msg +='</div>';
        msg +='</div>';
        
  
        
        if($(".book_"+data.id)[0]){                 
            $(".book_"+data.id).remove();
        }else{
            $(".grid .grid-item:last-child").remove();
        }                                                      
        
        append_content(msg);        
        
        $('.timeago').cuteTime({ refresh: 1000*20 });        
        
        refreshMasonary(1000);     
    });
     
    
</script>
