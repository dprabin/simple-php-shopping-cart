<?php
/**
* 
*/
class Product_model extends CI_Model{

	//Get all products
	public function get_products(){
		$this->db->select('*');
		$this->db->from('products');
		$query = $this->db->get();
		return $query->result();
	}
}

?>