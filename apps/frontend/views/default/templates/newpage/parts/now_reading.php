
<style>
    #myUL {
        list-style-type:square;
    }

    .caret {
        cursor: pointer;
        -webkit-user-select: none; /* Safari 3.1+ */
        -moz-user-select: none; /* Firefox 2+ */
        -ms-user-select: none; /* IE 10+ */
        user-select: none;
        font-family: 'Droid Arabic Kufi',tahoma,'Noto Sans' !important;
        font-size: 14px;
        margin-top: 10px;margin-right:5px;
        display: inline-block;
    }

.caret::before {
  color: black;
  display: inline-block;
  margin-right: 6px;
}


.nested {
        display: none;
        margin: 2;
        padding: 2;
        list-style-type:disc
    }

.active {
  display: block;
}
</style>




<div class="card bg-light" id="BrowseDewey">
    <div class="card-header bg-gray-dark head nice-font">
        <div class="row no-gutters">
            <?php if (OppAlign ==  "left"): ?>
                    <i class="fa fa-caret-<?php echo OppAlign; ?>"></i> &nbsp; <?php echo "تصفح المحتوي الرقمي حسب التصنيف" ?>
            <?php else: ?>
                    <i class="fa fa-caret-<?php echo OppAlign; ?>"></i> &nbsp; <?php echo "Browse by Classification" ?>
            <?php endif ?>
        </div>
    </div>

    <div class="list-group list-group-flush" id="BrowseDewey_container">

        <?php if (OppAlign ==  "left"): ?>

        <ul id="myUL">
            <li>
                <span class="caret">علم الحاسوب، المعلومات، والأعمال العامة</span>
                <ul class="nested">
                    <li>
                        <a href="/search/results/1?dewies=000;010">
                            <span class="caret">الببليوجرافيا </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=000;020">
                            <span class="caret">علوم المكتبات و المعلومات </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=000;030">
                            <span class="caret">الأعمال الموسوعية العامة </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=000;050">
                            <span class="caret">المطبوعات والمسلسلات</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=000;060">
                            <span class="caret">المنظمات والهيئات والمتاحف العامة </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=000;070">
                            <span class="caret">الصحافة و النشر  </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=000;080">
                            <span class="caret">المجموعات العامة </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=090;000">
                            <span class="caret">المخطوطات والكتب النادرة </span>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <span class="caret">الفلسفة والعلوم المتصلة </span>
                <ul class="nested">
                    <li>
                        <a href="/search/results/1?dewies=110;100">
                            <span class="caret">ما وراء الطبيعة </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=120;100">
                            <span class="caret">نظرية المعرفة و الجنس البشري </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=130;100">
                            <span class="caret">الظواهر الخوارقة</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=140;100">
                            <span class="caret">المباحث الفلسفية </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=150">
                            <span class="caret">علم النفس </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=160;100">
                            <span class="caret">المنطق </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=170;100">
                            <span class="caret">الأخلاق والفلسفة الأخلاقية </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=180;100">
                            <span class="caret">الفلسفة ,القديمة ,الوسطى ,الإسلامية </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=190;100">
                            <span class="caret">فلسفة العصر الحديث </span>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <span class="caret">العلوم الاجتماعية </span>
                <ul class="nested">
                    <li>
                        <a href="/search/results/1?dewies=310;300">
                            <span class="caret">الأحصاء </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=320;300">
                            <span class="caret">العلوم السياسية </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=330;300">
                            <span class="caret">الاقتصاد</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=340;300">
                            <span class="caret">القانون </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=350;300">
                            <span class="caret">الإدارة العامة </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=360;300">
                            <span class="caret">الخدمة و العمل الأجتماعي</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=370;300">
                            <span class="caret">التربية والتعليم </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=380;300">
                            <span class="caret">التجارة ، الاتصالات ، النقل</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=390;300">
                            <span class="caret">العادات والتقاليد والفنون الشعبية </span>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <span class="caret">اللغات </span>
                <ul class="nested">
                    <li>
                        <a href="/search/results/1?dewies=410;400">
                            <span class="caret">اللغة العربية </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=420;400">
                            <span class="caret">اللغة الإنجليزية والإنجلوسكسونية </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=430;400">
                            <span class="caret">اللغة الألمانية</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=440;400">
                            <span class="caret">اللغة الفرنسية </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=450;400">
                            <span class="caret">اللغة الإيطالية الرومانية،الريتورومانية </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=460;400">
                            <span class="caret">اللغة الأسبانية و البرتغالية </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=470;400">
                            <span class="caret">اللغة اللاتينية </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=480;400">
                            <span class="caret">اللغة الهيلنية - اللغات اليونانية الكلاسيكية </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=490;400">
                            <span class="caret">اللغات الأخري </span>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <span class="caret">العلوم الطبيعية و الرياضيات </span>
                <ul class="nested">
                    <li>
                        <a href="/search/results/1?dewies=510;500">
                            <span class="caret">الرياضيات </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=520;500">
                            <span class="caret">الفلك </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=530;500">
                            <span class="caret">الفيزيا</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=540;500">
                            <span class="caret">الكيمياء </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=550;500">
                            <span class="caret">علوم الأرض </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=560;500">
                            <span class="caret">علم الحفريات</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=570;500">
                            <span class="caret">علوم الحياة </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=580;500">
                            <span class="caret">العلوم النباتية</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=590;500">
                            <span class="caret">العلوم الحيوانية </span>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <span class="caret">العلوم التطبيقية </span>
                <ul class="nested">
                    <li>
                        <a href="/search/results/1?dewies=610;600">
                            <span class="caret">العلوم الطبية </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=620;600">
                            <span class="caret">الهندسة </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=630;600">
                            <span class="caret">الزراعة والتقنيات</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=640;600">
                            <span class="caret">الأقتصاد المنزلي والحياة العائلية </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=650;600">
                            <span class="caret">الإدارة وإدارة الأعمال </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=660;600">
                            <span class="caret">الكيمياء التكنولوجية وما يتصل بها </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=670;600">
                            <span class="caret">الصناعات </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=680;600">
                            <span class="caret">الصناعات اليدوية</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=690;600">
                            <span class="caret">المباني </span>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <span class="caret">الفنون </span>
                <ul class="nested">
                    <li>
                        <a href="/search/results/1?dewies=710;700">
                            <span class="caret">تخطيط المدن وفنون المناظر الطبيعية </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=720;700">
                            <span class="caret">فنون العمارة </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=730;700">
                            <span class="caret">الفنون البلاستيكية والنحت</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=740;700">
                            <span class="caret">الرسم والفنون الزخرفية </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=750;700">
                            <span class="caret">الرسم الزيتي واللوحات الزيتية </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=760;700">
                            <span class="caret">المصورات الفنية الطباعة </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=770;700">
                            <span class="caret">التصوير والصور الفوتوغرافية </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=780;700">
                            <span class="caret">الموسيقى</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=790;700">
                            <span class="caret">الفنون الترويحية </span>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <span class="caret">الآداب </span>
                <ul class="nested">
                    <li>
                        <a href="/search/results/1?dewies=810;800">
                            <span class="caret">الأدب العربي </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=820;800">
                            <span class="caret">الأدب الإنجليزي والإنجلوسكونية </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=830;800">
                            <span class="caret">الأدب الألماني</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=840;800">
                            <span class="caret">الأدب الفرنسي</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=850;800">
                            <span class="caret">الأدب الإيطالي والروماني </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=860;800">
                            <span class="caret">الأدب الأسباني </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=870;800">
                            <span class="caret">الأدب اللاتيني </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=880;800">
                            <span class="caret">الأدب اليوناني</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=890;800">
                            <span class="caret">الأداب الأخرى </span>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <span class="caret">التاريخ والجغرافيا العامة </span>
                <ul class="nested">
                    <li>
                        <a href="/search/results/1?dewies=910;900">
                            <span class="caret">الجغرافيا </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=920;900">
                            <span class="caret">التراجم العامة والأنساب </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=930;900">
                            <span class="caret">التاريخ العام للعالم القديم </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=940;900">
                            <span class="caret">التاريخ العام لأوروبا </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=950;900">
                            <span class="caret">التاريخ العام لآسيا </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=960;900">
                            <span class="caret">التاريخ العام لأفريقيا </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=970;900">
                            <span class="caret">التاريخ العام لأمريكا الشمالية </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=980;900">
                            <span class="caret">التاريخ العام لأمريكا الجنوبية</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=990;900">
                            <span class="caret">تاريخ باقي العالم </span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    
        <?php else: ?>
    
        <ul id="myUL">
            <li>
                <span class="caret">Computer Science, Information, And Public Works</span>
                <ul class="nested">
                    <li>
                        <a href="/search/results/1?dewies=000;10">
                            <span class="caret">Bibliographies</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=000;20">
                            <span class="caret">Library & Information Sciences </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=000;30">
                            <span class="caret">General Encyclopedic Works </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=000;50">
                            <span class="caret"> Publications & Serials</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=000;60">
                            <span class="caret">General Organizations & Museologies</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=000;70">
                            <span class="caret">Journalism & Publishing </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=000;80">
                            <span class="caret">General Collections</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=000;90">
                            <span class="caret"> Manuscripts & Rare Books </span>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <span class="caret">Philosophy & Related Sciences</span>
                <ul class="nested">
                    <li>
                        <a href="/search/results/1?dewies=100;110">
                            <span class="caret">Metaphysics</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=100;120">
                            <span class="caret">Anthropology</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=100;130">
                            <span class="caret"> Paranormal Phenomena</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=100;140">
                            <span class="caret">Philosophy Studies</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=100;150">
                            <span class="caret">Psychology</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=100;160">
                            <span class="caret">Logic </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=100;170">
                            <span class="caret">Ethics & Moral Philosophy</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=100;180">
                            <span class="caret">Ancient, Islamic, Moderate, Philosophy</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=100;190">
                            <span class="caret">Modern Western Philosophy</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <span class="caret">Social Sciences</span>
                <ul class="nested">
                    <li>
                        <a href="/search/results/1?dewies=300;310">
                            <span class="caret">Statistics</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=300;320">
                            <span class="caret">Political Science</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=300;330">
                            <span class="caret"> Economics</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=300;340">
                            <span class="caret">Law</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=300;350">
                            <span class="caret">Public Administration</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=300;360">
                            <span class="caret">Social Services & Affairs</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=300;370">
                            <span class="caret">Education</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=300;380">
                            <span class="caret">Commerce, Communications, Transport</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=300;390">
                            <span class="caret">Customs, Traditions & Folklore</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <span class="caret">Languages</span>
                <ul class="nested">
                    <li>
                        <a href="/search/results/1?dewies=400;410">
                            <span class="caret">Arabic Languages </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=400;420">
                            <span class="caret">English Languages & Anglo-Saxon</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=400;430">
                            <span class="caret">Germanic Language</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=400;440">
                            <span class="caret">French Language</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=400;450">
                            <span class="caret">Italian, Romanian, Rhaeto–Romanic Languages</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=400;460">
                            <span class="caret">Spanish & Portuguese Language</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=400;470">
                            <span class="caret">Latin Language</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=400;480">
                            <span class="caret">Hellen Language - Classic Latin Language </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=400;490">
                            <span class="caret">Other Languages</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <span class="caret">Natural Science & Mathematics</span>
                <ul class="nested">
                    <li>
                        <a href="/search/results/1?dewies=500;510">
                            <span class="caret">Mathematics</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=500;520">
                            <span class="caret">Astronomy</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=500;530">
                            <span class="caret">Physics</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=500;540">
                            <span class="caret">Chemistry</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=500;550">
                            <span class="caret">Earth Sciences </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=500;560">
                            <span class="caret">Paleontology</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=500;570">
                            <span class="caret">Life Sciences</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=500;580">
                            <span class="caret">Botanical Sciences</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=500;590">
                            <span class="caret">Zoology Science </span>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <span class="caret">Applied Sciences</span>
                <ul class="nested">
                    <li>
                        <a href="/search/results/1?dewies=600;610">
                            <span class="caret">Medicine</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=600;620">
                            <span class="caret">Engineering</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=600;630">
                            <span class="caret">Agriculture</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=600;640">
                            <span class="caret">Home Economics & Family Affairs</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=600;650">
                            <span class="caret">Management & Business</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=600;660">
                            <span class="caret">Chemical Engineering </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=600;670">
                            <span class="caret">Manufacturing</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=600;680">
                            <span class="caret">Handicrafts</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=600;690">
                            <span class="caret">Buildings </span>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <span class="caret">Arts</span>
                <ul class="nested">
                    <li>
                        <a href="/search/results/1?dewies=700;710">
                            <span class="caret">City Planning & Landscape Arts</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=700;720">
                            <span class="caret">Architecture </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=700;730">
                            <span class="caret">Plastic Arts, Sculpture</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=700;740">
                            <span class="caret">Drawing & Decorative Arts</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=700;750">
                            <span class="caret">Painting</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=700;760">
                            <span class="caret">Graphic Arts, Printmaking & Prints</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=700;770">
                            <span class="caret">Photography & Photographs</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=700;780">
                            <span class="caret">Music</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=700;790">
                            <span class="caret">Performing Arts </span>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <span class="caret">Literature</span>
                <ul class="nested">
                    <li>
                        <a href="/search/results/1?dewies=800;810">
                            <span class="caret">Arabic Literature</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=800;820">
                            <span class="caret">English & Anglo-Saxon Literature</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=800;830">
                            <span class="caret">German Literature</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=800;840">
                            <span class="caret">French Literature</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=800;850">
                            <span class="caret">Italian & Roman Literature </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=800;860">
                            <span class="caret">Spanish Literature</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=800;870">
                            <span class="caret">Latin Literature</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=800;880">
                            <span class="caret">Greek Literature</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=800;890">
                            <span class="caret">Other World Literature</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <span class="caret">History & General Geography </span>
                <ul class="nested">
                    <li>
                        <a href="/search/results/1?dewies=900;910">
                            <span class="caret">Geography </span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=900;920">
                            <span class="caret">Biography & Genealogy</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=900;930">
                            <span class="caret">General History of ancient world</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=900;940">
                            <span class="caret">General History of Europe</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=900;950">
                            <span class="caret">General History of Asia</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=900;960">
                            <span class="caret">General History of Africa</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=900;970">
                            <span class="caret">General History of North America</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=900;980">
                            <span class="caret">General History of South America</span>
                        </a>
                    </li>
                    <li>
                        <a href="/search/results/1?dewies=900;990">
                            <span class="caret">Other World History</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
        
        <?php endif ?>
    </div>
