<!DOCTYPE html>

<html>               
    <head>
        <meta http-equiv="Expires" content="Fri, Jan 01 1900 00:00:00 GMT">
        <meta http-equiv="Pragma" content="no-cache">
        <meta http-equiv="Cache-Control" content="no-cache">
        <base href="<?php echo base_url(); ?>" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta http-equiv="Lang" content="ar">
        <meta name="author" content="khashabawy">
        <meta name="description" content="<?php echo word("site_desc"); ?>">
        <meta name="keywords" content="<?php echo word("site_keywords"); ?>">
        <title><?php echo word("site_title"); ?> | لوحة التحكم | <?php echo $title; ?></title>
        <meta name="theme-color" content="#217A4B">
                    
        <script src="<?php echo base_url("assets/libs/jquery/jquery-3.3.1.min.js"); ?>"></script>
        <script src="<?php echo base_url("assets/libs/bootstrap/popper.min.js?v=".settings('refresh')); ?>"></script>                                        
        <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/fonts/fonts.css"); ?>">
        <link rel="stylesheet" href="<?php echo base_url("assets/libs/bootstrap/bootstrap-rtl.min.css"); ?>">                                 
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(APPFOLDER."views/".style."/assets/css/main.css?v=".settings("refresh")); ?>">        
        <link rel="stylesheet" type="text/css" href="<?php echo base_url("apps/common/assets/common.css?v=".settings("refresh")); ?>">        
        <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/libs/font_awesome/css/fontawesome-all.min.css?v=".settings('refresh')); ?>">     
        <script src="<?php echo base_url("assets/libs/bootstrap/bootstrap-rtl.min.js?v=".settings('refresh')); ?>"></script>                                        
        <script src="<?php echo base_url(APPFOLDER."views/".style."/assets/js/main.js?v=".settings("refresh")); ?>"></script>        
        <script src="<?php echo base_url("assets/libs/form-validator/validator.js?v=".settings("refresh")); ?>"></script>       
            
        <script src="<?php echo base_url("assets/libs/tinymce/tinymce.min.js?v=".settings("refresh")); ?>"></script>           
        <script src="<?php echo base_url("assets/libs/tinymce/config_admin.js?v=".settings("refresh")); ?>"></script>           

        <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1">

        <link rel="icon" href="/favicon.ico">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">            
            
        <!-- very important -->
        <script> 
            var base_url = "<?php echo base_url(); ?>"; 
            var admin_base = "<?php echo admin_base; ?>"; 
            var application_folder = "<?php echo APPFOLDER; ?>"; 
            var style_folder = "<?php echo style; ?>"; 
            var csrf_token = "<?php echo $this->security->get_csrf_hash();?>";
            var plz_fill_all = "<?php echo word("plz_fill_all"); ?>";                        
        </script>
        <!-- very important -->        
        
        
    </head>

<body>    

