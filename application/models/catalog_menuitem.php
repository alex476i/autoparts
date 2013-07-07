<?php
class Catalog_MenuItem extends CI_Model {
    
    function get_catalog_menuitems()
    {
        $query = $this->db->get('catalog_menuitems');
        return $query->result();
    }

    function get_catalog_menuitem($categoryid)
    {
        $query = $this->db->get_where('catalog_menuitems', array('id' => $categoryid));
        $ret = $query->result();
        return $ret[0];
    }

    function get_children_items($categoryid)
    {
        $query = $this->db->get_where('catalog_menuitems', array('parent_id' => $categoryid));
        return $query->result();
    }
}
?>