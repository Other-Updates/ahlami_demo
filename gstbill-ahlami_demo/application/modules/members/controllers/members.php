<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Members extends MX_Controller {

    function __construct() {
        parent::__construct();

        if (!in_array($this->router->method, array('search_family', 'is_user_name_available', 'is_email_address_available', 'is_mobile_number_available', 'reset_password', 'get_family_type_by_street_id'))) {
            if (!$this->user_auth->is_logged_in()) {
                redirect($this->config->item('base_url') . 'users/login');
            }
        }

        $main_module = 'members';
        $access_arr = array(
            'members/index' => array('add', 'edit', 'delete', 'view'),
            'members/add' => array('add'),
            'members/edit' => array('edit'),
            'members/delete' => array('delete'),
            'members/my_profile' => 'no_restriction',
            'members/search_family' => 'no_restriction',
            'members/members_ajaxList' => 'no_restriction',
            'members/import_members' => 'no_restriction',
            'members/is_user_name_available' => 'no_restriction',
            'members/is_email_address_available' => 'no_restriction',
            'members/is_mobile_number_available' => 'no_restriction',
            'members/member_index' => 'no_restriction',
            'members/upload_members' => 'no_restriction',
            'members/reset_password' => 'no_restriction',
            'members/get_family_type_by_street_id' => 'no_restriction'
        );

        if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {
            redirect($this->config->item('base_url'));
        }
        $this->load->model('members/members_model');
        $this->load->model('members/group_model');
        $this->load->model('api/increment_model');
        $this->load->model('masters/street_model');
        $this->template->write_view('session_msg', 'users/session_msg');
        date_default_timezone_set($this->timezone->timezone());
    }

    function index() {
        $data = array();
        $data['title'] = 'Members - Manage Members';
        $data['members'] = $this->members_model->get_all_members();
        $this->template->write_view('content', 'members/index', $data);
        $this->template->render();
    }

    function add() {
        $data = array();
        $data['title'] = 'Members - Add New Member';
        if ($this->input->post('member')) {
            // Profile Picture
            $profile_image = NULL;
            $config['upload_path'] = './attachments/member_image/';
            $allowed_types = array('jpg', 'jpeg', 'png');
            $config['allowed_types'] = implode('|', $allowed_types);
            $config['max_size'] = '10000';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!empty($_FILES['profile_image']['name'])) {
                $_FILES['profile_image'] = array(
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
            $member['created_date'] = date('Y-m-d H:i:s');
            $user_type_id = $this->user_auth->get_user_id();
            $member['user_type_id'] = 2;
            $member['approved_status'] = 1;
            $insert_id = $this->members_model->insert_member($member);
            if (!empty($insert_id)) {
                $this->increment_model->update_increment_code('member_code');
                $this->session->set_flashdata('flashSuccess', 'New Member successfully added!');
                redirect($this->config->item('base_url') . 'members');
            } else {
                $this->session->set_flashdata('flashError', 'Member not added! Please try again');
                redirect($this->config->item('base_url') . 'members');
            }
        }

        $data['streets'] = $this->street_model->get_all_streets();
        $data['groups'] = $this->group_model->get_all_groups();
        $data['member_id'] = $this->increment_model->get_increment_code('member_code');
        $this->template->write_view('content', 'members/add_member', $data);
        $this->template->render();
    }

    function edit($id) {
        $data = array();
        $data['title'] = 'Members - Edit Member';

        if ($this->input->post('member')) {
            // Profile Picture
            $profile_image = NULL;
            $config['upload_path'] = './attachments/member_image/';
            $allowed_types = array('jpg', 'jpeg', 'png');
            $config['allowed_types'] = implode('|', $allowed_types);
            $config['max_size'] = '10000';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!empty($_FILES['profile_image']['name'])) {
                $_FILES['profile_image'] = array(
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
                redirect($this->config->item('base_url') . 'members');
            } else {
                $this->session->set_flashdata('flashError', 'Member not updated! Please try again.');
                redirect($this->config->item('base_url') . 'members');
            }
        }

        $data['member'] = $this->members_model->get_member_by_id($id);

        $data['groups'] = $this->members_model->get_all_groups_by_street($data['member'][0]['street_id']);

        $data['streets'] = $this->group_model->get_street_by_city($data['member'][0]['city']);

        $data['location'] = $this->members_model->get_user_checked_in_location($id);


        $this->template->write_view('content', 'members/edit_member', $data);
        $this->template->render();
    }

    function delete($id) {
        $id = $this->input->post('id');
        $delete = $this->members_model->delete_member($id);
        if ($delete == 1) {
            $this->session->set_flashdata('flashSuccess', 'Member successfully deleted!');
            echo '1';
        } else {
            $this->session->set_flashdata('flashError', 'Operation Failed!');
            echo '0';
        }
    }

    function my_profile() {
        $data = array();
        $id = $this->user_auth->get_user_id();
        $data['title'] = 'My Profile';

        if ($this->input->post('user')) {
            // Profile Picture
            $profile_image = NULL;
            $config['upload_path'] = './attachments/profile_image/';
            $allowed_types = array('jpg', 'jpeg', 'png');
            $config['allowed_types'] = implode('|', $allowed_types);
            $config['max_size'] = '10000';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!empty($_FILES['profile_image']['name'])) {
                $_FILES['profile_image'] = array(
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
            $update = $this->members_model->update_user($user, $id);
            if (!empty($update)) {
                $this->session->set_flashdata('flashSuccess', 'User successfully updated!');
                redirect($this->config->item('base_url'));
            }
        }
        $data['user'] = $this->members_model->get_member_by_id($id);
        $data['countries'] = $this->street_model->get_all_streets();

        $this->template->write_view('content', 'users/my_profile', $data);
        $this->template->render();
    }

    function search_family() {
        $mobile_number = $this->input->post('mobile_number');
        $result = $this->group_model->get_family_by_mobile_number($mobile_number);

        if (!empty($result['family_id'])) {
            $city = $result['city'];
            $street_id = $result['street_id'];
            $family_id = $result['family_id'];
            $streets = $this->street_model->get_streets_by_city_name($city);
            $family_types = $this->group_model->get_family_types_by_street_id($street_id);

            $response = array(
                'status' => 'success',
                'city' => $city,
                'street_id' => $street_id,
                'family_id' => $family_id,
                'streets' => $streets,
                'family_types' => $family_types
            );
            echo json_encode($response);
        } else {
            $response = array(
                'status' => 'error'
            );
            echo json_encode($response);
        }
    }

    function is_user_name_available() {
        $username = $this->input->post('username');

        $result = $this->members_model->is_user_available($username);
        echo json_encode($result);
    }

    function is_mobile_number_available() {
        $mobile = $this->input->post('mobile');
        $data = $this->members_model->is_mobile_number_available($mobile);
        echo json_encode($data);
    }

    function is_email_address_available() {
        $email = $this->input->post('email');

        $result = $this->members_model->is_email_address_available($email);
        echo json_encode($result);
    }

    function members_ajaxList() {
        $search_data = array();
        $search_data = $this->input->post();
        $list = $this->members_model->get_datatables($search_data);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $ass) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = ucfirst($ass->firstname) . ' ' . ucfirst($ass->lastname);
            $row[] = $ass->username;
            $row[] = $ass->email_address;
            $row[] = $ass->mobile_number;
            $row[] = $ass->group_name;
            $row[] = ucwords(str_replace('_', ' ', $ass->relation));
            $row[] = $ass->street_name;
            if ($ass->city == '1') {
                $city = 'Kayalpattinam';
            } else {
                $city = 'Others';
            }
            $row[] = $city;
            if ($ass->approved_status == '1') {
                $approved_status = '<span class="label label-success">Approved</span>';
            } elseif ($ass->approved_status == '0') {
                $approved_status = '<span class="label label-danger">Rejected</span>';
            } elseif ($ass->approved_status == '2') {
                $approved_status = '<span class="label label-default">Pending</span>';
            }
            $row[] = $approved_status;
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

        $output = array(
            'draw' => $_POST['draw'],
            'recordsTotal' => $this->members_model->count_all(),
            'recordsFiltered' => $this->members_model->count_filtered($search_data),
            'data' => $data,
        );

        echo json_encode($output);
        exit;
    }

    function upload_members() {
        $data = array();
        $data['title'] = 'Members - Import Members';

        $this->template->write_view('content', 'members/upload_members');
        $this->template->render();
    }

    function import_members() {
        $data = array();
        $data['title'] = 'Members - Import Members';

        if ($this->input->post()) {
            $skip_rows = $this->input->post('skip_rows');
            $skip_rows = 1;
            if (!empty($_FILES['member_data'])) {
                $config['upload_path'] = './attachement/csv/';
                $config['allowed_types'] = '*';
                $config['max_size'] = '10000';
                $this->load->library('upload', $config);
                $random_hash = substr(str_shuffle(time()), 0, 3) . strrev(mt_rand(100000, 999999));
                $extension = pathinfo($_FILES['member_data']['name'], PATHINFO_EXTENSION);
                $new_file_name = 'member_' . $random_hash . '.' . $extension;
                $_FILES['member_data'] = array(
                    'name' => $new_file_name,
                    'type' => $_FILES['member_data']['type'],
                    'tmp_name' => $_FILES['member_data']['tmp_name'],
                    'error' => $_FILES['member_data']['error'],
                    'size' => $_FILES['member_data']['size']
                );
                $config['file_name'] = $new_file_name;
                $this->upload->initialize($config);
                $this->upload->do_upload('member_data');
                $upload_data = $this->upload->data();
                $file_name = $upload_data['file_name'];
                $file = base_url() . 'attachement/csv/' . $file_name;
                $handle = fopen($_FILES['member_data']['tmp_name'], 'r') or die("can't open file");
                if ($file != NULL && $skip_rows > 0) {
                    $skipLines = $skip_rows;
                    $lineNum = 1;
                    if ($skipLines > 0) {
                        while (fgetcsv($handle)) {
                            if ($lineNum == $skipLines) {
                                break;
                            }
                            $lineNum++;
                        }
                    }
                }

                $count = 2;
                $member_insert = '';
                $email_arr = '';
                $email_count = '';
                $username_arr = '';
                $username_count = '';
                if ($file != NULL) {
                    while ($row_data = fgetcsv($handle)) {

                        $firstname_error = "";
                        $lastname_error = "";
                        $username_error = "";
                        $gender_error = "";
                        $email_error = "";
                        $pwd_error = "";
                        $dob_error = "";
                        $mbl_error = "";
                        $familyname_error = "";
                        $street_error = "";
                        $onkayal_error = "";
                        $address_error = "";
                        $city_error = "";

                        $first_name = $row_data[0];
                        $last_name = $row_data[1];
                        $user_name = $row_data[2];
                        $gender = lcfirst($row_data[3]);
                        $email_address = $row_data[4];
                        $password = $row_data[5];
                        $dob = $row_data[6];
                        $mobile_number = $row_data[7];
                        $city = $row_data[8];
                        $street = $row_data[9];

                        $family_name = $row_data[10];
                        $relation = $row_data[11];
                        $on_kayalpattinam = strtolower($row_data[12]);
                        if ($on_kayalpattinam == "out of kayalpattinam") {
                            $on_kayalpattinam = str_replace(' ', '_', $on_kayalpattinam);
                        } else {
                            $on_kayalpattinam = $on_kayalpattinam;
                        }
                        $current_address = $row_data[13];
                        $from_date = $row_data[14];
                        $to_date = $row_data[15];
                        $image = $row_data[16];

                        $path = FCPATH . "attachments/temp/";
                        $filename = $image;
                        $full_path = $path . $filename;

                        if (file_exists($full_path) && $filename != '') {
                            $random_hash = substr(str_shuffle(time()), 0, 3) . strrev(mt_rand(100000, 999999));
                            $extension = pathinfo($filename, PATHINFO_EXTENSION);
                            $img_name = 'MI_' . $random_hash . '.' . $extension;

                            $upload_path = './attachments/member_image/' . $img_name;
                            $upload_thumb = './attachments/member_image/thumb/' . $img_name;
                            $profile_image = $img_name;
                            copy($full_path, $upload_path);
                            copy($full_path, $upload_thumb);
                        } if (!file_exists($full_path) && $filename == '') {
                            $profile_image = '';
                        }


                        //date of birth
                        $date_of_birth = explode('.', $dob);
                        $dateof_birth = $date_of_birth[2] . "-" . $date_of_birth[1] . "-" . $date_of_birth[0];

                        //check required field
                        $firstname_error = $this->check_data_required($first_name, $count);
                        $lastname_error = $this->check_data_required($last_name, $count);
                        $username_error = $this->check_data_required($user_name, $count);
                        $gender_error = $this->check_data_required($gender, $count);
                        $email_error = $this->check_data_required($email_address, $count);
                        $pwd_error = $this->check_data_required($password, $count);
                        $dob_error = $this->check_data_required($dob, $count);
                        $mbl_error = $this->check_data_required($mobile_number, $count);
                        $familyname_error = $this->check_data_required($family_name, $count);
                        $relation_error = $this->check_data_required($relation, $count);
                        $city_error = $this->check_data_required($city, $count);
                        $street_error = $this->check_data_required($street, $count);
                        $onkayal_error = $this->check_data_required($on_kayalpattinam, $count);
                        $address_error = $this->check_data_required($current_address, $count);
                        $image_error = $this->check_data_required($image, $count);
                        //check duplicate records
                        if (in_array($email_address, $email_arr)) {
                            $email_count[] = $count;
                        } else {
                            $email_arr[] = $email_address;
                        }

                        if (in_array($user_name, $username_arr)) {
                            $username_count[] = $count;
                        } else {
                            $username_arr[] = $user_name;
                        }

                        //unique check
                        $username_uniq_error = '';
                        $email_uniq_error = '';
                        $phn_no_error = '';
                        if ($username_error == 0) {
                            $user_name_exits = $this->members_model->is_user_name_exist($user_name);
                            if ($user_name_exits) {
                                $username_uniq_error = $this->check_unique_data($user_name_exits, $count);
                            }
                        }
                        if ($email_error == 0) {
                            $email_exits = $this->members_model->is_email_exist($email_address);
                            if ($email_exits) {
                                $email_uniq_error = $this->check_unique_data($email_exits, $count);
                            }
                        }
                        if ($mbl_error == 0) {
                            $phn_no_exits = $this->members_model->is_phn_no_exist($mobile_number);
                            if ($phn_no_exits) {
                                $phn_no_error = $this->check_unique_data($phn_no_exits, $count);
                            }
                        }

                        //check valid datas
                        $mbl_valid_error = '';
                        $email_valid_error = '';
                        if ($phn_no_error == 0) {
                            $chk_valid_phn_no = $this->members_model->valid_phone_number($mobile_number);
                            if (empty($chk_valid_phn_no)) {
                                $mbl_valid_error = $this->check_unique_data($mobile_number, $count);
                            }
                        }
                        if ($email_uniq_error == 0) {
                            $chk_valid_email = $this->members_model->valid_email($email_address);
                            if (empty($chk_valid_email)) {
                                $email_valid_error = $this->check_unique_data($email_address, $count);
                            }
                        }
                        $member = '';
                        if ($city == 'Kayalpattinam') {
                            $member['city'] = 1;
                        } else {
                            $member['city'] = 2;
                        }

                        //check street name available
                        $street_valid_error = '';
                        if ($street_error == 0) {
                            $check_street_name = $this->members_model->check_street_name_available($street, $member['city']);
                            if (empty($check_street_name)) {
                                $street_valid_error = $this->check_unique_data($street, $count);
                            }
                        }

                        //check family name available
                        $family_valid_error = '';
                        if ($familyname_error == 0) {
                            $check_family_name = $this->members_model->check_family_name_available($family_name, $member['city'], $check_street_name[0]['id']);
                            if (empty($check_family_name)) {
                                $family_valid_error = $this->check_unique_data($family_name, $count);
                            }
                        }
                        //check relation available
                        $relation_valid_error = '';
                        if ($relation_error == 0) {
                            $check_relation = $this->members_model->check_relation_available($relation);
                            if (empty($check_relation)) {
                                $relation_valid_error = $this->check_unique_data($relation, $count);
                            }
                        }
                        $from_date_error = '';
                        $to_date_error = '';
                        //check Onkayal Duration available
                        $onkayal_valid_error = '';
                        if ($onkayal_error == 0) {
                            $check_onkayal = $this->members_model->check_onkayal_available($on_kayalpattinam);
                            if (empty($check_onkayal)) {
                                $onkayal_valid_error = $this->check_unique_data($on_kayalpattinam, $count);
                            } else {
                                if ($check_onkayal == 'temporary') {
                                    $from_date_error = $this->check_data_required($from_date, $count);
                                    $to_date_error = $this->check_data_required($to_date, $count);
                                }
                            }
                        }

                        if (($firstname_error == 0) && ($lastname_error == 0) && ($username_error == 0) && ($username_uniq_error == 0) && ($gender_error == 0) && ($email_error == 0) && ($email_uniq_error == 0) && ($email_valid_error == 0) && ($pwd_error == 0) && ($dob_error == 0) && ($mbl_error == 0) && ($phn_no_error == 0) && ($mbl_valid_error == 0) && ($familyname_error == 0) && ($family_valid_error == 0) && ($relation_error == 0) && ($relation_valid_error == 0) && ($street_error == 0) && ($street_valid_error == 0) && ($onkayal_error == 0) && ($onkayal_valid_error == 0) && ($address_error == 0)) {

                            $member['firstname'] = $first_name;
                            $member['lastname'] = $last_name;
                            $member['username'] = $user_name;
                            $member['password'] = $password;
                            $member['dob'] = $dateof_birth;
                            $member['gender'] = $gender;
                            $member['email_address'] = $email_address;
                            $member['mobile_number'] = $mobile_number;
                            $member['on_kayalpattinam'] = $on_kayalpattinam;
                            $member['address_line_2'] = $current_address;
                            $member['relation'] = $relation;
                            if ($on_kayalpattinam == 'temporary' && $from_date != '' && $to_date != '') {

                                $dfrom = explode('.', $from_date);
                                $duration_from = $dfrom[2] . "-" . $dfrom[1] . "-" . $dfrom[0];
                                $dto = explode('.', $to_date);
                                $duration_to = $dto[2] . "-" . $dto[1] . "-" . $dto[0];
                            } else {
                                $duration_from = '';
                                $duration_to = '';
                            }
                            $member['duration_from'] = $duration_from;
                            $member['duration_to'] = $duration_to;
                            $member['family_id'] = $check_family_name[0]['id'];
//                            if ($city == 'Kayalpattinam') {
//                                $member['city'] = 1;
//                            } else {
//                                $member['city'] = 2;
//                            }

                            $member['street_id'] = $check_street_name[0]['id'];
                            $member_id = $this->increment_model->get_increment_code('member_code');
                            $member['member_id'] = $member_id;
                            $member['profile_image'] = $profile_image;
                            $member['user_type_id'] = 2;
                            $member['approved_status'] = 1;
                            $member_insert[] = $member;
                        }

                        //required error
                        if ($firstname_error != 0)
                            $first_name_mssage[] = $firstname_error;
                        if ($lastname_error != 0)
                            $last_name_mssage[] = $lastname_error;
                        if ($username_error != 0)
                            $user_name_mssage[] = $username_error;
                        if ($gender_error != 0)
                            $gender_mssage[] = $gender_error;
                        if ($email_error != 0)
                            $email_mssage[] = $email_error;
                        if ($pwd_error != 0)
                            $pwd_mssage[] = $pwd_error;
                        if ($dob_error != 0)
                            $dob_mssage[] = $dob_error;
                        if ($mbl_error != 0)
                            $mbl_mssage[] = $mbl_error;
                        if ($familyname_error != 0)
                            $familyname_mssage[] = $familyname_error;
                        if ($relation_error != 0)
                            $relation_mssage[] = $relation_error;
                        if ($street_error != 0)
                            $street_mssage[] = $street_error;
                        if ($city_error != 0)
                            $city_mssage[] = $city_error;
                        if ($onkayal_error != 0)
                            $onkayal_mssage[] = $onkayal_error;
                        if ($address_error != 0)
                            $address_mssage[] = $address_error;
                        if ($from_date_error != 0)
                            $from_date_mssage[] = $from_date_error;
                        if ($to_date_error != 0)
                            $to_date_mssage[] = $to_date_error;

                        //Unique error
                        if ($username_uniq_error != 0)
                            $username_uniq_msg[] = $username_uniq_error;
                        if ($email_uniq_error != 0)
                            $email_uniq_msg[] = $email_uniq_error;
                        if ($phn_no_error != 0)
                            $phn_no_uniq_msg[] = $phn_no_error;

                        //Valid error
                        if ($mbl_valid_error != 0)
                            $phn_no_valid_msg[] = $mbl_valid_error;
                        if ($email_valid_error != 0)
                            $email_valid_msg[] = $email_valid_error;

                        //street name error
                        if ($street_valid_error != 0) {
                            $street_name_msg[] = $street_valid_error;
                        }
                        //city error
                        if ($city_valid_error != 0) {
                            $city_name_msg[] = $city_valid_error;
                        }
                        //family name error
                        if ($family_valid_error != 0) {
                            $family_name_msg[] = $family_valid_error;
                        }
                        //Relation name error
                        if ($relation_valid_error != 0) {
                            $relation_name_msg[] = $relation_valid_error;
                        }
                        //on kayalpattinam error
                        if ($onkayal_valid_error != 0) {
                            $onkayal_msg[] = $onkayal_valid_error;
                        }

                        $count++;
                    }

                    $message = "";
                    //required msg error
                    if ($first_name_mssage) {
                        $firstname_err = implode(', ', $first_name_mssage);
                        $message[] = 'First Name Required in rows - ' . $firstname_err . '<br>';
                    }
                    if ($last_name_mssage) {
                        $lastname_err = implode(', ', $last_name_mssage);
                        $message[] = 'Last Name Required in rows - ' . $lastname_err . '<br>';
                    }
                    if ($user_name_mssage) {
                        $username_err = implode(', ', $user_name_mssage);
                        $message[] = 'User Name Required in rows - ' . $username_err . '<br>';
                    }
                    if ($gender_mssage) {
                        $gender_err = implode(', ', $gender_mssage);
                        $message[] = 'Gender Required in rows - ' . $gender_err . '<br>';
                    }
                    if ($email_mssage) {
                        $email_err = implode(', ', $email_mssage);
                        $message[] = 'Email Address Required in rows - ' . $email_err . '<br>';
                    }
                    if ($pwd_mssage) {
                        $pwd_err = implode(', ', $pwd_mssage);
                        $message[] = 'Password Required in rows - ' . $pwd_err . '<br>';
                    }
                    if ($dob_mssage) {
                        $dob_err = implode(', ', $dob_mssage);
                        $message[] = 'DOB Required in rows - ' . $dob_err . '<br>';
                    }
                    if ($mbl_mssage) {
                        $mbl_err = implode(', ', $mbl_mssage);
                        $message[] = 'Mobile Number Required in rows - ' . $mbl_err . '<br>';
                    }
                    if ($from_date_mssage) {
                        $from_date_err = implode(', ', $from_date_mssage);
                        $message[] = 'From Date Required in rows - ' . $from_date_err . '<br>';
                    }
                    if ($to_date_mssage) {
                        $to_date_err = implode(', ', $to_date_mssage);
                        $message[] = 'To Date Required in rows - ' . $to_date_err . '<br>';
                    }
                    if ($familyname_mssage) {
                        $familyname_err = implode(', ', $familyname_mssage);
                        $message[] = 'Family Name Required in rows - ' . $familyname_err . '<br>';
                    }
                    if ($relation_mssage) {
                        $relation_err = implode(', ', $relation_mssage);
                        $message[] = 'Relation Required in rows - ' . $relation_err . '<br>';
                    }
                    if ($street_mssage) {
                        $street_err = implode(', ', $street_mssage);
                        $message[] = 'Street Required in rows - ' . $street_err . '<br>';
                    }
                    if ($city_mssage) {
                        $city_err = implode(', ', $city_mssage);
                        $message[] = 'City Required in rows - ' . $city_err . '<br>';
                    }
                    if ($onkayal_mssage) {
                        $onkayal_err = implode(', ', $onkayal_mssage);
                        $message[] = 'On Kayalpattinam Required in rows - ' . $onkayal_err . '<br>';
                    }
                    if ($address_mssage) {
                        $address_err = implode(', ', $address_mssage);
                        $message[] = 'Address Required in rows - ' . $address_err . '<br>';
                    }

                    //duplicate datas
                    $duplicate_username = '';
                    if ($username_count) {
                        $duplicate_username = implode(', ', $username_count);
                        $message[] = 'Duplicate Username found in rows - ' . $duplicate_username;
                    }
                    $duplicate_email = '';
                    if ($email_count) {
                        $duplicate_email = implode(', ', $email_count);
                        $message[] = 'Duplicate Email found in rows - ' . $duplicate_email;
                    }

                    //unique msg error
                    if ($username_uniq_msg) {
                        $username_uniq_err = implode(', ', $username_uniq_msg);
                        $message[] = 'User Name already exits in rows - ' . $username_uniq_err . '<br>';
                    }
                    if ($email_uniq_msg) {
                        $email_uniq_err = implode(', ', $email_uniq_msg);
                        $message[] = 'Email already exits in rows - ' . $email_uniq_err . '<br>';
                    }
                    if ($phn_no_uniq_msg) {
                        $phn_no_uniq_err = implode(', ', $phn_no_uniq_msg);
                        $message[] = 'Mobile number already exits in rows - ' . $phn_no_uniq_err . '<br>';
                    }
                    //valid msg error
                    if ($phn_no_valid_msg) {
                        $phn_no_valid_err = implode(', ', $phn_no_valid_msg);
                        $message[] = 'Please enter valid Mobile number in rows - ' . $phn_no_valid_err . '<br>';
                    }
                    if ($email_valid_msg) {
                        $email_valid_err = implode(', ', $email_valid_msg);
                        $message[] = 'Please enter valid Email address in rows - ' . $email_valid_err . '<br>';
                    }
                    //street name error
                    if ($street_name_msg) {
                        $street_name_err = implode(', ', $street_name_msg);
                        $message[] = 'Please enter valid street name in rows - ' . $street_name_err . '<br>';
                    }
                    //family name error
                    if ($family_name_msg) {
                        $family_name_err = implode(', ', $family_name_msg);
                        $message[] = 'Please enter valid Family name in rows - ' . $family_name_err . '<br>';
                    }
                    //Relation name error
                    if ($relation_name_msg) {
                        $relation_name_err = implode(', ', $relation_name_msg);
                        $message[] = 'Please enter valid Relation in rows - ' . $relation_name_err . '<br>';
                    }
                    // on kayalpattinam error
                    if ($onkayal_msg) {
                        $onkayal_name_err = implode(', ', $onkayal_msg);
                        $message[] = 'Please enter valid live duration in rows - ' . $onkayal_name_err . '<br>';
                    }
                }
            }
            if ($message) {
                $this->session->set_flashdata('file_upload', $message);
            } else {
                foreach ($member_insert as $key => $insert_value) {
                    $member_id = $this->increment_model->get_increment_code('member_code');
                    $insert_value['member_id'] = $member_id;
                    $insert_id = $this->members_model->insert_member($insert_value);
                    if (!empty($insert_id)) {
                        $this->increment_model->update_increment_code('member_code');
                        $this->db->close();
                        $this->db->initialize();
                    }
                }
                $this->session->set_flashdata('success', 'File uploaded successfully');
            }
            redirect($this->config->item('base_url') . 'members/upload_members ');
        }
    }

    function check_data_required($data, $count) {
        if (empty($data)) {
            return $count;
        } else {
            return 0;
        }
    }

    function check_unique_data($data, $count) {
        if (!empty($data)) {
            return $count;
        } else {
            return 0;
        }
    }

    function get_family_type_by_street_id($street_id) {

        $family = $this->members_model->get_family_by_street($street_id);
        if ($family != 0) {
            echo json_encode($family);
        }
    }

    function reset_password() {
        $data = array();
        $data['title'] = 'Users - Forget Password';
        if ($this->input->post('member')) {
            $forget_password = $this->input->post('member');
            $email_address = $forget_password['email_address'];
            $mobile_number = $forget_password['mobile_number'];

            $confirmation_code = $forget_password['confirmation_code'];
            $id = $forget_password['id'];
            $time = $forget_password['time'];
            $p_status = $forget_password['p_status'];
            if(!empty($confirmation_code)){
                $this->load->model('users/users_model');
                $current_time = date('H:i:s');
                $expire_time = strtotime("+15 minutes", strtotime($time));
                if($p_status != ''){
                    $this->session->set_flashdata('flashError', 'Passowrd Already Recovered');
                    redirect($this->config->item('base_url') . 'users/users/forget_password/'.$confirmation_code.'/'.$p_status);
                    exit;
                }
                if(strtotime($expire_time) < strtotime($current_time) ){
                    $this->session->set_flashdata('flashError', 'Passowrd Recovery Time was Expired');
                    redirect($this->config->item('base_url') . 'users/users/forget_password/'.$confirmation_code);
                    exit;
                }else{
                    $check_user_has_code = $this->users_model->check_customer_code($id,$mobile_number,'',$email_address);
                    if (!$check_user_has_code) {
                        $this->session->set_flashdata('flashError', 'Incorrect details! Please try again.!');
                        redirect($this->config->item('base_url') . 'users/users/forget_password/'.$confirmation_code);
                        exit;
                    }
                    $reset_password['password'] = md5($forget_password['password']);
                    $reset_password['plain_password'] = ($forget_password['password']);
                    $reset_password['updated_at'] = date('Y-m-d H:i:s');
                    $reset_password['confirmation_code'] = '';
                    $this->users_model->update_customer($reset_password, $id);
                    $this->session->set_flashdata('flashSuccess', 'Password Reset successfully !');
                    redirect($this->config->item('base_url') . 'users/users/forget_password/'.$confirmation_code.'/'.base64_encode('success'));
                    exit;
                }
            }else{

            
            $data['chk_mob_mail'] = $this->members_model->chk_mobile_mail_exists($email_address, $mobile_number);

            $id = $data['chk_mob_mail'][0]['id'];


            if (!empty(trim($forget_password['password'])))
                $reset_password['password'] = md5($forget_password['password']);
            else
                unset($reset_password['password']);
            $reset_password['updated_at'] = date('Y-m-d H:i:s');

            if ($data['chk_mob_mail'] != 0) {

                $update = $this->members_model->update_member($reset_password, $id);
            }
            if ($data['chk_mob_mail'] == 0) {
                $this->session->set_flashdata('flashError', 'Incorrect details! Please try again.!');
                redirect($this->config->item('base_url') . 'users/users/forget_password');
            }
            if ($update == 1) {
                $this->session->set_flashdata('flashSuccess', 'Password Reset successfully !');
                redirect($this->config->item('base_url') . 'users/users/login');
            } else {
                $this->session->set_flashdata('flashError', 'Password not Reset! Please try again.!');
                redirect($this->config->item('base_url') . 'users/users/forget_password');
            }
        }
        }

        $this->template->write_view('content', 'users/forget_password', $data);
        $this->template->render();
    }

}
