<?php 
class Products extends CI_Controller{

    public function index(){
    	//Get All Products
    	$data['products'] = $this->Product_model->get_products();

    	//Load View
        //Define the main content area as products view (product.php)
        $data['main_content'] = 'products';
        //load product view
        $this->load->view('layouts/main',$data);
    }

    //Display the detail information of a product
    public function details($id=null){
        if(!empty($id)){
        	//Get Product Details
        	$data['product'] = $this->Product_model->get_product_details($id);
        	//Define the main content as details view
            $data['main_content'] = 'details';
            //load product view
            $this->load->view('layouts/main',$data);
        } else {
            $this->session->set_flashdata('action_unsuccessful','You didnt supply the product id');
            redirect('products');
        }
    }

    //Display the detail information of a product
    //it may be safer to move delete, add, and edit method to admin controller
    public function edit($id=null){
        if(!empty($id)){
            //If logged in as administrator, edit product 
            //otherwise redirect to details/id
            if ($this->session->userdata('previllege')=='admin'){
                $data['product'] = $this->Product_model->get_product_details($id);
                if($data['product'] || $_POST){
                    if($_POST){
                        //Validate data
                        $this->form_validation->set_rules('title','Username', 'trim|required|max_length[200]|min_length[3]');
                        $this->form_validation->set_rules('category_id','Category', 'trim|required');
                        $this->form_validation->set_rules('description','Product Description', 'trim|required|min_length[10]');
                        $this->form_validation->set_rules('nutritional_value','Nutritional Value', 'trim');
                        //$this->form_validation->set_rules('image','Product Image', 'trim|required|max_length[200]|min_length[5]');
                        $this->form_validation->set_rules('price','Product Price', 'trim|required|max_length[7]|min_length[1]');
                        $this->form_validation->set_rules('unit','Unit of product', 'trim|required|max_length[25]|min_length[1]');
                        //Read the product details
                        $data['product'] = $this->Product_model->get_product_details($this->input->post('product_id'));
                        if($this->form_validation->run() == FALSE){
                            $data['main_content'] = 'edit';
                            $this->load->view('layouts/main',$data);
                        } else {
                            if ($this->Product_model->upload_image() && $this->Product_model->edit_product()){
                                //generate thumbnail with images library
                                $this->Product_model->generate_thumbnail($this->upload->data());

                                $this->session->set_flashdata('action_successful','The product '.$this->input->post('title').' is updated');
                                redirect('products');
                            } else {
                                $this->session->set_flashdata('action_unsuccessful','The product '.$this->input->post('title').' is not updated');
                                redirect('products');
                            }
                        }
                    } else {
                        $data['main_content'] = 'edit';
                        $this->load->view('layouts/main',$data);
                    }
                } else {
                    $this->session->set_flashdata('action_unsuccessful','The product you are trying to edit does not exist');
                    redirect('products');
                }
            } else {
                $this->session->set_flashdata('action_unsuccessful','You do not have previllege to Edit products');
                redirect('products');
            }
        } else {
            $this->session->set_flashdata('action_unsuccessful','You cannot edit that item');
            redirect('products');
        }
    }

    //Add a new product
    //it may be safer to move delete, add, and edit method to admin controller
    public function add(){
        if ($this->session->userdata('previllege')=='admin'){
            //Validate data
            $this->form_validation->set_rules('title','Product Title', 'trim|required|max_length[200]|min_length[3]|is_unique[products.title]');
            $this->form_validation->set_rules('category_id','Product Category', 'trim|required');
            $this->form_validation->set_rules('description','Product Description', 'trim|required|min_length[10]');
            $this->form_validation->set_rules('nutritional_value','Nutritional Value', 'trim');
            //$this->form_validation->set_rules('userfile','Product Image', 'trim|required|max_length[200]|min_length[5]|is_unique[products.image]');
            $this->form_validation->set_rules('price','Product Price', 'trim|required|max_length[7]|min_length[1]');
            $this->form_validation->set_rules('unit','Unit of product', 'trim|required|max_length[25]|min_length[1]');

            if($this->form_validation->run() == FALSE){
                $data['main_content'] = 'add';
                $this->load->view('layouts/main',$data);
            } else {
                if ($this->Product_model->upload_image() && $this->Product_model->add_product()){
                    //generate thumbnail with images library
                    $this->Product_model->generate_thumbnail($this->upload->data());

                    $this->session->set_flashdata('action_successful','The product '.$this->input->post('title').' is added');
                    redirect('products/details/'.$this->db->insert_id());
                } else {
                    $this->session->set_flashdata('action_unsuccessful','The product '.$this->input->post('title').' is not added');
                    redirect('products');
                }
            }
        } else {
            $this->session->set_flashdata('action_unsuccessful','You do not have previllege to add new product');
            redirect('products');
        }
    }

