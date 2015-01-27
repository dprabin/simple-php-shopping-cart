<?php

class Order_model extends CI_Model{

	//the status can be (1) pending, (2) delivered, (3) settled, (4) canceled
	//Changed this to generic method to get orders by any field with given value
	//instead of writing several methods
	public function get_orders_by($field,$value){
		$this->db->select('o.*,p.title,u.name');
		$this->db->from('orders as o');
		$this->db->join('products as p','o.product_id=p.id','inner');
		$this->db->join('users as u','o.user_id=u.id','inner');
		$this->db->where($field,$value);
		$query = $this->db->get();
		return $query->results();
	}

	//Get list of all orders in database
	public function get_orders(){
		$this->db->select('o.*,p.title,u.name');
		$this->db->from('orders as o');
		$this->db->join('products as p','o.product_id=p.id','inner');
		$this->db->join('users as u','o.user_id=u.id','inner');
		$query = $this->db->get();
		$return $query->results();
	}

	//Get order by id
	public function get_order_by_id($id){
		$this->db->select('o.*,p.title,u.name');
		$this->db->from('orders as o');
		$this->db->join('products as p','o.product_id=p.id','inner');
		$this->db->join('users as u','o.user_id=u.id','inner');
		$this->db->where('id',$id);
		$query = $this->db->get();
		$return $query->row();
	}
	
}

?>