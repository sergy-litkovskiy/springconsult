<?php
 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SaleCategory_model extends Crud
{

    public function __construct()
    {
        parent::__construct();

        $this->idkey = 'id';
    }

    public function getCategoryListWithProductList()
    {
        $sql  = $this->_getSelectSql();
        $sql .= " LEFT JOIN sale_products ON sale_products.id = sale_categories_sale_products_assignment.sale_products_id";
        $sql .= " AND sale_categories.status = ".STATUS_ON;
        $sql .= " AND sale_products.status = ".STATUS_ON;

        $query = $this->db->query($sql);

        return $query->result_array();
    }

    public function getCategoryListWithProductListAdmin()
    {
        $sql = $this->_getSelectSql();
        $sql .= " LEFT JOIN sale_products ON sale_products.id = sale_categories_sale_products_assignment.sale_products_id";
        $query = $this->db->query($sql);

        return $query->result_array();
    }

    private function _getSelectSql()
    {
        return "SELECT
                    sale_categories.*,
                    sale_products.id as sale_products_id,
                    sale_products.title as sale_products_title,
                    sale_products.status as sale_products_status
                FROM
                    sale_categories
                LEFT JOIN
                    sale_categories_sale_products_assignment ON sale_categories_sale_products_assignment.sale_categories_id = sale_categories.id"
            ;
    }
}