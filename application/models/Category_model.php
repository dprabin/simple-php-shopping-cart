<?php
class Category_model extends CI_Model{
	/*
	 * The codeblock below handles categories, add edit and delete categories
	 */
	public function add_category(){
		$data = array(
			'name' => $this->input->post('category_name'));
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