<?php
/**
 * @author Litkovskiy
 * @copyright 2012
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Sale_admin extends CI_Controller
{
    public  $message;
    private $emptySalePageArr;
    private $emptySaleProductArr;
    private $urlArr = array();

    /** @var  Index_model */
    public $index_model;
    /** @var  Sale_model */
    public $sale_model;
    /** @var  Login_model */
    public $login_model;
    /** @var  SaleCategory_model */
    public $saleCategory_model;
    /** @var  Edit_menu_model */
    public $edit_menu_model;
    /** @var  Assign_model */
    public $assign_model;
    /** @var  CI_Form_validation */
    public $form_validation;
    /** @var  CI_Session */
    public $session;

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('username') && !$this->session->userdata('loggedIn')) {
            $this->login_model->logOut();
        }

        $this->emptySalePageArr = array(
            'id'           => null
            , 'title'      => null
            , 'slug'       => null
            , 'text1'      => null
            , 'text2'      => null
            , 'status'     => null
            , 'created_at' => null
        );

        $this->emptySaleProductArr = array(
            'id'             => null
            , 'title'        => null
            , 'label'        => null
            , 'description'  => null
            , 'price'        => null
            , 'gift'        => null
            , 'sale_page_id' => null
            , 'sale_page'    => array()
            , 'sequence_num' => null
            , 'status'       => null
            , 'image'        => null
            , 'created_at'   => null
        );

        $this->urlArr  = explode('/', $_SERVER['REQUEST_URI']);
        $this->message = null;
    }


