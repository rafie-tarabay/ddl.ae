<div class="card card-default">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-8 no-padding">                
                <h5 class="card-title  mb-0"><?php echo $title; ?></h5>
            </div>
            <div class="col-sm-4  no-padding text-left">
                <a class="btn btn-success" href="<?php echo base_url(admin_base."packages/edit_package/".$package->pack_id) ?>">تعديل</a>
                <a class="btn btn-info" href="<?php echo base_url(admin_base.ctrl()); ?>">الرجوع</a>                
            </div>            
        </div>
    </div> 


    <table class="table table-bordered table-striped m-0">                
                                    
        <tr>                        
            <td class="text-center" style="width: 100px;">رقم الحزمة</td>                
            <td class="text-center" style="width: 100px;">الترتيب</td>                
            <td>اسم الحزمة</td>                        
            <td class="text-center" style="width: 100px;">عدد</td>                
            <td class="text-center" style="width: 100px;">سعر شهري</td>                
            <td class="text-center" style="width: 100px;">سعر سنوي</td>                            
        </tr>   

        <tr>                        
            <td class="text-center"><?php echo $package->pack_id; ?></td>                
            <td class="text-center"><?php echo $package->pack_order; ?></td>                
            <td><?php echo $package->title; ?></td>                           
            <td class="text-center"><?php echo $package->pack_count; ?></td>                
            <td class="text-center"><?php echo $package->pack_price_monthly; ?> دولار</td>                
            <td class="text-center"><?php echo $package->pack_price_yearly; ?> دولار</td>               
        </tr>  

 
    </table>
        
</div>






<div class="card card-default mt-4">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-8 no-padding">                
                <h5 class="card-title mb-0">محتويات الحزمة</h5>
            </div>
            <div class="col-sm-4  no-padding text-left">
                <a class="btn btn-success" href="<?php echo base_url(admin_base."packages/add_book/".$package->pack_id) ?>">إضافة كتاب</a>                
            </div>            
        </div>
    </div> 


    <table class="table table-bordered table-striped m-0">                
                                    
        <tr>                        
            <td class="text-center" style="width:100px;">رقم الكتاب</td>                            
            <td class="text-center" style="width:100px;">الترتيب</td>                         
            <td>اسم الكتاب</td>                                       
            <td class="text-center" style="width:100px;">تعديل</td>                         
            <td class="text-center" style="width:100px;">حذف</td>                         
        </tr>   
            
        <?php foreach($books as $book){ ?>                        

            <tr>                        
                <td class="text-center"><?php echo $book->book_id; ?></td>                
                <td class="text-center"><?php echo $book->book_order; ?></td>                
                <td><a href="<?php echo base_url("book/".$book->book_id) ?>" target="_blank"><?php echo $book->book_title; ?></a></td>                                        
                
                <td class="text-center">                
                    <a class="btn btn-success" href="<?php echo base_url(admin_base."packages/edit_book/".$package->pack_id."/".$book->book_id) ?>">تعديل</a>                              
                </td>   
                               
                <td class="text-center">                
                    <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            حذف
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item sure" href="<?php echo base_url(admin_base."packages/delete_book/".$book->book_id."/".$package->pack_id) ?>">حذف من هذه الحزمة فقط</a>
                            <a class="dropdown-item sure" href="<?php echo base_url(admin_base."packages/delete_book/".$book->book_id) ?>">حذف من كل الحزم</a>
                        </div>
                    </div>                                
                </td>   
                
            </tr>  

        <?php } ?>

    </table>
        
</div>

