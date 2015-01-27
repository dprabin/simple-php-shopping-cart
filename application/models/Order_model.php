<?php

class Order_model extends CI_Model{

	//Generic method to get orders by any field and value
	public function get_orders_by($fieldname,$fieldvalue){
		$this->db->select('o.*,p.title,u.username,concat(u.first_name," ",u.last_name) as fullname, u.phone,concat(o.address," ",o.address2," ",o.city," ",o.state) as fulladdress ', FALSE);
		$this->db->from('orders as o');
		$this->db->join('products as p','o.product_id=p.id','inner');
		$this->db->join('users as u','o.user_id=u.id','inner');
		$this->db->where($fieldname,$fieldvalue);
		$query = $this->db->get();
		return $query->result();
	}

	//Get the total amount under any condition
	public function get_total_by($fieldname){
		$this->db->select('p.id,p.title,sum(o.price)');
		$this->db->from('orders as o');
		$this->db->join('products as p','o.product_id=p.id','inner');
		$this->db->join('users as u','o.user_id=u.id','inner');
		$this->db->group_by($fieldname);
		$this->db->where('o.status !=','canceled'); //not including canceled order
		$query = $this->db->get();
		return $query->result();
	}

	//Get list of all orders in database
	public function get_orders(){
		$this->db->select('o.*,p.title,u.username');
		$this->db->from('orders as o');
		$this->db->join('products as p','o.product_id=p.id','inner');
		$this->db->join('users as u','o.user_id=u.id','inner');
		$query = $this->db->get();
		return $query->result();
	}

	//Get order by id
	public function get_order_by_id($id){
		$this->db->select('o.*,p.title,u.name');
		$this->db->from('orders as o');
		$this->db->join('products as p','o.product_id=p.id','inner');
		$this->db->join('users as u','o.user_id=u.id','inner');
		$this->db->where('id',$id);
		$query = $this->db->get();
		return $query->row();
	}
	
}

?>