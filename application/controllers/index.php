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
       $this->result            = array("success" => null, "message" => null, "data" => null);
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
       $announcement        = $this->index_model->getFromTableByParams(array('status' => STATUS_ON),'announcement');

       $this->data_arr      = array_merge($this->_getDataArrForAction($title, $contentArr),
                                   array(
                                     'content'       	=> $contentArr
                                    ,'pager'         	=> $pager
                                    ,'current_page'     => $currentPage
                                    ,'disqus'           => show_disqus()
                                    ,'announcement'     => count($announcement) ? $announcement[0] : null
                               ));

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

        $this->data_arr      = array_merge($this->_getDataArrForAction($title, $contentArr),
                                    array(
                                    'titleFB'         	=> SITE_TITLE.' - '.(count($contentArr) > 0 && $contentArr[0]['title']) ? $contentArr[0]['title'] : $title
                                    ,'imgFB'         	=> (count($contentArr) > 0 && $contentArr[0]['text']) ? $this->_getFirstImgFromText($contentArr[0]['text']) : 'spring_logo.png'
                                    ,'content'       	=> $contentArr[0]
                                    ,'articles'       	=> $articlesArr
                                    ,'materials'       	=> $materialsArr
                                    ,'contact_form'    	=> $slug == 'contacts' ? $this->load->view('blocks/contact_form', $this->contactFormArr, true) : null
                                    ,'is_article'	    => false
                                    ,'disqus'           => $slug == 'reviews' ? show_disqus() : null
                                ));

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

        $this->data_arr      = array_merge($this->_getDataArrForAction($title, $contentArr),
                                array(
                                     'titleFB'         	=> SITE_TITLE.' - '.(count($contentArr) > 0 && $contentArr[0]['title']) ? $contentArr[0]['title'] : $title
                                    ,'imgFB'         	=> (count($contentArr) > 0 && $contentArr[0]['text']) ? $this->_getFirstImgFromText($contentArr[0]['text']) : 'spring_logo.png'
                                    ,'content'       	=> $contentArr[0]
                                    ,'articles'       	=> null
                                    ,'materials'       	=> null
                                    ,'is_article'	    => true
                                    ,'disqus'           => show_disqus()
                                ));

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
        $title               = 'статьи';
        if($contentArr){
            foreach($contentArr as $key => $content){
                $contentArr[$key]['slug_title'] = 'Статьи';
            }
        }
        $this->data_arr      = array_merge($this->_getDataArrForAction($title, $contentArr),
                                array(
                                     'content'       	=> $contentArr
                                    ,'pager'         	=> $pager
                                    ,'current_page'     => $currentPage
                                    ,'disqus'           => show_disqus()
                                ));

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


    protected function _prepareRulesSubscribeForm()
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



    protected function _trySubscribeProcess($data)
    {
        $data['created_at']  = date('Y-m-d H:i:s');

        if(!isset($_REQUEST['subscribe_id'])){
            $data['confirmed'] = STATUS_ON;            
        }
        $recipientDataArr = $this->index_model->getRecipientData($data);
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



    protected function _freeProductProcess($data, $recipientDataArr, $hashLink)
    {
        if($recipientDataArr['confirmed'] == STATUS_ON){
            return $this->_showPopUpHashLink($hashLink);
        } else {
            $this->result["success"] = true;
            return $this->_subscribeMailProcess($data, $recipientDataArr, $hashLink);
        }
    }



    protected function _subscribeArticlesProcess($data, $recipientDataArr)
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



    protected function _showPopUpHashLink($hashLink)
    {
        $urlParts   = explode('/', $hashLink);
        $hash       = $urlParts[count($urlParts)-1];
        $finishSubscribeProcessData = $this->_finishSubscribeProcess($hash);

        $this->result["success"] = true;        
        $this->result["data"] 	= "<p class='subscribe_success'>Материалы бесплатного продукта<br/>
                                    Вы можете скачать прямо сейчас:<br/>
                                    <a id='success' href='".$finishSubscribeProcessData['url']."'><img src='/img/img_main/floppy_disk.png'/><br/>
                                    Скачать материал</a></p>";

        return $this->result;
    }



    protected function _showPopUpAlreadySubscribed($recipientDataArr)
    {
        $this->result["success"] = true;
//        $this->result["data"] 	= "<p class='subscribe_success'>Добрый день, ".$recipientDataArr['name']."!<br/>
//                                    Вы уже подписаны на рассылку статей по личной эффективности с сайта Spring Consult.<br/>
//                                    Если вы по какой-либо причине не получаете материалы - пожалуйста, сообщите об этом <a id='success' href='".base_url()."show/contacts'>администратору сайта</a></p>";
        $this->result["data"] 	= "<p class='subscribe_success'>Добрый день, ".$recipientDataArr['name']."!<br/>
                                    Вы успешно подписались на рассылку статей по личной эффективности от Елены Литковской.</p>";

        return $this->result;
    }



    protected function _subscribeMailProcess($data, $recipientDataArr, $hashLink)
    {
        $this->_trySendSubscribeMail($data, $recipientDataArr, $hashLink);
        try{
            $this->_trySendSubscribeAdminMail($data);
            $this->_tryAddMailHistory($data, $recipientDataArr);
        } catch (Exception $e){
            $this->mailer_model->sendAdminErrorEmailMessage($e->getMessage());
        }
    }



    protected function _trySendSubscribeMail($data, $recipientDataArr, $hashLink)
    {
        $messId = $data['subscribe_id'] > 0 ? $this->mailer_model->sendFreeProductSubscribeEmailMessage($data, $recipientDataArr, $hashLink) : $this->mailer_model->sendArticleSubscribeConfirmationEmailMessage($recipientDataArr, $hashLink);
        Common::assertTrue($messId, "<p class='error'>К сожалению, письмо с сылкой на материал не было отправлено.<br/>Пожалуйста, попробуйте еще раз</p>");
        $this->result['success'] = true;
        $this->result["data"] = "<p class='success'>Спасибо за подписку!<br>На Ваш e-mail отправлено письмо для подтверждения вашей подписки. Проверьте Ваш почтовый ящик - папку Входящие и СПАМ.</p>";            
    }



    protected function _trySendSubscribeAdminMail($data)
    {
        $messId = $this->mailer_model->sendAdminSubscribeEmailMessage($data);
        Common::assertTrue($messId, "<p class='error'>Ошибка при попытке отправить AdminSubscribeEmailMessage</p>");
    }



    protected function _tryAddMailHistory($data, $recipientDataArr)
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
            $this->index_model->tryUnisenderSubscribe($recipientDataArr[0]);
        }
        return (array('url' => $linksPackerData['url'], 'subscribe_id' => $linksPackerData['subscribe_id'],'recipient_id' => $recipientId));
    }



    public function show_finish_subscribe($finishSubscribeProcessDataArr)
    {
        $this->data_menu            = array('menu' => $this->arrMenu,'current_url' => $this->urlArr[count($this->urlArr)-1]);
        $recipientData              = $this->index_model->getRecipientIdById($finishSubscribeProcessDataArr['recipient_id']);
        $subscribeId                = $finishSubscribeProcessDataArr['subscribe_id'];
        $finishSubscribeTamplate    = $subscribeId > 0 ? 'index/finish_free_product_subscribe' : 'index/finish_articles_subscribe';

        $this->data_arr             = array(
                                 'title'         	=> SITE_TITLE.' - subscribe'
                                ,'aforizmus'        => $this->aforizmus
                                ,'meta_keywords'	=> $this->defaultDescription
                                ,'meta_description'	=> $this->defaultKeywords
                                ,'recipient_data'  	=> $recipientData
                                ,'url'              => $finishSubscribeProcessDataArr['url']
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
            $messId                 = $this->mailer_model->sendEmailMessage($data);
            Common::assertTrue($messId, "<p class='error'>К сожалению, сообщение не было отправлено.<br/>Пожалуйста, попробуйте еще раз</p>");

            $this->result['success']    = true;
            $this->result['data']       = "<p class='success'>Сообщение успешно отправлено!</p>";
        } catch (Exception $e){
            $this->result['message'] = $e->getMessage();
        }

        print json_encode($this->result);
        exit;
    }

    

    protected function _checkValid($rules)
    {
        $isValid = $this->form_validation->set_rules($rules);
        Common::assertTrue($isValid, "<p class='error'>Форма заполнена неверно</p>");

        return true;
    }



    protected function _prepareRulesContactForm()
    {
         return array(  'field'	=> 'text',
                        'label'	=> 'Сообщение',
                        'rules'	=> 'required|xss_clean');
    }



    protected function _getDataArrForAction($title, $contentArr)
    {
        return array(
        'title'         	=> SITE_TITLE.' - '.$title

        ,'aforizmus'        => $this->aforizmus
        ,'meta_keywords'	=> (count($contentArr) > 0 && $contentArr[0]['meta_keywords']) ? $contentArr[0]['meta_keywords'] : $this->defaultDescription
        ,'meta_description'	=> (count($contentArr) > 0 && $contentArr[0]['meta_description']) ? $contentArr[0]['meta_description'] : $this->defaultKeywords
        );
    }



    private function _getFirstImgFromText($text)
    {
        $matches = array();
        preg_match('/\<img.*?src=(\'|\")(.*?.[jpg|png|jpeg])(\'|\")/is', $text, $matches);
	
        $imgParts = count($matches) > 0 && $matches[2] ? explode("/",$matches[2]) : null;
        $imgFB = $imgParts ? $imgParts[count($imgParts)-1] : 'spring_logo.png';
                 
        return $imgFB;
    }



    protected function _prepareMenu()
    {
       return $this->menu_model->childs;
    }



    protected function _getAforizmus()
    {
        return $this->index_model->getAforizmusByRandom();
    }



    protected function _prepareSubscribe()
    {
       return array('subscribeArr' => $this->index_model->getSubscribe());
    }



    protected function _getCloudsTag()
    {
        return $this->tags_model->getCloudsTag();
    }
}