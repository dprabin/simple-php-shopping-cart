<?php 
class Products extends CI_Controller{
    public function index(){
    	//Get All Products
    	$data['products'] = $this->Product_model->get_products();


    	//Load View
        //Defint the main content as products
        $data['main_content'] = 'products';
        //load product view
        $this->load->view('layouts/main',$data);
    }
}

?>