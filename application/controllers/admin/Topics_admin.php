<?php
/**
 * @author Litkovskiy
 * @copyright 2012
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Topics_admin extends CI_Controller
{
    public  $emptyTopicList = array();
    private $data           = array();
    public  $message;
    public  $result;
    public  $urlArr;

    /** @var  Index_admin */
    public $index_model;
    /** @var  Login_model */
    public $login_model;
    /** @var  Login_model */
    public $topics_model;
    /** @var  Edit_menu_model */
    public $edit_menu_model;
    /** @var  Assign_model */
    public $assign_model;
    /** @var  CI_Form_validation */
    public $form_validation;
    /** @var  CI_Session */
    public $session;

    public function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('username') && !$this->session->userdata('loggedIn')) {
            $this->login_model->logOut();
        }

        $this->emptyTopicList = array(
            'id'     => null,
            'name'   => null,
            'status' => null
        );

        $this->result  = array("success" => null, "message" => null, "data" => null);
        $this->urlArr  = explode('/', $_SERVER['REQUEST_URI']);
        $this->message = null;
    }

    public function index()
    {
        $topicListWithArticles = $this->topics_model->getTopicListWithArticlesAdmin();
        $topicArticlesMap      = $this->_prepareTopicArticlesMap($topicListWithArticles);

        $contentData = array(
            'title'            => 'Springconsulting - admin',
            'topicArticlesMap' => $topicArticlesMap,
            'message'          => $this->message
        );

        $data = array(
            'menu'    => $this->load->view(MENU_ADMIN, '', true),
            'content' => $this->load->view('admin/topics/show', $contentData, true));

        $this->load->view('layout_admin', $data);
    }

    private function _prepareTopicArticlesMap(array $topicListWithArticles)
    {
        $map = array();

        foreach ($topicListWithArticles as $topicData) {
            $map[ArrayHelper::arrayGet($topicData, 'id')]['data']          = $topicData;
            $map[ArrayHelper::arrayGet($topicData, 'id')]['articleList'][] = $topicData;
        }

        return $map;
    }

    public function topic_edit($id = null)
    {
        $topicData      = array();
        $assignArticles = array();
        $title          = "Добавить topic";

        $articleList = $this->index_model->getListFromTable('articles');

        if ($id) {
            $topicData      = $this->topics_model->getFromTableByParams(['id' => $id], 'topics');
            $assignArticles = $this->index_model->getAssignedArticleListByTopicId($id);

            $title = "Редактировать topic";
        }

        $content        = ArrayHelper::arrayGet($topicData, 0, $this->emptyTopicList);
        $url            = $this->index_model->prepareUrl($this->urlArr);
        $content['url'] = $url;

        $this->data = array(
            'title'          => $title,
            'content'        => $content,
            'menu_items'     => $this->edit_menu_model->childs,
            'assignArticles' => $assignArticles,
            'articleList'    => $articleList,
            'message'        => $this->message
        );

        $data = array(
            'menu'    => $this->load->view(MENU_ADMIN, '', true),
            'content' => $this->load->view('admin/topics/edit', $this->data, true));

        $this->load->view('layout_admin', $data);
    }


    public function check_valid_article()
    {
        $data            = $params = array();
        $id              = isset($_REQUEST['id']) && $_REQUEST['id'] ? $_REQUEST['id'] : null;
        $assignedNewArticleIds = isset($_REQUEST['new_article_id']) && $_REQUEST['new_article_id'] ? $_REQUEST['new_article_id'] : array();
        $assignedOldArticleIds = isset($_REQUEST['old_article_id']) && $_REQUEST['old_article_id'] ? $_REQUEST['old_article_id'] : array();

        try {
            $this->_formValidation();
            $data = $this->_prepareTopicDataForAddUpdate($_REQUEST);

            if ($id) {
                $params ['id'] = $id;
                $dataUpdate    = array('status'       => $_REQUEST['status']
                );

                $data = array_merge($data, $dataUpdate);

                if (count($assignedNewArticleIds)) {
                    $this->_assignProcess($assignedNewArticleIds, $assignedOldArticleIds, $id);
                }

                $this->_update($data, $params);
            } else {
                $dataAdd = array('status' => STATUS_ON);

                $data = array_merge($data, $dataAdd);

                $id = $this->_add($data);
                Common::assertTrue($id, 'Форма заполнена неверно');

                if (count($assignedNewArticleIds)) {
                    $this->_assignProcess($assignedNewArticleIds, $assignedOldArticleIds, $id);
                }

                redirect('backend/news');
            }

        } catch (Exception $e) {
            $this->article_edit($id);
        }
    }


    private function _assignProcess($assignMenuIdArr, $oldAssignMenuId, $id)
    {
        $assignsArr = array(
            'newSourceIdArr'    => $assignMenuIdArr
            , 'oldSourceIdArr'  => $oldAssignMenuId
            , 'assignId'        => $id
            , 'assignFieldName' => 'articles_id'
            , 'sourceFieldName' => 'menu_id'
            , 'table'           => 'assign_articles');

        $this->assign_model->setAssignArr($assignsArr);
        $this->assign_model->addOrDeleteAssigns();
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
                'field' => 'title',
                'label' => '<Название раздела>',
                'rules' => 'required')
            , array(
                'field' => 'slug',
                'label' => '<Алиас раздела>',
                'rules' => 'required')
            , array(
                'field' => 'text',
                'label' => '<Текст>',
                'rules' => 'required')
            , array(
                'field' => 'date',
                'label' => '<Дата>',
                'rules' => 'required'));
    }


    private function _prepareTopicDataForAddUpdate($request)
    {
        return array('title' => $request['title']);
    }


    public function ajax_send_article_to_subscribers()
    {
        $errLogData = array();
        $articleId  = $_REQUEST['article_id'] && is_numeric($_REQUEST['article_id']) ? $_REQUEST['article_id'] : null;
        try {
            Common::assertTrue($articleId, 'Ошибка! Не установлен идентификатор статьи');
            $articlesArr   = $this->index_model->getDetailContent($articleId);
            $articleDetail = count($articlesArr) ? $articlesArr[0] : null;
            Common::assertTrue($articleDetail, 'Ошибка! Нет данных по запрашиваемой статье');

            $recipientsArr = $this->index_model->getNlSubscribers();
            Common::assertTrue(count($recipientsArr), 'Не найден ни один подписчик для отправки');

//            $sentMailCounter = $this->_sendNlSubscribe($recipientsArr, $articleDetail);
//            Common::assertTrue($sentMailCounter > 0, 'Ошибка! Не было отправлено ни одного письма');
            $this->_unisenderCreateEmailMessage($articleDetail);

            $isUpdated = $this->_updateArticleStatusIsMailSent($articleDetail['id']);
            Common::assertTrue($isUpdated, 'Ошибка! Статус сатьи не был изменен на is mail sent');
            $this->result['success'] = true;
        } catch (Exception $e) {
            $this->result['message'] = $e->getMessage();

            $errLogData['resource_id'] = ERROR_SRC_ARTICLE_MAILER;
            $errLogData['text']        = $e->getMessage() . " - Название статьи: " . $articleDetail['title'];
            $errLogData['created_at']  = Common::getDateTime('Y-m-d H:i:s');
            $this->index_model->addInTable($errLogData, 'error_log');
        }

        print json_encode($this->result);
        exit;
    }

    private function _add($data)
    {
        return $this->index_model->addInTable($data, 'topics');
    }


    private function _update($data, $params)
    {
        if ($this->index_model->updateInTable($params['id'], $data, 'topics')) {
            redirect('backend/news');
        } else {
            throw new Exception('Not updated');
        }
    }


    public function drop($id)
    {
        try {
            $this->index_model->delFromTable($id, 'topics');
            $assignArticlesArr = $this->index_model->getFromTableByParams(array('articles_id' => $id), 'assign_articles');

            if (count($assignArticlesArr)) {
                foreach ($assignArticlesArr as $assignArticles) {
                    $this->index_model->delFromTable($assignArticles['id'], 'assign_articles');
                }
            }
            $this->result['success'] = true;
        } catch (Exception $e) {
            $this->result['message'] = $e->getMessage();
        }

        print json_encode($this->result);
        exit;
    }
}