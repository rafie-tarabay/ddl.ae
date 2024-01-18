<div class="mt-4">

    <div class="list-group">
    
        <div class="list-group-item bg-gray">

            <div class="row">
                <div class="col-md-8">
                    <i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo word("fags") ?>
                </div>
                <div class="col-md-4 text-<?php echo OppAlign; ?>">
                    <a class="btn btn-info  btn-sm" href="<?php echo base_url("page/contact/"); ?>"><?php echo word("contact_us") ?></a>
                </div>
            </div>                   
            
        </div>    
    
        <?php foreach($sections as $section){ ?>                               
            <a class="list-group-item" href="<?php echo base_url("faq/".$section->section_id); ?>">
                <h5><i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo $section->section_title; ?></h5>
                <div>
                    <small><?php echo $section->section_desc; ?></small>
                </div>
            </a>
        <?php } ?>
    </div>

</div>