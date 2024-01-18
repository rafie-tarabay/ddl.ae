<div class="mt-4">

    <div class="card card-default mb-4">
        <div class="card-header">
            <div class="row">
                <div class="col-md-8">
                    <i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo $section->section_title ?>
                </div>
                <div class="col-md-4 text-<?php echo OppAlign; ?>">
                    <a class="btn btn-info btn-sm" href="<?php echo base_url("faq"); ?>"><?php echo word("fags") ?></a>
                </div>
            </div>                     
        </div>
    </div>


    <div class="row">


        <div class="col-md-4">

            <div class="list-group">
                <div class="list-group-item bg-gray"><i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo word("sections") ?> </div>
                <?php foreach($sections as $sec){ ?>
                    <?php $active = $section->section_id == $sec->section_id ; ?>
                    <a class="list-group-item <?php if($active) echo "selected" ?>" href="<?php echo base_url("faq/".$sec->section_id); ?>"><i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo $sec->section_title; ?></a>
                <?php } ?>
            </div>
        
        </div>
        

        <div class="col-md-8">

            <div class="list-group">
                <div class="list-group-item bg-gray"><i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo word("subjects") ?></div>
                <?php foreach($topics as $topic){ ?>
                    <a class="list-group-item" href="<?php echo base_url("faq/topic/".$topic->topic_id); ?>"><i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo $topic->topic_title; ?></a>
                <?php } ?>
            </div> 

        </div>        

    </div>

</div>