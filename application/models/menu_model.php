<?php
/**
 * @author Litkovsky
 * @copyright 2010
 * model for object MENU - recursive getting menu items
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Menu_model extends Crud
{
    public $id, $parent, $title, $slug, $lang, $meta_description, $meta_keywords;
    public                                                        $childs = array();

    function __construct($id = 0)
    {
        parent::__construct();
//        $query_parent         = $this->db->query("SELECT
//                                                        menu.*
//                                                    FROM
//                                                        menu
//                                                    WHERE
//                                                        menu.id = " . $id . "
//                                                    AND
//                                                        menu.status = 1
//                                                    ORDER by
//                                                        menu.num_sequence");
//        $arr_menu_parent_item = $query_parent->result_array();
//
//        $this->id     = empty($arr_menu_parent_item) ? 0 : $arr_menu_parent_item[0]['id'];
//        $this->parent = empty($arr_menu_parent_item[0]['parent']) ? 0 : $arr_menu_parent_item[0]['parent'];
//        $this->title  = empty($arr_menu_parent_item[0]['title']) ? 0 : $arr_menu_parent_item[0]['title'];
//        $this->slug   = empty($arr_menu_parent_item[0]['slug']) ? 0 : $arr_menu_parent_item[0]['slug'];
//
//        $this->meta_description = empty($arr_menu_parent_item[0]['meta_description']) ? 0 : $arr_menu_parent_item[0]['meta_description'];
//        $this->meta_keywords    = empty($arr_menu_parent_item[0]['meta_keywords']) ? 0 : $arr_menu_parent_item[0]['meta_keywords'];
//        $query_childs           = $this->db->query("SELECT
//                                                menu.*
//                                            FROM
//                                                menu
//                                            WHERE
//                                                menu.parent = " . $this->id . "
//                                            AND
//                                                menu.status = 1ц
//                                            ORDER by
//                                                menu.num_sequence");
//        $arr_menu_item          = $query_childs->result_array();
//
//        foreach ($arr_menu_item as $val) {
//            $child          = new Menu_model($val['id']);
//            $this->childs[] = $child;
//        }
    }

    public function getMenuListByIdList(array $ids)
    {
        $idList = implode(',', $ids);
        $sql = sprintf(
            'SELECT menu.* FROM menu WHERE menu.id IN (%s) AND menu.status = %s ORDER by menu.num_sequence',
            $idList,
            STATUS_ON
        );

        $query = $this->db->query($sql);

        return $query->result_array();
    }
}