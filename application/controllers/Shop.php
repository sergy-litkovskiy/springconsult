<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Shop extends MY_Controller
{
    protected $entityName = 'shop';

    public function index()
    {
        $mainData = $this->menu_model->get(MENU_TOP_LEVEL_ID_SHOP);
        $mainData = ArrayHelper::arrayGet($mainData, 0, []);

        $metaData = $this->prepareMetaData($mainData);

        $categoryList     = $this->saleCategory_model->getCategoryListWithProductList();
        $saleCategoryList = $this->_makeMainDataToProductMap($categoryList, 'makeCategoryMainData');
        $data             = [
            'currentItemName'  => $this->entityName,
            'data'             => $mainData,
            'saleCategoryList' => $saleCategoryList,
            'metaData'         => $metaData,
            'pageTitle'        => 'Магазин'
        ];

        $data = array_merge($data, $this->baseResult);

        $this->twig->display($this->entityName . '/index.html', $data);
    }

    public function show($salePageId)
    {
        $salePageData = $this->salePage_model->getSalePageWithAssignedProducts($salePageId);
        $metaData     = $this->prepareMetaData(ArrayHelper::arrayGet($salePageData, 0, []));

        $salePageData = $this->_makeMainDataToProductMap($salePageData, 'makeSalePageMainData');

        $reviewList = $this->review_model->getReviewListBySalePageId($salePageId);;

        $data = [
            'currentItemName' => 'salePage',
            'metaData'        => $metaData,
            'reviewList'        => $reviewList,
            'data'            => ArrayHelper::arrayGet(array_values($salePageData), 0),
            'pageTitle'       => ArrayHelper::arrayGet($salePageData, '0.title')
        ];

        $data = array_merge($data, $this->baseResult);

        $this->twig->display($this->entityName . '/show.html', $data);
    }

    private function _makeMainDataToProductMap($dataList, $mainDataMethod)
    {
        $map = [];

        foreach ($dataList as $data) {
            $saleProductsId = ArrayHelper::arrayGet($data, 'sale_products_id');
            $mainDataId     = ArrayHelper::arrayGet($data, 'id');

            if (!ArrayHelper::arrayHas($map, $mainDataId)) {
                $map[$mainDataId]['data'] = $this->$mainDataMethod($data);
            }

            if (!$saleProductsId) {
                continue;
            }

            $map[$mainDataId]['productList'][$saleProductsId] =
                $saleProductsId
                    ? $this->makeProductsData($data)
                    : [];
        }

        return $map;
    }

    private function makeCategoryMainData(array $mainData)
    {
        return [
            'id'   => ArrayHelper::arrayGet($mainData, 'id'),
            'name' => ArrayHelper::arrayGet($mainData, 'name'),
        ];
    }

    private function makeSalePageMainData(array $mainData)
    {
        return [
            'id'    => ArrayHelper::arrayGet($mainData, 'id'),
            'title' => ArrayHelper::arrayGet($mainData, 'title'),
            'slug'  => ArrayHelper::arrayGet($mainData, 'slug'),
            'text1' => ArrayHelper::arrayGet($mainData, 'text1'),
            'text2' => ArrayHelper::arrayGet($mainData, 'text2'),
        ];
    }

    private function makeProductsData($categoryData)
    {
        return [
            'id'           => ArrayHelper::arrayGet($categoryData, 'sale_products_id'),
            'title'        => ArrayHelper::arrayGet($categoryData, 'sale_products_title'),
            'label'        => ArrayHelper::arrayGet($categoryData, 'sale_products_label'),
            'image'        => ArrayHelper::arrayGet($categoryData, 'sale_products_image'),
            'description'  => ArrayHelper::arrayGet($categoryData, 'sale_products_description'),
            'price'        => ArrayHelper::arrayGet($categoryData, 'sale_products_price'),
            'gift'        => ArrayHelper::arrayGet($categoryData, 'sale_products_gift'),
            'salePageSlug' => ArrayHelper::arrayGet($categoryData, 'sale_page_slug'),
            'salePageId'   => ArrayHelper::arrayGet($categoryData, 'sale_page_id'),
        ];
    }

    public function productPayment()
    {
        $recipientData = [
            'name'        => trim(strip_tags($this->input->post('name'))),
            'email'       => trim(strip_tags($this->input->post('email'))),
            'phone'       => trim(strip_tags($this->input->post('phone'))),
            'created_at'  => date('Y-m-d H:i:s'),
            'confirmed'   => STATUS_ON
        ];

        $extData = [
            'productId' => trim(strip_tags($this->input->post('productId'))),
            'price' => trim(strip_tags($this->input->post('price'))),
            'title' => trim(strip_tags($this->input->post('title'))),
        ];

        $saleHistoryData['created_at']       = date('Y-m-d H:i:s');
        $saleHistoryData['sale_products_id'] = trim(strip_tags($this->input->post('productId')));

        return $this->processPayment($recipientData, $saleHistoryData, $extData);
    }

    public function processPayment($recipientData, $saleHistoryData, $extData)
    {
        $result = ['success' => true, 'error' => false];
        $errLogData = [];

        try {
            //TODO: validate form fields
            $recipient = $this->recipient_model->getRecipientData($recipientData, true);

            $saleHistoryData['recipients_id'] = ArrayHelper::arrayGet($recipient, 'id');
            $saleHistoryData['payment_state'] = NULL;
            $saleHistoryData['payment_status'] = '';
            $saleHistoryData['payment_trans_id'] = '';
            $saleHistoryData['payment_message'] = '';

            $saleHistoryId = $this->saleHistory_model->add($saleHistoryData);
            Common::assertTrue(
                $saleHistoryId,
                'К сожалению, при регистрации произошла ошибка. Пожалуйста, попробуйте еще раз'
            );

            $mailData = array_merge($extData, $recipientData);
            $this->mailer_model->sendAdminSaleEmailMessage($mailData);
        } catch (Exception $e) {
            $result['error'] = true;
            $result['success'] = false;
            $result['message'] = $e->getMessage();

            $errLogData['resource_id'] = ERROR_PAYMENT_REGISTRATION;
            $errLogData['text'] = sprintf(
                '%s - Продающая страница: %s (%s - %s)',
                $e->getMessage(),
                ArrayHelper::arrayGet($saleHistoryData, 'sale_products_id'),
                ArrayHelper::arrayGet($recipientData, 'name'),
                ArrayHelper::arrayGet($recipientData, 'email')
            );

            $errLogData['created_at'] = date('Y-m-d H:i:s');
            $this->errorLog_model->add($errLogData);
        }

        print json_encode($result);
        exit;
    }
}