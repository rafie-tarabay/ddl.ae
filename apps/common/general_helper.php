<?php


$CI =& get_instance();

function settings($item,$index2 = 0,$index3 = 0){

    global $CI;  
    if(!$CI){
        $CI =& get_instance(); 
    }    

    $settings = $CI->config->item("settings");

    if(!$index2 && !$index3){
        return @$settings[$item];    
    }elseif($index2 && $index3){
        return @$settings[$item][$index2][$index3];
    }elseif($index2){
        return @$settings[$item][$index2];
    }

}

if(!function_exists("getDatetime")){
    function getDatetime($datetime = true){
        if ($datetime == true) {
            return date("Y-m-d H:i:s");
        }else{
            return date("Y-m-d");
        }
    }
}


if(!function_exists("say")){
    function say($text,$seprator=TRUE){
        if($seprator) prnt("-----------------",FALSE);
        prnt($text,FALSE);
        if($seprator) prnt("-----------------",FALSE);
    }
}

            

if(!function_exists("highlighter")){        
    function highlighter($haystack,$needles){
        if(function_exists("highlight_phrase")){
            if(is_array($needles) && count($needles)){
                foreach($needles as $needle){
                    $haystack =  highlight_phrase($haystack, $needle, '<span class="highlighted">', '</span>');    
                }
            }
            
            return $haystack;
        }else{
            return $haystack;
        }
    }
}
            

if(!function_exists("find_and_encode_urls_query")){        
    function find_and_encode_urls_query($text){
        preg_match_all('/href="(.*?)"/s',$text,$found);
        $links = $found[1];
        foreach($links as $link) {
            $l = explode('?',$link);
            $final = $l[0];
            $query = array();
            if($qs = @$l[1]){                        
                $parts = explode('&',$qs);
                if(count($parts) > 0){
                    foreach($parts as $part){
                        $pieces = explode('=',$part);                                
                        if($pieces){
                            $p1 = rawurlencode(@$pieces[1]);
                            $p1 = str_replace("%3B", ";",$p1);                            
                            $p1 = str_replace("%3A", ":",$p1);                            
                            $p1 = str_replace("%2C", ",",$p1);                                                        
                            $p1 = str_replace("%2B", "+",$p1);                                                        
                            $query[] = @$pieces[0]."=".$p1;
                        }
                    }
                }                           
                $final .= "?".join("&",$query);
            }
            $text = str_replace($link,$final,$text);
        }
        
        return $text;
    }
}


function ctrl(){
    global $CI;  
    if(!$CI){
        $CI =& get_instance(); 
    }        
    return $CI->router->fetch_class();
}

function fun(){
    global $CI;  
    if(!$CI){
        $CI =& get_instance(); 
    }        
    return $CI->router->fetch_method();
}


// permissions parser
function can($item){

    global $CI;  
    if(!$CI){
        $CI =& get_instance(); 
    }    

    $permissions = @$CI->config->item("permissions");

    return @$permissions[$item];
}


function word($index,$force = TRUE){          

    if($index){

        global $CI;
        if(!$CI){
            $CI =& get_instance(); 
        }

        $index = strtolower($index);

        if($CI){
            $return = $CI->lang->line($index);
            if($return !== FALSE){
                $return = stripcslashes( htmlspecialchars_decode( html_entity_decode($return) ) );
                return $return ? $return : $index;      
            }elseif($force == TRUE){
                $index = get_english($index);
                if($index){
                    $CI->frontend = $CI->load->database('frontend', TRUE);
                    $CI->frontend->insert("lang_words",array("word_alias"=>$index ,"word_ar"=>NULL,"word_en"=>NULL));
                }
                //prnt($CI->frontend->last_query());
                return $index;                        
            }else{
                return "";
            }
        }elseif($force == TRUE){
            return $index;
        }else{
            return "";
        }

    }
}

function go_back($alt=""){
    global $CI;
    if(!$CI){
        $CI =& get_instance(); 
    }    
    //$CI->load->library('user_agent');
    $url =  $CI->agent->referrer();
    if(strpos($url,base_url()) === FALSE){
        $url = $alt ? $alt : base_url(front_base);
    }    
    return $url;
}

function segment($seg){
    global $CI;
    if(!$CI){
        $CI =& get_instance(); 
    }
    return $CI->uri->segment($seg);     
}

