<?php


class search_m extends CI_Model{

    public function __construct(){
        parent::__construct();

    }

    public function search( $search_terms, $limit = 10, $offset = '' )
    {

        $term = strtolower(trim( $search_terms[ 's' ] ));

        $this->db->select( "SQL_CALC_FOUND_ROWS *", false );

        $this->db->from( "products p" );
        $this->db->like('lower(p.title)', $term);
        $this->db->or_like('lower(p.description)', $term);
        $this->db->limit( $limit, $offset );
        $this->db->order_by( 'p.title ASC' );

        $data[ 'result' ] = $this->db->get()->result();
//                echo $this->db->last_query();;
        $data[ 'total_rows' ] = $this->db->query( "SELECT FOUND_ROWS() total_rows" )->row()->total_rows;
//        var_dump($data['result']);
        return $data;
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