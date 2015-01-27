<?php

class Order_model extends CI_Model{

	//Get the list of orders by status
	//the status can be (1) pending, (2) delivered, (3) settled, (4) canceled
	public function get_orders_by_status($status){
		$this->db->select('*');
		$this->db->from('orders');
		$this->db->where('status',$status);
		$query = $this->db->get();
		return $query->results();
	}

	//Get list of all orders in database
	public function get_orders(){
		$this->db->select('*');
		$this->db->from('orders');
		$query = $this->db->get();
		$return $query->results();
	}

	//Get order by id
	public function get_order_by_id($id){
		return false;
	}
	
}

?>