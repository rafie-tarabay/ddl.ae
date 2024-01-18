<?php

$db['engine']['dsn'] = 'mysql:dbname='.engine_db.';host='.engine_host;
$db['engine']['hostname'] = engine_host;
$db['engine']['username'] = engine_user;
$db['engine']['password'] = engine_pass;
$db['engine']['database'] = engine_db;
$db['engine']['dbdriver'] = engine_driver;
$db['engine']['dbprefix'] = '';
$db['engine']['db_debug'] = FALSE;
$db['engine']['cache_on'] = FALSE;
$db['engine']['cachedir'] = FCPATH ."storage/queries";
$db['engine']['char_set'] = 'utf8';
$db['engine']['dbcollat'] = 'utf8_general_ci';
$db['engine']['swap_pre'] = '{PRE}';
$db['engine']['autoinit'] = TRUE;
$db['engine']['stricton'] = FALSE;
$db['engine']['pconnect'] = FALSE;


$db['frontend']['dsn'] = 'mysql:dbname='.frontend_db.';host='.frontend_host;
$db['frontend']['hostname'] = frontend_host;
$db['frontend']['username'] = frontend_user;
$db['frontend']['password'] = frontend_pass;
$db['frontend']['database'] = frontend_db;
$db['frontend']['dbdriver'] = frontend_driver;
$db['frontend']['dbprefix'] = 'ddl_';
$db['frontend']['db_debug'] = FALSE;
$db['frontend']['cache_on'] = FALSE;
$db['frontend']['cachedir'] = FCPATH ."storage/queries";
$db['frontend']['char_set'] = 'utf8';
$db['frontend']['dbcollat'] = 'utf8_general_ci';
$db['frontend']['swap_pre'] = '{PRE}';
$db['frontend']['autoinit'] = TRUE;
$db['frontend']['stricton'] = FALSE;
$db['frontend']['pconnect'] = FALSE;


$db['arab']['dsn'] = 'mysql:dbname='.arab_db.';host='.arab_host;
$db['arab']['hostname'] = arab_host;
$db['arab']['username'] = arab_user;
$db['arab']['password'] = arab_pass;
$db['arab']['database'] = arab_db;
$db['arab']['dbdriver'] = arab_driver;
$db['arab']['dbprefix'] = '';
$db['arab']['db_debug'] = FALSE;
$db['arab']['cache_on'] = FALSE;
$db['arab']['cachedir'] = FCPATH ."storage/queries";
$db['arab']['char_set'] = 'utf8';
$db['arab']['dbcollat'] = 'utf8_general_ci';
$db['arab']['swap_pre'] = '{PRE}';
$db['arab']['autoinit'] = TRUE;
$db['arab']['stricton'] = FALSE;
$db['arab']['pconnect'] = FALSE;


$db['logs']['dsn'] = 'mysql:dbname='.logs_db.';host='.logs_host;
$db['logs']['hostname'] = logs_host;
$db['logs']['username'] = logs_user;
$db['logs']['password'] = logs_pass;
$db['logs']['database'] = logs_db;
$db['logs']['dbdriver'] = logs_driver;
$db['logs']['dbprefix'] = 'ddl_';
$db['logs']['db_debug'] = FALSE;
$db['logs']['cache_on'] = FALSE;
$db['logs']['cachedir'] = FCPATH ."storage/queries";
$db['logs']['char_set'] = 'utf8';
$db['logs']['dbcollat'] = 'utf8_general_ci';
$db['logs']['swap_pre'] = '{PRE}';
$db['logs']['autoinit'] = TRUE;
$db['logs']['stricton'] = FALSE;
$db['logs']['pconnect'] = FALSE;

$db['dump']['dsn'] = 'mysql:dbname='.dump_db.';host='.dump_host;
$db['dump']['hostname'] = dump_host;
$db['dump']['username'] = dump_user;
$db['dump']['password'] = dump_pass;
$db['dump']['database'] = dump_db;
$db['dump']['dbdriver'] = dump_driver;
$db['dump']['dbprefix'] = 'z3950_';
$db['dump']['db_debug'] = FALSE;
$db['dump']['cache_on'] = FALSE;
$db['dump']['cachedir'] = FCPATH ."storage/queries";
$db['dump']['char_set'] = 'utf8';
$db['dump']['dbcollat'] = 'utf8_general_ci';
$db['dump']['swap_pre'] = '{PRE}';
$db['dump']['autoinit'] = FALSE;
$db['dump']['stricton'] = FALSE;
$db['dump']['pconnect'] = FALSE;

