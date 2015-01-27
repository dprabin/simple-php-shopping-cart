<?php
class Reports extends CI_Controller{
	public function index(){
		$data['orders'] = $this->Order_model->get_orders();
		$data['main_content'] = 'report_orders';
		$this->load->view('layouts/main',$data);
		}
	}
}


?>