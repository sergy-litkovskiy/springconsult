<?php
/**
 * @author Litkovskiy
 * @copyright 2010
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller
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

    public $topMenu   = array();

    public $arrMenu   = array();
    public $subscribe = array();
    public $aforizmus = array();
    public $urlArr    = array();
    public $cloudsTag = array();
    public $dataMenu  = array();
    public $data      = array();
    public $contactFormArr, $result;

    public function __construct()
    {
        parent::__construct();


        $this->contactFormArr = array('contact_form' => array('name' => null, 'email' => null, 'text' => null));
        $this->result         = array("success" => null, "message" => null, "data" => null);
    }

    public function index($currentPage = null)
    {
        $countTotal = $this->index_model->getCountArticles('news');
        //prepare pager config
        $config               = prepare_pager_config();
        $config['base_url']   = base_url() . 'news/page/';
        $config['total_rows'] = $countTotal;
        $this->pagination->initialize($config);
        $pager          = $this->pagination->create_links();
        $pagerParam     = array('current_page' => $currentPage, 'per_page' => $config['per_page']);
        $this->dataMenu = array('menu' => $this->arrMenu, 'current_url' => $this->urlArr[count($this->urlArr) - 1]);
        $contentArr     = $this->index_model->getNewsList($pagerParam);
        $title          = ArrayHelper::arrayGet($contentArr, '0.slug_title');
        $announcement   = $this->index_model->getFromTableByParams(array('status' => STATUS_ON), 'announcement');

        $this->data = array_merge($this->_getDataArrForAction($title, $contentArr),
            array(
                'content'        => $contentArr
                , 'pager'        => $pager
                , 'current_page' => $currentPage
                , 'disqus'       => show_disqus()
                , 'announcement' => count($announcement) ? $announcement[0] : null
            ));

        $data = array(
            'menu'      => $this->load->view(MENU, $this->dataMenu, true),
            'content'   => $this->load->view('index/show_news', $this->data, true),
            'cloud_tag' => $this->load->view('blocks/cloud_tag', $this->cloudsTag, true),
            'subscribe' => $this->load->view('blocks/subscribe', count($this->subscribe) ? $this->subscribe : null, true));

//        $this->load->view('layout', $data);
        $this->twig->display('index/index.html', $this->data);
    }

    public function show($slug)
    {
        $this->dataMenu = array('menu' => $this->arrMenu, 'current_url' => $this->urlArr[count($this->urlArr) - 1]);
        $contentArr     = $this->index_model->getContent($slug);
        $itemId         = ArrayHelper::arrayGet($contentArr, '0.id');
        $articlesArr    = $this->index_model->getContentFromTableByMenuId('article', $itemId);
        $materialsArr   = $this->index_model->getContentFromTableByMenuId('materials', $itemId);
        $slug           = ArrayHelper::arrayGet($contentArr, '0.slug');
        $text           = ArrayHelper::arrayGet($contentArr, '0.text');

        $fbTitle = sprintf('%s - %s', SITE_TITLE, ArrayHelper::arrayGet($contentArr, '0.title', $slug));
        $fbImage = $text ? $this->index_model->getFirstImgFromText($text) : DEFAULT_FB_IMAGE;

        $contentData = array(
            'titleFB'      => $fbTitle,
            'imgFB'        => $fbImage,
            'content'      => ArrayHelper::arrayGet($contentArr, 0),
            'article'     => $articlesArr,
            'materials'    => $materialsArr,
            'contact_form' => $slug == 'contacts' ? $this->load->view('blocks/contact_form', $this->contactFormArr, true) : null,
            'is_article'   => false,
            'disqus'       => $slug == 'reviews' ? show_disqus() : null
        );

        $this->data = array_merge($this->_getDataArrForAction($slug, $contentArr), $contentData);

        $data = array(
            'menu'      => $this->load->view(MENU, $this->dataMenu, true),
            'content'   => $this->load->view('index/show', $this->data, true),
            'cloud_tag' => $this->load->view('blocks/cloud_tag', $this->cloudsTag, true),
            'subscribe' => $this->load->view('blocks/subscribe', count($this->subscribe) ? $this->subscribe : null, true));

        $this->load->view('layout', $data);
    }

    public function freeProductShow()
    {
        $this->dataMenu = array('menu' => $this->arrMenu, 'current_url' => $this->urlArr[count($this->urlArr) - 1]);
        $contentArr     = $this->index_model->getSubscribePage();
        $title          = 'Подарки';

        $this->data = array_merge($this->_getDataArrForAction($title, $contentArr),
            array(
                'titleFB'   => SITE_TITLE . ' - ' . $title
                , 'imgFB'   => DEFAULT_FB_IMAGE
                , 'content' => $this->load->view('blocks/subscribe', array('subscribeArr' => $contentArr), true),
            ));

        $data = array(
            'menu'      => $this->load->view(MENU, $this->dataMenu, true),
            'content'   => $this->load->view('index/show_subscribe', $this->data, true),
            'cloud_tag' => $this->load->view('blocks/cloud_tag', $this->cloudsTag, true),
            'subscribe' => $this->load->view('blocks/subscribe', count($this->subscribe) ? $this->subscribe : null, true));
        $this->load->view('layout', $data);

    }


    public function showDetail($slug, $articleId)
    {
        $this->dataMenu = array('menu' => $this->arrMenu, 'current_url' => $this->urlArr[count($this->urlArr) - 1]);
        $contentArr     = $this->index_model->getDetailContent($articleId);

        if (!$contentArr) {
            redirect('/index');
        }

        $title = $contentArr ? $slug . ' - ' . ArrayHelper::arrayGet($contentArr, '0.slug') : null;
        $text  = ArrayHelper::arrayGet($contentArr, '0.text');

        $fbTitle = sprintf('%s - %s', SITE_TITLE, ArrayHelper::arrayGet($contentArr, '0.title', $slug));
        $fbImage = $text ? $this->index_model->getFirstImgFromText($text) : DEFAULT_FB_IMAGE;

        $this->data = array_merge($this->_getDataArrForAction($title, $contentArr),
            array(
                'titleFB'      => $fbTitle
                , 'imgFB'      => $fbImage
                , 'content'    => ArrayHelper::arrayGet($contentArr, 0)
                , 'article'   => null
                , 'materials'  => null
                , 'is_article' => true
                , 'disqus'     => show_disqus()
            ));

        $data = array(
            'menu'      => $this->load->view(MENU, $this->dataMenu, true),
            'content'   => $this->load->view('index/show', $this->data, true),
            'cloud_tag' => $this->load->view('blocks/cloud_tag', $this->cloudsTag, true),
            'subscribe' => $this->load->view('blocks/subscribe', count($this->subscribe) ? $this->subscribe : null, true));

        $this->load->view('layout', $data);
    }


    public function cloudTagList($tagMasterId, $currentPage = null)
    {
//        $this->load->library('pagination');
        $countTotal = $this->index_model->getCountArticlesByTagId($tagMasterId);

        //prepare pager config
        $config                = prepare_pager_config();
        $config['uri_segment'] = 4;
        $config['base_url']    = base_url() . 'cloudtag/' . $tagMasterId . '/page/';
        $config['total_rows']  = $countTotal;

        $this->pagination->initialize($config);

        $pager          = $this->pagination->create_links();
        $pagerParam     = array('current_page' => $currentPage, 'per_page' => $config['per_page']);
        $this->dataMenu = array('menu' => $this->arrMenu, 'current_url' => $this->urlArr[count($this->urlArr) - 1]);
        $contentArr     = $this->index_model->getArticlesListByTagId($pagerParam, $tagMasterId);
        $contentArr     = $contentArr ? $contentArr : null;
        $title          = 'статьи';

        if ($contentArr) {
            foreach ($contentArr as $key => $content) {
                $contentArr[$key]['slug_title'] = 'Статьи';
            }
        }

        $this->data = array_merge($this->_getDataArrForAction($title, $contentArr),
            array(
                'content'        => $contentArr
                , 'pager'        => $pager
                , 'current_page' => $currentPage
                , 'disqus'       => show_disqus()
            ));

        $data = array(
            'menu'      => $this->load->view(MENU, $this->dataMenu, true),
            'content'   => $this->load->view('index/show_news', $this->data, true),
            'cloud_tag' => $this->load->view('blocks/cloud_tag', $this->cloudsTag, true),
            'subscribe' => $this->load->view('blocks/subscribe', count($this->subscribe) ? $this->subscribe : null, true));

        $this->load->view('layout', $data);
    }


    public function ajax_send_subscribe()
    {
        $data          = array();
        $data['name']  = trim(strip_tags($_REQUEST['name']));
        $data['email'] = trim(strip_tags($_REQUEST['email']));

        return $this->checkValidSubscribeForm($data);
    }


    public function checkValidSubscribeForm($data)
    {
        try {
            $rules = $this->_prepareRulesSubscribeForm();
            $this->_checkValid($rules);
            Common::assertTrue($data['email'], "<p class='error'>Форма заполнена неверно. Пожалуйста, попробуйте еще раз.</p>");
            Common::assertTrue($data['name'], "<p class='error'>Форма заполнена неверно. Пожалуйста, попробуйте еще раз.</p>");

            $this->_trySubscribeProcess($data);
        } catch (Exception $e) {
            $this->result['message'] = $e->getMessage();
        }

        print json_encode($this->result);
        exit;
    }


    protected function _prepareRulesSubscribeForm()
    {
        return array(
            array(
                'field' => 'name',
                'label' => 'Name',
                'rules' => 'required|xss_clean'),
            array(
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'required|valid_email')
        );
    }


    protected function _trySubscribeProcess($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');

        if (!$subscribeId = ArrayHelper::arrayGet($_REQUEST, 'subscribe_id', 0)) {
            $data['confirmed'] = STATUS_ON;
        }

        $recipientDataArr = $this->index_model->getRecipientData($data);
        $recipientId      = ArrayHelper::arrayGet($recipientDataArr, 'id');

        Common::assertTrue(
            $recipientId,
            "<p class='error'>К сожалению, при регистрации произошла ошибка.<br/>Пожалуйста, попробуйте еще раз</p>"
        );

        $subscribeName = ArrayHelper::arrayGet($_REQUEST, 'subscribe_name', '');

        $data['subscribe_name'] = trim(strip_tags($subscribeName));
        $data['subscribe_id']   = $subscribeId;

        if ($subscribeId) {
            $hashLink = $this->index_model->hashProcess($data, $recipientId);

            Common::assertTrue(
                $hashLink,
                "<p class='error'>К сожалению, при регистрации произошла ошибка.<br/>Пожалуйста, попробуйте еще раз</p>"
            );

            $this->_freeProductProcess($data, $recipientDataArr, $hashLink);
        } else {
            $this->_subscribeArticlesProcess($data, $recipientDataArr);
        }

        return;
    }


    protected function _freeProductProcess($data, $recipientDataArr, $hashLink)
    {
        if ($recipientDataArr['confirmed'] == STATUS_ON) {
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
        $urlParts                   = explode('/', $hashLink);
        $hash                       = $urlParts[count($urlParts) - 1];
        $finishSubscribeProcessData = $this->_finishSubscribeProcess($hash);

        $this->result["success"] = true;
        $this->result["data"]    = sprintf(
            "<p class='subscribe_success'>Материалы бесплатного продукта<br/>Вы можете скачать прямо сейчас:<br/><a id='success' href='%s'><img src='/img/img_main/floppy_disk.png'/><br/>Скачать материал</a></p>",
            ArrayHelper::arrayGet($finishSubscribeProcessData, 'url'));

        return $this->result;
    }


    protected function _showPopUpAlreadySubscribed($recipientDataArr)
    {
        $this->result["success"] = true;
//        $this->result["data"] 	= "<p class='subscribe_success'>Добрый день, ".$recipientDataArr['name']."!<br/>
//                                    Вы уже подписаны на рассылку статей по личной эффективности с сайта Spring Consult.<br/>
//                                    Если вы по какой-либо причине не получаете материалы - пожалуйста, сообщите об этом <a id='success' href='".base_url()."show/contacts'>администратору сайта</a></p>";
        $this->result["data"] = sprintf(
            "<p class='subscribe_success'>Добрый день, %s!<br/>Вы успешно подписались на рассылку статей по личной эффективности от Елены Литковской.</p>",
            ArrayHelper::arrayGet($recipientDataArr, 'name')
        );

        return $this->result;
    }


    protected function _subscribeMailProcess($data, $recipientDataArr, $hashLink)
    {
        $this->_trySendSubscribeMail($data, $recipientDataArr, $hashLink);
        try {
            $this->_trySendSubscribeAdminMail($data);
            $this->_tryAddMailHistory($data, $recipientDataArr);
        } catch (Exception $e) {
            $this->mailer_model->sendAdminErrorEmailMessage($e->getMessage());
        }
    }


    protected function _trySendSubscribeMail($data, $recipientDataArr, $hashLink)
    {
        $messId = ArrayHelper::arrayGet($data, 'subscribe_id') ?
            $this->mailer_model->sendFreeProductSubscribeEmailMessage($data, $recipientDataArr, $hashLink) :
            $this->mailer_model->sendArticleSubscribeConfirmationEmailMessage($recipientDataArr, $hashLink);

        Common::assertTrue($messId, "<p class='error'>К сожалению, письмо с сылкой на материал не было отправлено.<br/>Пожалуйста, попробуйте еще раз</p>");

        $this->result['success'] = true;
        $this->result["data"]    = "<p class='success'>Спасибо за подписку!<br>На Ваш e-mail отправлено письмо для подтверждения вашей подписки. Проверьте Ваш почтовый ящик - папку Входящие и СПАМ.</p>";
    }


    protected function _trySendSubscribeAdminMail($data)
    {
        $messId = $this->mailer_model->sendAdminSubscribeEmailMessage($data);
        Common::assertTrue($messId, "<p class='error'>Ошибка при попытке отправить AdminSubscribeEmailMessage</p>");
    }


    protected function _tryAddMailHistory($data, $recipientDataArr)
    {
        $dataMailHistory['subscribe_id']  = ArrayHelper::arrayGet($data, 'subscribe_id');
        $dataMailHistory['recipients_id'] = ArrayHelper::arrayGet($recipientDataArr, 'id');
        $dataMailHistory['date']          = date('Y-m-d');
        $dataMailHistory['time']          = date('H:i:s');
        $mailHistoryId                    = $this->index_model->addInTable($dataMailHistory, 'mail_history');
        Common::assertTrue(
            $mailHistoryId,
            sprintf("<p class='error'>Ошибка! Запись в Mail_history для subscribe_id=%s и recipients_id=%s не произошла</p>",
                ArrayHelper::arrayGet($dataMailHistory, 'subscribe_id'),
                ArrayHelper::arrayGet($dataMailHistory, 'recipients_id')
            )
        );
    }


    public function finishSubscribe($hash)
    {
        try {
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

        $url         = ArrayHelper::arrayGet($linksPackerData, 'url');
        $linkId      = ArrayHelper::arrayGet($linksPackerData, 'id');
        $count       = ArrayHelper::arrayGet($linksPackerData, 'count');
        $subscribeId = ArrayHelper::arrayGet($linksPackerData, 'subscribe_id');

        $updateData = array('count' => $count + 1, 'updated_at' => date('Y-m-d H:i:s'));
        $this->index_model->updateInTable($linkId, $updateData, 'links_packer');

        $urlParts            = explode('/', $url);
        $recipientId         = $urlParts[count($urlParts) - 1];
        $updateDataRecipient = array('confirmed' => STATUS_ON);
        $this->index_model->updateInTable($recipientId, $updateDataRecipient, 'recipients');

        $recipientDataArr = $this->index_model->getFromTableByParams(array('id' => $recipientId), 'recipients');

        if ($subscribeData = ArrayHelper::arrayGet($recipientDataArr, 0)) {
            $this->index_model->tryUnisenderSubscribe($subscribeData);
        }

        return (array('url' => $url, 'subscribe_id' => $subscribeId, 'recipient_id' => $recipientId));
    }


    public function showFinishSubscribe($finishSubscribeProcessDataArr)
    {
        $this->dataMenu          = array('menu' => $this->arrMenu, 'current_url' => $this->urlArr[count($this->urlArr) - 1]);
        $recipientData           = $this->index_model->getRecipientById($finishSubscribeProcessDataArr['recipient_id']);
        $subscribeId             = ArrayHelper::arrayGet($finishSubscribeProcessDataArr, 'subscribe_id');
        $finishSubscribeTemplate = $subscribeId > 0 ? 'index/finish_free_product_subscribe' : 'index/finish_article_subscribe';

        $this->data = array(
            'title'              => SITE_TITLE . ' - subscribe'
            , 'aforizmus'        => $this->aforizmus
            , 'meta_keywords'    => DEFAULT_META_KEYWORDS
            , 'meta_description' => DEFAULT_META_DESCRIPTION
            , 'recipient_data'   => $recipientData
            , 'url'              => ArrayHelper::arrayGet($finishSubscribeProcessDataArr, 'url')
        );

        $data = array(
            'menu'      => $this->load->view(MENU, $this->dataMenu, true),
            'content'   => $this->load->view($finishSubscribeTemplate, $this->data, true),
            'cloud_tag' => $this->load->view('blocks/cloud_tag', $this->cloudsTag, true),
            'subscribe' => $this->load->view('blocks/subscribe', count($this->subscribe) ? $this->subscribe : null, true));
        $this->load->view('layout', $data);
    }


    public function outputSubscribe($subscribeId, $recipientId)
    {
        try {
            Common::assertTrue($subscribeId, "");
            $subscribeDataArr = $this->index_model->getSubscribeDataArrById($subscribeId);
            Common::assertTrue($subscribeDataArr, "");

            $this->_outputFile(ArrayHelper::arrayGet($subscribeDataArr, 'material_path'));
        } catch (Exception $e) {
            redirect('/index');
        }
    }


    private function _outputFile($fileName)
    {
        $filePath = './subscribegift/' . $fileName;
        if (file_exists($filePath)) {
            header("Content-Type: application/octet-stream");
            header("Accept-Ranges: bytes");
            header("Content-Length: " . filesize($filePath));
            header("Content-Disposition: attachment; filename=" . $fileName);
            readfile($filePath);
        } else {
            redirect('/index');
        }
    }


    public function unsubscribeProcess($hash)
    {
        $linksPackerData = $this->index_model->getLinksPackerDataByHash($hash);
        Common::assertTrue($linksPackerData, "");

        $updateData = array('count' => $linksPackerData['count'] + 1, 'updated_at' => date('Y-m-d H:i:s'));
        $this->index_model->updateInTable($linksPackerData['id'], $updateData, 'links_packer');

        $urlParts            = explode('/', $linksPackerData['url']);
        $recipientId         = $urlParts[count($urlParts) - 1];
        $updateDataRecipient = array('unsubscribed' => STATUS_ON);

        $this->index_model->updateInTable($recipientId, $updateDataRecipient, 'recipients');

        return $this->showUnsubscribePage();
    }


    public function showUnsubscribePage()
    {
        $this->dataMenu = array('menu' => $this->arrMenu, 'current_url' => $this->urlArr[count($this->urlArr) - 1]);

        $this->data = array(
            'title'              => SITE_TITLE . ' - unsubscribe'
            , 'aforizmus'        => $this->aforizmus
            , 'meta_keywords'    => DEFAULT_META_KEYWORDS
            , 'meta_description' => DEFAULT_META_DESCRIPTION
        );

        $data = array(
            'menu'      => $this->load->view(MENU, $this->dataMenu, true),
            'content'   => $this->load->view('blocks/unsubscribe_message', $this->data, true),
            'cloud_tag' => $this->load->view('blocks/cloud_tag', $this->cloudsTag, true),
            'subscribe' => $this->load->view('blocks/subscribe', count($this->subscribe) ? $this->subscribe : null, true));

        $this->load->view('layout', $data);
    }


    public function ajaxSendContactForm()
    {
        $data          = array();
        $data['name']  = trim(strip_tags($_REQUEST['name']));
        $data['email'] = trim(strip_tags($_REQUEST['email']));
        $data['text']  = trim(strip_tags($_REQUEST['text']));

        return $this->checkValidContactForm($data);
    }


    public function checkValidContactForm($data)
    {
        try {
            $rulesMain    = $this->_prepareRulesSubscribeForm();
            $rulesContact = $this->_prepareRulesContactForm();
            $rules        = array_merge($rulesMain, $rulesContact);
            $this->_checkValid($rules);

            $data['created_at'] = date('Y-m-d');
            $messId             = $this->mailer_model->sendEmailMessage($data);
            Common::assertTrue($messId, "<p class='error'>К сожалению, сообщение не было отправлено.<br/>Пожалуйста, попробуйте еще раз</p>");

            $this->result['success'] = true;
            $this->result['data']    = "<p class='success'>Сообщение успешно отправлено!</p>";
        } catch (Exception $e) {
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
        return array(
            'field' => 'text',
            'label' => 'Сообщение',
            'rules' => 'required|xss_clean'
        );
    }


    protected function _getDataArrForAction($title, $contentArr)
    {
        $metaKeywords    = ArrayHelper::arrayGet($contentArr, '0.meta_keywords', DEFAULT_META_KEYWORDS);
        $metaDescription = ArrayHelper::arrayGet($contentArr, '0.meta_description', DEFAULT_META_DESCRIPTION);

        return array(
            'title'            => SITE_TITLE . ' - ' . $title,
            'aforizmus'        => $this->aforizmus,
            'meta_keywords'    => $metaKeywords,
            'meta_description' => $metaDescription
        );
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