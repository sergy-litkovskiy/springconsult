<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Crud extends CI_Model
{
    protected $table = '';
    protected $idkey = 'id';
    
    public function __construct()
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

        if(!$this->db->update($table, $data)) {
            return false;
        }

        return true;
    }

    public function del($id)
    {
        $this->db->where($this->idkey, $id);
        if(!$this->db->delete($this->table)) {
            return false;
        }
        return true;
    }

    public function delFromTable($id, $table)
    {
        $this->db->where($this->idkey, $id);
        if(!$this->db->delete($table)) {
            return false;
        }
        return true;
    }

    public function get($id, $limit = NULL, $offset = NULL)
    {
        $this->db->where($this->idkey, $id);
        $query = $this->db->get($this->table, $limit, $offset);

        return $query->result_array();
    }

    public function getFromTableByParams($params, $table)
    {
        $this->table = $table;

        return $this->getListByParams($params);
    }

    public function getListFromTable($table)
    {
        $this->table = $table;

        return $this->getList();
    }

    public function getListByParams(
        $params,
        $orderBy = ORDER_BY_DEFAULT,
        $orderDirection = ORDER_DIRECTION_ASC,
        $limit = 0,
        $offset = 0
    )
    {
        $this->db->where($params);

        if ($orderBy) {
            $this->db->order_by($orderBy, $orderDirection);
        }

        if ($limit || $offset) {
            $this->db->limit($limit, $offset);
        }

        return $this->getList();
    }

    public function getList()
    {
        $query = $this->db->get($this->table);

        return $query->result_array();
    }

    public function getTotalCount()
    {
        return $this->db->count_all_results($this->table);
    }

    public function getCountByParams($params, $limit = null, $offset = null)
    {
        $this->db->where($params);

        if ($limit) {
            $this->db->limit($limit, $offset);
        }

        $query = $this->db->get($this->table);

        return $query->num_rows();
    }

    public function getArrWhere($table, $params, $limit, $orderBy = false)
    {
        $orderBy = $orderBy ? " ORDER BY ".$orderBy : false;
        $sqlLimit = $limit ? " LIMIT ".$limit : false;
        $sqlWhere = count($params) ? $this->_makeSqlWhereFromParams($params) : null;

        $query = $this->db->query("SELECT * FROM ".$table.$sqlWhere.$orderBy.$sqlLimit);
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