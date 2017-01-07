<?php
 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gift_model extends Crud
{

    public function __construct()
    {
        parent::__construct();

        $this->idkey = 'id';
        $this->table = 'subscribe';
    }
}