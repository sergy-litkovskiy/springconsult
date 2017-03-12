<?php
 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Review_model extends Crud
{
    public function __construct()
    {
        parent::__construct();

        $this->idkey = 'id';
        $this->table = 'review';
    }

    public function getReviewListWithAssignedItemsAdmin()
    {
        $sql = "SELECT
                    review.*,
                    sale_page.id as sale_page_id,
                    sale_page.title as sale_page_title,
                    sale_page.status as sale_page_status,
                    
                    menu.id as menu_id,
                    menu.title as menu_title,
                    menu.status as menu_status
                FROM
                    review
                LEFT JOIN
                    sale_page_review_assignment ON sale_page_review_assignment.review_id = review.id
                LEFT JOIN 
                    sale_page ON sale_page.id = sale_page_review_assignment.sale_page_id                    
                LEFT JOIN
                    menu_review_assignment ON menu_review_assignment.review_id = review.id
                LEFT JOIN 
                    menu ON menu.id = menu_review_assignment.menu_id"
        ;

        $query = $this->db->query($sql);

        return $query->result_array();
    }

    public function getReviewListBySalePageId($salePageId)
    {
        $sql = "SELECT
                    sale_page_review_assignment.id as sale_page_review_assignment_id,
                    review.*
                FROM
                    review
                INNER JOIN
                    sale_page_review_assignment ON sale_page_review_assignment.review_id = review.id";
        $sql .= " AND sale_page_review_assignment.sale_page_id = ".$salePageId;

        $query = $this->db->query($sql);

        return $query->result_array();
    }
}