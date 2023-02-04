
<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Members_model extends CI_Model {

    private $table_name = 'eve_members';
    private $group_table = 'eve_groups';
    private $street_table = 'eve_streets';
    private $events_table = 'eve_events';
    private $member_location_table = 'eve_member_location';
    private $user_type_table = 'scoo_user_types';
    private $event_type_table = 'eve_event_types';
    var $joinTable1 = 'eve_groups tab_2';
    var $joinTable2 = 'eve_streets tab_3';
    var $primaryTable = 'eve_members tab_1';
    var $selectColumn = 'tab_1.*,tab_2.group_name,tab_3.street_name';
    var $column_order = array('tab_1.id', 'CONCAT(tab_1.firstname, " ", tab_1.lastname)', 'tab_1.username', 'tab_1.email_address', 'tab_2.group_name', 'tab_1.relation', 'tab_3.street_name', 'tab_1.status');
    var $column_search = array('tab_1.firstname', 'tab_1.username', 'tab_1.email_address', 'tab_2.group_name', 'tab_1.relation', 'tab_3.street_name', 'tab_1.status');
    var $order = array('tab_1.id' => 'desc ');

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insert_member($data) {
        if ($this->db->insert($this->table_name, $data)) {
            $user_id = $this->db->insert_id();
            return $user_id;
        }
        return FALSE;
    }

    function update_member($data, $user_id) {
        $this->db->where('id', $user_id);
        if ($this->db->update($this->table_name, $data)) {
            return 1;
        }
        return 0;
    }

    function delete_member($id) {
        $this->db->where('id', $id);
        if ($this->db->delete($this->table_name)) {
            return 1;
        }
        return 0;
    }

    function get_all_members() {
        $this->db->select('tab_1.*,tab_2.group_name,tab_3.street_name');
        $this->db->join($this->group_table . ' AS tab_2', 'tab_2.id = tab_1.family_id', 'LEFT');
        $this->db->join($this->street_table . ' AS tab_3', 'tab_3.id = tab_1.street_id', 'LEFT');
        $this->db->order_by('tab_1.id', 'DESC');
        $query = $this->db->get($this->table_name . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    function get_members_by_list($members = array()) {
        $this->db->select('tab_1.id, tab_1.email_address');
        $this->db->where_in('tab_1.id', $members);
        //$this->db->where('tab_1.approved_status', 1);
        //$this->db->where('tab_1.id !=', $already_invited_mem);
        //$this->db->where_not_in('tab_1.id', $already_invited_mem);
        $query = $this->db->get($this->table_name . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    function get_count_variables($label, $id) {
        if ($label == 'city')
            $this->db->where('city', $id);
        else if ($label == 'street')
            $this->db->where('street_id', $id);
        else if ($label == 'family')
            $this->db->where('family_id', $id);

        $query = $this->db->get($this->table_name);
        return $query->num_rows();
    }

    function get_all_members_tree_structure() {
        $all_members = array();
        $members_count_arr = array();
        $members_section_arr = array();
        $this->db->select('tab_1.*,tab_2.group_name,tab_3.street_name');
        $this->db->join($this->group_table . ' AS tab_2', 'tab_2.id = tab_1.family_id', 'LEFT');
        $this->db->join($this->street_table . ' AS tab_3', 'tab_3.id = tab_1.street_id', 'LEFT');
        $this->db->order_by('tab_1.id', 'DESC');
        //$this->db->where('tab_1.approved_status', 1);
        $query = $this->db->get($this->table_name . ' AS tab_1');
        $result = $query->result_array();


        if (!empty($result)) {
            foreach ($result as $list) {
                $city = $list['city'];
                $street_id = $list['street_id'];
                $family_id = $list['family_id'];
                $all_members[$city][$street_id][$family_id][] = $list;
                $members_section_arr['city'][$city][] = $list['id'];
                $members_section_arr['street'][$street_id][] = $list['id'];
                $members_section_arr['group'][$family_id][] = $list['id'];
                if (isset($members_count_arr['city'][$city])) {
                    $members_count_arr['city'][$city] += 1;
                } else {
                    $members_count_arr['city'][$city] = 1;
                }
                if (isset($members_count_arr['street'][$street_id])) {
                    $members_count_arr['street'][$street_id] += 1;
                } else {
                    $members_count_arr['street'][$street_id] = 1;
                }
                if (isset($members_count_arr['group'][$family_id])) {
                    $members_count_arr['group'][$family_id] += 1;
                } else {
                    $members_count_arr['group'][$family_id] = 1;
                }
            }
        }
        $tree_structure_arr = array(
            'all_members' => $all_members,
            'members_section' => $members_section_arr,
            'members_count' => $members_count_arr
        );
        return $tree_structure_arr;
    }

    function get_all_count() {
        $all_members = array();
        $this->db->select('tab_1.*,tab_2.group_name,tab_3.street_name');
        $this->db->join($this->group_table . ' AS tab_2', 'tab_2.id = tab_1.family_id', 'LEFT');
        $this->db->join($this->street_table . ' AS tab_3', 'tab_3.id = tab_1.street_id', 'LEFT');
        $this->db->order_by('tab_1.id', 'DESC');
        $query = $this->db->get($this->table_name . ' AS tab_1');
        $result = $query->result_array();
        if (!empty($result)) {
            foreach ($result as $list) {
                $street_id = $list['street_id'];
                $family_id = $list['family_id'];
                $all_members[$city][$street_id][$family_id][] = $list;
            }
        }
        return $all_members;
    }

    function get_member_by_id($member_id) {
        $this->db->select('tab_1.*,tab_2.group_name,tab_3.street_name,tab_4.location');
        $this->db->join($this->group_table . ' AS tab_2', 'tab_2.id = tab_1.family_id', 'LEFT');
        $this->db->join($this->street_table . ' AS tab_3', 'tab_3.id = tab_1.street_id', 'LEFT');
        $this->db->join($this->member_location_table . ' AS tab_4', 'tab_4.user_id = tab_1.id', 'LEFT');
        $this->db->where('tab_1.id', $member_id);
        $query = $this->db->get($this->table_name . ' AS tab_1');

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    function is_user_available($username) {
        $this->db->select('tab_1.*');
        $this->db->where('LCASE(tab_1.username)', strtolower($username));
        $query = $this->db->get($this->table_name . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return 0;
    }

    function is_email_address_available($email, $id = NULL) {
        $this->db->select('tab_1.*');
        $this->db->where('LCASE(tab_1.email_address)', strtolower($email));

        $query = $this->db->get($this->table_name . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return 0;
    }

    function is_mobile_number_available($mobile) {
        $this->db->select('*');
        $this->db->where('mobile_number', $mobile);
        $query = $this->db->get($this->table_name);

        if ($query->num_rows > 0) {
            $res = $query->result_array();
            return $res;
        }

        return 0;
    }

    function get_member_by_login($username, $password) {
        $password = md5($password);
        $this->db->select('tab_1.*, tab_2.id AS user_type_id, tab_2.user_type_name');
        $this->db->join($this->user_type_table . ' AS tab_2', 'tab_2.id = tab_1.user_type_id', 'LEFT');

        $this->db->where('tab_1.password =', $password);
        $where = '(LOWER(tab_1.username) = "' . strtolower($username) . '" OR LOWER(tab_1.email_address) = "' . strtolower($username) . '")';
        $this->db->where($where);
        $this->db->where('tab_1.status', 1);
        $this->db->where('tab_1.is_deleted', 0);
        $this->db->group_by('tab_1.id');
        $query = $this->db->get($this->table_name . ' AS tab_1');

        if ($query->num_rows() == 1) {
            return $query->row();
        }
        return NULL;
    }

    public function get_user_checked_in_location($user_id) {
        $this->db->select('*');
        $this->db->where('user_id', $user_id);
        $get_user_lat_lang = $this->db->get($this->member_location_table)->result_array();
        $user_latitude = $get_user_lat_lang[0]['latitude'];
        $user_longitude = $get_user_lat_lang[0]['longitude'];
        $kayalpattinam_latitude = '11.0168';
        $kayalpattinam_longitude = '76.9558';
        if ((round($user_latitude) == round($kayalpattinam_latitude)) && (round($user_longitude) == round($kayalpattinam_longitude))) {
            return 1;
        } else {
            $distance = $this->get_distance_between_latitude_and_longitude($user_lat, $user_lang, $kayal_lat, $kayal_lang);
            if ($distance > 12) {
                return 0;
            } else {
                return 1;
            }
        }
    }

    public function get_distance_between_latitude_and_longitude($lat1, $lng1, $lat2, $lng2) {
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

    public function get_datatables($search_data) {
        $this->db->select('tab_1.*,tab_2.group_name,tab_3.street_name');
        $this->db->join($this->group_table . ' AS tab_2', 'tab_2.id = tab_1.family_id', 'LEFT');
        $this->db->join($this->street_table . ' AS tab_3', 'tab_3.id = tab_1.street_id', 'LEFT');
        $i = 0;
        foreach ($this->column_search as $item) { // loop column
            if ($search_data['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->like($item, $search_data['search']['value']);
                } else {
                    $this->db->or_like($item, $search_data['search']['value']);
                }
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }

        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get($this->table_name . ' AS tab_1');
        return $query->result();
    }

    public function count_all() {
        $this->db->from($this->primaryTable);
        return $this->db->count_all_results();
    }

    public function count_filtered($search_data) {
        $this->db->select('tab_1.*,tab_2.group_name,tab_3.street_name');
        $this->db->join($this->group_table . ' AS tab_2', 'tab_2.id = tab_1.family_id', 'LEFT');
        $this->db->join($this->street_table . ' AS tab_3', 'tab_3.id = tab_1.street_id', 'LEFT');

        $i = 0;
        foreach ($this->column_search as $item) { // loop column
            if ($search_data['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->like($item, $search_data['search']['value']);
                } else {
                    $this->db->or_like($item, $search_data['search']['value']);
                }
            }
            $i++;
        }
        $query = $this->db->get($this->table_name . ' AS tab_1');

        return $query->num_rows();
    }

    public function is_user_name_exist($user_name) {
        $this->db->select('username');
        $this->db->where('username', $user_name);
        $query = $this->db->get($this->table_name);
        if ($query->num_rows > 0) {
            $res = $query->result_array();
            return $res[0]['username'];
        }
        return NULL;
    }

    public function is_email_exist($email_address) {
        $this->db->select('email_address');
        $this->db->where('email_address', $email_address);
        $query = $this->db->get($this->table_name);
        if ($query->num_rows > 0) {
            $res = $query->result_array();
            return $res[0]['email_address'];
        }
        return NULL;
    }

    public function is_phn_no_exist($mobile_number) {
        $this->db->select('mobile_number');
        $this->db->where('mobile_number', $mobile_number);
        $query = $this->db->get($this->table_name);
        if ($query->num_rows > 0) {
            $res = $query->result_array();
            return $res[0]['mobile_number'];
        }
        return NULL;
    }

    function valid_phone_number($value) {
        $value = trim($value);
        if (preg_match('/^\(?[0-9]{3}\)?[-. ]?[0-9]{3}[-. ]?[0-9]{4}$/', $value)) {
            return preg_replace('/^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/', '($1) $2-$3', $value);
        } else {
            return FALSE;
        }
    }

    function valid_email($value) {
        if (preg_match('/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/', $value)) {
            return $value;
        } else {
            return FALSE;
        }
    }

    function check_street_name_available($street_name, $city) {
        $this->db->select('id');
        $this->db->where('street_name', $street_name);
        $this->db->where('city', $city);
        $query = $this->db->get($this->street_table);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    function check_family_name_available($family_name, $city, $street_id) {
        $this->db->select('tab_1.id');
        $this->db->where('tab_1.group_name', $family_name);
        $this->db->where('tab_1.street_id', $street_id);
        $this->db->where('tab_1.city', $city);
        $query = $this->db->get($this->group_table . ' AS tab_1');

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    function check_relation_available($relation) {
        $relation_value = array(
            'parent' => 'Parent',
            'children' => 'Children',
            'siblings' => 'Siblings',
            'relatives' => 'Relatives',
            'others' => 'Others');
        if (in_array($relation, $relation_value)) {
            return $relation;
        }
        return FALSE;
    }

    function check_onkayal_available($onkayal) {
        $onkayal_value = array(
            'temporary' => 'temporary',
            'permanent' => 'permanent',
            'out_of_kayalpattinam' => 'out_of_kayalpattinam');
        if (in_array($onkayal, $onkayal_value)) {
            return $onkayal;
        }
        return FALSE;
    }

    function get_family_by_street($street_id) {
        $this->db->select('*');
        $this->db->where('street_id', $street_id);
        $query = $this->db->get('eve_groups');

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return 0;
    }

    function get_all_groups_by_street($street_id) {
        $this->db->select('*');
        $this->db->where('street_id', $street_id);
        $query = $this->db->get('eve_groups');

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return 0;
    }

    function chk_mobile_mail_exists($email_address, $mobile_number) {
        $this->db->select('*');
        $this->db->where('email_address', $email_address);
        $this->db->where('mobile_number', $mobile_number);
        $query = $this->db->get('eve_members');

        if ($query->num_rows() > 0) {

            return $query->result_array();
        }

        return 0;
    }

    function get_member_family_id($member_id) {
        $this->db->select('tab_1.*');

        $this->db->where('tab_1.id', $member_id);
        $this->db->order_by('tab_1.id', 'DESC');
        $query = $this->db->get($this->table_name . ' AS tab_1');
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result[0]['family_id'];
        }
        return NULL;
    }

    function get_all_members_by_family($family) {
        $this->db->select('tab_1.*,tab_2.group_name,tab_3.street_name');
        $this->db->join($this->group_table . ' AS tab_2', 'tab_2.id = tab_1.family_id', 'LEFT');
        $this->db->join($this->street_table . ' AS tab_3', 'tab_3.id = tab_1.street_id', 'LEFT');
        $this->db->where('tab_1.family_id', $family);
        $this->db->order_by('tab_1.id', 'DESC');
        $query = $this->db->get($this->table_name . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    function get_all_events_by_family($family) {
        $this->db->select('tab_1.*,tab_2.group_name,tab_3.street_name,tab_4.event_type_name');
        $this->db->join($this->group_table . ' AS tab_2', 'tab_2.id = tab_1.family_types', 'LEFT');
        $this->db->join($this->street_table . ' AS tab_3', 'tab_3.id = tab_1.streets', 'LEFT');
        $this->db->join($this->event_type_table . ' AS tab_4', 'tab_4.id = tab_1.event_type_id', 'LEFT');
        $this->db->where('tab_1.family_types', $family);
        $this->db->order_by('tab_1.id', 'DESC');
        $query = $this->db->get($this->events_table . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    public function get_member_relation($user_id) {
        $this->db->select('relation');
        $this->db->where('id', $user_id);
        $query = $this->db->get($this->table_name);
        if ($query->num_rows > 0) {
            $res = $query->result_array();
            return $res[0]['relation'];
        }
        return NULL;
    }

}
