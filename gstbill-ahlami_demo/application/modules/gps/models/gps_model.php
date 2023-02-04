<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class gps_model extends CI_Model {

    private $table_name = 'scoo_scootero';

    function __construct() {
        parent::__construct();
        $this->load->helper('date');
        $this->load->database();
    }

    function get_scootero_by_lock(){
        $this->db->select($this->table_name. '.*');
        $this->db->where('lock_status',0);
        $this->db->where('gps',ON);
        $query = $this->db->get($this->table_name);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    function get_scootero_by_unlock(){
        $this->db->select($this->table_name. '.*');
        $this->db->where('lock_status',1);
        $this->db->where('gps',ON);
        $query = $this->db->get($this->table_name);
        if ($query->num_rows() > 0){
            return $query->result_array();
        }
        return NULL;
    }
    
    function get_scootero_time(){
        $this->db->select($this->table_name.'.*');
        $this->db->where('gps_tracking_time  < now() - interval 60 second');
        $query = $this->db->get($this->table_name);
        if ($query->num_rows() > 0){
            return $query->result_array();
        }
        return NULL;
    }
}