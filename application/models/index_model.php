<?php
/**
 * @author Litkovsky
 * @copyright 2010
 * model for index page
 */
 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index_model extends Crud
{
    public $idkey = 'id';
    public $table = 'articles';
    protected $params, $key, $tableName ;
//    protected $table = 'content';

    public function __construct()
    {
        parent::__construct();
        $this->params = array('limit' => null, 'status' => null);
        $this->key;
        $this->tableName;
    }



    public function getCountArticles($slug)
    {
        $query_parent = $this->db->query("SELECT
                                                articles.id
                                            FROM
                                                articles
                                            INNER JOIN
                                                assign_articles ON assign_articles.articles_id = articles.id
                                            INNER JOIN
                                                menu ON menu.id = assign_articles.menu_id
                                            WHERE
                                                menu.slug = '".$slug."'
                                            AND
                                                menu.status = ".STATUS_ON."
                                            AND
                                                articles.status = ".STATUS_ON);
        return $query_parent->num_rows();
    }

    
    
    public function getCountArticlesByTagId($tagMasterId)
    {
        $query_parent = $this->db->query("SELECT
                                                articles.id
                                            FROM
                                                articles
                                            INNER JOIN
                                                articles_tag ON articles_tag.articles_id = articles.id
                                            WHERE
                                                articles_tag.tag_master_id = '".$tagMasterId."'
                                            AND
                                                articles.status = ".STATUS_ON);
        return $query_parent->num_rows();
    }
    
    
    
    public function getArticlesListByTagId($pagerParam, $tagMasterId)
    {
        $currentPage = $startPage = null;
        if($pagerParam){
            $currentPage  = $pagerParam['current_page'] > 0 ? $pagerParam['current_page'] : 1;
            $startPage    = $pagerParam['per_page']*($currentPage -1 );
            $this->params['limit']        = " LIMIT ".$startPage.", ".$pagerParam['per_page'];
            $this->params['status']       = " AND articles.status = ".STATUS_ON." ";
        }
        
        $sql_query = $this->db->query("SELECT
                                            articles.*
                                        FROM
                                            articles
                                        LEFT JOIN
                                            articles_tag ON articles_tag.articles_id = articles.id
                                        WHERE
                                            articles_tag.tag_master_id = '".$tagMasterId."'
                                            ".$this->params['status']."
                                        ORDER by
                                            articles.date DESC, articles.time DESC
                                        ".$this->params['limit']."");
 
        return $sql_query->result_array();
    }
    


    public function getNewsList($pagerParam = null)
    {
        $currentPage = $startPage = null;
        if($pagerParam){
            $currentPage  = $pagerParam['current_page'] > 0 ? $pagerParam['current_page'] : 1;
            $startPage    = $pagerParam['per_page']*($currentPage -1 );
            $this->params['limit']        = " LIMIT ".$startPage.", ".$pagerParam['per_page'];
            $this->params['status']       = " AND articles.status = ".STATUS_ON." ";
        }

        $sql_query = $this->db->query($this->_prepareSqlForNewsList());
        return $sql_query->result_array();
    }



    public function getNewsListAdmin()
    {
        $sql_query = $this->db->query($this->_prepareSqlForNewsListAdmin());
        return $sql_query->result_array();
    }



    private function _prepareSqlForNewsList()
    {
        return "SELECT
                    articles.*
                    , menu_child.title AS slug_title
                    , menu_parent.title AS slug_title_parent
                    , menu_child.meta_keywords AS menu_meta_keywords
                    , menu_child.meta_description AS menu_meta_description
                FROM
                    articles
                LEFT JOIN
                    assign_articles
                ON
                    assign_articles.articles_id = articles.id
                LEFT JOIN
                    menu AS menu_child
                ON
                    menu_child.id = assign_articles.menu_id
                LEFT JOIN
                    menu AS menu_parent
                ON
                    menu_parent.id = assign_articles.menu_id
                WHERE
                    menu_child.slug = 'news'
                ".$this->params['status']."
                ORDER by
                    articles.date DESC, articles.time DESC
                ".$this->params['limit']."";
    }



    private function _prepareSqlForNewsListAdmin()
    {
        return "SELECT
                    articles.*
                    , menu_child.title AS slug_title
                    , menu_parent.title AS slug_title_parent
                FROM
                    articles
                LEFT JOIN
                    assign_articles
                ON
                    assign_articles.articles_id = articles.id
                LEFT JOIN
                    menu AS menu_child
                ON
                    menu_child.id = assign_articles.menu_id
                LEFT JOIN
                    menu AS menu_parent
                ON
                    menu_parent.id = assign_articles.menu_id
                ORDER by
                    articles.date DESC, articles.time DESC";
    }



    public function getMaterialListAdmin()
    {
        $sql =  "SELECT
                    materials.*
                    , menu_child.title AS slug_title
                    , menu_parent.title AS slug_title_parent
                    , menu_child.meta_keywords AS menu_meta_keywords
                    , menu_child.meta_description AS menu_meta_description
                FROM
                    materials
                LEFT JOIN
                    assign_materials
                ON
                    assign_materials.materials_id = materials.id
                LEFT JOIN
                    menu AS menu_child
                ON
                    menu_child.id = assign_materials.menu_id
                LEFT JOIN
                    menu AS menu_parent
                ON
                    menu_parent.id = assign_materials.menu_id";
        
        $sql_query = $this->db->query($sql);
        return $sql_query->result_array();
    }



    public function getSubscribeListAdmin($id = null)
    {
        $where = $id ? "WHERE subscribe.id = ".$id : null;
        $sql =  "SELECT subscribe.* FROM subscribe ".$where;

        $sql_query = $this->db->query($sql);
        return $sql_query->result_array();
    }



    public function getContent($slug)
    {
        return $this->getFromTableByParams(array('slug' => $slug), 'menu');
    }



    public function getSubscribe()
    {
        return $this->getFromTableByParams(array('status' => STATUS_ON), 'subscribe');
    }



    public function getContentFromTableByMenuId($table, $menuId)
    {
        $query_parent = $this->db->query("SELECT
                                                ".$table.".*
                                            FROM
                                                ".$table."
                                            INNER JOIN
                                                assign_".$table."
                                            ON
                                                assign_".$table.".".$table."_id = ".$table.".id
                                            WHERE
                                               assign_".$table.".menu_id = ".$menuId."
                                            AND
                                               ".$table.".status = ".STATUS_ON);
        return $query_parent->result_array();
    }



    public function getDetailContent($articleId)
    {
        return $this->getFromTableByParams(array('id' => $articleId, 'status' => STATUS_ON), 'articles');
    }



    public function getDetailContentAdmin($articleId)
    {
        return $this->getFromTableByParams(array('id' => $articleId), 'articles');
    }



    public function getAssignArticlesByArticleIdAdmin($articleId)
    {
        return $this->getFromTableByParams(array('articles_id' => $articleId), 'assign_articles');
    }


    
    public function getAssignTagArr($id, $table, $key)
    {
        $query = $this->db->query("SELECT
                                        ".$table.".*,
                                        tag_master.description as tag_description
                                    FROM
                                        ".$table."
                                    INNER JOIN
                                        tag_master
                                    ON
                                        tag_master.id = ".$table.".tag_master_id
                                    WHERE
                                       ".$table.".".$key." = ".$id);
        return $query->result_array();
    }

    
    
    public function getAvailableTag()
    {
        return $this->getListFromTable('tag_master');
    }
    
    
    
    public function getMaterialDetailsAdmin($materialId)
    {
        return $this->getFromTableByParams(array('id' => $materialId), 'materials');
    }



    public function getAssignMaterialsByMaterialIdAdmin($materialId)
    {
        return $this->getFromTableByParams(array('materials_id' => $materialId), 'assign_materials');
    }


    
    public function getBlockStatusListForAdmin()
    {
        $block_status = $this->db->query("SELECT
                                                block_status.*
                                                , menu.title
                                          FROM
                                                block_status
                                          LEFT JOIN 
                                                menu 
                                          ON
                                                menu.slug = block_status.slug");
        return $block_status->result_array();
    }


    
    public function getSearchContent($text)
    {
        $searchResultArr = array();
        
        $searchingText = mb_convert_case($text, MB_CASE_LOWER, "UTF-8");
        
        $searchResultArr['menuArr']         = $this->_getSearchMenuSql($searchingText);
        $searchResultArr['articlesArr']     = $this->_getSearchArticlesSql($searchingText);
        $searchResultArr['materialsArr']    = $this->_getSearchMaterialsSql($searchingText);

        return $searchResultArr;
    }


    
    private function _getSearchMenuSql($searchingText)
    {
        $sql  = $this->_prepareSearchMainSqlSelect('menu');
        $sql .= $this->_prepareSearchMainSqlWhere($searchingText);
        $queryMenu = $this->db->query($sql);
        
        return $queryMenu->result_array();
    }



    private function _getSearchArticlesSql($searchingText)
    {
        $sql  = $this->_prepareSearchMainSqlSelect('articles');
        $sql .= $this->_prepareSearchMainSqlWhere($searchingText);
        $queryArticles = $this->db->query($sql);

        return $queryArticles->result_array();
    }



    private function _getSearchMaterialsSql($searchingText)
    {
        $sql  = $this->_prepareSearchMainSqlSelect('materials');
        $sql .= " AND (LOWER(rus_name) REGEXP '^".$searchingText."' OR LOWER(rus_name) REGEXP ' ".$searchingText."' OR LOWER(rus_name) REGEXP '>".$searchingText."')";
        $queryArticles = $this->db->query($sql);

        return $queryArticles->result_array();
    }



    private function _prepareSearchMainSqlSelect($table)
    {
        return "SELECT * FROM ".$table." WHERE status = ".STATUS_ON;
    }



    private function _prepareSearchMainSqlWhere($searchingText)
    {
        return " AND ((LOWER(title) REGEXP '^".$searchingText."' OR LOWER(text) REGEXP '^".$searchingText."') 
            OR (LOWER(title) REGEXP ' ".$searchingText."' OR LOWER(text) REGEXP ' ".$searchingText."')
            OR (LOWER(title) REGEXP '>".$searchingText."' OR LOWER(text) REGEXP '>".$searchingText."'))";
    }



    public function getRecipientIdByEmail($email)
    {
        $qweryResult = $this->getFromTableByParams(array('email' => $email), 'recipients');
        $result      = $qweryResult ? $qweryResult[0] : null;

        return $result;
    }


        
    public function getRecipientIdById($id)
    {
        $qweryResult = $this->getFromTableByParams(array('id' => $id), 'recipients');
        $result      = $qweryResult ? $qweryResult[0] : null;

        return $result;
    }

    
    public function addMessage($data)
    {
        $this->addInTable($data, 'messages');
        if($this->sendEmailMessage($data)){
            return true;
        }
        else{
            return false;
        };
    }

	
	
    public function hashProcess($data, $recipientId)
    {
        $linkspackerData                    = array();
        $linkspackerData['url']             = '/frontend/finishsubscribe/'.$data["subscribe_id"].'/recip/'.$recipientId;
        $linkspackerData['hash']            = MD5($linkspackerData['url']);
        $linkspackerData['livetime']        = 30;
        $linkspackerData['subscribe_id']    = $data["subscribe_id"];
        $linkspackerData['count']           = 0;
        $linkspackerData['created_at']      = date('Y-m-d H:i:s');
        $linkspackerData['updated_at']      = date('Y-m-d H:i:s');
		
        if($this->addInTable($linkspackerData, 'links_packer')){
            return base_url().'finishsubscribe/'.$linkspackerData['hash'];
        } else {
            return false;
        };
    }


    
    public function getLinksPackerDataByHash($hash)
    {
        $qweryResult = $this->getFromTableByParams(array('hash' => $hash), 'links_packer');
        $result      = $qweryResult ? $qweryResult[0] : null;

        return $result;
    }



    public function getSubscribeDataArrById($id)
    {
        $qweryResult    = $this->getFromTableByParams(array('id' => $id), 'subscribe');
        $result         = $qweryResult ? $qweryResult[0] : null;

        return $result;
    }


    
    public function sendAdminSubscribeEmailMessage($data)
    {
        $type   = $data['subscribe_id'] > 0 ? "'Free product subscribe action( ".$data['subscribe_name']." )'" : "'Articles subscribe action'";
        $message = "Type of message: ".$type."<br/>\r\n 
                    Date: ".date('Y-m-d')." / Time ".date('H:i:s')."<br/>\r\n
                    Subscriber: ".$data['name']." (email of author :".$data['email'].")\r\n";

        return $this->_sendAdminEmailMessage($message);
    }



    public function sendAdminErrorEmailMessage($errorMess)
    {
        $message = "Type of message: 'Error message'<br/>\r\n 
                    Date: ".date('Y-m-d')." / Time ".date('H:i:s')."<br/>\r\n
                    Message error: ".$errorMess.")<br/>\r\n";

        return $this->_sendAdminEmailMessage($message);
    }


    
    public function sendEmailMessage($data)
    {
        $message = "Type of message: 'Message from contact form'<br/>\r\n 
                    Date: ".date('Y-m-d')." / Time ".date('H:i:s')."<br/>\r\n
                    Message from: ".$data['name']." (email of author :".$data['email'].").<br/>\r\n
                    Message: ".@$data['text'].".\r\n";

        return $this->_sendAdminEmailMessage($message);
    }
    

    private function _sendAdminEmailMessage($message)
    {
        $headers    = $this->_getMailHeader();
        $email      = SUPERADMIN_EMAIL;
        $subject    = "Message from Springconsulting site for admin";
        $isMailSent = mail($email, $subject, $message, $headers);

        return $isMailSent;
    }

    
    public function sendLandingSubscribeEmailMessage($landingPageData, $recipientDataArr)
    {
        $headers    = $this->_getMailHeader();
        $email      = $recipientDataArr['email'];
        $subject    = "Ваша регистрация на '".$landingPageData['title']."'";
        $body       = "<p>Добрый день, ".$recipientDataArr['name']."!</p>";
        $body      .= $landingPageData['letter_text'];
        $message    = $this->_getEmailTamplate($body);
       
        $isMailSent = mail($email, $subject, $message, $headers);

        return $isMailSent;
    }
    
    

    public function sendFreeProductSubscribeEmailMessage($data, $recipientDataArr, $hashLink)
    {
        $headers    = $this->_getMailHeader();
        $email      = $recipientDataArr['email'];
        $subject    = "Подписка на бесплатный продукт от Springconsulting";
        $body       = '<p><b>Здравствуйте, '.$recipientDataArr['name'].'!</b></p>
                                        
                        <p>На Ваш email '.date("d-m-Y").' была оформлена подписка на получение бесплатного доступа к следующим материалам : < <b>'.$data['subscribe_name'].'</b> >(Автор: Литковская Елена, Spring Consulting)</p>
						
						<p> Чтобы скачать бесплатный материал, пожалуйста, перейдите по ссылке – <a href="'.$hashLink.'">'.$hashLink.'</a></p>
                        
                        <p>В случае, если Вы НЕ подписывались на получение указанного материала, то просто не реагируйте на это письмо и Ваш email-адрес автоматически будет исключен из списка рассылки.</p>

                        <p>С наилучшими пожеланиями,</p>
                        <p>Команда Spring Consulting</p>';
        $message    = $this->_getEmailTamplate($body);
        
        $isMailSent = mail($email, $subject, $message, $headers);

        return $isMailSent;
    }
    
    
    
    public function sendArticleSubscribeConfirmationEmailMessage($recipientDataArr, $hashLink)
    {
        $headers    = $this->_getMailHeader();
        $email      = $recipientDataArr['email'];
        $subject    = "Подписка на получение новых статей от Springconsulting";
        $body       = '<p><b>Здравствуйте, '.$recipientDataArr['name'].'!</b></p>
                                        
                        <p>На Ваш email '.date("d-m-Y").' была оформлена подписка на получение новых статей по личной эффективности от коуча <a href="'.base_url().'show/about_me">Литковской Елены</a>.</p>

                        <p> Подтвердите подписку на получение новых статей, перейдя по ссылке – <a href="'.$hashLink.'">'.$hashLink.'</a></p>

                        <p>В случае, если Вы НЕ подписывались на получение указанных материалов, то просто не реагируйте на это письмо, и Ваш email-адрес автоматически будет исключен из списка рассылки.</p>

                        <p>С наилучшими пожеланиями,</p>
                        <p>Команда <a href="'.base_url().'">Spring Consulting</a></p>';
        $message    = $this->_getEmailTamplate($body);
        
        $isMailSent = mail($email, $subject, $message, $headers);

        return $isMailSent;
    }
    
    
    
    public function sendArticlesSubscribedEmail($recipient, $articleDetail, $unsubscribeLink)
    {
        $headers    = $this->_getMailHeader();
        $email      = $recipient['email'];
        $subject    = "Новая статья на сайте Spring Сonsulting";
        $body       = '<p><b>Добрый день, '.$recipient['name'].'!</b></p>
                                        
                        <p>Для вас новая статья <b>"'.$articleDetail['title'].'"</b> на сайте "Spring Сonsulting",<br> 
                        читайте здесь: <a href="'.base_url().'articles/'.$articleDetail['id'].'">'.base_url().'articles/'.$articleDetail['id'].'</a></p> 
                        
                        <p><i><a style="color:#58753E; text-decoration: none; " href="'.base_url().'articles/'.$articleDetail['id'].'">'.Common::cutString($articleDetail['text'], 100).'</a></i></p>

                        <p>Продолжение читайте здесь: <a href="'.base_url().'articles/'.$articleDetail['id'].'">'.base_url().'articles/'.$articleDetail['id'].'</a></p>

                        <p>Приятного вам чтения!</p>

                        <p>Литковская Елена и команда <a href="'.base_url().'">Spring Consulting</a></p>
                        <hr>    
                        <p style="font-size:8pt">Вы получили это письмо в рамках рассылки компании  "Spring Сonsulting". 
                        Если по определенным причинам Вы не желаете в дальнейшем получать от нас информационные сообщения, вы можете отписаться от рассылки <a style="color:blue" href="'.$unsubscribeLink.'">'.$unsubscribeLink.'</a>.
                        </p>';
        $message    = $this->_getEmailTamplate($body);
        
        $isMailSent = mail($email, $subject, $message, $headers);

        return $isMailSent;
    }
    
    
        
    public function getUnisenderSubscribeEmailTpl($articleDetail)
    {
        $baseUrl = base_url().'logo_top.png';
        return '
            <table border="0" cellpadding="0" cellspacing="0" width="650" align="left">
                    <tr>
                        <td style="background:#D8FDB7; vertical-align:top; width: 66px">
                            <img width="66" src="'.$baseUrl.'" />
                        </td>
                        <td style="padding: 1px 1px 5px 10px;; vertical-align:top">            
                            <p><b>Добрый день, {{Name}}!</b></p>

                            <p>Для вас новая статья <b>"'.$articleDetail['title'].'"</b> на сайте "Spring Сonsulting",<br> 
                            читайте здесь: <a href="'.base_url().'articles/'.$articleDetail['id'].'">'.base_url().'articles/'.$articleDetail['id'].'</a></p> 

                            <p><i><a style="color:#58753E; text-decoration: none; " href="'.base_url().'articles/'.$articleDetail['id'].'">'.Common::cutString($articleDetail['text'], 100).'</a></i></p>

                            <p>Продолжение читайте здесь: <a href="'.base_url().'articles/'.$articleDetail['id'].'">'.base_url().'articles/'.$articleDetail['id'].'</a></p>

                            <p>Приятного вам чтения!</p>

                            <p>Литковская Елена и команда <a href="'.base_url().'">Spring Consulting</a></p>
                            <hr>    
                            <p style="font-size:8pt">Вы получили это письмо в рамках рассылки компании  "Spring Сonsulting". 
                            Если по определенным причинам Вы не желаете в дальнейшем получать от нас информационные сообщения, вы можете отписаться от рассылки перейдя по ссылке ниже.
                            </p>
                        </td>
                    </tr>
            </table>';
    }
    
    
    
    private function _getEmailTamplate($body)
    {
        return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                        <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru">
                        <head>
                            <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
                            <title>SpringConsult</title>
                        </head>
                        <body>
                            <table border="0" cellpadding="0" cellspacing="0" width="650" align="center">
                                <tr>
                                    <td style="background:#D8FDB7; vertical-align:top; width: 66px">
                                        <img width="66" src="'.base_url().'logo_top.png" alt="SpringConsult" />
                                    </td>
                                    <td style="padding: 1px 1px 5px 10px;; vertical-align:top">
                                        '.$body.'
                                    </td>
                                 </tr>
                            </table>
                        </body>
                            <style type="text/css">
                                body {
                                    margin: 0;
                                    background: #fff;
                                    font-size: 14px;
                                }
                                p { margin-bottom: 16px; font-size: 10pt; color:#4E4E4E}
                                a {color:red; font-size:10pt}
                                a:hover { text-decoration: none; }
                                td {height:250; vertical-align: top}
                                table {border: solid 1px #B4D795;}
                            </style>
                        </html>';
    }
    
    

    private function _getMailHeader()
    {
        $headers  = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n";
        $headers .= "From: spring@springconsult.com.ua \r\n";
        
        return $headers;
        
    }
    
    
	
    public function delFromTableByParams($assignsArr, $oldAssignMenuId)
    {
        $this ->db->where($assignsArr['assignFieldName'], $assignsArr['id']);
        $this ->db->where('menu_id', $oldAssignMenuId);
        if(!$this->db->delete($assignsArr['table']))
        {
            return false;
        }
        return true;
    }

    

    public function getAforizmusByRandom()
    {
        $qweryResult = $this->db->query("SELECT * FROM `aforizmus` WHERE id >= (SELECT FLOOR( MAX(id) * RAND()) FROM `aforizmus` ) ORDER BY id LIMIT 1");
        $result = $qweryResult->result_array();
        
        return $result ? $result[0] : null;
    }
    
    
    
    public function getAforizmusList()
    {
        return $this->getListFromTable('aforizmus');
    }
    
    
    
    public function getArticlesForRssByParams($params)
    {
        $qweryResult = $this->db->query("SELECT * FROM `articles` WHERE status = ".STATUS_ON." ORDER BY date DESC LIMIT ".$params['limit']);
        $articelsArr = $qweryResult->result_array();
        
        return $articelsArr ? $articelsArr : null;
    }
    
    
    
    public function getNlSubscribers()
    {
        //TODO: inner join on mail_history
        return $this->getFromTableByParams(array('confirmed' => STATUS_ON, 'unsubscribed' => STATUS_OFF), 'recipients');
    }
    
    
    
    public function unsubscribeHashProcess($recipientId)
    {
        $linkspackerData                    = array();
        $linkspackerData['url']             = '/frontend/unsubscribe/re/'.$recipientId;
        $linkspackerData['hash']            = MD5($linkspackerData['url']);
        $linkspackerData['livetime']        = 30;
        $linkspackerData['subscribe_id']    = 0;
        $linkspackerData['count']           = 0;
        $linkspackerData['created_at']      = date('Y-m-d H:i:s');
        $linkspackerData['updated_at']      = date('Y-m-d H:i:s');
		
        if($this->addInTable($linkspackerData, 'links_packer')){
            return base_url().'unsubscribe/'.$linkspackerData['hash'];
        } else {
            return false;
        };
    }
    
    
    
    public function findTagMasterIdByDescription($description)
    {
        $qwery = $this->db->query("SELECT id FROM tag_master WHERE description = '".$description."'");
      
        $result = $qwery->result_array();
        
        return $result ? $result[0]['id'] : null;
    }
    
     
    
    public function deleteArticlesTagByTagIdAndArticlesId($tagMasterId, $id)
    {   
        return $this->db->query("DELETE FROM ".$this->tableName." WHERE tag_master_id = ".$tagMasterId." AND ".$this->key." = ".$id."");
    }
    
    
    
    public function getCloudsTag()
    {
        $tagMaster = $this->db->query("SELECT
                                            tag_master.*
                                            , COUNT(articles_tag.id) AS articles_tag_amount
                                      FROM
                                            tag_master
                                      LEFT JOIN 
                                            articles_tag 
                                      ON
                                            articles_tag.tag_master_id = tag_master.id
                                      INNER JOIN 
                                            articles 
                                      ON
                                            articles.id = articles_tag.articles_id  
                                      WHERE
                                            articles.status = ".STATUS_ON."
                                      GROUP BY
                                            tag_master.id");
        $arrTagMaster = $tagMaster->result_array();
        
        return $this->_prepareCloudsTag($arrTagMaster);        
    }
    
    
    
    private function _prepareCloudsTag($arrTagMaster)
    {
        list($min, $max) = $this->_getMinMaxCountTags($arrTagMaster);
        return $this->_prepareArrCloudsTag($arrTagMaster, $min, $max);
    }
    
    
    
    private function _getMinMaxCountTags($arrTagMaster)
    {
        $min = $max = 0;
        for ($i = 1; $i < count($arrTagMaster); $i++) {
            if ($arrTagMaster[$i]['articles_tag_amount'] > $max) {
                $max = $arrTagMaster[$i]['articles_tag_amount'];
            }
            if ($arrTagMaster[$i]['articles_tag_amount'] < $min) {
                $min = $arrTagMaster[$i]['articles_tag_amount'];
            }
        }
        
        return array($min, $max);
    }
    
    
    
    private function _prepareArrCloudsTag($arrTagMaster, $min, $max)
    {
        $fontSize   = 0;
        $minSize    = 70;
        $maxSize    = 150;
        
        foreach ($arrTagMaster as $key => $tag) {
            if ($min == $max) {
                $fontSize = round(($maxSize - $minSize)/2 + $minSize);
            }
            else {
                $fontSize = round((($tag['articles_tag_amount'] - $min)/($max - $min))*($maxSize - $minSize) + $minSize);
            }
            $arrTagMaster[$key]['font_size'] = $fontSize;
        }
        return $arrTagMaster;
    }
    
    
    
    //////////////TAG PROCESS/////////////
    public function tagProcess($arrAssignedTags, $id, $table, $key)
    {
        $this->key          = $key;
        $this->tableName    = $table;
        
        if(count($arrAssignedTags->toInsertNew) > 0){
            foreach($arrAssignedTags->toInsertNew as $newTag){
                $tagMasterId = $this->_insertTagMaster($newTag, $id);
                Common::assertTrue($tagMasterId, 'Not inserted new tag into tag_master');
            }
        }
         
        if(count($arrAssignedTags->toDelete) > 0){
            foreach($arrAssignedTags->toDelete as $oldAssignedTag){
                $isDeleted = $this->_deleteAssignedTag($oldAssignedTag, $id);
                Common::assertTrue($isDeleted, 'Not deleted tag from '.$table);
            }
        }
        
        if(count($arrAssignedTags->toInsertAssign) > 0){
            foreach($arrAssignedTags->toInsertAssign as $newAssignedTag){
                $articleTagId = $this->_insertAssignedTag($newAssignedTag, $id);
                Common::assertTrue($articleTagId, 'Not inserted new assign tag into '.$table);
            }
        }
    }
    
    
        
    private function _insertTagMaster($newTag, $id)
    {
        $arrTagMaster   = $this->_prepareArrTagMaster($newTag);
        $tagMasterId    = $this->index_model->addInTable($arrTagMaster, 'tag_master');
        $arrAssigneTag  = $this->_prepareArrAssignedTag($tagMasterId, $id);
        $assignedTagId  = $this->index_model->addInTable($arrAssigneTag, $this->tableName);
        Common::assertTrue($assignedTagId, 'Not inserted new assign tag into '.$this->tableName);
        
        return $tagMasterId;
    }
    
   
     
    private function _deleteAssignedTag($oldAssignedTag, $id)
    {
        $arrTagMaster   = $this->_prepareArrTagMaster($oldAssignedTag);
        $tagMasterId    = $this->index_model->findTagMasterIdByDescription($arrTagMaster['description']);
        
        return $this->index_model->deleteArticlesTagByTagIdAndArticlesId($tagMasterId, $id);
    }
    
    
    
    private function _insertAssignedTag($newAssignedTag, $id)
    {
        $arrTagMaster    = $this->_prepareArrTagMaster($newAssignedTag);
        $tagMasterId    = $this->index_model->findTagMasterIdByDescription($arrTagMaster['description']);
        $arrAssignedTag  = $this->_prepareArrAssignedTag($tagMasterId, $id);

        return $this->index_model->addInTable($arrAssignedTag, $this->tableName);
    }
    
     
    
    private function _prepareArrTagMaster($tag)
    {
        $arrTagMaster = array();
        $arrTagMaster['description'] = $tag;
        
        return $arrTagMaster;
    }
    
    
     
    private function _prepareArrAssignedTag($tagMasterId, $id)
    {
        $arrAssignedTag = array();
        $arrAssignedTag['tag_master_id'] = $tagMasterId;
        $arrAssignedTag[$this->key] = $id;
        
        return $arrAssignedTag;
    }
   
    
    ////////////////LANDING PAGE/////////////////////
    public function getLandingPageByUnique($unique)
    {
        $qweryResult = $this->getFromTableByParams(array('unique' => $unique, 'status' => STATUS_ON), 'landing_page');
        $result      = $qweryResult ? $qweryResult[0] : null;

        return $result;        
    }
    
    
    public function getLandingRegistredRecipients($landingPageId, $specMailerHistoryDate = null)
    {
        $additionRule = $specMailerHistoryDate ? " AND landing_statistics.date_visited <= '$specMailerHistoryDate'": null;
        $query = $this->db->query("SELECT
                                recipients.name, recipients.email
                            FROM
                                recipients
                            INNER JOIN
                                landing_statistics
                            ON
                                landing_statistics.recipients_id = recipients.id
                            AND
                                landing_statistics.landing_page_id = $landingPageId" . $additionRule);
        return $query->result_array();
    }
 
    
    
    public function sendSpecMailerEmail($recipientDataArr, $data)
    {
        $headers    = $this->_getMailHeader();
        $email      = $recipientDataArr['email'];
        $subject    = $data['theme'];
        $body       = "<p><b>Здравствуйте, ".$recipientDataArr['name']."!</b></p>
                       ".$data['text']."   
                        <p>Читайте подробнее в статье <b>'".$data['articles_title']."'</b> <br/>на сайте Spring Сonsulting: <a href='".$data['article_link']."'>".$data['article_link']."</a></p>
                        <p>С наилучшими пожеланиями,</p>
                        <p>Команда <a href='".base_url()."'>Spring Consulting</a></p>";
        $message    = $this->_getEmailTamplate($body);
        $isMailSent = mail($email, $subject, $message, $headers);

        return $isMailSent;
    }
    
    
    
    public function getSpecMailerStatistics($landingPageId)
    {
        $query = $this->db->query("SELECT
                                spec_mailer_history.*,
                                landing_page.title AS landing_page_title,
                                articles.title AS articles_title
                            FROM
                                spec_mailer_history
                            LEFT JOIN
                                landing_page
                            ON
                                landing_page.id = spec_mailer_history.landing_page_id
                            LEFT JOIN
                                articles
                            ON
                                articles.id = spec_mailer_history.articles_id
                            WHERE
                                spec_mailer_history.landing_page_id = $landingPageId
                            ORDER BY
                                spec_mailer_history.created_at DESC");
        return $query->result_array();        
    }
    
    
    
    public function getLandingArticleById($id)
    {
        $qweryResult = $this->getFromTableByParams(array('id' => $id, 'status' => STATUS_ON), 'landing_articles');
        $result      = $qweryResult ? $qweryResult[0] : null;

        return $result;          
    }
    
    
    
    public function getLandingArticleData($data)
    {
        $query = $this->db->query("SELECT
                                landing_articles.*
                            FROM
                                landing_articles
                            INNER JOIN
                                landing_statistics
                            ON
                                landing_statistics.landing_page_id = landing_articles.landing_page_id
                            INNER JOIN
                                recipients
                            ON
                                recipients.id = landing_statistics.recipients_id
                            AND
                                recipients.email = '".$data['email']."'
                            WHERE
                                landing_articles.id = ".$data['landing_article_id']."
                                AND 
                                landing_articles.landing_page_id = ".$data['landing_page_id']);
        $qweryResult = $query->result_array();        
        $result      = $qweryResult ? $qweryResult[0] : null;

        return $result;        
    }
    
    
    
    public function updateSaleHistoryByParams($paymentData, $paymentUpdateRules)
    {
        $result = $this->db->query(" UPDATE 
                                        sale_history 
                                    SET 
                                        payment_system = '".$paymentData['payment_system']."',
                                        payment_state = '".$paymentData['payment_state']."',
                                        payment_trans_id = '".$paymentData['payment_trans_id']."',
                                        payment_date = '".$paymentData['payment_date']."'
                                    WHERE 
                                        id = '".$paymentUpdateRules['sale_history_id']."' 
                                        AND 
                                        recipients_id = '".$paymentUpdateRules['recipients_id']."'
                                        AND
                                        sale_products_id = '".$paymentUpdateRules['sale_products_id']."'");
        
        return $result;        
    }
    
}