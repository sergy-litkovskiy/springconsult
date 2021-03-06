<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

$route['default_controller'] = 'service';
$route['404_override']       = 'errorController/index';

$route['message/send']        = 'index/ajax_message';
$route['(:any)/message/send'] = 'index/ajax_message';

////////////////////ADMIN////////////////////////////

$route['backend']        = "admin/login";
$route['backend/login']  = "admin/index_admin";
$route['backend/logout'] = "admin/index_admin/logout";

$route['ajax_change_status'] = "admin/menu_admin/ajax_change_status";
//$route['backend/ajax_change_status']              = "admin/index_admin/ajax_change_status";

$route['backend/article_edit/(:num)'] = 'admin/article_admin/article_edit/$1';
$route['backend/article_edit']        = 'admin/article_admin/article_edit';
$route['backend/check_valid_article'] = 'admin/article_admin/check_valid_article';
$route['backend/article_drop/(:num)'] = 'admin/article_admin/drop/$1';

$route['backend/topic_edit']        = 'admin/topic_admin/edit';
$route['backend/topic_edit/(:num)'] = 'admin/topic_admin/edit/$1';
$route['backend/topic_drop/(:num)'] = 'admin/topic_admin/drop/$1';
$route['backend/topic_save']        = 'admin/topic_admin/save';

$route['backend/sale_category_edit']        = 'admin/saleCategory_admin/edit';
$route['backend/sale_category_edit/(:num)'] = 'admin/saleCategory_admin/edit/$1';
$route['backend/sale_category_drop/(:num)'] = 'admin/saleCategory_admin/drop/$1';
$route['backend/sale_category_save']        = 'admin/saleCategory_admin/save';

$route['backend/sale_category_number_edit/(:num)'] = 'admin/saleCategory_admin/editNumber/$1';

$route['backend/review_edit']        = 'admin/review_admin/edit';
$route['backend/review_edit/(:num)'] = 'admin/review_admin/edit/$1';
$route['backend/review_drop/(:num)'] = 'admin/review_admin/drop/$1';
$route['backend/review_save']        = 'admin/review_admin/save';

$route['backend/check_valid_submenu']            = 'admin/menu_admin/check_valid_menu';
$route['backend/check_valid_menu']               = 'admin/menu_admin/check_valid_menu';
$route['backend/menu_admin']                     = 'admin/menu_admin/index';
$route['backend/menu_admin/item_edit']           = 'admin/menu_admin/edit_menu_item';
$route['backend/menu_admin/del/(:num)/(:num)']   = 'admin/menu_admin/drop/$1/$2';
$route['backend/menu_admin/item_edit/(:num)']    = 'admin/menu_admin/edit_menu_item/$1';
$route['backend/menu_admin/subitem_edit']        = 'admin/menu_admin/edit_menu_subitem';
$route['backend/menu_admin/subitem_edit/(:num)'] = 'admin/menu_admin/edit_menu_subitem/$1';

$route['backend/news']          = 'admin/index_admin/index';
$route['backend/topic']         = 'admin/topic_admin/index';
$route['backend/sale_category'] = 'admin/saleCategory_admin/index';
$route['backend/review']        = 'admin/review_admin/index';

//$route['backend/send_nl_subscribe/(:num)']        = 'admin/article_admin/ajax_send_article_to_subscribers/$1';

$route['backend/gift']             = 'admin/index_admin/gift_list';
$route['backend/check_valid_gift'] = 'admin/index_admin/check_valid_gift';
$route['backend/gift_edit']        = 'admin/index_admin/gift_edit';
$route['backend/gift_edit/(:num)'] = 'admin/index_admin/gift_edit/$1';
$route['backend/gift_drop/(:num)'] = 'admin/index_admin/gift_drop/$1';

$route['backend/material']             = 'admin/material_admin/material_list';
$route['backend/material_drop/(:num)'] = 'admin/material_admin/material_drop/$1';
$route['backend/material_edit']        = 'admin/material_admin/material_edit';
$route['backend/material_edit/(:num)'] = 'admin/material_admin/material_edit/$1';
$route['backend/check_valid_material'] = 'admin/material_admin/check_valid_materials';

