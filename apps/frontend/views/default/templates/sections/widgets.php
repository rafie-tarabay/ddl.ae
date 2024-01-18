
<div class="special_library">

    <?php $file = @$section->cover ? $section->cover : rand(1,6).".jpg" ?>
    <div class="jumbotron rounded border" style="background-image: url('<?php echo base_url("assets/images/bgs/".$file) ?>');">
        <div class="layout rounded">
            <table class="table border-0">
                <tr>
                    <td valign="middle">
                        <div class="m-auto   line-height-30">
                            <h1 class=""><?php echo $section->title ?></h1>
                            <?php if($section->desc){ ?>
                                <h5 class="mt-4 line-height-30 desc"><?php echo $section->desc ?></h5>
                            <?php } ?>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>


    <div class="row mt-4 grid"> 

        <?php foreach($widgets as $widget){ ?>
        
            <div class="mb-3 grid-item <?php echo $widget->widget_grid_css_class ? $widget->widget_grid_css_class : "col-md-6" ?>">
            
                <div class="card <?php echo $widget->widget_card_css_class ? $widget->widget_card_css_class : "card-default" ?>  ">
                
                    <?php if($widget->title && $widget->widget_show_title){ ?>
                        <div class="card-header">
                            <div class="card-title m-0"><i class="fa fa-caret-<?php echo OppAlign; ?> text-info"></i> <?php echo $widget->title; ?></div>
                        </div> 
                    <?php } ?>
                    
                    <div class="list-group list-group-flush widget_content">
                        <?php if(@$widget->items){ ?>
                            <?php foreach($widget->items as $item){  ?>                                                    
                                <?php $this->load->view(style.'/templates/sections/parts/classes/'.$item->item_class,array("fields"=>$item->fields)); ?>
                            <?php } ?>
                        <?php } ?>
                    </div>
                
                
                </div>
            
            </div>
        
        <?php } ?>

    </div>

</div>