if(!function_exists("prnt")){
    function prnt($query,$die = TRUE){
        echo '<pre class="ltr">';
        print_r($query);
        echo "</pre>";        
        if($die == TRUE) die();
    }
}

if(!function_exists("prntf")){
    function prntf($query){
        return prnt($query,FALSE);
    }
}

if(!function_exists("array_numeric")){
    function array_numeric($entries){
        $returned = array();
        foreach($entries as $entry){
            if(!empty($entry) || ( $entry === 0 || $entry === "0"  || $entry === "000" )){
                //special case for dewies
                $returned[] = $entry === "000" ? "000" : (int) $entry;
            }
        } 
        return $returned;       
    }
}

if(!function_exists("array_alpha")){
    function array_alpha($entries,$length = FALSE){
        $returned = array();
        foreach($entries as $entry){
            
            if(preg_match("/^[a-zA-Z0-9]+$/", $entry) == 1) {            
                if($length > 0){
                    if(strlen($entry) == $length){
                        $returned[] = $entry;    
                    }
                }else{
                    $returned[] = $entry;
                }            
            }
        } 
        return $returned;       
    }
}

if(!function_exists("lq")){
    function lq($db = FALSE){     
        if($db == FALSE) $db = $this->db;
        prnt($db->last_query());
    }
}

function anchor_me($url,$text,$target = "_self",$title = ""){
    return '<a href="'.$url.'" target="'.$target.'" title="'.$title.'">'.$text.'</a>';
}

function gen_hash($length = 10){
    $_rand_src = array(
        array(48,57) //digits
        , array(97,122) //lowercase chars
        , array(65,90) //uppercase chars
    );
    srand ((double) microtime() * 1000000);
    $hash = "";
    for($i=0;$i<$length;$i++){
        $i1=rand(0,sizeof($_rand_src)-1);
        $hash .= chr(rand($_rand_src[$i1][0],$_rand_src[$i1][1]));
    }
    return $hash;        
}

function gen_code($length = 10){
    $_rand_src = array(
        array(48,57) //digits
    );
    srand ((double) microtime() * 1000000);
    $hash = "";
    for($i=0;$i<$length;$i++){
        $i1=rand(0,sizeof($_rand_src)-1);
        $hash .= chr(rand($_rand_src[$i1][0],$_rand_src[$i1][1]));
    }
    return $hash;        
}


function decode_html($html){
    return htmlspecialchars_decode($html);
}


function remove_emoji($text){


    // Match Emoticons
    $regexEmoticons = '/[\x{1F600}-\x{1F64F}]/u';
    $clean_text = preg_replace($regexEmoticons, '', $text);

    // Match Miscellaneous Symbols and Pictographs
    $regexSymbols = '/[\x{1F300}-\x{1F5FF}]/u';
    $clean_text = preg_replace($regexSymbols, '', $clean_text);

    // Match Transport And Map Symbols
    $regexTransport = '/[\x{1F680}-\x{1F6FF}]/u';
    $clean_text = preg_replace($regexTransport, '', $clean_text);

    // Match Miscellaneous Symbols
    $regexMisc = '/[\x{2600}-\x{26FF}]/u';
    $clean_text = preg_replace($regexMisc, '', $clean_text);

    // Match Dingbats
    $regexDingbats = '/[\x{2700}-\x{27BF}]/u';
    $clean_text = preg_replace($regexDingbats, '', $clean_text);    

    return preg_replace('/\xEE[\x80-\xBF][\x80-\xBF]|\xEF[\x81-\x83][\x80-\xBF]/', '', $clean_text);
}


function clean_blanks($text){

    $text = @str_replace('[removed]', '', $text);    

    return preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $text);    

}