$db['api']['dsn'] = 'mysql:dbname='.api_db.';host='.api_host;
$db['api']['hostname'] = api_host;
$db['api']['username'] = api_user;
$db['api']['password'] = api_pass;
$db['api']['database'] = api_db;
$db['api']['dbdriver'] = api_driver;
$db['api']['dbprefix'] = '';
$db['api']['db_debug'] = FALSE;
$db['api']['cache_on'] = FALSE;
$db['api']['cachedir'] = FCPATH ."storage/queries";
$db['api']['char_set'] = 'utf8';
$db['api']['dbcollat'] = 'utf8_general_ci';
$db['api']['swap_pre'] = '{PRE}';
$db['api']['autoinit'] = FALSE;
$db['api']['stricton'] = FALSE;
$db['api']['pconnect'] = FALSE;

$db['chatbot']['dsn'] = 'mysql:dbname='.chatbot_db.';host='.chatbot_host;
$db['chatbot']['hostname'] = chatbot_host;
$db['chatbot']['username'] = chatbot_user;
$db['chatbot']['password'] = chatbot_pass;
$db['chatbot']['database'] = chatbot_db;
$db['chatbot']['dbdriver'] = chatbot_driver;
$db['chatbot']['dbprefix'] = 'bot_';
$db['chatbot']['db_debug'] = FALSE;
$db['chatbot']['cache_on'] = FALSE;
$db['chatbot']['cachedir'] = FCPATH ."storage/queries";
$db['chatbot']['char_set'] = 'utf8';
$db['chatbot']['dbcollat'] = 'utf8_general_ci';
$db['chatbot']['swap_pre'] = '{PRE}';
$db['chatbot']['autoinit'] = FALSE;
$db['chatbot']['stricton'] = FALSE;
$db['chatbot']['pconnect'] = FALSE;

$db['dicts']['dsn'] = 'mysql:dbname='.dicts_db.';host='.dicts_host;
$db['dicts']['hostname'] = dicts_host;
$db['dicts']['username'] = dicts_user;
$db['dicts']['password'] = dicts_pass;
$db['dicts']['database'] = dicts_db;
$db['dicts']['dbdriver'] = dicts_driver;
$db['dicts']['dbprefix'] = '';
$db['dicts']['db_debug'] = FALSE;
$db['dicts']['cache_on'] = FALSE;
$db['dicts']['cachedir'] = FCPATH ."storage/queries";
$db['dicts']['char_set'] = 'utf8';
$db['dicts']['dbcollat'] = 'utf8_general_ci';
$db['dicts']['swap_pre'] = '{PRE}';
$db['dicts']['autoinit'] = FALSE;
$db['dicts']['stricton'] = FALSE;
$db['dicts']['pconnect'] = FALSE;

/*
$db['koha']['dsn'] = 'mysql:dbname='.koha_db.';host='.koha_host;
$db['koha']['hostname'] = koha_host;
$db['koha']['username'] = koha_user;
$db['koha']['password'] = koha_pass;
$db['koha']['database'] = koha_db;
$db['koha']['dbdriver'] = koha_driver;
$db['koha']['dbprefix'] = '';
$db['koha']['db_debug'] = FALSE;
$db['koha']['cache_on'] = FALSE;
$db['koha']['cachedir'] = '';
$db['koha']['char_set'] = 'utf8';
$db['koha']['dbcollat'] = 'utf8_general_ci';
$db['koha']['swap_pre'] = '{PRE}';
$db['koha']['autoinit'] = FALSE;
$db['koha']['stricton'] = FALSE;
$db['koha']['pconnect'] = TRUE;

      
foreach (range(1,3) as $db_no) {
        
    $mrqoom_db = marqoom_db.$db_no;
    
    $db[$mrqoom_db]['dsn'] = 'mysql:dbname='.$mrqoom_db.';host='.marqoom_host;
    $db[$mrqoom_db]['hostname'] = marqoom_host;
    $db[$mrqoom_db]['username'] = marqoom_user;
    $db[$mrqoom_db]['password'] = marqoom_pass;
    $db[$mrqoom_db]['database'] = $mrqoom_db;
    $db[$mrqoom_db]['dbdriver'] = marqoom_driver;
    $db[$mrqoom_db]['dbprefix'] = '';
    $db[$mrqoom_db]['db_debug'] = FALSE;
    $db[$mrqoom_db]['cache_on'] = FALSE;
    $db[$mrqoom_db]['cachedir'] = FCPATH ."storage/queries";
    $db[$mrqoom_db]['char_set'] = 'utf8';
    $db[$mrqoom_db]['dbcollat'] = 'utf8_general_ci';
    $db[$mrqoom_db]['swap_pre'] = '';
    $db[$mrqoom_db]['autoinit'] = FALSE;
    $db[$mrqoom_db]['stricton'] = FALSE; 
    $db[$mrqoom_db]['pconnect'] = TRUE;   
                
}
  
*/