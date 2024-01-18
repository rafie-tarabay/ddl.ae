<script src="<?php echo base_url(APPFOLDER."views/".style."/assets/js/packages.js?v=".settings('refresh')); ?>"></script>                                

<div class="card card-default mt-4">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-6">
                <h5 class="mt-1 mb-0"><i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo word("packages") ?></h5>
            </div>
            <div class="col-sm-6 text-<?php echo OppAlign; ?>">
                <a class="btn btn-sm btn-info" href="<?php echo base_url("orders") ?>"><i class="fa fa-shopping-bag"></i> <?php echo word("orders") ?></a>
                <a class="btn btn-sm btn-info" href="<?php echo base_url("payments") ?>"><i class="fa fa-receipt"></i> <?php echo word("payments") ?></a>
                <a class="btn btn-sm btn-info" href="<?php echo base_url("orders/purchases") ?>"><i class="fa fa-cubes"></i> <?php echo word("purchases") ?></a>
            </div>
        </div>        
        
    </div>            
</div> 



<?php echo form_open( base_url("packages/create_order/") , array("role" => "form",  "class"=>"inline check_submit", "release"=>"true", "id"=>"packages") ); ?>
                            
    <div class="row mt-4">

        <div class="col-12 col-sm-8">
            
            <div class="card card-default">
                
                <div class="card-header">

                    <div class="row">                
                        <div class="col-md-8">
                            <?php echo word("package") ?>
                        </div>

                        <div class="col-md-2 text-center">
                            <?php echo word("books") ?>
                        </div>              
                          
                        <div class="col-md-2 text-center">
                            <?php echo word("price") ?>
                        </div>                                    
                    </div>                        
                
                </div> 
                
                <div class="list-group list-group-flush packages-list ">
                
                    <?php foreach($packages as $package){ ?>
                        
                        <?php $active_sub = in_array($package->pack_id,$active_packs_ids) ? TRUE : FALSE; ?>

                        <div class="list-group-item single-package <?php if($active_sub) echo "disabled"; ?>" id="package_<?php echo $package->pack_id; ?>">
                            <div class="row">
                            
                                <div class="col-md-8">
                                    <div class="form-check">
                                        
                                        <?php if($active_sub){ ?>                                        
                                            <input class="form-check-input pointer" type="checkbox"  disabled="disabled" />
                                        <?php }else{ ?>
                                            <input class="form-check-input pointer packs" type="checkbox" name="packs[]" value="<?php echo $package->pack_id ?>" id="pack_select_<?php echo $package->pack_id ?>" data-price-monthly="<?php echo $package->pack_price_monthly ?>" data-price-yearly="<?php echo $package->pack_price_yearly ?>" <?php if($active_sub) echo 'disabled="disabled"'; ?>  />
                                        <?php } ?>
                                        
                                        <label class="form-check-label pointer" for="pack_select_<?php echo $package->pack_id ?>">
                                            <div class="package_title">
                                                <?php echo $package->title; ?>
                                                <a target="_blank" href="<?php echo base_url("packages/view_package/".$package->pack_id); ?>"><i class="fa fa-link"></i></a>
                                            </div>

                                            <div class="small mt-1 line-height-24">
                                                <?php if($active_sub){ ?>
                                                        <i class="fa fa-check text-success"></i> <?php echo word("you_already_subscribed") ?>
                                                <?php }else{?>
                                                        <?php echo $package->desc; ?>
                                                <?php } ?>
                                            </div>
                                        </label>
                                    </div>                    
                                </div>

                                <div class="col-md-2 text-center">
                                    <?php echo $package->pack_count ?>
                                </div>              
                                  
                                <div class="col-md-2 text-center">
                                    <span>$</span><span class="package_price monthly d-none"><?php echo $package->pack_price_monthly ?></span><span class="package_price yearly"><?php echo $package->pack_price_yearly ?></span>                       
                                </div>                                    
                            </div>
                            
                        </div>

                    <?php } ?>
                
                </div>
                
            </div>
                        
        </div>    

        <div class="col-12 col-sm-4">
        
            <div class="card card-default">

                <div class="card-header">
                    <i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo word("order_summary") ?>
                </div>

                <div class="card-body"> 

                    <div class="form-group">
                        
                        <label><i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo word("subscribe_plan"); ?></label>                                
                        
                        <div class="row">
                            <div class="col-6">
                                <div class="form-check subscribe_plan selected" id="subscribe_plan_yearly">
                                    <input class="form-check-input pointer" type="radio" name="subscribe_plan" id="subscribe_yearly" value="yearly" checked>
                                    <label class="form-check-label d-block pointer" for="subscribe_yearly">
                                        <?php echo word("yearly") ?>
                                    </label>
                                </div>                            
                            </div>
                            <div class="col-6">
                                <div class="form-check subscribe_plan" id="subscribe_plan_monthly">
                                    <input class="form-check-input pointer" type="radio" name="subscribe_plan" id="subscribe_monthly" value="monthly">
                                    <label class="form-check-label d-block pointer" for="subscribe_monthly">
                                        <?php echo word("monthly") ?>
                                    </label>
                                </div>                            
                            </div>                        
                        </div>
                        
                    </div>
                

                           
                
                    <div class="form-group">
                        
                        <label><i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo word("total_price"); ?></label>                                
                        
                        <div class="mb-3">
                            <span>$</span><span id="total_price">0</span>
                        </div>                                        
                        
                    </div>                           
                                    
                    <div class="mt-3">                
                        <button type="submit" class="btn btn-success btn-block" id="create_order" disabled="disabled"><i class="fa fa-check"></i> <?php echo word("create_order") ?></button>                                            
                    </div>

                </div>

            </div>        


        </div>  

    </div>

<?php echo form_close(); ?>

<br />