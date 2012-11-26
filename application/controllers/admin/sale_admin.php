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
        $salePageArr        = $this->index_model->getListFromTable('sale_page');
        $saleProductsArr    = $this->index_model->getArrWhere('sale_products', array(), '', '' , 'sequence_num');

        foreach($salePageArr as $key => $salePage){
            foreach($saleProductsArr as $i => $saleProducts){
                if($saleProducts['sale_page_id'] == $salePage['id']){
                    $salePageArr[$key]['sale_products'][] = $saleProducts;
                }
            }
        }

        $this->data_arr     = array(
            'title'     => $title
            ,'content'  => $salePageArr
        );

        $data = array(
            'menu'    => $this->load->view(MENU_ADMIN, '', true),
            'content' => $this->load->view('admin/sale_page/show', $this->data_arr, true));

        $this->load->view('layout_admin', $data);
    }


    public function sale_page_drop($id)
    {
        $this->index_model->delFromTable($id, 'sale_page');
        redirect('backend/sale_page_list');
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
        $title           = "Продукты для продажи";
        $salePageArr     = $this->index_model->getListFromTable('sale_page');
        $saleProductsArr = $this->index_model->getListFromTable('sale_products');
//        $saleProductsArr = $this->index_model->getArrWhere('sale_products', array(), '', '' , 'sequence_num');

        foreach($saleProductsArr as $i => $saleProducts){
            foreach($salePageArr as $key => $salePage){
                if($saleProducts['sale_page_id'] == $salePage['id']){
                    $saleProductsArr[$i]['sale_page'] = $salePage['title'];
                }
            }
        }

        $this->data_arr     = array(
            'title'     => $title
            ,'content'  => $saleProductsArr
        );

        $data = array(
            'menu'    => $this->load->view(MENU_ADMIN, '', true),
            'content' => $this->load->view('admin/sale_products/show', $this->data_arr, true));

        $this->load->view('layout_admin', $data);
    }


    public function sale_products_drop($id)
    {
        $this->index_model->delFromTable($id, 'sale_products');
        redirect('backend/sale_products_list');
    }


    public function sale_products_edit($id = null)
    {
        $saleProduct  = null;
        $title        = "Создать sale produst";
        if($id){
            $saleProduct  = $this->index_model->getFromTableByParams(array('id' => $id), 'sale_products');
            $title        = "Редактировать sale product";
        }

        $salePageArr        = $this->index_model->getListFromTable('sale_page');
        $contentArr         = $saleProduct[0] ? $saleProduct[0] : $this->emptySaleProductArr;
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

        try{
            $this->_formSaleProductsValidation();
            $dataMain       = array(
                'title'             => $_REQUEST['title']
                ,'description'      => $_REQUEST['description']
                ,'price'            => $_REQUEST['price']
                ,'sale_page_id'     => $_REQUEST['sale_page_id']);

            if($id){
                $params['id']  = $id;
                $data          = array_merge($dataMain, array(
                    'created_at'    => $_REQUEST['created_at'],
                    'status'        => $_REQUEST['status'],
                    'sequence_num'  => $_REQUEST['sequence_num']));
                $this->_updateSaleProducts($data, $params);
            } else {
                $data = array_merge($dataMain, array(
                    'created_at'    => date('Y-m-d H:i:s'),
                    'status'        => STATUS_ON,
                    'sequence_num'  => 0));

                $this->_addSaleProducts($data);
            }
        } catch (Exception $e){
            $this->message = $e->getMessage();
            $this->sale_products_edit($id);
        }
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
        redirect('backend/sale_products_list');
    }


    private function _updateSaleProducts($data, $params)
    {
        $isUpdated = $this->index_model->updateInTable($params['id'], $data, 'sale_products');
        Common::assertTrue($isUpdated, 'Not updated');
        redirect('backend/sale_products_list');
    }
}