<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Gift extends MY_Controller
{
    /** @var Gift_model */
    public $gift_model;

    public function ajax_get_gift_list()
    {
        $giftList = $this->gift_model->getListByParams(['status' => STATUS_ON, 'is_top' => 1]);

        print ['data' => $giftList];
        exit;
    }
}