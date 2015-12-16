<?php

/**
 * @author Litkovsky
 * @copyright 2010
 * model for all objects of site
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Crud extends CI_Model {
	
    var $table = '';
    var $idkey = '';
    
    function __construct()
    {
        parent::__construct();
    }


    public function add($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
	 

    public function addInTable($data, $table)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }
    

    public function update($id, $data)
    {
        $this->db->where($this->idkey, $id);
        if(!$this->db->update($this->table, $data))
        {
            return false;
        }
        return true;
    }
	

    public function updateInTable($id, $data, $table)
    {
        $this->db->where($this->idkey, $id);
        if(!$this->db->update($table, $data))
        {
            return false;
        }
        return true;
    }


    public function del($id)
    {
        $this->db->where($this->idkey, $id);
        if(!$this->db->delete($this->table))
        {
            return false;
        }
        return true;
    }
	

    public function delFromTable($id, $table)
    {
        $this->db->where($this->idkey, $id);
        if(!$this->db->delete($table))
        {
            return false;
        }
        return true;
    }
    

    public function get($id)
    {
        $this->db->where($this->idkey, $id);
        $query = $this->db->get($this->table);

        return $query->result_array();
    }
	

    public function getFromTableByParams($params, $table)
    {
        $this->db->where($params);
        $query = $this->db->get($table);
        
        return $query->result_array();
    }
	

    public function getList()
    {
        $query = $this->db->get($this->table);
        return $query->result_array();
    }
    

    public function getListFromTable($table)
    {
        $query = $this->db->get($table);
        return $query->result_array();
    }
	

    public function getArrWhere($table, $params, $limit, $order_by = false)
    {
        $orderBy = $order_by ? " ORDER BY ".$order_by : false;
        $sqlLimit = $limit ? " LIMIT ".$limit : false;
        $sqlWhere = count($params) ? $this->_makeSqlWhereFromParams($params) : null;

        $query = $this->db->query("SELECT * FROM ".$table.$sqlWhere.$orderBy.$sqlLimit."");
        return $query->result_array();
    }


    private function _makeSqlWhereFromParams(array $params)
    {
        $sqlWhere = " WHERE";
        $paramsCount = count($params);
        $count = 1;
        foreach($params as $col => $val){
            $sqlAnd = ( $count < $paramsCount ) ? "AND" : null;
            $sqlWhere .= " " . $col ." = '". $val ."' ".$sqlAnd;
            $count++;
        }
        return $sqlWhere;
    }
}