<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ', 							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 					'ab');
define('FOPEN_READ_WRITE_CREATE', 				'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 			'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

/*
|--------------------------------------------------------------------------
| Constans for action message
|--------------------------------------------------------------------------
|
*/
define('MESS_SUCCESS', "<h2 class='mess_good'>The action is executed successfully!</h2>");
define('MESS_ERROR', "<h2 class='mess_bad'>The action was not executed. Please, try again.</h2>");

/*
|--------------------------------------------------------------------------
| Path for load menu
|--------------------------------------------------------------------------
|
*/
define('MENU', 'blocks/menu');
define('MENU_ADMIN', 'admin/blocks/menu_admin');

/*
|--------------------------------------------------------------------------
| Index for languages
|--------------------------------------------------------------------------
|
*/
define('LANGUAGE_ID_RU', '1');

/////////////////////////////////////////////////////////////

define('STATUS_ON', '1');
define('STATUS_OFF', '0');
define('ERROR_SRC_SPEC_MAILER', '1');
define('ERROR_SRC_ARTICLE_MAILER', '2');
define('ERROR_PAYMENT_REGISTRATION', '3');
define('ERROR_PAYMENT_CALLBACK', '4');
define('ALLOWED_UPLOAD_SIZE', 2111111);
define('ALLOWED_FORMAT', 'txt,doc,ppt,pps,pdf,docx,pptx,ppsx,pdfx,xls,xlsx,jpeg,jpg,gif,png,flw,swt');
define('ADMIN_EMAIL', 'spring@springconsult.com.ua');
define('SUPERADMIN_EMAIL', 'avdik77@mail.ru');
define('SITE_TITLE', 'Spring Consulting');
define('SALESTATUSID', '813A6CE48D37');
define('SALESHOPID', 'D13EFD96-A73E-4638-43CD-813A6CE48D37');
define('UNISENDERAPIKEY', '581woumrc4iedxpdtsahhsy8hxkfew5q8xpp8tyy');
define('UNISENDERMAINLISTID', 1237963);
define('UNISENDERTESTLISTID', 1238223);
/* End of file constants.php */
/* Location: ./system/application/config/constants.php */