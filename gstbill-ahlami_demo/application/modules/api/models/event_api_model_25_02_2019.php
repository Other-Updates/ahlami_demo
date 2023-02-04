<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Event_api_model extends CI_Model {

    private $table_name = 'eve_users';
    private $event_table = 'eve_events';
    private $event_type_table = 'eve_event_types';
    private $member_table = 'eve_members';
    private $group_table = 'eve_groups';
    private $street_table = 'eve_streets';
    private $event_action_table = 'eve_event_actions';
    private $event_invited_members_table = 'eve_event_invited_members';
    private $event_invitation_table = 'eve_event_invitations';
    private $member_location_table = 'eve_member_location';
    private $event_type_dynamic_fields_table = 'eve_event_type_dynamic_fields';
    private $event_dynamic_values_table = 'eve_event_dynamic_values';

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function get_member_by_login($username, $password) {
        $this->db->select('tab_1.*');
        $this->db->where('tab_1.username', $username);
        $this->db->where('tab_1.password', md5($password));
        $this->db->where('tab_1.status', 1);
        $query = $this->db->get($this->member_table . ' AS tab_1');
        if ($query->num_rows() == 1) {
            return $query->result_array();
        }
        return FALSE;
    }

    function get_member_by_id($id) {
        $this->db->select('tab_1.*,tab_2.street_name,tab_3.group_name');
        $this->db->join($this->street_table . ' AS tab_2', 'tab_2.id = tab_1.street_id', 'LEFT');
        $this->db->join($this->group_table . ' AS tab_3', 'tab_3.id = tab_1.family_id', 'LEFT');
        $this->db->where('tab_1.id', $id);
        $query = $this->db->get($this->member_table . ' AS tab_1');
        if ($query->num_rows() > 0) {
            $member_data = $query->result_array();
            $image_path = 'attachments/member_image/' . $member_data[0]['profile_image'];
            $member_data[0]['image_path'] = base_url() . $image_path;
            return $member_data;
        }
        return NULL;
    }

    function update_member_by_id($update_data, $id) {
        $this->db->where($this->member_table . '.id', $id);
        $this->db->update($this->member_table, $update_data);
        $updated_status = $this->db->affected_rows();

        if ($updated_status):
            return 1;
        else:
            return 0;
        endif;
    }

    function update_profile_image($update_data, $id) {
        $this->db->where($this->member_table . '.id', $id);
        if ($this->db->update($this->member_table, $update_data)) {
            return TRUE;
        }
        return FALSE;
    }

    function is_username_exists($username) {
        $this->db->where('tab_1.username', $username);
        $query = $this->db->get($this->member_table . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function is_email_address_exists($email_address) {
        $this->db->where('tab_1.email_address', $email_address);
        $query = $this->db->get($this->member_table . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function insert_member($data) {
        if ($this->db->insert($this->member_table, $data)) {
            $member_id = $this->db->insert_id();
            return $member_id;
        }
        return FALSE;
    }

    function get_streets_by_city_name($city) {
        $this->db->select('tab_1.*');
        $this->db->where('tab_1.city', $city);
        $this->db->where('tab_1.status', 1);
        $query = $this->db->get($this->street_table . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return array();
    }

    function get_family_type_by_street_id($street_id) {
        $this->db->select('tab_1.*');
        $this->db->where('tab_1.street_id', $street_id);
        $this->db->where('tab_1.status', 1);
        $query = $this->db->get($this->group_table . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return array();
    }

    function get_event_details_by_id($id, $member_id) {
        $this->db->select('tab_1.*,tab_2.event_type_name,tab_3.username');
        $this->db->select('CONVERT(GROUP_CONCAT(DISTINCT(tab_4.group_name) SEPARATOR ",") USING utf8) AS group_name', FALSE);
        $this->db->select('CONVERT(GROUP_CONCAT(DISTINCT(tab_5.street_name) SEPARATOR ",") USING utf8) AS street_name', FALSE);

        $this->db->join($this->event_type_table . ' AS tab_2', 'tab_2.id = tab_1.event_type_id', 'LEFT');
        $this->db->join($this->member_table . ' AS tab_3', 'tab_3.id = tab_1.user_id', 'LEFT');
        $this->db->custom_join($this->group_table . ' AS tab_4', 'FIND_IN_SET(tab_4.id,tab_1.family_types)', 'LEFT');
        $this->db->custom_join($this->street_table . ' AS tab_5', 'FIND_IN_SET(tab_5.id,tab_1.streets)', 'LEFT');
        $this->db->where('tab_1.id', $id);
        $query = $this->db->get($this->event_table . ' AS tab_1');
        $event_details = $query->result_array();

        if (count($event_details) > 0) {
            foreach ($event_details as $key => $result) {
                // Get Event Invitations
                $event_invitations = $this->get_event_invitations_by_event_id($id);
                $event_details[$key]['event_invitations'] = $event_invitations;

                $dynamic_values = $this->get_event_dynamic_values_by_event_id($id);

                // Get Event Dynamic Fields
                $event_type_dynamic_fields = $this->get_event_type_dynamic_fields($result['event_type_id']);
                $event_dynamic_fields = array();
                if (!empty($event_type_dynamic_fields)) {
                    foreach ($event_type_dynamic_fields as $list) {
                        $list['field_data'] = json_decode($list['field_data'], TRUE);
                        $event_dynamic_fields[$list['id']] = $list;
                    }
                }
                $event_details[$key]['event_dynamic_fields'] = $event_dynamic_fields;

                // Get Event Dynamic Values
                $event_dynamic_values = array();
                if (!empty($dynamic_values)) {
                    foreach ($dynamic_values as $list) {
                        $event_dynamic_values[$list['field_id']] = $list;
                    }
                }
                $event_details[$key]['event_dynamic_values'] = $event_dynamic_values;

                // Get Event Action Details
                $this->db->select('*');
                $this->db->where('event_id', $id);
                $this->db->where('member_id', $member_id);
                $action_query = $this->db->get($this->event_action_table);
                $event_action = $action_query->result_array();
                $event_status = 0;
                $event_comments = 0;
                if (count($event_action) > 0 && !empty($event_action)) {
                    if ($event_action[0]['status'] == 1) {
                        $event_status = 1;
                    } else if ($event_action[0]['status'] == 0) {
                        $event_status = 2;
                        $event_comments = $get_view_status[0]['comments'];
                    }
                }
                $event_details[$key]['event_status'] = $event_status;
                $event_details[$key]['event_comments'] = $event_comments;
            }
        }
        return $event_details;
    }

    function get_event_invitations_by_id($event_id) {
        $event_invitations = $this->get_event_invitations_by_event_id($event_id);
        return $event_invitations;
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

    function get_event_dynamic_values_by_event_id($id) {
        $this->db->select('tab_1.*');
        $this->db->where('tab_1.event_id', $id);
        $query = $this->db->get($this->event_dynamic_values_table . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    function get_all_streets() {
        $this->db->select('tab_1.*');
        $this->db->where('tab_1.status', 1);
        $this->db->where('tab_1.is_deleted', 0);
        $query = $this->db->get($this->street_table . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    function get_all_groups() {
        $this->db->select($this->group_table . '.*');
        $query = $this->db->get($this->group_table);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    function delete_view($id, $event_id) {
        $this->db->where('member_id', $id);
        $this->db->where('event_id', $event_id);
        if ($this->db->delete($this->event_action_table)) {
            return TRUE;
        }
        return FALSE;
    }

    function insert_events_action($data) {
        if ($this->db->insert($this->event_action_table, $data)) {
            $insert_id = $this->db->insert_id();
            return $insert_id;
        }
        return FALSE;
    }

    function api_get_event_type_details($event_type_id) {
        $event_type_dynamic_fields = $this->get_event_type_dynamic_fields($event_type_id);
        $event_dynamic_fields = array();
        if (!empty($event_type_dynamic_fields)) {
            foreach ($event_type_dynamic_fields as $list) {
                $list['field_data'] = json_decode($list['field_data'], TRUE);
                $event_dynamic_fields[$list['id']] = $list;
            }
        }
        return $event_dynamic_fields;
    }

    function get_family($mobile_number) {
        $this->db->select('tab_2.group_name, tab_2.id');
        $this->db->join($this->group_table . ' AS tab_2', 'tab_2.id = tab_1.family_id', 'LEFT');
        $this->db->where('tab_1.mobile_number', $mobile_number);
        $query = $this->db->get($this->member_table . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    function get_all_event_types() {
        $this->db->select('tab_1.*');
        $query = $this->db->get($this->event_type_table . ' AS tab_1');
        $event_type_details = $query->result_array();
        $event_types = array();
        if (!empty($event_type_details)) {
            foreach ($event_type_details as $list) {
                $list['form_data'] = json_decode($list['form_data'], TRUE);
                $event_types[$list['id']] = $list;
            }
        }
        return $event_types;
    }

    function insert_member_location($data) {
        if ($this->db->insert($this->member_location_table, $data)) {
            $insert_id = $this->db->insert_id();
            return $insert_id;
        }
        return FALSE;
    }

    function delete_member_location($id) {
        $this->db->where('user_id', $id);
        if ($this->db->delete($this->member_location_table)) {
            return TRUE;
        }
        return FALSE;
    }

    function get_today_events($member_id) {
        $member_id_str = json_encode($member_id);
        // Get Member Family, Street ID
        $this->db->select('id,family_id');
        $this->db->where('id', $member_id);
        $member_info = $this->db->get($this->member_table)->result_array();
        $member_family_id = $member_info[0]['family_id'];
        $member_street_id = $member_info[0]['street_id'];
        $current_date = date('Y-m-d');

        $where = "(FIND_IN_SET('" . $member_family_id . "', tab_1.family_types) OR FIND_IN_SET('" . $member_street_id . "', tab_1.streets))";
        $member_where = "(tab_1.invited_members LIKE '%" . "[%" . $member_id . "%]" . "%' )";

        // Get Today Events (Related)
        $this->db->select('tab_1.*,tab_2.event_type_name');
        $this->db->select('(CASE
                           WHEN tab_6.status = 1 THEN 1
                           WHEN tab_6.status = 0 THEN 2
                           ELSE 0 END) AS event_status');
        $this->db->select('(CASE
                           WHEN tab_6.status = 0 THEN tab_6.comments
                           ELSE NULL END) AS comments');
        $this->db->select('GROUP_CONCAT(tab_3.img_path SEPARATOR ",") AS event_invitations', FALSE);
        $this->db->select('CONVERT(GROUP_CONCAT(DISTINCT(tab_4.group_name) SEPARATOR ",") USING utf8) AS group_name', FALSE);
        $this->db->select('CONVERT(GROUP_CONCAT(DISTINCT(tab_5.street_name) SEPARATOR ",") USING utf8) AS street_name', FALSE);

        $this->db->join($this->event_type_table . ' AS tab_2', 'tab_2.id = tab_1.event_type_id', 'LEFT');
        $this->db->join($this->event_invitation_table . ' AS tab_3', 'tab_3.event_id = tab_1.id', 'LEFT');
        $this->db->custom_join($this->group_table . ' AS tab_4', 'FIND_IN_SET(tab_4.id,tab_1.family_types)', 'LEFT');
        $this->db->custom_join($this->street_table . ' AS tab_5', 'FIND_IN_SET(tab_5.id,tab_1.streets)', 'LEFT');
        $this->db->join($this->event_action_table . ' AS tab_6', 'tab_6.event_id = tab_1.id AND tab_6.member_id = ' . $member_id, 'LEFT');

        $this->db->where('DATE(tab_1.from_date)', $current_date);
        $this->db->where($where);
        $this->db->group_by('tab_1.id');
        $query_1 = $this->db->get($this->event_table . ' AS tab_1');
        $related_events_list = $query_1->result_array();

        // Get Today Events (Invited)
        $this->db->select('tab_2.*,tab_3.event_type_name');
        $this->db->select('(CASE
                           WHEN tab_7.status = 1 THEN 1
                           WHEN tab_7.status = 0 THEN 2
                           ELSE 0 END) AS event_status');
        $this->db->select('(CASE
                           WHEN tab_7.status = 0 THEN tab_7.comments
                           ELSE NULL END) AS comments');
        $this->db->select('GROUP_CONCAT(tab_4.img_path SEPARATOR ",") AS event_invitations', FALSE);
        $this->db->select('CONVERT(GROUP_CONCAT(DISTINCT(tab_5.group_name) SEPARATOR ",") USING utf8) AS group_name', FALSE);
        $this->db->select('CONVERT(GROUP_CONCAT(DISTINCT(tab_6.street_name) SEPARATOR ",") USING utf8) AS street_name', FALSE);

        $this->db->join($this->event_table . ' AS tab_2', 'tab_2.id = tab_1.event_id', 'LEFT');
        $this->db->join($this->event_type_table . ' AS tab_3', 'tab_3.id = tab_2.event_type_id', 'LEFT');
        $this->db->join($this->event_invitation_table . ' AS tab_4', 'tab_4.event_id = tab_1.id', 'LEFT');
        $this->db->custom_join($this->group_table . ' AS tab_5', 'FIND_IN_SET(tab_5.id,tab_2.family_types)', 'LEFT');
        $this->db->custom_join($this->street_table . ' AS tab_6', 'FIND_IN_SET(tab_6.id,tab_2.streets)', 'LEFT');
        $this->db->join($this->event_action_table . ' AS tab_7', 'tab_7.event_id = tab_1.id AND tab_7.member_id = ' . $member_id, 'LEFT');
        $this->db->where('DATE(tab_2.from_date)', $current_date);
        $this->db->where($member_where, NULL, FALSE);
        $this->db->group_by('tab_1.id');
        $query_2 = $this->db->get($this->event_invited_members_table . ' AS tab_1');

        $other_events_list = $query_2->result_array();

        $today_events = array();
        if (!empty($related_events_list)) {
            foreach ($related_events_list as $related_events) {
                $today_events[$related_events['id']] = $related_events;
            }
        }
        if (!empty($other_events_list)) {
            foreach ($other_events_list as $other_events) {
                $today_events[$other_events['id']] = $other_events;
            }
        }
        return $today_events;
    }

    function get_upcoming_events($member_id) {
        $member_id_str = json_encode($member_id);
        // Get Member Family, Street ID
        $this->db->select('id,family_id');
        $this->db->where('id', $member_id);
        $member_info = $this->db->get($this->member_table)->result_array();
        $member_family_id = $member_info[0]['family_id'];
        $member_street_id = $member_info[0]['street_id'];
        $current_date = date('Y-m-d');

        $where = "(FIND_IN_SET('" . $member_family_id . "', tab_1.family_types) OR FIND_IN_SET('" . $member_street_id . "', tab_1.streets))";
        $member_where = "(tab_1.invited_members LIKE '%" . "[%" . $member_id . "%]" . "%' )";

        // Get Today Events (Related)
        $this->db->select('tab_1.*,tab_2.event_type_name');
        $this->db->select('(CASE
                           WHEN tab_6.status = 1 THEN 1
                           WHEN tab_6.status = 0 THEN 2
                           ELSE 0 END) AS event_status');
        $this->db->select('(CASE
                           WHEN tab_6.status = 0 THEN tab_6.comments
                           ELSE NULL END) AS comments');
        $this->db->select('GROUP_CONCAT(tab_3.img_path SEPARATOR ",") AS event_invitations', FALSE);
        $this->db->select('CONVERT(GROUP_CONCAT(DISTINCT(tab_4.group_name) SEPARATOR ",") USING utf8) AS group_name', FALSE);
        $this->db->select('CONVERT(GROUP_CONCAT(DISTINCT(tab_5.street_name) SEPARATOR ",") USING utf8) AS street_name', FALSE);

        $this->db->join($this->event_type_table . ' AS tab_2', 'tab_2.id = tab_1.event_type_id', 'LEFT');
        $this->db->join($this->event_invitation_table . ' AS tab_3', 'tab_3.event_id = tab_1.id', 'LEFT');
        $this->db->custom_join($this->group_table . ' AS tab_4', 'FIND_IN_SET(tab_4.id,tab_1.family_types)', 'LEFT');
        $this->db->custom_join($this->street_table . ' AS tab_5', 'FIND_IN_SET(tab_5.id,tab_1.streets)', 'LEFT');
        $this->db->join($this->event_action_table . ' AS tab_6', 'tab_6.event_id = tab_1.id AND tab_6.member_id = ' . $member_id, 'LEFT');

        $this->db->where('DATE_FORMAT(tab_1.from_date, "%Y-%m-%d")>', $current_date);
        $this->db->where($where);
        $this->db->group_by('tab_1.id');
        $query_1 = $this->db->get($this->event_table . ' AS tab_1');
        $related_events_list = $query_1->result_array();

        // Get Today Events (Invited)
        $this->db->select('tab_2.*,tab_3.event_type_name');
        $this->db->select('(CASE
                           WHEN tab_7.status = 1 THEN 1
                           WHEN tab_7.status = 0 THEN 2
                           ELSE 0 END) AS event_status');
        $this->db->select('(CASE
                           WHEN tab_7.status = 0 THEN tab_7.comments
                           ELSE NULL END) AS comments');
        $this->db->select('GROUP_CONCAT(tab_4.img_path SEPARATOR ",") AS event_invitations', FALSE);
        $this->db->select('CONVERT(GROUP_CONCAT(DISTINCT(tab_5.group_name) SEPARATOR ",") USING utf8) AS group_name', FALSE);
        $this->db->select('CONVERT(GROUP_CONCAT(DISTINCT(tab_6.street_name) SEPARATOR ",") USING utf8) AS street_name', FALSE);

        $this->db->join($this->event_table . ' AS tab_2', 'tab_2.id = tab_1.event_id', 'LEFT');
        $this->db->join($this->event_type_table . ' AS tab_3', 'tab_3.id = tab_2.event_type_id', 'LEFT');
        $this->db->join($this->event_invitation_table . ' AS tab_4', 'tab_4.event_id = tab_1.id', 'LEFT');
        $this->db->custom_join($this->group_table . ' AS tab_5', 'FIND_IN_SET(tab_5.id,tab_2.family_types)', 'LEFT');
        $this->db->custom_join($this->street_table . ' AS tab_6', 'FIND_IN_SET(tab_6.id,tab_2.streets)', 'LEFT');
        $this->db->join($this->event_action_table . ' AS tab_7', 'tab_7.event_id = tab_1.id AND tab_7.member_id = ' . $member_id, 'LEFT');
        $this->db->where('DATE_FORMAT(tab_2.from_date, "%Y-%m-%d")>', $current_date);
        $this->db->where($member_where, NULL, FALSE);
        $this->db->group_by('tab_1.id');
        $query_2 = $this->db->get($this->event_invited_members_table . ' AS tab_1');

        $other_events_list = $query_2->result_array();

        $upcoming_events = array();
        if (!empty($related_events_list)) {
            foreach ($related_events_list as $related_events) {
                $upcoming_events[$related_events['id']] = $related_events;
            }
        }
        if (!empty($other_events_list)) {
            foreach ($other_events_list as $other_events) {
                $upcoming_events[$other_events['id']] = $other_events;
            }
        }
        return $upcoming_events;
    }

    function get_past_events($member_id) {
        $member_id_str = json_encode($member_id);
        // Get Member Family, Street ID
        $this->db->select('id,family_id');
        $this->db->where('id', $member_id);
        $member_info = $this->db->get($this->member_table)->result_array();
        $member_family_id = $member_info[0]['family_id'];
        $member_street_id = $member_info[0]['street_id'];
        $current_date = date('Y-m-d');

        $where = "(FIND_IN_SET('" . $member_family_id . "', tab_1.family_types) OR FIND_IN_SET('" . $member_street_id . "', tab_1.streets))";
        $member_where = "(tab_1.invited_members LIKE '%" . "[%" . $member_id . "%]" . "%' )";

        // Get Today Events (Related)
        $this->db->select('tab_1.*,tab_2.event_type_name');
        $this->db->select('(CASE
                           WHEN tab_6.status = 1 THEN 1
                           WHEN tab_6.status = 0 THEN 2
                           ELSE 0 END) AS event_status');
        $this->db->select('(CASE
                           WHEN tab_6.status = 0 THEN tab_6.comments
                           ELSE NULL END) AS comments');
        $this->db->select('GROUP_CONCAT(tab_3.img_path SEPARATOR ",") AS event_invitations', FALSE);
        $this->db->select('CONVERT(GROUP_CONCAT(DISTINCT(tab_4.group_name) SEPARATOR ",") USING utf8) AS group_name', FALSE);
        $this->db->select('CONVERT(GROUP_CONCAT(DISTINCT(tab_5.street_name) SEPARATOR ",") USING utf8) AS street_name', FALSE);

        $this->db->join($this->event_type_table . ' AS tab_2', 'tab_2.id = tab_1.event_type_id', 'LEFT');
        $this->db->join($this->event_invitation_table . ' AS tab_3', 'tab_3.event_id = tab_1.id', 'LEFT');
        $this->db->custom_join($this->group_table . ' AS tab_4', 'FIND_IN_SET(tab_4.id,tab_1.family_types)', 'LEFT');
        $this->db->custom_join($this->street_table . ' AS tab_5', 'FIND_IN_SET(tab_5.id,tab_1.streets)', 'LEFT');
        $this->db->join($this->event_action_table . ' AS tab_6', 'tab_6.event_id = tab_1.id AND tab_6.member_id = ' . $member_id, 'LEFT');

        $this->db->where('DATE_FORMAT(tab_1.from_date, "%Y-%m-%d")<', $current_date);
        $this->db->where($where);
        $this->db->group_by('tab_1.id');
        $query_1 = $this->db->get($this->event_table . ' AS tab_1');
        $related_events_list = $query_1->result_array();

        // Get Today Events (Invited)
        $this->db->select('tab_2.*,tab_3.event_type_name');
        $this->db->select('(CASE
                           WHEN tab_7.status = 1 THEN 1
                           WHEN tab_7.status = 0 THEN 2
                           ELSE 0 END) AS event_status');
        $this->db->select('(CASE
                           WHEN tab_7.status = 0 THEN tab_7.comments
                           ELSE NULL END) AS comments');
        $this->db->select('GROUP_CONCAT(tab_4.img_path SEPARATOR ",") AS event_invitations', FALSE);
        $this->db->select('CONVERT(GROUP_CONCAT(DISTINCT(tab_5.group_name) SEPARATOR ",") USING utf8) AS group_name', FALSE);
        $this->db->select('CONVERT(GROUP_CONCAT(DISTINCT(tab_6.street_name) SEPARATOR ",") USING utf8) AS street_name', FALSE);

        $this->db->join($this->event_table . ' AS tab_2', 'tab_2.id = tab_1.event_id', 'LEFT');
        $this->db->join($this->event_type_table . ' AS tab_3', 'tab_3.id = tab_2.event_type_id', 'LEFT');
        $this->db->join($this->event_invitation_table . ' AS tab_4', 'tab_4.event_id = tab_1.id', 'LEFT');
        $this->db->custom_join($this->group_table . ' AS tab_5', 'FIND_IN_SET(tab_5.id,tab_2.family_types)', 'LEFT');
        $this->db->custom_join($this->street_table . ' AS tab_6', 'FIND_IN_SET(tab_6.id,tab_2.streets)', 'LEFT');
        $this->db->join($this->event_action_table . ' AS tab_7', 'tab_7.event_id = tab_1.id AND tab_7.member_id = ' . $member_id, 'LEFT');
        $this->db->where('DATE_FORMAT(tab_2.from_date, "%Y-%m-%d")<', $current_date);
        $this->db->where($member_where, NULL, FALSE);
        $this->db->group_by('tab_1.id');
        $query_2 = $this->db->get($this->event_invited_members_table . ' AS tab_1');

        $other_events_list = $query_2->result_array();

        $past_events = array();
        if (!empty($related_events_list)) {
            foreach ($related_events_list as $related_events) {
                $past_events[$related_events['id']] = $related_events;
            }
        }
        if (!empty($other_events_list)) {
            foreach ($other_events_list as $other_events) {
                $past_events[$other_events['id']] = $other_events;
            }
        }
        return $past_events;
    }

    function get_all_events() {
        $this->db->select('tab_1.*,tab_2.event_type_name');
        $this->db->select('CONVERT(GROUP_CONCAT(DISTINCT(tab_4.group_name) SEPARATOR ",") USING utf8) AS group_name', FALSE);
        $this->db->select('CONVERT(GROUP_CONCAT(DISTINCT(tab_5.street_name) SEPARATOR ",") USING utf8) AS street_name', FALSE);
        $this->db->select('SUM(tab_3.family_id) AS family_count');
        $this->db->select('SUM(tab_6.id) AS accept_count');
        $this->db->select('SUM(tab_7.id) AS reject_count');

        $this->db->join($this->event_type_table . ' AS tab_2', 'tab_2.id = tab_1.event_type_id', 'LEFT');
        $this->db->custom_join($this->member_table . ' AS tab_3', 'FIND_IN_SET(tab_3.family_id,tab_1.family_types)', 'LEFT');
        $this->db->custom_join($this->group_table . ' AS tab_4', 'FIND_IN_SET(tab_4.id,tab_1.family_types)', 'LEFT');
        $this->db->custom_join($this->street_table . ' AS tab_5', 'FIND_IN_SET(tab_5.id,tab_1.streets)', 'LEFT');
        $this->db->join($this->event_action_table . ' AS tab_6', 'tab_6.event_id = tab_1.id AND tab_6.status = 1', 'LEFT');
        $this->db->join($this->event_action_table . ' AS tab_7', 'tab_7.event_id = tab_1.id AND tab_6.status = 0', 'LEFT');
        $this->db->group_by('tab_1.id');
        $this->db->order_by('tab_1.id', 'DESC');
        $query = $this->db->get($this->event_table . ' AS tab_1');
        $all_events = $query->result_array();
        return $all_events;
    }

    function get_my_events($user_id) {
        $this->db->select('tab_1.*,tab_2.event_type_name');
        $this->db->select('CONVERT(GROUP_CONCAT(DISTINCT(tab_3.group_name) SEPARATOR ",") USING utf8) AS group_name', FALSE);
        $this->db->select('CONVERT(GROUP_CONCAT(DISTINCT(tab_4.street_name) SEPARATOR ",") USING utf8) AS street_name', FALSE);
        $this->db->select('SUM(tab_5.id) AS accept_count');
        $this->db->select('SUM(tab_6.id) AS reject_count');
        $this->db->select('tab_7.total_invited_members AS invited_count');
        $this->db->select('GROUP_CONCAT(tab_8.img_path SEPARATOR ",") AS event_invitations', FALSE);

        $this->db->join($this->event_type_table . ' AS tab_2', 'tab_2.id = tab_1.event_type_id', 'LEFT');
        $this->db->custom_join($this->group_table . ' AS tab_3', 'FIND_IN_SET(tab_3.id,tab_1.family_types)', 'LEFT');
        $this->db->custom_join($this->street_table . ' AS tab_4', 'FIND_IN_SET(tab_4.id,tab_1.streets)', 'LEFT');
        $this->db->join($this->event_action_table . ' AS tab_5', 'tab_5.event_id = tab_1.id AND tab_5.status = 1', 'LEFT');
        $this->db->join($this->event_action_table . ' AS tab_6', 'tab_6.event_id = tab_1.id AND tab_6.status = 0', 'LEFT');
        $this->db->join($this->event_invited_members_table . ' AS tab_7', 'tab_7.event_id = tab_1.id', 'LEFT');
        $this->db->join($this->event_invitation_table . ' AS tab_8', 'tab_8.event_id = tab_1.id', 'LEFT');

        $this->db->where('tab_1.user_id', $user_id);
        $this->db->group_by('tab_1.id');
        $this->db->order_by('tab_1.id', 'DESC');
        $query = $this->db->get($this->event_table . ' AS tab_1');
        $my_events = $query->result_array();
        return $my_events;
    }

    function check_user_in_location($user_id) {
        $this->db->select('*');
        $this->db->where('user_id', $user_id);
        $user_info = $this->db->get($this->member_location_table)->result_array();
        $user_latitude = $user_info[0]['latitude'];
        $user_longitude = $user_info[0]['longitude'];
        $kayal_latitude = '11.0168';
        $kayal_longitude = '76.9558';
        if ((round($user_latitude) == round($kayal_latitude)) && (round($user_longitude) == round($kayal_lang))) {
            return 1;
        } else {
            $distance = $this->get_distance_between_latitude_longitude($user_latitude, $user_longitude, $kayal_latitude, $kayal_longitude);
            if ($distance > 12) {
                return 0;
            } else {
                return 1;
            }
        }
    }

    function get_distance_between_latitude_longitude($lat1, $lng1, $lat2, $lng2) {
        $pi80 = M_PI / 180;

        $lat1 *= $pi80;
        $lng1 *= $pi80;
        $lat2 *= $pi80;
        $lng2 *= $pi80;

        $r = 6372.797; // mean radius of Earth in km
        $dlat = $lat2 - $lat1;
        $dlng = $lng2 - $lng1;
        $a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlng / 2) * sin($dlng / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $r * $c;
        $distance = round($distance);

        $distance = floatval($distance);
        $onekm = 0.621371; //one kilometer == miles
        $miles = $distance * $onekm;
        $distance = number_format((float) $distance, 2, '.', '');
        return $distance;
    }

    function get_accept_members_details($event_id) {
        $this->db->select('tab_2.* ,tab_3.group_name,tab_4.street_name');
        $this->db->join($this->member_table . ' AS tab_2', 'tab_2.id = tab_1.member_id', 'LEFT');
        $this->db->join($this->group_table . ' AS tab_3', 'tab_3.id = tab_1.family_id', 'LEFT');
        $this->db->join($this->street_table . ' AS tab_4', 'tab_4.id = tab_1.street_id', 'LEFT');
        $this->db->where('tab_1.event_id', $event_id);
        $this->db->where('tab_1.status', 1);

        $query = $this->db->get($this->event_action_table . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    function get_reject_members_details($event_id) {
        $this->db->select('tab_2.* ,tab_3.group_name,tab_4.street_name,tab_1.comments AS reason');
        $this->db->join($this->member_table . ' AS tab_2', 'tab_2.id = tab_1.member_id', 'LEFT');
        $this->db->join($this->group_table . ' AS tab_3', 'tab_3.id = tab_1.family_id', 'LEFT');
        $this->db->join($this->street_table . ' AS tab_4', 'tab_4.id = tab_1.street_id', 'LEFT');
        $this->db->where('tab_1.event_id', $event_id);
        $this->db->where('tab_1.status', 0);
        $query = $this->db->get($this->event_action_table . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    function get_invited_members_details($event_id) {
        $this->db->select('tab_1.*');
        $this->db->where('tab_1.event_id', $id);
        $query = $this->db->get($this->event_invited_members_table . ' AS tab_1');
        $event_invited_members = $query->result_array();
        $invited_members_json = $event_invited_members[0]['invited_members'];
        $invited_members_arr = json_decode($invited_members_json, TRUE);

        $invited_members = array();
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

    function get_all_events_list($member_id) {
        $member_id_str = json_encode($member_id);
        // Get Member Family, Street ID
        $this->db->select('id,family_id');
        $this->db->where('id', $member_id);
        $member_info = $this->db->get($this->member_table)->result_array();
        $member_family_id = $member_info[0]['family_id'];
        $member_street_id = $member_info[0]['street_id'];
        $current_date = date('Y-m-d');

        $where = "(FIND_IN_SET('" . $member_family_id . "', tab_1.family_types) OR FIND_IN_SET('" . $member_street_id . "', tab_1.streets))";
        $member_where = "(tab_1.invited_members LIKE '%" . "[%" . $member_id . "%]" . "%' )";

        // Get Today Events (Related)
        $this->db->select('tab_1.*,tab_2.event_type_name');
        $this->db->select('(CASE
                           WHEN tab_6.status = 1 THEN 1
                           WHEN tab_6.status = 0 THEN 2
                           ELSE 0 END) AS event_status');
        $this->db->select('(CASE
                           WHEN tab_6.status = 0 THEN tab_6.comments
                           ELSE NULL END) AS comments');
        $this->db->select('GROUP_CONCAT(tab_3.img_path SEPARATOR ",") AS event_invitations', FALSE);
        $this->db->select('CONVERT(GROUP_CONCAT(DISTINCT(tab_4.group_name) SEPARATOR ",") USING utf8) AS group_name', FALSE);
        $this->db->select('CONVERT(GROUP_CONCAT(DISTINCT(tab_5.street_name) SEPARATOR ",") USING utf8) AS street_name', FALSE);

        $this->db->join($this->event_type_table . ' AS tab_2', 'tab_2.id = tab_1.event_type_id', 'LEFT');
        $this->db->join($this->event_invitation_table . ' AS tab_3', 'tab_3.event_id = tab_1.id', 'LEFT');
        $this->db->custom_join($this->group_table . ' AS tab_4', 'FIND_IN_SET(tab_4.id,tab_1.family_types)', 'LEFT');
        $this->db->custom_join($this->street_table . ' AS tab_5', 'FIND_IN_SET(tab_5.id,tab_1.streets)', 'LEFT');
        $this->db->join($this->event_action_table . ' AS tab_6', 'tab_6.event_id = tab_1.id AND tab_6.member_id = ' . $member_id, 'LEFT');

        $this->db->where($where);
        $this->db->group_by('tab_1.id');
        $query_1 = $this->db->get($this->event_table . ' AS tab_1');
        $related_events_list = $query_1->result_array();

        // Get Today Events (Invited)
        $this->db->select('tab_2.*,tab_3.event_type_name');
        $this->db->select('(CASE
                           WHEN tab_7.status = 1 THEN 1
                           WHEN tab_7.status = 0 THEN 2
                           ELSE 0 END) AS event_status');
        $this->db->select('(CASE
                           WHEN tab_7.status = 0 THEN tab_7.comments
                           ELSE NULL END) AS comments');
        $this->db->select('GROUP_CONCAT(tab_4.img_path SEPARATOR ",") AS event_invitations', FALSE);
        $this->db->select('CONVERT(GROUP_CONCAT(DISTINCT(tab_5.group_name) SEPARATOR ",") USING utf8) AS group_name', FALSE);
        $this->db->select('CONVERT(GROUP_CONCAT(DISTINCT(tab_6.street_name) SEPARATOR ",") USING utf8) AS street_name', FALSE);

        $this->db->join($this->event_table . ' AS tab_2', 'tab_2.id = tab_1.event_id', 'LEFT');
        $this->db->join($this->event_type_table . ' AS tab_3', 'tab_3.id = tab_2.event_type_id', 'LEFT');
        $this->db->join($this->event_invitation_table . ' AS tab_4', 'tab_4.event_id = tab_1.id', 'LEFT');
        $this->db->custom_join($this->group_table . ' AS tab_5', 'FIND_IN_SET(tab_5.id,tab_2.family_types)', 'LEFT');
        $this->db->custom_join($this->street_table . ' AS tab_6', 'FIND_IN_SET(tab_6.id,tab_2.streets)', 'LEFT');
        $this->db->join($this->event_action_table . ' AS tab_7', 'tab_7.event_id = tab_1.id AND tab_7.member_id = ' . $member_id, 'LEFT');
        $this->db->where($member_where, NULL, FALSE);
        $this->db->group_by('tab_1.id');
        $query_2 = $this->db->get($this->event_invited_members_table . ' AS tab_1');

        $other_events_list = $query_2->result_array();

        $all_events = array();
        if (!empty($related_events_list)) {
            foreach ($related_events_list as $related_events) {
                $all_events[$related_events['id']] = $related_events;
            }
        }
        if (!empty($other_events_list)) {
            foreach ($other_events_list as $other_events) {
                $all_events[$other_events['id']] = $other_events;
            }
        }
        return $all_events;
    }

    function is_event_name_available($event_name, $event_id = NULL) {
        $this->db->select('tab_1.id');
        if (!empty($event_id))
            $this->db->where('tab_1.id != ', $event_id);
        $this->db->where('LCASE(tab_1.event_name)', strtolower($event_name));
        $query = $this->db->get($this->event_table . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return FALSE;
        }
        return TRUE;
    }

    function insert_event($data) {
        if ($this->db->insert($this->event_table, $data)) {
            return $this->db->insert_id();
        }
        return FALSE;
    }

    function update_event($data, $event_id) {
        $this->db->where('id', $event_id);
        if ($this->db->update($this->event_table, $data)) {
            return TRUE;
        }
        return FALSE;
    }

    function insert_event_invitation($data) {
        if ($this->db->insert($this->event_invitation_table, $data)) {
            return $this->db->insert_id();
        }
        return FALSE;
    }

    function insert_event_dynamic_values($data) {
        if ($this->db->insert_batch($this->event_dynamic_values_table, $data)) {
            return TRUE;
        }
        return FALSE;
    }

    function update_event_dynamic_values($update_data, $event_id) {
        if (!empty($update_data)) {
            foreach ($update_data as $field_id => $data) {
                $this->db->where('field_id', $field_id);
                $this->db->where('event_id', $event_id);
                $this->db->update($this->event_dynamic_values_table, $data);
            }
            return TRUE;
        }
        return FALSE;
    }

    function get_event_invitations_by_event_id($id) {
        $this->db->select('tab_1.*');
        $this->db->where('tab_1.event_id', $id);
        $query = $this->db->get($this->event_invitation_table . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    function delete_event_invitation_by_id($id) {
        $this->db->where('id', $id);
        if ($this->db->delete($this->event_invitation_table)) {
            return TRUE;
        }
        return FALSE;
    }

}
