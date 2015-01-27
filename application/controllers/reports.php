<?php
class Reports extends CI_Controller{
	public function index(){
		$data['all_orders'] = $this->Order_model->get_orders();
		$data['pending_orders'] = $this->Order_model->get_orders_by('status','pending'); //status can be pending,delivered,settled,canceled
		$data['main_content'] = 'report_orders';
		$this->load->view('layouts/main',$data);
		}
	}
}


?>