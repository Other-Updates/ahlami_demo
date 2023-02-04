<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Event_type_model extends CI_Model {

    private $table_name = 'eve_event_types';
    private $event_custom_fields = 'event_custom_fields';
    private $event_type_dynamic_fields = 'eve_event_type_dynamic_fields';

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insert_event_type($user_type) {
        if ($this->db->insert($this->table_name, $user_type)) {
            $insert_id = $this->db->insert_id();
            return $insert_id;
        }
        return FALSE;
    }

    function update_event_type($data, $id) {
        $this->db->where('id', $id);
        if ($this->db->update($this->table_name, $data)) {
            return TRUE;
        }
        return FALSE;
    }

    function update_dynamic_fields($event_type_fields = array()) {
        if (!empty($event_type_fields)) {
            foreach ($event_type_fields as $field_data) {
                $this->db->select('tab_1.id, tab_1.field_name');
                $this->db->where('tab_1.field_name', $field_data['field_name']);
                $query = $this->db->get($this->event_type_dynamic_fields . ' AS tab_1');
                $field_info = $query->result_array();
                if (!empty($field_info[0]['id'])) {
                    $this->db->where('field_name', $field_data['field_name']);
                    $this->db->where('event_type_id', $field_data['event_type_id']);
                    $this->db->where('id', $field_info[0]['id']);
                    $this->db->update($this->event_type_dynamic_fields, $field_data);
                } else {
                    $this->db->insert($this->event_type_dynamic_fields, $field_data);
                }
            }
        }
    }

    function delete_event_type($id) {
        $this->db->where('id', $id);
        if ($this->db->delete($this->table_name)) {
            return TRUE;
        }
        return FALSE;
    }

    function delete_dynamic_fields($id) {
        $this->db->where('event_type_id', $id);
        if ($this->db->delete($this->event_type_dynamic_fields)) {
            return TRUE;
        }
        return FALSE;
    }

    function get_event_type_by_id($id) {
        $this->db->select('tab_1.*');
        $this->db->where('tab_1.id', $id);
        $query = $this->db->get($this->table_name . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    function get_all_event_types() {
        $this->db->select('tab_1.*');
        $query = $this->db->get($this->table_name . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    function is_event_type_name_available($event_type_name, $id = NULL) {
        $this->db->select('tab_1.id');
        $this->db->where('LCASE(tab_1.event_type_name)', strtolower($event_type_name));
        if (!empty($id))
            $this->db->where('tab_1.id !=', $id);
        $query = $this->db->get($this->table_name . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

}