<?php if(!isset($hide_header)){ ?>                
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        
        <a class="navbar-brand" href="<?php echo base_url(admin_base); ?>"><i class="fas fa-shield-alt"></i></a>
        <a class="navbar-brand d-block d-sm-none" href="<?php echo base_url(); ?>"><i class="fas fa-home"></i></a>
        <a class="navbar-brand search_icon d-block d-sm-none" data-toggle="modal" data-target="#search_modal" href="#"><i class="fas fa-search"></i></a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
           
        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <?php if(logged_in == 1){ ?>        
                
                
                <ul class="navbar-nav ml-auto">     
                
                    <?php if( can("edit_site_settings") ){ ?>           
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                الإعدادات
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="<?php echo base_url(admin_base."settings"); ?>">الإعدادات العامة</a>
                                <a class="dropdown-item" href="<?php echo base_url(admin_base."settings/email"); ?>">إعدادات البريد</a>
                                <a class="dropdown-item" href="<?php echo base_url(admin_base."settings/security"); ?>">إعدادات الأمان</a>
                                <a class="dropdown-item" href="<?php echo base_url(admin_base."settings/urls"); ?>">إعدادات الروابط</a>
                                <a class="dropdown-item" href="<?php echo base_url(admin_base."language/"); ?>" >إعدادات اللغات</a>
                                <a class="dropdown-item" href="<?php echo base_url(admin_base."sitemap/"); ?>" >خريطة الموقع</a>
                            </div>
                        </li>    
                    <?php } ?>                               

                    
                    <?php if(can("edit_landing_content")){ ?>
                    <li class="nav-item">
                    
                    
                        <li class="nav-item dropdown ">
                            <a class="nav-link dropdown-toggle " href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                محتوى الرئيسية
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="<?php echo base_url(admin_base."landing_content");  ?>">محتوى الرئيسية</a>
                                <?php if( can("edit_sections") ){  ?>
                                    <a class="dropdown-item" href="<?php echo base_url(admin_base."sections"); ?>">المكتبات النوعية</a>
                                <?php } ?>    
                                <?php if( can("edit_sections") ){  ?>
                                    <a class="dropdown-item" href="<?php echo base_url(admin_base."partners"); ?>"> شركاء المعرفه</a>
                                <?php } ?>  
                            </div>
                        </li>                      
                    
                    </li>                                 
                    <?php } ?>  
                                      
                    <?php if(can("view_users")){ ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url(admin_base."users");  ?>">المستخدمين</a>
                    </li>                                 
                    <?php } ?>  
                                                                      
                    <?php if(can("view_orders")){ ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url(admin_base."orders");  ?>">الطلبات</a>
                    </li>                                 
                    <?php } ?>  
                                      
                    <?php if(can("view_logs_db")){ ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url(admin_base."logs_db");  ?>">السجلات</a>
                    </li>                                 
                    <?php } ?>  
                                      
                    <?php if(can("view_sources")){ ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url(admin_base."logs_db/sources");  ?>">المصادر</a>
                    </li>                                 
                    <?php } ?>  

                    <?php if(can("show_access")){ ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url(admin_base."access");  ?>">الدخول المجاني</a>
                    </li>       
                    <?php } ?>                     

                    <?php if(can("edit_faq")){ ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url(admin_base."faq");  ?>">الأسئلة الشائعة</a>
                    </li>                          
                    <?php } ?>                     
                    
                    <?php if(can("edit_pages")){ ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url(admin_base."pages");  ?>">الصفحات</a>
                    </li>                                                                  
                    <?php } ?>                        
                    
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url(admin_base."file_manager");  ?>">مدير الملفات</a>
                    </li>                                                                  
                    
                    
                </ul>             
            <?php } ?>            
                

            <ul class="navbar-nav mr-auto my-2 my-lg-0">

                <li class="nav-item">
                    <a class="nav-link d-none d-sm-block" href="<?php echo base_url(front_base) ?>"><i class="fas fa-home"></i> رئيسية الموقع</a>
                </li>              
            
                <?php if( logged_in ){ ?>                                                               
                
                    <li class="nav-item">
                        <a class="nav-link d-none d-sm-block" data-toggle="modal" data-target="#search_modal" href="#"><i class="fas fa-search"></i> بحث</a>
                    </li>              

                    <?php if( can("view_admins") || can("view_admin_logs") ){ ?>                                                               
                        <li class="nav-item dropdown ">
                            <a class="nav-link dropdown-toggle " href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                الإدارة
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <?php if( can("view_admins") ){ ?>                                                               
                                    <a class="dropdown-item" href="<?php echo base_url(admin_base."admins"); ?>">المديرين</a>
                                <?php } ?>
                                <?php if( can("view_admin_logs") ){ ?>                                                               
                                    <a class="dropdown-item" href="<?php echo base_url(admin_base."admins/view_logs"); ?>">السجلات</a>
                                <?php } ?>                                          
                            </div>                                                  
                        </li>   
                    <?php } ?>                                          
                    
                    
                    <li class="nav-item dropdown ">
                        <a class="nav-link dropdown-toggle " href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            العضوية
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <?php if( can("edit_own_profile") ){  ?>
                                <a class="dropdown-item" href="<?php echo base_url(admin_base."admins/profile"); ?>">تحديث البيانات</a>
                                <a class="dropdown-item" href="<?php echo base_url(admin_base."admins/change_password"); ?>">تغيير كلمة المرور</a>
                            <?php } ?>                                                             
                            <a class="dropdown-item" href="<?php echo base_url(admin_base."admins/logout"); ?>">تسجيل خروج</a>
                        </div>
                    </li>            
                    
                <?php } ?>                                          
                
            </ul>
            
        </div>
    </nav>
                 

<?php } ?>


<?php if(logged_in == 1){ ?>
    
    <?php if(settings("site_offline") == 1){ ?>                
        <div class="alert alert-danger text-center">
            <i class="fa fa-warning"></i> الموقع الآن فى وضع الصيانة ولا يمكن للزوار مشاهدة المحتوى أو التعامل معه [ <a class="text-info" href="<?php echo base_url(admin_base."settings"); ?>">إغلاق وضع الصيانة</a> ]
        </div>
    <?php } ?>
    

    <div class="container" id="main-container">

        <!-- Modal -->
        <div class="modal fade" id="search_modal" tabindex="-1" role="dialog" aria-labelledby="search_modalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">

                        <?php echo form_open(base_url(admin_base."search/index") , array("class" => "", "role" => "form")); ?>                

                                <input type="text" class="form-control "  name="keywords" id="keywords" placeholder="بحث عن" value="<?php echo @urldecode($keywords); ?>">
                                
                                <br />
                                                
                                <select name="for" id="for" class="form-control ">                         
                                    <option value="admin_logs">سجلات المديرين</option>                            
                                </select>                            
                            
                                <br />
                                
                                <button class="btn btn-success no-round" type="submit"><i class="fa fa-search"></i> بحث</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">اخفاء</button>
                        <?php echo form_close(); ?>        

                    </div>
                </div>
            </div>
        </div>

<?php } ?>
    
