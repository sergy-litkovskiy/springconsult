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


    public function tryUnisenderSubscribe($recipientDataArr)
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


    public function getRecipientData($data)
    {
        $recipientDataArr = array();
        $recipientDataArr = $this->getRecipientIdByEmail($data['email']);

        if(!count($recipientDataArr)){
            $data['confirmed']      = isset($data['confirmed']) ? $data['confirmed'] : STATUS_OFF;
            $data['unsubscribed']   = STATUS_OFF;

            $recipientDataArr['id']        	= $this->addInTable($data, 'recipients');
            Common::assertTrue($recipientDataArr['id'], "<p class='error'>К сожалению, при регистрации произошла ошибка.<br/>Пожалуйста, попробуйте еще раз</p>");
            $recipientDataArr['name']           = $data['name'];
            $recipientDataArr['email']          = $data['email'];
            $recipientDataArr['confirmed']	= $data['confirmed'] == STATUS_ON ? STATUS_ON : STATUS_OFF;
            $recipientDataArr['unsubscribed']	= 0;

            if($data['confirmed'] == STATUS_ON){
                $this->tryUnisenderSubscribe($recipientDataArr);
            }
        }

        return $recipientDataArr;
    }


    public function prepareUrl($urlArr)
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


    public function tryUploadFile($fileUploading, $uploadPath)
    {
        return Fileloader::loadFile($fileUploading['name'], $uploadPath, $fileUploading['tmp_name']);
    }



    public function dropWithFile($dirTableName)
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
            $isDeleted = $this->delFromTable($id, $dirTableName);
            Common::assertTrue($isDeleted, 'Not deleted');

        } catch(Exception $e){
            $error = $e->getMessage();
        }
        print json_encode($error);
    }
}