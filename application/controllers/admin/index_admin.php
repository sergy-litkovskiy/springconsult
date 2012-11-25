<?php
/**
 * @author Litkovskiy
 * @copyright 2010
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index_admin extends CI_Controller
{
    public $arrMenu             = array();
    public $emptyArticleArr     = array();
    public $subscribe           = array();
    public $emptyAforizmusArr   = array();
    public $landingPageArr      = array();
    public $defaultDescription  = '';
    public $defaultKeywords     = '';
    public $message;

    public function __construct()
    {
       parent::__construct();

       if(!$this->session->userdata('username') && !$this->session->userdata('loggedIn')){
           $this->login_model->logOut();
       }
       $this->message          = null;
       $this->arrMenu          = $this->_prepareMenu();
//       $this->result           = array("success" => null, "error" => null, "popup" => null, "data" => null);
       $this->result           = array("success" => null, "message" => null, "data" => null);
       $this->emptyArticleArr  = array(
                        'id'                => null
                       ,'slug'              => null
                       ,'text'              => null
                       ,'title'             => null
                       ,'num_sequence'      => null
                       ,'status'            => null
                       ,'meta_description'  => null
                       ,'meta_keywords'     => null
                       ,'is_sent_mail'      => null
                       ,'date'              => date('Y-m-d')
                       ,'time'              => date('H:i:s'));

       $this->emptyMaterialsArr  = array(
                        'id'                => null
                       ,'rus_name'          => null
                       ,'file_path'         => null
                       ,'num_sequence'      => null
                       ,'status'            => null);

       $this->assignsArr   = array(
                        'assignMenuIdArr'      => null
                       ,'oldAssignMenuIdArr'   => null
                       ,'id'                   => null
                       ,'assignFieldName'      => null
                       ,'table'                => null);

       $this->subscribeArr   = array(
                        'id'               => null
                       ,'subscribe_name'   => null
                       ,'description'      => null
                       ,'img_path'         => null
                       ,'material_path'    => null
                       ,'status'           => null);

        $this->emptyAforizmusArr   = array(
                        'id'       => null
                       ,'author'   => null
                       ,'text'     => null);
        
        $this->landingPageArr = array( 
                            'id'                    => null
                            ,'unique'               => null
                            ,'title'                => null
                            ,'title_description'    => null
                            ,'page_text'            => null
                            ,'letter_text'          => null
                            ,'status'               => null
                            ,'created_at'           => null
                            ,'updated_at'           => null);    
        
        $this->landingArticleArr = array( 
                            'id'                    => null
                            ,'title'                => null
                            ,'slug'                 => null
                            ,'text'                 => null
                            ,'landing_page_id'      => null
                            ,'password_mp3'         => null
                            ,'link_mp3'             => null
                            ,'status'               => null
                            ,'created_at'           => null); 
        
        $this->emptySalePageArr = array( 
                            'id'                    => null
                            ,'title'                => null
                            ,'slug'                 => null
                            ,'text1'                => null
                            ,'text2'                => null
                            ,'status'               => null
                            ,'created_at'           => null);
        
        $this->emptySaleProductArr = array( 
                            'id'                    => null
                            ,'title'                => null
                            ,'description'          => null
                            ,'price'                => null
                            ,'sale_page_id'         => null
                            ,'sequence_num'         => null
                            ,'status'               => null
                            ,'created_at'           => null);
        
       $this->urlArr = explode('/',$_SERVER['REQUEST_URI']);
    }



    public function index()
    {
       $contentAndAssignArr = array();
       $this->data_menu     = array('menu' => $this->arrMenu);
       $contentArr          = $this->index_model->getNewsListAdmin();
       $landingsArr         = $this->index_model->getFromTableByParams(array('status' => STATUS_ON),'landing_page');
       $contentAndAssignArr = $this->_prepareContentAndAssignsArr($contentArr);

       $this->data_arr      = array(
             'title'         	=> 'Springconsulting - admin'
            ,'content'       	=> $contentAndAssignArr['content']
            ,'assigns'       	=> $contentAndAssignArr['assigns']
            ,'message'          => $this->message
            ,'specMailerContainer'    => $this->load->view('admin/blocks/spec_mailer_form', array('landings' => $landingsArr), true)
       );

       $data = array(
                'menu'          => $this->load->view(MENU_ADMIN, $this->data_menu, true),
                'content'       => $this->load->view('admin/index_admin/show', $this->data_arr, true));

       $this->load->view('layout_admin', $data);
    }



    public function show($slug)
    {
       $this->data_menu      = array('menu' => $this->arrMenu);
       $contentArr           = $this->index_model->getContent($slug);

       $this->data_arr       = array(
             'title'            => 'Springconsult - edit '.$slug
            ,'content'          => $contentArr
            ,'message'          => $this->message
       );
       
       $data = array(
                'menu'    => $this->load->view(MENU_ADMIN, $this->data_menu, true),
                'content' => $this->load->view('admin/index_admin/edit', $this->data_arr, true));

       $this->load->view('layout_admin', $data);
    }
    
////////////////////////////////ARTICLES//////////////////////////
    public function article_edit($id = null)
    {
        $contentItems   = array(0);
        $assignArticles = $assignTagArr = array();
        $title          = "Добавить статью";
        if($id){
            $contentItems   = $this->index_model->getDetailContentAdmin($id);
            $assignArtArr   = $this->index_model->getAssignArticlesByArticleIdAdmin($id);
            $assignTagArr   = $this->index_model->getAssignTagArr($id, 'articles_tag', 'articles_id');
            
            foreach($assignArtArr as $assignArt){
                $assignArticles[$assignArt['articles_id']][] = $assignArt['menu_id'];
            }
            if($assignArticles){
                $assignArticles = $assignArticles[$id];
            }
            $title          = "Редактировать статью";
        }

        $contentArr         = $contentItems[0] ? $contentItems[0] : $this->emptyArticleArr;
        $url                = $this->_prepareUrl($this->urlArr);
        $contentArr['url']  = $url;

        $this->data_arr     = array(
             'title'            => $title
            ,'content'          => $contentArr
            ,'menu_items'       => $this->arrMenu
            ,'assign_articles'  => $assignArticles
            ,'assign_tag_arr'   => $assignTagArr
            ,'message'          => $this->message
        );

        $data = array(
                'menu'    => $this->load->view(MENU_ADMIN, '', true),
                'content' => $this->load->view('admin/index_admin/edit', $this->data_arr, true));

        $this->load->view('layout_admin', $data);
    }

    

    public function check_valid_article()
    {
        $data = $params = $assignMenuIdArr = $oldAssignMenuId = array();
        $id                 = isset($_REQUEST['id']) && $_REQUEST['id'] ? $_REQUEST['id'] : null;
        $assignMenuIdArr    = isset($_REQUEST['menu']) && $_REQUEST['menu'] ? $_REQUEST['menu'] : array() ;
        $oldAssignMenuId    = isset($_REQUEST['old_assign_id']) && $_REQUEST['old_assign_id'] ? $_REQUEST['old_assign_id'] : array();
        $arrArticlesTag     = json_decode($_REQUEST['json_encode_tag_arr']);  

        try{
            $this->_formValidation();
            $data = $this->_prepareArticleDataForAddUpdate($_REQUEST);

            if($id){
                $params ['id']  = $id;
                $dataUpdate = array('num_sequence'    => $_REQUEST['num_sequence']
                                    ,'status'         => $_REQUEST['status']
                                    ,'is_sent_mail'   => $_REQUEST['is_sent_mail']);
                $data = array_merge($data, $dataUpdate);
                $this->assignsArr = array(
                     'assignMenuIdArr'      => $assignMenuIdArr
                   , 'oldAssignMenuIdArr'   => $oldAssignMenuId
                   , 'id'                   => $id
                   , 'assignFieldName'      => 'articles_id'
                   , 'table'                => 'assign_articles');
                $this->_addOrDeleteAssigns();
                $this->index_model->tagProcess($arrArticlesTag, $id, 'articles_tag', 'articles_id');
                
                $this->_update($data, $params);
            } else {
                $dataAdd = array('num_sequence'    => '0'
                                ,'status'          => STATUS_ON
                                ,'is_sent_mail'    => '0');
                $data = array_merge($data, $dataAdd);

                $id = $this->_add($data);
                Common::assertTrue($id, 'Форма заполнена неверно');

                $this->assignsArr = array(
                     'assignMenuIdArr'      => $assignMenuIdArr
                   , 'oldAssignMenuIdArr'   => $oldAssignMenuId
                   , 'id'                   => $id
                   , 'assignFieldName'      => 'articles_id'
                   , 'table'                => 'assign_articles');
                $this->_addOrDeleteAssigns();
                $this->index_model->tagProcess($arrArticlesTag, $id, 'articles_tag', 'articles_id');
                
                redirect('backend/news');
            }
            
        } catch (Exception $e){
            $this->article_edit($id);
        }
    }



    private function _formValidation()
    {
        $rules = $this->_prepareArticleValidationRules();
        $this->form_validation->set_rules($rules);

        $isValid = $this->form_validation->run();
        Common::assertTrue($isValid, 'Форма заполнена неверно');
    }



    private function _prepareArticleValidationRules()
    {
        return array(
    		    	array(
    		        'field'	=> 'title',
    		    	'label'	=> '<Название раздела>',
    		    	'rules'	=> 'required')
                    ,array(
    		        'field'	=> 'slug',
    		    	'label'	=> '<Алиас раздела>',
    		    	'rules'	=> 'required')
                    ,array(
    		        'field'	=> 'text',
    		    	'label'	=> '<Текст>',
    		    	'rules'	=> 'required')
                    ,array(
    		        'field'	=> 'date',
    		    	'label'	=> '<Дата>',
    		    	'rules'	=> 'required'));
    }



    private function _prepareArticleDataForAddUpdate($request)
    {
        return array('meta_description' => $request['meta_description']
                    ,'meta_keywords'    => $request['meta_keywords']
                    ,'title'            => $request['title']
                    ,'slug'             => $request['slug']
                    ,'text'             => $request['text']
                    ,'date'             => isset($request['date']) ? $request['date'] : date('Y-m-d')
                    ,'time'             => isset($request['time']) ? $request['time'] : date('H:i:s'));
    }
    
    
    
    public function ajax_send_article_to_subscribers($articleId)
    {
        $errLogData = array();
        try{
//            $this->index_model->db->trans_begin();
            
            $articlesArr    = $this->index_model->getDetailContent($articleId);
            $articleDetail  = count($articlesArr) ? $articlesArr[0] : null;
            Common::assertTrue($articleDetail, 'Ошибка! Нет данных по запрашиваемой статье');
            
            $recipientsArr = $this->index_model->getNlSubscribers();
            Common::assertTrue(count($recipientsArr), 'Не найден ни один подписчик для отправки');
            
//            $sentMailCounter = $this->_sendNlSubscribe($recipientsArr, $articleDetail);
//            Common::assertTrue($sentMailCounter > 0, 'Ошибка! Не было отправлено ни одного письма');
            $this->_unisenderCreateEmailMessage($articleDetail);
            
            $isUpdated = $this->_updateArticleStatusIsMailSent($articleDetail['id']);
            Common::assertTrue($isUpdated, 'Ошибка! Статус сатьи не был изменен на is mail sent');

//            $this->index_model->db->trans_commit();
        } catch (Exception $e){
//            $this->index_model->db->trans_rollback();
            $this->result['message'] = $e->getMessage();
            
            $errLogData['resource_id']  = ERROR_SRC_ARTICLE_MAILER;
            $errLogData['text']         = $e->getMessage()." - Название статьи: ".$articleDetail['title'];
            $errLogData['created_at']   = date('Y-m-d H:i:s');
            $this->index_model->addInTable($errLogData, 'error_log');            
        }

        print json_encode($this->result);
        exit;
    }
    
    
    
//    private function _sendNlSubscribe($recipientsArr, $articleDetail)
//    {
//        $sentMailCounter = 0;
//         foreach($recipientsArr as $recipient){
//             try{
//                $unsubscribeLink = $this->index_model->unsubscribeHashProcess($recipient['id']);
//                Common::assertTrue($unsubscribeLink, 'Ошибка! Не был сформирован url для отказа от подписки');
//
//                $data = array('articles_id'    => $articleDetail['id']
//                            ,'recipients_id'   => $recipient['id']
//                            ,'date'            => date('Y-m-d')
//                            ,'time'            => date('H:i:s'));
//                                
//                $historyId = $this->index_model->addInTable($data, 'articles_subscribe_mail_history');
//                Common::assertTrue($historyId, 'Ошибка! Не произошла запись в articles_subscribe_mail_history');
//
//                $isSent = $this->mailer_model->sendArticlesSubscribedEmail($recipient, $articleDetail, $unsubscribeLink);
//                Common::assertTrue($isSent, 'Ошибка! Письмо для подписчика '.$recipient['name'].' ('.$recipient['email'].') не было отправлено');
//
//                $sentMailCounter++;
//            } catch (Exception $e){
//                $errLogData['resource_id']  = ERROR_SRC_ARTICLE_MAILER;
//                $errLogData['text']         = $e->getMessage()." - Название статьи: ".$articleDetail['title'];
//                $errLogData['created_at']   = date('Y-m-d H:i:s');
//                $this->index_model->addInTable($errLogData, 'error_log');
//            }
//         }
//         
//         return $sentMailCounter;
//    }
    
    
    
    private function _unisenderCreateEmailMessage($articleDetail)
    {
        $jsonObj = null;
        $postArr = array (
            'api_key'       => UNISENDERAPIKEY,
            'sender_name'   => SITE_TITLE,
            'sender_email'  => ADMIN_EMAIL,
            'subject'       => "Новая статья на сайте Spring Сonsulting",
            'wrap_type'     => 'left',
            'list_id'       => UNISENDERMAINLISTID,
            'body'          => $this->mailer_model->getUnisenderSubscribeEmailTpl($articleDetail)
        );

        $result = startCurlExec($postArr, 'http://api.unisender.com/ru/api/createEmailMessage?format=json');   
        Common::assertTrue($result, 'Ошибка! Unisender API(createEmailMessage) не отвечает!');

        $jsonObj = json_decode($result);
        Common::assertTrue($jsonObj, 'Ошибка! API(createEmailMessage) Invalid JSON');

        if((isset($jsonObj->error) && is_object($jsonObj->error)) && (isset($jsonObj->code) && is_object($jsonObj->code))){
            throw new Exception("An error occured: " . @$jsonObj->error . "(code: " . @$jsonObj->code . ")");    
        } else {
            $this->_unusenderCreateCampaign($jsonObj->result->message_id);
        }
    }
    
    
    
    private function _unusenderCreateCampaign($messageId)
    {
        $postArr = array (
            'api_key'       => UNISENDERAPIKEY,
            'message_id'    => $messageId,
            'track_read'    => '0',
            'track_links'   => '0'
        );

        $result = startCurlExec($postArr, 'http://api.unisender.com/ru/api/createCampaign?format=json');   
        Common::assertTrue($result, 'Ошибка! Unisender API(createCampaign) не отвечает!');

        $jsonObj = json_decode($result);
        Common::assertTrue($jsonObj, 'Ошибка! API(createCampaign) Invalid JSON');   
        
        if((isset($jsonObj->error) && is_object($jsonObj->error)) && (isset($jsonObj->code) && is_object($jsonObj->code))){
            throw new Exception("An error occured: " . @$jsonObj->error . "(code: " . @$jsonObj->code . ")");    
        } else {
            $this->result['success'] = "Рассылка на Unisender<br> запущена успешно со статусом: " . $jsonObj->result->status."!";
        }       
    }
    
    
    
    private function _updateArticleStatusIsMailSent($articleId)
    {
        return $this->index_model->updateInTable($articleId, array('is_sent_mail' => STATUS_ON), 'articles');
    }
    
        
////////////////////////////////MATERIALS//////////////////////////
    public function material_list()
    {
       $this->data_menu     = array('menu' => $this->arrMenu);
       $contentArr          = $this->index_model->getMaterialListAdmin();
       $contentAndAssignArr = $this->_prepareContentAndAssignsArr($contentArr);

       $this->data_arr      = array(
             'title'         	=> 'Springconsulting - admin'
            ,'content'       	=> $contentAndAssignArr['content']
            ,'assigns'       	=> $contentAndAssignArr['assigns']
            ,'message'          => $this->message
       );

       $data = array(
                'menu'          => $this->load->view(MENU_ADMIN, $this->data_menu, true),
                'content'       => $this->load->view('admin/material/show', $this->data_arr, true));

       $this->load->view('layout_admin', $data);

    }



    public function material_edit($id = null)
    {
        $materials          = array(0);
        $assignMaterials    = array();
        $title              = "Добавить статью";
        if($id){
            $materials   = $this->index_model->getMaterialDetailsAdmin($id);
            $assignMaterialsArr   = $this->index_model->getAssignMaterialsByMaterialIdAdmin($id);
            foreach($assignMaterialsArr as $assignArt){
                $assignMaterials[$assignArt['materials_id']][] = $assignArt['menu_id'];
            }
            if($assignMaterials){
                $assignMaterials = $assignMaterials[$id];
            }
            $title          = "Редактировать материал";
        }
        $assignTagArr       = $this->index_model->getAssignTagArr($id, 'materials_tag', 'materials_id');
        $contentArr         = $materials[0] ? $materials[0] : $this->emptyMaterialsArr;
        $url                = $this->_prepareUrl($this->urlArr);
        $contentArr['url']  = $url;

        $this->data_arr     = array(
             'title'            => $title
            ,'content'          => $contentArr
            ,'menu_items'       => $this->arrMenu
            ,'assign_materials' => $assignMaterials
            ,'assign_tag_arr'   => $assignTagArr
            ,'message'          => $this->message
        );

        $data = array(
                'menu'    => $this->load->view(MENU_ADMIN, '', true),
                'content' => $this->load->view('admin/material/edit', $this->data_arr, true));

        $this->load->view('layout_admin', $data);
    }
    


    public function check_valid_materials()
    {
        $fileName       = null;
        $uploadPath     = './materials/';
        $data           = $params = array();
        $id             = isset($_REQUEST['id']) && $_REQUEST['id'] ? $_REQUEST['id'] : null;
        $arrAssignedTag = json_decode($_REQUEST['json_encode_tag_arr']);

        try{
            if($_FILES['file_path']['size'] > 0){
                $fileName = $this->_tryUploadFile($_FILES['file_path'], $uploadPath);
            }

            $assignMenuIdArr = isset($_REQUEST['menu']) && $_REQUEST['menu'] ? $_REQUEST['menu'] : array() ;
            $oldAssignMenuId = isset($_REQUEST['old_assign_id']) && $_REQUEST['old_assign_id'] ? $_REQUEST['old_assign_id'] : array();

            if($id){
                $this->_formMaterialsValidation();
                $params ['id']  = $id;
                $dataUpdate = array('rus_name'          => $_REQUEST['rus_name']
                                    ,'num_sequence'     => $_REQUEST['num_sequence']
                                    ,'status'           => $_REQUEST['status']);

                $data = $fileName ? array_merge(array('file_path' => $fileName), $dataUpdate) : $dataUpdate;
                $this->assignsArr = array(
                     'assignMenuIdArr'      => $assignMenuIdArr
                   , 'oldAssignMenuIdArr'   => $oldAssignMenuId
                   , 'id'                   => $id
                   , 'assignFieldName'      => 'materials_id'
                   , 'table'                => 'assign_materials');

                $this->_addOrDeleteAssigns();
                $this->index_model->tagProcess($arrAssignedTag, $id, 'materials_tag', 'materials_id');
                $this->_updateMaterials($data, $params);
            } else {
                $this->_formMaterialsValidation();
                Common::assertTrue($fileName, 'Форма заполнена неверно');
                
                $data = array('rus_name'         => $_REQUEST['rus_name']
                              ,'num_sequence'    => '0'
                              ,'status'          => STATUS_ON
                              ,'file_path'       => $fileName);

                $id = $this->_addMaterials($data);
                Common::assertTrue($id, 'Форма заполнена неверно');

                $this->assignsArr = array(
                     'assignMenuIdArr'      => $assignMenuIdArr
                   , 'oldAssignMenuIdArr'   => $oldAssignMenuId
                   , 'id'                   => $id
                   , 'assignFieldName'      => 'materials_id'
                   , 'table'                => 'assign_materials');

                $this->_addOrDeleteAssigns();
                $this->index_model->tagProcess($arrAssignedTag, $id, 'materials_tag', 'materials_id');
                redirect('backend/material');
            }
        } catch (Exception $e){
            $this->message = $e->getMessage();
            $this->material_edit($id);
        }
    }



    private function _formMaterialsValidation()
    {
        $rules = array(
    		    	array(
    		        'field'	=> 'rus_name',
    		    	'label'	=> '<Название>',
    		    	'rules'	=> 'required'));
        $this->form_validation->set_rules($rules);

        $isValid = $this->form_validation->run();
        Common::assertTrue($isValid, 'Форма заполнена неверно');
    }



    public function material_drop()
    {
        return $this->_dropWithFile('materials');
    }



    private function _addMaterials($data)
    {
        return $this->index_model->addInTable($data, 'materials');
    }

    

    private function _updateMaterials($data, $params)
    {
        $isUpdated = $this->index_model->updateInTable($params['id'], $data, 'materials');
        Common::assertTrue($isUpdated, 'Not updated');
        if(isset($params['file']) && $params['file']){
            unlink('./materials/'.$params['file']);
        }
        redirect('backend/material');
    }
    
////////////////////////SUBSCRIBE////////////////////////////////
    public function subscribe_list()
    {
       $this->data_menu     = array('menu' => $this->arrMenu);
       $contentArr          = $this->index_model->getSubscribeListAdmin();
       $this->data_arr      = array(
             'title'         	=> 'Springconsulting - admin'
            ,'content'       	=> $contentArr
            ,'message'          => $this->message
       );

       $data = array(
                'menu'          => $this->load->view(MENU_ADMIN, $this->data_menu, true),
                'content'       => $this->load->view('admin/subscribe/show', $this->data_arr, true));

       $this->load->view('layout_admin', $data);

    }



    public function subscribe_edit($id = null)
    {
        $subscribes   = array(0);
        $title        = "Добавить продукт";
        if($id){
            $subscribes  = $this->index_model->getSubscribeListAdmin($id);
            $title       = "Редактировать бесплатный продукт";
        }

        $contentArr         = $subscribes[0] ? $subscribes[0] : $this->subscribeArr;
        $url                = $this->_prepareUrl($this->urlArr);
        $contentArr['url']  = $url;

        $this->data_arr     = array(
             'title'            => $title
            ,'content'          => $contentArr
            ,'menu_items'       => $this->arrMenu
            ,'message'          => $this->message
        );

        $data = array(
                'menu'    => $this->load->view(MENU_ADMIN, '', true),
                'content' => $this->load->view('admin/subscribe/edit', $this->data_arr, true));

        $this->load->view('layout_admin', $data);
    }



    public function check_valid_subscribe()
    {
        $data = $params = array();
        $fileName = $materialName = null;
        $imgUploadPath      = './subscribe/';
//        $materialUploadPath = './subscribegift/';
        $id                 = isset($_REQUEST['id']) && $_REQUEST['id'] ? $_REQUEST['id'] : null;

        try{
            if($_FILES['img_path']['size'] > 0){
                $fileName = $this->_tryUploadFile($_FILES['img_path'], $imgUploadPath);
            }
            //if($_FILES['material_path']['size'] > 0){
//                $materialName = $this->_tryUploadFile($_FILES['material_path'], $materialUploadPath);
//            }

            $validationRules = $this->_prepareRulesSubscribeValidation();
            $this->_formSubscribeValidation($validationRules);
            if($id){
                //$this->_formSubscribeValidation($validationRules);
                $params ['id']  = $id;
                $dataUpdate = array('subscribe_name'   => $_REQUEST['subscribe_name']
                                    ,'description'     => $_REQUEST['description']
                                    ,'status'          => $_REQUEST['status']
                                    ,'material_path'   => $_REQUEST['material_path']);

                $data = $fileName ? array_merge(array('img_path' => $fileName), $dataUpdate) : $dataUpdate;
                $params['img_file'] = $fileName && $_REQUEST['old_img_path'] ? $_REQUEST['old_img_path'] : null;

               // $data = $materialName ? array_merge(array('material_path' => $materialName), $data) : $data;
//                $params['material_file'] = $materialName && $_REQUEST['old_material_path'] ? $_REQUEST['old_material_path'] : null;
                
                $this->_updateSubscribe($data, $params);
            } else {
                Common::assertTrue($fileName, 'Не загружена картинка');
                //Common::assertTrue($materialName, 'Не загружен материал');
                               
                $data = array('subscribe_name'   => $_REQUEST['subscribe_name']
                              ,'description'     => $_REQUEST['description']
                              ,'status'          => STATUS_ON
                              ,'img_path'        => $fileName
                              ,'material_path'   => $_REQUEST['material_path']);

                $id = $this->_addSubscribe($data);
                Common::assertTrue($id, 'Форма заполнена неверно');

                redirect('backend/subscribe');
            }
        } catch (Exception $e){
            $this->message = $e->getMessage();
            $this->subscribe_edit($id);
        }
    }



    private function _formSubscribeValidation($rules)
    {
        $this->form_validation->set_rules($rules);

        $isValid = $this->form_validation->run();
        Common::assertTrue($isValid, 'Форма заполнена неверно');
    }


    
    private function _prepareRulesSubscribeValidation()
    {
        return array(
                    array(
    		        'field'	=> 'subscribe_name',
    		    	'label'	=> '<Название продукта>',
    		    	'rules'	=> 'required'),
                    array(
    		        'field'	=> 'description',
    		    	'label'	=> '<Описание>',
    		    	'rules'	=> 'required'),
                    array(
                    'field'	=> 'material_path',
                    'label'	=> '<Материал>',
                    'rules'	=> 'required'));
    }



    //private function _prepareRulesSubscribeValidationForAdd()
//    {
//        return array(
//                    array('field'	=> 'material_path',
//                          'label'	=> '<Материал>',
//                          'rules'	=> 'required'));
//    }
    


    private function _addSubscribe($data)
    {
        return $this->index_model->addInTable($data, 'subscribe');
    }



    private function _updateSubscribe($data, $params)
    {
        $isUpdated = $this->index_model->updateInTable($params['id'], $data, 'subscribe');
        Common::assertTrue($isUpdated, 'Not updated');
        if(isset($params['img_file']) && $params['img_file']){
            unlink('./subscribe/'.$params['img_file']);
        }
        //if(isset($params['material_file']) && $params['material_file']){
//            unlink('./subscribegift/'.$params['material_file']);
//        }
        redirect('backend/subscribe');
    }



    public function subscribe_drop()
    {
        return $this->_dropWithFile('subscribe');
    }
    
////////////////////////////////AFORIZMUS//////////////////////////
    public function aforizmus_list()
    {
        $title              = "Редактировать афоризмы";
        $aforizmusList      = $this->index_model->getAforizmusList();
        $contentArr         = $aforizmusList ? $aforizmusList : $this->emptyAforizmusArr;

        $this->data_arr     = array(
             'title'            => $title
            ,'content'          => $contentArr
            ,'menu_items'       => $this->arrMenu
        );

        $data = array(
                'menu'    => $this->load->view(MENU_ADMIN, '', true),
                'content' => $this->load->view('admin/aforizmus/show', $this->data_arr, true));

        $this->load->view('layout_admin', $data);
    }
    
    
    
    public function aforizmus_drop($id)
    {
        $this->index_model->delFromTable($id, 'aforizmus');
        redirect('backend/aforizmus');
    }
    
    
    
    public function aforizmus_edit($id = null)
    {
        try{
            $data = array('author'   => $_REQUEST['author']
                            ,'text'  => $_REQUEST['text']);
            if($id){
                $resultUpdate = $this->index_model->updateInTable($id, $data, 'aforizmus');
                Common::assertTrue($resultUpdate, 'Ошибка! Информация не обновлена');
                $this->result['success'] = 'Информация успешно обновлена!';
            } else {
                $id = $this->index_model->addInTable($data, 'aforizmus');
                Common::assertTrue($id, 'Ошибка! Информация не добавлена');
                $this->result['success'] = 'Информация успешно добавлена!';
            }
        } catch (Exception $e){
            $this->result['message'] = $e->getMessage();
        }

        print json_encode($this->result);
        exit;
    }
        

////////////////////////////////LANDING//////////////////////////
    public function landing_list()
    {
        $title          = "Редактировать лэндинги";
        $landingList    = $this->index_model->getListFromTable('landing_page');
        foreach($landingList as $key => $landing){
            $landingList[$key]['registred_list'] = $this->landing_model->getLandingRegistredRecipients($landing['id']);
        }
       
        $this->data_arr     = array(
             'title'            => $title
            ,'content'          => $landingList
            ,'menu_items'       => $this->arrMenu
        );

        $data = array(
                'menu'    => $this->load->view(MENU_ADMIN, '', true),
                'content' => $this->load->view('admin/landing/show', $this->data_arr, true));

        $this->load->view('layout_admin', $data);
    }
    
    
    
    public function landing_drop($id)
    {
        $this->index_model->delFromTable($id, 'landing_page');
        redirect('backend/landing');
    }
    

    
    public function landing_edit($id = null)
    {
        $landingPage  = null;
        $title        = "Редактировать landing page";
        if($id){
            $landingPage  = $this->index_model->getFromTableByParams(array('id' => $id), 'landing_page');
            $title        = "Редактировать landing page";
        }

        $contentArr         = $landingPage[0] ? $landingPage[0] : $this->landingPageArr;
        $url                = $this->_prepareUrl($this->urlArr);
        $contentArr['url']  = $url;

        $this->data_arr     = array(
             'title'            => $title
            ,'content'          => $contentArr
            ,'menu_items'       => $this->arrMenu
            ,'message'          => $this->message
        );

        $data = array(
                'menu'    => $this->load->view(MENU_ADMIN, '', true),
                'content' => $this->load->view('admin/landing/edit', $this->data_arr, true));

        $this->load->view('layout_admin', $data);
    }
    
    
    
    public function check_valid_landing()
    {
        $data           = $params = array();
        $id             = isset($_REQUEST['id']) && $_REQUEST['id'] ? $_REQUEST['id'] : null;
        $this->_formLandingValidation();
        $dataMain       = array('unique'                => $_REQUEST['unique']
                                ,'title'                => $_REQUEST['title']
                                ,'title_description'    => $_REQUEST['title_description']
                                ,'page_text'            => $_REQUEST['page_text']
                                ,'letter_text'          => $_REQUEST['letter_text']);

        try{
            if($id){
                $params['id']  = $id;
                $data          = array_merge($dataMain, array(
                                                        'created_at'    => $_REQUEST['created_at'],
                                                        'status'        => $_REQUEST['status']));
                $this->_updateLanding($data, $params);
            } else {
                $data = array_merge($dataMain, array(
                                                'created_at'    => date('Y-m-d H:i:s')
                                                ,'status'       => STATUS_ON));

                $this->_addLanding($data);
            }
        } catch (Exception $e){
            $this->message = $e->getMessage();
            $this->landing_edit($id);
        }
    }
    
    
    
    private function _formLandingValidation()
    {
        $rules = array(
                    array(
    		        'field'	=> 'unique',
    		    	'label'	=> '<Ключ для ссылки>',
    		    	'rules'	=> 'required'),
                    array(
    		        'field'	=> 'page_text',
    		    	'label'	=> '<Текст>',
    		    	'rules'	=> 'required'),
                    array(
                    'field'	=> 'title',
                    'label'	=> '<Название>',
                    'rules'	=> 'required'));
        $this->form_validation->set_rules($rules);

        $isValid = $this->form_validation->run();
        Common::assertTrue($isValid, 'Форма заполнена неверно');
    }
    
    
    
    private function _addLanding($data)
    {
        $id = $this->index_model->addInTable($data, 'landing_page');
        Common::assertTrue($id, 'Информация не добавлена в базу');
        redirect('backend/landing');        
    }

    

    private function _updateLanding($data, $params)
    {
        $isUpdated = $this->index_model->updateInTable($params['id'], $data, 'landing_page');
        Common::assertTrue($isUpdated, 'Not updated');
        redirect('backend/landing');
    }
    
    
    
    ////////////////////////////////LANDING ARTICLES//////////////////////////
    public function landing_articles_list()
    {
        $title          = "Редактировать landing articles";
        $landingList    = $this->index_model->getListFromTable('landing_articles');
        $landingsArr    = $this->index_model->getFromTableByParams(array('status' => STATUS_ON),'landing_page');
        
        foreach($landingList as $key => $articles){
            foreach($landingsArr as $i => $pages){
                $landingList[$key]['landing_page_name'] = ($pages['id'] == $articles['landing_page_id']) ? $pages['title'] : '';
            }
        }
      
        $this->data_arr     = array(
             'title'                => $title
            ,'content'              => $landingList
            ,'menu_items'           => $this->arrMenu
            ,'specMailerContainer'  => $this->load->view('admin/blocks/spec_mailer_form', array('landings' => $landingsArr), true)                
        );

        $data = array(
                'menu'    => $this->load->view(MENU_ADMIN, '', true),
                'content' => $this->load->view('admin/landing_articles/show', $this->data_arr, true));

        $this->load->view('layout_admin', $data);
    }
    
    
    
    public function landing_articles_drop($id)
    {
        $this->index_model->delFromTable($id, 'landing_articles');
        redirect('backend/landing_articles');
    }
    

    
    public function landing_articles_edit($id = null)
    {
        $landingArticle  = null;
        $title        = "Создать landing article";
        if($id){
            $landingArticle  = $this->index_model->getFromTableByParams(array('id' => $id), 'landing_articles');
            $title        = "Редактировать landing article";
        }
        
        $landingsArr        = $this->index_model->getFromTableByParams(array('status' => STATUS_ON),'landing_page');
        $contentArr         = $landingArticle[0] ? $landingArticle[0] : $this->landingArticleArr;
        $url                = $this->_prepareUrl($this->urlArr);
        $contentArr['url']  = $url;

        $this->data_arr     = array(
             'title'            => $title
            ,'content'          => $contentArr
            ,'landings'         => $landingsArr
            ,'menu_items'       => $this->arrMenu
            ,'message'          => $this->message
        );

        $data = array(
                'menu'    => $this->load->view(MENU_ADMIN, '', true),
                'content' => $this->load->view('admin/landing_articles/edit', $this->data_arr, true));

        $this->load->view('layout_admin', $data);
    }
    
    
    
    public function check_valid_landing_articles()
    {
        $data           = $params = array();
        $id             = isset($_REQUEST['id']) && $_REQUEST['id'] ? $_REQUEST['id'] : null;

        try{        
            $this->_formLandingArticlesValidation();
            $dataMain       = array('title'             => $_REQUEST['title']
                                    ,'slug'             => $_REQUEST['slug']
                                    ,'text'             => $_REQUEST['text']
                                    ,'password_mp3'     => $_REQUEST['password_mp3']
                                    ,'link_mp3'         => $_REQUEST['link_mp3']
                                    ,'landing_page_id'  => $_REQUEST['landing']);

            if($id){
                $params['id']  = $id;
                $data          = array_merge($dataMain, array(
                                                        'created_at'    => $_REQUEST['created_at'],
                                                        'status'        => $_REQUEST['status']));
                $this->_updateLandingArticles($data, $params);
            } else {
                $data = array_merge($dataMain, array(
                                                'created_at'    => date('Y-m-d H:i:s')
                                                ,'status'       => STATUS_ON));

                $this->_addLandingArticles($data);
            }
        } catch (Exception $e){
            $this->message = $e->getMessage();
            $this->landing_articles_edit($id);
        }
    }
    
    
    
    private function _formLandingArticlesValidation()
    {
        $rules = array(
                    array(
    		        'field'	=> 'slug',
    		    	'label'	=> '<Alias названия>',
    		    	'rules'	=> 'required'),
                    array(
    		        'field'	=> 'title',
    		    	'label'	=> '<Название>',
    		    	'rules'	=> 'required'),
                    array(
    		        'field'	=> 'landing',
    		    	'label'	=> '<Landing page>',
    		    	'rules'	=> 'required'));
        $this->form_validation->set_rules($rules);

        $isValid = $this->form_validation->run();
        Common::assertTrue($isValid, 'Форма заполнена неверно');
    }
    
    
    
    private function _addLandingArticles($data)
    {
        $id = $this->index_model->addInTable($data, 'landing_articles');
        Common::assertTrue($id, 'Информация не добавлена в базу');
        redirect('backend/landing_articles');        
    }

    

    private function _updateLandingArticles($data, $params)
    {
        $isUpdated = $this->index_model->updateInTable($params['id'], $data, 'landing_articles');
        Common::assertTrue($isUpdated, 'Not updated');
        redirect('backend/landing_articles');
    }
    
    
    public function ajax_send_spec_mailer()
    {
        $errLogData = array();
        $data = array('theme'               => $_REQUEST['theme']
                        ,'text'             => $_REQUEST['text']
                        ,'articles_id'      => $_REQUEST['articleId']
                        ,'landing_page_id'  => $_REQUEST['landingPageId']);
        try{
            $this->_assertSpecMailerData($data);

            $recipientsSpecMailerArr    = $this->landing_model->getLandingRegistredRecipients($data['landing_page_id']);
            Common::assertTrue(count($recipientsSpecMailerArr), 'Не найден ни один подписчик для отправки');
  
            $data['created_at'] = date('Y-m-d H:i:s');
            $specMailerHistoryId = $this->index_model->addInTable($data, 'spec_mailer_history');
            Common::assertTrue($specMailerHistoryId, 'Ошибка! Информация об отправке писем по спецрассылке НЕ вставлена в БД');
           
            $data['articles_title'] = $_REQUEST['articleTitle'];
            $data['article_link']   = $_REQUEST['isLanding'] ? base_url()."landing_articles/".$data['articles_id'] : base_url()."articles/".$data['articles_id'];
          
            $sentMailCounter = $this->_sendSpecMailer($recipientsSpecMailerArr, $data);
            Common::assertTrue($sentMailCounter > 0, 'Ошибка! Не было отправлено ни одного письма');
           
           
            $this->result['data']       = 'Спецрассылка прошла успешно! <br>Можно идти пить чай:)';
            $this->result['success']    = true;
        } catch (Exception $e){
            $this->result['message']    = $e->getMessage();
            
            $errLogData['resource_id']  = ERROR_SRC_SPEC_MAILER;
            $errLogData['text']         = $e->getMessage()." - Название статьи: ".$_REQUEST['articleTitle'];
            $errLogData['created_at']   = date('Y-m-d H:i:s');
            $this->index_model->addInTable($errLogData, 'error_log');
        }

        print json_encode($this->result);
        exit;
    }
    
    
    
    private function _assertSpecMailerData($data)
    {
        foreach($data as $key => $item){
            Common::assertTrue($item, 'Ошибка! Не заполнено поле '.$key);
        }
    }
    
    
    
    private function _sendSpecMailer($recipientsSpecMailerArr, $data)
    {
        $sentMailCounter = 0;
        $errLogData = array();
         foreach($recipientsSpecMailerArr as $recipient){
             try{
                $isSent = $this->mailer_model->sendSpecMailerEmail($recipient, $data);
                Common::assertTrue($isSent, 'Ошибка! Письмо для подписчика '.$recipient['name'].' ('.$recipient['email'].') не было отправлено');
                $sentMailCounter++;
             } catch (Exception $e){
                 $errLogData['resource_id'] = ERROR_SRC_SPEC_MAILER;
                 $errLogData['text']        = $e->getMessage()." - Название статьи: ".$data['articles_title'];
                 $errLogData['created_at']  = date('Y-m-d H:i:s');
                 $this->index_model->addInTable($errLogData, 'error_log');
             }
         }
         
         return $sentMailCounter;
    }
    
    
    
    public function spec_mailer_statistics($landingPageId = null)
    {
        $title          = "Статистика спец. рассылки";
        if($landingPageId){
            $specMailerHistoryArr    = $this->landing_model->getSpecMailerStatistics($landingPageId);
            foreach($specMailerHistoryArr as $key => $specMailerHistory){
                $specMailerHistoryArr[$key]['registred_list'] = $this->landing_model->getLandingRegistredRecipients($specMailerHistory['landing_page_id'], $specMailerHistory['created_at']);
            }

            $this->data_arr     = array(
                'title'            => $title
                ,'content'          => $specMailerHistoryArr
                ,'menu_items'       => $this->arrMenu
            );

            $data = array(
                    'menu'    => $this->load->view(MENU_ADMIN, '', true),
                    'content' => $this->load->view('admin/landing/spec_mailer_statistics_show', $this->data_arr, true));
        } else {
            $landingPageArr = $this->index_model->getListFromTable('landing_page');
            
            $this->data_arr     = array(
                'title'            => $title
                ,'content'          => $landingPageArr
                ,'menu_items'       => $this->arrMenu
            );

            $data = array(
                    'menu'    => $this->load->view(MENU_ADMIN, '', true),
                    'content' => $this->load->view('admin/landing/landing_page_list', $this->data_arr, true));            
        }
        
        $this->load->view('layout_admin', $data);        
    }

    
    
////////////////////////////////SALE PAGE//////////////////////////
    public function sale_page_list()
    {
        $title          = "Продающие страницы";
        $salePageArr    = $this->index_model->getListFromTable('sale_page');
        $saleProductsArr    = $this->index_model->getArrWhere('sale_products', array(), '', '' , 'sequence_num');
        
        foreach($salePageArr as $key => $salePage){
            foreach($saleProductsArr as $i => $saleProducts){
                if($saleProducts['sale_page_id'] == $salePage['id']){
                    $salePageArr[$key]['sale_products'][] = $saleProducts;
                }
            }
        }
      
        $this->data_arr     = array(
             'title'                => $title
            ,'content'              => $salePageArr          
        );

        $data = array(
                'menu'    => $this->load->view(MENU_ADMIN, '', true),
                'content' => $this->load->view('admin/sale_page/show', $this->data_arr, true));

        $this->load->view('layout_admin', $data);
    }
    
    
    
    public function sale_page_drop($id)
    {
        $this->index_model->delFromTable($id, 'sale_page');
        redirect('backend/sale_page_list');
    }
    

    
    public function sale_page_edit($id = null)
    {
        $salePage  = null;
        $title        = "Создать sale page";
        if($id){
            $salePage  = $this->index_model->getFromTableByParams(array('id' => $id), 'sale_page');
            $title        = "Редактировать sale page";
        }
        
        $contentArr         = $salePage[0] ? $salePage[0] : $this->emptySalePageArr;
        $url                = $this->_prepareUrl($this->urlArr);
        $contentArr['url']  = $url;

        $this->data_arr     = array(
             'title'            => $title
            ,'content'          => $contentArr
            ,'menu_items'       => $this->arrMenu
            ,'message'          => $this->message
        );

        $data = array(
                'menu'    => $this->load->view(MENU_ADMIN, '', true),
                'content' => $this->load->view('admin/sale_page/edit', $this->data_arr, true));

        $this->load->view('layout_admin', $data);
    }
    
    
    
    public function check_valid_sale_page()
    {
        $data           = $params = array();
        $id             = isset($_REQUEST['id']) && $_REQUEST['id'] ? $_REQUEST['id'] : null;

        try{        
            $this->_formSalePageValidation();
            $dataMain       = array('title'             => $_REQUEST['title']
                                    ,'slug'             => $_REQUEST['slug']
                                    ,'text1'            => $_REQUEST['text1']
                                    ,'text2'            => $_REQUEST['text2']);

            if($id){
                $params['id']  = $id;
                $data          = array_merge($dataMain, array(
                                                        'created_at'    => $_REQUEST['created_at'],
                                                        'status'        => $_REQUEST['status']));
                $this->_updateSalePage($data, $params);
            } else {
                $data = array_merge($dataMain, array(
                                                'created_at'    => date('Y-m-d H:i:s')
                                                ,'status'       => STATUS_ON));

                $this->_addSalePage($data);
            }
        } catch (Exception $e){
            $this->message = $e->getMessage();
            $this->sale_page_edit($id);
        }
    }
    
    
    
    private function _formSalePageValidation()
    {
        $rules = array(
                    array(
    		        'field'	=> 'slug',
    		    	'label'	=> '<Alias названия>',
    		    	'rules'	=> 'required'),
                    array(
    		        'field'	=> 'title',
    		    	'label'	=> '<Название>',
    		    	'rules'	=> 'required'));
        
        $this->form_validation->set_rules($rules);

        $isValid = $this->form_validation->run();
        Common::assertTrue($isValid, 'Форма заполнена неверно');
    }
    
    
    
    private function _addSalePage($data)
    {
        $id = $this->index_model->addInTable($data, 'sale_page');
        Common::assertTrue($id, 'Информация не добавлена в базу');
        redirect('backend/sale_page_list');        
    }

    

    private function _updateSalePage($data, $params)
    {
        $isUpdated = $this->index_model->updateInTable($params['id'], $data, 'sale_page');
        Common::assertTrue($isUpdated, 'Not updated');
        redirect('backend/sale_page_list');
    }

    
////////////////////////////////SALE PRODUCTS//////////////////////////
    public function sale_products_list()
    {
        $title          = "Продукты для продажи";
        $salePageArr     = $this->index_model->getListFromTable('sale_page');
        $saleProductsArr = $this->index_model->getListFromTable('sale_products');
//        $saleProductsArr = $this->index_model->getArrWhere('sale_products', array(), '', '' , 'sequence_num');

        foreach($saleProductsArr as $i => $saleProducts){   
            foreach($salePageArr as $key => $salePage){
                if($saleProducts['sale_page_id'] == $salePage['id']){
                    $saleProductsArr[$i]['sale_page'] = $salePage['title'];
                }
            }
        }
      
        $this->data_arr     = array(
             'title'                => $title
            ,'content'              => $saleProductsArr          
        );

        $data = array(
                'menu'    => $this->load->view(MENU_ADMIN, '', true),
                'content' => $this->load->view('admin/sale_products/show', $this->data_arr, true));

        $this->load->view('layout_admin', $data);
    }
    
    
    
    public function sale_products_drop($id)
    {
        $this->index_model->delFromTable($id, 'sale_products');
        redirect('backend/sale_products_list');
    }
    

    
    public function sale_products_edit($id = null)
    {
        $saleProduct  = null;
        $title        = "Создать sale produst";
        if($id){
            $saleProduct  = $this->index_model->getFromTableByParams(array('id' => $id), 'sale_products');
            $title        = "Редактировать sale product";
        }

        $salePageArr        = $this->index_model->getListFromTable('sale_page');
        $contentArr         = $saleProduct[0] ? $saleProduct[0] : $this->emptySaleProductArr;
        $url                = $this->_prepareUrl($this->urlArr);
        $contentArr['url']  = $url;

        $this->data_arr     = array(
             'title'            => $title
            ,'content'          => $contentArr
            ,'salePageArr'      => $salePageArr
            ,'menu_items'       => $this->arrMenu
            ,'message'          => $this->message
        );

        $data = array(
                'menu'    => $this->load->view(MENU_ADMIN, '', true),
                'content' => $this->load->view('admin/sale_products/edit', $this->data_arr, true));

        $this->load->view('layout_admin', $data);
    }
    
    
    
    public function check_valid_sale_products()
    {
        $data           = $params = array();
        $id             = isset($_REQUEST['id']) && $_REQUEST['id'] ? $_REQUEST['id'] : null;

        try{        
            $this->_formSaleProductsValidation();
            $dataMain       = array('title'             => $_REQUEST['title']
                                    ,'description'      => $_REQUEST['description']
                                    ,'price'            => $_REQUEST['price']
                                    ,'sale_page_id'     => $_REQUEST['sale_page_id']);

            if($id){
                $params['id']  = $id;
                $data          = array_merge($dataMain, array(
                                                        'created_at'    => $_REQUEST['created_at'],
                                                        'status'        => $_REQUEST['status'],
                                                        'sequence_num'  => $_REQUEST['sequence_num']));
                $this->_updateSaleProducts($data, $params);
            } else {
                $data = array_merge($dataMain, array(
                                                'created_at'    => date('Y-m-d H:i:s'),
                                                'status'        => STATUS_ON,
                                                'sequence_num'  => 0));

                $this->_addSaleProducts($data);
            }
        } catch (Exception $e){
            $this->message = $e->getMessage();
            $this->sale_products_edit($id);
        }
    }
    
    
    
    private function _formSaleProductsValidation()
    {
        $rules = array(
                    array(
    		        'field'	=> 'title',
    		    	'label'	=> '<Название>',
    		    	'rules'	=> 'required'));
        
        $this->form_validation->set_rules($rules);

        $isValid = $this->form_validation->run();
        Common::assertTrue($isValid, 'Форма заполнена неверно');
    }
    
    
    
    private function _addSaleProducts($data)
    {
        $id = $this->index_model->addInTable($data, 'sale_products');
        Common::assertTrue($id, 'Информация не добавлена в базу');
        redirect('backend/sale_products_list');        
    }

    

    private function _updateSaleProducts($data, $params)
    {
        $isUpdated = $this->index_model->updateInTable($params['id'], $data, 'sale_products');
        Common::assertTrue($isUpdated, 'Not updated');
        redirect('backend/sale_products_list');
    }
    ////////////////END SALE PRODUCTS////////
    
    
    private function _prepareUrl($urlArr)
    {
        $countUrl = count($urlArr) - 1;
        $url = '';

        for($i = 1; $i <= $countUrl; $i++){
            $url .= $urlArr[$i];
            if($i < ($countUrl)){
                $url .= '/';
            }
        }

        return $url;
    }



    private function _add($data)
    {
        return $this->index_model->addInTable($data, 'articles');
    }



    private function _update($data, $params)
    {
        if($this->index_model->updateInTable($params['id'], $data, 'articles')){
            redirect('backend/news');
        } else{
            throw new Exception('Not updated');
        }
    }



    private function _prepareContentAndAssignsArr($contentArr)
    {
        $contentAndAssignArr = $newContentArr = $assignedDivizionArr = array();
        foreach($contentArr as $content){
            $newContentArr[$content['id']] = $content;
            $assignedDivizionArr[$content['id']][] = $content['slug_title'];
        }
        $contentAndAssignArr['content'] = $newContentArr;
        $contentAndAssignArr['assigns'] = $assignedDivizionArr;

        return $contentAndAssignArr;
    }
    


    private function _tryUploadFile($fileUploading, $uploadPath)
    {
        return Fileloader::loadFile($fileUploading['name'], $uploadPath, $fileUploading['tmp_name']);
    }

    

    public function drop($id)
    {
       $this->index_model->del($id);
       redirect('backend/news');
    }



    private function _dropWithFile($dirTableName)
    {
        $error = null;
        try{
            $filename   = isset($_REQUEST['filename']) && $_REQUEST['filename'] ? $_REQUEST['filename'] : null;
            $id         = isset($_REQUEST['id']) && $_REQUEST['id'] ? $_REQUEST['id'] : null;
            Common::assertTrue($id, 'Id not set');
            Common::assertTrue($filename, 'Filename not set');
            
            if(file_exists('./'.$dirTableName.'/'.$filename)){
               unlink('./'.$dirTableName.'/'.$filename);
            }
           $isDeleted = $this->index_model->delFromTable($id, $dirTableName);
           Common::assertTrue($isDeleted, 'Not deleted');

        } catch(Exception $e){
            $error = $e->getMessage();
        }
       print json_encode($error);
    }



    public function ajax_change_status()
    {
        $data = $arrData = array();
        $data['status']     = $_REQUEST['status'];
        $arrData['id']      = $_REQUEST['id'];
        $arrData['table']   = $_REQUEST['table'];
        if($this->_update_status($data, $arrData)){
             print 'updated_true';
             exit;
        } else{
             return false;
        }
    }

 
    
    public function ajax_get_available_tag()
    {
        $tagArr =  $this->index_model->getAvailableTag();
       
        print json_encode($tagArr);
        exit;
    }

    
    
    private function _prepareMenu()
    {
       return $this->edit_menu_model->childs;
    }



    private function _update_status($data, $arrData)
    {
        return $this->index_model->updateInTable($arrData['id'], $data, $arrData['table']);
    }


    
    private function _addOrDeleteAssigns()
    {
        $newAssignMenuIdArr         = $this->_prepareNewAssignedIdArrIndexIsEqualValue();
        $clearedNewAssignMenuIdArr  = $this->_deleteClearedAssigns($newAssignMenuIdArr);
        $clearedNewAssignMenuIdArr ? $this->_addNewAssigns($clearedNewAssignMenuIdArr) : null;
    }


    
    private function _prepareNewAssignedIdArrIndexIsEqualValue()
    {
        $newAssignMenuIdArr = array();

        foreach($this->assignsArr['assignMenuIdArr'] as $assignId){
            $newAssignMenuIdArr[$assignId] = $assignId;
        }

        return $newAssignMenuIdArr;
    }

    

    private function _deleteClearedAssigns($newAssignMenuIdArr)
    {
        foreach($this->assignsArr['oldAssignMenuIdArr'] as $oldAssignMenuId){
            if(!in_array($oldAssignMenuId, $newAssignMenuIdArr)){
                $this->index_model->delFromTableByParams($this->assignsArr, $oldAssignMenuId);
            } else{
                unset($newAssignMenuIdArr[$oldAssignMenuId]);
            }
        }

        return $newAssignMenuIdArr;
    }



    private function _addNewAssigns($clearedNewAssignMenuIdArr)
    {
        foreach($clearedNewAssignMenuIdArr as $newAssignMenuId){
            $data = array('menu_id' => $newAssignMenuId, $this->assignsArr['assignFieldName'] => $this->assignsArr['id']);
            $this->index_model->addInTable($data, $this->assignsArr['table']);
        }
    }


    
    public function logout()
    {
        return $this->login_model->logOut();
    }

    
        
    private function _getCloudsTag()
    {
        return $this->index_model->getCloudsTag();
    }
}