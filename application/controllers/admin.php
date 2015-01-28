<?php
class Admin extends CI_Controller{

	function __construct() {
		parent::__construct();
		if(!$this->session->userdata('previllege') == 'admin'){
			$this->session->set_flashdata('action_unsuccessful','You Need Admin Rights for that action.');
			redirect('products');
		}
	}

	public function index(){
		$this->load->model('Order_model');
		$data['report_title'] = 'Pending Orders';
		$data['orders'] = $this->Order_model->get_orders_by('status','pending'); //status can be pending,delivered,settled,canceled
		$data['main_content'] = 'reports/report_orders';
		$this->load->view('layouts/main',$data);
	}


	//Order Reports

	public function all_orders(){
		$this->load->model('Order_model');
		$data['report_title'] = 'All Orders';
		$data['orders'] = $this->Order_model->get_orders();
		$data['main_content'] = 'reports/report_orders';
		$this->load->view('layouts/main',$data);
	}

	public function orders_by_status($status=null){
		if(!empty($status)){
			$status=strtolower($status);
			if($status=='pending' || $status=='delivered' || $status=='settled' || $status=='canceled' ){
			} else {
				//$this->session->set_flashdata('action_unsuccessful','The status you supplied is invalid, displaying pending orders');
				$status='pending';
			}
			$this->load->model('Order_model');
			$data['report_title'] = ucwords($status).' Orders';
			$data['orders'] = $this->Order_model->get_orders_by('status',$status);
			$data['total'] = $this->Order_model->get_total_by('status');
			$data['main_content'] = 'reports/report_orders';
			$this->load->view('layouts/main',$data);
		} else {
			$this->session->set_flashdata('action_unsuccessful','You didnt supply the status of order, displaying index page');
			redirect('admin');
		}
	}

	public function orders_by_user($user_id=null){
		if(!empty($user_id)){
			$this->load->model('Order_model');
			$data['report_title'] = 'Ordered by user no: '.$user_id; //get username instead of user id
			$data['orders'] = $this->Order_model->get_orders_by('user_id',$user_id); //if no data returned, redirect with message
			$data['main_content'] = 'reports/report_orders';
			$this->load->view('layouts/main',$data);
		} else {
			$this->session->set_flashdata('action_unsuccessful','You didnt supply the status of order, displaying index page');
			redirect('admin');
		}
	}

	public function orders_by_product($product_id=null){
		if(!empty($product_id)){
			$this->load->model('Order_model');
			$data['report_title'] = 'Ordered by user no: '.$product_id; //get username instead of user id
			$data['orders'] = $this->Order_model->get_orders_by('product_id',$product_id); //if no data returned, redirect with message
			$data['main_content'] = 'reports/report_orders';
			$this->load->view('layouts/main',$data);
		} else {
			$this->session->set_flashdata('action_unsuccessful','You didnt supply the status of order, displaying index page');
			redirect('admin');
		}
	}


	//Products report

	public function all_products(){
		$data['report_title'] = 'All Products';
		$data['products'] = $this->Product_model->get_products();
		$data['main_content'] = 'reports/report_products';
		$this->load->view('layouts/main',$data);
	}

	public function products_by_category($category=null){
		if(!empty($category)){
			$category = urldecode($category);
			$data['report_title'] = 'Product by category: '.$category;
			$data['products'] = $this->Product_model->get_products_by('name',$category); //if no data returned, redirect with message
			$data['main_content'] = 'reports/report_products';
			$this->load->view('layouts/main',$data);
		} else {
			$this->session->set_flashdata('action_unsuccessful','You didnt supply the category name, displaying index page');
			redirect('admin/all_products');
		}
	}


	//Categories 

	public function categories(){
		$this->load->model('Category_model');
		$data['report_title'] = 'All categories with product count';
		$data['categories'] = $this->Category_model->get_categories();
		$data['main_content'] = 'reports/report_all_categories';
		$this->load->view('layouts/main',$data);
	}

	public function add_category(){
		//validation Rules
		$this->form_validation->set_rules('category_name','Name of the Category', 'trim|required|min_length[4]|max_length[30]');
		if($this->form_validation->run() == FALSE){
			$data['main_content'] = 'reports/add_category';
			$this->load->view('layouts/main',$data);
		} else {
			$this->load->model('Category_model');
			if($this->Category_model->add_category()){
				$this->session->set_flashdata('action_successful','New Category '.$this->input->post('category_name').' has been added successfully');//flashdata in ci can be used in new view also
				redirect('admin/categories');
			}
		}
	}

	public function edit_category($category_id=null){
		if(!empty($category_id)){
			//First load the category_model
			$this->load->model('Category_model');
			//validation Rules
			$this->form_validation->set_rules('category_name','Name of the Category', 'trim|required|min_length[4]|max_length[30]');
			if($this->form_validation->run() == FALSE){
				$data['category'] = $this->Category_model->get_category($category_id);
				$data['main_content'] = 'reports/edit_category';
				$this->load->view('layouts/main',$data);
			} else {
				if($this->Category_model->add_category()){
					$this->session->set_flashdata('action_successful','New Category has been added successfully');//flashdata in ci can be used in new view also
					redirect('admin/categories');
				}
			}
		} else {
			$this->session->set_flashdata('action_unsuccessful','You didnt supply the category name');
			redirect('admin/categories');
		}
	}

	public function delete_category($id=null){
		if(!empty($category)){

		} else {
			$this->session->set_flashdata('action_unsuccessful','You didnt supply the category name, displaying index page');
			redirect('admin/all_products');
		}
	}
}
?>