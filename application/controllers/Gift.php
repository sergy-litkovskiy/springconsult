<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Gift extends MY_Controller
{
    /** @var Gift_model */
    public $gift_model;

//    public function ajax_get_gift_list()
    public function ajaxGetGiftList()
    {
        $giftList = $this->gift_model->getListByParams(['status' => STATUS_ON, 'is_top' => 1]);
$giftList = [['giftName' => 'giftName', 'giftDescription' => 'giftDescription', 'giftId' => 'giftId', 'giftImage' => 'my_book_print.jpg']];
        print json_encode(['data' => $giftList]);
        exit;
    }

    public function ajaxGiftSubscribe()
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);

        } catch (Exception $e) {
            print json_encode(['success' => false, 'error' => $e->getMessage()]);
            exit;
        }

        print json_encode(['success' => true, 'data' => ['username' => ArrayHelper::arrayGet($data, 'userName'), 'email' => ArrayHelper::arrayGet($data, 'email')]]);
        exit;
    }
}