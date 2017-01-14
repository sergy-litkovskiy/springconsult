<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends MY_Controller
{
    protected $entityName = 'blog';

    public function index($page = 1)
    {
        $metaData = $this->getMainData();

        $countTotal = $this->blog_model->getCountByParams(['status' => STATUS_ON]);

        $baseUrl = sprintf('%s%s', base_url(), $this->entityName);

        $pagerView = $this->preparePager($baseUrl, $countTotal);

        list($orderParams, $limitParams) = $this->makeSqlParams($page);

        $articleList = $this->blog_model->getListByParams(['status' => STATUS_ON], $orderParams, $limitParams);

        $topicList = $this->topic_model->getTopicListByParamsWithArticleCount(['status' => STATUS_ON]);

        $data = [
            'currentItemName' => $this->entityName,
            'articleList'     => $articleList,
            'metaData'        => $metaData,
            'topicList'       => $topicList,
            'pager'           => $pagerView,
            'pageTitle'       => 'Блог'
        ];

        $data = array_merge($data, $this->baseResult);

        $this->twig->display($this->entityName . '/index.html', $data);
    }

    public function topic($topicId, $page = 1)
    {
        $metaData = $this->getMainData();

        $countTotal = $this->blog_model->getCountArticlesForTopicByParams($topicId, ['status' => STATUS_ON]);

        $baseUrl = sprintf('%s%s/topic/%s', base_url(), $this->entityName, $topicId);

        $pagerView = $this->preparePager($baseUrl, $countTotal, 5);

        list($orderParams, $limitParams) = $this->makeSqlParams($page);

        $articleList = $this->blog_model->getArticlesForTopicByParams(
            $topicId,
            ['status' => STATUS_ON],
            $orderParams,
            $limitParams
        );

        $topicList = $this->topic_model->getTopicListByParamsWithArticleCount(['status' => STATUS_ON]);

        //remove current topic from the list
        $topicList = array_filter($topicList, function ($value) use ($topicId) {
            return ArrayHelper::arrayGet($value, 'id') != $topicId;
        });

        $data = [
            'currentItemName' => $this->entityName,
            'articleList'     => $articleList,
            'metaData'        => $metaData,
            'topicList'       => $topicList,
            'pager'           => $pagerView,
            'pageTitle'       => 'Блог'
        ];

        $data = array_merge($data, $this->baseResult);

        $this->twig->display($this->entityName . '/index.html', $data);
    }

    private function getMainData()
    {
        $mainData = $this->menu_model->getListByParams(['status' => STATUS_ON, 'id' => MENU_TOP_LEVEL_ID_BLOG]);
        $mainData = ArrayHelper::arrayGet($mainData, 0, []);

        return $this->prepareMetaData($mainData);
    }

    private function preparePager($baseUrl, $countTotal, $uriSegment = null)
    {
        //prepare pager config
        $config               = prepare_pager_config();
        $config['base_url']   = $baseUrl . '/page/';
        $config['first_url']   = $baseUrl;
        $config['total_rows'] = $countTotal;

        if ($uriSegment) {
            $config['uri_segment'] = $uriSegment;
        }

        $this->pagination->initialize($config);

        return $this->pagination->create_links();
    }

    private function makeSqlParams($page)
    {
        $limit = $this->pagination->per_page;
        $offset = $limit * ($page - 1);

        $orderParams = [
            'orderBy' => 'date',
            'orderDirection' => ORDER_DIRECTION_DESC
        ];

        $limitParams = [
            'limit' => $limit,
            'offset' => $offset
        ];

        return [$orderParams, $limitParams];
    }
}