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

	//Get a single product
	public function get_product_details($id){
		$this->db->select('*');
		$this->db->from('products');
		$this->db->where('id',$id);
		$query = $this->db->get();
		return $query->row();
	}

	//Get Categories
	public function get_categories(){
		$this->db->select('*');
		$this->db->from('categories');
		$query = $this->db->get();
		return $query->result();
	}

	//Get items of specific category
	public function get_category_items($category_id){
		$this->db->select('*');
		$this->db->from('products');
		$this->db->where('category_id',$category_id);
		$query = $this->db->get();
		return $query->result();
	}

	//Get Popular Product
	public function get_popular(){
		$this->db->select('p.title,p.id, count(o.product_id) as total');
		$this->db->from('orders as o');
		$this->db->join('products as p','o.product_id = p.id','inner');
		$this->db->group_by('o.product_id');
		$this->db->order_by('total','desc');
		//$this->db->limit('5');
		$query = $this->db->get();
		return $query->result();
	}

	//add products in cart to order
	public function add_products_to_cart(){
		$data = array(
			'address' => $this->input->post('address'),
			'address2' => $this->input->post('address2'),
			'phone' => $this->input->post('phone'),
			'username' => $this->input->post('username'),
			'password' => md5($this->input->post('password'))
			);
		$insert = $this->db->insert('users',$data);
		return $insert;
	}

}

?>