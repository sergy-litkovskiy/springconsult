<?php
/**
 * @author Litkovskiy
 * @copyright 2010
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Sale extends CI_Controller
{

    public $defaultDescription = 'SpringСonsulting - ваша возможность понять себя, реализовать свой потенциал, мечты, желания, цели! Профессиональная поддержка опытного коуча-консультанта и сопровождение в поисках ответов на жизненно важные вопросы, в поиске работы, в построении гармоничных отношений,  в достижении счастья и успеха';
    public $defaultKeywords = '';
    public $arrMenu = array();

    public function __construct()
    {
        parent::__construct();
        $this->arrMenu = $this->_prepareMenu();
        $this->urlArr  = explode('/', $_SERVER['REQUEST_URI']);
    }


    public function sale_show($slug)
    {
        $salePageArr = $this->sale_model->getSalePageArrWithProducts($slug);
        if (count($salePageArr) < 1) redirect('/index');
        $saleArr = array();

        foreach ($salePageArr as $salePage) {
            $saleArr['id']    = $salePage['id'];
            $saleArr['slug']  = $salePage['slug'];
            $saleArr['title'] = $salePage['title'];
            $saleArr['text1'] = $salePage['text1'];
            $saleArr['text2'] = $salePage['text2'];
            if ($salePage['sale_products_id']) {
                $saleArr['sale_products'][$salePage['sale_products_id']]['id']          = $salePage['sale_products_id'];
                $saleArr['sale_products'][$salePage['sale_products_id']]['title']       = $salePage['sale_products_title'];
                $saleArr['sale_products'][$salePage['sale_products_id']]['description'] = $salePage['sale_products_description'];
                $saleArr['sale_products'][$salePage['sale_products_id']]['price']       = $salePage['sale_products_price'];
            }
        }

        $title         = count($saleArr) > 0 ? $saleArr['title'] : 'sale page';
        $this->dataArr = array(
            'title'          => SITE_TITLE . ' - ' . $title
        , 'meta_keywords'    => $this->defaultDescription
        , 'meta_description' => $this->defaultKeywords
        , 'content'          => $saleArr
        , 'payment_form'     => $this->load->view('blocks/payment_form', '', true)
        );

        $data = array('content' => $this->load->view('index/show_sale', $this->dataArr, true));
        $this->load->view('layout_sale', $data);
    }


    public function ajax_payment_registration()
    {
        $recipientDataArr               = $saleHistoryArr = array();
        $recipientDataArr['name']       = trim(strip_tags($_REQUEST['name']));
        $recipientDataArr['email']      = trim(strip_tags($_REQUEST['email']));
        $recipientDataArr['created_at'] = date('Y-m-d H:i:s');
        $recipientDataArr['confirmed']  = STATUS_ON;

        $saleHistoryArr['created_at']       = date('Y-m-d H:i:s');
        $saleHistoryArr['sale_products_id'] = trim(strip_tags($_REQUEST['sale_products_id']));

        return $this->check_valid_payment_registration($recipientDataArr, $saleHistoryArr);
    }


    public function check_valid_payment_registration($recipientDataArr, $saleHistoryArr)
    {
        $recipient = $errLogData = array();

        try {
            $rules = $this->_prepareRulesSubscribeForm();
            $this->_checkValid($rules);

            $recipient                          = $this->index_model->getRecipientData($recipientDataArr);
            $saleHistoryArr['recipients_id']    = $recipient['id'];
            $saleHistoryArr['payment_state']    = '';
            $saleHistoryArr['payment_trans_id'] = '';
            $saleHistoryArr['payment_system']   = '';

            $saleHistoryId = $this->sale_model->addInTable($saleHistoryArr, 'sale_history');
            Common::assertTrue($saleHistoryId, "<p class='error'>К сожалению, при регистрации произошла ошибка.<br/>Пожалуйста, попробуйте еще раз</p>");

            $this->result["success"] = true;
            $this->result["data"]    = array('sale_history_id' => $saleHistoryId, 'recipients_id' => $recipient['id']);
        } catch (Exception $e) {
            $this->result['message'] = $e->getMessage();

            $errLogData['resource_id'] = ERROR_PAYMENT_REGISTRATION;
            $errLogData['text']        = $e->getMessage() . " - Продающая страница: " . $saleHistoryArr['sale_products_id'] . "(" . $recipientDataArr['name'] . " - " . $recipientDataArr['email'] . ")";
            $errLogData['created_at']  = date('Y-m-d H:i:s');
            $this->sale_model->addInTable($errLogData, 'error_log');
        }

        print json_encode($this->result);
        exit;
    }


    public function sale_payment($saleStatusId)
    {
        $paymentData = $paymentUpdateRules = array();
        list($paymentData, $paymentUpdateRules) = $this->_makePaymentDataFromRequest();
        $saleShopId = trim(strip_tags($_REQUEST['ik_shop_id']));
        try {
            Common::assertTrue($saleStatusId == SALESTATUSID, 'Sale status ID:' . $saleStatusId . ' is wrong');
            Common::assertTrue($saleShopId == SALESHOPID, 'Sale shop ID:' . $saleShopId . ' is wrong');
            Common::assertTrue(count($paymentData), 'Данных(paymentData) для апдейта не достаточно');
            Common::assertTrue(count($paymentUpdateRules), 'Данных(paymentUpdateRules) для апдейта не достаточно');

            $updateResult = $this->index_model->updateSaleHistoryByParams($paymentData, $paymentUpdateRules);
            Common::assertTrue($updateResult, "Sale history table was not updated by: id-" . $paymentUpdateRules['sale_history_id'] . '|sale_products_id-' . $paymentUpdateRules['sale_products_id'] . '|recipients_id-' . $paymentUpdateRules['recipients_id']);

            $this->_sendPaymentConfirmationLetter($paymentUpdateRules);

        } catch (Exception $e) {
            $errLogData['resource_id'] = ERROR_PAYMENT_CALLBACK;
            $errLogData['text']        = $e->getMessage() . " - Продающая страница: " . $paymentUpdateRules['sale_products_id'] . "(recipient#" . $paymentUpdateRules['recipients_id'] . ")";
            $errLogData['created_at']  = date('Y-m-d H:i:s');
            $this->sale_model->addInTable($errLogData, 'error_log');
        }
    }


    private function _makePaymentDataFromRequest()
    {
        $paymentData['payment_system']   = trim(strip_tags($_REQUEST['ik_paysystem_alias']));
        $paymentData['payment_state']    = trim(strip_tags($_REQUEST['ik_payment_state']));
        $paymentData['payment_trans_id'] = trim(strip_tags($_REQUEST['ik_trans_id']));
        $paymentData['payment_date']     = date('Y-m-d H:m:s', trim(strip_tags($_REQUEST['ik_payment_timestamp'])));

        $recipSaleIdArr                         = explode('|', trim(strip_tags($_REQUEST['ik_baggage_fields'])));
        $paymentUpdateRules['recipients_id']    = $recipSaleIdArr[0];
        $paymentUpdateRules['sale_history_id']  = $recipSaleIdArr[1];
        $paymentUpdateRules['sale_products_id'] = trim(strip_tags($_REQUEST['ik_payment_id']));

        return array($paymentData, $paymentUpdateRules);
    }


    private function _sendPaymentConfirmationLetter($paymentUpdateRules)
    {
        $saleProductLetterArr = $this->sale_model->getFromTableByParams(array('sale_products_id' => $paymentUpdateRules['sale_products_id']), "sale_products_letters");
        if (count($saleProductLetterArr)) {
            $recipientDataArr = $this->sale_model->getFromTableByParams(array('id' => $paymentUpdateRules['recipients_id']), "recipients");
            Common::assertTrue(count($recipientDataArr), "Any recipient was not found within: sale_history_id-" . $paymentUpdateRules['sale_history_id'] . '|sale_products_id-' . $paymentUpdateRules['sale_products_id'] . '|recipients_id-' . $paymentUpdateRules['recipients_id']);

            $isMailSent = $this->mailer_model->sendSaleMailerEmail($recipientDataArr[0], $saleProductLetterArr[0]);
            Common::assertTrue($isMailSent, "Payment confirmation letter was not send within: sale_history_id-" . $paymentUpdateRules['sale_history_id'] . '|sale_products_id-' . $paymentUpdateRules['sale_products_id'] . '|recipients_id-' . $paymentUpdateRules['recipients_id']);

            $data = $this->_makeSaleMailerHistoryData($recipientDataArr[0]['email'], $saleProductLetterArr[0]['id'], $paymentUpdateRules['sale_history_id']);
            $this->sale_model->addInTable($data, "sale_mailer_history");
        }
    }


    private function _makeSaleMailerHistoryData($email, $saleProductsLettersId, $saleHistoryId)
    {
        return array(
            "sale_history_id"          => $saleHistoryId,
            "sale_products_letters_id" => $saleProductsLettersId,
            "email"                    => $email,
            "created_at"               => date("Y-m-d H:i:s"));
    }


    public function success_sale()
    {
        $this->data_arr  = array(
            'title'          => SITE_TITLE . ' - успешная оплата услуг'
        , 'meta_keywords'    => $this->defaultDescription
        , 'meta_description' => $this->defaultKeywords
        , 'content'          => "сообщение"
        );
        $this->data_menu = array('menu'        => $this->arrMenu,
                                 'current_url' => $this->urlArr[count($this->urlArr) - 1]);

        $data = array('content' => $this->load->view('index/show_success_sale', $this->data_arr, true),
                      'menu'    => $this->load->view(MENU, $this->data_menu, true));
        $this->load->view('layout_sale', $data);
    }


    public function faild_sale()
    {
        Common::debugLogProd('faild_sale');
        Common::debugLogProd($_REQUEST);
        redirect('/index');
    }


    protected function _prepareRulesSubscribeForm()
    {
        return array(
            array(
                'field' => 'name',
                'label' => 'Name',
                'rules' => 'required|xss_clean'),
            array(
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'required|valid_email')
        );
    }


    protected function _checkValid($rules)
    {
        $isValid = $this->form_validation->set_rules($rules);
        Common::assertTrue($isValid, "<p class='error'>Форма заполнена неверно</p>");

        return true;
    }


    protected function _prepareMenu()
    {
        return $this->menu_model->childs;
    }


}