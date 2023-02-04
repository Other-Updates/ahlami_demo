<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Event_model extends CI_Model {

    private $table_name = 'eve_events';
    private $event_invited_members_table = 'eve_event_invited_members';
    private $event_invitations_table = 'eve_event_invitations';
    private $event_type_dynamic_fields_table = 'eve_event_type_dynamic_fields';
    private $event_dynamic_values_table = 'eve_event_dynamic_values';
    private $event_type_table = 'eve_event_types';
    private $members_table = 'eve_members';
    private $group_table = 'eve_groups';
    private $street_table = 'eve_streets';
    private $event_action_table = 'eve_event_actions';
    var $primaryTable = 'eve_events tab_1';
    var $column_order = array ('tab_1.id', 'tab_2.event_type_name', 'tab_1.event_name', 'tab_3.group_name', 'tab_4.street_name', 'tab_1.from_date', 'tab_1.to_date');
    var $column_search = array ('tab_2.event_type_name', 'tab_1.event_name', 'tab_3.group_name', 'tab_4.street_name', 'tab_1.from_date', 'tab_1.to_date');
    var $order = array ('tab_1.id' => 'DESC');

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insert_event($data) {
        if ($this->db->insert($this->table_name, $data)) {
            $insert_id = $this->db->insert_id();
            return $insert_id;
        }
        return FALSE;
    }

    function insert_event_invited_members($data) {
        if ($this->db->insert($this->event_invited_members_table, $data)) {
            return TRUE;
        }
        return FALSE;
    }

    function insert_event_invitations($data) {
        if ($this->db->insert_batch($this->event_invitations_table, $data)) {
            return TRUE;
        }
        return FALSE;
    }

    function insert_dynamic_field_values($data) {
        if ($this->db->insert_batch($this->event_dynamic_values_table, $data)) {
            return TRUE;
        }
        return FALSE;
    }

    function update_event($data, $event_id) {
        $this->db->where('id', $event_id);
        if ($this->db->update($this->table_name, $data)) {
            return TRUE;
        }
        return FALSE;
    }

    function update_event_invited_members($data, $event_id) {
        $this->db->where('event_id', $event_id);
        if ($this->db->update($this->event_invited_members_table, $data)) {
            return TRUE;
        }
        return FALSE;
    }

    function update_event_dynamic_fields($eventDynamicArray, $event_id) {
        if (!empty($eventDynamicArray)) {
            foreach ($eventDynamicArray as $field_id => $data) {
                $this->db->where('field_id', $field_id);
                $this->db->where('event_id', $event_id);
                $this->db->update($this->event_dynamic_values_table, $data);
            }
            return TRUE;
        }
        return FALSE;
    }

    function delete_event($id) {
        $this->db->where('id', $id);
        if ($this->db->delete($this->table_name)) {
            return 1;
        }
        return 0;
    }

    function delete_invitation_by_id($id) {
        $this->db->where('id', $id);
        if ($this->db->delete($this->event_invitations_table)) {
            return TRUE;
        }
        return FALSE;
    }

    function delete_family_details($id) {
        $this->db->where('event_id', $id);
        if ($this->db->delete('events_family_details')) {
            return TRUE;
        }
        return FALSE;
    }

    function delete_street_details($id) {
        $this->db->where('event_id', $id);
        if ($this->db->delete('events_street_details')) {
            return TRUE;
        }
        return FALSE;
    }

    function get_event_by_id($id) {
        $SQL = "SELECT tab_1.*,tab_2.event_type_name,DATE_FORMAT(tab_1.from_date, '%d/%m/%Y %H:%i') AS formatted_from_date,DATE_FORMAT(tab_1.to_date, '%d/%m/%Y %H:%i') AS formatted_to_date FROM eve_events AS tab_1 LEFT JOIN eve_event_types AS tab_2 ON tab_1.event_type_id = tab_2.id  WHERE tab_1.id = " . $id;
        $query = $this->db->query($SQL);
        return $query->result_array();
    }

    function get_event_details_by_id($id) {
        $SQL = "SELECT tab_1.*,DATE_FORMAT(tab_1.from_date, '%d/%m/%Y %H:%i') AS formatted_from_date FROM eve_events AS tab_1 LEFT JOIN eve_event_types AS tab_2 ON tab_1.event_type_id = tab_2.id WHERE tab_1.id = " . $id;

        $query = $this->db->query($SQL);
        return $query->result_array();
    }

    function get_event_invitations_by_event_id($id) {
        $this->db->select('tab_1.*');
        $this->db->where('tab_1.event_id', $id);
        $query = $this->db->get($this->event_invitations_table . ' AS tab_1');

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    function get_event_invited_members_by_event_id($id) {
        $this->db->select('tab_1.*');
        $this->db->where('tab_1.event_id', $id);
        $query = $this->db->get($this->event_invited_members_table . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    function get_event_dynamic_values_by_event_id($id) {
        $this->db->select('tab_1.*');
        $this->db->where('tab_1.event_id', $id);
        $query = $this->db->get($this->event_dynamic_values_table . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    function get_event_dynamic_file_field_details($event_id, $dynamic_field_id) {
        $this->db->select('tab_1.*');
        $this->db->where('tab_1.event_id', $event_id);
        $this->db->where('tab_1.field_id', $dynamic_field_id);
        $query = $this->db->get($this->event_dynamic_values_table . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;


        $SQL = "SELECT tab_1.*,DATE_FORMAT(tab_1.from_date, '%d/%m/%Y %H:%i') AS formatted_from_date,DATE_FORMAT(tab_1.to_date, '%d/%m/%Y %H:%i') AS formatted_to_date FROM eve_events AS tab_1 WHERE tab_1.id = " . $id;
        $query = $this->db->query($SQL);
        return $query->result_array();
    }

    function get_event_type_dynamic_fields($id) {
        $this->db->select('tab_1.*');
        $this->db->where('tab_1.event_type_id', $id);
        $query = $this->db->get($this->event_type_dynamic_fields_table . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    function get_family_members_by_family_type($family_types = array ()) {
        $family_members = array ();
        if (!empty($family_types) && is_array($family_types)) {
            $this->db->select('tab_1.id,tab_1.email_address,tab_1.username');
            $this->db->where_in('tab_1.family_id', $family_types);
            $this->db->where('tab_1.status', 1);
            $query = $this->db->get($this->members_table . ' AS tab_1');
            if ($query->num_rows() > 0) {
                $family_members = $query->result_array();
            }
        }
        return $family_members;
    }

    function get_family_members_by_street($streets = array ()) {
        $family_members = array ();
        if (!empty($streets) && is_array($streets)) {
            $this->db->select('tab_1.id,tab_1.email_address,tab_1.username');
            $this->db->where_in('tab_1.street_id', $streets);
            $this->db->where('tab_1.status', 1);
            $query = $this->db->get($this->members_table . ' AS tab_1');
            if ($query->num_rows() > 0) {
                $family_members = $query->result_array();
            }
        }
        return $family_members;
    }

    function get_local_members($from_date, $to_date) {
        $local_members = array ();
        $permanent_members = array ();
        $this->db->select('tab_1.id,tab_1.email_address,tab_1.username');
        $this->db->where('tab_1.on_kayalpattinam', 'permanent');
        $this->db->where('tab_1.status', 1);
        $query = $this->db->get($this->members_table . ' AS tab_1');
        if ($query->num_rows() > 0) {
            $permanent_members = $query->result_array();
        }

        $temporary_members = array ();
        $this->db->select('tab_1.id,tab_1.email_address,tab_1.username');
        $this->db->where('tab_1.on_kayalpattinam', 'temporary');
        $this->db->where('tab_1.duration_from >=', $from_date);
        $this->db->where('tab_1.duration_to <=', $to_date);
        $this->db->where('tab_1.status', 1);
        $query = $this->db->get($this->members_table . ' AS tab_1');
        if ($query->num_rows() > 0) {
            $temporary_members = $query->result_array();
        }
        $local_members = array_merge($permanent_members, $temporary_members);
        $local_members = array_filter($local_members);
        return $local_members;
    }

    function get_all_events() {
        $this->db->select('tab_1.*,tab_2.event_type_name');
        $this->db->select('CONVERT(GROUP_CONCAT(DISTINCT(tab_3.group_name) SEPARATOR ",") USING utf8) AS group_name', FALSE);
        $this->db->select('CONVERT(GROUP_CONCAT(DISTINCT(tab_4.street_name) SEPARATOR ",") USING utf8) AS street_name', FALSE);
        $this->db->select('SUM(tab_5.id) AS accept_count');
        $this->db->select('SUM(tab_6.id) AS reject_count');

        $this->db->join($this->event_type_table . ' AS tab_2', 'tab_2.id = tab_1.event_type_id', 'LEFT');
        $this->db->custom_join($this->group_table . ' AS tab_3', 'FIND_IN_SET(tab_3.id,tab_1.family_types)', 'LEFT');
        $this->db->custom_join($this->street_table . ' AS tab_4', 'FIND_IN_SET(tab_4.id,tab_1.streets)', 'LEFT');
        $this->db->join($this->event_action_table . ' AS tab_5', 'tab_5.event_id = tab_1.id AND tab_5.status = 1', 'LEFT');
        $this->db->join($this->event_action_table . ' AS tab_6', 'tab_6.event_id = tab_1.id AND tab_6.status = 0', 'LEFT');
        $this->db->group_by('tab_1.id');

        $query = $this->db->get($this->table_name . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return array ();
    }

    function get_invited_members_list($id) {
        $this->db->select('tab_1.*');
        $this->db->where('tab_1.event_id', $id);
        $query = $this->db->get($this->event_invited_members_table . ' AS tab_1');
        $event_invited_members = $query->result_array();
        $invited_members_json = $event_invited_members[0]['invited_members'];
        $invited_members_arr = json_decode($invited_members_json, TRUE);

        $invited_members = array ();
        if (!empty($invited_members_arr) && is_array($invited_members_arr)) {
            $this->db->select('tab_1.* ,tab_2.group_name,tab_3.street_name');
            $this->db->join($this->group_table . ' AS tab_2', 'tab_2.id = tab_1.family_id', 'LEFT');
            $this->db->join($this->street_table . ' AS tab_3', 'tab_3.id = tab_1.street_id', 'LEFT');
            $this->db->where_in('tab_1.id', $invited_members_arr);
            $this->db->where('tab_1.status', 1);
            $query = $this->db->get($this->members_table . ' AS tab_1');
            if ($query->num_rows() > 0) {
                $invited_members = $query->result_array();
            }
        }
        return $invited_members;
    }

    function get_event_accept_members_list($id) {
        $this->db->select('tab_2.* ,tab_3.group_name,tab_4.street_name');
        $this->db->join($this->members_table . ' AS tab_2', 'tab_2.id = tab_1.member_id', 'LEFT');
        $this->db->join($this->group_table . ' AS tab_3', 'tab_3.id = tab_1.family_id', 'LEFT');
        $this->db->join($this->street_table . ' AS tab_4', 'tab_4.id = tab_1.street_id', 'LEFT');
        $this->db->where('tab_1.event_id', $id);
        $this->db->where('tab_1.status', 1);
        $query = $this->db->get($this->event_action_table . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    function get_event_reject_members_list($id) {
        $this->db->select('tab_1.comments AS reason,tab_2.* ,tab_3.group_name,tab_4.street_name');
        $this->db->join($this->members_table . ' AS tab_2', 'tab_2.id = tab_1.member_id', 'LEFT');
        $this->db->join($this->group_table . ' AS tab_3', 'tab_3.id = tab_1.family_id', 'LEFT');
        $this->db->join($this->street_table . ' AS tab_4', 'tab_4.id = tab_1.street_id', 'LEFT');
        $this->db->where('tab_1.event_id', $id);
        $this->db->where('tab_1.status', 0);
        $query = $this->db->get($this->event_action_table . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    function get_today_events() {
        $this->db->select('tab_1.*,tab_2.event_type_name');
        $this->db->select('CONVERT(GROUP_CONCAT(DISTINCT(tab_3.group_name) SEPARATOR ",") USING utf8) AS group_name', FALSE);
        $this->db->select('CONVERT(GROUP_CONCAT(DISTINCT(tab_4.street_name) SEPARATOR ",") USING utf8) AS street_name', FALSE);
        $this->db->select('SUM(tab_5.id) AS accept_count');
        $this->db->select('SUM(tab_6.id) AS reject_count');

        $this->db->join($this->event_type_table . ' AS tab_2', 'tab_2.id = tab_1.event_type_id', 'LEFT');
        $this->db->custom_join($this->group_table . ' AS tab_3', 'FIND_IN_SET(tab_3.id,tab_1.family_types)', 'LEFT');
        $this->db->custom_join($this->street_table . ' AS tab_4', 'FIND_IN_SET(tab_4.id,tab_1.streets)', 'LEFT');
        $this->db->join($this->event_action_table . ' AS tab_5', 'tab_5.event_id = tab_1.id AND tab_5.status = 1', 'LEFT');
        $this->db->join($this->event_action_table . ' AS tab_6', 'tab_6.event_id = tab_1.id AND tab_6.status = 0', 'LEFT');

        $this->db->where('DATE_FORMAT(tab_1.from_date,"%Y-%m-%d")', date('Y-m-d'));
        $this->db->group_by('tab_1.id');

        $query = $this->db->get($this->table_name . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return array ();
    }

    function get_upcoming_events() {
        $this->db->select('tab_1.*,tab_2.event_type_name');
        $this->db->select('CONVERT(GROUP_CONCAT(DISTINCT(tab_3.group_name) SEPARATOR ",") USING utf8) AS group_name', FALSE);
        $this->db->select('CONVERT(GROUP_CONCAT(DISTINCT(tab_4.street_name) SEPARATOR ",") USING utf8) AS street_name', FALSE);
        $this->db->select('SUM(tab_5.id) AS accept_count');
        $this->db->select('SUM(tab_6.id) AS reject_count');

        $this->db->join($this->event_type_table . ' AS tab_2', 'tab_2.id = tab_1.event_type_id', 'LEFT');
        $this->db->custom_join($this->group_table . ' AS tab_3', 'FIND_IN_SET(tab_3.id,tab_1.family_types)', 'LEFT');
        $this->db->custom_join($this->street_table . ' AS tab_4', 'FIND_IN_SET(tab_4.id,tab_1.streets)', 'LEFT');
        $this->db->join($this->event_action_table . ' AS tab_5', 'tab_5.event_id = tab_1.id AND tab_5.status = 1', 'LEFT');
        $this->db->join($this->event_action_table . ' AS tab_6', 'tab_6.event_id = tab_1.id AND tab_6.status = 0', 'LEFT');

        $this->db->where('DATE_FORMAT(tab_1.from_date,"%Y-%m-%d")>', date('Y-m-d'));
        $this->db->group_by('tab_1.id');

        $query = $this->db->get($this->table_name . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return array ();
    }

    function get_datatables($search_data) {
        $this->db->select('tab_1.*,tab_2.event_type_name');
//        $this->db->select('CONVERT(GROUP_CONCAT(DISTINCT(tab_3.group_name) SEPARATOR ",") USING utf8) AS group_name', FALSE);
//        $this->db->select('CONVERT(GROUP_CONCAT(DISTINCT(tab_4.street_name) SEPARATOR ",") USING utf8) AS street_name', FALSE);
        $this->db->select('SUM(tab_5.id) AS accept_count');
        $this->db->select('SUM(tab_6.id) AS reject_count');
        $this->db->select('tab_7.total_invited_members AS invited_count');

        $this->db->join($this->event_type_table . ' AS tab_2', 'tab_2.id = tab_1.event_type_id', 'LEFT');
//        $this->db->custom_join($this->group_table . ' AS tab_3', 'FIND_IN_SET(tab_3.id,tab_1.family_types)', 'LEFT');
//        $this->db->custom_join($this->street_table . ' AS tab_4', 'FIND_IN_SET(tab_4.id,tab_1.streets)', 'LEFT');
        $this->db->join($this->event_action_table . ' AS tab_5', 'tab_5.event_id = tab_1.id AND tab_5.status = 1', 'LEFT');
        $this->db->join($this->event_action_table . ' AS tab_6', 'tab_6.event_id = tab_1.id AND tab_6.status = 0', 'LEFT');
        $this->db->join($this->event_invited_members_table . ' AS tab_7', 'tab_7.event_id = tab_1.id', 'LEFT');

        $i = 0;
        $search_colums = $this->column_search;
        if (!empty($search_colums)) {
            foreach ($search_colums as $item) {
                if (isset($search_data['search']['value']) && !empty($search_data['search']['value'])) {
                    if ($i === 0) {
                        $this->db->like($item, $search_data['search']['value']);
                    } else {
                        $this->db->or_like($item, $search_data['search']['value']);
                    }
                }
                $i++;
            }
        }

        $this->db->group_by('tab_1.id');

        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get($this->table_name . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return array ();
    }

    function count_all() {
        $this->db->select('tab_1.id');
        $query = $this->db->get($this->table_name . ' AS tab_1');
        return $query->num_rows();
    }

    function count_filtered($search_data) {
        $this->db->select('tab_1.id');
        $this->db->select('tab_1.*,tab_2.event_type_name');
//        $this->db->select('CONVERT(GROUP_CONCAT(DISTINCT(tab_3.group_name) SEPARATOR ",") USING utf8) AS group_name', FALSE);
//        $this->db->select('CONVERT(GROUP_CONCAT(DISTINCT(tab_4.street_name) SEPARATOR ",") USING utf8) AS street_name', FALSE);

        $this->db->join($this->event_type_table . ' AS tab_2', 'tab_2.id = tab_1.event_type_id', 'LEFT');
//        $this->db->custom_join($this->group_table . ' AS tab_3', 'FIND_IN_SET(tab_3.id,tab_1.family_types)', 'LEFT');
//        $this->db->custom_join($this->street_table . ' AS tab_4', 'FIND_IN_SET(tab_4.id,tab_1.streets)', 'LEFT');

        $i = 0;
        $search_colums = $this->column_search;
        if (!empty($search_colums)) {
            foreach ($search_colums as $item) {
                if (isset($search_data['search']['value']) && !empty($search_data['search']['value'])) {
                    if ($i === 0) {
                        $this->db->like($item, $search_data['search']['value']);
                    } else {
                        $this->db->or_like($item, $search_data['search']['value']);
                    }
                }
                $i++;
            }
        }

        $this->db->group_by('tab_1.id');

        $query = $this->db->get($this->table_name . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return array ();
    }

}
