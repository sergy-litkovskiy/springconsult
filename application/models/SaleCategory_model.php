<?php
 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SaleCategory_model extends Crud
{

    public function __construct()
    {
        parent::__construct();

        $this->idkey = 'id';
        $this->table = 'sale_categories';
    }

    public function getCategoryListWithProductList()
    {
        $sql  = $this->_getSqlSelect();
        $sql .= " , sale_page.id as sale_page_id, sale_page.slug as sale_page_slug";
        $sql .= $this->_getSqlFrom();

        $sql .= " INNER JOIN sale_products ON sale_products.id = sale_categories_sale_products_assignment.sale_products_id";
        $sql .= " AND sale_products.status = ".STATUS_ON;
        $sql .= " LEFT JOIN sale_page ON sale_products.sale_page_id = sale_page.id";
        $sql .= " AND sale_page.status = ".STATUS_ON;
        $sql .= " WHERE sale_categories.status = ".STATUS_ON;

        $query = $this->db->query($sql);

        return $query->result_array();
    }

    public function getCategoryListWithProductListAdmin()
    {
        $sql = $this->_getSqlSelect();
        $sql .= $this->_getSqlFrom();
        $sql .= " LEFT JOIN sale_products ON sale_products.id = sale_categories_sale_products_assignment.sale_products_id";
        $query = $this->db->query($sql);

        return $query->result_array();
    }

    private function _getSqlSelect()
    {
        return "SELECT
                    sale_categories.*,
                    sale_products.id as sale_products_id,
                    sale_products.title as sale_products_title,
                    sale_products.status as sale_products_status,
                    sale_products.price as sale_products_price,
                    sale_products.thumb as sale_products_thumb,
                    sale_products.description as sale_products_description";
    }

    private function _getSqlFrom()
    {
        return " FROM
                    sale_categories
                LEFT JOIN
                    sale_categories_sale_products_assignment ON sale_categories_sale_products_assignment.sale_categories_id = sale_categories.id"
            ;
    }
}