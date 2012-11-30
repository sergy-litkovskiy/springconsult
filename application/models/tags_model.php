<?php
/**
 * @author Litkovsky
 * @copyright 2010
 * model for index page
 */
 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tags_model extends Crud
{
    protected $params, $key, $tableName ;

    public function __construct()
    {
        parent::__construct();
        $this->key;
        $this->tableName;
    }


    public function findTagMasterIdByDescription($description)
    {
        $qwery = $this->db->query("SELECT id FROM tag_master WHERE description = '".$description."'");
      
        $result = $qwery->result_array();
        
        return $result ? $result[0]['id'] : null;
    }
    

    public function deleteArticlesTagByTagIdAndArticlesId($tagMasterId, $id)
    {   
        return $this->db->query("DELETE FROM articles_tag WHERE tag_master_id = ".$tagMasterId." AND articles_id = ".$id."");
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
        $tagMasterId    = $this->findTagMasterIdByDescription($arrTagMaster['description']);
        
        return $this->deleteArticlesTagByTagIdAndArticlesId($tagMasterId, $id);
    }

    
    private function _insertAssignedTag($newAssignedTag, $id)
    {
        $arrTagMaster    = $this->_prepareArrTagMaster($newAssignedTag);
        $tagMasterId    = $this->findTagMasterIdByDescription($arrTagMaster['description']);
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

}