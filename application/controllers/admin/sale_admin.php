<?php
/**
 * @author Litkovskiy
 * @copyright 2012
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sale_admin extends CI_Controller
{
    public $message;
    private $emptySalePageArr;
    private $emptySaleProductArr;

    public function __construct()
    {
        parent::__construct();
        if(!$this->session->userdata('username') && !$this->session->userdata('loggedIn')){
            $this->login_model->logOut();
        }

        $this->emptySalePageArr = array(
            'id'                    => null
            ,'title'                => null
            ,'slug'                 => null
            ,'text1'                => null
            ,'text2'                => null
            ,'status'               => null
            ,'created_at'           => null);

        $this->emptySaleProductArr = array(
            'id'                    => null
            ,'title'                => null
            ,'description'          => null
            ,'price'                => null
            ,'sale_page_id'         => null
            ,'sale_page'            => array()
            ,'sequence_num'         => null
            ,'status'               => null
            ,'created_at'           => null);

        $this->urlArr = explode('/',$_SERVER['REQUEST_URI']);
        $this->message  = null;
    }


////////////////////////////////SALE PAGE//////////////////////////
    public function sale_page_list()
    {
        $title              = "Продающие страницы";
        $salePageArr = $this->sale_model->getSalePageArrWithProductsAdmin();
        $saleArr = array();

        foreach($salePageArr as $salePage){
            $saleArr[$salePage['id']]['id'] = $salePage['id'];
            $saleArr[$salePage['id']]['slug'] = $salePage['slug'];
            $saleArr[$salePage['id']]['title'] = $salePage['title'];
            $saleArr[$salePage['id']]['text1'] = $salePage['text1'];
            $saleArr[$salePage['id']]['text2'] = $salePage['text2'];
            $saleArr[$salePage['id']]['status'] = $salePage['status'];
            $saleArr[$salePage['id']]['created_at'] = $salePage['created_at'];
            $saleArr[$salePage['id']]['sale_products'][$salePage['sale_products_id']]['id'] = $salePage['sale_products_id'];
            $saleArr[$salePage['id']]['sale_products'][$salePage['sale_products_id']]['title'] = $salePage['sale_products_title'];
            $saleArr[$salePage['id']]['sale_products'][$salePage['sale_products_id']]['status'] = $salePage['sale_products_status'];
        }

        $this->data_arr     = array(
            'title'     => $title
            ,'content'  => $saleArr
        );

        $data = array(
            'menu'    => $this->load->view(MENU_ADMIN, '', true),
            'content' => $this->load->view('admin/sale_page/show', $this->data_arr, true));

        $this->load->view('layout_admin', $data);
    }


    public function sale_page_drop($id)
    {
        try{
            $this->index_model->delFromTable($id, 'sale_page');
            $assignSaleArr = $this->index_model->getFromTableByParams(array('sale_page_id' => $id), 'assign_sale');

            if(count($assignSaleArr)){
                foreach($assignSaleArr as $assignSale){
                    $this->index_model->delFromTable($assignSale['id'], 'assign_sale');
                }
            }
            $this->result['success'] = true;
        } catch (Exception $e){
            $this->result['message'] = $e->getMessage();
        }

        print json_encode($this->result);
        exit;
    }


    public function sale_page_edit($id = null)
    {
        $salePage  = null;
        $title        = "Создать sale page";
        if($id){
            $salePage  = $this->index_model->getFromTableByParams(array('id' => $id), 'sale_page');
            $title     = "Редактировать sale page";
        }

        $contentArr         = $salePage[0] ? $salePage[0] : $this->emptySalePageArr;
        $url                = $this->index_model->prepareUrl($this->urlArr);
        $contentArr['url']  = $url;

        $this->data_arr     = array(
             'title'            => $title
            ,'content'          => $contentArr
            ,'menu_items'       => $this->edit_menu_model->childs
            ,'message'          => $this->message
            );

        $data = array(
            'menu'    => $this->load->view(MENU_ADMIN, '', true),
            'content' => $this->load->view('admin/sale_page/edit', $this->data_arr, true));

        $this->load->view('layout_admin', $data);
    }


    public function check_valid_sale_page()
    {
        $data           = $params = array();
        $id             = isset($_REQUEST['id']) && $_REQUEST['id'] ? $_REQUEST['id'] : null;

        try{
            $this->_formSalePageValidation();
            $dataMain       = array(
                'title'     => $_REQUEST['title']
                ,'slug'     => $_REQUEST['slug']
                ,'text1'    => $_REQUEST['text1']
                ,'text2'    => $_REQUEST['text2']);

            if($id){
                $params['id']  = $id;
                $data          = array_merge($dataMain, array(
                    'created_at'    => $_REQUEST['created_at'],
                    'status'        => $_REQUEST['status']));
                $this->_updateSalePage($data, $params);
            } else {
                $data = array_merge($dataMain, array(
                    'created_at'    => date('Y-m-d H:i:s')
                    ,'status'       => STATUS_ON));

                $this->_addSalePage($data);
            }
        } catch (Exception $e){
            $this->message = $e->getMessage();
            $this->sale_page_edit($id);
        }
    }


    private function _formSalePageValidation()
    {
        $rules = array(
            array(
                'field'	=> 'slug',
                'label'	=> '<Alias названия>',
                'rules'	=> 'required'),
            array(
                'field'	=> 'title',
                'label'	=> '<Название>',
                'rules'	=> 'required'));

        $this->form_validation->set_rules($rules);

        $isValid = $this->form_validation->run();
        Common::assertTrue($isValid, 'Форма заполнена неверно');
    }


    private function _addSalePage($data)
    {
        $id = $this->index_model->addInTable($data, 'sale_page');
        Common::assertTrue($id, 'Информация не добавлена в базу');
        redirect('backend/sale_page_list');
    }


    private function _updateSalePage($data, $params)
    {
        $isUpdated = $this->index_model->updateInTable($params['id'], $data, 'sale_page');
        Common::assertTrue($isUpdated, 'Not updated');
        redirect('backend/sale_page_list');
    }

////////////////////////////////SALE PRODUCTS//////////////////////////
    public function sale_products_list()
    {
        $title                  = "Продукты для продажи";
        $saleProductsArr        = $this->sale_model->getSaleProductsArrWithProductsAdmin();
        $saleProductsLetterArr  = $this->sale_model->getListFromTable('sale_products_letters');
        $saleArr = $saleProductsLetterArrMaped = array();
        foreach($saleProductsLetterArr as $saleProductsLetter){
            $saleProductsLetterArrMaped[$saleProductsLetter['sale_products_id']] = $saleProductsLetter;
        }

        foreach($saleProductsArr as $saleProducts){
            $saleProductsLetters = isset($saleProductsLetterArrMaped[$saleProducts['id']])
                                    ? $saleProductsLetterArrMaped[$saleProducts['id']] : null;
            $saleArr[$saleProducts['id']]['created_at']   = $saleProducts['created_at'];
            $saleArr[$saleProducts['id']]['id']           = $saleProducts['id'];
            $saleArr[$saleProducts['id']]['title']        = $saleProducts['title'];
            $saleArr[$saleProducts['id']]['price']        = $saleProducts['price'];
            $saleArr[$saleProducts['id']]['description']  = $saleProducts['description'];
            $saleArr[$saleProducts['id']]['status']       = $saleProducts['status'];
            $saleArr[$saleProducts['id']]['sale_products_letters'] = $saleProductsLetters;
            if($saleProducts['sale_page_id']){
                $saleArr[$saleProducts['id']]['sale_page'][$saleProducts['sale_page_id']]['title'] = $saleProducts['sale_page_title'];
                $saleArr[$saleProducts['id']]['sale_page'][$saleProducts['sale_page_id']]['status'] = $saleProducts['sale_page_status'];
            }
        }

        $this->data_arr     = array(
            'title'     => $title
            ,'content'  => $saleArr
            ,'saleProductLetterContainer' => $this->load->view('admin/blocks/sale_product_letter_form', '', true)
        );

        $data = array(
            'menu'    => $this->load->view(MENU_ADMIN, '', true),
            'content' => $this->load->view('admin/sale_products/show', $this->data_arr, true));

        $this->load->view('layout_admin', $data);
    }


    public function sale_products_drop($id)
    {
        $this->index_model->delFromTable($id, 'sale_products');
        $assignSaleArr = $this->index_model->getFromTableByParams(array('sale_products_id' => $id), 'assign_sale');

        if(count($assignSaleArr)){
            foreach($assignSaleArr as $assignSale){
                $this->index_model->delFromTable($assignSale['id'], 'assign_sale');
            }
        }
        redirect('backend/sale_products_list');
    }


    public function sale_products_edit($id = null)
    {
        $saleProductArr  = null;
        $title        = "Создать sale produst";
        if($id){
            $saleProductArr  = $this->sale_model->getSaleProductWithAssignedSalePageById($id);
            $title        = "Редактировать sale product";
            $assignedSalePageArr = array();
            foreach($saleProductArr as $saleProduct){
                $assignedSalePageArr[] = $saleProduct['sale_page_id'];
            }

            $saleProductArr[0]['sale_page'] = $assignedSalePageArr;
        }

        $salePageArr        = $this->index_model->getListFromTable('sale_page');
        $contentArr         = $saleProductArr[0] ? $saleProductArr[0] : $this->emptySaleProductArr;
        $url                = $this->index_model->prepareUrl($this->urlArr);
        $contentArr['url']  = $url;

        $this->data_arr     = array(
             'title'            => $title
            ,'content'          => $contentArr
            ,'salePageArr'      => $salePageArr
            ,'menu_items'       => $this->edit_menu_model->childs
            ,'message'          => $this->message
            );

        $data = array(
            'menu'    => $this->load->view(MENU_ADMIN, '', true),
            'content' => $this->load->view('admin/sale_products/edit', $this->data_arr, true));

        $this->load->view('layout_admin', $data);
    }


    public function check_valid_sale_products()
    {
        $data           = $params = array();
        $id             = isset($_REQUEST['id']) && $_REQUEST['id'] ? $_REQUEST['id'] : null;
        $newSalePageIdArr = isset($_REQUEST['new_sale_page_id']) && $_REQUEST['new_sale_page_id'] ? $_REQUEST['new_sale_page_id'] : array();
        $oldSalePageIdArr = isset($_REQUEST['old_sale_page_id']) && $_REQUEST['old_sale_page_id'] ? $_REQUEST['old_sale_page_id'] : array();

        try{
            $this->_formSaleProductsValidation();
            $dataMain       = array(
                'title'             => $_REQUEST['title']
                ,'description'      => $_REQUEST['description']
                ,'price'            => $_REQUEST['price']);

            if($id){
                $params['id']  = $id;
                $data          = array_merge($dataMain, array(
                    'created_at'    => $_REQUEST['created_at'],
                    'status'        => $_REQUEST['status'],
                    'sequence_num'  => $_REQUEST['sequence_num']));
//                if(count($newSalePageIdArr)){
                    $this->_assignProcess($newSalePageIdArr, $oldSalePageIdArr, $id);
//                }

                $this->_updateSaleProducts($data, $params);
            } else {
                $data = array_merge($dataMain, array(
                    'created_at'    => date('Y-m-d H:i:s'),
                    'status'        => STATUS_ON,
                    'sequence_num'  => 0));

                $id = $this->_addSaleProducts($data);
                if(count($newSalePageIdArr)){
                    $this->_assignProcess($newSalePageIdArr, $oldSalePageIdArr, $id);
                }
                redirect('backend/sale_products_list');
            }
        } catch (Exception $e){
            $this->message = $e->getMessage();
            $this->sale_products_edit($id);
        }
    }


    private function _assignProcess($newSalePageIdArr, $oldSalePageIdArr, $saleProductid)
    {
        $this->assignsArr = array(
            'newSourceIdArr'    => $newSalePageIdArr
            , 'oldSourceIdArr'  => $oldSalePageIdArr
            , 'assignId'        => $saleProductid
            , 'assignFieldName' => 'sale_products_id'
            , 'sourceFieldName' => 'sale_page_id'
            , 'table'           => 'assign_sale');

        $this->assign_model->setAssignArr($this->assignsArr);
        $this->assign_model->addOrDeleteAssigns();
    }


    private function _formSaleProductsValidation()
    {
        $rules = array(
            array(
                'field'	=> 'title',
                'label'	=> '<Название>',
                'rules'	=> 'required'));

        $this->form_validation->set_rules($rules);

        $isValid = $this->form_validation->run();
        Common::assertTrue($isValid, 'Форма заполнена неверно');
    }


    private function _addSaleProducts($data)
    {
        $id = $this->index_model->addInTable($data, 'sale_products');
        Common::assertTrue($id, 'Информация не добавлена в базу');
        return $id;
    }


    private function _updateSaleProducts($data, $params)
    {
        $isUpdated = $this->index_model->updateInTable($params['id'], $data, 'sale_products');
        Common::assertTrue($isUpdated, 'Not updated');
        redirect('backend/sale_products_list');
    }


    public function sale_products_statistic()
    {
        $i = 0;
        $title          = "Статистика продаж";
        $saleHistoryArr    = $this->sale_model->getSaleHistory();
        foreach($saleHistoryArr as $saleHistory){
            if($saleHistory['payment_state']){
                $i++;
            }
        }
        $this->data_arr     = array(
            'title'         => $title
            ,'content'      => $saleHistoryArr
            ,'successCount' => $i
        );

        $data = array(
            'menu'    => $this->load->view(MENU_ADMIN, '', true),
            'content' => $this->load->view('admin/sale_products/show_statistic', $this->data_arr, true));

        $this->load->view('layout_admin', $data);
    }


    public function ajax_sale_products_letters_edit()
    {
        $id             = $_REQUEST['id'] ? $_REQUEST['id'] : null;
        $saleProductsId = $_REQUEST['saleProductsId'] ? $_REQUEST['saleProductsId'] : null;
        try{
            Common::assertTrue($saleProductsId, 'Не установлен ID продукта');
            $data = array(
                'sale_products_id'  => $saleProductsId,
                'text'              => $_REQUEST['text'],
                'subject'           => $_REQUEST['subject']);

            if($id){
                $result = $this->sale_model->updateInTable($id, $data, 'sale_products_letters');
            } else {
                $result = $this->sale_model->addInTable($data, 'sale_products_letters');
            }

            Common::assertTrue($result, 'Ошибка! Текст письма НЕ сохраненю. Попробуйте еще раз');

            $this->result['data']       = 'Текст письма успешно сохранен! <br>Можно идти грызть морковку:)';
            $this->result['success']    = true;
        } catch (Exception $e){
            $this->result['message']    = $e->getMessage();
        }

        print json_encode($this->result);
        exit;
    }

}