<?php
/**
 * @author Litkovsky
 * @copyright 2010
 * model for index page
 */
 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Assign_model extends Crud
{
    private $assignsArr;

    public function __construct()
    {
        parent::__construct();
        $this->assignsArr = array(
            'assignMenuIdArr'       => null
            ,'oldAssignMenuIdArr'   => null
            ,'id'                   => null
            ,'assignFieldName'      => null
            ,'table'                => null);
    }


    public function setAssignArr($assignsArr)
    {
        $this->assignsArr = $assignsArr;
    }


    public function addOrDeleteAssigns()
    {
        $newAssignMenuIdArr         = $this->_prepareNewAssignedIdArrIndexIsEqualValue();
        $clearedNewAssignMenuIdArr  = $this->_deleteClearedAssigns($newAssignMenuIdArr);
        $clearedNewAssignMenuIdArr ? $this->_addNewAssigns($clearedNewAssignMenuIdArr) : null;
    }


    private function _prepareNewAssignedIdArrIndexIsEqualValue()
    {
        $newAssignMenuIdArr = array();

        foreach($this->assignsArr['assignMenuIdArr'] as $assignId){
            $newAssignMenuIdArr[$assignId] = $assignId;
        }

        return $newAssignMenuIdArr;
    }


    private function _deleteClearedAssigns($newAssignMenuIdArr)
    {
        foreach($this->assignsArr['oldAssignMenuIdArr'] as $oldAssignMenuId){
            if(!in_array($oldAssignMenuId, $newAssignMenuIdArr)){
                $this->index_model->delFromTableByParams($this->assignsArr, $oldAssignMenuId);
            } else{
                unset($newAssignMenuIdArr[$oldAssignMenuId]);
            }
        }

        return $newAssignMenuIdArr;
    }


    private function _addNewAssigns($clearedNewAssignMenuIdArr)
    {
        foreach($clearedNewAssignMenuIdArr as $newAssignMenuId){
            $data = array('menu_id' => $newAssignMenuId, $this->assignsArr['assignFieldName'] => $this->assignsArr['id']);
            $this->index_model->addInTable($data, $this->assignsArr['table']);
        }
    }
}