<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Review_admin extends CI_Controller
{
    public $emptyReviewList = array();
    public $message;
    public $result;
    public $urlArr;

    /** @var  Index_model */
    public $index_model;
    /** @var  Sale_model */
    public $sale_model;
    /** @var  Assign_model */
    public $assign_model;
    /** @var  Login_model */
    public $login_model;
    /** @var  Review_model */
    public $review_model;
    /** @var  Edit_menu_model */
    public $edit_menu_model;
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

        $this->emptyReviewList = array(
            'id'     => null,
            'author' => null,
            'image'  => null,
            'text'   => null,
            'status' => null,
            'date'   => null,
        );

        $this->result  = array("success" => null, "message" => null, "data" => null);
        $this->urlArr  = explode('/', $_SERVER['REQUEST_URI']);
        $this->message = null;
    }

    public function index()
    {
        $reviewListWithAssignedItems = $this->review_model->getReviewListWithAssignedItemsAdmin();
        $reviewsToAssignedItemsMap      = $this->_prepareReviewsWithAssignedItemsMap($reviewListWithAssignedItems);

        $contentData = array(
            'title'                => 'Springconsulting - admin',
            'reviewsToAssignedItemsMap' => $reviewsToAssignedItemsMap,
            'message'              => $this->message
        );

        $data = array(
            'menu'    => $this->load->view(MENU_ADMIN, '', true),
            'content' => $this->load->view('admin/reviews/show', $contentData, true));

        $this->load->view('layout_admin', $data);
    }

    private function _prepareReviewsWithAssignedItemsMap(array $reviewListWithProductList)
    {
        $map = array();

        foreach ($reviewListWithProductList as $reviewData) {
            $saleProductsId = ArrayHelper::arrayGet($reviewData, 'sale_products_id');
            $menuId = ArrayHelper::arrayGet($reviewData, 'menu_id');

            $map[ArrayHelper::arrayGet($reviewData, 'id')]['data']                = $reviewData;
            $map[ArrayHelper::arrayGet($reviewData, 'id')]['sale_product_list'][$saleProductsId] = $reviewData;
            $map[ArrayHelper::arrayGet($reviewData, 'id')]['menu_list'][$menuId] = $reviewData;
        }

        return $map;
    }

    public function edit($id = null)
    {
        $reviewData              = array();
        $assignedSaleProductList = array();
        $assignedMenuList = array();
        $title                   = "Добавить отзыв";

        $saleProductList = $this->sale_model->getListFromTable('sale_products');
        $menuList = $this->sale_model->getListFromTable('menu');

        if ($id) {
            $reviewData                  = $this->review_model->get($id);
            $assignedSaleProductDataList = $this->sale_model->getAssignedSaleProductListByReviewId($id);
            $assignedMenuDataList = $this->edit_menu_model->getAssignedMenuListByReviewId($id);

            foreach ($assignedSaleProductDataList as $assignedSaleProductData) {
                $saleProductsId = ArrayHelper::arrayGet($assignedSaleProductData, 'sale_products_id');
                $assignedSaleProductList[$saleProductsId] = $assignedSaleProductData;
            }

            foreach ($assignedMenuDataList as $assignedMenuData) {
                $menuId = ArrayHelper::arrayGet($assignedMenuData, 'id');
                $assignedMenuList[$menuId] = $assignedMenuData;
            }

            $title = "Редактировать reviews";
        }

        $content = ArrayHelper::arrayGet($reviewData, 0, $this->emptyReviewList);

        $url            = $this->index_model->prepareUrl($this->urlArr);
        $content['url'] = $url;

        $contentData = array(
            'title'                   => $title,
            'content'                 => $content,
            'menu_items'              => $this->edit_menu_model->childs,
            'assignedSaleProductList' => $assignedSaleProductList,
            'assignedMenuList' => $assignedMenuList,
            'saleProductList'         => $saleProductList,
            'menuList'         => $menuList,
            'message'                 => $this->message
        );

        $data = array(
            'menu'    => $this->load->view(MENU_ADMIN, '', true),
            'content' => $this->load->view('admin/reviews/edit', $contentData, true));

        $this->load->view('layout_admin', $data);
    }


    public function save()
    {
        $data = $params = array();
        $id   = ArrayHelper::arrayGet($_REQUEST, 'id');

        $assignedNewSaleProductIds = ArrayHelper::arrayGet($_REQUEST, 'new_sale_products_id', array());
        $assignedOldSaleProductIds = ArrayHelper::arrayGet($_REQUEST, 'old_sale_products_id', array());

        $assignedNewMenuIds = ArrayHelper::arrayGet($_REQUEST, 'new_menu_id', array());
        $assignedOldMenuIds = ArrayHelper::arrayGet($_REQUEST, 'old_menu_id', array());

        try {
            $data['author'] = ArrayHelper::arrayGet($_REQUEST, 'author');
            $data['text']   = trim(ArrayHelper::arrayGet($_REQUEST, 'text'));
            $data['image']  = ArrayHelper::arrayGet($_REQUEST, 'image');
            $data['date']   = ArrayHelper::arrayGet($_REQUEST, 'date', date('Y-m-d H:i:s'));

            if ($id) {
                $dataUpdate = array('status' => ArrayHelper::arrayGet($_REQUEST, 'status'));

                $data = array_merge($data, $dataUpdate);

                if ($assignedNewSaleProductIds) {
                    $dataToAssign = array(
                        'assignId'        => $id,
                        'assignFieldName' => 'reviews_id',
                        'sourceFieldName' => 'sale_products_id',
                        'table'           => 'sale_products_reviews_assignment'
                    );

                    $this->_assignProcess($assignedNewSaleProductIds, $assignedOldSaleProductIds, $dataToAssign);
                }

                if ($assignedNewMenuIds) {
                    $dataToAssign = array(
                        'assignId'        => $id,
                        'assignFieldName' => 'reviews_id',
                        'sourceFieldName' => 'menu_id',
                        'table'           => 'menu_reviews_assignment'
                    );

                    $this->_assignProcess($assignedNewMenuIds, $assignedOldMenuIds, $dataToAssign);
                }

                $this->_update($id, $data);
            } else {
                $dataAdd = array('status' => STATUS_ON);

                $data = array_merge($data, $dataAdd);

                $id = $this->review_model->add($data);
                Common::assertTrue($id, 'Форма заполнена неверно');

                if (count($assignedNewSaleProductIds)) {
                    $this->_assignProcess($assignedNewSaleProductIds, $assignedOldSaleProductIds, $id);
                }

                redirect('backend/review');
            }

        } catch (Exception $e) {
            $this->edit($id);
        }
    }

    private function _assignProcess(array $assignedNewIds, array $assignedOldIds, array $data)
    {
        $assignsArr = array_merge(
            $data, array(
                'newSourceIdArr'  => $assignedNewIds,
                'oldSourceIdArr'  => $assignedOldIds,
            )
        );

        $this->assign_model->setAssignArr($assignsArr);
        $this->assign_model->addOrDeleteAssigns();
    }

    private function _update($id, $data)
    {
        if ($this->review_model->update($id, $data)) {
            redirect('backend/review');
        } else {
            throw new Exception('Not updated');
        }
    }

    public function drop($id)
    {
        try {
            $this->review_model->del($id);
            $assignedSaleProductDataList = $this->sale_model->getAssignedSaleProductListByReviewId($id);

            if ($assignedSaleProductDataList) {
                foreach ($assignedSaleProductDataList as $assignedSaleProductsData) {
                    $this->review_model->delFromTable(
                        ArrayHelper::arrayGet($assignedSaleProductsData, 'sale_products_reviews_assignment_id'),
                        'sale_products_reviews_assignment'
                    );
                }
            }
            $this->result['success'] = true;
        } catch (Exception $e) {
            $this->result['message'] = $e->getMessage();
        }

        print json_encode($this->result);
        exit;
    }
}