<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

    private $table_name = 'eve_events';
    private $event_invited_members_table = 'eve_event_invited_members';
    private $event_type_table = 'eve_event_types';
    private $group_table = 'eve_groups';
    private $street_table = 'eve_streets';
    private $event_action_table = 'eve_event_actions';

    function __construct() {
        $this->load->database();
        parent::__construct();
    }

    function get_today_events() {
        $this->db->select('tab_1.*,tab_2.event_type_name');
        $this->db->select('tab_3.total_invited_members AS invited_count');
        $this->db->select('SUM(tab_4.id) AS accept_count');
        $this->db->select('SUM(tab_5.id) AS reject_count');

        $this->db->join($this->event_type_table . ' AS tab_2', 'tab_2.id = tab_1.event_type_id', 'LEFT');
        $this->db->join($this->event_invited_members_table . ' AS tab_3', 'tab_3.event_id = tab_1.id', 'LEFT');
        $this->db->join($this->event_action_table . ' AS tab_4', 'tab_4.event_id = tab_1.id AND tab_4.status = 1', 'LEFT');
        $this->db->join($this->event_action_table . ' AS tab_5', 'tab_5.event_id = tab_1.id AND tab_5.status = 0', 'LEFT');

        $this->db->where('DATE_FORMAT(tab_1.from_date,"%Y-%m-%d")', date('Y-m-d'));
        $this->db->group_by('tab_1.id');
        $this->db->order_by('tab_1.id', 'DESC');
        $this->db->limit(5);
        $query = $this->db->get($this->table_name . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return array ();
    }

    function get_all_today_events() {
        $this->db->select('tab_1.*,tab_2.event_type_name');
        $this->db->select('tab_3.total_invited_members AS invited_count');
        $this->db->select('SUM(tab_4.id) AS accept_count');
        $this->db->select('SUM(tab_5.id) AS reject_count');

        $this->db->join($this->event_type_table . ' AS tab_2', 'tab_2.id = tab_1.event_type_id', 'LEFT');
        $this->db->join($this->event_invited_members_table . ' AS tab_3', 'tab_3.event_id = tab_1.id', 'LEFT');
        $this->db->join($this->event_action_table . ' AS tab_4', 'tab_4.event_id = tab_1.id AND tab_4.status = 1', 'LEFT');
        $this->db->join($this->event_action_table . ' AS tab_5', 'tab_5.event_id = tab_1.id AND tab_5.status = 0', 'LEFT');

        $this->db->where('DATE_FORMAT(tab_1.from_date,"%Y-%m-%d")', date('Y-m-d'));
        $this->db->group_by('tab_1.id');
        $this->db->order_by('tab_1.id', 'DESC');

        $query = $this->db->get($this->table_name . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return array ();
    }

    function get_upcoming_events() {
        $this->db->select('tab_1.*,tab_2.event_type_name');
        $this->db->select('tab_3.total_invited_members AS invited_count');
        $this->db->select('SUM(tab_4.id) AS accept_count');
        $this->db->select('SUM(tab_5.id) AS reject_count');

        $this->db->join($this->event_type_table . ' AS tab_2', 'tab_2.id = tab_1.event_type_id', 'LEFT');
        $this->db->join($this->event_invited_members_table . ' AS tab_3', 'tab_3.event_id = tab_1.id', 'LEFT');
        $this->db->join($this->event_action_table . ' AS tab_4', 'tab_4.event_id = tab_1.id AND tab_4.status = 1', 'LEFT');
        $this->db->join($this->event_action_table . ' AS tab_5', 'tab_5.event_id = tab_1.id AND tab_5.status = 0', 'LEFT');

        $this->db->where('DATE_FORMAT(tab_1.from_date,"%Y-%m-%d")>', date('Y-m-d'));
        $this->db->group_by('tab_1.id');
        $this->db->order_by('tab_1.id', 'DESC');
        $this->db->limit(5);
        $query = $this->db->get($this->table_name . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return array ();
    }

    function get_all_upcoming_events() {
        $this->db->select('tab_1.*,tab_2.event_type_name');
        $this->db->select('tab_3.total_invited_members AS invited_count');
        $this->db->select('SUM(tab_4.id) AS accept_count');
        $this->db->select('SUM(tab_5.id) AS reject_count');

        $this->db->join($this->event_type_table . ' AS tab_2', 'tab_2.id = tab_1.event_type_id', 'LEFT');
        $this->db->join($this->event_invited_members_table . ' AS tab_3', 'tab_3.event_id = tab_1.id', 'LEFT');
        $this->db->join($this->event_action_table . ' AS tab_4', 'tab_4.event_id = tab_1.id AND tab_4.status = 1', 'LEFT');
        $this->db->join($this->event_action_table . ' AS tab_5', 'tab_5.event_id = tab_1.id AND tab_5.status = 0', 'LEFT');

        $this->db->where('DATE_FORMAT(tab_1.from_date,"%Y-%m-%d")>', date('Y-m-d'));
        $this->db->group_by('tab_1.id');
        $this->db->order_by('tab_1.id', 'DESC');

        $query = $this->db->get($this->table_name . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return array ();
    }

    function get_all_events() {
        $SQL = "SELECT tab_1.id,tab_1.event_name,DATE_FORMAT(tab_1.from_date, '%Y-%m-%dT%H:%i:%s') AS formatted_from_date,DATE_FORMAT(tab_1.to_date, '%Y-%m-%dT%H:%i:%s') AS formatted_to_date FROM eve_events AS tab_1 WHERE tab_1.status = 1";
        $query = $this->db->query($SQL);
        return $query->result_array();
    }

    function get_events_by_event_type() {
        $this->db->select('tab_2.event_type_name');
        $this->db->select('COUNT(tab_1.id) AS total');
        $this->db->join($this->event_type_table . ' AS tab_2', 'tab_2.id = tab_1.event_type_id', 'LEFT');
        $this->db->group_by('tab_1.event_type_id');

        $query = $this->db->get($this->table_name . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return array ();
    }

}
