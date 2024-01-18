<div class="card card-default">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-8 no-padding">                
                <h5 class="card-title m-0"><?php echo $title; ?></h5>
            </div>
            <div class="col-sm-4  no-padding text-left">
                <a class="btn btn-success btn-sm" href="<?php echo base_url(admin_base.ctrl()."/add_widget/".$section->sec_id); ?>">إضافة محتوى</a>                                
                <a class="btn btn-info btn-sm" href="<?php echo base_url(admin_base.ctrl()); ?>">الرجوع</a>                                
            </div>            
        </div>
    </div> 

</div>


<br>
<div class="row"> 

    <?php foreach($widgets as $widget){ ?>
    
        <div class="col-md-4 mb-3">
        
            <div class="card card-default">

                <div class="card-header p-2">
                    <div class="row no-gutters">
                        <div class="col-sm-7 no-padding">                
                            <div class="line-height-35"><?php echo $widget->widget_order; ?> <?php echo $widget->title; ?></div>
                        </div>
                        <div class="col-sm-5 no-padding text-left">                                    
                                                                
                            <div class="btn-group">
                                <button type="button" class="btn btn-success btn-sm btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-plus"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <?php foreach($classes as $class){ ?>
                                        <a class="dropdown-item" href="<?php echo base_url(admin_base.ctrl()."/add_item/".$class->class_name."/".$widget->widget_id); ?>"><?php echo $class->class_name; ?></a>                                
                                    <?php } ?>
                                </div>
                            </div>                                                                
                            
                            <a class="btn btn-info btn-sm  btn-xs" href="<?php echo base_url(admin_base.ctrl()."/edit_widget/".$widget->widget_id); ?>"><i class="fa fa-edit"></i></a>                                
                            
                            <a class="btn btn-danger btn-sm  btn-xs" href="<?php echo base_url(admin_base.ctrl()."/delete_widget/".$widget->widget_id); ?>"><i class="fa fa-trash"></i></a>                                
                            
                        </div>            
                    </div>
                </div> 

                <div class="list-group list-group-flush">
                    <?php if(@$widget->items){ ?>
                        <?php foreach($widget->items as $item){  ?>                        
                            <div class="list-group-item">
                                <div class="float-left">
                                    <code><?php echo $item->item_order; ?></code>
                                    <a href="<?php echo base_url(admin_base.ctrl()."/edit_item/".$item->item_id); ?>"><i class="fa fa-edit"></i></a>                                
                                    <a href="<?php echo base_url(admin_base.ctrl()."/delete_item/".$item->item_id); ?>"><i class="fa fa-trash"></i></a>                                                                                                                                                
                                </div>
                                <div>   
                                    <?php $this->load->view(style.'/templates/sections/parts/classes/'.$item->item_class,array("fields"=>$item->fields)); ?>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            
            
            </div>
        
        </div>
    
    <?php } ?>

</div>