////////////////////////////////SALE PAGE//////////////////////////
    public function sale_page_list()
    {
        $title       = "Продающие страницы";
        $salePageArr = $this->sale_model->getSalePageArrWithProductsAdmin();
        $saleArr     = array();

        foreach ($salePageArr as $salePage) {
            $saleArr[$salePage['id']]['id']                                                     = $salePage['id'];
            $saleArr[$salePage['id']]['slug']                                                   = $salePage['slug'];
            $saleArr[$salePage['id']]['title']                                                  = $salePage['title'];
            $saleArr[$salePage['id']]['text1']                                                  = $salePage['text1'];
            $saleArr[$salePage['id']]['text2']                                                  = $salePage['text2'];
            $saleArr[$salePage['id']]['status']                                                 = $salePage['status'];
            $saleArr[$salePage['id']]['created_at']                                             = $salePage['created_at'];
            $saleArr[$salePage['id']]['sale_products'][$salePage['sale_products_id']]['id']     = $salePage['sale_products_id'];
            $saleArr[$salePage['id']]['sale_products'][$salePage['sale_products_id']]['title']  = $salePage['sale_products_title'];
            $saleArr[$salePage['id']]['sale_products'][$salePage['sale_products_id']]['label']  = $salePage['sale_products_label'];
            $saleArr[$salePage['id']]['sale_products'][$salePage['sale_products_id']]['status'] = $salePage['sale_products_status'];
            $saleArr[$salePage['id']]['sale_products'][$salePage['sale_products_id']]['image']  = $salePage['sale_products_image'];
            $saleArr[$salePage['id']]['sale_products'][$salePage['sale_products_id']]['gift']  = $salePage['sale_products_gift'];
        }

        $contentData = array(
            'title'     => $title
            , 'content' => $saleArr
        );

        $data = array(
            'menu'    => $this->load->view(MENU_ADMIN, '', true),
            'content' => $this->load->view('admin/sale_page/show', $contentData, true));

        $this->load->view('layout_admin', $data);
    }


    public function sale_page_drop($id)
    {
        try {
            $this->index_model->delFromTable($id, 'sale_page');
            $assignSaleArr = $this->index_model->getFromTableByParams(array('sale_page_id' => $id), 'assign_sale');

            if (count($assignSaleArr)) {
                foreach ($assignSaleArr as $assignSale) {
                    $this->index_model->delFromTable($assignSale['id'], 'assign_sale');
                }
            }
            $result['success'] = true;
        } catch (Exception $e) {
            $result['message'] = $e->getMessage();
        }

        print json_encode($result);
        exit;
    }


    public function sale_page_edit($id = null)
    {
        $salePage = null;
        $title    = "Создать sale page";
        if ($id) {
            $salePage = $this->index_model->getFromTableByParams(array('id' => $id), 'sale_page');
            $title    = "Редактировать sale page";
        }

        $contentArr        = ArrayHelper::arrayGet($salePage, 0, $this->emptySalePageArr);
        $url               = $this->index_model->prepareUrl($this->urlArr);
        $contentArr['url'] = $url;

        $contentData = array(
            'title'        => $title
            , 'content'    => $contentArr
            , 'menu_items' => $this->edit_menu_model->childs
            , 'message'    => $this->message
        );

        $data = array(
            'menu'    => $this->load->view(MENU_ADMIN, '', true),
            'content' => $this->load->view('admin/sale_page/edit', $contentData, true));

        $this->load->view('layout_admin', $data);
    }


    public function sale_page_save()
    {
        $data = $params = array();
        $id   = ArrayHelper::arrayGet($_REQUEST, 'id');

        try {
            $this->_formSalePageValidation();
            $dataMain = array(
                'title' => ArrayHelper::arrayGet($_REQUEST, 'title'),
                'slug'  => ArrayHelper::arrayGet($_REQUEST, 'slug'),
                'text1' => ArrayHelper::arrayGet($_REQUEST, 'text1'),
                'text2' => ArrayHelper::arrayGet($_REQUEST, 'text2'),
                'image' => ArrayHelper::arrayGet($_REQUEST, 'image'),
            );

            if ($id) {
                $params['id'] = $id;
                $data         = array_merge($dataMain, array(
                        'created_at' => ArrayHelper::arrayGet($_REQUEST, 'created_at'),
                        'status'     => ArrayHelper::arrayGet($_REQUEST, 'status'))
                );
                $this->_updateSalePage($data, $params);
            } else {
                $data = array_merge($dataMain, array(
                    'created_at' => date('Y-m-d H:i:s')
                    , 'status'   => STATUS_ON));

                $this->_addSalePage($data);
            }
        } catch (Exception $e) {
            $this->message = $e->getMessage();
            $this->sale_page_edit($id);
        }
    }


    private function _formSalePageValidation()
    {
        $rules = array(
            array(
                'field' => 'slug',
                'label' => '<Alias названия>',
                'rules' => 'required'),
            array(
                'field' => 'title',
                'label' => '<Название>',
                'rules' => 'required'));

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
        $isUpdated = $this->index_model->updateInTable(ArrayHelper::arrayGet($params, 'id'), $data, 'sale_page');
        Common::assertTrue($isUpdated, 'Not updated');
        redirect('backend/sale_page_list');
    }

