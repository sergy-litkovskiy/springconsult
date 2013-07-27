<?php

/**
 * @author Litkovskiy
 * @copyright 2010
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function head_htm()
	{
		$CI =& get_instance();
		
		$code = $CI->load->view ('helpers/head_htm','',TRUE);
		
		return $code; 
    }

?>