<?php defined('BASEPATH') OR exit('No direct script access allowed');

    class MY_Lang extends CI_Lang{
        function __construct(){
            parent::__construct();
        }

        public function speak($langfile){

            $langfile = "lang_".$langfile.'.php';

            if (in_array($langfile, $this->is_loaded, TRUE))
            {
                return;
            }

            $config =& get_config();

            $found = FALSE;
             
            if (file_exists('langs/'.$langfile))
            {
                include('langs/'.$langfile);
                $found = TRUE;
            }
               
            if ($found !== TRUE){
                //show_error('Unable to load the requested language file: langs/'.$langfile);
            }


            if ( ! isset($lang))
            {
                log_message('error', 'Language file contains no data: language/'.$langfile);
                return;
            }
            
            $this->is_loaded[] = $langfile;
            $this->language = array_merge($this->language, $lang);
            unset($lang);

            log_message('debug', 'Language file loaded: language/'.$langfile);
            return TRUE;            

        }

} 