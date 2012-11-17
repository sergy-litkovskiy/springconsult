<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| AUTO-LOADER
| -------------------------------------------------------------------
| This file specifies which systems should be loaded by default.
|
| In order to keep the framework as light-weight as possible only the
| absolute minimal resources are loaded by default. For example,
| the database is not connected to automatically since no assumption
| is made regarding whether you intend to use it.  This file lets
| you globally define which systems you would like loaded with every
| request.
|
| -------------------------------------------------------------------
| Instructions
| -------------------------------------------------------------------
|
| These are the things you can load automatically:
|
| 1. Packages
| 2. Libraries
| 3. Helper files
| 4. Custom config files
| 5. Language files
| 6. Models
|
*/

/*
| -------------------------------------------------------------------
|  Auto-load Packges
| -------------------------------------------------------------------
| Prototype:
|
|  $autoload['packages'] = array(APPPATH.'third_party', '/usr/local/shared');
|
*/

$autoload['packages'] = array(APPPATH.'third_party');


/*
| -------------------------------------------------------------------
|  Auto-load Libraries
| -------------------------------------------------------------------
| These are the classes located in the system/libraries folder
| or in your application/libraries folder.
|
| Prototype:
|
|   $autoload['libraries'] = array('database', 'session', 'xmlrpc');
*/

$autoload['libraries'] = array('database'
                                , 'firephp'
                                , 'form_validation'
                                , 'fileloader'
                                , 'session'
                                , 'common'
                                , 'pagination'
                                , 'security'
                                , 'email');


/*
| -------------------------------------------------------------------
|  Auto-load Helper Files
| -------------------------------------------------------------------
| Prototype:
|
|   $autoload['helper'] = array('url', 'file');
*/

$autoload['helper'] = array('url'
                            ,'form'
                            ,'head_htm'
                            ,'head_htm_backend'
                            ,'tinymce'
                            ,'email'
                            ,'directory'
                            ,'text'
                            ,'cookie'
                            ,'date'
                            ,'pager'
                            ,'security'
                            ,'disqus'
                            ,'firephp'
                            ,'unisender_curl');



/*
| -------------------------------------------------------------------
|  Auto-load Config files
| -------------------------------------------------------------------
| Prototype:
|
|   $autoload['config'] = array('config1', 'config2');
|
| NOTE: This item is intended for use ONLY if you have created custom
| config files.  Otherwise, leave it blank.
|
*/

$autoload['config'] = array();


/*
| -------------------------------------------------------------------
|  Auto-load Language files
| -------------------------------------------------------------------
| Prototype:
|
|   $autoload['language'] = array('lang1', 'lang2');
|
| NOTE: Do not include the "_lang" part of your file.  For example 
| "codeigniter_lang.php" would be referenced as array('codeigniter');
|
*/

$autoload['language'] = array();


/*
| -------------------------------------------------------------------
|  Auto-load Models
| -------------------------------------------------------------------
| Prototype:
|
|   $autoload['model'] = array('model1', 'model2');
|
*/

$autoload['model'] = array('crud', 'index_model', 'edit_menu_model', 'menu_model',  'login_model');


/*
| -------------------------------------------------------------------
|  Auto-load Core Libraries
| -------------------------------------------------------------------
|
| DEPRECATED:  Use $autoload['libraries'] above instead.
|
*/
$autoload['core'] = array('firephp');



/* End of file autoload.php */
/* Location: ./application/config/autoload.php */