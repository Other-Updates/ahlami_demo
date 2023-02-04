<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Session_model extends CI_Model {

    private $table_name = 'ci_sessions';

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function get_all_sesion_data($ip_address) {
        $this->db->select('tab_1.session_id,user_data');
        $this->db->where('ip_address', $ip_address);
        $query = $this->db->get($this->table_name . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return NULL;
    }

}
