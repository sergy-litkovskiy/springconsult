<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller']    = "index";
$route['404_override']          = '';

$route['message/send']          = 'index/ajax_message';
$route['(:any)/message/send']   = 'index/ajax_message';

////////////////////ADMIN////////////////////////////

$route['backend']                                 = "admin/login";
$route['backend/login']                           = "admin/index_admin";
$route['backend/logout']                          = "admin/index_admin/logout";

$route['ajax_change_status']                      = "admin/menu_admin/ajax_change_status";
$route['backend/ajax_change_status']              = "admin/index_admin/ajax_change_status";

$route['backend/article_edit/(:num)']             = 'admin/index_admin/article_edit/$1';
$route['backend/article_edit']                    = 'admin/index_admin/article_edit';
$route['backend/check_valid_article']             = 'admin/index_admin/check_valid_article';
$route['backend/article_drop/(:num)']             = 'admin/index_admin/drop/$1';

$route['backend/check_valid_submenu']             = 'admin/menu_admin/check_valid_menu';
$route['backend/check_valid_menu']                = 'admin/menu_admin/check_valid_menu';
$route['backend/menu_admin']                      = 'admin/menu_admin/index';
$route['backend/menu_admin/item_edit']            = 'admin/menu_admin/edit_menu_item';
$route['backend/menu_admin/del/(:num)/(:num)']    = 'admin/menu_admin/drop/$1/$2';
$route['backend/menu_admin/item_edit/(:num)']     = 'admin/menu_admin/edit_menu_item/$1';
$route['backend/menu_admin/subitem_edit']         = 'admin/menu_admin/edit_menu_subitem';
$route['backend/menu_admin/subitem_edit/(:num)']  = 'admin/menu_admin/edit_menu_subitem/$1';

$route['backend/news']                            = 'admin/index_admin/index';

$route['backend/send_nl_subscribe/(:num)']        = 'admin/index_admin/ajax_send_article_to_subscribers/$1';

$route['backend/subscribe']                       = 'admin/index_admin/subscribe_list';
$route['backend/check_valid_subscribe']           = 'admin/index_admin/check_valid_subscribe';
$route['backend/subscribe_edit']                  = 'admin/index_admin/subscribe_edit';
$route['backend/subscribe_edit/(:num)']           = 'admin/index_admin/subscribe_edit/$1';
$route['backend/subscribe_drop']                  = 'admin/index_admin/subscribe_drop';

$route['backend/material']                        = 'admin/index_admin/material_list';
$route['backend/material_drop']                   = 'admin/index_admin/material_drop';
$route['backend/material_edit']                   = 'admin/index_admin/material_edit';
$route['backend/material_edit/(:num)']            = 'admin/index_admin/material_edit/$1';
$route['backend/check_valid_material']            = 'admin/index_admin/check_valid_materials';

$route['backend/aforizmus']                       = 'admin/index_admin/aforizmus_list';
$route['backend/aforizmus_edit']                  = 'admin/index_admin/aforizmus_edit';
$route['backend/aforizmus_edit/(:num)']           = 'admin/index_admin/aforizmus_edit/$1';
$route['backend/aforizmus_drop/(:num)']           = 'admin/index_admin/aforizmus_drop/$1';

$route['backend/landing']                         = 'admin/index_admin/landing_list';
$route['backend/landing_edit']                    = 'admin/index_admin/landing_edit';
$route['backend/landing_edit/(:num)']             = 'admin/index_admin/landing_edit/$1';
$route['backend/landing_drop/(:num)']             = 'admin/index_admin/landing_drop/$1';
$route['backend/check_valid_landing']             = 'admin/index_admin/check_valid_landing';

$route['backend/landing_articles']                = 'admin/index_admin/landing_articles_list';
$route['backend/landing_articles_edit']           = 'admin/index_admin/landing_articles_edit';
$route['backend/landing_articles_edit/(:num)']    = 'admin/index_admin/landing_articles_edit/$1';
$route['backend/landing_articles_drop/(:num)']    = 'admin/index_admin/landing_articles_drop/$1';
$route['backend/check_valid_landing_articles']    = 'admin/index_admin/check_valid_landing_articles';

$route['backend/sale_page_list']                  = 'admin/index_admin/sale_page_list';
$route['backend/sale_page_edit']                  = 'admin/index_admin/sale_page_edit';
$route['backend/sale_page_edit/(:num)']           = 'admin/index_admin/sale_page_edit/$1';
$route['backend/sale_page_drop/(:num)']           = 'admin/index_admin/sale_page_drop/$1';
$route['backend/check_valid_sale_page']           = 'admin/index_admin/check_valid_sale_page';

$route['backend/sale_products_list']              = 'admin/index_admin/sale_products_list';
$route['backend/sale_products_edit']              = 'admin/index_admin/sale_products_edit';
$route['backend/sale_products_edit/(:num)']       = 'admin/index_admin/sale_products_edit/$1';
$route['backend/sale_products_drop/(:num)']       = 'admin/index_admin/sale_products_drop/$1';
$route['backend/check_valid_sale_products']       = 'admin/index_admin/check_valid_sale_products';

$route['backend/spec_mailer_statistics']          = 'admin/index_admin/spec_mailer_statistics';
$route['backend/spec_mailer_statistics/(:num)']   = 'admin/index_admin/spec_mailer_statistics/$1';
$route['backend/(:any)']                          = 'admin/index_admin/show/$1';

////////////////////FRONTEND////////////////////////////
$route['contact_form/send']                                 = 'index/ajax_send_contact_form';
$route['search']                                            = 'search/search_result';
$route['rss']                                               = 'rss/show_rss';
$route['sitemap']                                           = 'index/sitemap';
$route['show/news']                                         = 'index';
//$route['frontend/unsubscribe/re/(:num)']                    = 'index/unsubscribe_finish/$1';
$route['cloudtag/(:num)']                                   = 'index/cloud_tag_list/$1';
$route['cloudtag/(:num)/page/(:num)']                       = 'index/cloud_tag_list/$1/$2';

$route['unsubscribe/(:any)']                                = 'index/unsubscribe_process/$1';
//$route['subscribe/send']                                    = 'index/ajax_send_subscribe';
$route['frontend/finishsubscribe/(:num)/recip/(:num)']      = 'index/output_subscribe/$1/$2';
$route['news/page/(:num)']                                  = 'index/index/$1';
$route['finishsubscribe/(:any)']                            = 'index/finish_subscribe/$1';
$route['show/(:any)']                                       = 'index/show/$1';
$route['ajax_get_landing_mp3']                              = 'landing/ajax_get_landing_mp3';
$route['landing/(:any)']                                    = 'landing/show_landing_page/$1';
$route['landing_subscribe']                                 = 'landing/ajax_landing_subscribe';
$route['landing_articles/(:any)']                           = 'landing/show_landing_article/$1';
$route['ajax_payment_registration']                         = 'sale/ajax_payment_registration';
$route['sale/(:any)']                                       = 'sale/sale_show/$1';

$route['salestatus/(:any)']                                 = 'sale/sale_payment/$1';
$route['success/sale']                                      = 'sale/success_sale';
$route['faild/sale']                                        = 'sale/faild_sale';

$route['(:any)/(:num)']                                     = 'index/show_detail/$1/$2';

/* End of file routes.php */
/* Location: ./application/config/routes.php */