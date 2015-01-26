<?php
class Cart_model extends CI_model{
	//add order to database
	public function add_order($order_data){
		//Insert order data to db and return
		$insert = $this->db->insert('orders',$order_data);
		return $insert;
	}
}

?>