<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Users extends MX_Controller {

    function __construct() {
        parent::__construct();
        if (!in_array($this->router->method, array ('login', 'logout', 'register', 'forget_password'))) {
            if (!$this->user_auth->is_logged_in()) {
                redirect($this->config->item('base_url') . 'users/login');
            }
        }

        $main_module = 'users';
        $access_arr = array (
        'users/index' => array ('add', 'edit', 'delete', 'view'),
        'users/add' => array ('add'),
        'users/edit' => array ('edit'),
        'users/delete' => array ('delete'),
        'users/my_profile' => array ('view'),
        'users/register' => 'no_restriction',
        'users/is_user_name_available' => 'no_restriction',
        'users/is_email_address_available' => 'no_restriction',
        'users/is_mobile_number_available' => 'no_restriction',
        'users/login' => 'no_restriction',
        'users/logout' => 'no_restriction',
        'users/forget_password' => 'no_restriction',
        'users/session_data' => 'no_restriction'
        );

        if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {
            redirect($this->config->item('base_url'));
        }

        $this->load->model('users/users_model');
        $this->load->model('users/user_type_model');
        $this->load->model('api/increment_model');
        $this->load->model('masters/street_model');
        $this->load->model('members/members_model');
        $this->load->model('members/group_model');
        $this->template->write_view('session_msg', 'users/session_msg');
        date_default_timezone_set($this->timezone->timezone());
    }

    function index() {
        $data = array ();
        $data['title'] = 'Users - Manage Users';
        $data['users'] = $this->users_model->get_all_users();
        $this->template->write_view('content', 'users/index', $data);
        $this->template->render();
    }

    function add() {
        $data = array ();
        $data['title'] = 'Users - Add New User';
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
                $config['file_name'] = 'PI_' . $random_hash . '.' . $extension;
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
                $profile_image = base_url() . 'attachments/profile_image/' . $upload_data['file_name'];
            }

            $user = $this->input->post('user');
            $dob = explode(' ', $user['dob']);
            $date = explode('/', $dob[0]);
            $dob_date = $date[2] . '-' . $date[1] . '-' . $date[0];
            if (!empty($profile_image))
                $user['profile_image'] = $profile_image;
            $user['password'] = md5($user['password']);
            $user['dob'] = $dob_date;
            $user['user_id'] = $this->increment_model->get_increment_code('user_code');
            $user['created_date'] = date('Y-m-d H:i:s');
            $insert_id = $this->users_model->insert_user($user);
            if (!empty($insert_id)) {
                $this->increment_model->update_increment_code('user_code');
                $this->session->set_flashdata('flashSuccess', 'New User successfully added!');
                redirect($this->config->item('base_url') . 'users');
            }
        }
        $data['user_types'] = $this->user_type_model->get_all_user_types();
        $data['user_id'] = $this->increment_model->get_increment_code('user_code');
        $this->template->write_view('content', 'users/add_user', $data);
        $this->template->render();
    }

    function edit($id) {
        $data = array ();
        $data['title'] = 'Users - Edit User';

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
                $config['file_name'] = 'PI_' . $random_hash . '.' . $extension;
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
                $profile_image = base_url() . 'attachments/profile_image/' . $upload_data['file_name'];
            }

            $user = $this->input->post('user');
            $dob = explode(' ', $user['dob']);
            $date = explode('/', $dob[0]);
            $dob_date = $date[2] . '-' . $date[1] . '-' . $date[0];
            if (!empty($profile_image))
                $user['profile_image'] = $profile_image;
            if (empty($user['password']) || trim($user['password']) == '')
                unset($user['password']);
            else
                $user['password'] = md5($user['password']);
            $user['dob'] = $dob_date;
            $user['updated_date'] = date('Y-m-d H:i:s');
            $update = $this->users_model->update_user($user, $id);
            if (!empty($update)) {
                $this->session->set_flashdata('flashSuccess', 'User successfully updated!');
                redirect($this->config->item('base_url') . 'users');
            }
        }
        $data['user_types'] = $this->user_type_model->get_all_user_types();
        $data['user'] = $this->users_model->get_user_by_id($id);

        $this->template->write_view('content', 'users/edit_user', $data);
        $this->template->render();
    }

    function delete($id) {
        $id = $this->input->post('id');
        $delete = $this->users_model->delete_user($id);
        if ($delete == 1) {
            $this->session->set_flashdata('flashSuccess', 'User successfully deleted!');
            echo '1';
        } else {
            $this->session->set_flashdata('flashError', 'Operation Failed!');
            echo '0';
        }
    }

    function my_profile() {
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
                $config['file_name'] = 'PI_' . $random_hash . '.' . $extension;
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
                $profile_image = base_url() . 'attachments/profile_image/' . $upload_data['file_name'];
            }

            $user = $this->input->post('user');
            $dob = explode(' ', $user['dob']);
            $date = explode('/', $dob[0]);
            $dob_date = $date[2] . '-' . $date[1] . '-' . $date[0];
            if (!empty($profile_image))
                $user['profile_image'] = $profile_image;
            if (empty($user['password']) || trim($user['password']) == '')
                unset($user['password']);
            else
                $user['password'] = md5($user['password']);
            $user['dob'] = $dob_date;
            $user['updated_date'] = date('Y-m-d H:i:s');
            $update = $this->users_model->update_user($user, $id);
            if (!empty($update)) {
                $this->session->set_flashdata('flashSuccess', 'User successfully updated!');
                redirect($this->config->item('base_url'));
            }
        }

        $data['user'] = $this->users_model->get_user_by_id($id);
        $this->template->write_view('content', 'users/my_profile', $data);
        $this->template->render();
    }

    function register() {
        $data = array ();
        $data['title'] = 'Users - Register New User';
        if ($this->input->post('member')) {
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
            $member['member_id'] = $this->increment_model->get_increment_code('member_code');
            $member['password'] = md5($member['password']);
            $member['dob'] = $dob_formatted;
            $member['duration_from'] = $dur_from_formatted;
            $member['duration_to'] = $dur_to_formatted;
            $member['created_date'] = date('Y-m-d H:i:s');
            $member['user_type_id'] = 2;
//            $member['approved_status'] = 1;
            $insert_id = $this->members_model->insert_member($member);
            if (!empty($insert_id)) {
                $this->increment_model->update_increment_code('member_code');
                $this->session->set_flashdata('flashSuccess', 'Member Registered successfully!');
                redirect($this->config->item('base_url') . 'users/login');
            }
        }
        $data['streets'] = $this->street_model->get_all_streets();
        $data['groups'] = $this->group_model->get_all_groups();
        $data['member_id'] = $this->increment_model->get_increment_code('member_code');
        $this->template->set_master_template('../../themes/scootero/template_register.php');
        $this->template->write_view('content', 'users/register', $data);
        $this->template->render();
    }

    function is_user_name_available() {
        $username = $this->input->post('username');
        $id = $this->input->post('id');
        $result = $this->users_model->is_user_available($username, $id);
        if (!empty($result[0]['id'])) {
            echo 'yes';
        } else {
            echo 'no';
        }
    }

    function is_email_address_available() {
        $email = $this->input->post('email');
        $id = $this->input->post('id');
        $result = $this->users_model->is_email_address_available($email, $id);
        if (!empty($result[0]['id'])) {
            echo 'yes';
        } else {
            echo 'no';
        }
    }

    function is_mobile_number_available() {
        $mobile = $this->input->post('mobile');
        $id = $this->input->post('id');
        $result = $this->users_model->is_mobile_number_available($mobile, $id);
        if (!empty($result[0]['id'])) {
            echo 'yes';
        } else {
            echo 'no';
        }
    }

    function login($status = NULL) {
        $data = array ();
        $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
        if ($this->form_validation->run()) {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $location_info = $this->input->post('location_info');
            $location_info['updated_date'] = date('Y-m-d H:i:s');
            $result = $this->user_auth->login($username, $password, $location_info);
            if (isset($result['status']) && $result['status'] == 'success') {
                $user_type = $result['user_type'];
                if ($user_type == 2) {
                    redirect($this->config->item('base_url') . 'members/dashboard');
                } else {
                    redirect($this->config->item('base_url'));
                }
            } else {
                $data = $this->session->set_flashdata('flashError', 'Invalid User', $data);
                redirect($this->config->item('base_url') . 'users/login?login=fail');
            }
        }
        $data['login_status'] = 'success';
        if (isset($status) && $status != NULL) {
            $data['status'] = $status;
        }
        if (isset($_REQUEST['login']) && $_REQUEST['login'] == 'fail') {
            $data['login_status'] = 'fail';
        }
        $this->template->set_master_template('../../themes/scootero/template_login.php');
        $this->template->write_view('content', 'users/login', $data);
        $this->template->render();
    }

    function logout($status = NULL) {
        $data = array ();
        $this->user_auth->logout();
        if (isset($status) && $status != NULL) {
            redirect($this->config->item('base_url') . 'users/login?inactive=true');
        }
        redirect($this->config->item('base_url') . 'users/login');
    }

    function session_data() {
        $session_data = $this->user_auth->get_from_session_table();
        $session_data = unserialize($session_data['user_data']);
        $app_name = $this->config->item('application_name');
        $session_data = $session_data[$app_name];
        $app_session = json_decode(json_encode($this->user_auth->cryptography('decrypt', $session_data)), true);
    }

    function forget_password($confirmation_code=NULL,$status=NULL) {
        $data = array ();
        $data['title'] = 'Users - Forget Password';
        $data['status']= $status;
        $data['confirmation_code']=$confirmation_code;
        if($confirmation_code != NULL && $status == NULL){
            $confirmation_code_decode = base64_decode($confirmation_code);
            $code_split_array = explode('-',$confirmation_code_decode);
            $id = $code_split_array[0];
            $mobile_number = $code_split_array[1];
            $time = $code_split_array[2];
            $check_user_has_code = $this->users_model->check_customer_code($id,$mobile_number,$confirmation_code);
            if($check_user_has_code){
                $data['customers'] = $check_user_has_code;
            }else{
                $data['customers'] = '';
            }
            $data['expire']=0;
            $data['id']=$id;
            $data['time']=$time;
            $data['current_time']= $current_time = date('H:i:s');
            $data['confirmation_code']=$confirmation_code;
             $expire_time = strtotime("+15 minutes", strtotime($time));
             $data['expire_time'] = date('H:i:s',$expire_time);
            if(strtotime($expire_time) < strtotime($current_time) ){
                $data['expire']=1;
                $this->session->set_flashdata('flashError', 'Passowrd Recovery Time was Expired');
            }elseif(!$data['customers']){
                $this->session->set_flashdata('flashError', 'Invalid Customer to Password Recovery');
            }
        }
        $this->template->set_master_template('../../themes/scootero/template_reset_password.php');
        $this->template->write_view('content', 'users/forget_password', $data);
        $this->template->render();
    }

}
