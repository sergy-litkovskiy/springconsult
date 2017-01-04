<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Menu_model extends Crud
{
    public function getMenuListByIdList(array $ids)
    {
        $idList = implode(',', $ids);
        $sql = sprintf(
            'SELECT menu.* FROM menu WHERE menu.id IN (%s) AND menu.status = %s ORDER by menu.num_sequence',
            $idList,
            STATUS_ON
        );

        $query = $this->db->query($sql);

        return $query->result_array();
    }

    public function getTopLevelMenuList()
    {
        $sql = sprintf(
            'SELECT menu.* FROM menu WHERE menu.parent = 0 AND menu.status = %s ORDER by menu.num_sequence',
            STATUS_ON
        );

        $query = $this->db->query($sql);

        return $query->result_array();
    }

    public function getMenuListByParentId($id)
    {
        $sql = sprintf(
            'SELECT menu.* FROM menu WHERE menu.parent = %s AND menu.status = %s ORDER by menu.num_sequence',
            $id,
            STATUS_ON
        );

        $query = $this->db->query($sql);

        return $query->result_array();
    }

    public function getMenuListWithReviewsByParentId($id)
    {
        $sql = sprintf(
            '
            SELECT 
                menu.*,
                reviews.id as reviews_id, 
                reviews.author as reviews_author, 
                reviews.text as reviews_text, 
                reviews.image as reviews_image
            FROM 
                menu 
            LEFT JOIN 
                menu_reviews_assignment as mra
              ON 
                mra.menu_id = menu.id 
            LEFT JOIN 
                reviews
              ON 
                mra.reviews_id = reviews.id AND reviews.status = %s              
            WHERE 
                menu.parent = %s 
            AND 
                menu.status = %s 
            ORDER by 
                menu.num_sequence
            ',
            STATUS_ON,
            $id,
            STATUS_ON
        );

        $query = $this->db->query($sql);

        return $query->result_array();
    }

    public function getReviewListByMenuId($id)
    {
        $sql = sprintf(
            '
            SELECT 
                reviews.*
            FROM 
                reviews 
            INNER JOIN 
                menu_reviews_assignment as mra
            ON 
                mra.reviews_id = reviews.id 
            AND 
                reviews.status = %s    
            AND 
                mra.menu_id = %s
            ',
            STATUS_ON,
            $id
        );

        $query = $this->db->query($sql);

        return $query->result_array();
    }

    public function getArticleListByMenuId($id, $limit)
    {
        $sql = sprintf(
            '
            SELECT 
                articles.id,
                articles.title,
                articles.thumb,
                articles.date
            FROM 
                articles 
            INNER JOIN 
                assign_articles as aa
            ON 
                aa.articles_id = articles.id 
            AND 
                articles.status = %s    
            AND 
                aa.menu_id = %s
            ORDER BY 
                articles.date DESC  
            LIMIT %s 
            ',
            STATUS_ON,
            $id,
            $limit
        );

        $query = $this->db->query($sql);

        return $query->result_array();
    }
}