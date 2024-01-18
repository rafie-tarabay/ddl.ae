<div class="row">

    <div class="col-md-4">    
        <div class="list-group">
            <a class="list-group-item" href="<?php echo base_url(admin_base."access/list_records/token"); ?>">عرض صلاحيات التذاكر Tokens</a>    
            <a class="list-group-item" href="<?php echo base_url(admin_base.ctrl()."/add_record/token"); ?>">إضافة صلاحية جديدة</a><br/>
            <a class="list-group-item" href="<?php echo base_url(admin_base.ctrl()."/tokens_generator"); ?>">إضافة صلاحيات متعددة</a><br/>
            <a class="list-group-item" href="<?php echo base_url(admin_base.ctrl()."/view_group_tokens"); ?>">عرض تذاكر مجموعة</a><br/>
        </div>
    </div>

    <div class="col-md-4">    
        <div class="list-group">
            <a class="list-group-item" href="<?php echo base_url(admin_base."access/list_records/ip"); ?>">عرض صلاحيات الأي بي IP</a>    
            <a class="list-group-item" href="<?php echo base_url(admin_base.ctrl()."/add_record/ip"); ?>">إضافة صلاحية جديدة</a>
        </div>
    </div>


    <div class="col-md-4">    
        <div class="list-group">
            <a class="list-group-item" href="<?php echo base_url(admin_base."access/list_records/country"); ?>">عرض صلاحيات الدول countries</a>    
            <a class="list-group-item" href="<?php echo base_url(admin_base.ctrl()."/add_record/country"); ?>">إضافة صلاحية جديدة</a>
        </div>
    </div>

</div>