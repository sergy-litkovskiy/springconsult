<?php
 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SalePage_model extends Crud
{

    public function __construct()
    {
        parent::__construct();

        $this->idkey = 'id';
        $this->table = 'sale_page';
    }

    public function getSalePageWithAssignedProducts($id)
    {
        $sql  = $this->_getSelectSql();
        $sql .= " LEFT JOIN sale_product ON sale_product.id = assign_sale.sale_product_id";
        $sql .= " AND sale_product.status = ".STATUS_ON;
        $sql .= " WHERE ".$this->table.".id = '".$id."'
                AND ".$this->table.".status = ".STATUS_ON."
                ORDER BY sale_product.sequence_num";
        $query = $this->db->query($sql);

        return $query->result_array();
    }

    private function _getSelectSql()
    {
        return sprintf("SELECT
                    %s.*,
                    sale_product.id as sale_product_id,
                    sale_product.title as sale_product_title,
                    sale_product.label as sale_product_label,
                    sale_product.status as sale_product_status,
                    sale_product.price as sale_product_price,
                    sale_product.description as sale_product_description,
                    sale_product.image as sale_product_image
                FROM
                    %s
                LEFT JOIN
                    assign_sale ON assign_sale.sale_page_id = %s.id", $this->table, $this->table, $this->table);
    }

    public function getAssignedSalePageListByReviewId($reviewId)
    {
        $sql = "SELECT
                    sale_page_review_assignment.id as sale_page_review_assignment_id,
                    sale_page.id as sale_page_id,
                    sale_page.title as sale_page_title,
                    sale_page.status as sale_page_status
                FROM
                    sale_page
                INNER JOIN
                    sale_page_review_assignment ON sale_page_review_assignment.sale_page_id = sale_page.id";
        $sql .= " AND sale_page_review_assignment.review_id = ".$reviewId;

        $query = $this->db->query($sql);

        return $query->result_array();
    }
}