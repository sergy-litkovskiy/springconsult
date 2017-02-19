<?php
 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Topic_model extends Crud
{

    public function __construct()
    {
        parent::__construct();

        $this->idkey = 'id';
        $this->table = 'topics';
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

//    public function getAssignedArticleListByTopicId($id)
//    {
//        $sql = $this->_getSelectSql();
//        $sql .= " LEFT JOIN articles ON articles.id = topics_articles_assignment.articles_id";
//        $sql .= " AND topics.id = ".$id;
//
//        $query = $this->db->query($sql);
//
//        return $query->result_array();
//    }

    public function getTopicListByParamsWithArticleCount($params)
    {
        $selectSql = '
            topics.*, 
            (
                SELECT count(0) 
                FROM topics_articles_assignment as taa 
                INNER JOIN articles ON articles.id = taa.articles_id AND articles.status = '.STATUS_ON.' 
                WHERE taa.topics_id = topics.id
            ) as articles_count
        ';

        $this->db->select($selectSql);
        $this->db->where($params);
        $this->db->join(
            'topics_articles_assignment as taa',
            $this->table . '.id = taa.topics_id',
            'LEFT'
        );
        $this->db->order_by('topics.name');
        $this->db->group_by('topics.id');

        $query = $this->db->get($this->table);

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