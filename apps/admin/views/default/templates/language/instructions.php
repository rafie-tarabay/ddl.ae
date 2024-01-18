<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-4 no-padding">                
                <h3 class="card-title"><?php echo $title; ?></h3>
            </div>
            
            <div class="col-md-8 no-padding text-left">                
                <a class="btn btn-primary btn-sm" href="<?php echo base_url(admin_base."".$this->uri->segment(1)."/add_lang") ?>" ><i class="fa fa-plus"></i> أضف لغة</a>                
                <a class="btn btn-primary btn-sm" href="<?php echo base_url(admin_base."".$this->uri->segment(1)."/words") ?>" ><i class="fa fa-sort-alpha-asc"></i> العبارات</a>                                                
                <a class="btn btn-primary btn-sm" href="<?php echo base_url(admin_base."".$this->uri->segment(1)) ?>" ><i class="fa fa-language"></i> اللغات</a>                                
            </div>                        
          
        </div>
    </div>    

    <div class="card-body">
    

        <h3 style="margin-bottom: 20px;"><i class="fa fa-question-circle"></i> ما الذى يجب عمله بعد إضافة لغة جديدة ؟</h3>
        <ul>        
            <li>ترجمة العبارات إلى اللغة الجديدة أو تحميل ملف أحد اللغات وترجمته ثم إعادة رفعه <a target="_blank" href="<?php echo base_url(admin_base."language/words"); ?>">ترجمة العبارات من هنا</a></li>
            <li>يجب إضافة اسم الموقع ووصف الموقع باللغة الجديدة <a target="_blank" href="<?php echo base_url(admin_base."settings"); ?>">من هنا</a></li>
            <li>يجب إضافة بيانات الإتصال بنا باللغة الجديدة <a target="_blank" href="<?php echo base_url(admin_base."contact_us/edit_info"); ?>">من هنا</a></li>
            <li>يجب إضافة أسماء الدول باللغات الجديدة عن طريق تعديل كل دولة <a target="_blank" href="<?php echo base_url(admin_base."countries"); ?>">من هنا</a></li>
            <li>إضافة المحتوى القديم مثل الأخبار والمنتجات و غيرها باللغة الجديدة</li>            
        </ul>                
        

        <h3 style="margin-bottom: 20px;"><i class="fa fa-question-circle"></i> ما الذى يجب عمله بعد حذف لغة ؟</h3>
        <ul>        
            <li>حذف بيانات الإتصال بنا الخاصة باللغة المحذوفة <a target="_blank" href="<?php echo base_url(admin_base."contact_us/edit_info"); ?>">من هنا</a></li>
            <li>حذف المحتوى القديم مثل الأخبار والمنتجات و غيرها باللغة المحذوفة</li>            
        </ul>                
                
    
        <hr />
    
        <h3 style="margin-bottom: 20px;"><i class="fa fa-sort-alpha-asc"></i> العبارات</h3>
        <ul class="no-list">
        
            <li>
                <h4><i class="fa fa-plus"></i> إضافة عبارة</h4>
                <ul>
                    <li>مميز العبارة : يجب أن يتبع الإرشادات الموضحة أسفل منه بحيث لا يحتوى على مسافات ويتكون من حروف إنجليزية فقط</li>
                    <li>الترجمة : يتم كتابة العبارة بكافة اللغات المتاحة فى الموقع</li>
                </ul>
            </li>                
                
            <li>
                <h4><i class="fa fa-pencil"></i> استعراض وتعديل العبارات</h4>
                <ul>
                    <li>تتيح خاصية العبارات تصفح العبارات بكل لغات الموقع مع إمكانية التعديل بسهولة</li>
                    <li>يتم التعديل بتقنية ال AJAX بحيث تتم العملية بسرعة ودون إعادة تحميل الصفحة</li>
                    <li>يجب الحذر عند حذف أى عبارة والتأكد من عدم عملها أو استخدامها فى الموقع</li>
                </ul>     
            </li>

        </ul> 
    

        <h3 style="margin-bottom: 20px;"><i class="fa fa-language"></i> اللغات</h3>
        <ul class="no-list">
            
            <li>
                <h4><i class="fa fa-plus"></i> إضافة اللغة</h4>
                <ul>
                    <li>الإسم المختصر للغة : يجب أن يتكون من حرفين أو 3 أحرف على الأكثر و لا يكون مكرراً أو مستخدماً من قبل</li>
                    <li>إسم اللغة : إسم اللغة الذى سيظهر فى الصفحة الرئيسية للموقع فى قائمة إختيار اللغات</li>
                    <li>إتجاه اللغة : إتجاه كتابة اللغة والذى سيترتب عليه إتجاه ظهور الستايل الخاص بالموقع</li>
                    <li>علم اللغة : العلم الخاص بالدولة المعبرة عن اللغة و يجب أن يكون أبعاده 24 عرض فى 19 إرتفاع</li>
                </ul>
            </li>
            
            <li>
                <h4><i class="fa fa-download"></i> تحميل اللغة</h4>
                <ul>
                    <li>يمكن تحميل ملف Backup من اللغة المراد تحميلها عبر الضغط على علامة التحميل المقابله لها</li>
                    <li>الملف المحمل يكون على صيغة JSON الشهيره</li>
                    <li>يمكن استخدام الملف المحمل لترجمة الموقع إلى لغات أخرى </li>
                    <li>يمكن إستعراض الملف المحمل و تعديله عبر خدمات أونلين مثل <a target="_blank" href="https://www.jsoneditoronline.org/">jsoneditoronline.org</a></li>
                </ul>    
            </li>
            
            <li>
                <h4><i class="fa fa-upload"></i> رفع اللغة</h4>
                <ul>
                    <li>يمكنك بعد عملية ترجمة ملف اللغة بصيغة JSON أن تقوم برفعه ليتم تحديث اللغة</li>
                    <li>يتم تحديث قاعدة البيانات وكذلك ملفات اللغة الموجودة فى مجلد /langs</li>
                </ul>  
            </li>
            
        </ul>     

    </div>
    
</div>