<?php

class authors extends MY_Controller
{
    public function __construct() {
        parent::__construct(); // getting base constructor
    }


    public function index(){
        $data["views"]["content_view"] ="
                                        <a style='margin:5px' href='/search/results/?authors=931' class='btn btn-outline-primary'>جلال الدين عبد الرحمن السيوطي</a>
                                        <a style='margin:5px' href='/search/results/?authors=1225' class='btn btn-outline-primary'>عبد الرحمن بن ناصر السعدي</a>
                                        <a style='margin:5px' href='/search/results/?authors=40862' class='btn btn-outline-primary'>العقاد، عباس،</a>
                                        <a style='margin:5px' href='/search/results/?authors=41101' class='btn btn-outline-primary'>ابن تيمية، أحمد بن عبد الحليم بن عبد السلام،</a>
                                        <a style='margin:5px' href='/search/results/?authors=41283' class='btn btn-outline-primary'>ابن قيم الجوزية، محمد بن أبي بكر بن أيوب،</a>
                                        <a style='margin:5px' href='/search/results/?authors=41751' class='btn btn-outline-primary'>الجلال السيوطي، عبد الرحمن بن أبي بكر بن محمد،</a>
                                        <a style='margin:5px' href='/search/results/?authors=41831' class='btn btn-outline-primary'>ماضي، أحمد.</a>
                                        <a style='margin:5px' href='/search/results/?authors=42429' class='btn btn-outline-primary'>أبو الروس، أيمن الحسيني</a>
                                        <a style='margin:5px' href='/search/results/?authors=42643' class='btn btn-outline-primary'>حسن، أحمد عبد المنعم،</a>
                                        <a style='margin:5px' href='/search/results/?authors=43173' class='btn btn-outline-primary'>الإمام ابن حنبل، أحمد بن محمد بن حنبل،</a>
                                        <a style='margin:5px' href='/search/results/?authors=43836' class='btn btn-outline-primary'>ابن عساكر، علي بن الحسن بن هبة الله،</a>
                                        <a style='margin:5px' href='/search/results/?authors=44658' class='btn btn-outline-primary'>القحطاني، سعيد بن علي بن وهف،</a>
                                        <a style='margin:5px' href='/search/results/?authors=45590' class='btn btn-outline-primary'>صبري، مسعود</a>
                                        <a style='margin:5px' href='/search/results/?authors=47150' class='btn btn-outline-primary'>الوهيبي، محمد حمد.</a>
                                        <a style='margin:5px' href='/search/results/?authors=48740' class='btn btn-outline-primary'>علي، جواد</a>
                                        <a style='margin:5px' href='/search/results/?authors=49012' class='btn btn-outline-primary'>ابن قلاقس، نصر بن عبد الله.</a>
                                        <a style='margin:5px' href='/search/results/?authors=49360' class='btn btn-outline-primary'>راشد، علي</a>
                                        <a style='margin:5px' href='/search/results/?authors=50453' class='btn btn-outline-primary'>الحاجي، محمد عمر</a>
                                        <a style='margin:5px' href='/search/results/?authors=50668' class='btn btn-outline-primary'>مكاريوس، إسكندر</a>
                                        <a style='margin:5px' href='/search/results/?authors=50691' class='btn btn-outline-primary'>أبو نضارة، يعقوب بن رافائيل صنوع،</a>
                                        <a style='margin:5px' href='/search/results/?authors=51528' class='btn btn-outline-primary'>أبو علي الفارسي، الحسن بن أحمد.</a>
                                        <a style='margin:5px' href='/search/results/?authors=51851' class='btn btn-outline-primary'>عبد الرحمن، أسامة</a>
                                        <a style='margin:5px' href='/search/results/?authors=52325' class='btn btn-outline-primary'>الجزيري، جمال</a>
                                        <a style='margin:5px' href='/search/results/?authors=52875' class='btn btn-outline-primary'>الجميعي، عبد المنعم إبراهيم الدسوقي</a>
                                        <a style='margin:5px' href='/search/results/?authors=54970' class='btn btn-outline-primary'>مطاوع، عبد الوهاب،</a>
                                        <a style='margin:5px' href='/search/results/?authors=55178' class='btn btn-outline-primary'>الملاخ، كمال،</a>
                                        <a style='margin:5px' href='/search/results/?authors=59027' class='btn btn-outline-primary'>سزكين ، فؤاد.</a>
                                        <a style='margin:5px' href='/search/results/?authors=59910' class='btn btn-outline-primary'>‫كاسون، آلان‬.</a>
                                        <a style='margin:5px' href='/search/results/?authors=59940' class='btn btn-outline-primary'>الطيب، نوري بن طاهر</a>
                                        <a style='margin:5px' href='/search/results/?authors=59941' class='btn btn-outline-primary'>‫جاوكرودجر، دايفيد ج.‬</a>
                                        <a style='margin:5px' href='/search/results/?authors=59949' class='btn btn-outline-primary'>‫دايرو، جوزيف ف.</a>
                                        <a style='margin:5px' href='/search/results/?authors=59968' class='btn btn-outline-primary'>‫نوروتز، إيرول‬.</a>
                                        <a style='margin:5px' href='/search/results/?authors=59975' class='btn btn-outline-primary'>ابن صادق، عبد الوهاب رجب هاشم‏.</a>
                                        <a style='margin:5px' href='/search/results/?authors=60154' class='btn btn-outline-primary'>‫بيتي، مارك‬.</a>
                                        <a style='margin:5px' href='/search/results/?authors=60350' class='btn btn-outline-primary'>حسين، ماهر البسيوني.</a>
                                        <a style='margin:5px' href='/search/results/?authors=60368' class='btn btn-outline-primary'>العودات، محمد عبدو</a>
                                        <a style='margin:5px' href='/search/results/?authors=60591' class='btn btn-outline-primary'>الصالح، محمد علي خليفة</a>
                                        <a style='margin:5px' href='/search/results/?authors=60640' class='btn btn-outline-primary'>باج، علي.</a>
                                        <a style='margin:5px' href='/search/results/?authors=60648' class='btn btn-outline-primary'>المروزي، ناصر خسرو علوي.</a>
                                        <a style='margin:5px' href='/search/results/?authors=60756' class='btn btn-outline-primary'>المنصور، ناصر بن صالح.</a>
                                        <a style='margin:5px' href='/search/results/?authors=70993' class='btn btn-outline-primary'>Ivits, Shantel,</a>
                                        <a style='margin:5px' href='/search/results/?authors=71003' class='btn btn-outline-primary'>Lidstone, Rod,</a>
                                        <a style='margin:5px' href='/search/results/?authors=72196' class='btn btn-outline-primary'>Sivak, M.,</a>
                                        <a style='margin:5px' href='/search/results/?authors=75677' class='btn btn-outline-primary'>Arthur, T. S.</a>
                                        <a style='margin:5px' href='/search/results/?authors=76467' class='btn btn-outline-primary'>Leonard, Justin W.,</a>
                                        <a style='margin:5px' href='/search/results/?authors=77207' class='btn btn-outline-primary'>Botelho, Luiz C. L.</a>
                                        <a style='margin:5px' href='/search/results/?authors=77359' class='btn btn-outline-primary'>Bartman, Fred L.</a>
                                        <a style='margin:5px' href='/search/results/?authors=78376' class='btn btn-outline-primary'>Colwell, Lester Vern.</a>
                                        <a style='margin:5px' href='/search/results/?authors=78867' class='btn btn-outline-primary'>Birge, John R.</a>
                                        <a style='margin:5px' href='/search/results/?authors=79384' class='btn btn-outline-primary'>Cooper, James Fenimore,</a>
                                        <a style='margin:5px' href='/search/results/?authors=79831' class='btn btn-outline-primary'>Southworth, Emma Dorothy Eliza Nevitte,</a>
                                        <a style='margin:5px' href='/search/results/?authors=82464' class='btn btn-outline-primary'>Ruger, A.</a>
                                        <a style='margin:5px' href='/search/results/?authors=84725' class='btn btn-outline-primary'>Buntline, Ned,</a>
                                        <a style='margin:5px' href='/search/results/?authors=89213' class='btn btn-outline-primary'>Allison, Leonard Newton,</a>
                                        <a style='margin:5px' href='/search/results/?authors=89227' class='btn btn-outline-primary'>Alexander, Gaylord R.</a>
                                        <a style='margin:5px' href='/search/results/?authors=89281' class='btn btn-outline-primary'>Brüll, Ignaz,</a>
                                        <a style='margin:5px' href='/search/results/?authors=89316' class='btn btn-outline-primary'>Hubbs, Carl L.</a>
                                        <a style='margin:5px' href='/search/results/?authors=89561' class='btn btn-outline-primary'>Shetter, David Sibley,</a>
                                        <a style='margin:5px' href='/search/results/?authors=89569' class='btn btn-outline-primary'>Fukano, K. G.</a>
                                        <a style='margin:5px' href='/search/results/?authors=89571' class='btn btn-outline-primary'>Cooper, Gerald P.</a>
                                        <a style='margin:5px' href='/search/results/?authors=91159' class='btn btn-outline-primary'>Washburn, George N.</a>
                                        <a style='margin:5px' href='/search/results/?authors=91180' class='btn btn-outline-primary'>Hazzard, Albert S.</a>
                                        <a style='margin:5px' href='/search/results/?authors=91183' class='btn btn-outline-primary'>Crowe, Walter R.</a>
                                        <a style='margin:5px' href='/search/results/?authors=91732' class='btn btn-outline-primary'>Carbine, William F.</a>
                                        <a style='margin:5px' href='/search/results/?authors=91766' class='btn btn-outline-primary'>Brown, C. J. D.</a>
                                        <a style='margin:5px' href='/search/results/?authors=102891' class='btn btn-outline-primary'>Metropolitan Museum of Art New York, N.Y.</a>
                                        <a style='margin:5px' href='/search/results/?authors=102982' class='btn btn-outline-primary'>New York N.Y..</a>
                                        <a style='margin:5px' href='/search/results/?authors=103133' class='btn btn-outline-primary'>Dickens, Charles,</a>
                                        <a style='margin:5px' href='/search/results/?authors=105467' class='btn btn-outline-primary'>University of Michigan.</a>
                                        <a style='margin:5px' href='/search/results/?authors=105960' class='btn btn-outline-primary'>Schneider, James C.</a>
                                        <a style='margin:5px' href='/search/results/?authors=106279' class='btn btn-outline-primary'>Michigan.</a>
                                        <a style='margin:5px' href='/search/results/?authors=106302' class='btn btn-outline-primary'>United States.</a>
                                        <a style='margin:5px' href='/search/results/?authors=106447' class='btn btn-outline-primary'>Philippines.</a>
                                        <a style='margin:5px' href='/search/results/?authors=106505' class='btn btn-outline-primary'>Hawaii.</a>
                                        <a style='margin:5px' href='/search/results/?authors=107244' class='btn btn-outline-primary'>William L. Clements Library.</a>
                                        <a style='margin:5px' href='/search/results/?authors=107809' class='btn btn-outline-primary'>Hammitt, Frederick G.,</a>
                                        <a style='margin:5px' href='/search/results/?authors=107955' class='btn btn-outline-primary'>Yano, Candace A.</a>
                                        <a style='margin:5px' href='/search/results/?authors=108075' class='btn btn-outline-primary'>New York State.</a>
                                        <a style='margin:5px' href='/search/results/?authors=111293' class='btn btn-outline-primary'>Taube, Clarence M.</a>
                                        <a style='margin:5px' href='/search/results/?authors=111717' class='btn btn-outline-primary'>Stecke, Kathryn E.</a>
                                        <a style='margin:5px' href='/search/results/?authors=112026' class='btn btn-outline-primary'>Eschmeyer, R. W.</a>
                                        <a style='margin:5px' href='/search/results/?authors=116720' class='btn btn-outline-primary'>الدق صلاح نجيب</a>
                                        <a style='margin:5px' href='/search/results/?authors=116957' class='btn btn-outline-primary'>أحمد عبد المنعم حسن</a>
                                        <a style='margin:5px' href='/search/results/?authors=117042' class='btn btn-outline-primary'>محمد يونس هاشم</a>
                                        <a style='margin:5px' href='/search/results/?authors=121308' class='btn btn-outline-primary'>جامعة الأزهر القاهرة.</a>
                                        <a style='margin:5px' href='/search/results/?authors=143283' class='btn btn-outline-primary'>رازي، فخر الدين محمد بن عمر، 1149 </a>
                                        <a style='margin:5px' href='/search/results/?authors=143624' class='btn btn-outline-primary'>شيرازي، محمد المهدي الحسيني ‎‎</a>
                                        <a style='margin:5px' href='/search/results/?authors=145549' class='btn btn-outline-primary'>مجلسي، محمد باقر بن محمد تقي، 1627 </a>
                                        <a style='margin:5px' href='/search/results/?authors=149414' class='btn btn-outline-primary'>شمس الدين محمد بن أحمد بن عثمان الذهبي</a>
                                        <a style='margin:5px' href='/search/results/?authors=151477' class='btn btn-outline-primary'>علي بن نايف الشحود</a>
                                        <a style='margin:5px' href='/search/results/?authors=155708' class='btn btn-outline-primary'>سعيد بن علي بن وهف القحطاني</a>
                                        <a style='margin:5px' href='/search/results/?authors=155855' class='btn btn-outline-primary'>صالح بن فوزان الفوزان</a>
                                        <a style='margin:5px' href='/search/results/?authors=156192' class='btn btn-outline-primary'>محمد ناصر الدين الألباني</a>
                                        <a style='margin:5px' href='/search/results/?authors=156663' class='btn btn-outline-primary'>محمد بن صالح العثيمين</a>
                                        <a style='margin:5px' href='/search/results/?authors=157421' class='btn btn-outline-primary'>محمد بن محمد بن محمد بن الجزري</a>
                                        <a style='margin:5px' href='/search/results/?authors=157465' class='btn btn-outline-primary'>أحمد بن علي بن حجر العسقلاني</a>
                                        <a style='margin:5px' href='/search/results/?authors=161061' class='btn btn-outline-primary'>تقي الدين أحمد بن عبد الحليم بن تيمية</a>
                                        <a style='margin:5px' href='/search/results/?authors=167185' class='btn btn-outline-primary'>محمد بن عبد الوهاب التميمي</a>


                                        ";

        $this->load->view(design_path.'/templates/main/core',$data);
    }

}