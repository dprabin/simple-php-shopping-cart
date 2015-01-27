<?php
class Product_model extends CI_Model{

	//Get all products
	public function get_products(){
		$this->db->select('p.*, c.name');
		$this->db->from('products as p');
		$this->db->join('categories as c','p.category_id=c.id','inner');
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

	//Generic method to get products by any field and value
	public function get_products_by($fieldname,$fieldvalue){
		$this->db->select('p.*,c.name as category_name');
		$this->db->from('products as p');
		$this->db->join('categories as c','c.id=p.category_id','inner');
		$this->db->where($fieldname,$fieldvalue);
		$this->db->order_by('timestamp','desc');
		$query = $this->db->get();
		return $query->result();
	}

	//Update products
	public function update(){
		$data = array(
			'category_id' => $this->input->post('category_id'),
			'title' => $this->input->post('title'),
			'description' => $this->input->post('description'),
			'nutritional_value' => $this->input->post('nutritional_value'),
			'image' => $this->input->post('image'),
			'price' => $this->input->post('price'),
			'unit' => $this->input->post('unit'));
		$this->db->where('id',$this->input->post('product_id'));
		$update = $this->db->update('products',$data);
		return $update;
	}

	//Add new product
	public function add_product(){
		$data = array(
			'category_id' => $this->input->post('category_id'),
			'title' => $this->input->post('title'),
			'description' => $this->input->post('description'),
			'nutritional_value' => $this->input->post('nutritional_value'),
			'image' => $this->input->post('image'),
			'price' => $this->input->post('price'),
			'unit' => $this->input->post('unit'));
		$insert = $this->db->insert('products',$data);
		return $insert;
	}

	//Remove product
	public function remove_product($id){
		//Delete from products
		//$data=array('id'=>$id);
		//return $this>db->delete('products',$data);
		//set deleted
		//$data2=array('product_id'=>$id);
		//return $this->db->update('order',$data2);
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
}

?>