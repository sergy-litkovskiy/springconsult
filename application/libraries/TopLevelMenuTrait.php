<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

trait TopLevelMenuTrait
{
    /** @var  Menu_model */
    public $menu_model;

    protected function getTopLevelMenuIdList()
    {
        return [
          MENU_TOP_LEVEL_ID_SERVICE,
          MENU_TOP_LEVEL_ID_ABOUT,
          MENU_TOP_LEVEL_ID_SHOP,
          MENU_TOP_LEVEL_ID_BLOG,
          MENU_TOP_LEVEL_ID_CONTACTS,
        ];
    }

    public function getTopLevelMenuList()
    {
        $menuIdList = $this->getTopLevelMenuIdList();

        return $this->menu_model->getMenuListByIdList($menuIdList);
    }

}