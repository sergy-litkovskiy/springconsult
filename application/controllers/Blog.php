<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends MY_Controller
{
    protected $entityName = 'blog';

    public function index($page = 0)
    {
        $mainData = $this->menu_model->getListByParams(['status' => STATUS_ON, 'id' => MENU_TOP_LEVEL_ID_BLOG]);
        $mainData = ArrayHelper::arrayGet($mainData, 0, []);
        $metaData = $this->prepareMetaData($mainData);

        $countTotal = $this->blog_model->getCountByParams(['status' => STATUS_ON]);

        //prepare pager config
        $config               = prepare_pager_config();
        $config['base_url']   = base_url() . $this->entityName . '/page/';
        $config['first_url']   = base_url() . $this->entityName;
        $config['total_rows'] = $countTotal;
        $this->pagination->initialize($config);

        $pager = $this->pagination->create_links();

        $page   = $page > 0 ? $page : 1;
        $offset = ArrayHelper::arrayGet($config, 'per_page', 0);
        $limit  = $offset * ($page - 1);

        $articleList = $this->blog_model->getListByParams(['status' => STATUS_ON], 'date', 'DESC', $limit, $offset);

        $topicList = $this->topic_model->getListByParams(['status' => STATUS_ON]);

        $data = [
            'currentItemName' => $this->entityName,
            'articleList'     => $articleList,
            'metaData'        => $metaData,
            'topicList'       => $topicList,
            'pager'           => $pager,
            'pageTitle'       => 'Блог'
        ];

        $data = array_merge($data, $this->baseResult);

        $this->twig->display($this->entityName . '/index.html', $data);
    }
}