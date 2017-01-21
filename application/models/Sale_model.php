<?php
 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sale_model extends Crud
{

    public function __construct()
    {
        parent::__construct();
        $this->idkey = 'id';
        $this->table = 'sale_products';
    }

    public function getSalePageArrWithProducts($slug)
    {
        $sql  = $this->_getSelectSql();
        $sql .= " LEFT JOIN sale_products ON sale_products.id = assign_sale.sale_products_id";
        $sql .= " AND sale_products.status = ".STATUS_ON;
        $sql .= " WHERE sale_page.slug = '".$slug."'
                AND sale_page.status = ".STATUS_ON."
                ORDER BY sale_products.sequence_num";
        $query = $this->db->query($sql);

        return $query->result_array();
    }


    public function getSaleHistory()
    {
        $sql = "SELECT
                    sale_history.*,
                    sale_products.title as sale_products_title,
                    sale_products.price as sale_products_price,
                    recipients.name as recipients_name,
                    recipients.email as recipients_email
                FROM
                    sale_history
                LEFT JOIN
                    sale_products ON sale_products.id = sale_history.sale_products_id
                LEFT JOIN
                    recipients ON recipients.id = sale_history.recipients_id
                ORDER BY sale_history.created_at DESC";

        $query = $this->db->query($sql);

        return $query->result_array();
    }

    public function getSalePageArrWithProductsAdmin()
    {
        $sql = $this->_getSelectSql();
        $sql .= " LEFT JOIN sale_products ON sale_products.id = assign_sale.sale_products_id";
        $query = $this->db->query($sql);
        return $query->result_array();
    }


    public function getSaleProductsArrWithProductsAdmin()
    {
        $sql = "SELECT
                    sale_products.*,
                    sale_page.id as sale_page_id,
                    sale_page.slug as sale_page_slug,
                    sale_page.title as sale_page_title,
                    sale_page.status as sale_page_status
                FROM
                    sale_products
                LEFT JOIN
                    assign_sale ON assign_sale.sale_products_id = sale_products.id
                LEFT JOIN
                    sale_page ON sale_page.id = assign_sale.sale_page_id";
        $query = $this->db->query($sql);
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
                    sale_products.description as sale_products_description,
                    sale_products.thumb as sale_products_thumb
                FROM
                    sale_page
                LEFT JOIN
                    assign_sale ON assign_sale.sale_page_id = sale_page.id";
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

    public function getAssignedASaleProductListBySaleCategoryId($saleCategoryId)
    {
        $sql = "SELECT
                    sale_categories_sale_products_assignment.id as sale_categories_sale_products_assignment_id,
                    sale_products.id as sale_products_id,
                    sale_products.title as sale_products_title,
                    sale_products.status as sale_products_status
                FROM
                    sale_products
                INNER JOIN
                    sale_categories_sale_products_assignment ON sale_categories_sale_products_assignment.sale_products_id = sale_products.id";
        $sql .= " AND sale_categories_sale_products_assignment.sale_categories_id = ".$saleCategoryId;

        $query = $this->db->query($sql);

        return $query->result_array();
    }
}