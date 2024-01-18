<?php 
          
///// vars
define("__env", "live");
//define("__base_live", "https://ddl.ae/");
define("__base_live", "//".$_SERVER["HTTP_HOST"]."/");

define("__base_local", "http://".$_SERVER["HTTP_HOST"]."/ddl/ddl.ae/");
define("__ssl", FALSE);
define("IS_DEBUG", true);

////frontend
//define("frontend_host", '159.65.153.96');
//define("frontend_user", 'client');
define("frontend_host", '10.139.96.134');
define("frontend_user", 'datacenter');
define("frontend_pass", 'Ic@nTHaVe@cceSS');
define("frontend_db", 'ddl_frontend');
define("frontend_driver", 'mysqli');

////Arab Books 
define("arab_host", '10.139.96.134');
define("arab_user", 'arab');
define("arab_pass", 'Ic@nTHaVe@cceSS');
define("arab_db", 'books');
define("arab_driver", 'mysqli');


////engine
//define("engine_host", '159.65.153.96');
//define("engine_user", 'client');
define("engine_host", '10.139.96.134');
define("engine_user", 'datacenter');
define("engine_pass", 'Ic@nTHaVe@cceSS');
define("engine_db", 'ddl_engine');
define("engine_driver", 'mysqli');


////logs
//define("logs_host", '159.65.153.96');
//define("logs_user", 'client');
define("logs_host", '10.139.96.134');
define("logs_user", 'datacenter');
define("logs_pass", 'Ic@nTHaVe@cceSS');
define("logs_db", 'ddl_logs');
define("logs_driver", 'mysqli');


////dump
define("dump_host", '10.139.96.134');
define("dump_user", 'datacenter');
define("dump_pass", 'Ic@nTHaVe@cceSS');
define("dump_db", 'ddl');
define("dump_driver", 'mysqli');

////API
define("api_host", '10.139.96.134');
define("api_user", 'datacenter');
define("api_pass", 'Ic@nTHaVe@cceSS');
define("api_db", 'ddl_api');
define("api_driver", 'mysqli');


////chatbot
define("chatbot_host", '10.139.96.134');
define("chatbot_user", 'datacenter');
define("chatbot_pass", 'Ic@nTHaVe@cceSS');
define("chatbot_db", 'ddl_chatbot');
define("chatbot_driver", 'mysqli');


////dictionaries
define("dicts_host", '10.139.96.134');
define("dicts_user", 'datacenter');
define("dicts_pass", 'Ic@nTHaVe@cceSS');
define("dicts_db", 'ddl_dictionaries');
define("dicts_driver", 'mysqli');

////Koha
define("koha_host", '');
define("koha_user", '');
define("koha_pass", '');
define("koha_db", 'koha_library');
define("koha_driver", 'pdo');


//// Solr
//define("solr_host", "159.65.153.98"); //// Stable Solr Real IP
define("solr_host", "10.139.224.236");  //// Stable Solr internal IP
//define("solr_host", "139.59.21.206");   //// Testing Solr Real IP
    

/// encryption key  
define("encryption_key","af5ecf59d0a8f4ae1d74d8c7155ba7b5");
define("url_timeout",3000); // seconds 3000 = 5 minutes

/// teleporter host  
define("teleporter_host", 'http://10.139.160.155/index.php');