function clear_me($text , $nl2br = TRUE){

    $text = remove_emoji($text);    

    $text = @trim($text);
    $text = @strip_tags($text);
    $text = @strip_slashes($text);
    $text = @strip_quotes($text);         
    $text = @htmlentities($text, ENT_QUOTES, 'UTF-8');       

    // email
    $pattern = "/[^@\s]*@[^@\s]*\.[^@\s]*/";
    $replacement = " ";
    $text = @preg_replace($pattern, $replacement, $text);    

    // url
    $pattern = "/[a-zA-Z]*[:\/\/]*[A-Za-z0-9\-_]+\.+[A-Za-z0-9\.\/%&=\?\-_]+/i";
    $replacement = " ";
    $text = @preg_replace($pattern, $replacement, $text);

    // mobile
    $pattern = "/\+?[0-9][0-9-\s+]{4,20}[0-9]/";
    $replacement = " ";    
    $text = @preg_replace($pattern, $replacement, $text);       

    $text = nl2br($text);
    $text = @preg_replace('#<br />(\s*<br />)+#', '<br />', $text);    
    $text = @preg_replace('#</br>(\s*</br>)+#', '</br>', $text);    
    $text = @preg_replace('#<br>(\s*<br>)+#', '<br>', $text);    

    if($text && $nl2br == FALSE){
        $text = str_replace('<br />',"\n", $text);
        $text = str_replace('<br>',"\n", $text);
    }

    return $text;

}   

function clean_comment($text, $nl2br = TRUE,$emoji = TRUE){

    if($emoji == TRUE){
        $text = remove_emoji($text);
    }

    $text = @trim($text);
    $text = @strip_tags($text);    
    $text = @htmlentities($text, ENT_QUOTES, 'UTF-8');       

    $text = nl2br($text);
    $text = @preg_replace('#<br />(\s*<br />)+#', '<br />', $text);    
    $text = @preg_replace('#</br>(\s*</br>)+#', '</br>', $text);    
    $text = @preg_replace('#<br>(\s*<br>)+#', '<br>', $text);    

    if($text && $nl2br == FALSE){
        $text = str_replace('<br />',"\n", $text);
        $text = str_replace('<br>',"\n", $text);
        $text = @strip_tags($text);    
    }

    $text = @str_replace('[removed]', '', $text);    

    return $text;

}                

function clean_desc($text,$empty = FALSE){

    $text = remove_emoji($text);

    $text = strip_tags($text);

    $pattern = '~\{\{\s*(.*?)\s*\}\}~';
    $replacement = $empty == FALSE ? " [ملف صوتي] " : " ";    
    $text = @preg_replace($pattern, $replacement, $text); 

    $pattern = '/[^@\s]*@[^@\s]*\.[^@\s]*/';
    $replacement = $empty == FALSE ? " [بريد-إلكتروني] " : " ";
    $text = @preg_replace($pattern, $replacement, $text);    

    $pattern = '/[a-zA-Z]*[:\/\/]*[A-Za-z0-9\-_]+\.+[A-Za-z0-9\.\/%&=\?\-_]+/i';
    $replacement = $empty == FALSE ? " [رابط] " : " ";
    $text = @preg_replace($pattern, $replacement, $text);       

    $text = trim($text);  

    $text = @str_replace('[removed]', '', $text); 

    return $text;
}

function simple_clean($text){
    $text = remove_emoji($text);
    $text = @str_replace('[removed]', '', $text);
    return trim(allowed_chars($text));
}

function security_clean($text){
    $text = remove_emoji($text);
    $text = @trim($text);
    $text = @strip_tags($text);    
    $text = @htmlentities($text, ENT_QUOTES, 'UTF-8');   

    $text = @str_replace('[removed]', '', $text);

    return $text;
}

function topic_clean($text){
    $text = remove_emoji($text);
    $text = @str_replace('[removed]', '', $text);
    return  strip_tags($text,"<br><p><div><ul><li><img><a><b><strong><em><span>");;
}

function project_clean($text){
    $text = remove_emoji($text);
    $text = @str_replace('[removed]', '', $text);
    $text = @preg_replace('[]', '', $text);
    return  strip_tags($text,"<br><p><div><ul><li><b><strong><em><span>");
}

function get_ids_array($elements,$parameter){

    $arr = array();
    if($elements){
        foreach($elements as $element){  
            if($element && !is_null($element)){
                $arr[] = $element->{$parameter};              
            }
        }
    }
    return $arr;
}      

function elements_to_list($elements,$class="list_elements",$icon = "",$word = TRUE){

    $list = '<ul class="'.$class.'">';        
    $_icon = $icon ? '<i class="fa fa-'.$icon.'"></i> ':"";
    foreach($elements as $element){
        if($word == TRUE)
            $list .= "<li>".$_icon.word($element)."</li>";
        else
            $list .= "<li>".$_icon.$element."</li>";
    }        
    $list .= "</ul>";

    return $list;
}    