</div>





<script>
var toggler = document.getElementsByClassName("caret");
var i;

for (i = 0; i < toggler.length; i++) {
  toggler[i].addEventListener("click", function() {
    this.parentElement.querySelector(".nested").classList.toggle("active");
    this.classList.toggle("caret-down");
  });
}
</script>










<div class="card bg-light" id="live_visiting">

    <div class="card-header bg-gray-dark head nice-font">
        <div class="row no-gutters">
            <div class="col-8">
                <a href="<?php echo base_url(front_base."live") ?>" target="_blank" class="text-dark">            
                    <i class="fa fa-caret-<?php echo OppAlign; ?>"></i> <?php echo word("now_reading") ?>
                </a>                    
            </div>
            <!--div class="col-4 text-<?php echo OppAlign; ?>">
                <i class="fas fa-spinner fa-pulse"></i>
            </div-->
        </div>
    </div>

    <div class="list-group list-group-flush" id="live_visiting_container">
        <?php foreach($latest_logs as $log){ ?>
            
            <?php $book = json_decode($log->log_rel_text); ?>
        
            <div class="list-group-item p-2 book_<?php echo $book->id ?>">
                <div class="small">
                    <a target="_blank" href="<?php echo base_url(front_base."book/".$book->id) ?>">
                        <i class="fa fa-caret-<?php echo OppAlign; ?> text-info"></i> <?php echo $book->title ?>
                    </a>
                </div>
                <div class="small text-muted">
                    <i class="fa fa-clock"></i> <span class="timeago small"><?php echo date("c",$log->log_timestamp) ?></span>
                </div>
            </div>     
        <?php } ?>        
    </div>

