<?php

class Order_model extends CI_Model{

	//Get the list of orders by status
	//the status can be (1) pending, (2) delivered, (3) settled, (4) canceled
	public function get_orders_by_status($status){
		$this->db->select('o.*,p.title,u.name');
		$this->db->from('orders as o');
		$this->db->join('products as p','o.product_id=p.id','inner');
		$this->db->join('users as u','o.user_id=u.id','inner');
		$this->db->where('status',$status);
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