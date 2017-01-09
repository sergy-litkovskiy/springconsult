<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Service extends MY_Controller
{
    protected $entityName = 'service';

    public function index()
    {
        $serviceList         = $this->menu_model->getMenuListWithReviewsByParentId(MENU_TOP_LEVEL_ID_SERVICE);
        $mainServiceData     = $this->menu_model->get(MENU_TOP_LEVEL_ID_SERVICE);
        $metaData            = $this->prepareMetaData(ArrayHelper::arrayGet($mainServiceData, 0, []));
        $serviceToReviewsMap = $this->makeServiceToReviewsMap($serviceList);

        $data = [
            'serviceToReviewsMap' => $serviceToReviewsMap,
            'metaData'            => $metaData,
            'pageTitle'           => 'Услуги'
        ];

        $data = array_merge($data, $this->baseResult);

        $this->twig->display($this->entityName.'/index.html', $data);
    }

    public function show($id)
    {
        $serviceData = $this->menu_model->getListByParams(['id' => $id, 'status' => STATUS_ON]);
        $metaData    = $this->prepareMetaData(ArrayHelper::arrayGet($serviceData, 0, []));

        $reviewList  = $this->menu_model->getReviewListByMenuId($id);
        $serviceList = $this->menu_model->getMenuListByParentId(MENU_TOP_LEVEL_ID_SERVICE);
        $articleList = $this->menu_model->getArticleListByMenuId($id, ASSIGNED_ARTICLE_LIST_LIMIT);

        //remove current item from available service list
        $serviceList = array_filter($serviceList, function ($val) use ($id) {
            return $val['id'] != $id;
        });

        $data = [
            'metaData'            => $metaData,
            'data'                => ArrayHelper::arrayGet($serviceData, 0),
            'reviewList'          => $reviewList,
            'serviceList'         => $serviceList,
            'articleList'         => $articleList,
            'pageTitle'           => ArrayHelper::arrayGet($serviceData, '0.title')
        ];

        $data = array_merge($data, $this->baseResult);

        $this->twig->display($this->entityName.'/show.html', $data);
    }

    private function makeServiceToReviewsMap($serviceList)
    {
        $map = [];

        foreach ($serviceList as $serviceData) {
            $reviewsId = ArrayHelper::arrayGet($serviceData, 'reviews_id');
            $menuId    = ArrayHelper::arrayGet($serviceData, 'id');

            $map[$menuId]                           = $this->makeMainData($serviceData);
            $map[$menuId]['reviewList'][$reviewsId] = $reviewsId ? $this->makeReviewsData($serviceData) : [];
        }

        return $map;
    }

    private function makeMainData(array $serviceData)
    {
        return [
            'id'          => ArrayHelper::arrayGet($serviceData, 'id'),
            'title'       => ArrayHelper::arrayGet($serviceData, 'title'),
            'text'        => ArrayHelper::arrayGet($serviceData, 'text'),
            'description' => ArrayHelper::arrayGet($serviceData, 'description'),
            'color_class' => ArrayHelper::arrayGet($serviceData, 'color_class'),
            'icon_class'  => ArrayHelper::arrayGet($serviceData, 'icon_class'),
        ];
    }

    private function makeReviewsData($serviceData)
    {
        return [
            'id'     => ArrayHelper::arrayGet($serviceData, 'reviews_id'),
            'author' => ArrayHelper::arrayGet($serviceData, 'reviews_author'),
            'text'   => ArrayHelper::arrayGet($serviceData, 'reviews_text'),
            'image'  => ArrayHelper::arrayGet($serviceData, 'reviews_image'),
        ];
    }
}