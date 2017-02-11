<?php
 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blog_model extends Crud
{
    public function __construct()
    {
        parent::__construct();

        $this->idkey = 'id';
        $this->table = 'articles';
    }

    public function getCountArticlesForTopicByParams($topicId, $params)
    {
        $this->prepareSqlQuery($params, $topicId);
        $query = $this->db->get($this->table);

        return $query->num_rows();
    }

    public function getArticlesForTopicByParams($topicId, $params, $orderParams = [], $limitParams = [])
    {
        $orderBy = ArrayHelper::arrayGet($orderParams, 'orderBy', ORDER_BY_DEFAULT);
        $orderDirection = ArrayHelper::arrayGet($orderParams, 'orderDirection', ORDER_DIRECTION_ASC);

        $limit = ArrayHelper::arrayGet($limitParams, 'limit', 0);
        $offset = ArrayHelper::arrayGet($limitParams, 'offset', 0);

        $this->prepareSqlQuery($params, $topicId);

        if ($orderBy) {
            $this->db->order_by($orderBy, $orderDirection);
        }

        if ($limit && $offset) {
            $this->db->limit($limit, $offset);
        } elseif ($limit) {
            $this->db->limit($limit);
        }

        $query = $this->db->get($this->table);

        return $query->result_array();
    }

    private function prepareSqlQuery($params, $topicId)
    {
        $this->db->select($this->table . '.*');
        $this->db->where($params);
        $this->db->join(
            'topics_articles_assignment as taa',
            $this->table . '.id = taa.articles_id AND taa.topics_id = ' . $topicId,
            'INNER'
        );
    }

    public function getAssignedArticleListByGiftId($giftId)
    {
        $sqlSelect = '
            gaa.id as gift_articles_assignment_id,
            articles.id as article_id,
            articles.title as article_title,
            articles.status as article_status
        ';

        $this->db->select($sqlSelect);
        $this->db->join(
            'gift_articles_assignment as gaa',
            $this->table . '.id = gaa.articles_id AND gaa.gift_id = ' . $giftId,
            'INNER'
        );

        $query = $this->db->get($this->table);

        return $query->result_array();
    }


    public function getAssignedArticleListByTopicId($giftId)
    {
        $sqlSelect = '
            taa.id as topics_articles_assignment_id,
            articles.id as article_id,
            articles.title as article_title,
            articles.status as article_status
        ';

        $this->db->select($sqlSelect);
        $this->db->join(
            'topics_articles_assignment as taa',
            $this->table . '.id = taa.articles_id AND taa.topics_id = ' . $giftId,
            'INNER'
        );

        $query = $this->db->get($this->table);

        return $query->result_array();
    }
}