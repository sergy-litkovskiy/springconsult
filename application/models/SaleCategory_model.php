<?php
 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SaleCategory_model extends Crud
{

    public function __construct()
    {
        parent::__construct();

        $this->idkey = 'id';
        $this->table = 'sale_category';
    }

    public function getCategoryListWithProductList()
    {
        $sql  = $this->_getSqlSelect();
        $sql .= " , sale_page.id as sale_page_id, sale_page.slug as sale_page_slug";
        $sql .= $this->_getSqlFrom();

        $sql .= " INNER JOIN sale_product ON sale_product.id = sale_category_sale_product_assignment.sale_product_id";
        $sql .= " AND sale_product.status = ".STATUS_ON;
        $sql .= " LEFT JOIN sale_page ON sale_product.sale_page_id = sale_page.id";
        $sql .= " AND sale_page.status = ".STATUS_ON;
        $sql .= " WHERE sale_category.status = ".STATUS_ON;
        $sql .= ' ORDER BY sale_category.sequence_num, sale_product.sequence_num';

        $query = $this->db->query($sql);

        return $query->result_array();
    }

    public function getCategoryListWithProductListAdmin()
    {
        $sql = $this->_getSqlSelect();
        $sql .= $this->_getSqlFrom();
        $sql .= " LEFT JOIN sale_product ON sale_product.id = sale_category_sale_product_assignment.sale_product_id";
        $sql .= ' ORDER BY sale_category.sequence_num, sale_product.sequence_num';
        $query = $this->db->query($sql);

        return $query->result_array();
    }

    private function _getSqlSelect()
    {
        return "SELECT
                    sale_category.*,
                    sale_product.id as sale_product_id,
                    sale_product.title as sale_product_title,
                    sale_product.label as sale_product_label,
                    sale_product.status as sale_product_status,
                    sale_product.price as sale_product_price,
                    sale_product.gift as sale_product_gift,
                    sale_product.image as sale_product_image,
                    sale_product.sequence_num as sale_product_sequence_num,
                    sale_product.description as sale_product_description";
    }

    private function _getSqlFrom()
    {
        return " FROM
                    sale_category
                LEFT JOIN
                    sale_category_sale_product_assignment ON sale_category_sale_product_assignment.sale_category_id = sale_category.id"
            ;
    }
}