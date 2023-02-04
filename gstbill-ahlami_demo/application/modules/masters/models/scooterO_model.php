<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Scootero_model extends CI_Model {

    private $table_name = 'scoo_scootero';
    private $scootero_history = 'scoo_position_history';

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function get_all_scooterO() {
        $this->db->select($this->table_name . '.*');
        $this->db->where('is_deleted',0);
        $query = $this->db->get($this->table_name);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }
    
    function insert_scooterO($data) {
        if ($this->db->insert($this->table_name, $data)) {
            $insert_id = $this->db->insert_id();
            return $insert_id;
        }
        return FALSE;
    }

    function insert_scooterO_history($data) {

        //Update Old Position 
        $this->db->where('scootero_id',$data['scootero_id']);
        $this->db->update($this->scootero_history,array('is_current_position'=>0));

        if ($this->db->insert($this->scootero_history, $data)) {
            $insert_id = $this->db->insert_id();
            return $insert_id;
        }
        return FALSE;
    }

    function check_scootero_position($lat,$lon,$id){
        $this->db->select($this->table_name . '.id');
        $this->db->where($this->table_name . '.id', $id);
        $this->db->where($this->table_name . '.scoo_lat', $lat);
        $this->db->where($this->table_name . '.scoo_long', $lon);
        $query = $this->db->get($this->table_name);
        if ($query->num_rows() > 0) {
            return TRUE;
        }
        return NULL;
    }
    function update_scooterO($data, $id) {
        $this->db->where('id', $id);
        if ($this->db->update($this->table_name, $data)) {
            return TRUE;
        }
        return FALSE;
    }

    function get_scooterO_by_id($id) {
        $this->db->select($this->table_name . '.*');
        $this->db->where($this->table_name . '.id', $id);
        $query = $this->db->get($this->table_name);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

}