function allowed_chars($text){
    $allowed = array(
        "1","2","3","4","5","6","7","8","9","0",
        "a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z",
        "A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z",
        "ا","أ","إ","آ","ض","ص","ث","ق","ف","غ","ع","ه","خ","ح","ج","د","ش","س","ي","ب","ل","ت","ن","م","ك","ط","ئ","ء","ؤ","ر","ى","ة","و","ز","ظ","ذ"
        ," ","-","_","?","!",'$',":","،",",",";","(",")",'ّ','َ','ً','ُ','ٌ','ِ','ٍ','ْ'
    );
    $splitted = str_split_utf8($text);
    $text = "";
    foreach($splitted as $letter){
        if(in_array($letter,$allowed)){
            $text .= $letter;
        }
    }
    return $text;
}    

function clean_title_chars($text){
    $allowed = array(
        "[","]",        
        "1","2","3","4","5","6","7","8","9","0",        
        "a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z",
        "A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z",
        "ا","أ","إ","آ","ض","ص","ث","ق","ف","غ","ع","ه","خ","ح","ج","د","ش","س","ي","ب","ل","ت","ن","م","ك","ط","ئ","ء","ؤ","ر","ى","ة","و","ز","ظ","ذ",'ی',
        " ","-","?","!","/","\/"
    );
    $splitted = str_split_utf8($text);
    $text = "";
    foreach($splitted as $letter){
        if(in_array($letter,$allowed)){
            $text .= $letter;
        }
    }
    return $text;
}     

function clean_keywords_chars($text){
    $allowed = array(
        "1","2","3","4","5","6","7","8","9","0",        
        "a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z",
        "A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z",
        "ا","أ","إ","آ","ض","ص","ث","ق","ف","غ","ع","ه","خ","ح","ج","د","ش","س","ي","ب","ل","ت","ن","م","ك","ط","ئ","ء","ؤ","ر","ى","ة","و","ز","ظ","ذ"
        ," ",",","-",'"'
    );
    $splitted = str_split_utf8($text);
    //prnt($splitted,FALSE);
    $text = "";
    foreach($splitted as $letter){                                 
        $letter = (string) $letter;
        if(in_array($letter,$allowed)){
            $text .= $letter;
        }
    }
    return $text;
}     

function tags_chars($text){
    $allowed = array(
        "1","2","3","4","5","6","7","8","9","0",
        "a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z",
        "A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z",
        "ا","أ","إ","آ","ض","ص","ث","ق","ف","غ","ع","ه","خ","ح","ج","د","ش","س","ي","ب","ل","ت","ن","م","ك","ط","ئ","ء","ؤ","ر","ى","ة","و","ز","ظ","ذ"
        ,"_",'ّ','َ','ً','ُ','ٌ','ِ','ٍ','ْ'
    );
    $splitted = str_split_utf8($text);
    $text = "";
    foreach($splitted as $letter){
        if(in_array($letter,$allowed)){
            $text .= $letter;
        }
    }
    return $text;
}     

function get_english($text){
    $english = array("1","2","3","4","5","6","7","8","9","0","a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","A","B","C","D","E","F","G","H","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","_","-");
    $splitted = str_split_utf8($text);
    $text = "";
    foreach($splitted as $letter){
        if(in_array($letter,$english)){
            $text .= $letter;
        }
    }
    return $text;
}       



function get_alias($word_alias){

    $word_alias = trim($word_alias);
    $word_alias = strtolower(str_replace(" ","_",$word_alias));                        
    $word_alias = get_english($word_alias);

    return $word_alias;
}        



function str_split_utf8($str) {
    $str = (string) $str;
    // place each character of the string into array
    $split=1;
    $array = array();
    for ( $i=0; $i < strlen( $str ); ){
        $value = ord($str[$i]);
        if($value > 127){
            if($value >= 192 && $value <= 223)
                $split=2;
            elseif($value >= 224 && $value <= 239)
                $split=3;
            elseif($value >= 240 && $value <= 247)
                $split=4;
        }else{
            $split=1;
        }
        $key = NULL;
        for ( $j = 0; $j < $split; $j++, $i++ ) {
            $key .= $str[$i];
        }
        array_push( $array, $key );
    }
    return $array;
} 