//$route['backend/aforizmus']             = 'admin/index_admin/aforizmus_list';
//$route['backend/aforizmus_edit']        = 'admin/index_admin/aforizmus_edit';
//$route['backend/aforizmus_edit/(:num)'] = 'admin/index_admin/aforizmus_edit/$1';
//$route['backend/aforizmus_drop/(:num)'] = 'admin/index_admin/aforizmus_drop/$1';

$route['backend/landing']             = 'admin/landing_admin/landing_list';
$route['backend/landing_edit']        = 'admin/landing_admin/landing_edit';
$route['backend/landing_edit/(:num)'] = 'admin/landing_admin/landing_edit/$1';
$route['backend/landing_drop/(:num)'] = 'admin/landing_admin/landing_drop/$1';
$route['backend/check_valid_landing'] = 'admin/landing_admin/check_valid_landing';

$route['backend/landing_articles']             = 'admin/landing_admin/landing_articles_list';
$route['backend/landing_articles_edit']        = 'admin/landing_admin/landing_articles_edit';
$route['backend/landing_articles_edit/(:num)'] = 'admin/landing_admin/landing_articles_edit/$1';
$route['backend/landing_articles_drop/(:num)'] = 'admin/landing_admin/landing_articles_drop/$1';
$route['backend/check_valid_landing_articles'] = 'admin/landing_admin/check_valid_landing_articles';

$route['backend/sale_page_list']        = 'admin/sale_admin/sale_page_list';
$route['backend/sale_page_edit']        = 'admin/sale_admin/sale_page_edit';
$route['backend/sale_page_edit/(:num)'] = 'admin/sale_admin/sale_page_edit/$1';
$route['backend/sale_page_drop/(:num)'] = 'admin/sale_admin/sale_page_drop/$1';
$route['backend/sale_page_save']        = 'admin/sale_admin/sale_page_save';

$route['backend/sale_product_list']        = 'admin/sale_admin/sale_product_list';
$route['backend/sale_product_edit']        = 'admin/sale_admin/sale_product_edit';
$route['backend/sale_product_edit/(:num)'] = 'admin/sale_admin/sale_product_edit/$1';
$route['backend/sale_product_drop/(:num)'] = 'admin/sale_admin/sale_product_drop/$1';
$route['backend/sale_product_save']        = 'admin/sale_admin/sale_product_save';
$route['backend/sale_product_statistic']   = 'admin/sale_admin/sale_product_statistic';
$route['backend/sale_product_number_edit/(:num)'] = 'admin/sale_admin/editNumber/$1';

$route['backend/announce_list']        = 'admin/announce_admin/announce_list';
$route['backend/check_valid_announce'] = 'admin/announce_admin/check_valid_announce';
$route['backend/announce_edit']        = 'admin/announce_admin/announce_edit';
$route['backend/announce_edit/(:num)'] = 'admin/announce_admin/announce_edit/$1';
$route['backend/announce_drop/(:num)'] = 'admin/announce_admin/announce_drop/$1';

$route['backend/spec_mailer_statistics']        = 'admin/index_admin/spec_mailer_statistics';
$route['backend/spec_mailer_statistics/(:num)'] = 'admin/index_admin/spec_mailer_statistics/$1';
$route['backend/(:any)']                        = 'admin/index_admin/show/$1';

////////////////////FRONTEND////////////////////////////
$route['service/(:num)/(:any)'] = 'service/show/$1';

$route['about'] = 'about/index';

$route['blog'] = 'blog/index';
$route['blog/page/(:num)'] = 'blog/index/$1';
$route['blog/topic/(:num)/(:any)'] = 'blog/topic/$1/$2';
$route['blog/topic/(:num)/(:any)/page/(:num)'] = 'blog/topic/$1/$2/$3';
$route['article/(:num)'] = 'blog/show/$1';

$route['review'] = 'review/index';

$route['shop'] = 'shop/index';
$route['shop/payment'] = 'shop/productPayment';
$route['shop/sale/(:num)/(:any)'] = 'shop/show/$1';

$route['gift/list'] = 'gift/ajaxGetGiftList';
$route['gift/subscribe'] = 'gift/ajaxGiftSubscribe';
$route['gift/finishsubscribe/(:num)/(:num)'] = 'gift/outputSubscribe/$1/$2';
$route['finishsubscribe/(:any)'] = 'gift/finishSubscribe/$1';
