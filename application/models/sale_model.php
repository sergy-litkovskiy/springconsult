<?php
/**
 * @author Litkovsky
 * @copyright 2010
 * model for index page
 */
 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sale_model extends Crud
{

    public function __construct()
    {
        parent::__construct();
    }


    public function getSalePageArrWithProducts($slug)
    {
        $sql = $this->_getSelectSql();
        $sql .= " WHERE sale_page.slug = '".$slug."'
                AND sale_page.status = ".STATUS_ON."
                AND sale_products.status = ".STATUS_ON."
                ORDER BY sale_products.sequence_num";
        $query = $this->db->query($sql);

        return $query->result_array();
    }


    public function getSalePageArrWithProductsAdmin()
    {
        $query = $this->db->query($this->_getSelectSql());
        return $query->result_array();
    }


    private function _getSelectSql()
    {
        return "SELECT
                    sale_page.*,
                    sale_products.id as sale_products_id,
                    sale_products.title as sale_products_title,
                    sale_products.status as sale_products_status,
                    sale_products.price as sale_products_price,
                    sale_products.description as sale_products_description
                FROM
                    sale_page
                LEFT JOIN
                    assign_sale ON assign_sale.sale_page_id = sale_page.id
                LEFT JOIN
                    sale_products ON sale_products.id = assign_sale.sale_products_id";
    }


    public function getSaleProductWithAssignedSalePageById($saleProductsId)
    {
        $sql = "SELECT
                  sale_products.*,
                  sale_page.id as sale_page_id
                FROM
                    sale_products
                LEFT JOIN
                    assign_sale ON assign_sale.sale_products_id = sale_products.id
                LEFT JOIN
                    sale_page ON sale_page.id = assign_sale.sale_page_id
                WHERE
                    sale_products.id = ".$saleProductsId;

        $query = $this->db->query($sql);
        return $query->result_array();
    }

}