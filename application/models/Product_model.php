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
	public function get_products_by($search_terms, $limit = 10, $offset = '' )
	{

		$term = strtolower(trim( $search_terms[ 'category_id' ] ));

		$this->db->select('SQL_CALC_FOUND_ROWS p.*,c.name',false); //false will escape characters
		$this->db->from('products as p');
		$this->db->join('categories as c','c.id=p.category_id','inner');
		$this->db->where('p.category_id', $term);
		$this->db->limit( $limit, $offset );

		$data[ 'result' ] = $this->db->get()->result();
		//                echo $this->db->last_query();;
		$data[ 'total_rows' ] = $this->db->query( "SELECT FOUND_ROWS() total_rows" )->row()->total_rows;
		return $data;
	}

	//Update products
	public function edit_product(){
		$fileinfo = $this->upload->data('userfile');
		$data = array(
			'category_id' => $this->input->post('category_id'),
			'title' => $this->input->post('title'),
			'description' => $this->input->post('description'),
			'nutritional_value' => $this->input->post('nutritional_value'),
			'image' => $fileinfo['file_name'],//$this->input->post('image'),
			'price' => $this->input->post('price'),
			'unit' => $this->input->post('unit'));
		$this->db->where('id',$this->input->post('product_id'));
		$update = $this->db->update('products',$data);
		return $update;
	}

	//Add new product
	public function add_product(){
		$fileinfo = $this->upload->data('userfile');
		$data = array(
			'category_id' => $this->input->post('category_id'),
			'title' => $this->input->post('title'),
			'description' => $this->input->post('description'),
			'nutritional_value' => $this->input->post('nutritional_value'),
			'image' => $fileinfo['file_name'],//$this->input->post('userfile'),
			'price' => $this->input->post('price'),
			'unit' => $this->input->post('unit'));
		$insert = $this->db->insert('products',$data);
		return $insert;
	}

	//Remove product
	public function delete_product($id){
		//Start transaction
		$this->db->trans_start();
		//Delete from products
		$this->db->where('id',$id);
		$this->db->delete('products');
		//update orders with product_id =$id
		$this->db->where('product_id',$id);
		//return $this->db->update('order',array('product_deleted'=>'deleted'));
		//For now, delete all from orders with product id
		$this->db->delete('orders');
		//Complete transaction
		$this->db->trans_complete();
		//Return transaction status
		return $this->db->trans_status();
	}

	//Get Popular Product
	public function get_popular(){
		$this->db->select('p.title,p.id, count(o.product_id) as total');
		$this->db->from('orders as o');
		$this->db->join('products as p','o.product_id = p.id','inner');
		$this->db->group_by('o.product_id');
		$this->db->order_by('total','desc');
		$this->db->limit('5');
		$query = $this->db->get();
		return $query->result();
	}

	//Upload the product image
	public function upload_image(){
		$config=array(
			'upload_path' => realpath(APPPATH. '../assets/images/products/'),//dirname($_SERVER["SCRIPT_FILENAME"]).'/assets/images/products/',
			'upload_url' => base_url().'assets/images/products/',
			'remove_spaces' => TRUE,
			'allowed_types' => 'gif|jpg|png|jpeg',
			'overwrite' => TRUE,
			'max_size' => '2048',
			'max_width'  => '1024',
			'max_height'  => '768');
		$this->load->library('upload',$config);
		$this->upload->initialize($config);
		return $this->upload->do_upload();
	}

	//generate thumbnail by resizing the image
	public function generate_thumbnail($image_data){
		//generate thumbnail with images library
		$config = array(
			'source_image' => $image_data['full_path'],
			'new_image' => $image_data['file_path'].'/thumbs/'.$image_data['file_name'],
			'maintain_ratio' => TRUE,
			'width' => 150,
			'height' => 100);
		$this->load->library('image_lib',$config);
		return $this->image_lib->resize();
	}
}

?>