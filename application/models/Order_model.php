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
	
}

?>