    //Remove Product form database
    //it may be safer to move delete, add, and edit method to admin controller
    public function delete($id=null){
        if(!empty($id)){
            if ($this->session->userdata('previllege')=='admin'){
                //Confirm before removing product in javascript
                $this->Product_model->delete_product($id);
                $this->session->set_flashdata('action_successful','The product is successfully deleted');
                redirect('admin/all_products');
            }
        } else {
            $this->session->set_flashdata('action_unsuccessful','Please supply the product id');
        }
        redirect('products');
    }

    //Category viewer
    public function category($id=null){
         if(!empty($id)){

             //for pagination
             $config[ "base_url" ]             = base_url( 'products/category/'.$id );
             $config[ 'uri_segment' ]             = 4;
             $config[ 'per_page' ]             = 12;
             $config[ 'num_links' ]            = 5;
             $config[ 'full_tag_open' ]        = '<ul class="pagination right paddingbtm20">';
             $config[ 'full_tag_close' ]       = '</ul>';
             $config[ 'first_link' ]           = 'First';
             $config[ 'last_link' ]            = 'Last';
             $config[ 'enable_query_strings' ] = true;
             $config[ 'use_page_numbers' ]     = true;
             $config[ 'first_tag_open' ]       = '<li>';
             $config[ 'first_tag_close' ]      = '</li>';
             $config[ 'last_tag_open' ]        = '<li>';
             $config[ 'last_tag_close' ]       = '</li>';
             $config[ 'prev_tag_open' ]        = '<li>';
             $config[ 'prev_tag_close' ]       = '</li>';
             $config[ 'next_tag_open' ]        = '<li>';
             $config[ 'next_tag_close' ]       = '</li>';
             $config[ 'num_tag_open' ]         = '<li>';
             $config[ 'num_tag_close' ]        = '</li>';
             $config[ 'cur_tag_open' ]         = '<li class="disabled"><a href="#">';
             $config[ 'cur_tag_close' ]        = '</a></li>';

             $this->load->model('search_m');
             $this->load->library('pagination');
             $pg = $this->uri->segment( 4 ) ? $this->uri->segment( 4 ) : 1;
             if ( $this->input->post() )
             {
                 $searchterm = $this->search_m->searchterm_handler( json_encode( $this->input->post() ) );
             } else
             {
                 $searchterm = $this->search_m->searchterm_handler( 'false' );
             }

             $search_terms    = json_decode( $searchterm );
             $search[ 's' ]   = @$search_terms->s;

             $this->data[ 'edit_data' ] = $search;
             $this->data[ 'start_sn' ]  = $config[ 'per_page' ] * ( $pg - 1 );

             $search['category_id'] = $id;
             $result = $this->search_m->Product_model->get_products_by( $search, $config[ 'per_page' ], $config[ 'per_page' ] * ( $pg - 1 ) );

             $this->data[ 'category_items' ]    = $result[ 'result' ];
             $this->data[ 'total_rows' ] = $config[ 'total_rows' ] = $result[ 'total_rows' ];

             $data[ "links" ] = $this->pagination->create_links();

             $this->pagination->initialize( $config );

             $this->data[ 'pagination_links' ] = $this->pagination->create_links();
             $this->data['main_content'] = 'category';


            $this->load->view('layouts/main',$this->data);
        } else {
            $this->session->set_flashdata('action_unsuccessful','You didnt supply the category id');
            redirect('products');
        }
    }
}

?>