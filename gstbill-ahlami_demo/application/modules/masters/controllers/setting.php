<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Setting extends MX_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->user_auth->is_logged_in()) {
            redirect($this->config->item('base_url') . 'users/login');
        }
        $main_module = 'masters';
        $access_arr = array (
        'setting/index' => array ('add', 'edit', 'delete', 'view'),
        'setting/add' => array ('add'),
        'setting/edit' => array ('edit'),
        'setting/delete' => array ('delete'),
        'setting/is_street_name_available' => array ('add', 'edit')
        );

        if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {
            redirect($this->config->item('base_url'));
        }

        $this->load->model('masters/setting_model');
        $this->template->write_view('session_msg', 'users/session_msg');
        date_default_timezone_set($this->timezone->timezone());
    }

    function index() {
        $data = array ();
        $data['title'] = 'Masters - General Settings';
        $data['setting'] = $this->setting_model->get_all_setting();
        $this->template->write_view('content', 'masters/setting', $data);
        $this->template->render();
    }

    function edit($id) {
        $data = array ();
        $data['title'] = 'Masters - Edit Setting';

        if ($this->input->post('setting', TRUE)) {


            $setting = $this->input->post('setting');
            $setting['updated_date'] = date('Y-m-d H:i:s');
            $location['latitude']=$this->input->post('latitude');
            $location['longitude']=$this->input->post('longitude');
            $setting['current_location']= serialize($location);
            $update = $this->setting_model->update_setting($setting, $id);
            $this->session->set_flashdata('flashSuccess', 'Setting successfully updated!');
            redirect($this->config->item('base_url') . 'masters/setting');
        }
        $data['street'] = $this->street_model->get_street_by_id($id);

        $this->template->write_view('content', 'masters/setting', $data);
        $this->template->render();
    }

}
