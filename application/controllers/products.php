<?php 
class Products extends CI_Controller{
    public function index(){
        //Defint the main content as products
        $data['main_content'] = 'products';
        //load product view
        
        $this->load->view('layouts/main',$data);
    }
}

?>