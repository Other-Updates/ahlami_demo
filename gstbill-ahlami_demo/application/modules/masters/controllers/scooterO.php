<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ScooterO extends MX_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->user_auth->is_logged_in())
            redirect($this->config->item('base_url') . 'users/login');
        $main_module = 'masters';
        $access_arr = array(
            'scooterO/index' => array('add', 'edit', 'delete'),
            'scooterO/add' => array('add'),
            'scooterO/edit' => array('edit'),
            'scooterO/delete' => array('delete'),
            'scooterO/is_scooterO_available' => array('add', 'edit')
        );
        $data = $this->user_auth->is_permission_allowed($access_arr, $main_module);
        if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {
            redirect($this->config->item('base_url'));
        }
        $this->load->model('masters/scootero_model');
        $this->load->model('api/increment_model');
        $this->load->model('masters/setting_model');
    }

    public function index() {
        $data = array();
        $data['title'] = 'ScooterO - Manage ScooterO';
        $data['scooterO'] = $this->scootero_model->get_all_scooterO();
        $this->template->write_view('content', 'masters/list_scooterO', $data);
        $this->template->render();
    }

    public function add() {
        $data = array();
        $data['title'] = 'ScooterO - Add New ScooterO';
        if ($this->input->post('user_type')) {
            $scooterO = $this->input->post('scooterO');
            $scooterO['created_at']=date('Y-m-d H:i:s');
            $scootero_id = $this->scootero_model->insert_scooterO($scooterO);

            //Scootero Position Updates
            $insert_data['scootero_id']=$scootero_id;
            $insert_data['scoo_lat']=$scooterO['scoo_lat'];
            $insert_data['scoo_long']=$scooterO['scoo_long'];
            $insert_data['updated_by']=$this->user_auth->get_user_id();
            $insert_data['is_current_position']=1;
            $insert_data['created_date']=date('Y-m-d h:i:s');
            $this->scootero_model->insert_scooterO_history($insert_data);

            $this->increment_model->update_increment_code('scootero_serial_number_code');
            $this->session->set_flashdata('flashSuccess', 'ScooterO Added');
            redirect($this->config->item('base_url') . 'masters/scooterO');
        }
        $data['serial_number'] = $this->increment_model->get_increment_code('scootero_serial_number_code');
        $data['setting'] = $this->setting_model->get_all_setting();
        $this->template->write_view('content', 'masters/add_scooterO', $data);
        $this->template->render();
    }

    public function edit($id) {
        $data = array();
        $data['title'] = 'ScooterO - Edit ScooterO';
        $post_data = $this->input->post();
        if ($this->input->post('scooterO')) {
            $scooterO = $this->input->post('scooterO');
            $scooterO['updated_at']=date('Y-m-d H:i:s');
            $update = $this->scootero_model->update_scooterO($scooterO, $id);
            if(($post_data['old_scoo_lat'] != $scooterO['scoo_lat']) || ($post_data['old_scoo_long'] != $scooterO['scoo_long']) ){
                 //Scootero Position Updates
                $insert_data['scootero_id']=$id;
                $insert_data['scoo_lat']=$scooterO['scoo_lat'];
                $insert_data['scoo_long']=$scooterO['scoo_long'];
                $insert_data['updated_by']=$this->user_auth->get_user_id();
                $insert_data['is_current_position']=1;
                $insert_data['created_date']=date('Y-m-d h:i:s');
                $this->scootero_model->insert_scooterO_history($insert_data);
            }
            $this->session->set_flashdata('flashSuccess', 'ScooterO Updated');
            redirect($this->config->item('base_url') . 'masters/scooterO');
        }
        $data['scooterO'] = $this->scootero_model->get_scooterO_by_id($id);
        $this->template->write_view('content', 'masters/edit_scooterO', $data);
        $this->template->render();
    }

    function delete($id) {
        $id = $this->input->post('id');

        $data = array('is_deleted' => 1);
        $delete = $this->scootero_model->update_scooterO($data,$id);

        if ($delete == 1) {
            $this->session->set_flashdata('flashSuccess', 'ScooterO successfully deleted!');
            echo 1;exit;
        } else {
            $this->session->set_flashdata('flashError', 'Operation Failed!');
            exit;
        }
    }

}
