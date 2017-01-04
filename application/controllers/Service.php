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

    public $topMenu = [];

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
//        $this->dataMenu = array('menu' => $this->arrMenu, 'current_url' => $this->urlArr[count($this->urlArr) - 1]);
        $contentArr     = $this->index_model->getNewsList();
        $title          = ArrayHelper::arrayGet($contentArr, '0.slug_title');
        $announcement   = $this->index_model->getFromTableByParams(['status' => STATUS_ON], 'announcement');

        $data = array();

        $this->twig->display('service/index.html', $data);
    }

    private function getTopLevelMenuList()
    {
        $menuIdList = MenuHelper::getTopLevelMenuIdList();

        return $this->menu_model->getMenuListByIdList($menuIdList);
    }

    public function show($id)
    {
        $data = ['title' => 'Service title'];

        $this->twig->display('service/show.html', $data);
    }
}