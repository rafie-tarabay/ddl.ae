 
   <div class="row special_icons mt-4" >
    <div onclick="location='https://ddl.mbrf.ae/library/school'" class="col-md-4">
      <div class="card card-1">
        <h4>بوابة الأطفال والطلاب</h4>
        <p>نافذة إلى عالم مليء بالقصص والكتب المعرفية للأطفال والطلاب واليافعين 
</p>
      </div>
    </div>
    <div class="col-md-4" onclick="location='/browse/reader_corner_trends'" >
      <div class="card card-2">
        <h4>بوابة القارئ العام</h4>
        <p>مجتمع غني بالكنوز العلمية والمعرفية العامة التي تهم القارئ عموماً في شتى المجالات
</p>
      </div>
    </div>
    <div onclick="location='https://ddl.mbrf.ae/search/results/1?sources=4;6;7;10;11;12;13;14;17;19;20;21;22;250'" class="col-md-4">
      <div class="card card-3">
        <h4>بوابة الباحثين</h4>
        <p>  منهل معرفي متخصص في المجالات الأكاديمية والتخصصية يجد فيها كل باحث بغيته</p>
      </div>
    </div>
  </div>
 

<div class="row text-center mt-4" id="special_lib_widget">

    <?php 
    
        $libs = $content["widgets"]["special-libraries"]; 
        $libraries = array();
        foreach($libs as $lib){
            if($lib->content_rel_title2 == "main"){
                $libraries["main"] = $lib;
            }else{
                $libraries["small"][] = $lib;
            }
        }
    
    ?>

    <div class="col-md-4">
        <?php if($lib = $libraries["main"]){ ?>
            <a class="special_library large" href="<?php echo $lib->content_rel_url1; ?>" target="_blank">
                <img class="img-fluid rounded" src="<?php echo base_url($lib->content_rel_image1); ?>"  alt="<?php echo word("image") ?>"/>
            </a>        
        <?php } ?>
    </div>                                  

    <div class="col-md-8">    
        
        <div class="row">

            <?php foreach($libraries["small"] as $lib){ ?>
                <div class="<?php echo $lib->content_rel_text1 ? $lib->content_rel_text1 : "col-md-4"; ?> ">
                    <?php if($lib->content_rel_url2 != "disabled"){ ?>
                        <a class="special_library small" href="<?php echo $lib->content_rel_url1; ?>" target="_blank">                    
                            <img class="img-fluid rounded" src="<?php echo base_url($lib->content_rel_image1); ?>"  alt="<?php echo word("image") ?>"/>
                        </a>
                    <?php }else{ ?>
                        <a class="special_library small" title="<?php echo word("soon"); ?>" rel="tooltip" target="_blank">                    
                            <img class="img-fluid rounded" src="<?php echo base_url($lib->content_rel_image1); ?>"  alt="<?php echo word("image") ?>"/>
                        </a>
                    <?php }?>                        
                </div>
            <?php } ?>                 

        </div>    
    
    </div>

</div>