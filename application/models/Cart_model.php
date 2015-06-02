<?php
class Cart_model extends CI_Model{
	//add order to database
	public function add_order($order_data){
		//Insert order data to db and return
		$insert = $this->db->insert('orders',$order_data);
		return $this->db->insert_id();
	}

	public function add_order_details($order_detail){
		return $this->db->insert_batch('order_details', $order_detail);

	}
}

?>