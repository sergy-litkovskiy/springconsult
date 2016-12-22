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

    public function getReviewListWithProductListAdmin()
    {
        $sql = "SELECT
                    reviews.*,
                    sale_products.id as sale_products_id,
                    sale_products.title as sale_products_title,
                    sale_products.status as sale_products_status
                FROM
                    reviews
                LEFT JOIN
                    sale_products_reviews_assignment ON sale_products_reviews_assignment.reviews_id = reviews.id"
        ;

        $sql .= " LEFT JOIN sale_products ON sale_products.id = sale_products_reviews_assignment.sale_products_id";

        $query = $this->db->query($sql);

        return $query->result_array();
    }

    public function getAssignedReviewListBySaleProductId($saleProductsId)
    {
        $sql = "SELECT
                    sale_products_reviews_assignment.id as sale_products_reviews_assignment_id,
                    reviews.*
                FROM
                    reviews
                INNER JOIN
                    sale_products_reviews_assignment ON sale_products_reviews_assignment.reviews_id = reviews.id";
        $sql .= " AND sale_products_reviews_assignment.sale_products_id = ".$saleProductsId;

        $query = $this->db->query($sql);

        return $query->result_array();
    }
}