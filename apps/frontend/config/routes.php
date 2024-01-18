<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = "home";
$route['404_override'] = 'misc/not_found';

$route['page/(:any)'] = "help/page/$1";
$route['faq'] = "help/faq";
$route['faq/(:num)'] = "help/faq_section/$1";
$route['faq/topic/(:num)'] = "help/faq_topic/$1";
                              
$route['free-access'] = "Gateway/free_access";                              
$route['access'] = "Gateway/index/";                              
$route['access/expired'] = "Gateway/expired";                              
$route['access/(:any)'] = "Gateway/index/$1";                              
 
$route['join'] = "users/select_type";
$route['join/(:num)'] = "users/join_step/$1";
$route['join/(:num)/(:any)'] = "users/join_step/$1/$2";

$route['login'] = "users/login";
$route['logout'] = "users/logout";
$route['forget-password'] = "users/forget_password";
$route['reset-password'] = "users/reset_password";
$route['reset-password/(:any)'] = "users/reset_password/$1";
$route['arab-library'] = "arab/index";
$route['arab-library/search'] = "arab/search";
$route['arab-library/search/(:any)'] = "arab/search/$1";
$route['arab-library/search/(:any)/(:any)'] = "arab/search/$1/$2";



$route['user/(:any)'] = "profile/index/$1";
$route['profile/edit'] = "profile/edit_profile";

$route['lights/(:any)'] = "misc/night_mode/$1";
$route['locale/(:any)'] = "misc/change_language/$1";

$route['library/(:any)'] = "sections/index/$1";
$route['library/arab-library/(:any)'] = "sections/load/$1";


$route['book/(:any)']               = 'books/view_book/$1';
$route['book/similar/(:any)']       = 'books/similar_books/$1';

$route['book/read/(:any)']          = 'books/read_book/$1';

$route['journal/(:any)']            = 'books/view_journal/$1';    
$route['journal/(:any)/(:num)']     = 'books/view_journal/$1/$2';   

$route['live'] = "browse/now_reading";
$route['bookcopy'] = "orders/PrintCopy";  

/* End of file routes.php */
/* Location: ./application/config/routes.php */