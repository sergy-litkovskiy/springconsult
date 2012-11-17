<?php
/**
 * @author Litkovskiy
 * @copyright 2010
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller
    {

        public $data_arr   = array();

        function __construct()
    	{
    	   parent::__construct();
    	}
        
    	function index()
    	{
           $this->data_arr  = array('title' => 'Springconsult - admin');
           $data = array(
                    'content' => $this->load->view('admin/login/show', $this->data_arr, true));
    
    	   $this->load->view('layout_login', $data);
    	}

        public function ajax_login()
        {
            $data['login']    = isset($_REQUEST['log'])  ? trim(strip_tags($_REQUEST['log']))  : '';
            $data['pass']     = isset($_REQUEST['pass']) ? trim(strip_tags($_REQUEST['pass'])) : '';

            return $this->check_valid($data);
        }

	public function check_valid($data)
	{
            $rules = array(
                    array(
    		        'field'	=> 'log',
    		    	'label'	=> 'login',
    		    	'rules'	=> 'required'),
                    array(
    		        'field'	=> 'pass',
    		    	'label'	=> 'password',
    		    	'rules'	=> 'required')
                    );

            $this->form_validation->set_rules($rules);

            if ($this->form_validation->run() === false) {
                $this->index();
            }
            else {
                if($this->login_model->checkLogPass($data['login'], $data['pass'])){
                    print 'login_true';
                    exit;
                }
                else{
                    return false;
                }

            }
     }
}