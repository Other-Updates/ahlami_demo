<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Events extends MX_Controller {

    function __construct() {
        parent::__construct();
        if (!in_array($this->router->method, array ('login', 'logout'))) {
            if (!$this->user_auth->is_logged_in()) {
                redirect($this->config->item('base_url') . 'users/login');
            }
        }

        $main_module = 'events';
        $access_arr = array (
        'events/index' => array ('add', 'edit', 'delete', 'view'),
        'events/add' => array ('add'),
        'events/edit' => array ('edit'),
        'events/view' => array ('view'),
        'events/delete' => array ('delete'),
        'events/delete_invitation' => 'no_restriction',
        'events/delete_dynamic_field_attachment' => 'no_restriction',
        'events/event_invitation_mail' => 'no_restriction',
        'events/generate_form_by_event_type' => 'no_restriction',
        'events/today_events' => 'no_restriction',
        'events/accept_members' => 'no_restriction',
        'events/reject_members' => 'no_restriction',
        'events/invited_members' => 'no_restriction',
        'events/events_ajaxList' => 'no_restriction',
        );

        if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {
            redirect($this->config->item('base_url') . 'dashboard');
        }

        $this->load->model('members/event_model');
        $this->load->model('events/event_type_model');
        $this->load->model('members/group_model');
        $this->load->model('members/members_model');
        $this->load->model('masters/street_model');
        $this->load->model('api/increment_model');
        $this->template->set_master_template('../../themes/event/member_template.php');
        $this->template->write_view('session_msg', 'users/session_msg');
        date_default_timezone_set($this->timezone->timezone());
    }

    function index() {
        $data = array ();
        $data['title'] = 'Events - Manage Events';
//        $user_id = $this->user_auth->get_user_id();
//        $family = $this->members_model->get_member_family_id($user_id);
////        $data['events'] = $this->members_model->get_all_events_by_family($family);
//        $data['events'] = $this->event_model->get_all_member_events($user_id);
//
        $this->template->write_view('content', 'members/events', $data);
        $this->template->render();
    }

    function add() {
        $data = array ();
        $image_path = '';
        $data['title'] = 'Events - Add New Event';
        $user_id = $this->user_auth->get_user_id();

        if ($this->input->post()) {
            $event = $this->input->post('event');
            $event_members = $this->input->post('event_member');
            $dynamic = $this->input->post('dynamic');
            $from_date = explode(' ', $event['from_date']);
            $date = explode('/', $from_date[0]);
            $time = $from_date[1];
            $from_date = $date[2] . '-' . $date[1] . '-' . $date[0];
            $from_date_time = $from_date . ' ' . $time . ':00';
            $to_date = explode(' ', $event['to_date']);
            $date = explode('/', $to_date[0]);
            $time = $to_date[1];
            $to_date = $date[2] . '-' . $date[1] . '-' . $date[0];
            $to_date_time = $to_date . ' ' . $time . ':00';
            $event['from_date'] = $from_date_time;
            $event['to_date'] = $to_date_time;
            $event['user_id'] = $user_id;
            //$family_types = $event['family_types'];
            //$streets = $event['streets'];
            //$event['family_types'] = implode(',', $event['family_types']);
            //$event['streets'] = implode(',', $event['streets']);
            //$event['sent_event_to_all_members'] = ($event['sent_event_to_all_members'] == 1) ? $event['sent_event_to_all_members'] : 0;
            $event['user_id'] = $this->user_auth->get_from_session('user_id');
            $event['created_date'] = date('Y-m-d H:i:s');
            $event['approved_status'] = 2;
            // Get Invited Members List
            $invited_members_arr = array ();
            if (!empty($event_members)) {
                foreach ($event_members as $city_id => $streets) {
                    if (!empty($streets)) {
                        foreach ($streets as $street_id => $groups) {
                            if (!empty($groups)) {
                                foreach ($groups as $group_id => $members) {
                                    if (!empty($members)) {
                                        foreach ($members as $list) {
                                            $invited_members_arr[] = $list;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            $invited_members = array ();
            if (!empty($invited_members_arr)) {
                $members_list = $this->members_model->get_members_by_list($invited_members_arr);
                if (!empty($members_list)) {
                    foreach ($members_list as $list) {
                        $invited_members[$list['id']] = $list['email_address'];
                    }
                }
            }

            /* $family_members_1 = $this->event_model->get_family_members_by_family_type($family_types);
              $family_members_2 = $this->event_model->get_family_members_by_street($streets);
              if ($event['sent_event_to_all_members'] == 1) {
              $family_members_3 = $this->event_model->get_local_members($from_date_time, $to_date_time);
              }
              $invited_members = array();
              if (!empty($family_members_1)) {
              foreach ($family_members_1 as $list) {
              $invited_members[$list['id']] = $list['email_address'];
              }
              }
              if (!empty($family_members_2)) {
              foreach ($family_members_2 as $list) {
              $invited_members[$list['id']] = $list['email_address'];
              }
              }
              if ($event['sent_event_to_all_members'] == 1) {
              if (!empty($family_members_3)) {
              foreach ($family_members_3 as $list) {
              $invited_members[$list['id']] = $list['email_address'];
              }
              }
              } */

            $event_id = $this->event_model->insert_event($event);
            if ($event_id) {
                $invited_members = array_filter($invited_members);
                $invited_members_list = array_keys($invited_members);
                $invited_members_json = json_encode($invited_members_list);
                $invited_members_arr = array (
                'event_id' => $event_id,
                'total_invited_members' => count($invited_members),
                'invited_members' => $invited_members_json,
                'created_date' => date('Y-m-d H:i:s')
                );
                $this->event_model->insert_event_invited_members($invited_members_arr);


                if (!empty($_FILES['dynamic']['name'])) {
                    foreach ($_FILES['dynamic']['name'] as $dynamic_id => $dynamic_value) {
                        $_FILES['dynamic_file']['name'] = $_FILES['dynamic']['name'][$dynamic_id];
                        $_FILES['dynamic_file']['type'] = $_FILES['dynamic']['type'][$dynamic_id];
                        $_FILES['dynamic_file']['tmp_name'] = $_FILES['dynamic']['tmp_name'][$dynamic_id];
                        $_FILES['dynamic_file']['error'] = $_FILES['dynamic']['error'][$dynamic_id];
                        $_FILES['dynamic_file']['size'] = $_FILES['dynamic']['size'][$dynamic_id];
                        $uploadPath = 'attachments/events/dynamic_images/';
                        $config['upload_path'] = $uploadPath;
                        $config['allowed_types'] = 'jpg|jpeg|png|gif';
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if ($this->upload->do_upload('dynamic_file')) {
                            $fileData = $this->upload->data();
                            $new_file_name = $_FILES['dynamic']['name'][$dynamic_id];
                            $insert_image_data = array (
                            'field_id' => $dynamic_id,
                            'value' => $new_file_name,
                            'event_id' => $event_id,
                            'event_type_id' => $event['event_type_id']
                            );
                            $this->db->insert('eve_event_dynamic_values', $insert_image_data);
                        }
                    }
                }

                $eventDynamicArray = array ();
                if (isset($dynamic) && !empty($dynamic)) {
                    $i = 0;
                    foreach ($dynamic as $key => $val) {
                        $dynamic_val = (is_array($val)) ? implode(',', $val) : $val;
                        $eventDynamicArray[$i]['field_id'] = $key;
                        $eventDynamicArray[$i]['value'] = $dynamic_val;
                        $eventDynamicArray[$i]['event_id'] = $event_id;
                        $eventDynamicArray[$i]['event_type_id'] = $event['event_type_id'];
                        $i++;
                    }
                    $dynamic = $this->event_model->insert_dynamic_field_values($eventDynamicArray);
                }

                $invitationData = array ();
                if (!empty($_FILES['invitation_image']['name'])) {
                    $_FILES['file']['name'] = $_FILES['invitation_image']['name'];
                    $_FILES['file']['type'] = $_FILES['invitation_image']['type'];
                    $_FILES['file']['tmp_name'] = $_FILES['invitation_image']['tmp_name'];
                    $_FILES['file']['error'] = $_FILES['invitation_image']['error'];
                    $_FILES['file']['size'] = $_FILES['invitation_image']['size'];
                    $uploadPath = 'attachments/events/invitations/';
                    $config['upload_path'] = $uploadPath;
                    $config['allowed_types'] = 'jpg|jpeg|png|gif';
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        $fileData = $this->upload->data();
                        $uploadData = array (
                        'file_name' => $fileData['file_name'],
                        'event_id' => $event_id,
                        'img_path' => base_url() . $uploadPath . '' . $fileData['file_name']
                        );
                        $invitationData[] = $uploadData;
                    }
                }

                if (!empty($invitationData)) {
                    $insert = $this->event_model->insert_event_invitations($invitationData);
                }
                $this->event_invitation_mail($event_id, $invited_members);
                $this->session->set_flashdata('flashSuccess', 'New Event successfully created!');
                redirect($this->config->item('base_url') . 'members/events');
            } else {
                $this->session->set_flashdata('flashError', 'Event not created! Please try again.');
                redirect($this->config->item('base_url') . 'members/events');
            }
        }
        $data['streets'] = $streets = $this->street_model->get_all_streets();
        $streets_list = array ();
        if (!empty($streets)) {
            foreach ($streets as $list) {
                $streets_list[$list['id']] = $list;
            }
        }
        $data['streets_arr'] = $streets_list;
        $data['groups'] = $groups = $this->group_model->get_all_groups();
        $groups_list = array ();
        if (!empty($groups)) {
            foreach ($groups as $list) {
                $groups_list[$list['id']] = $list;
            }
        }
        $data['groups_arr'] = $groups_list;
        $data['event_types'] = $this->event_type_model->get_all_event_types();
        $tree_structure = $this->members_model->get_all_members_tree_structure();
        $data['members_tree'] = (isset($tree_structure['all_members'])) ? $tree_structure['all_members'] : array ();
        $data['members_count'] = (isset($tree_structure['members_count'])) ? $tree_structure['members_count'] : array ();

        $this->template->write_view('content', 'members/add_event', $data);
        $this->template->render();
    }

//    function edit($id) {
//
//        $data = array ();
//        $data['title'] = 'Events - Edit Event';
//        $user_id = $this->user_auth->get_user_id();
//        if ($this->input->post()) {
//            $event = $this->input->post('event');
//            $event_members = $this->input->post('event_member');
//            $dynamic = $this->input->post('dynamic');
//            $from_date = explode(' ', $event['from_date']);
//            $date = explode('/', $from_date[0]);
//            $time = $from_date[1];
//            $from_date = $date[2] . '-' . $date[1] . '-' . $date[0];
//            $from_date_time = $from_date . ' ' . $time . ':00';
//            $to_date = explode(' ', $event['to_date']);
//            $date = explode('/', $to_date[0]);
//            $time = $to_date[1];
//            $to_date = $date[2] . '-' . $date[1] . '-' . $date[0];
//            $to_date_time = $to_date . ' ' . $time . ':00';
//            $event['from_date'] = $from_date_time;
//            $event['to_date'] = $to_date_time;
//            $event['user_id'] = $user_id;
//            $event['approved_status'] = 2;
//
//
//            //$family_types = $event['family_types'];
//            //$streets = $event['streets'];
//            //$event['family_types'] = implode(',', $event['family_types']);
//            //$event['streets'] = implode(',', $event['streets']);
//            //$event['sent_event_to_all_members'] = ($event['sent_event_to_all_members'] == 1) ? $event['sent_event_to_all_members'] : 0;
//            $event['updated_date'] = date('Y-m-d H:i:s');
//
//            // Get Invited Members List
//            $invited_members_arr = array ();
//            if (!empty($event_members)) {
//                foreach ($event_members as $city_id => $streets) {
//                    if (!empty($streets)) {
//                        foreach ($streets as $street_id => $groups) {
//                            if (!empty($groups)) {
//                                foreach ($groups as $group_id => $members) {
//                                    if (!empty($members)) {
//                                        foreach ($members as $list) {
//                                            $invited_members_arr[] = $list;
//                                        }
//                                    }
//                                }
//                            }
//                        }
//                    }
//                }
//            }
//            $invited_members = array ();
//            if (!empty($invited_members_arr)) {
//                $members_list = $this->members_model->get_members_by_list($invited_members_arr);
//                if (!empty($members_list)) {
//                    foreach ($members_list as $list) {
//                        $invited_members[$list['id']] = $list['email_address'];
//                    }
//                }
//            }
//
//            /* $family_members_1 = $this->event_model->get_family_members_by_family_type($family_types);
//              $family_members_2 = $this->event_model->get_family_members_by_street($streets);
//              if ($event['sent_event_to_all_members'] == 1) {
//              $family_members_3 = $this->event_model->get_local_members($from_date_time, $to_date_time);
//              }
//              $invited_members = array();
//              if (!empty($family_members_1)) {
//              foreach ($family_members_1 as $list) {
//              $invited_members[$list['id']] = $list['email_address'];
//              }
//              }
//              if (!empty($family_members_2)) {
//              foreach ($family_members_2 as $list) {
//              $invited_members[$list['id']] = $list['email_address'];
//              }
//              }
//              if ($event['sent_event_to_all_members'] == 1) {
//              if (!empty($family_members_3)) {
//              foreach ($family_members_3 as $list) {
//              $invited_members[$list['id']] = $list['email_address'];
//              }
//              }
//              } */
//
//            $update = $this->event_model->update_event($event, $id);
//            if ($update) {
//                $invited_members = array_filter($invited_members);
//                $invited_members_list = array_keys($invited_members);
//                $invited_members_json = json_encode($invited_members_list);
//                $invited_members_arr = array (
//                'event_id' => $id,
//                'total_invited_members' => count($invited_members),
//                'invited_members' => $invited_members_json,
//                'updated_date' => date('Y-m-d H:i:s')
//                );
//                $this->event_model->update_event_invited_members($invited_members_arr, $id);
//                //$this->event_invitation_mail($id, $invited_members);
//
//                $eventDynamicFileArray = array ();
//                if (!empty($_FILES['dynamic']['name'])) {
//                    foreach ($_FILES['dynamic']['name'] as $dynamic_id => $dynamic_value) {
//                        $_FILES['dynamic_file']['name'] = $_FILES['dynamic']['name'][$dynamic_id];
//                        $_FILES['dynamic_file']['type'] = $_FILES['dynamic']['type'][$dynamic_id];
//                        $_FILES['dynamic_file']['tmp_name'] = $_FILES['dynamic']['tmp_name'][$dynamic_id];
//                        $_FILES['dynamic_file']['error'] = $_FILES['dynamic']['error'][$dynamic_id];
//                        $_FILES['dynamic_file']['size'] = $_FILES['dynamic']['size'][$dynamic_id];
//                        $uploadPath = 'attachments/events/dynamic_images/';
//                        $config['upload_path'] = $uploadPath;
//                        $config['allowed_types'] = 'jpg|jpeg|png|gif';
//                        $this->load->library('upload', $config);
//                        $this->upload->initialize($config);
//                        if ($this->upload->do_upload('dynamic_file')) {
//                            $fileData = $this->upload->data();
//                            $new_file_name = $_FILES['dynamic']['name'][$dynamic_id];
//                            $dynamic_file_data = $this->event_model->get_event_dynamic_file_field_details($id, $dynamic_id);
//                            $file_attachments_arr = array ();
//                            if (!empty($dynamic_file_data[0]['value'])) {
//                                $file_attachments_arr = explode(',', $dynamic_file_data[0]['value']);
//                            }
//                            $file_attachments_arr[] = $new_file_name;
//                            $file_list_str = implode(',', $file_attachments_arr);
//                            $eventDynamicFileArray[$dynamic_id] = array (
//                            'field_id' => $dynamic_id,
//                            'value' => $file_list_str,
//                            'event_id' => $id,
//                            'event_type_id' => $event['event_type_id'],
//                            'updated_date' => date('Y-m-d H:i:s')
//                            );
//                        }
//                    }
//                    if (!empty($eventDynamicFileArray)) {
//                        $dynamic_update = $this->event_model->update_event_dynamic_fields($eventDynamicFileArray, $id);
//                    }
//                }
//
//                $eventDynamicArray = array ();
//                if (isset($dynamic) && !empty($dynamic)) {
//                    foreach ($dynamic as $field_id => $val) {
//                        $dynamic_val = (is_array($val)) ? implode(',', $val) : $val;
//                        $eventDynamicArray[$field_id]['field_id'] = $field_id;
//                        $eventDynamicArray[$field_id]['value'] = $dynamic_val;
//                        $eventDynamicArray[$field_id]['event_id'] = $id;
//                        $eventDynamicArray[$field_id]['event_type_id'] = $event['event_type_id'];
//                        $eventDynamicArray[$field_id]['updated_date'] = date('Y-m-d H:i:s');
//                    }
//                    if (!empty($eventDynamicArray)) {
//                        $dynamic = $this->event_model->update_event_dynamic_fields($eventDynamicArray, $id);
//                    }
//                }
//
//                $invitationData = array ();
//                if (!empty($_FILES['invitation_image']['name'])) {
//                    $_FILES['file']['name'] = $_FILES['invitation_image']['name'];
//                    $_FILES['file']['type'] = $_FILES['invitation_image']['type'];
//                    $_FILES['file']['tmp_name'] = $_FILES['invitation_image']['tmp_name'];
//                    $_FILES['file']['error'] = $_FILES['invitation_image']['error'];
//                    $_FILES['file']['size'] = $_FILES['invitation_image']['size'];
//                    $uploadPath = 'attachments/events/invitations/';
//                    $config['upload_path'] = $uploadPath;
//                    $config['allowed_types'] = 'jpg|jpeg|png|gif';
//                    $this->load->library('upload', $config);
//                    $this->upload->initialize($config);
//                    if ($this->upload->do_upload('file')) {
//                        $fileData = $this->upload->data();
//                        $uploadData = array (
//                        'file_name' => $fileData['file_name'],
//                        'event_id' => $id,
//                        'img_path' => base_url() . $uploadPath . '' . $fileData['file_name']
//                        );
//                        $invitationData[] = $uploadData;
//                    }
//                }
//                if (!empty($invitationData)) {
//                    $insert = $this->event_model->insert_event_invitations($invitationData);
//                }
//                $this->session->set_flashdata('flashSuccess', 'Event successfully updated!');
//                redirect($this->config->item('base_url') . 'members/events');
//            } else {
//                $this->session->set_flashdata('flashError', 'Event not updated!Please try again.');
//                redirect($this->config->item('base_url') . 'members/events');
//            }
//        }
//
//        $data['event'] = $this->event_model->get_event_by_id($id);
//        $data['event_invitations'] = $this->event_model->get_event_invitations_by_event_id($id);
//        $data['event_invited_members'] = $this->event_model->get_event_invited_members_by_event_id($id);
//        $data['streets'] = $streets = $this->street_model->get_all_streets();
//        $streets_list = array ();
//        if (!empty($streets)) {
//            foreach ($streets as $list) {
//                $streets_list[$list['id']] = $list;
//            }
//        }
//        $data['streets_arr'] = $streets_list;
//        $data['groups'] = $groups = $this->group_model->get_all_groups();
//        $groups_list = array ();
//        if (!empty($groups)) {
//            foreach ($groups as $list) {
//                $groups_list[$list['id']] = $list;
//            }
//        }
//        $data['groups_arr'] = $groups_list;
//        $data['event_types'] = $this->event_type_model->get_all_event_types();
//        $tree_structure = $this->members_model->get_all_members_tree_structure();
//        $data['members_tree'] = (isset($tree_structure['all_members'])) ? $tree_structure['all_members'] : array ();
//        $data['members_count'] = (isset($tree_structure['members_count'])) ? $tree_structure['members_count'] : array ();
//
//        $dynamic_values = $this->event_model->get_event_dynamic_values_by_event_id($id);
//        $event_dynamic_values = array ();
//        if (!empty($dynamic_values)) {
//            foreach ($dynamic_values as $list) {
//                $event_dynamic_values[$list['field_id']] = $list;
//            }
//        }
//        $data['event_dynamic_values'] = $event_dynamic_values;
//        $event_type_dynamic_fields = $this->event_model->get_event_type_dynamic_fields($data['event'][0]['event_type_id']);
//        $event_dynamic_fields = array ();
//        if (!empty($event_type_dynamic_fields)) {
//            foreach ($event_type_dynamic_fields as $list) {
//                $event_dynamic_fields[$list['id']] = $list;
//            }
//        }
//        $data['event_dynamic_fields'] = $event_dynamic_fields;
//
//        $this->template->write_view('content', 'members/edit_event', $data);
//        $this->template->render();
//    }
    function edit($id) {
        $data = array ();
        $data['title'] = 'Events - Edit Event';
        if ($this->input->post()) {

            $event = $this->input->post('event');
            $event_members = $this->input->post('event_member');
            $dynamic = $this->input->post('dynamic');
            $from_date = explode(' ', $event['from_date']);
            $date = explode('/', $from_date[0]);
            $time = $from_date[1];
            $from_date = $date[2] . '-' . $date[1] . '-' . $date[0];
            $from_date_time = $from_date . ' ' . $time . ':00';
            $to_date = explode(' ', $event['to_date']);
            $date = explode('/', $to_date[0]);
            $time = $to_date[1];
            $to_date = $date[2] . '-' . $date[1] . '-' . $date[0];
            $to_date_time = $to_date . ' ' . $time . ':00';
            $event['from_date'] = $from_date_time;
            $event['to_date'] = $to_date_time;

            //$family_types = $event['family_types'];
            //$streets = $event['streets'];
            //$event['family_types'] = implode(',', $event['family_types']);
            //$event['streets'] = implode(',', $event['streets']);
            //$event['sent_event_to_all_members'] = ($event['sent_event_to_all_members'] == 1) ? $event['sent_event_to_all_members'] : 0;
            $event['updated_date'] = date('Y-m-d H:i:s');
            $event['approved_status'] = 2;

            // Get Invited Members List
            $invited_members_arr = array ();
            if (!empty($event_members)) {
                foreach ($event_members as $city_id => $streets) {
                    if (!empty($streets)) {
                        foreach ($streets as $street_id => $groups) {
                            if (!empty($groups)) {
                                foreach ($groups as $group_id => $members) {
                                    if (!empty($members)) {
                                        foreach ($members as $list) {
                                            $invited_members_arr[] = $list;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            $invited_members = array ();
            if (!empty($invited_members_arr)) {
                $members_list = $this->members_model->get_members_by_list($invited_members_arr);
                if (!empty($members_list)) {
                    foreach ($members_list as $list) {
                        $invited_members[$list['id']] = $list['email_address'];
                    }
                }
            }

            /* $family_members_1 = $this->event_model->get_family_members_by_family_type($family_types);
              $family_members_2 = $this->event_model->get_family_members_by_street($streets);
              if ($event['sent_event_to_all_members'] == 1) {
              $family_members_3 = $this->event_model->get_local_members($from_date_time, $to_date_time);
              }
              $invited_members = array();
              if (!empty($family_members_1)) {
              foreach ($family_members_1 as $list) {
              $invited_members[$list['id']] = $list['email_address'];
              }
              }
              if (!empty($family_members_2)) {
              foreach ($family_members_2 as $list) {
              $invited_members[$list['id']] = $list['email_address'];
              }
              }
              if ($event['sent_event_to_all_members'] == 1) {
              if (!empty($family_members_3)) {
              foreach ($family_members_3 as $list) {
              $invited_members[$list['id']] = $list['email_address'];
              }
              }
              } */

            $update = $this->event_model->update_event($event, $id);
            if ($update) {
                $invited_members = array_filter($invited_members);
                $invited_members_list = array_keys($invited_members);
                $invited_members_json = json_encode($invited_members_list);
                $invited_members_arr = array (
                'event_id' => $id,
                'total_invited_members' => count($invited_members),
                'invited_members' => $invited_members_json,
                'updated_date' => date('Y-m-d H:i:s')
                );
                $this->event_model->update_event_invited_members($invited_members_arr, $id);
                $this->event_invitation_mail($id, $invited_members);

                $eventDynamicFileArray = array ();
                if (!empty($_FILES['dynamic']['name'])) {
                    foreach ($_FILES['dynamic']['name'] as $dynamic_id => $dynamic_value) {
                        $_FILES['dynamic_file']['name'] = $_FILES['dynamic']['name'][$dynamic_id];
                        $_FILES['dynamic_file']['type'] = $_FILES['dynamic']['type'][$dynamic_id];
                        $_FILES['dynamic_file']['tmp_name'] = $_FILES['dynamic']['tmp_name'][$dynamic_id];
                        $_FILES['dynamic_file']['error'] = $_FILES['dynamic']['error'][$dynamic_id];
                        $_FILES['dynamic_file']['size'] = $_FILES['dynamic']['size'][$dynamic_id];
                        $uploadPath = 'attachments/events/dynamic_images/';
                        $config['upload_path'] = $uploadPath;
                        $config['allowed_types'] = 'jpg|jpeg|png|gif';
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if ($this->upload->do_upload('dynamic_file')) {
                            $fileData = $this->upload->data();
                            $new_file_name = $_FILES['dynamic']['name'][$dynamic_id];
                            $dynamic_file_data = $this->event_model->get_event_dynamic_file_field_details($id, $dynamic_id);
                            $file_attachments_arr = array ();
                            if (!empty($dynamic_file_data[0]['value'])) {
                                $file_attachments_arr = explode(',', $dynamic_file_data[0]['value']);
                            }
                            $file_attachments_arr[] = $new_file_name;
                            $file_list_str = implode(',', $file_attachments_arr);
                            $eventDynamicFileArray[$dynamic_id] = array (
                            'field_id' => $dynamic_id,
                            'value' => $file_list_str,
                            'event_id' => $id,
                            'event_type_id' => $event['event_type_id'],
                            'updated_date' => date('Y-m-d H:i:s')
                            );
                        }
                    }
                    if (!empty($eventDynamicFileArray)) {
                        $dynamic_update = $this->event_model->update_event_dynamic_fields($eventDynamicFileArray, $id);
                    }
                }

                $eventDynamicArray = array ();
                if (isset($dynamic) && !empty($dynamic)) {
                    foreach ($dynamic as $field_id => $val) {
                        $dynamic_val = (is_array($val)) ? implode(',', $val) : $val;
                        $eventDynamicArray[$field_id]['field_id'] = $field_id;
                        $eventDynamicArray[$field_id]['value'] = $dynamic_val;
                        $eventDynamicArray[$field_id]['event_id'] = $id;
                        $eventDynamicArray[$field_id]['event_type_id'] = $event['event_type_id'];
                        $eventDynamicArray[$field_id]['updated_date'] = date('Y-m-d H:i:s');
                    }
                    if (!empty($eventDynamicArray)) {
                        $dynamic = $this->event_model->update_event_dynamic_fields($eventDynamicArray, $id);
                    }
                }

                $invitationData = array ();
                if (!empty($_FILES['invitation_image']['name'])) {
                    $_FILES['file']['name'] = $_FILES['invitation_image']['name'];
                    $_FILES['file']['type'] = $_FILES['invitation_image']['type'];
                    $_FILES['file']['tmp_name'] = $_FILES['invitation_image']['tmp_name'];
                    $_FILES['file']['error'] = $_FILES['invitation_image']['error'];
                    $_FILES['file']['size'] = $_FILES['invitation_image']['size'];
                    $uploadPath = 'attachments/events/invitations/';
                    $config['upload_path'] = $uploadPath;
                    $config['allowed_types'] = 'jpg|jpeg|png|gif';
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        $fileData = $this->upload->data();
                        $uploadData = array (
                        'file_name' => $fileData['file_name'],
                        'event_id' => $id,
                        'img_path' => base_url() . $uploadPath . '' . $fileData['file_name']
                        );
                        $invitationData[] = $uploadData;
                    }
                }
                if (!empty($invitationData)) {
                    $insert = $this->event_model->insert_event_invitations($invitationData);
                }
                $this->session->set_flashdata('flashSuccess', 'Event successfully updated!');
                redirect($this->config->item('base_url') . 'members/events');
            } else {
                $this->session->set_flashdata('flashError', 'Event not updated! Please try again.');
                redirect($this->config->item('base_url') . 'members/events');
            }
        }

        $data['event'] = $this->event_model->get_event_by_id($id);
        $data['event_invitations'] = $this->event_model->get_event_invitations_by_event_id($id);
        $data['event_invited_members'] = $this->event_model->get_event_invited_members_by_event_id($id);
        $data['streets'] = $streets = $this->street_model->get_all_streets();
        $streets_list = array ();
        if (!empty($streets)) {
            foreach ($streets as $list) {
                $streets_list[$list['id']] = $list;
            }
        }
        $data['streets_arr'] = $streets_list;
        $data['groups'] = $groups = $this->group_model->get_all_groups();
        $groups_list = array ();
        if (!empty($groups)) {
            foreach ($groups as $list) {
                $groups_list[$list['id']] = $list;
            }
        }
        $data['groups_arr'] = $groups_list;
        $data['event_types'] = $this->event_type_model->get_all_event_types();
        $tree_structure = $this->members_model->get_all_members_tree_structure();
        $data['members_tree'] = (isset($tree_structure['all_members'])) ? $tree_structure['all_members'] : array ();
        $data['members_section'] = (isset($tree_structure['members_section'])) ? $tree_structure['members_section'] : array ();
        $data['members_count'] = (isset($tree_structure['members_count'])) ? $tree_structure['members_count'] : array ();

        $dynamic_values = $this->event_model->get_event_dynamic_values_by_event_id($id);
        $event_dynamic_values = array ();
        if (!empty($dynamic_values)) {
            foreach ($dynamic_values as $list) {
                $event_dynamic_values[$list['field_id']] = $list;
            }
        }
        $data['event_dynamic_values'] = $event_dynamic_values;
        $event_type_dynamic_fields = $this->event_model->get_event_type_dynamic_fields($data['event'][0]['event_type_id']);
        $event_dynamic_fields = array ();
        if (!empty($event_type_dynamic_fields)) {
            foreach ($event_type_dynamic_fields as $list) {
                $event_dynamic_fields[$list['id']] = $list;
            }
        }
        $data['event_dynamic_fields'] = $event_dynamic_fields;

        $this->template->write_view('content', 'members/edit_event', $data);
        $this->template->render();
    }

    function view($id) {
        $data = array ();
        $data['title'] = 'Event - View Event';
        $data['event_types'] = $this->event_type_model->get_all_event_types();
        $data['event_invited_members'] = $this->event_model->get_event_invited_members_by_event_id($id);
        $data['streets'] = $streets = $this->street_model->get_all_streets();
        $streets_list = array ();
        if (!empty($streets)) {
            foreach ($streets as $list) {
                $streets_list[$list['id']] = $list;
            }
        }
        $data['streets_arr'] = $streets_list;
        $data['groups'] = $groups = $this->group_model->get_all_groups();
        $groups_list = array ();
        if (!empty($groups)) {
            foreach ($groups as $list) {
                $groups_list[$list['id']] = $list;
            }
        }
        $data['groups_arr'] = $groups_list;
        $tree_structure = $this->members_model->get_all_members_tree_structure();
        $data['members_tree'] = (isset($tree_structure['all_members'])) ? $tree_structure['all_members'] : array ();
        $data['members_section'] = (isset($tree_structure['members_section'])) ? $tree_structure['members_section'] : array ();
        $data['members_count'] = (isset($tree_structure['members_count'])) ? $tree_structure['members_count'] : array ();

        $data['event'] = $this->event_model->get_event_by_id($id);
        $data['event_invitations'] = $this->event_model->get_event_invitations_by_event_id($id);

        $dynamic_values = $this->event_model->get_event_dynamic_values_by_event_id($id);
        $event_dynamic_values = array ();
        if (!empty($dynamic_values)) {
            foreach ($dynamic_values as $list) {
                $event_dynamic_values[$list['field_id']] = $list;
            }
        }
        $data['event_dynamic_values'] = $event_dynamic_values;
        $event_type_dynamic_fields = $this->event_model->get_event_type_dynamic_fields($data['event'][0]['event_type_id']);
        $event_dynamic_fields = array ();
        if (!empty($event_type_dynamic_fields)) {
            foreach ($event_type_dynamic_fields as $list) {
                $event_dynamic_fields[$list['id']] = $list;
            }
        }
        $data['event_dynamic_fields'] = $event_dynamic_fields;
        $this->template->write_view('content', 'members/view_event_new', $data);
        $this->template->render();
    }

    function delete($id) {

        $data = array ('is_deleted' => 1);
        $delete = $this->event_model->delete_event($id);
        if ($delete == 1) {
            $this->session->set_flashdata('flashSuccess', 'Case Type successfully deleted!');
            echo '1';
        } else {
            $this->session->set_flashdata('flashError', 'Operation Failed!');
            echo '0';
        }
    }

    function delete_invitation($id) {
        $id = $this->input->post('id');
        $delete = $this->event_model->delete_invitation_by_id($id);
        if ($delete) {
            $this->session->set_flashdata('flashSuccess', 'Event Invitation successfully deleted!');
            echo '1';
        } else {
            $this->session->set_flashdata('flashError', 'Operation Failed!');
            echo '0';
        }
    }

    function delete_dynamic_field_attachment() {
        $event_id = $this->input->post('event_id');
        $field_id = $this->input->post('field_id');
        $file_name = $this->input->post('file_name');

        $new_file_name = $_FILES['dynamic']['name'][$dynamic_id];
        $dynamic_file_data = $this->event_model->get_event_dynamic_file_field_details($event_id, $field_id);
        $file_attachments_arr = array ();
        if (!empty($dynamic_file_data[0]['value'])) {
            $file_attachments_arr = explode(', ', $dynamic_file_data[0]['value']);
        }
        if (($key = array_search($file_name, $file_attachments_arr)) !== false) {
            unset($file_attachments_arr[$key]);
        }
        $file_list_str = implode(', ', $file_attachments_arr);
        $eventDynamicFileArray[$field_id] = array (
        'field_id' => $field_id,
        'value' => $file_list_str,
        'event_id' => $event_id,
        'event_type_id' => $dynamic_file_data[0]['event_type_id'],
        'updated_date' => date('Y-m-d H:i:s')
        );

        if (!empty($eventDynamicFileArray)) {
            $dynamic = $this->event_model->update_event_dynamic_fields($eventDynamicFileArray, $event_id);
            $this->session->set_flashdata('flashSuccess', 'Event field attachment successfully deleted!');
            echo '1';
        } else {
            $this->session->set_flashdata('flashError', 'Operation Failed!');
            echo '0';
        }
    }

    function event_invitation_mail($id, $invited_members = array ()) {

        $data = array ();
        $this->load->library('email');
        $config = array (
        'protocol' => 'mail',
        'charset' => 'utf-8',
        'wordwrap' => FALSE,
        'mailtype' => 'html'
        );
        $this->email->initialize($config);
        $data = array ();

        $data['event_types'] = $this->event_type_model->get_all_event_types();
        $data['event_invited_members'] = $this->event_model->get_event_invited_members_by_event_id($id);
        $data['streets'] = $streets = $this->street_model->get_all_streets();
        $streets_list = array ();
        if (!empty($streets)) {
            foreach ($streets as $list) {
                $streets_list[$list['id']] = $list;
            }
        }
        $data['streets_arr'] = $streets_list;
        $data['groups'] = $groups = $this->group_model->get_all_groups();
        $groups_list = array ();
        if (!empty($groups)) {
            foreach ($groups as $list) {
                $groups_list[$list['id']] = $list;
            }
        }
        $data['groups_arr'] = $groups_list;
        $tree_structure = $this->members_model->get_all_members_tree_structure();
        $data['members_tree'] = (isset($tree_structure['all_members'])) ? $tree_structure['all_members'] : array ();
        $data['members_section'] = (isset($tree_structure['members_section'])) ? $tree_structure['members_section'] : array ();
        $data['members_count'] = (isset($tree_structure['members_count'])) ? $tree_structure['members_count'] : array ();

        $data['event'] = $this->event_model->get_event_by_id($id);


        $data['event_invitations'] = $this->event_model->get_event_invitations_by_event_id($id);

        $dynamic_values = $this->event_model->get_event_dynamic_values_by_event_id($id);
        $event_dynamic_values = array ();
        if (!empty($dynamic_values)) {
            foreach ($dynamic_values as $list) {
                $event_dynamic_values[$list['field_id']] = $list;
            }
        }
        $data['event_dynamic_values'] = $event_dynamic_values;
        $event_type_dynamic_fields = $this->event_model->get_event_type_dynamic_fields($data['event'][0]['event_type_id']);
        $event_dynamic_fields = array ();
        if (!empty($event_type_dynamic_fields)) {
            foreach ($event_type_dynamic_fields as $list) {
                $event_dynamic_fields[$list['id']] = $list;
            }
        }
        $data['event_dynamic_fields'] = $event_dynamic_fields;

        $htmlContent .= $this->load->view('members/event_invitation_mail.php', $data, TRUE);
        $invited_members_list = array_values($invited_members);
        $invited_members_lists = implode(',', $invited_members_list);
        $this->email->from('ftwoftesting@gmail.com', 'Events');
//        $this->email->to($invited_members_lists);
        $this->email->to('kavithabui2k18@gmail.com');
        $this->email->subject('Event Invitation');
        $this->email->message($htmlContent);
        $this->email->send();
        echo $this->email->print_debugger();
    }

    function generate_form_by_event_type() {
        $event_type = $this->input->post('event_type');
        $form_fields = $this->event_model->get_event_type_dynamic_fields($event_type);
        $form_text = '';
        $form_field_text = '';
        $num = 1;
        if (!empty($form_fields)) {
            foreach ($form_fields as $field) {
                $fieldData = json_decode($field['field_data'], TRUE);
                $fieldID = $field['id'];
                $fieldType = $field['field_type'];
                $fieldLabel = $field['field_label'];
                $fieldValue = (!empty($fieldData['value'])) ? $fieldData['value'] : '';
                $fieldOptions = !empty($fieldData['values']) ? $fieldData['values'] : array ();
                $fieldRequired = (!empty($fieldData['required'])) ? $fieldData['required'] : 0;
                $fieldPlaceholder = (!empty($fieldData['placeholder'])) ? $fieldData['placeholder'] : '';
                $fieldLength = (!empty($fieldData['maxlength'])) ? $fieldData['maxlength'] : '';
                $fieldRows = (!empty($fieldData['rows'])) ? $fieldData['rows'] : '';
                $is_multiple = (!empty($fieldData['multiple'])) ? $fieldData['multiple'] : 0;
                $is_required = ($fieldRequired == 1) ? 'required' : '';
                $required_text = ($fieldRequired == 1) ? '<span class = "req">*</span>' : '';
                $maxlength_text = ($fieldLength != '') ? 'maxlength = "' . $fieldLength . '"' : '';
                $multiple_text = ($is_multiple == 1) ? 'multiple = "multiple"' : '';

                $field_text = '';
                switch ($fieldType) {
                    case 'text':
                        $field_text .= '<div class = "col-xs-4">';
                        $field_text .= '<div class = "form-group has-feedback has-feedback-left">';
                        $field_text .= '<label><strong>' . $fieldLabel . ':</strong></label>' . $required_text;
                        $field_text .= '<input type = "text" name = "dynamic[' . $fieldID . ']" class = "form-control ' . $is_required . '" value = "' . $fieldValue . '" placeholder = "' . $fieldPlaceholder . '" ' . $maxlength_text . '>';
                        $field_text .= '<span class = "error_msg"></span>';
                        $field_text .= '<div class = "form-control-feedback"><i class = "icon-clipboard2"></i></div>';
                        $field_text .= '</div>';
                        $field_text .= '</div>';
                        break;
                    case 'date':
                        $field_text .= '<div class = "col-xs-4">';
                        $field_text .= '<div class = "form-group has-feedback has-feedback-left">';
                        $field_text .= '<label><strong>' . $fieldLabel . ':</strong></label>' . $required_text;
                        $field_text .= '<input type = "text" name = "dynamic[' . $fieldID . ']" class = "form-control dynamic_datepicker ' . $is_required . '" readonly = "readonly" placeholder = "' . $fieldPlaceholder . '">';
                        $field_text .= '<span class = "error_msg"></span>';
                        $field_text .= '<div class = "form-control-feedback"><i class = "icon-calendar3"></i></div>';
                        $field_text .= '</div>';
                        $field_text .= '</div>';
                        break;
                    case 'number':
                        $field_text .= '<div class = "col-xs-4">';
                        $field_text .= '<div class = "form-group has-feedback has-feedback-left">';
                        $field_text .= '<label><strong>' . $fieldLabel . ':</strong></label>' . $required_text;
                        $field_text .= '<input type = "number" name = "dynamic[' . $fieldID . ']" class = "form-control ' . $is_required . '" value = "' . $fieldValue . '" placeholder = "' . $fieldPlaceholder . '">';
                        $field_text .= '<span class = "error_msg"></span>';
                        $field_text .= '<div class = "form-control-feedback"><i class = "icon-clipboard2"></i></div>';
                        $field_text .= '</div>';
                        $field_text .= '</div>';
                        break;
                    case 'file':
                        $field_text .= '<div class = "col-xs-4">';
                        $field_text .= '<div class = "form-group has-feedback">';
                        $field_text .= '<label><strong>' . $fieldLabel . ':</strong></label>' . $required_text;
                        $field_text .= '<input type = "file" name = "dynamic[' . $fieldID . ']" class = "form-control dynamic_file ' . $is_required . '" placeholder = "' . $fieldPlaceholder . '" ' . $multiple_text . '>';
                        $field_text .= '<span class = "error_msg"></span>';
                        $field_text .= '<div class = "form-control-feedback"><i class = "icon-file-picture"></i></div>';
                        $field_text .= '</div>';
                        $field_text .= '</div>';
                        break;
                    case 'textarea':
                        $field_text .= '<div class = "col-xs-4">';
                        $field_text .= '<div class = "form-group has-feedback has-feedback-left">';
                        $field_text .= '<label><strong>' . $fieldLabel . ':</strong></label>' . $required_text;
                        $field_text .= '<textarea name = "dynamic[' . $fieldID . ']" class = "form-control ' . $is_required . '" placeholder = "' . $fieldPlaceholder . '" ' . $maxlength_text . ' rows = "' . $fieldRows . '" style = "resize:vertical;">' . $fieldValue . '</textarea>';
                        $field_text .= '<span class = "error_msg"></span>';
                        $field_text .= '<div class = "form-control-feedback"><i class = "icon-clipboard2"></i></div>';
                        $field_text .= '</div>';
                        $field_text .= '</div>';
                        break;
                    case 'select':
                        $option_text = '';
                        $option_text .= '<option value = "">' . $fieldPlaceholder . '</option>';
                        if (!empty($fieldOptions)) {
                            foreach ($fieldOptions as $option) {
                                $is_selected = (!empty($option['selected'])) ? 'selected = "selected"' : '';
//                                $option_text .= '<option value = "' . $option['value'] . '" ' . $is_selected . '>' . $option['label'] . '</option>';
                                $option_text .= '<option value="' . $option['label'] . '" ' . $is_selected . '>' . $option['label'] . '</option>';
                            }
                        }
                        $field_text .= '<div class = "col-xs-4">';
                        $field_text .= '<div class = "form-group has-feedback has-feedback-left">';
                        $field_text .= '<label><strong>' . $fieldLabel . ':</strong></label>' . $required_text;
                        if ($is_multiple) {
                            $field_text .= '<select name = "dynamic[' . $fieldID . '][]" class = "form-control ' . $is_required . '" ' . $multiple_text . '>' . $option_text . '</select>';
                        } else {
                            $field_text .= '<select name = "dynamic[' . $fieldID . ']" class = "form-control ' . $is_required . '" ' . $multiple_text . '>' . $option_text . '</select>';
                        }
                        $field_text .= '<span class = "error_msg"></span>';
                        $field_text .= '<div class = "form-control-feedback"><i class = "icon-clipboard2"></i></div>';
                        $field_text .= '</div>';
                        $field_text .= '</div>';
                        break;
                    case 'checkbox-group':
                        $option_text = '';
                        if (!empty($fieldOptions)) {
                            foreach ($fieldOptions as $option) {
                                $is_checked = (!empty($option['selected'])) ? 'checked = "checked"' : '';
//                                $option_text .= '<div class = "checkbox"><label><input type = "checkbox" name = "dynamic[' . $fieldID . '][]" value = "' . $option['value'] . '" ' . $is_checked . '>' . $option['label'] . '</label></div>';
                                $option_text .= '<div class = "checkbox"><label><input type = "checkbox" name = "dynamic[' . $fieldID . '][]" value = "' . $option['label'] . '" ' . $is_checked . '>' . $option['label'] . '</label></div>';
                            }
                        }
                        $field_text .= '<input type = "hidden" name = "dynamic[' . $fieldID . ']" value = "">';
                        $field_text .= '<div class = "col-xs-4">';
                        $field_text .= '<div class = "form-group">';
                        $field_text .= '<label class = "text-semibold"><strong>' . $fieldLabel . ':</strong></label>' . $required_text;
                        $field_text .= $option_text;
                        $field_text .= '<span class = "error_msg"></span>';
                        $field_text .= '</div>';
                        $field_text .= '</div>';
                        break;
                    case 'radio-group':
                        $option_text = '';
                        if (!empty($fieldOptions)) {
                            foreach ($fieldOptions as $option) {
                                $is_checked = (!empty($option['selected'])) ? 'checked = "checked"' : '';
//                                $option_text .= '<div class = "radio"><label><input type = "radio" name = "dynamic[' . $fieldID . ']" value = "' . $option['value'] . '" ' . $is_checked . '>' . $option['label'] . '</label></div>';
                                $option_text .= '<div class = "radio"><label><input type = "radio" name = "dynamic[' . $fieldID . ']" value = "' . $option['label'] . '" ' . $is_checked . '>' . $option['label'] . '</label></div>';
                            }
                        }
                        $field_text .= '<input type = "hidden" name = "dynamic[' . $fieldID . ']" value = "">';
                        $field_text .= '<div class = "col-xs-4">';
                        $field_text .= '<div class = "form-group">';
                        $field_text .= '<label class = "text-semibold"><strong>' . $fieldLabel . ':</strong></label>' . $required_text;
                        $field_text .= $option_text;
                        $field_text .= '<span class = "error_msg"></span>';
                        $field_text .= '</div>';
                        $field_text .= '</div>';
                        break;
                    default:
                        break;
                }
                $form_field_text .= $field_text;

                if ($num == 3) {
                    $form_text .= '<div class = "row" style = "margin-bottom:15px;">' . $form_field_text . '</div>';
                    $form_field_text = '';
                    $num = 0;
                }
                $num++;
            }
            if ($form_field_text != '') {
                $form_text .= '<div class = "row">' . $form_field_text . '</div>';
                $form_field_text = '';
            }
        }
        echo $form_text;
    }

    function today_events() {
        $data = array ();
        $data['title'] = 'Events - Today Events';
        $data['events'] = $this->event_model->get_today_events();
        $this->template->write_view('content', 'dashboard/index', $data);
        $this->template->render();
    }

    function invited_members($id) {
        $data = array ();
        $data['title'] = 'Events - Invited Members';
        $data['event'] = $this->event_model->get_event_by_id($id);
        $data['invited_members'] = $this->event_model->get_invited_members_list($id);

        $this->template->write_view('content', 'members/invited_members', $data);
        $this->template->render();
    }

    function accept_members($id) {
        $data = array ();
        $data['title'] = 'Events - Accept Members';
        $data['event'] = $this->event_model->get_event_by_id($id);
        $data['accept_members'] = $this->event_model->get_event_accept_members_list($id);
        $this->template->write_view('content', 'members/accept_members', $data);
        $this->template->render();
    }

    function reject_members($id) {
        $data = array ();
        $data['title'] = 'Events - Reject Members';
        $data['event'] = $this->event_model->get_event_by_id($id);
        $data['reject_members'] = $this->event_model->get_event_reject_members_list($id);
        $this->template->write_view('content', 'members/reject_members', $data);
        $this->template->render();
    }

    function events_ajaxList() {
        $search_data = array ();
        $search_data = $this->input->post();
        $list = $this->event_model->get_datatables($search_data);




        $data = array ();
        $no = $_POST['start'];
        foreach ($list as $ass) {
            $no++;
            $row = array ();
            $row[] = $no;
            $row[] = ucfirst($ass['event_type_name']);
            $row[] = ucfirst($ass['event_name']);
////            $row[] = ucfirst($ass['group_name']);
//            $row[] = ucfirst($ass['street_name']);
            $row[] = (!empty($ass['from_date'])) ? date('d-M-Y H:i A', strtotime($ass['from_date'])) : '';
            $row[] = (!empty($ass['to_date'])) ? date('d-M-Y H:i A', strtotime($ass['to_date'])) : '';
            $accept_count = (!empty($ass['accept_count'])) ? $ass['accept_count'] : 0;
            $reject_count = (!empty($ass['reject_count'])) ? $ass['reject_count'] : 0;

            $invited_count = (!empty($ass['invited_count'])) ? $ass['invited_count'] : 0;
            $row[] = '<a class = "btn btn-primary btn-xs" href = "' . $this->config->item('base_url') . 'members/events/invited_members/' . $ass['id'] . '">' . $invited_count . '</a>';
            $row[] = '<a class = "btn btn-success btn-xs" href = "' . $this->config->item('base_url') . 'members/events/accept_members/' . $ass['id'] . '">' . $accept_count . '</a>';
            $row[] = '<a class = "btn btn-danger btn-xs" href = "' . $this->config->item('base_url') . 'members/events/reject_members/' . $ass['id'] . '">' . $reject_count . '</a>';

            if ($ass['approved_status'] == '1') {
                $approved_status = '<span class = "label label-success">Approved</span>';
            } elseif ($ass['approved_status'] == '2') {
                $approved_status = '<span class = "label label-default">Pending</span>';
            } elseif ($ass['approved_status'] == '0') {
                $approved_status = '<span class = "label label-danger">Rejected</span>';
            }
            $row[] = $approved_status;
            if ($ass['status'] == '1') {
                $status = '<span class = "label label-success">Active</span>';
            } else {
                $status = '<span class = "label label-default">Inactive</span>';
            }
            $row[] = $status;
            $user_id = $this->user_auth->get_user_id();
            $event_user_id = $ass['user_id'];

            if ($this->user_auth->is_action_allowed('members', 'members', 'view', 'edit', 'delete') && $user_id == $event_user_id) {
                $row[] = '<a href = "' . $this->config->item('base_url') . 'members/events/view/' . $ass['id'] . '" class = "btn btn-success btn-xs" title = "View"><i class = "glyphicon glyphicon-eye-open"></i></a>&nbsp;
                <a href = "' . $this->config->item('base_url') . 'members/events/edit/' . $ass['id'] . '" class = "btn btn-info btn-xs" title = "Edit"><i class = "glyphicon glyphicon-edit"></i></a>&nbsp;
                <a href = "javascript:void(0);" event_id = "' . $ass['id'] . '" event_id = "' . $ass['id'] . '" class = "btn btn-danger btn-xs delete_event" title = "Delete"><i class = "glyphicon glyphicon-trash"></i></a>';
            } elseif ($this->user_auth->is_action_allowed('members', 'members', 'view', 'edit', 'delete')) {
                $row[] = '<a href = "' . $this->config->item('base_url') . 'members/events/view/' . $ass['id'] . '" class = "btn btn-success btn-xs" style="margin-left: 38px;" title = "View"><i class = "glyphicon glyphicon-eye-open"></i></a>&nbsp;';
            }
            $data[] = $row;
        }

        $filter_count = $this->event_model->count_filtered($search_data);
        $filter_count = (!empty($filter_count)) ? count($filter_count) : 0;
        $output = array (
        'draw' => $_POST['draw'],
        'recordsTotal' => $this->event_model->count_all(),
        'recordsFiltered' => $filter_count,
        'data' => $data
        );
        echo json_encode($output);
        exit;
    }

    public function download($id) {
        if (!empty($id)) {
            //load download helper
            $this->load->helper('download');

            //get file info from database
            $fileInfo = $this->file->getRows(array ('id' => $id));
            echo '<pre>';
            print_r($fileInfo);
            exit;
            //file path
            $file = 'attachments/events/invitations/' . $fileInfo['file_name '];

            //download file from directory
            force_download($file, NULL);
        }
    }

}
