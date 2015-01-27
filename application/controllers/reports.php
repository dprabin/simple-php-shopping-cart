<?php
class Reports extends CI_Controller{
	public function index(){
		if($this->session->userdata('previllege') == 'admin'){
			$this->load->model('Order_model');
			$data['report_title'] = 'Pending Orders';
			$data['orders'] = $this->Order_model->get_orders_by('status','pending'); //status can be pending,delivered,settled,canceled
			$data['main_content'] = 'reports/report_orders';
			$this->load->view('layouts/main',$data);
		} else {
			$this->session->set_flashdata('action_unsuccessful','You Need Admin Rights to view reports');
			redirect('products');
		}
	}
	public function all_orders(){
		if($this->session->userdata('previllege') == 'admin'){
			$this->load->model('Order_model');
			$data['report_title'] = 'All Orders';
			$data['orders'] = $this->Order_model->get_orders();
			$data['main_content'] = 'reports/report_orders';
			$this->load->view('layouts/main',$data);
		} else {
			$this->session->set_flashdata('action_unsuccessful','You Need Admin Rights to view reports');
			redirect('products');
		}
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

	public function all_products(){
		if($this->session->userdata('previllege') == 'admin'){
			$data['report_title'] = 'All Products';
			$data['orders'] = $this->Product_model->get_products();
			$data['main_content'] = 'reports/report_products';
			$this->load->view('layouts/main',$data);
		} else {
			$this->session->set_flashdata('action_unsuccessful','You Need Admin Rights to view reports');
			redirect('products');
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
}
?>