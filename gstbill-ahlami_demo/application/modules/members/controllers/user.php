<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends MX_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->user_auth->is_logged_in()) {
            redirect($this->config->item('base_url') . 'users/login');
        }

        $main_module = 'members';
        $access_arr = array (
        'user/delete' => 'no_restriction',
        'user/index' => 'no_restriction',
        'user/add' => 'no_restriction',
        'user/member_profile' => 'no_restriction',
        'user/edit' => 'no_restriction',
        'user/users_ajaxList' => 'no_restriction'
        );

        if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {
            redirect($this->config->item('base_url') . 'members/dashboard');
        }

        $this->load->model('members/members_model');
        $this->load->model('masters/street_model');
        $this->load->model('members/group_model');
        $this->load->model('api/increment_model');
        $this->template->set_master_template('../../themes/event/member_template.php');
        $this->template->write_view('session_msg', 'users/session_msg');
        date_default_timezone_set($this->timezone->timezone());
    }

    function index() {
        $data = array ();
        $data['title'] = 'Members - Manage Members';
        $member_id = $this->user_auth->get_user_id();
        $family = $this->members_model->get_member_family_id($member_id);
        $data['members'] = $this->members_model->get_all_members_by_family($family);

        $this->template->write_view('content', 'members/member_index', $data);
        $this->template->render();
    }

    function add() {
        $data = array ();
        $data['title'] = 'Members - Add New Member';
        $id = $this->user_auth->get_user_id();
        if ($this->input->post('member')) {
            // Profile Picture
            $profile_image = NULL;
            $config['upload_path'] = './attachments/member_image/';
            $allowed_types = array ('jpg', 'jpeg', 'png');
            $config['allowed_types'] = implode('|', $allowed_types);
            $config['max_size'] = '10000';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!empty($_FILES['profile_image']['name'])) {
                $_FILES['profile_image'] = array (
                'name' => $_FILES['profile_image']['name'],
                'type' => $_FILES['profile_image']['type'],
                'tmp_name' => $_FILES['profile_image']['tmp_name'],
                'error' => $_FILES['profile_image']['error'],
                'size' => $_FILES['profile_image']['size']
                );
                $random_hash = substr(str_shuffle(time()), 0, 3) . strrev(mt_rand(100000, 999999));
                $extension = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
                $config['file_name'] = 'MI_' . $random_hash . '.' . $extension;
                $this->upload->initialize($config);
                $this->upload->do_upload('profile_image');
                $upload_data = $this->upload->data();
                // Make thumbnail image
                $this->load->library('image_lib');
                $config['image_library'] = 'gd2';
                $config['source_image'] = FCPATH . 'attachments/member_image/' . $upload_data['file_name'];
                $config['create_thumb'] = TRUE;
                $config['maintain_ratio'] = FALSE;
                $config['width'] = 150;
                $config['height'] = 150;
                $config['new_image'] = FCPATH . 'attachments/member_image/thumb/' . $upload_data['file_name'];
                $this->image_lib->initialize($config);
                $this->image_lib->resize();
                $profile_image = $upload_data['file_name'];
            }

            $member = $this->input->post('member');
            $dob = explode(' ', $member['dob']);
            $dob_date = explode('/', $dob[0]);
            $dob_formatted = $dob_date[2] . '-' . $dob_date[1] . '-' . $dob_date[0];

            if ($member['on_kayalpattinam'] == 'temporary') {
                $dur_from = explode(' ', $member['duration_from']);
                $dur_from_date = explode('/', $dur_from[0]);
                $dur_from_formatted = $dur_from_date[2] . '-' . $dur_from_date[1] . '-' . $dur_from_date[0];

                $dur_to = explode(' ', $member['duration_to']);
                $dur_to_date = explode('/', $dur_to[0]);
                $dur_to_formatted = $dur_to_date[2] . '-' . $dur_to_date[1] . '-' . $dur_to_date[0];
            } else {
                $dur_from_formatted = NULL;
                $dur_to_formatted = NULL;
            }

            if (!empty($profile_image))
                $member['profile_image'] = $profile_image;
            $member['password'] = md5($member['password']);
            $member['dob'] = $dob_formatted;
            $member['duration_from'] = $dur_from_formatted;
            $member['duration_to'] = $dur_to_formatted;
            $member['street_id'] = $member['street_id'];
            $member['created_date'] = date('Y-m-d H:i:s');

            $data['member'] = $this->members_model->get_member_by_id($id);
            $member['street_id'] = $data['member'][0]['street_id'];
            $member['family_id'] = $data['member'][0]['family_id'];
            $user_type_id = $this->user_auth->get_user_id();
            $member['city'] = $data['member'][0]['city'];
            $member['user_type_id'] = 2;
            $member['approved_status'] = 1;

            $insert_id = $this->members_model->insert_member($member);
            if (!empty($insert_id)) {
                $this->increment_model->update_increment_code('member_code');
                $this->session->set_flashdata('flashSuccess', 'New Member successfully added!');
                redirect($this->config->item('base_url') . 'members/user');
            } else {
                $this->session->set_flashdata('flashError', 'Member not added! Please try again');
                redirect($this->config->item('base_url') . 'members/user');
            }
        }

        $data['member'] = $this->members_model->get_member_by_id($id);
        $data['groups'] = $this->members_model->get_all_groups_by_street($data['member'][0]['street_id']);
        $data['streets'] = $this->group_model->get_street_by_city($data['member'][0]['city']);
        $data['member_id'] = $this->increment_model->get_increment_code('member_code');
        $this->template->write_view('content', 'members/user_add_member', $data);
        $this->template->render();
    }

    function edit($id) {
        $data = array ();
        $data['title'] = 'Members - Edit Member';

        if ($this->input->post('member')) {
            // Profile Picture
            $profile_image = NULL;
            $config['upload_path'] = './attachments/member_image/';
            $allowed_types = array ('jpg', 'jpeg', 'png');
            $config['allowed_types'] = implode('|', $allowed_types);
            $config['max_size'] = '10000';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!empty($_FILES['profile_image']['name'])) {
                $_FILES['profile_image'] = array (
                'name' => $_FILES['profile_image']['name'],
                'type' => $_FILES['profile_image']['type'],
                'tmp_name' => $_FILES['profile_image']['tmp_name'],
                'error' => $_FILES['profile_image']['error'],
                'size' => $_FILES['profile_image']['size']
                );
                $random_hash = substr(str_shuffle(time()), 0, 3) . strrev(mt_rand(100000, 999999));
                $extension = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
                $config['file_name'] = 'MI_' . $random_hash . '.' . $extension;
                $this->upload->initialize($config);
                $this->upload->do_upload('profile_image');
                $upload_data = $this->upload->data();
                // Make thumbnail image
                $this->load->library('image_lib');
                $config['image_library'] = 'gd2';
                $config['source_image'] = FCPATH . 'attachments/member_image/' . $upload_data['file_name'];
                $config['create_thumb'] = TRUE;
                $config['maintain_ratio'] = FALSE;
                $config['width'] = 150;
                $config['height'] = 150;
                $config['new_image'] = FCPATH . 'attachments/member_image/thumb/' . $upload_data['file_name'];
                $this->image_lib->initialize($config);
                $this->image_lib->resize();
                $profile_image = $upload_data['file_name'];
            }

            $member = $this->input->post('member');
            if (!empty($profile_image))
                $member['profile_image'] = $profile_image;

            $dob = explode(' ', $member['dob']);
            $dob_date = explode('/', $dob[0]);
            $dob_formatted = $dob_date[2] . '-' . $dob_date[1] . '-' . $dob_date[0];
            $member['dob'] = $dob_formatted;
            if (!empty(trim($member['password'])))
                $member['password'] = md5($member['password']);
            else
                unset($member['password']);
            if ($member['on_kayalpattinam'] == 'temporary') {
                $dur_from = explode(' ', $member['duration_from']);
                $dur_from_date = explode('/', $dur_from[0]);
                $dur_from_formatted = $dur_from_date[2] . '-' . $dur_from_date[1] . '-' . $dur_from_date[0];

                $dur_to = explode(' ', $member['duration_to']);
                $dur_to_date = explode('/', $dur_to[0]);
                $dur_to_formatted = $dur_to_date[2] . '-' . $dur_to_date[1] . '-' . $dur_to_date[0];
                $member['duration_from'] = $dur_from_formatted;
                $member['duration_to'] = $dur_to_formatted;
            } else {
                $member['duration_from'] = NULL;
                $member['duration_to'] = NULL;
            }
            $member['updated_date'] = date('Y-m-d H:i:s');
            $update = $this->members_model->update_member($member, $id);

            if (!empty($update)) {
                $this->session->set_flashdata('flashSuccess', 'Member successfully updated!');
                redirect($this->config->item('base_url') . 'members/user');
            } else {
                $this->session->set_flashdata('flashError', 'Member not updated! Please try again.');
                redirect($this->config->item('base_url') . 'members/user');
            }
        }
        $user_id = $this->user_auth->get_user_id();
        $data['chk_member_relation'] = $this->members_model->get_member_relation($user_id);

        $data['member'] = $this->members_model->get_member_by_id($id);
        $data['groups'] = $this->members_model->get_all_groups_by_street($data['member'][0]['street_id']);
        $data['streets'] = $this->group_model->get_street_by_city($data['member'][0]['city']);
        $data['location'] = $this->members_model->get_user_checked_in_location($id);

        $this->template->write_view('content', 'members/user_edit_member', $data);
        $this->template->render();
    }

    function member_profile() {
        $data = array ();
        $id = $this->user_auth->get_user_id();
        $data['title'] = 'My Profile';
        if ($this->input->post('user')) {
            // Profile Picture
            $profile_image = NULL;
            $config['upload_path'] = './attachments/profile_image/';
            $allowed_types = array ('jpg', 'jpeg', 'png');
            $config['allowed_types'] = implode('|', $allowed_types);
            $config['max_size'] = '10000';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!empty($_FILES['profile_image']['name'])) {
                $_FILES['profile_image'] = array (
                'name' => $_FILES['profile_image']['name'],
                'type' => $_FILES['profile_image']['type'],
                'tmp_name' => $_FILES['profile_image']['tmp_name'],
                'error' => $_FILES['profile_image']['error'],
                'size' => $_FILES['profile_image']['size']
                );
                $random_hash = substr(str_shuffle(time()), 0, 3) . strrev(mt_rand(100000, 999999));
                $extension = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
                $config['file_name'] = 'MI_' . $random_hash . '.' . $extension;
                $this->upload->initialize($config);
                $this->upload->do_upload('profile_image');
                $upload_data = $this->upload->data();
                // Make thumbnail image
                $this->load->library('image_lib');
                $config['image_library'] = 'gd2';
                $config['source_image'] = FCPATH . 'attachments/profile_image/' . $upload_data['file_name'];
                $config['create_thumb'] = TRUE;
                $config['maintain_ratio'] = FALSE;
                $config['width'] = 150;
                $config['height'] = 150;
                $config['new_image'] = FCPATH . 'attachments/profile_image/thumb/' . $upload_data['file_name'];
                $this->image_lib->initialize($config);
                $this->image_lib->resize();
                $profile_image = $upload_data['file_name'];
            }

            $user = $this->input->post('user');
            if (!empty($profile_image))
                $user['profile_image'] = $profile_image;
            if (empty($user['password']) || trim($user['password']) == '')
                unset($user['password']);
            else
                $user['password'] = md5($user['password']);
            $user['dob'] = date('Y-m-d', strtotime($user['dob']));
            $user['updated_date'] = date('Y-m-d H:i:s');
            $update = $this->members_model->update_member($user, $id);

            if (!empty($update)) {
                $this->session->set_flashdata('flashSuccess', 'User successfully updated!');
                redirect($this->config->item('base_url') . 'members/dashboard');
            }
        }
        $data['user'] = $this->members_model->get_member_by_id($id);
        $data['countries'] = $this->street_model->get_all_streets();
        $this->template->write_view('content', 'member_profile', $data);
        $this->template->render();
    }

    function delete($id) {

        $data = array ('is_deleted' => 1);
        $delete = $this->members_model->delete_member($id);
        if ($delete == 1) {
            $this->session->set_flashdata('flashSuccess', 'Member Successfully deleted!');
            echo '1';
        } else {
            $this->session->set_flashdata('flashError', 'Operation Failed!');
            echo '0';
        }
    }

    function users_ajaxList() {
        $search_data = array ();
        $search_data = $this->input->post();
        $list = $this->members_model->get_datatables($search_data);
        $data = array ();
        $no = $_POST['start'];
        foreach ($list as $ass) {
            $no++;
            $row = array ();
            $row[] = $no;
            $row[] = ucfirst($ass->firstname) . ' ' . ucfirst($ass->lastname);
            $row[] = $ass->username;
            $row[] = $ass->email_address;
            $row[] = $ass->group_name;
            $row[] = ucwords(str_replace('_', ' ', $ass->relation));
            $row[] = $ass->street_name;
            if ($ass->city == '1') {
                $city = 'Kayalpattinam';
            } else {
                $city = 'Others';
            }
            $row[] = $city;
            if ($ass->status == '1') {
                $status = '<span class="label label-success">Active</span>';
            } else {
                $status = '<span class="label label-default">Inactive</span>';
            }
            $row[] = $status;
            if ($this->user_auth->is_action_allowed('members', 'members', 'edit', 'delete')) {
                $row[] = '<a href="' . $this->config->item('base_url') . 'members/edit/' . $ass->id . '" title="Edit" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;<a href="javascript:void(0);" class="btn btn-danger btn-xs" onclick="delete_members(' . $ass->id . ')" title="Delete"><i class="glyphicon glyphicon-trash"></i></a>';
            }
            $data[] = $row;
        }

        $output = array (
        'draw' => $_POST['draw'],
        'recordsTotal' => $this->members_model->count_all(),
        'recordsFiltered' => $this->members_model->count_filtered($search_data),
        'data' => $data,
        );

        echo json_encode($output);
        exit;
    }

}
