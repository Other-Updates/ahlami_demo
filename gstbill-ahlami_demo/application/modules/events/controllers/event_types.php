<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Event_types extends MX_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->user_auth->is_logged_in())
            redirect($this->config->item('base_url') . 'users/login');
        $main_module = 'events';
        $access_arr = array (
        'event_types/index' => array ('add', 'edit', 'delete', 'view'),
        'event_types/add' => array ('add'),
        'event_types/edit' => array ('edit'),
        'event_types/Z' => array ('delete'),
        'event_types/view' => array ('view'),
        'event_types/is_event_type_name_available' => array ('add', 'edit'),
        'event_types/get_event_type' => 'no_restriction',
        'event_types/get_asset_by_id' => 'no_restriction'
        );

        if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {
            redirect($this->config->item('base_url'));
        }

        $this->load->model('events/event_type_model');
        $this->template->write_view('session_msg', 'users/session_msg');
        date_default_timezone_set($this->timezone->timezone());
    }

    public function index() {
        $data = array ();
        $data['title'] = 'Events - Manage Event Types';
        $data['event_types'] = $this->event_type_model->get_all_event_types();
        $this->template->write_view('content', 'events/event_types', $data);
        $this->template->render();
    }

    public function add() {
        $data = array ();
        $data['title'] = 'Event Types - Add New Event Type';
        if ($this->input->post()) {
            $event_type_data = $this->input->post();
            $event_type_info = array (
            'event_type_name' => $event_type_data['event_type_name'],
            'form_data' => $event_type_data['form_data'],
            'status' => $event_type_data['status'],
            'created_date' => date('Y-m-d H:i:s')
            );
            $form_data = json_decode(($event_type_data['form_data']), TRUE);
            $event_type_id = $this->event_type_model->insert_event_type($event_type_info);
            if ($event_type_id) {
                $dynamic_fields = array ();
                $time = date('Y-m-d H:i:s');
                if (isset($form_data) && !empty($form_data)) {
                    foreach ($form_data as $field_data) {
                        $field_arr = array (
                        'event_type_id' => $event_type_id,
                        'field_name' => $field_data['name'],
                        'field_type' => $field_data['type'],
                        'field_label' => $field_data['label'],
                        'field_data' => json_encode($field_data),
                        'created_date' => $time
                        );
                        $dynamic_fields[] = $field_arr;
                    }
                }
                if (!empty($dynamic_fields)) {
                    $this->db->insert_batch('eve_event_type_dynamic_fields', $dynamic_fields);
                }

                $this->session->set_flashdata('flashSuccess', 'New Event Type successfully added!');
                echo 'success';
                //redirect($this->config->item('base_url') . 'events/events_types');
            } else {
                $this->session->set_flashdata('flashError', 'Event Type not added! Please try again.');
                echo 'error';
                //redirect($this->config->item('base_url') . 'events/events_types');
            }
        }
        $this->template->write_view('content', 'events/add_event_type', $data);
        $this->template->render();
    }

    public function edit($id) {
        $data = array ();
        $data['title'] = 'Event Types - Edit Event Type';
        if ($this->input->post()) {
            $event_type_data = $this->input->post();
            $event_type_info = array (
            'event_type_name' => $event_type_data['event_type_name'],
            'form_data' => $event_type_data['form_data'],
            'status' => $event_type_data['status'],
            'updated_date' => date('Y-m-d H:i:s')
            );
            $form_data = json_decode(($event_type_data['form_data']), TRUE);

            $update = $this->event_type_model->update_event_type($event_type_info, $id);
            if ($update) {
                //$this->event_type_model->delete_dynamic_fields($id);
                $dynamic_fields = array ();
                $time = date('Y-m-d H:i:s');
                if (isset($form_data) && !empty($form_data)) {
                    foreach ($form_data as $field_data) {
                        $field_arr = array (
                        'event_type_id' => $id,
                        'field_name' => $field_data['name'],
                        'field_type' => $field_data['type'],
                        'field_label' => $field_data['label'],
                        'field_data' => json_encode($field_data),
                        'created_date' => $time,
                        'updated_date' => $time
                        );
                        $dynamic_fields[] = $field_arr;
                    }
                }
                if (!empty($dynamic_fields)) {
                    $this->event_type_model->update_dynamic_fields($dynamic_fields);
                }
                $this->session->set_flashdata('flashSuccess', 'Event Type successfully updated!');
                echo 'success';
            } else {
                $this->session->set_flashdata('flashError', 'Event Type not updated! Please try again.');
                echo 'error';
            }
        }
        $data['event_type'] = $this->event_type_model->get_event_type_by_id($id);

        $this->template->write_view('content', 'events/edit_event_type', $data);
        $this->template->render();
    }

    public function delete() {
        $id = $this->input->post('id');
        $delete = $this->event_type_model->delete_event_type($id);
        if ($delete) {
            $this->session->set_flashdata('flashSuccess', 'Event Type successfully deleted!');
            echo '1';
        } else {
            $this->session->set_flashdata('flashError', 'Operation Failed!');
            echo '0';
        }
    }

    function is_event_type_name_available() {
        $event_type_name = $this->input->post('event_type_name');
        $id = $this->input->post('id');
        $result = $this->event_type_model->is_event_type_name_available($event_type_name, $id);
        if (!empty($result[0]['id'])) {
            echo 'yes';
        } else {
            echo 'no';
        }
    }

    function get_event_type() {
        $result = $this->event_type_model->get_all_event_types();
        echo json_encode($result);
    }

    function get_asset_by_id($id) {
        $result['asset_type'] = $this->event_type_model->get_asset_by_id($id);
        $result['form_fields'] = $this->event_type_model->get_form_fields($id);
        echo json_encode($result);
    }

}
