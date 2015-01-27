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
			redirect('reports');
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
			redirect('reports');
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
			redirect('reports');
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
			redirect('reports/all_products');
		}
	}

	//Categories

	public function categories(){
		$data['report_title'] = 'Categories';
		$data['products'] = $this->Product_model->get_categories();
		$data['main_content'] = 'reports/report_products';
		$this->load->view('layouts/main',$data);
	}
}
?>