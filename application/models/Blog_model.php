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
        } elseif ($offset) {
            $this->db->limit($offset);
        }

        $query = $this->db->get($this->table);

        return $query->result_array();
    }

    private function prepareSqlQuery($params, $topicId)
    {
        $this->db->where($params);
        $this->db->join(
            'topics_articles_assignment as taa',
            $this->table . '.id = taa.articles_id AND taa.topics_id = ' . $topicId,
            'INNER'
        );
    }
}