function inflator($count,$word,$one=FALSE){ 
    $lang = word("lang");
    $count = (int) $count;
    if($count == 1){
        return ($one == TRUE? "1 " :"").word($word);
    }elseif($count == 2){
        return $lang =="ar" ? " ".word("2_".$word."s")  : $count." ".word($word."s") ;
    }elseif($count > 2 && $count < 11){
        return $count." ".word($word."s") ;
    }else{
        return $lang =="ar" ? $count." ".word($word)  : $count." ".word($word."s") ;
    }
}

function secondsToTime($inputSeconds , $__seconds = TRUE ,$__days = TRUE ,$__minutes = TRUE , $two_items =FALSE) {
    $secondsInAMinute = 60;
    $secondsInAnHour  = 60 * $secondsInAMinute;
    $secondsInADay    = 24 * $secondsInAnHour;
    $days = floor($inputSeconds / $secondsInADay);
    $hourSeconds = $inputSeconds % $secondsInADay;
    $hours = floor($hourSeconds / $secondsInAnHour);
    $minuteSeconds = $hourSeconds % $secondsInAnHour;
    $minutes = floor($minuteSeconds / $secondsInAMinute);
    $remainingSeconds = $minuteSeconds % $secondsInAMinute;
    $seconds = ceil($remainingSeconds);
    $obj = array('d' => (int) $days,'h' => (int) $hours,'m' => (int) $minutes,'s' => (int) $seconds,);            

    $time = array();                        
    $sep = " ".word("clock_separator");                                                        
    if($__days && $days > 0){
        $time[] = inflator($days,"day");
    } 

    if($days > 0 || ($days == 0 && $hours > 0)){
        $time[] = inflator($hours,"hour");
    }

    if( $__minutes && (($hours > 0) || ( $hours == 0 && $minutes > 0) ) ){
        $time[] = inflator($minutes,"minute");                                         
    }

    if($__seconds && $seconds > 0){
        $time[] = inflator($seconds,"second");
    }  

    if(!$time){
        $time[] = inflator($minutes,"minute");                                         
    }

    if(!$time){
        $time[] = inflator($seconds,"second");
    }    

    if($two_items == TRUE){
        $_time = array();
        foreach($time as $t){
            if(count($_time) < 2){
                if($t) $_time[] = $t;
            }
        }

        $time = $_time;
    }        

    return join($sep,$time);

}    

function human_date($date){
    $lang = word("lang");
    if($lang == "ar"){
        $months = array(
            "january"=>"يناير","february"=>"فبراير","march"=>"مارس","april"=>"أبريل","may"=>"مايو","june"=>"يونيو", "july"=>"يوليو","august"=>"أغسطس","september"=>"سبتمبر","october"=>"أكتوبر","november"=>"نوفمبر","december"=>"ديسمبر"
        );
        $days = array(
            "saturday"=>"السبت","sunday"=>"الأحد", "monday"=>"الإثنين", "tuesday"=>"الثلاثاء", "wednesday"=>"الأربعاء", "thursday"=>"الخميس", "friday"=>"الجمعة" 
        );        
        $date = strtolower($date);
        foreach ($months as $en => $ar) { $date = str_replace($en , $ar ,$date); }
        foreach ($days as $en => $ar) { $date = str_replace($en , $ar ,$date); }        
        $date = str_replace("pm" , "م" ,$date);
        $date = str_replace("am" , "ص" ,$date);
    }
    return $date;
}


function valid_url($url){       
    if( filter_var($url, FILTER_VALIDATE_URL) === FALSE || ( strpos($url,".") !== FALSE && strpos($url,"//") !== FALSE ) ){
        $pattern = '|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i';        
        return preg_match($pattern, $url);
    }else{
        return FALSE;
    }
}


function url_ready($text){

    $text = allowed_chars($text);

    return underscore($text);
}



function total_counter($elements,$parameter){
    $val = 0;
    foreach($elements as $element){  
        $val += $element->{$parameter};              
    }
    return $val;
}


