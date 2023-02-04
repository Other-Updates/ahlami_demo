<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Users_model extends CI_Model {

    private $table_name = 'scoo_users';
    private $customers = 'scoo_customers';
    private $user_type_table = 'scoo_user_types';

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insert_user($data) {
        if ($this->db->insert($this->table_name, $data)) {
            $user_id = $this->db->insert_id();
            return $user_id;
        }
        return FALSE;
    }

    function update_user($data, $user_id) {
        $this->db->where('id', $user_id);
        if ($this->db->update($this->table_name, $data)) {
            return TRUE;
        }
        return FALSE;
    }

    function delete_user($id) {
        $this->db->where('id', $id);
        if ($this->db->delete($this->table_name)) {
            return 1;
        }
        return 0;
    }

    function reset_password($user, $user_id) {
        $id = base64_decode(urldecode($user_id));
        $this->db->where('id', $id);
        if ($this->db->update($this->table_name, $user)) {
            return TRUE;
        }
        return FALSE;
    }

    function get_all_users() {
        $this->db->select('tab_1.*, tab_2.id AS user_type_id, tab_2.user_type_name');
        $this->db->join($this->user_type_table . ' AS tab_2', 'tab_2.id = tab_1.user_type_id', 'LEFT');
        $query = $this->db->get($this->table_name . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    function get_users_by_user_type_and_shop($user_type_id, $shop_id) {
        $this->db->select('tab_1.*, tab_2.id AS user_type_id, tab_2.user_type_name');
        $this->db->join($this->user_type_table . ' AS tab_2', 'tab_2.id = tab_1.user_type_id', 'LEFT');
        $this->db->where('tab_1.user_type_id', $user_type_id);
        $this->db->where('tab_1.status', 1);
        $this->db->where('tab_1.is_deleted', 0);
        if (!$this->user_auth->is_admin()) {
            $this->db->where('tab_1.shop_id', $shop_id);
        }
        $query = $this->db->get($this->table_name . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    function get_users_by_user_type($user_type_id) {
        $this->db->select('tab_1.*, tab_2.id AS user_type_id, tab_2.user_type_name, tab_3.shop_name AS branch_name');
        $this->db->join($this->user_type_table . ' AS tab_2', 'tab_2.id = tab_1.user_type_id', 'LEFT');
        $this->db->where('tab_1.user_type_id', $user_type_id);
        $query = $this->db->get($this->table_name . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    function get_username_by_id($user_id) {
        $this->db->select('CONCAT_WS(" ", firstname, lastname) AS name', FALSE);
        $this->db->where('tab_1.id', $user_id);
        $query = $this->db->get($this->table_name . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    function get_user_by_id($user_id) {
        $this->db->select('tab_1.*, tab_2.id AS user_type_id, tab_2.user_type_name');
        $this->db->join($this->user_type_table . ' AS tab_2', 'tab_2.id = tab_1.user_type_id', 'LEFT');

        $this->db->where('tab_1.id', $user_id);
        $query = $this->db->get($this->table_name . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    function is_user_available($username, $id = NULL) {
        $this->db->select($this->table_name . '.id');
        $this->db->where('LCASE(username)', strtolower($username));
        if (!empty($id))
            $this->db->where('id !=', $id);
        $query = $this->db->get($this->table_name);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    function is_email_address_available($email, $id = NULL) {
        $this->db->select($this->table_name . '.id');
        $this->db->where('LCASE(email_address)', strtolower($email));
        if (!empty($id))
            $this->db->where('id !=', $id);
        $query = $this->db->get($this->table_name);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    function is_mobile_number_available($mobile, $id = NULL) {
        $this->db->select($this->table_name . '.id');
        $this->db->where('LCASE(mobile_number)', strtolower($mobile));
        if (!empty($id))
            $this->db->where('id !=', $id);
        $query = $this->db->get($this->table_name);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    function get_user_by_login($username, $password) {
        $password = md5($password);
        $this->db->select('tab_1.*, tab_2.id AS user_type_id, tab_2.user_type_name');
        $this->db->join($this->user_type_table . ' AS tab_2', 'tab_2.id = tab_1.user_type_id', 'LEFT');
        $this->db->where('password = ', $password);
        $where = '(LOWER(username) = "' . strtolower($username) . '" OR LOWER(tab_1.email_address) = "' . strtolower($username) . '")';
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

    function get_increment_id() {
        $this->db->select($this->increment_table . '.*');
        $query = $this->db->get($this->increment_table);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    function update_increment_table($data) {
        if ($this->db->update($this->increment_table, $data)) {
            return TRUE;
        }
        return FALSE;
    }

    function getAllTimeZones() {
        $timezones = array(
            'Pacific/Midway' => "(GMT-11:00) Midway Island",
            'US/Samoa' => "(GMT-11:00) Samoa",
            'US/Hawaii' => "(GMT-10:00) Hawaii",
            'US/Alaska' => "(GMT-09:00) Alaska",
            'US/Pacific' => "(GMT-08:00) Pacific Time (US &amp; Canada)",
            'America/Tijuana' => "(GMT-08:00) Tijuana",
            'US/Arizona' => "(GMT-07:00) Arizona",
            'US/Mountain' => "(GMT-07:00) Mountain Time (US &amp; Canada)",
            'America/Chihuahua' => "(GMT-07:00) Chihuahua",
            'America/Mazatlan' => "(GMT-07:00) Mazatlan",
            'America/Mexico_City' => "(GMT-06:00) Mexico City",
            'America/Monterrey' => "(GMT-06:00) Monterrey",
            'Canada/Saskatchewan' => "(GMT-06:00) Saskatchewan",
            'US/Central' => "(GMT-06:00) Central Time (US &amp; Canada)",
            'US/Eastern' => "(GMT-05:00) Eastern Time (US &amp; Canada)",
            'US/East-Indiana' => "(GMT-05:00) Indiana (East)",
            'America/Bogota' => "(GMT-05:00) Bogota",
            'America/Lima' => "(GMT-05:00) Lima",
            'America/Caracas' => "(GMT-04:30) Caracas",
            'Canada/Atlantic' => "(GMT-04:00) Atlantic Time (Canada)",
            'America/La_Paz' => "(GMT-04:00) La Paz",
            'America/Santiago' => "(GMT-04:00) Santiago",
            'Canada/Newfoundland' => "(GMT-03:30) Newfoundland",
            'America/Buenos_Aires' => "(GMT-03:00) Buenos Aires",
            'Greenland' => "(GMT-03:00) Greenland",
            'Atlantic/Stanley' => "(GMT-02:00) Stanley",
            'Atlantic/Azores' => "(GMT-01:00) Azores",
            'Atlantic/Cape_Verde' => "(GMT-01:00) Cape Verde Is.",
            'Africa/Casablanca' => "(GMT) Casablanca",
            'Europe/Dublin' => "(GMT) Dublin",
            'Europe/Lisbon' => "(GMT) Lisbon",
            'Europe/London' => "(GMT) London",
            'Africa/Monrovia' => "(GMT) Monrovia",
            'Europe/Amsterdam' => "(GMT+01:00) Amsterdam",
            'Europe/Belgrade' => "(GMT+01:00) Belgrade",
            'Europe/Berlin' => "(GMT+01:00) Berlin",
            'Europe/Bratislava' => "(GMT+01:00) Bratislava",
            'Europe/Brussels' => "(GMT+01:00) Brussels",
            'Europe/Budapest' => "(GMT+01:00) Budapest",
            'Europe/Copenhagen' => "(GMT+01:00) Copenhagen",
            'Europe/Ljubljana' => "(GMT+01:00) Ljubljana",
            'Europe/Madrid' => "(GMT+01:00) Madrid",
            'Europe/Paris' => "(GMT+01:00) Paris",
            'Europe/Prague' => "(GMT+01:00) Prague",
            'Europe/Rome' => "(GMT+01:00) Rome",
            'Europe/Sarajevo' => "(GMT+01:00) Sarajevo",
            'Europe/Skopje' => "(GMT+01:00) Skopje",
            'Europe/Stockholm' => "(GMT+01:00) Stockholm",
            'Europe/Vienna' => "(GMT+01:00) Vienna",
            'Europe/Warsaw' => "(GMT+01:00) Warsaw",
            'Europe/Zagreb' => "(GMT+01:00) Zagreb",
            'Europe/Athens' => "(GMT+02:00) Athens",
            'Europe/Bucharest' => "(GMT+02:00) Bucharest",
            'Africa/Cairo' => "(GMT+02:00) Cairo",
            'Africa/Harare' => "(GMT+02:00) Harare",
            'Europe/Helsinki' => "(GMT+02:00) Helsinki",
            'Europe/Istanbul' => "(GMT+02:00) Istanbul",
            'Asia/Jerusalem' => "(GMT+02:00) Jerusalem",
            'Europe/Kiev' => "(GMT+02:00) Kyiv",
            'Europe/Minsk' => "(GMT+02:00) Minsk",
            'Europe/Riga' => "(GMT+02:00) Riga",
            'Europe/Sofia' => "(GMT+02:00) Sofia",
            'Europe/Tallinn' => "(GMT+02:00) Tallinn",
            'Europe/Vilnius' => "(GMT+02:00) Vilnius",
            'Asia/Baghdad' => "(GMT+03:00) Baghdad",
            'Asia/Kuwait' => "(GMT+03:00) Kuwait",
            'Africa/Nairobi' => "(GMT+03:00) Nairobi",
            'Asia/Riyadh' => "(GMT+03:00) Riyadh",
            'Europe/Moscow' => "(GMT+03:00) Moscow",
            'Asia/Tehran' => "(GMT+03:30) Tehran",
            'Asia/Baku' => "(GMT+04:00) Baku",
            'Europe/Volgograd' => "(GMT+04:00) Volgograd",
            'Asia/Muscat' => "(GMT+04:00) Muscat",
            'Asia/Tbilisi' => "(GMT+04:00) Tbilisi",
            'Asia/Yerevan' => "(GMT+04:00) Yerevan",
            'Asia/Kabul' => "(GMT+04:30) Kabul",
            'Asia/Karachi' => "(GMT+05:00) Karachi",
            'Asia/Tashkent' => "(GMT+05:00) Tashkent",
            'Asia/Kolkata' => "(GMT+05:30) Kolkata",
            'Asia/Kathmandu' => "(GMT+05:45) Kathmandu",
            'Asia/Yekaterinburg' => "(GMT+06:00) Ekaterinburg",
            'Asia/Almaty' => "(GMT+06:00) Almaty",
            'Asia/Dhaka' => "(GMT+06:00) Dhaka",
            'Asia/Novosibirsk' => "(GMT+07:00) Novosibirsk",
            'Asia/Bangkok' => "(GMT+07:00) Bangkok",
            'Asia/Jakarta' => "(GMT+07:00) Jakarta",
            'Asia/Krasnoyarsk' => "(GMT+08:00) Krasnoyarsk",
            'Asia/Chongqing' => "(GMT+08:00) Chongqing",
            'Asia/Hong_Kong' => "(GMT+08:00) Hong Kong",
            'Asia/Kuala_Lumpur' => "(GMT+08:00) Kuala Lumpur",
            'Australia/Perth' => "(GMT+08:00) Perth",
            'Asia/Singapore' => "(GMT+08:00) Singapore",
            'Asia/Taipei' => "(GMT+08:00) Taipei",
            'Asia/Ulaanbaatar' => "(GMT+08:00) Ulaan Bataar",
            'Asia/Urumqi' => "(GMT+08:00) Urumqi",
            'Asia/Irkutsk' => "(GMT+09:00) Irkutsk",
            'Asia/Seoul' => "(GMT+09:00) Seoul",
            'Asia/Tokyo' => "(GMT+09:00) Tokyo",
            'Australia/Adelaide' => "(GMT+09:30) Adelaide",
            'Australia/Darwin' => "(GMT+09:30) Darwin",
            'Asia/Yakutsk' => "(GMT+10:00) Yakutsk",
            'Australia/Brisbane' => "(GMT+10:00) Brisbane",
            'Australia/Canberra' => "(GMT+10:00) Canberra",
            'Pacific/Guam' => "(GMT+10:00) Guam",
            'Australia/Hobart' => "(GMT+10:00) Hobart",
            'Australia/Melbourne' => "(GMT+10:00) Melbourne",
            'Pacific/Port_Moresby' => "(GMT+10:00) Port Moresby",
            'Australia/Sydney' => "(GMT+10:00) Sydney",
            'Asia/Vladivostok' => "(GMT+11:00) Vladivostok",
            'Asia/Magadan' => "(GMT+12:00) Magadan",
            'Pacific/Auckland' => "(GMT+12:00) Auckland",
            'Pacific/Fiji' => "(GMT+12:00) Fiji",
        );
        return $timezones;
    }

    function check_customer_code($id=NULL,$mobile_number=NULL,$confirmation_code=NULL,$email=NULL){
        $this->db->select('c.*');
        if($id != NULL){
            $this->db->where('c.id',$id);
        }
        if($mobile_number != NULL){
            $this->db->where('c.mobile_number',$mobile_number);
        }
        if($email != NULL){
            $this->db->where('c.email',$email);
        }
        if($confirmation_code != NULL){
            $this->db->where('c.confirmation_code',$confirmation_code);
        }
        $query = $this->db->get($this->customers.' As c')->row_array();
        if(!empty($query)){
            return $query;
        }else{
            return false;
        }
    }
    function update_customer($data, $user_id) {
        $this->db->where('id', $user_id);
        if ($this->db->update($this->customers, $data)) {
            return TRUE;
        }
        return FALSE;
    }

}
