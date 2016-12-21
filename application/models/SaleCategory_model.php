<?php
 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SaleCategory_model extends Crud
{

    public function __construct()
    {
        parent::__construct();

        $this->idkey = 'id';
    }

    public function getTopicListWithArticles()
    {
        $sql  = $this->_getSelectSql();
        $sql .= " LEFT JOIN articles ON articles.id = topics_articles_assignment.articles_id";
        $sql .= " AND topics.status = ".STATUS_ON;
        $sql .= " AND articles.status = ".STATUS_ON;

        $query = $this->db->query($sql);

        return $query->result_array();
    }

    public function getTopicListWithArticlesAdmin()
    {
        $sql = $this->_getSelectSql();
        $sql .= " LEFT JOIN articles ON articles.id = topics_articles_assignment.articles_id";
        $query = $this->db->query($sql);

        return $query->result_array();
    }

    public function getAssignedArticleListByTopicId($id)
    {
        $sql = $this->_getSelectSql();
        $sql .= " LEFT JOIN articles ON articles.id = topics_articles_assignment.articles_id";
        $sql .= " AND topics.id = ".$id;

        $query = $this->db->query($sql);

        return $query->result_array();
    }


    private function _getSelectSql()
    {
        return "SELECT
                    topics.*,
                    articles.id as article_id,
                    articles.title as article_title,
                    articles.status as article_status
                FROM
                    topics
                LEFT JOIN
                    topics_articles_assignment ON topics_articles_assignment.topics_id = topics.id"
            ;
    }
}