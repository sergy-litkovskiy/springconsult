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

    public function show($id)
    {
        $salePageData = $this->salePage_model->getSalePageWithAssignedProducts($id);
        $metaData    = $this->prepareMetaData(ArrayHelper::arrayGet($salePageData, 0, []));

        $salePageData  = $this->_makeMainDataToProductMap($salePageData, 'makeSalePageMainData');

        $data = [
            'metaData'            => $metaData,
            'salePageData'          => $salePageData,
            'pageTitle'           => ArrayHelper::arrayGet($salePageData, '0.title')
        ];

        $data = array_merge($data, $this->baseResult);

        $this->twig->display($this->entityName.'/show.html', $data);
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
            'id'   => ArrayHelper::arrayGet($mainData, 'id'),
            'title' => ArrayHelper::arrayGet($mainData, 'title'),
            'slug' => ArrayHelper::arrayGet($mainData, 'slug'),
            'text1' => ArrayHelper::arrayGet($mainData, 'text1'),
            'text2' => ArrayHelper::arrayGet($mainData, 'text2'),
        ];
    }

    private function makeProductsData($categoryData)
    {
        return [
            'id'          => ArrayHelper::arrayGet($categoryData, 'sale_products_id'),
            'title'       => ArrayHelper::arrayGet($categoryData, 'sale_products_title'),
            'thumb'       => ArrayHelper::arrayGet($categoryData, 'sale_products_thumb'),
            'description' => ArrayHelper::arrayGet($categoryData, 'sale_products_description'),
            'price'       => ArrayHelper::arrayGet($categoryData, 'sale_products_price'),
            'salePageSlug'       => ArrayHelper::arrayGet($categoryData, 'sale_page_slug'),
            'salePageId'       => ArrayHelper::arrayGet($categoryData, 'sale_page_id'),
        ];
    }
}