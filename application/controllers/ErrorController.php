<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ErrorController extends MY_Controller
{
    public function index()
    {
//        $mainServiceData = $this->menu_model->get(MENU_TOP_LEVEL_ID_SERVICE);
//        $metaData        = $this->prepareMetaData(ArrayHelper::arrayGet($mainServiceData, 0, []));

        $data = [
//            'metaData'  => $metaData,
            'pageTitle' => 'Not found'
        ];

        $data = array_merge($data, $this->baseResult);

        $this->twig->display('error/index.html', $data);
    }
}