<?php
class Product extends CI_Model {

    function get_cart_products($cart)
    {
        $arr = array();
        foreach (json_decode($cart) as $key => $value) {
            array_push($arr, $key);
        }

        $this->db->where_in('id', $arr);
        return $this->db->get('products')->result();
    }
    
    function get_products($categoryid)
    {
        $query = $this->db->get_where('products', array('catalog_menuitem_id' => $categoryid));
        return $query->result();
    }

    function get_product($productid)
    {
        $query = $this->db->get_where('products', array('id' => $productid));
        $ret = $query->result();
        return $ret[0];
    }

    public function set_product($categoryid)
    {
        $this->load->helper('url');
                
        $data = array(
            'name' => $this->input->post('name'),
            'article' => $this->input->post('article'),
            'cost' => $this->input->post('cost'),
            'catalog_menuitem_id' => $categoryid
        );
        return $this->db->insert('products', $data);
    }

    public function update_product($id)
    {
        $this->load->helper('url');
                
        $data = array(
            'name' => $this->input->post('name'),
            'article' => $this->input->post('article'),
            'cost' => $this->input->post('cost'),
        );

        $this->db->where('id', $id);
        return $this->db->update('products', $data); 
    }

    public function select_product($id)
    {
        $query = $this->db->get_where('products', array('id' => $id));
        $res = $query->result();
        $s = abs($res[0]->selected - 1);

        $data = array(
            'selected' => $s
        );

        $this->db->where('id', $id);
        $this->db->update('products', $data);

        return $query = $this->db->get_where('products', array('selected' => 1))->result_array();
    }
}
?>