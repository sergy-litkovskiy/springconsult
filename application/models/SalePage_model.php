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
        $sql .= " LEFT JOIN sale_products ON sale_products.id = assign_sale.sale_products_id";
        $sql .= " AND sale_products.status = ".STATUS_ON;
        $sql .= " WHERE ".$this->table.".id = '".$id."'
                AND ".$this->table.".status = ".STATUS_ON."
                ORDER BY sale_products.sequence_num";
        $query = $this->db->query($sql);

        return $query->result_array();
    }

    private function _getSelectSql()
    {
        return sprintf("SELECT
                    %s.*,
                    sale_products.id as sale_products_id,
                    sale_products.title as sale_products_title,
                    sale_products.status as sale_products_status,
                    sale_products.price as sale_products_price,
                    sale_products.description as sale_products_description,
                    sale_products.thumb as sale_products_thumb
                FROM
                    %s
                LEFT JOIN
                    assign_sale ON assign_sale.sale_page_id = %s.id", $this->table, $this->table, $this->table);
    }
}