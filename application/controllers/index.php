<?php
/**
 * @author Litkovskiy
 * @copyright 2010
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller 
{
    public $arrMenu             = array();
    public $subscribe           = array();
    public $aforizmus           = array();
    public $cloudsTag           = array();
    public $defaultDescription  = '';
    public $defaultKeywords     = '';
    public $contactFormArr, $result;


    public function __construct()
    {
       parent::__construct();
       $this->arrMenu           = $this->_prepareMenu();
       $this->subscribe         = $this->_prepareSubscribe();
       $this->aforizmus         = $this->_getAforizmus();
       $this->contactFormArr    = array('contact_form' => array('name' => null, 'email' => null, 'text' => null));
       $this->result            = array("success" => null, "message" => null, "data" => null, "popup" => null);     
       $this->urlArr            = explode('/',$_SERVER['REQUEST_URI']);
       $this->cloudsTag         = array('tags' => $this->_getCloudsTag()); 
    }


    
    public function index($currentPage = null)
    {
       $this->load->library('pagination');
       $countTotal           = $this->index_model->getCountArticles('news');
        //prepare pager config
       $config               = prepare_pager_config();
       $config['base_url']   = base_url().'news/page/';
       $config['total_rows'] = $countTotal;
       $this->pagination->initialize($config);
       $pager               = $this->pagination->create_links();
       $pagerParam          = array('current_page' => $currentPage, 'per_page' => $config['per_page']);
       $this->data_menu     = array('menu' => $this->arrMenu,'current_url' => $this->urlArr[count($this->urlArr)-1]);
       $contentArr          = $this->index_model->getNewsList($pagerParam);
       $title               = count($contentArr) > 0 ? $contentArr[0]['slug_title'] : null;
     
       $this->data_arr      = array(
             'title'         	=> SITE_TITLE.' - '.$title
            ,'aforizmus'        => $this->aforizmus
            ,'meta_keywords'	=> $contentArr[0]['meta_keywords'] ? $contentArr[0]['meta_keywords'] : $this->defaultDescription
            ,'meta_description'	=> $contentArr[0]['meta_description'] ? $contentArr[0]['meta_description'] : $this->defaultKeywords
            ,'content'       	=> $contentArr
            ,'pager'         	=> $pager
            ,'current_page'     => $currentPage
            ,'disqus'           => show_disqus()
       );

       $data = array(
                'menu'          => $this->load->view(MENU, $this->data_menu, true),
                'content'       => $this->load->view('index/show_news', $this->data_arr, true),
                'cloud_tag'     => $this->load->view('blocks/cloud_tag', $this->cloudsTag, true),
                'subscribe'     => $this->load->view('blocks/subscribe', count($this->subscribe) ? $this->subscribe : null, true));

       $this->load->view('layout', $data);

    }


    
    public function show($slug)
    {
       $this->data_menu      = array('menu' => $this->arrMenu,'current_url' => $this->urlArr[count($this->urlArr)-1]);
       $contentArr           = $this->index_model->getContent($slug);
       $articlesArr          = $this->index_model->getContentFromTableByMenuId('articles', $contentArr[0]['id']);
       $materialsArr         = $this->index_model->getContentFromTableByMenuId('materials', $contentArr[0]['id']);
       $title                = count($contentArr) > 0 ? $contentArr[0]['slug'] : null;

       $this->data_arr       = array(
             'title'         	=> SITE_TITLE.' - '.$title
            ,'titleFB'         	=> SITE_TITLE.' - '.(count($contentArr) > 0 && $contentArr[0]['title']) ? $contentArr[0]['title'] : $title 
            ,'imgFB'         	=> (count($contentArr) > 0 && $contentArr[0]['text']) ? $this->_getFirstImgFromText($contentArr[0]['text']) : 'spring_logo.png' 
            ,'aforizmus'        => $this->aforizmus
            ,'meta_keywords'	=> (count($contentArr) > 0 && $contentArr[0]['meta_keywords']) ? $contentArr[0]['meta_keywords'] : $this->defaultDescription
            ,'meta_description'	=> (count($contentArr) > 0 && $contentArr[0]['meta_description']) ? $contentArr[0]['meta_description'] : $this->defaultKeywords
            ,'content'       	=> $contentArr[0]
            ,'articles'       	=> $articlesArr
            ,'materials'       	=> $materialsArr
            ,'contact_form'    	=> $slug == 'contacts' ? $this->load->view('blocks/contact_form', $this->contactFormArr, true) : null
            ,'is_article'	=> false
            ,'disqus'           => $slug == 'reviews' ? show_disqus() : null
       );

       $data = array(
             'menu'          => $this->load->view(MENU, $this->data_menu, true),
             'content'       => $this->load->view('index/show', $this->data_arr, true),
             'cloud_tag'     => $this->load->view('blocks/cloud_tag', $this->cloudsTag, true),
             'subscribe'     => $this->load->view('blocks/subscribe', count($this->subscribe) ? $this->subscribe : null, true));
       $this->load->view('layout', $data);

    }



    public function show_detail($slug, $articleId)
    {
       $this->data_menu      = array('menu' => $this->arrMenu,'current_url' => $this->urlArr[count($this->urlArr)-1]);
       $contentArr           = $this->index_model->getDetailContent($articleId);
       if(count($contentArr) < 1)  redirect('/index');
       $title                = count($contentArr) > 0 ? $slug.' - '.$contentArr[0]['slug'] : null;

       $this->data_arr       = array(
             'title'         	=> SITE_TITLE.' - '.$title
            ,'titleFB'         	=> SITE_TITLE.' - '.(count($contentArr) > 0 && $contentArr[0]['title']) ? $contentArr[0]['title'] : $title 
            ,'imgFB'         	=> (count($contentArr) > 0 && $contentArr[0]['text']) ? $this->_getFirstImgFromText($contentArr[0]['text']) : 'spring_logo.png' 
            ,'aforizmus'        => $this->aforizmus
            ,'meta_keywords'	=> (count($contentArr) > 0 && $contentArr[0]['meta_keywords']) ? $contentArr[0]['meta_keywords'] : $this->defaultDescription
            ,'meta_description'	=> (count($contentArr) > 0 && $contentArr[0]['meta_description']) ? $contentArr[0]['meta_description'] : $this->defaultKeywords
            ,'content'       	=> $contentArr[0]
            ,'articles'       	=> null
            ,'materials'       	=> null
            ,'is_article'	=> true
            ,'disqus'           => show_disqus()
       );

       $data = array(
             'menu'          => $this->load->view(MENU, $this->data_menu, true),
             'content'       => $this->load->view('index/show', $this->data_arr, true),
             'cloud_tag'     => $this->load->view('blocks/cloud_tag', $this->cloudsTag, true),
             'subscribe'     => $this->load->view('blocks/subscribe', count($this->subscribe) ? $this->subscribe : null, true));
       $this->load->view('layout', $data);
    }


    
    public function cloud_tag_list($tagMasterId, $currentPage = null)
    {
        $this->load->library('pagination');
        $countTotal           = $this->index_model->getCountArticlesByTagId($tagMasterId);
       
        //prepare pager config
        $config               = prepare_pager_config();
        $config['uri_segment']= 4;
        $config['base_url']   = base_url().'cloudtag/'.$tagMasterId.'/page/';
        $config['total_rows'] = $countTotal;
        $this->pagination->initialize($config);
        $pager               = $this->pagination->create_links();
        $pagerParam          = array('current_page' => $currentPage, 'per_page' => $config['per_page']);
        $this->data_menu     = array('menu' => $this->arrMenu,'current_url' => $this->urlArr[count($this->urlArr)-1]);
        $contentArr          = $this->index_model->getArticlesListByTagId($pagerParam, $tagMasterId);
        $contentArr          = count($contentArr) > 0 ? $contentArr : null;
        if($contentArr){
            foreach($contentArr as $key => $content){
                $contentArr[$key]['slug_title'] = 'Статьи';
            }
        }
        $this->data_arr      = array(
             'title'         	=> SITE_TITLE.' - статьи'
            ,'aforizmus'        => $this->aforizmus
            ,'meta_keywords'	=> $this->defaultDescription
            ,'meta_description'	=> $this->defaultKeywords
            ,'content'       	=> $contentArr
            ,'pager'         	=> $pager
            ,'current_page'     => $currentPage
            ,'disqus'           => show_disqus()
        );

        $data = array(
                'menu'          => $this->load->view(MENU, $this->data_menu, true),
                'content'       => $this->load->view('index/show_news', $this->data_arr, true),
                'cloud_tag'     => $this->load->view('blocks/cloud_tag', $this->cloudsTag, true),
                'subscribe'     => $this->load->view('blocks/subscribe', count($this->subscribe) ? $this->subscribe : null, true));

        $this->load->view('layout', $data);
    }
    
    

    public function ajax_send_subscribe()
    {
        $data = array();
        $data['name']   = trim(strip_tags($_REQUEST['name']));
        $data['email']  = trim(strip_tags($_REQUEST['email']));
       
        return $this->check_valid_subscribe_form($data);
    }

    
    
    public function check_valid_subscribe_form($data)
    {
        try{
            $rules = $this->_prepareRulesSubscribeForm();
            $this->_checkValid($rules);
            Common::assertTrue($data['email'], "<p class='error'>Форма заполнена неверно. Пожалуйста, попробуйте еще раз.</p>");
            Common::assertTrue($data['name'], "<p class='error'>Форма заполнена неверно. Пожалуйста, попробуйте еще раз.</p>");

            $this->_trySubscribeProcess($data);
        } catch (Exception $e){
            $this->result['message'] = $e->getMessage();
        }

        print json_encode($this->result);
        exit;
    }


	 
    private function _prepareRulesSubscribeForm()
    {
        return array(
                    array(
                    'field'	=> 'name',
                    'label'	=> 'Name',
                    'rules'	=> 'required|xss_clean'),
                    array(
                    'field'	=> 'email',
                    'label'	=> 'Email',
                    'rules'	=> 'required|valid_email')
                    );
    }
	
	
	
    private function _trySubscribeProcess($data)
    {
        $data['created_at']  = date('Y-m-d H:i:s');

        if(!isset($_REQUEST['subscribe_id'])){
            $data['confirmed'] = STATUS_ON;            
        }
        $recipientDataArr = $this->_getRecipientData($data);
        Common::assertTrue($recipientDataArr['id'], "<p class='error'>К сожалению, при регистрации произошла ошибка.<br/>Пожалуйста, попробуйте еще раз</p>");

        $data['subscribe_name'] = isset($_REQUEST['subscribe_name']) ? trim(strip_tags($_REQUEST['subscribe_name'])) : '';
        $data['subscribe_id']   = isset($_REQUEST['subscribe_id']) ? $_REQUEST['subscribe_id'] : 0;

        if($data['subscribe_id'] > 0){
            $hashLink = $this->index_model->hashProcess($data, $recipientDataArr['id']);
            Common::assertTrue($hashLink, "<p class='error'>К сожалению, при регистрации произошла ошибка.<br/>Пожалуйста, попробуйте еще раз</p>");
            $this->_freeProductProcess($data, $recipientDataArr, $hashLink);
        } else {
            $this->_subscribeArticlesProcess($data, $recipientDataArr);
        }
        
        return;
    }

	
	
    private function _getRecipientData($data)
    {
        $recipientDataArr = array();
        $recipientDataArr = $this->index_model->getRecipientIdByEmail($data['email']);

        if(!count($recipientDataArr)){
            $data['confirmed']      = isset($data['confirmed']) ? $data['confirmed'] : STATUS_OFF;
            $data['unsubscribed']   = STATUS_OFF;

            $recipientDataArr['id']        	= $this->index_model->addInTable($data, 'recipients');
            Common::assertTrue($recipientDataArr['id'], "<p class='error'>К сожалению, при регистрации произошла ошибка.<br/>Пожалуйста, попробуйте еще раз</p>");            
            $recipientDataArr['name']           = $data['name'];
            $recipientDataArr['email']          = $data['email'];
            $recipientDataArr['confirmed']	= $data['confirmed'] == STATUS_ON ? STATUS_ON : STATUS_OFF;
            $recipientDataArr['unsubscribed']	= 0;
            
            if($data['confirmed'] == STATUS_ON){
                $this->_tryUnisenderSubscribe($recipientDataArr);
            }
        }

        return $recipientDataArr;
    }
	
	
    
    private function _freeProductProcess($data, $recipientDataArr, $hashLink)
    {
        if($recipientDataArr['confirmed'] == STATUS_ON){
            $this->_showPopUpHashLink($hashLink);
        } else {
            $this->result["success"] = true;
            $this->_subscribeMailProcess($data, $recipientDataArr, $hashLink);
        }
    }
    
    
    
    private function _subscribeArticlesProcess($data, $recipientDataArr)
    {
        $this->_trySendSubscribeAdminMail($data);
        return $this->_showPopUpAlreadySubscribed($recipientDataArr);
//        if($recipientDataArr['confirmed'] == STATUS_ON && $recipientDataArr['unsubscribed'] == STATUS_OFF){
//Common::debugLog('_showPopUpAlreadySubscribed');            
//            $this->_showPopUpAlreadySubscribed($recipientDataArr);
//        } else {
//            $this->result["success"] = true;
//Common::debugLog('_subscribeMailProcess');             
//            $this->_subscribeMailProcess($data, $recipientDataArr, $hashLink);
//        }
    }
    
    
	
    private function _showPopUpHashLink($hashLink)
    {
        $urlParts   = explode('/', $hashLink);
        $hash       = $urlParts[count($urlParts)-1];
        $finishSubscribeProcessData = $this->_finishSubscribeProcess($hash);

        $this->result["popup"] 	= true;
        $this->result["success"] = true;        
        $this->result["data"] 	= "<p class='subscribe_success'>Материалы бесплатного продукта<br/>
                                    Вы можете скачать прямо сейчас:<br/>
                                    <a id='success' href='".$finishSubscribeProcessData['url']."'><img src='/img/img_main/floppy_disk.png'/><br/>
                                    Скачать материал</a></p>";

        return $this->result;
    }


    
    private function _showPopUpAlreadySubscribed($recipientDataArr)
    {
        $this->result["popup"] 	= true;
        $this->result["success"] = true;
//        $this->result["data"] 	= "<p class='subscribe_success'>Добрый день, ".$recipientDataArr['name']."!<br/>
//                                    Вы уже подписаны на рассылку статей по личной эффективности с сайта Spring Consult.<br/>
//                                    Если вы по какой-либо причине не получаете материалы - пожалуйста, сообщите об этом <a id='success' href='".base_url()."show/contacts'>администратору сайта</a></p>";
        $this->result["data"] 	= "<p class='subscribe_success'>Добрый день, ".$recipientDataArr['name']."!<br/>
                                    Вы успешно подписались на рассылку статей по личной эффективности от Елены Литковской.</p>";

        return $this->result;
    }
    
    

    private function _subscribeMailProcess($data, $recipientDataArr, $hashLink)
    {
        $this->_trySendSubscribeMail($data, $recipientDataArr, $hashLink);
        try{
            $this->_trySendSubscribeAdminMail($data);
            $this->_tryAddMailHistory($data, $recipientDataArr);
        } catch (Exception $e){
            $this->index_model->sendAdminErrorEmailMessage($e->getMessage());
        }
    }



    private function _trySendSubscribeMail($data, $recipientDataArr, $hashLink)
    {
        $messId = $data['subscribe_id'] > 0 ? $this->index_model->sendFreeProductSubscribeEmailMessage($data, $recipientDataArr, $hashLink) : $this->index_model->sendArticleSubscribeConfirmationEmailMessage($recipientDataArr, $hashLink);
        Common::assertTrue($messId, "<p class='error'>К сожалению, письмо с сылкой на материал не было отправлено.<br/>Пожалуйста, попробуйте еще раз</p>");
        $this->result['success'] = true;
        $this->result["data"] = "<p class='success'>Спасибо за подписку!<br>На Ваш e-mail отправлено письмо для подтверждения вашей подписки. Проверьте Ваш почтовый ящик - папку Входящие и СПАМ.</p>";            
    }



    private function _trySendSubscribeAdminMail($data)
    {
        $messId = $this->index_model->sendAdminSubscribeEmailMessage($data);
        Common::assertTrue($messId, "<p class='error'>Ошибка при попытке отправить AdminSubscribeEmailMessage</p>");
    }



    private function _tryAddMailHistory($data, $recipientDataArr)
    {
        $dataMailHistory['subscribe_id']    = $data['subscribe_id'];
        $dataMailHistory['recipients_id']   = $recipientDataArr['id'];
        $dataMailHistory['date']            = date('Y-m-d');
        $dataMailHistory['time']            = date('H:i:s');
        $mailHistoryId                      = $this->index_model->addInTable($dataMailHistory, 'mail_history');
        Common::assertTrue($mailHistoryId, "<p class='error'>Ошибка! Запись в Mail_history для subscribe_id=".$dataMailHistory['subscribe_id']." и recipients_id=".$dataMailHistory['recipients_id']." не произошла</p>");
    }



    public function finish_subscribe($hash)
    {
        try{
            $finishSubscribeProcessDataArr = $this->_finishSubscribeProcess($hash);
            
            $this->show_finish_subscribe($finishSubscribeProcessDataArr);
        } catch (Exception $e) {
            redirect('/index');
        }
    }



    private function _finishSubscribeProcess($hash)
    {
        $linksPackerData = $this->index_model->getLinksPackerDataByHash($hash);
        Common::assertTrue($linksPackerData, "");

        $updateData = array('count' => $linksPackerData['count'] + 1, 'updated_at' => date('Y-m-d H:i:s'));
        $this->index_model->updateInTable($linksPackerData['id'], $updateData, 'links_packer');

        $urlParts               = explode('/', $linksPackerData['url']);
        $recipientId            = $urlParts[count($urlParts)-1];
        $updateDataRecipient    = array('confirmed' => STATUS_ON);
        $this->index_model->updateInTable($recipientId, $updateDataRecipient, 'recipients');
        $recipientDataArr = $this->index_model->getFromTableByParams(array('id' => $recipientId), 'recipients');
        if($recipientDataArr[0]){
            $this->_tryUnisenderSubscribe($recipientDataArr[0]);
        }
        return (array('url' => $linksPackerData['url'], 'subscribe_id' => $linksPackerData['subscribe_id'],'recipient_id' => $recipientId));
    }


    
    private function _tryUnisenderSubscribe($recipientDataArr)
    {
        $postArr = array (
            'api_key'               => UNISENDERAPIKEY,
            'list_ids'              => UNISENDERMAINLISTID,
            'fields[email]'         => $recipientDataArr['email'],
            'fields[Name]'          => $recipientDataArr['name'],
            'fields[confirmed]'     => $recipientDataArr['confirmed'],
            'fields[unsubscribed]'  => $recipientDataArr['unsubscribed'],
            'double_optin'          => "3"
        );

        startCurlExec($postArr, 'http://api.unisender.com/ru/api/subscribe?format=json'); 
    }
    
    

    public function show_finish_subscribe($finishSubscribeProcessDataArr)
    {
        $this->data_menu            = array('menu' => $this->arrMenu,'current_url' => $this->urlArr[count($this->urlArr)-1]);
        $recipientData              = $this->index_model->getRecipientIdById($finishSubscribeProcessDataArr['recipient_id']);
        $subscribeId                = $finishSubscribeProcessDataArr['subscribe_id'];
        $finishSubscribeTamplate    = $subscribeId > 0 ? 'index/finish_free_product_subscribe' : 'index/finish_articles_subscribe';
      
        $this->data_arr             = array(
                                 'title'         	=> SITE_TITLE.' - subscribe'
                                ,'aforizmus'            => $this->aforizmus
                                ,'meta_keywords'	=> $this->defaultDescription
                                ,'meta_description'	=> $this->defaultKeywords
                                ,'recipient_data'  	=> $recipientData
                                ,'url'                  => $finishSubscribeProcessDataArr['url']
        );

        $data = array(
             'menu'          => $this->load->view(MENU, $this->data_menu, true),
             'content'       => $this->load->view($finishSubscribeTamplate, $this->data_arr, true),
             'cloud_tag'     => $this->load->view('blocks/cloud_tag', $this->cloudsTag, true),
             'subscribe'     => $this->load->view('blocks/subscribe', count($this->subscribe) ? $this->subscribe : null, true));
        $this->load->view('layout', $data);
    }


    
    public function output_subscribe($subscribeId, $recipientId)
    {
        try{
            Common::assertTrue($subscribeId, "");
            $subscribeDataArr = $this->index_model->getSubscribeDataArrById($subscribeId);
            Common::assertTrue($subscribeDataArr, "");

            $this->_outputFile($subscribeDataArr['material_path']);
        } catch (Exception $e) {
            redirect('/index');
        }
    }


    
    private function _outputFile($fileName)
    {
        $filePath = './subscribegift/'.$fileName;
        if (file_exists($filePath )) {
            header ("Content-Type: application/octet-stream");
            header ("Accept-Ranges: bytes");
            header ("Content-Length: ".filesize($filePath));
            header ("Content-Disposition: attachment; filename=".$fileName);
            readfile($filePath);
        } else {
            redirect('/index');
        }
    }
	
    
    
    public function unsubscribe_process($hash)
    {
        $linksPackerData = $this->index_model->getLinksPackerDataByHash($hash);
        Common::assertTrue($linksPackerData, "");

        $updateData = array('count' => $linksPackerData['count'] + 1, 'updated_at' => date('Y-m-d H:i:s'));
        $this->index_model->updateInTable($linksPackerData['id'], $updateData, 'links_packer');

        $urlParts               = explode('/', $linksPackerData['url']);
        $recipientId            = $urlParts[count($urlParts)-1];
        $updateDataRecipient    = array('unsubscribed' => STATUS_ON);
        $this->index_model->updateInTable($recipientId, $updateDataRecipient, 'recipients');

        return $this->showUnsubscribePage();
    }
    
	
    
    public function showUnsubscribePage()
    {
       $this->data_menu      = array('menu' => $this->arrMenu,'current_url' => $this->urlArr[count($this->urlArr)-1]);

       $this->data_arr       = array(
             'title'         	=> SITE_TITLE.' - unsubscribe'
            ,'aforizmus'        => $this->aforizmus
            ,'meta_keywords'	=> $this->defaultDescription
            ,'meta_description'	=> $this->defaultKeywords
       );

       $data = array(
             'menu'          => $this->load->view(MENU, $this->data_menu, true),
             'content'       => $this->load->view('blocks/unsubscribe_message', $this->data_arr, true),
             'cloud_tag'     => $this->load->view('blocks/cloud_tag', $this->cloudsTag, true),
             'subscribe'     => $this->load->view('blocks/subscribe', count($this->subscribe) ? $this->subscribe : null, true));
       $this->load->view('layout', $data);
    }
    
    
	
    public function ajax_send_contact_form()
    {
        $data = array();
        $data['name']  = trim(strip_tags($_REQUEST['name']));
        $data['email'] = trim(strip_tags($_REQUEST['email']));
        $data['text']  = trim(strip_tags($_REQUEST['text']));

        return $this->check_valid_contact_form($data);
    }



    public function check_valid_contact_form($data)
    {
        try{
            $rulesMain      = $this->_prepareRulesSubscribeForm();
            $rulesContact   = $this->_prepareRulesContactForm();
            $rules          = array_merge($rulesMain, $rulesContact);
            $this->_checkValid($rules);

            $data['created_at']     = date('Y-m-d');
            $messId                 = $this->index_model->sendEmailMessage($data);
            Common::assertTrue($messId, "<p class='error'>К сожалению, сообщение не было отправлено.<br/>Пожалуйста, попробуйте еще раз</p>");

            $this->result['success'] = $messId;
        } catch (Exception $e){
            $this->result['message'] = $e->getMessage();
        }

        print json_encode($this->result);
        exit;
    }

    
    
    public function show_landing_page($code)
    {
        $landingPageData = $this->index_model->getLandingPageByUnique($code);
      
        if(!count($landingPageData)) redirect('/index');        
        $this->data_arr       = array(
            'title'             => SITE_TITLE.' - landing page',
            'meta_keywords'	=> $this->defaultDescription,
            'meta_description'	=> $this->defaultKeywords,
            'content'           => $landingPageData
        );

       $data = array(
             'content'       => $this->load->view('blocks/landing_page', $this->data_arr, true),
             'subscribe'     => $this->load->view('blocks/landing_subscribe', $this->data_arr, true));
       $this->load->view('layout_landing', $data);
    }

    
    
    public function show_landing_article($id)
    {
        $landingArticleData = $this->index_model->getLandingArticleById($id);
      
        if(!$landingArticleData) redirect('/index');   
        $this->data_menu      = array('menu' => $this->arrMenu,'current_url' => $this->urlArr[count($this->urlArr)-1]);        
        $this->data_arr       = array(
            'title'             => SITE_TITLE.' - закрытая система мероприятий',
            'meta_keywords'	=> $this->defaultDescription,
            'meta_description'	=> $this->defaultKeywords,
            'content'           => $landingArticleData
        );

       $data = array(
             'menu'          => $this->load->view(MENU, $this->data_menu, true),           
             'content'       => $this->load->view('blocks/landing_article', $this->data_arr, true),
             'downloads'     => $this->load->view('blocks/landing_downloads', $this->data_arr, true));
       $this->load->view('layout_landing_articles', $data);
    }
    
    
    
    public function ajax_landing_subscribe()
    {
        $data = array();
        $data['name']  = trim(strip_tags($_REQUEST['name']));
        $data['email'] = trim(strip_tags($_REQUEST['email']));
        $data['created_at'] = date('Y-m-d H:i:s');

        return $this->check_valid_landing_form($data);
    }



    public function check_valid_landing_form($data)
    {
        try{
            $rules      = $this->_prepareRulesSubscribeForm();
            $this->_checkValid($rules);
            $data['confirmed'] = STATUS_ON;
            $arrRecipientData               = $this->_getRecipientData($data);
            $landingData['landing_page_id'] = trim(strip_tags($_REQUEST['landing_page_id']));  
            $landingData['recipients_id']   = $arrRecipientData['id'];
            $landingData['date_visited']    = date('Y-m-d H:i:s');
            $arrLandingStatisticsData       = $this->index_model->getFromTableByParams(array('landing_page_id' => $landingData['landing_page_id'], 'recipients_id' => $landingData['recipients_id']), 'landing_statistics');
          
            Common::assertFalse(count($arrLandingStatisticsData), "Вы уже зарегистрированы на данное мероприятие!");  
            $landingStatisticsId        = $this->index_model->addInTable($landingData, 'landing_statistics');            
            Common::assertTrue($landingStatisticsId, "<p class='error'>К сожалению, регистрация прошла неудачно.<br/>Пожалуйста, попробуйте еще раз</p>");
            $landingPageData = $this->index_model->getFromTableByParams(array('id' => $landingData['landing_page_id']), 'landing_page');
            $data['text'] = '<p>Новая подписка на треннинг : "'.trim(strip_tags($_REQUEST['title'])).'"</p>';

            $this->index_model->sendLandingSubscribeEmailMessage($landingPageData[0], $arrRecipientData);
            $this->index_model->sendEmailMessage($data);
            
            $this->result['success'] = "<p class='success'>Спасибо за регистрацию!<br/>На Ваш почтовый ящик была отправлена подробная инструкция<br/>(проверьте папку Входящие и СПАМ)</p>";
        } catch (Exception $e){
            $this->result['message'] = $e->getMessage();
        }

        print json_encode($this->result);
        exit;
    }
    
    
     
    private function _checkValid($rules)
    {
        $isValid = $this->form_validation->set_rules($rules);
        Common::assertTrue($isValid, "<p class='error'>Форма заполнена неверно</p>");

        return true;
    }



    private function _prepareRulesContactForm()
    {
         return array(  'field'	=> 'text',
                        'label'	=> 'Сообщение',
                        'rules'	=> 'required|xss_clean');
    }

    
    
    public function ajax_get_landing_mp3()
    {
        $data = array();
        $data['email']              = trim(strip_tags($_REQUEST['email']));
        $data['landing_page_id']    = trim(strip_tags($_REQUEST['landing_page_id']));
        $data['landing_article_id'] = trim(strip_tags($_REQUEST['landing_article_id']));
      
        return $this->check_valid_download_form($data);
    }



    public function check_valid_download_form($data)
    {
        try{
            $rules      = $this->_prepareRulesDownloadForm();
            $this->_checkValid($rules);

            $landingArticleData   = $this->index_model->getLandingArticleData($data);
            Common::assertTrue(count($landingArticleData), "<p class='error'>К сожалению, введенный E-mail<br/> 
                                                            не регистрирован на данное мероприятие<br/> 
                                                            и не может получить доступ к скачиванию материала.</p>");            

            $this->result['data']       = "<p class='success'>Чтобы скачать материал по теме<br/>  
                                            <b>'".$landingArticleData['title']."'</b><br/>
                                            перейдите по ссылке:<br> 
                                            <a href='".base_url().$landingArticleData['link_mp3']."'>'".base_url().$landingArticleData['link_mp3']."'</a><br/> 
                                            и воспользуйтесь паролем<br/> 
                                            <b>".$landingArticleData['password_mp3']."</b></p>";
            $this->result['success']    = true;            
        } catch (Exception $e){
            $this->result['message'] = $e->getMessage();
        }

        print json_encode($this->result);
        exit;
    }
    
    
    
    private function _prepareRulesDownloadForm()
    {
         return array(  'field'	=> 'email',
                        'label'	=> 'Email не заполнен',
                        'rules'	=> 'required|email');
    }
    
    

    public function show_rss()
    {
        $articlesArr = null;
        $rssTotalArr = $rssItemsArr = array();
        //set limit of articles's amount
        $params = array(
            'limit' => 3
        );
       
        $articlesArr = $this->index_model->getArticlesForRssByParams($params);

        foreach($articlesArr as $key => $item){
            $rssItemsArr[$key]['title']       = $item['title'];
            $rssItemsArr[$key]['link']        = 'http://'.$_SERVER['SERVER_NAME'].'/articles/'.$item['id'];
            $rssItemsArr[$key]['description'] = Common::cutString($item['text'], 60);
        }
        $rssTotalArr = array(
             'rss_channel_title'        => 'Последние статьи сайта Spring Consulting'
            ,'rss_channel_link'         => 'http://'.$_SERVER['SERVER_NAME']
            ,'rss_channel_description'  => 'На нашем сайте Вы сможете найти .'
            ,'rss_channel_language'     => 'ru'
            ,'rss_channel_copyright'    => '&copy; Copyright Spring consulting'

            ,'rss_logo_url'             => 'http://'.$_SERVER['SERVER_NAME'].'/spring_logo.png'
            ,'rss_logo_title'           => 'Spring Consulting'
            ,'rss_logo_link'            => 'http://'.$_SERVER['SERVER_NAME']

            ,'arr_rss_items'            => $rssItemsArr
        );

        header("Content-type: application/xml");
        //header("Content-Disposition: inline; filename=prestige_rss.xml");

        print $this->_makeXmlRss($rssTotalArr);
        exit;
    }
    
    
    
    private function _makeXmlRss($rssTotalArr)
    {

        $xw = new xmlWriter();
        $xw->openMemory();

        $xw->startDocument('1.0', 'UTF-8');
        //set atribute 'version' for element 'rss'
        //<rss version = '2.0'>
        $xw->startAttribute("version");
        $xw->startElement("rss");
        $xw->writeAttribute("version", "2.0");
        $xw->endAttribute();
            //<channel>
            $xw->startElement('channel');
                //<title>value</title>
                $xw->writeElement('title', $rssTotalArr['rss_channel_title']);
                //<link>value</link>
                $xw->writeElement('link', $rssTotalArr['rss_channel_link']);
                //<description>value</description>
                $xw->writeElement('description', $rssTotalArr['rss_channel_description']);
                //<language>value</language>
                $xw->writeElement('language', $rssTotalArr['rss_channel_language']);
                //<copyright>value</copyright>
                $xw->writeElement('copyright', $rssTotalArr['rss_channel_copyright']);
                //<image>
                $xw->startElement('image');
                    //<title>value</title>
                    $xw->writeElement('url', $rssTotalArr['rss_logo_url']);
                    //<link>value</link>
                    $xw->writeElement('title', $rssTotalArr['rss_logo_title']);
                    //<description>value</description>
                    $xw->writeElement('link', $rssTotalArr['rss_logo_link']);
                //</image>
                $xw->endElement();
                foreach ($rssTotalArr['arr_rss_items'] as $item) {
                    //<item>
                    $xw->startElement('item');
                        //<title>value</title>
                        $xw->writeElement('title', $item['title']);
                        //<link>value</link>
                        $xw->writeElement('link', $item['link']);
                        //<description>value</description>
                        $xw->writeElement('description', $item['description']);
                        //<guid>value</guid>
                        $xw->writeElement('guid', $item['link']);
                    //</item>
                    $xw->endElement();
                }
            //</channel>
            $xw->endElement();
        //</rss>
        $xw->endElement();

        $xw->endDocument();

        return $xw->outputMemory(true);
    }
    
    
     
    public function search()
    {
        $searchText = (isset($_REQUEST['search_text']) && $_REQUEST['search_text']) ? $_REQUEST['search_text']: null;

        try{
            Common::assertTrue($searchText, 'Вы не ввели посковое предписание!');
            $searchText = xss_clean(strip_image_tags(trim($_REQUEST['search_text'])));

            $this->data_menu      = array('menu' => $this->arrMenu, 'current_url' => $this->urlArr[count($this->urlArr)-1]);
            $contentArr           = $this->index_model->getSearchContent($searchText);
            $searchResult         = $this->_prepareSearchResult($contentArr, $searchText);

            $this->data_arr       = array(
                    'title'         	=> 'Springconsulting - search result'
                    ,'aforizmus'        => $this->aforizmus
                    ,'meta_keywords'	=> $this->defaultDescription
                    ,'meta_description'	=> $this->defaultKeywords
                    ,'content'       	=> $searchResult
                    ,'searching_text' 	=> $searchText
                    ,'empty_result' 	=> count($searchResult) < 1 ? 'К сожалению, по вашему запросу ничего не найдено' : null
            );

            $data = array(
                    'menu'          => $this->load->view(MENU, $this->data_menu, true),
                    'content'       => $this->load->view('blocks/search_result', $this->data_arr, true),
                    'cloud_tag'     => $this->load->view('blocks/cloud_tag', $this->cloudsTag, true),
                    'subscribe'     => $this->load->view('blocks/subscribe', count($this->subscribe) ? $this->subscribe : null, true));
            $this->load->view('layout', $data);
        } catch (Exception $e) {
            redirect(base_url());
        }
    }



    private function _prepareSearchResult($contentArr, $searchText)
    {
        $searchResult = array();
        foreach($contentArr as $blockName => $blockArr){
            foreach($blockArr as $key => $val){
                if(isset($val['text'])){
                    $val['text'] = $this->_backlightText($val['text'], $searchText);
                }
                $searchResult[$blockName][$key] = $val;
            }
        }
        return $searchResult;
    }



    private function _backlightText($text, $searchText)
    {
        /*ищем слова совпадения в возвращаемом тексте*/
        $textCut = strstr($text,$searchText);

        /*обрезаем до 20 слов начиная со слова-совпадения*/
        $textCutLink = Common::cutString($textCut, 20);

        /*подсвечиваем совпадения с искомым словом*/
        return str_replace($searchText, "<font style='color:green'><b>".$searchText."</b></font>", $textCutLink );
    }

    
    
    private function _getFirstImgFromText($text)
    {
        $matches = array();
        preg_match('/\<img.*?src=(\'|\")(.*?.[jpg|png|jpeg])(\'|\")/is', $text, $matches);
	
        $imgParts = count($matches) > 0 && $matches[2] ? explode("/",$matches[2]) : null;
        $imgFB = $imgParts ? $imgParts[count($imgParts)-1] : 'spring_logo.png';
                 
        return $imgFB;
    }


    
    public function sale($slug)
    {
//       $this->data_menu      = array('menu' => $this->arrMenu,'current_url' => $this->urlArr[count($this->urlArr)-1]);
       $salePageArr          = $this->index_model->getFromTableByParams(array('slug' => $slug, 'status' => STATUS_ON), 'sale_page');
       if(count($salePageArr) < 1)  redirect('/index');
       $saleProductsArr      = $this->index_model->getArrWhere('sale_products', 
                                                                array('sale_page_id' => $salePageArr[0]['id'], 'status' => STATUS_ON), 
                                                                '', '' , 'sequence_num');
       $title                = count($salePageArr) > 0 ? $salePageArr[0]['title'] : 'sale page';
       $this->data_arr       = array(
             'title'         	=> SITE_TITLE.' - '.$title
            ,'meta_keywords'	=> $this->defaultDescription
            ,'meta_description'	=> $this->defaultKeywords
            ,'content'       	=> $salePageArr[0]
            ,'sale_products'    => count($saleProductsArr) > 0 ? $saleProductsArr : null
            ,'payment_form'     => $this->load->view('blocks/payment_form', '', true)
       );

       $data = array('content' => $this->load->view('index/show_sale', $this->data_arr, true));
       $this->load->view('layout_sale', $data);

    }
    
    
    
    public function ajax_payment_registration()
    {
        $recipinetDataArr = $saleHistoryArr = array();
        $recipinetDataArr['name']       = trim(strip_tags($_REQUEST['name']));
        $recipinetDataArr['email']      = trim(strip_tags($_REQUEST['email']));
        $recipinetDataArr['created_at'] = date('Y-m-d H:i:s');
        $recipinetDataArr['confirmed']  = STATUS_ON;
        
        $saleHistoryArr['created_at']       = date('Y-m-d H:i:s');
        $saleHistoryArr['sale_products_id'] = trim(strip_tags($_REQUEST['sale_products_id']));

        return $this->check_valid_payment_registration($recipinetDataArr, $saleHistoryArr);
    }



    public function check_valid_payment_registration($recipinetDataArr, $saleHistoryArr)
    {
        $recipient = $errLogData = array();
        try{
            $rules      = $this->_prepareRulesSubscribeForm();
            $this->_checkValid($rules);
            
            $recipient  = $this->_getRecipientData($recipinetDataArr);
            $saleHistoryArr['recipients_id'] = $recipient['id'];
            $saleHistoryId = $this->index_model->addInTable($saleHistoryArr, 'sale_history');
            Common::assertTrue($saleHistoryId, "<p class='error'>К сожалению, при регистрации произошла ошибка.<br/>Пожалуйста, попробуйте еще раз</p>");              

            $this->result["success"]    = true;
            $this->result["data"]       = array('sale_history_id' => $saleHistoryId, 'recipients_id' => $recipient['id']);
        } catch (Exception $e){
            $this->result['message'] = $e->getMessage();
            
            $errLogData['resource_id']  = ERROR_PAYMENT_REGISTRATION;
            $errLogData['text']         = $e->getMessage()." - Продающая страница: ".$saleHistoryArr['sale_products_id']."(".$recipinetDataArr['name']." - ".$recipinetDataArr['email'].")";
            $errLogData['created_at']   = date('Y-m-d H:i:s');
            $this->index_model->addInTable($errLogData, 'error_log');
        }

        print json_encode($this->result);
        exit;
    }
    
  
    
    public function sale_payment($saleStatusId)
    {
        $paymentData    = $paymentUpdateRules = array();
        list($paymentData, $paymentUpdateRules) = $this->_makePaymentDataFromRequest();
        $saleShopId     = trim(strip_tags($_REQUEST['ik_shop_id']));
         try{
            Common::assertTrue($saleStatusId == SALESTATUSID, 'Sale status ID:'.$saleStatusId.' is wrong');
            Common::assertTrue($saleShopId == SALESHOPID, 'Sale shop ID:'.$saleShopId.' is wrong');
            Common::assertTrue(count($paymentData), 'Данных(paymentData) для апдейта не достаточно');
            Common::assertTrue(count($paymentUpdateRules), 'Данных(paymentUpdateRules) для апдейта не достаточно');

            $updateResult = $this->index_model->updateSaleHistoryByParams($paymentData, $paymentUpdateRules);
            Common::assertTrue($updateResult, "Sale history table was not updated by: id-".$paymentUpdateRules['sale_history_id'].'|sale_products_id-'.$paymentUpdateRules['sale_history_id'].'|recipients_id-'.$paymentUpdateRules['recipients_id']);              
            $paymentData['payment_description'] = trim(strip_tags($_REQUEST['ik_payment_desc']));
        } catch (Exception $e){
            $errLogData['resource_id']  = ERROR_PAYMENT_CALLBACK;
            $errLogData['text']         = $e->getMessage()." - Продающая страница: ".$saleHistoryArr['sale_products_id']."(".$recipinetDataArr['name']." - ".$recipinetDataArr['email'].")";
            $errLogData['created_at']   = date('Y-m-d H:i:s');
            $this->index_model->addInTable($errLogData, 'error_log');
        }
    }
    
    
    
    private function _makePaymentDataFromRequest()
    {
        $paymentData['payment_system']      = trim(strip_tags($_REQUEST['ik_paysystem_alias']));
        $paymentData['payment_state']       = trim(strip_tags($_REQUEST['ik_payment_state']));
        $paymentData['payment_trans_id']    = trim(strip_tags($_REQUEST['ik_trans_id']));
        $paymentData['payment_date']        = date('Y-m-d H:m:s', trim(strip_tags($_REQUEST['ik_payment_timestamp'])));
        
        $recipSaleIdArr = explode('|', trim(strip_tags($_REQUEST['ik_baggage_fields'])));
        $paymentUpdateRules['recipients_id']    = $recipSaleIdArr[0];
        $paymentUpdateRules['sale_history_id']  = $recipSaleIdArr[1];
        $paymentUpdateRules['sale_products_id'] = trim(strip_tags($_REQUEST['ik_payment_id']));
        
        return array($paymentData, $paymentUpdateRules);
    }
    
    
    
    public function success_sale()
    {
       $this->data_arr       = array(
             'title'         	=> SITE_TITLE.' - успешная оплата услуг'
            ,'meta_keywords'	=> $this->defaultDescription
            ,'meta_description'	=> $this->defaultKeywords
            ,'content'       	=> "сообщение"
       );
       $this->data_menu = array('menu'          => $this->arrMenu, 
                                'current_url'   => $this->urlArr[count($this->urlArr)-1]);
       
       $data = array('content'  => $this->load->view('index/show_success_sale', $this->data_arr, true),
                     'menu'     => $this->load->view(MENU, $this->data_menu, true));
       $this->load->view('layout_sale', $data);
    }
    
    
    
    public function faild_sale()
    {
Common::debugLogProd('faild_sale'); 
Common::debugLogProd($_REQUEST);
        redirect('/index');
    }
    
    
    
    private function _prepareMenu()
    {
       return $this->menu_model->childs;
    }


    
    private function _getAforizmus()
    {
        return $this->index_model->getAforizmusByRandom();
    }



    private function _prepareSubscribe()
    {
       return array('subscribeArr' => $this->index_model->getSubscribe());
    }
    
    
    
    private function _getCloudsTag()
    {
        return $this->index_model->getCloudsTag();
    }
}