function url_pattern(){
    //source : https://gist.github.com/gruber/8891611
    return "/(?i)\b((?:https?:(?:\/{1,3}|[a-z0-9%])|[a-z0-9.\-]+[.](?:com|net|org|edu|gov|mil|aero|asia|biz|cat|coop|info|int|jobs|mobi|museum|name|post|pro|tel|travel|xxx|ac|ad|ae|af|ag|ai|al|am|an|ao|aq|ar|as|at|au|aw|ax|az|ba|bb|bd|be|bf|bg|bh|bi|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|cr|cs|cu|cv|cx|cy|cz|dd|de|dj|dk|dm|do|dz|ec|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gg|gh|gi|gl|gm|gn|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|im|in|io|iq|ir|is|it|je|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|me|mg|mh|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|mv|mw|mx|my|mz|na|nc|ne|nf|ng|ni|nl|no|np|nr|nu|nz|om|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|ps|pt|pw|py|qa|re|ro|rs|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|Ja|sk|sl|sm|sn|so|sr|ss|st|su|sv|sx|sy|sz|tc|td|tf|tg|th|tj|tk|tl|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)\/)(?:[^\s()<>{}\[\]]+|\([^\s()]*?\([^\s()]+\)[^\s()]*?\)|\([^\s]+?\))+(?:\([^\s()]*?\([^\s()]+\)[^\s()]*?\)|\([^\s]+?\)|[^\s`!()\[\]{};:'\".,<>?«»“”‘’])|(?:(?<!@)[a-z0-9]+(?:[.\-][a-z0-9]+)*[.](?:com|net|org|edu|gov|mil|aero|asia|biz|cat|coop|info|int|jobs|mobi|museum|name|post|pro|tel|travel|xxx|ac|ad|ae|af|ag|ai|al|am|an|ao|aq|ar|as|at|au|aw|ax|az|ba|bb|bd|be|bf|bg|bh|bi|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|cr|cs|cu|cv|cx|cy|cz|dd|de|dj|dk|dm|do|dz|ec|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gg|gh|gi|gl|gm|gn|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|im|in|io|iq|ir|is|it|je|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|me|mg|mh|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|mv|mw|mx|my|mz|na|nc|ne|nf|ng|ni|nl|no|np|nr|nu|nz|om|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|ps|pt|pw|py|qa|re|ro|rs|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|Ja|sk|sl|sm|sn|so|sr|ss|st|su|sv|sx|sy|sz|tc|td|tf|tg|th|tj|tk|tl|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)\b\/?(?!@)))/";
}

function get_from_json($json_encoded,$param = FALSE){
    $json_decoded = json_decode($json_encoded,TRUE);   
    if($param){
        return $json_decoded[$param];
    }else{
        return $json_decoded;
    }
}



if(!function_exists("curl_fetch")){

    function curl_fetch($url,$saveto){

        $user_agent='Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';        
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);        

        //curl_setopt($ch, CURLOPT_TIMEOUT,10);
        curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
        curl_setopt($ch, CURLOPT_SSLVERSION,CURL_SSLVERSION_DEFAULT);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);         
        $output = curl_exec($ch);

        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch); 

        if($httpcode == 200){

            if(file_exists($saveto)){
                unlink($saveto);
            }
            $fp = fopen($saveto,'x');
            fwrite($fp, $output);
            fclose($fp);  

            return TRUE;

        }else{
            return FALSE;
        }

    }    


}




if(!function_exists("upload_folder")){

    function upload_folder($date="today",$sub_dir = "",$no_base=FALSE,$full_url =FALSE,$predate=""){

        /// Upload Base Folder
        $base = defined("upload_base") ? ( upload_base ? upload_base : "uploads/" )  :  "uploads/";
        $upload_base = FCPATH.$base;        
        // make sure it exists or create it
        if( !is_dir($upload_base) ) mkdir($upload_base);
        
        /// if you need a prefix before date
        if($predate){
            if( !is_dir($upload_base.$predate) ) mkdir($upload_base.$predate);                
            $upload_base .= $predate."/";
        }
        
        // convert Date Sent to timestamp
        $timestamp = strtotime($date);
        // Year / Month / Day Folder
        $year = date("Y",$timestamp);
        $month = date("m",$timestamp);
        $day = date("d",$timestamp);        
        // Make sure they exist or create them
        if( !is_dir($upload_base.$year) ) mkdir($upload_base.$year);
        if( !is_dir($upload_base.$year."/".$month) ) mkdir($upload_base.$year."/".$month);
        if( !is_dir($upload_base.$year."/".$month."/".$day) ) mkdir($upload_base.$year."/".$month."/".$day);

        // Set Path
        $path = $upload_base.$year."/".$month."/".$day."/";
        // Add sub directory if needed
        if($sub_dir){
            $path = $path.$sub_dir."/";
            if( !is_dir($path) ) mkdir($path);
        }

        // strip Base from path of needed
        if($no_base == TRUE){
            $path = str_replace($upload_base,"/",$path);
            if($predate) $path = "/".$predate.$path;
        }

        // Give http url for the folder if needed
        if($full_url == TRUE){
            $path = str_replace($upload_base,"/",$path);
            $path = ltrim($path, '/');
            $path = base_url($base.$path);
        }

        return $path;

    }    


}






