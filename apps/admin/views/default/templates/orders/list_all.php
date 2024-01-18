<script src="<?php echo no_protocol(base_url("assets/libs/jquery/jquery-ui-1.12.1.custom/jquery-ui.min.js")); ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo no_protocol(base_url("assets/libs/jquery/jquery-ui-1.12.1.custom/jquery-ui.min.css")); ?>">
<div class="card card-default">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-8 no-padding">
                <h5 class="card-title"><?php echo $title; ?></h5>
            </div>
            <div class="col-sm-4  no-padding text-left">
                <a class="btn btn-info" href="<?php echo base_url(admin_base . ctrl()); ?>">الرجوع</a>
            </div>
        </div>
    </div>

    <div class="card-body">
        <b>اجمالي الطلبات:</b> <code><?php echo $count; ?></code>
    </div>

    <?php
    if(!isset($start_date) || empty($start_date))
    {
        $start_date = strtotime(date("Y-m-d"));
    }
    if(!isset($end_date) || empty($end_date))
    {
        $end_date = strtotime(date("Y-m-d"));
    }
    ?>

    <div class="row m-4">

        <?php echo form_open_multipart(base_url(admin_base . ctrl() . "/filter" ), array("class" => "", "role" => "form")); ?>

        <div class="card-body">
            <div class="row"> 
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label>يبدأ من</label>
                        <input type="text" class="form-control ltr text-left datepicker" maxlength="10" name="start_date" id="start_date" placeholder="MM/DD/YYYY">
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label>ينتهي في</label>
                        <input type="text" class="form-control ltr text-left datepicker" maxlength="10" name="end_date" id="end_date" placeholder="MM/DD/YYYY">
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label>حالة الطلب</label>
                        <select class="form-control req_field" name="order_status">
                             <option <?php if(isset($order_status)&& $order_status == "all" ){ echo 'selected = "selected"'; } ?> value="all">الكل</option> 
                            <option <?php if(isset($order_status)&& $order_status == "paid" ){ echo 'selected = "selected"'; } ?> value="paid">مدفوغ</option>
                            <option <?php if(isset($order_status)&& $order_status == "canceled" ){ echo 'selected = "selected"'; } ?> value="canceled">ملغي</option>
                            <option <?php if(isset($order_status)&& $order_status == "unpaid" ){ echo 'selected = "selected"'; } ?> value="unpaid">غير مدفوع</option>

                        </select>
                    </div>
                </div>

            </div> 
        </div>


        <div class="card-footer" style="text-align: left;">
            <input class="btn btn-success" type="submit" value="تصفية" />
        </div> 
        <?php echo form_close(); ?>
    </div>


</div>


<div class="card card-default mt-4">
    <table class="table table-bordered table-hover table-sm m-0">
        <tr>
            <th>أسم المستخدم</th>
            <th>حالة الطلب</th>
            <th style="width: 150px;">
                رقم الطلب
            </th>
            <th>التاريخ</th>
            <th>المواد</th>
        </tr>
        <?php foreach ($records as $record) { ?>

            <tr>
                <td>
                    <p class="mb-0"><a href="<?php echo base_url(admin_base . "users/show_user/" . $record->user->u_id) ?>"><?php echo @$record->user->u_fullname; ?></a></p>
                </td>
                <td>
                    <div class="col no-padding text-right">
                        <?php if ($record->order_status == "paid") { ?>
                            <span class="text-success"><i class="fa fa-check"></i> تم الدفع</span>
                        <?php } elseif ($record->order_status == "unpaid") { ?>
                            <span class="text-info"><i class="fas fa-clock"></i> بإنتظار الدفع</span>
                        <?php } elseif ($record->order_status == "canceled") { ?>
                            <span class="text-danger"><i class="fa fa-times"></i> ملغي</span>
                        <?php } ?>
                    </div>
                </td>
                <td><?php echo $record->order_id; ?></td>
                <td><?php echo date("Y-m-d h:i A", $record->order_timestamp); ?></td>
                <td>
                    <?php foreach ($record->items as $item) { ?>
                        <?php $data = json_decode($item->item_data); ?>
                        <div><a target="_blank" href="<?php echo base_url(front_base . "book/" . $item->item_id) ?>"><?php echo $data->title ?></a></div>
                    <?php } ?>
                </td>
            </tr>


        <?php } ?>
    </table>
</div>


<div class="text-center mt-4">
    <?php echo $pagination; ?>
</div>

<script>
        $( function() {
        $( ".datepicker" ).datepicker({
            showButtonPanel: true,
            changeMonth: true,
            changeYear: true, 
            yearRange: "<?php echo date("Y",strtotime("-5 years")) ?>:<?php echo date("Y" , strtotime("+5 years")) ?>",
            dateFormat: "yy-mm-dd"
        }); 
        $( "#start_date").datepicker("setDate", "<?php echo @date("Y-m-d",$start_date) ?>" ); 
        $( "#end_date").datepicker("setDate", "<?php echo @date("Y-m-d",$end_date) ?>"   );
    } );

</script>