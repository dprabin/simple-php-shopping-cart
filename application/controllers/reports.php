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

	public function orders($status='null'){
		if(!empty($status){
			$status=strtolower($status);
			if($status!='pending' || $status!='delivered' || $status!='settled' || $status!='canceled' ){
				$this->session->set_flashdata('action_unsuccessful','The status you supplied is invalid, displaying index page');
				$status='pending';
			}
			$this->load->model('Order_model');
			$data['report_title'] = ucwords($status).' Orders';
			$data['orders'] = $this->Order_model->get_orders_by($status);
			$data['main_content'] = 'reports/report_orders';
			$this->load->view('layouts/main',$data);
		} else {
			$this->session->set_flashdata('action_unsuccessful','You didnt supply the status of order, displaying index page');
			redirect('reports');
		}
	}
}
?>