</div>

<!-- Stoped By Rafie!-->

<!--script src="//cdnjs.cloudflare.com/ajax/libs/socket.io/2.2.0/socket.io.js" type="text/javascript"></script-->
<!--script type="text/javascript">

    function append_content(new_content){        
        $(new_content).hide().prependTo('#live_visiting_container').fadeIn();           
    }

    var socket = io.connect('//socket.ddl.ae:8080',{ secure: true });
    
    /// Getting From Server
    socket.emit('set_room_id', "view_book_readers" );
    
    socket.on('book_data', function(data) {
        var time_now = new Date();
        var msg = '';
        msg += '<div class="list-group-item p-2 book_'+data.id+'">';        
        
        msg += '<div class="small">';        
        msg += '<a target="_blank" href="'+data.url+'">';        
        msg += '<i class="fa fa-caret-<?php echo OppAlign; ?> text-info"></i> ';        
        msg += data.title;    
        msg += '</a>';
        msg += '</div>';        
        
        msg += '<div class="small text-muted">';                                               
        msg += '<i class="fa fa-clock"></i> <span class="timeago">'+time_now+'</i>';        
        msg += '</div>';        
                
        msg += '</div>';        
        
        if($(".book_"+data.id)[0]){                 
            $(".book_"+data.id).remove();
        }else{
            $("#live_visiting_container .list-group-item:last-child").remove();
        }                                                      
        
        append_content(msg);                  
        
        $('.timeago').cuteTime({ refresh: 1000*20 });        
    });
     
    
</script-->