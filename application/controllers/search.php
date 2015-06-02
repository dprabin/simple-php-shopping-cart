<?php

class Search extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model('search_m');
        $this->load->library( 'pagination' );
    }

    public function index()
    {
        //for pagination
        $config[ "base_url" ]             = base_url( 'search' );
        $config[ 'uri_segment' ]             = 2;
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

        $pg = $this->uri->segment( 2 ) ? $this->uri->segment( 2 ) : 1;
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

        $result = $this->search_m->search( $search, $config[ 'per_page' ], $config[ 'per_page' ] * ( $pg - 1 ) );

        $this->data[ 'category_items' ]    = $result[ 'result' ];
        $this->data[ 'total_rows' ] = $config[ 'total_rows' ] = $result[ 'total_rows' ];

        $data[ "links" ] = $this->pagination->create_links();

        $this->pagination->initialize( $config );

        $this->data[ 'pagination_links' ] = $this->pagination->create_links();
        $this->data['main_content'] = 'category';

        if(!empty($this->data[ 'total_rows' ])){
            $this->load->view('layouts/main',$this->data);
        } else {
            $this->session->set_flashdata('action_unsuccessful','couldn\'t find what you are looking for. please use another keyword in search.');
            redirect('products');
        }
    }




    /**
     * handles search terms and pagination
     * @author: SAM <amritms@gmail.com>
     * @param json $searchterm
     * @return json
     */
    public function searchterm_handler($searchterm)
    {
        if($searchterm != 'false')
        {
            $this->session->set_userdata('searchterm', $searchterm);
            return $searchterm;
        }
        elseif($this->session->userdata('searchterm'))
        {
            $searchterm = $this->session->userdata('searchterm');
            return $searchterm;
        }
        else
        {
            $searchterm ="";
            return $searchterm;
        }
    }
}