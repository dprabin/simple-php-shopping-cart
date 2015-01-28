<?php
class Category_model extends CI_Model{
	/*
	 * The codeblock below handles categories, add edit and delete categories
	 */

	//Get Categories with product count
	public function get_categories(){
		$this->db->select('c.*,count(p.id) as product_count',false); //false will escape characters
		$this->db->from('categories as c');
		$this->db->join('products as p','c.id=p.category_id','left');
		$this->db->group_by('c.id');
		$query = $this->db->get();
		return $query->result();
	}

	//Get a single category
	public function get_category($category_id){
		$this->db->select('*',false); //false will escape characters
		$this->db->from('categories as c');
		$this->db->where('id',$category_id);
		$query = $this->db->get();
		return $query->result();
	}

	public function add_category(){
		$data = array('name' => $this->input->post('category_name'));
		$insert = $this->db->insert('categories',$data);
		return $insert;
	}

	public function edit_category(){
		$data = array(
			'name' => $this->input->post('category_name'));
		$this->db->where('id',$this->input->post('category_id'));
		$update = $this->db->update('products',$data);
		return $update;
	}
}
?>