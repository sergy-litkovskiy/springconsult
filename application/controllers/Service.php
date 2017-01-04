<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Service extends CI_Controller
{
    /** @var  Index_model */
    public $index_model;
    /** @var  Menu_model */
    public $menu_model;
    /** @var  Mailer_model */
    public $mailer_model;
    /** @var  CI_Pagination */
    public $pagination;
    /** @var  Tags_model */
    public $tags_model;
    /** @var  CI_Form_validation */
    public $form_validation;
    /** @var  Twig */
    public $twig;
    public $topLevelMenuList = [];

    public $topMenu = [];

    public function __construct()
    {
        parent::__construct();
        $this->topLevelMenuList = $this->menu_model->getTopLevelMenuList();
    }

    public function index()
    {
        $metaData = $this->getMetaDataForPage($this->topLevelMenuList, MENU_TOP_LEVEL_ID_SERVICE);
        $serviceList = $this->menu_model->getMenuListWithReviewsByParentId(MENU_TOP_LEVEL_ID_SERVICE);
        $serviceToReviewsMap = $this->makeServiceToReviewsMap($serviceList);

        $data = [
            'topLevelMenuList' => $this->topLevelMenuList,
            'serviceToReviewsMap' => $serviceToReviewsMap,
            'metaData' => $metaData
        ];

        $this->twig->display('service/index.html', $data);
    }

    public function show($id)
    {
        $menuData = $this->menu_model->getArrWhere('menu', ['id' => $id, 'status' => STATUS_ON], null);
        $reviewList = $this->menu_model->getReviewListByMenuId($id);
        $serviceList = $this->menu_model->getMenuListByParentId(MENU_TOP_LEVEL_ID_SERVICE);
        $articleList = $this->menu_model->getArticleListByMenuId($id, ASSIGNED_ARTICLE_LIST_LIMIT);

        //remove current item from available service list
        $serviceList = array_filter($serviceList, function ($val, $key) use ($id) {
            return $val['id'] != $id;
        });

        $data = [
            'currentMenuId' => $id,
            'topLevelMenuList' => $this->topLevelMenuList,
            'metaData' => $this->prepareMetaData(ArrayHelper::arrayGet($menuData, 0, [])),
            'data' => ArrayHelper::arrayGet($menuData, 0),
            'reviewList' => $reviewList,
            'serviceList' => $serviceList,
            'articleList' => $articleList
        ];

        $this->twig->display('service/show.html', $data);
    }

    private function getMetaDataForPage($topLevelMenuList, $menuId)
    {
        $metaData = [];

        foreach ($topLevelMenuList as $menuData) {
            if (ArrayHelper::arrayGet($menuData, 'id') != $menuId) {
                continue;
            }

            $metaData = $this->prepareMetaData($menuData);

            break;
        }

        return $metaData;
    }

    private function prepareMetaData($data)
    {
        $metaData = [];

        $metaData['metaDescription'] = ArrayHelper::arrayGet($data, 'meta_description');
        $metaData['metaKeywords'] = ArrayHelper::arrayGet($data, 'meta_keywords');
        $metaData['fbTitle'] = sprintf('%s - %s', SITE_TITLE, ArrayHelper::arrayGet($data, 'title'));
        $metaData['fbImg'] = ImageHelper::getFirstImgFromText(
            ArrayHelper::arrayGet($data, 'text'),
            DEFAULT_FB_IMAGE
        );

        return $metaData;
    }

    private function makeServiceToReviewsMap($serviceList)
    {
        $map = [];

        foreach ($serviceList as $serviceData) {
            $map[ArrayHelper::arrayGet($serviceData, 'id')] = $serviceData;
        }

        return $map;
    }
}