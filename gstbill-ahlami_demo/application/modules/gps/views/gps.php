<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class gps extends MX_Controller {


    function __construct() {
        parent::__construct();
        $this->load->model('gps/gps_model');
        if (!$this->user_auth->is_logged_in()) {
            redirect($this->config->item('base_url') . 'users/login');
        }
    }

    function index(){
        $data=array();
        $data['locked'] = $this->gps_model->get_scootero_by_lock();
        $data['unlocked'] = $this->gps_model->get_scootero_by_unlock(); 
        $data['timestamp'] = $this->gps_model->get_scootero_time();
        $this->template->write_view('content', 'gps/gps_tracking',$data);
        $this->template->render();
    }

    function marker(){
        $data=array();
        $data['locked'] = $this->gps_model->get_scootero_by_lock();
        $data['unlocked'] = $this->gps_model->get_scootero_by_unlock(); 
        $data['timestamp'] = $this->gps_model->get_scootero_time();
        print_r($data);
        exit;
        echo json_encode(array_merge($data['locked'],$data['unlocked'], $data['timestamp']));
    }
}
