<?php
 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sale_model extends Crud
{

    public function __construct()
    {
        parent::__construct();
        $this->idkey = 'id';
        $this->table = 'sale_product';
    }

    public function getSalePageArrWithProducts($slug)
    {
        $sql  = $this->_getSelectSql();
        $sql .= " LEFT JOIN sale_product ON sale_product.id = sale_page_sale_product_assignment.sale_product_id";
        $sql .= " AND sale_product.status = ".STATUS_ON;
        $sql .= " WHERE sale_page.slug = '".$slug."'
                AND sale_page.status = ".STATUS_ON."
                ORDER BY sale_product.sequence_num";
        $query = $this->db->query($sql);

        return $query->result_array();
    }


    public function getSaleHistory()
    {
        $sql = "SELECT
                    sale_history.*,
                    sale_product.title as sale_product_title,
                    sale_product.label as sale_product_label,
                    sale_product.price as sale_product_price,
                    sale_product.gift as sale_product_gift,
                    recipients.name as recipients_name,
                    recipients.email as recipients_email
                FROM
                    sale_history
                LEFT JOIN
                    sale_product ON sale_product.id = sale_history.sale_product_id
                LEFT JOIN
                    recipients ON recipients.id = sale_history.recipients_id
                ORDER BY sale_history.created_at DESC";

        $query = $this->db->query($sql);

        return $query->result_array();
    }

    public function getSalePageArrWithProductsAdmin()
    {
        $sql = $this->_getSelectSql();
        $sql .= " LEFT JOIN sale_product ON sale_product.id = sale_page_sale_product_assignment.sale_product_id";
        $query = $this->db->query($sql);
        return $query->result_array();
    }


    public function getSaleProductsArrWithProductsAdmin()
    {
        $sql = "SELECT
                    sale_product.*,
                    sale_page.id as sale_page_id,
                    sale_page.slug as sale_page_slug,
                    sale_page.title as sale_page_title,
                    sale_page.status as sale_page_status
                FROM
                    sale_product
                LEFT JOIN
                    sale_page_sale_product_assignment ON sale_page_sale_product_assignment.sale_product_id = sale_product.id
                LEFT JOIN
                    sale_page ON sale_page.id = sale_page_sale_product_assignment.sale_page_id
                ORDER by sale_product.sequence_num";

        $query = $this->db->query($sql);
        return $query->result_array();
    }


    private function _getSelectSql()
    {
        return "SELECT
                    sale_page.*,
                    sale_product.id as sale_product_id,
                    sale_product.title as sale_product_title,
                    sale_product.label as sale_product_label,
                    sale_product.slug as sale_product_slug,
                    sale_product.status as sale_product_status,
                    sale_product.price as sale_product_price,
                    sale_product.gift as sale_product_gift,
                    sale_product.description as sale_product_description,
                    sale_product.image as sale_product_image
                FROM
                    sale_page
                LEFT JOIN
                    sale_page_sale_product_assignment ON sale_page_sale_product_assignment.sale_page_id = sale_page.id";
    }


    public function getSaleProductWithAssignedSalePageById($saleProductsId)
    {
        $sql = "SELECT
                  sale_product.*,
                  sale_page.id as sale_page_id
                FROM
                    sale_product
                LEFT JOIN
                    sale_page_sale_product_assignment ON sale_page_sale_product_assignment.sale_product_id = sale_product.id
                LEFT JOIN
                    sale_page ON sale_page.id = sale_page_sale_product_assignment.sale_page_id
                WHERE
                    sale_product.id = ".$saleProductsId." 
                ORDER by sale_product.sequence_num";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getAssignedASaleProductListBySaleCategoryId($saleCategoryId)
    {
        $sql = "SELECT
                    sale_category_sale_product_assignment.id as sale_category_sale_product_assignment_id,
                    sale_product.id as sale_product_id,
                    sale_product.title as sale_product_title,
                    sale_product.label as sale_product_label,
                    sale_product.slug as sale_product_slug,
                    sale_product.status as sale_product_status,
                    sale_product.gift as sale_product_gift
                FROM
                    sale_product
                INNER JOIN
                    sale_category_sale_product_assignment ON sale_category_sale_product_assignment.sale_product_id = sale_product.id";
        $sql .= " AND sale_category_sale_product_assignment.sale_category_id = ".$saleCategoryId." ORDER by sale_product.sequence_num";

        $query = $this->db->query($sql);

        return $query->result_array();
    }

    public function getSaleProductListByMenuId($menuId)
    {
        $this->db->select($this->table . '.*');
        $this->db->join(
            'menu_sale_product_assignment as mspa',
            'mspa.sale_product_id = sale_product.id AND mspa.menu_id = ' . $menuId,
            'INNER'
        );

        $query = $this->db->get($this->table);

        return $query->result_array();
    }
}