if(!function_exists("fetch_cover")){
    function fetch_cover($whatever = 0, $view="full" , $full_url = true){    

        //$whatever = str_replace(" ","%20",$whatever);
        
        // if it is not a url AND not a no-protocol url
        if (filter_var($whatever, FILTER_VALIDATE_URL) === FALSE && substr( $whatever, 0, 2 ) !== '//') {
  
            // full image or thumb ?
            $view = $view ? $view : @$_GET["view"] ;        

            /// Upload Base Folder
            $base = defined("upload_base") ? ( upload_base ? upload_base : "uploads/" )  :  "uploads/";

            // no content alternatives
            if($whatever == "zaid_cover"){
                $no_cover = $base."no_image/no_book_cover_zaid.jpg";
                $no_thumb = $base."no_image/thumb_no_book_cover_zaid.jpg";
            }else{
                $no_cover = $base."no_image/no_book_cover.jpg";
                $no_thumb = $base."no_image/thumb_no_book_cover.jpg";                
            }

            if($whatever){             
                $whatever = str_replace("sources/sources","sources",$whatever);                            
                $cover = "https://ddl-covers.sgp1.digitaloceanspaces.com/sources/".$whatever;                    
                //list($width, $height) = getimagesize($cover);
                //if($width < 100 || $height < 100){
                    //unset($cover);
                //}
            }

            // if no cover found
            if(!isset($cover)){
                if( $view == "full" ){
                    $cover = $no_cover;            
                }else{
                    $cover = $no_thumb;   
                }                    
            }

            return $cover;

        }else{
            return $whatever;
        }        

    } 
}


if(!function_exists("thumb_file_name")){
    function thumb_file_name($file){
        $file_name = basename($file);
        $cover_thumb_path = str_replace($file_name,"thumb_".$file_name,$file);
        return $cover_thumb_path;
    }
}

if(!function_exists("relative_to_full_url")){
    function relative_to_full_url($relative){        
        $url = str_replace(FCPATH,"",$relative);        
        $url = ltrim($url, '/');
        return base_url($url);
    }
}



if(!function_exists("path_of")){
    function path_of($url){                
        if(filter_var($url, FILTER_VALIDATE_URL) === FALSE){
            $url = ltrim($url, '/');    
            $url = base_url(upload_base.$url);
        }        
        return $url;
    }
}




if(!function_exists("no_protocol")){
    function no_protocol($url){                
        $url = str_replace("http://","//",$url);
        $url = str_replace("https://","//",$url);
        return $url;
    }
}


if(!function_exists("ip_to_int")){
    function ip_to_int($ip){        
        $octet = explode(".",$ip);
        return ($octet[0] *  (256*256*256) ) + ($octet[1] * (256*256) ) + ($octet[2] * 256) + ($octet[3]);        
    }
}


if(!function_exists("user_photo")){
    function user_photo($user){  
        if( filter_var($user->u_photo, FILTER_VALIDATE_URL) === FALSE ){      
            return $user->u_photo ? base_url(upload_base."users/".$user->u_photo) : base_url(upload_base."no_image/user_".$user->u_gender.".png");
        }else{
            return $user->u_photo;
        }
    }
}




if(!function_exists("teleport")){
    function teleport($file){                            
        
        $host = teleporter_host."?SecretXparam=".base64_encode($file);

        $result = file_get_contents($host);
          
        return $result;          
        
        /*        
        $host = teleporter_host;
                   
        $params = array(
            "file" => base64_encode($file),
        ); 

        $fields_string = http_build_query($params);       
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); 
        curl_setopt($ch, CURLOPT_URL, $host);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');    
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CAINFO, APPPATH.'config/cacert.pem');        
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        $result = curl_exec($ch);        
        
        curl_close($ch);  
                          
        return $result;       
        */           
        
    }
}



if(!function_exists("random_float")){
    function random_float ($min,$max) {
        return round( ($min + lcg_value()*(abs($max - $min))), 1 );
    }
}