////////////////////////////////SALE PRODUCTS//////////////////////////
    public function sale_products_list()
    {
        $title                 = "Продукты для продажи";
        $saleProductsArr       = $this->sale_model->getSaleProductsArrWithProductsAdmin();
        $saleProductsLetterArr = $this->sale_model->getListFromTable('sale_products_letters');
        $saleArr               = $saleProductsLetterArrMap = array();
        foreach ($saleProductsLetterArr as $saleProductsLetter) {
            $saleProductsLetterArrMap[$saleProductsLetter['sale_products_id']] = $saleProductsLetter;
        }

        foreach ($saleProductsArr as $saleProducts) {
            $saleProductsId      = ArrayHelper::arrayGet($saleProducts, 'id');
            $saleProductsLetters = ArrayHelper::arrayGet($saleProductsLetterArrMap, $saleProductsId);

            $saleArr[$saleProducts['id']]['created_at']            = $saleProducts['created_at'];
            $saleArr[$saleProducts['id']]['id']                    = $saleProducts['id'];
            $saleArr[$saleProducts['id']]['title']                 = $saleProducts['title'];
            $saleArr[$saleProducts['id']]['label']                 = $saleProducts['label'];
            $saleArr[$saleProducts['id']]['price']                 = $saleProducts['price'];
            $saleArr[$saleProducts['id']]['gift']                 = $saleProducts['gift'];
            $saleArr[$saleProducts['id']]['description']           = $saleProducts['description'];
            $saleArr[$saleProducts['id']]['status']                = $saleProducts['status'];
            $saleArr[$saleProducts['id']]['image']                 = $saleProducts['image'];
            $saleArr[$saleProducts['id']]['sale_products_letters'] = $saleProductsLetters;

            if ($saleProducts['sale_page_id']) {
                $saleArr[$saleProducts['id']]['sale_page'][$saleProducts['sale_page_id']]['title']  = $saleProducts['sale_page_title'];
                $saleArr[$saleProducts['id']]['sale_page'][$saleProducts['sale_page_id']]['status'] = $saleProducts['sale_page_status'];
            }
        }

        $contentData = array(
            'title'                        => $title
            , 'content'                    => $saleArr
            , 'saleProductLetterContainer' => $this->load->view('admin/blocks/sale_product_letter_form', '', true)
        );

        $data = array(
            'menu'    => $this->load->view(MENU_ADMIN, '', true),
            'content' => $this->load->view('admin/sale_products/show', $contentData, true));

        $this->load->view('layout_admin', $data);
    }


    public function sale_products_drop($id)
    {
        $this->index_model->delFromTable($id, 'sale_products');
        $assignSaleArr = $this->index_model->getFromTableByParams(array('sale_products_id' => $id), 'assign_sale');

        if (count($assignSaleArr)) {
            foreach ($assignSaleArr as $assignSale) {
                $this->index_model->delFromTable(ArrayHelper::arrayGet($assignSale, 'id'), 'assign_sale');
            }
        }

        redirect('backend/sale_products_list');
    }


    public function sale_products_edit($id = null)
    {
        $saleProductArr = null;
        $title          = "Создать sale produst";

        if ($id) {
            $saleProductArr      = $this->sale_model->getSaleProductWithAssignedSalePageById($id);
            $title               = "Редактировать sale product";
            $assignedSalePageArr = array();
            foreach ($saleProductArr as $saleProduct) {
                $assignedSalePageArr[] = ArrayHelper::arrayGet($saleProduct, 'sale_page_id');
            }

            $saleProductArr[0]['sale_page'] = $assignedSalePageArr;
        }

        $salePageArr       = $this->index_model->getListFromTable('sale_page');
        $contentArr        = ArrayHelper::arrayGet($saleProductArr, 0, $this->emptySaleProductArr);
        $url               = $this->index_model->prepareUrl($this->urlArr);
        $contentArr['url'] = $url;

        $contentData = array(
            'title'         => $title
            , 'content'     => $contentArr
            , 'salePageArr' => $salePageArr
            , 'menu_items'  => $this->edit_menu_model->childs
            , 'message'     => $this->message
        );

        $data = array(
            'menu'    => $this->load->view(MENU_ADMIN, '', true),
            'content' => $this->load->view('admin/sale_products/edit', $contentData, true));

        $this->load->view('layout_admin', $data);
    }


    public function sale_products_save()
    {
        $data             = $params = array();
        $id               = ArrayHelper::arrayGet($_REQUEST, 'id');
        $newSalePageIdArr = ArrayHelper::arrayGet($_REQUEST, 'new_sale_page_id', array());
        $oldSalePageIdArr = ArrayHelper::arrayGet($_REQUEST, 'old_sale_page_id', array());

        try {
            $this->_formSaleProductsValidation();
            $dataMain = array(
                'title'       => ArrayHelper::arrayGet($_REQUEST, 'title'),
                'label'       => ArrayHelper::arrayGet($_REQUEST, 'label'),
                'description' => ArrayHelper::arrayGet($_REQUEST, 'description'),
                'price'       => ArrayHelper::arrayGet($_REQUEST, 'price'),
                'gift'       => ArrayHelper::arrayGet($_REQUEST, 'gift'),
                'image'       => ArrayHelper::arrayGet($_REQUEST, 'image'),
            );

            if ($id) {
                $params['id'] = $id;
                $data         = array_merge($dataMain, array(
                        'created_at'   => ArrayHelper::arrayGet($_REQUEST, 'created_at'),
                        'status'       => ArrayHelper::arrayGet($_REQUEST, 'status'),
                        'sequence_num' => ArrayHelper::arrayGet($_REQUEST, 'sequence_num')
                    )
                );

                $this->_assignProcess($newSalePageIdArr, $oldSalePageIdArr, $id);

                $this->_updateSaleProducts($data, $params);
            } else {
                $data = array_merge($dataMain, array(
                        'created_at'   => date('Y-m-d H:i:s'),
                        'status'       => STATUS_ON,
                        'sequence_num' => 0)
                );

                $id = $this->_addSaleProducts($data);
                if (count($newSalePageIdArr)) {
                    $this->_assignProcess($newSalePageIdArr, $oldSalePageIdArr, $id);
                }
                redirect('backend/sale_products_list');
            }
        } catch (Exception $e) {
            $this->message = $e->getMessage();
            $this->sale_products_edit($id);
        }
    }


    private function _assignProcess($newSalePageIdArr, $oldSalePageIdArr, $saleProductId)
    {
        $assignedArr = array(
            'newSourceIdArr'    => $newSalePageIdArr
            , 'oldSourceIdArr'  => $oldSalePageIdArr
            , 'assignId'        => $saleProductId
            , 'assignFieldName' => 'sale_products_id'
            , 'sourceFieldName' => 'sale_page_id'
            , 'table'           => 'assign_sale');

        $this->assign_model->setAssignArr($assignedArr);
        $this->assign_model->addOrDeleteAssigns();
    }


    private function _formSaleProductsValidation()
    {
        $rules = array(
            array(
                'field' => 'title',
                'label' => '<Название>',
                'rules' => 'required'));

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
        $isUpdated = $this->index_model->updateInTable(ArrayHelper::arrayGet($params, 'id'), $data, 'sale_products');
        Common::assertTrue($isUpdated, 'Not updated');
        redirect('backend/sale_products_list');
    }


    public function sale_products_statistic()
    {
        $i              = 0;
        $title          = "Статистика продаж";
        $saleHistoryArr = $this->sale_model->getSaleHistory();

        foreach ($saleHistoryArr as $saleHistory) {
            if ($saleHistory['payment_state']) {
                $i++;
            }
        }

        $contentData = array(
            'title'          => $title
            , 'content'      => $saleHistoryArr
            , 'successCount' => $i
        );

        $data = array(
            'menu'    => $this->load->view(MENU_ADMIN, '', true),
            'content' => $this->load->view('admin/sale_products/show_statistic', $contentData, true));

        $this->load->view('layout_admin', $data);
    }


    public function ajax_sale_products_letters_edit()
    {
        $id             = ArrayHelper::arrayGet($_REQUEST, 'id');
        $saleProductsId = ArrayHelper::arrayGet($_REQUEST, 'saleProductsId');

        try {
            Common::assertTrue($saleProductsId, 'Не установлен ID продукта');
            $data = array(
                'sale_products_id' => $saleProductsId,
                'text'             => ArrayHelper::arrayGet($_REQUEST, 'text'),
                'subject'          => ArrayHelper::arrayGet($_REQUEST, 'subject')
            );

            if ($id) {
                $result = $this->sale_model->updateInTable($id, $data, 'sale_products_letters');
            } else {
                $result = $this->sale_model->addInTable($data, 'sale_products_letters');
            }

            Common::assertTrue($result, 'Ошибка! Текст письма НЕ сохраненю. Попробуйте еще раз');

            $result['data']    = 'Текст письма успешно сохранен! <br>Можно идти грызть морковку:)';
            $result['success'] = true;
        } catch (Exception $e) {
            $result['message'] = $e->getMessage();
        }

        print json_encode($result);
        exit;
    }

    public function editNumber($id)
    {
        $sequenceNum = ArrayHelper::arrayGet($_REQUEST, 'sequence_num');
        $this->sale_model->update($id, ['sequence_num' => $sequenceNum]);

        redirect('backend/sale_category');
    }
}