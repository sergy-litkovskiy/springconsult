<?php
 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Review_model extends Crud
{
    public function __construct()
    {
        parent::__construct();

        $this->idkey = 'id';
        $this->table = 'reviews';
    }

    public function getReviewListWithAssignedItemsAdmin()
    {
        $sql = "SELECT
                    reviews.*,
                    sale_page.id as sale_page_id,
                    sale_page.title as sale_page_title,
                    sale_page.status as sale_page_status,
                    
                    menu.id as menu_id,
                    menu.title as menu_title,
                    menu.status as menu_status
                FROM
                    reviews
                LEFT JOIN
                    sale_page_reviews_assignment ON sale_page_reviews_assignment.reviews_id = reviews.id
                LEFT JOIN 
                    sale_page ON sale_page.id = sale_page_reviews_assignment.sale_page_id                    
                LEFT JOIN
                    menu_reviews_assignment ON menu_reviews_assignment.reviews_id = reviews.id
                LEFT JOIN 
                    menu ON menu.id = menu_reviews_assignment.menu_id"
        ;

        $query = $this->db->query($sql);

        return $query->result_array();
    }

    public function getReviewListBySalePageId($salePageId)
    {
        $sql = "SELECT
                    sale_page_reviews_assignment.id as sale_page_reviews_assignment_id,
                    reviews.*
                FROM
                    reviews
                INNER JOIN
                    sale_page_reviews_assignment ON sale_page_reviews_assignment.reviews_id = reviews.id";
        $sql .= " AND sale_page_reviews_assignment.sale_page_id = ".$salePageId;

        $query = $this->db->query($sql);

        return $query->result_array();
    }
}