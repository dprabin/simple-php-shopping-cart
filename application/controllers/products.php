<?php 
class Products extends CI_Controller{
    public function index(){
        $data['name'] = 'Prabin';
        //load product view
        $this->load->view('products',$data);
    }
}

?>