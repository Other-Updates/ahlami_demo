<?php

if (!defined('BASEPATH'))
    echo 'No Direct Access Allowed';

Class Api extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('api/api_model');
        $this->load->model('api/increment_model');
        $this->load->model('masters/scootero_model');
        date_default_timezone_set($this->timezone->timezone());
        $json_input = file_get_contents('php://input', TRUE);
        $input_data = json_decode($json_input, TRUE);
        if($input_data['language'] == 'english' || $input_data['language'] == 'en'){
            $this->lang->load('general','english');
        }
        else if($input_data['language'] == 'arabic'|| $input_data['language'] == 'ar'){
            $this->lang->load('general','arabic');
        }
        else{
            $this->lang->load('general','english');
        }
        
        //$this->lang->line('GENERIC_PAYMENTS_CONTENT');
    }

    public function api_get_all_contents(){
        $all_lang_array=$this->lang->language;
        $output = array ('status' => 'success', 'message' => 'Language Contents','data'=>$all_lang_array);
        echo json_encode($output);
    }
    public function api_customer_registeration() {
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        if (!empty($json_input)) {
                $data = json_decode($json_input, TRUE);
                $check_duplicate_mobile = $this->api_model->check_field_exists('mobile_number',$data['mobile_number'],'','OTP');
                if($check_duplicate_mobile){
                    $output = array ('status' => 'Error', 'message' => 'Mobile Number Already Exists');
                    echo json_encode($output);
                    exit;
                }
                $check_duplicate_email = $this->api_model->check_field_exists('email',$data['email'],'','OTP');
                if($check_duplicate_email){
                    $output = array ('status' => 'Error', 'message' => 'Email Address Already Exists');
                    echo json_encode($output);
                    exit;
                }
                $customer_data['name'] = $data['name'];
                $customer_data['mobile_number'] = $data['mobile_number'];
                $customer_data['dob'] = ($data['dob'] != '') ? date('Y-m-d',strtotime($data['dob'])) : '';
                $customer_data['gender'] = ($data['gender'] > 0) ? (($data['gender'] == 'Male') ? 1 : 2) : 0;
                $customer_data['email'] = $data['email'];
                $customer_data['password'] = md5($data['password']);
                $customer_data['plain_password'] = $data['password'];
                $customer_data['otp_verify'] = 0;
                $customer_data['created_at']=date('Y-m-d h:i:s');
                $customer_data['is_google']=($data['isGoogle']) ? 1 : 0;
                $customer_data['google_id']=($data['isGoogle']) ? $data['googleid'] : 0;

                  //Generate OTP
                  $otp = $this->api_model->generateNumericOTP('4');
                  $htmlContent = "One Time OTP : ".$otp." ";

                $customer_data['otp_code']=$otp;
                $customer_id = $this->api_model->insert_customer_details($customer_data);

                //Wallet Updates
                $wallet_data['customer_id']=$customer_id;
                $wallet_data['amount']='0.00';
                $wallet_data['created_date']=date('Y-m-d H:i:s');
                $this->api_model->insert_customer_walltet($wallet_data);
                $this->api_model->sendSMS($data['mobile_number'],$htmlContent);

                $this->load->library('email');
                $config = array (
                'protocol' => 'mail',
                'charset' => 'utf-8',
                'wordwrap' => FALSE,
                'mailtype' => 'html'
                );
                $this->email->initialize($config);

                
                $this->email->from($this->config->item('default_from_email'), $this->config->item('default_email_name'));
                $this->email->to($data['email']);
                $this->email->subject('One Time Password');
                $this->email->message($htmlContent);
                $this->email->send();

                //$update_data['otp_code']=$otp;
               // $this->api_model->update_fields($customer_id,$update_data);
                //$customer_data= $this->api_model->check_login_details($data);

                
                
                if ($customer_id) {
                    $output = array ('status' => 'Success', 'message' => 'Customer registered successfully..OTP has been sent to registered email address','OTP'=>$otp,'customer_id'=>$customer_id);
                    echo json_encode($output);
                } else {
                    $output = array ('status' => 'Error', 'message' => 'Somthing went wrong');
                    echo json_encode($output);
                }
        } else {
            $output = array ('status' => 'error', 'message' => 'Please enter input data');
            echo json_encode($output);
        }
    }

    public function api_forget_password(){
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        if (!empty($json_input)) {
            $data = json_decode($json_input, TRUE);
                $result = $this->api_model->check_field_exists('mobile_number',$data['mobile_number']);
                if ($result) {
                    $output = array ('status' => 'Success', 'message' => 'Mobile number verified successfully','data'=>$result);
                    echo json_encode($output);
                } else {
                    $output = array ('status' => 'Error', 'message' => 'Invalid mobile number');
                    echo json_encode($output);
                }
        } else {
            $output = array ('status' => 'error', 'message' => 'Please mobile number and password');
            echo json_encode($output);
        }
    }
    public function api_send_otp(){
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        if (!empty($json_input)) {
            $data = json_decode($json_input, TRUE);
                $otp = $this->api_model->generateNumericOTP('4');
                if ($otp) {
                   // $update_data['otp_verify']=0;
                    $update_data['otp_code']=$otp;
                    $htmlContent = "One Time OTP : ".$otp." ";
                      $this->api_model->sendSMS($data['mobile_number'],$htmlContent);
      
                      $this->load->library('email');
                      $config = array (
                      'protocol' => 'mail',
                      'charset' => 'utf-8',
                      'wordwrap' => FALSE,
                      'mailtype' => 'html'
                      );
                      $this->email->initialize($config);
      
                      
                      $this->email->from($this->config->item('default_from_email'), $this->config->item('default_email_name'));
                      $this->email->to($data['email']);
                      $this->email->subject('One Time Password');
                      $this->email->message($htmlContent);
                      $this->email->send();

                    $this->api_model->update_fields($data['customer_id'],$update_data);
                    $output = array ('status' => 'Success', 'message' => 'Otp Send successfully','OTP'=>$otp);
                    echo json_encode($output);
                } else {
                    $output = array ('status' => 'Error', 'message' => 'Something went wrong');
                    echo json_encode($output);
                }
        } else {
            $output = array ('status' => 'error', 'message' => 'Please enter input data');
            echo json_encode($output);
        }
    }

    public function api_check_customer_otp(){
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        if (!empty($json_input)) {
            $data = json_decode($json_input, TRUE);
                $otp_result = $this->api_model->check_customer_otp($data);
                if ($otp_result) {
                    $update_data['otp_verify']=1;
                    $this->api_model->update_fields($otp_result['customer_id'],$update_data);
                    //Welcome Start
                        //SMs
                        $htmlContent = "Welcome!!! to our ScooterO";
                        $this->api_model->sendSMS($data['mobile_number'],$htmlContent);
                        //Email
                        $this->email->from($this->config->item('default_from_email'), $this->config->item('default_email_name'));
                        $this->email->to($data['email']);
                        $this->email->subject('Registration');
                        $this->email->message($htmlContent);
                        $this->email->send();
                    //Welcome End
                    $output = array ('status' => 'Success', 'message' => 'Otp Verified successfully','data'=>$otp_result);
                    echo json_encode($output);
                } else {
                    $output = array ('status' => 'Error', 'message' => 'Invalid OTP');
                    echo json_encode($output);
                }
        } else {
            $output = array ('status' => 'error', 'message' => 'Please mobile number and password');
            echo json_encode($output);
        }
    }
    public function api_generate_otp(){
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        if (!empty($json_input)) {
            $data = json_decode($json_input, TRUE);
                $field_data = $data['data'];
                $id=$data['id'];
                if($id != ''){
                    $cutsomer_details= $this->api_model->get_customer_profile_details(array('id'=>$id));
                    $data['mobile_number']=$cutsomer_details['mobile_number'];
                }
                $otp_code=$data['otp_code'];
                $is_exists = '';
                $txt = '';
                if($data['type']=="change mobile"){
                    $field_name = 'mobile_number';
                    $msg="Mobile number has been changed Successfully...!";
                    if(!$otp_code)
                        $is_exists = $this->api_model->check_field_exists('mobile_number',$data['mobile_number'],'','',$id);
                    $txt='Change Mobile Number';
                }
                if($data['type']=="change email"){
                    $field_name='email';
                    $msg='Email ID has been changed Successfully...!';
                    if(!$otp_code)
                        $is_exists = $this->api_model->check_field_exists('mobile_number',$data['mobile_number'],'','',$id);
                    $txt='Change Email Address';
                }
                if($data['type']=="forget password"){
                    $field_name='password';
                    $msg='Password has been changed Successfully...!';
                    $update_profile['password']=md5($data['data']);
                    $update_profile['plain_password']=($data['data']);
                    if(!$otp_code)
                        $is_exists = $this->api_model->check_field_exists('mobile_number',$data['mobile_number'],'','','');

                    $txt='Forget Password';
                }
                if(!$otp_code){
                    if ($is_exists) {
                        //Generate OTP
                       $otp = $this->api_model->generateNumericOTP('4');
                       $htmlContent = "One Time OTP : ".$otp." ";
                       $this->api_model->sendSMS($data['mobile_number'],$htmlContent);

                        //Email
                        $this->email->from($this->config->item('default_from_email'), $this->config->item('default_email_name'));
                        $this->email->to($data['email']);
                        $this->email->subject($txt);
                        $this->email->message($htmlContent);
                        $this->email->send();

                       $update_data['otp_code']=$otp;
                       $id = ($data['id']) ? $data['id'] : $is_exists['id'];
                       $this->api_model->update_fields($id,$update_data);
                       $output = array ('status' => 'Success', 'message' => 'Otp Send successfully','OTP'=>$otp,'id'=>$id);
                       echo json_encode($output);
                       exit;
                   }else{
                       $message = 'Invalid Details';
                        if($data['type'] =="forget password"){
                            $message = 'The mobile number which is enter is wrong (OR) not registered with us, please check the entered number and try again';
                        }
                       $output = array ('status' => 'Error', 'message' => $message);
                       echo json_encode($output);
                       exit;
                   }
                }else{
                    $is_exists = $this->api_model->check_field_exists('otp_code',$data['otp_code'],'','',$id);
                    if($is_exists){
                        $update_data = true;
                        if($data['type']!="forget password"){
                            $update_data = $this->api_model->update_profile_fields($id,$field_name,$field_data,$update_profile,'otp');
                        }
                        if ($update_data) {
                            if($data['type']=="forget password"){
                                $customer_data = $this->api_model->check_customer_otp('',$id);
                               
                                //Generate OTP
                               $otp = $this->api_model->generateNumericOTP('4');
                               $code = base64_encode($id.'-'.$data['mobile_number'].'-'.date('H:i:s'));

                               $this->api_model->update_profile_fields($id,'confirmation_code',$code,'','');

                               $url = base_url().'users/users/forget_password/'.$code;
                               $htmlContent = "<a href='".$url."' >Click here to reset password</a> ";
                               $this->api_model->sendSMS($data['mobile_number'],$htmlContent);
        
                                //Email
                                $this->email->from($this->config->item('default_from_email'), $this->config->item('default_email_name'));
                                $this->email->to($customer_data['email']);
                                $this->email->subject('Forget Password Recovery');
                                $this->email->message($htmlContent);
                                $this->email->send();
                                
                                $output = array ('status' => 'Success', 'message' => 'We have sent you a message with password reset link to your mobile and email, please click on the url and reset your password');
                            }else{
                                $output = array ('status' => 'Success', 'message' => ''.$msg.'');
                            }
                            echo json_encode($output);
                        } else {
                            $output = array ('status' => 'Error', 'message' => 'Somthing went wrong');
                            echo json_encode($output);
                        }
                    }else{
                        $output = array ('status' => 'Error', 'message' => 'Invalid OTP');
                        echo json_encode($output);
                    }
                    
                } 
        } else {
            $output = array ('status' => 'error', 'message' => 'Please enter input data');
            echo json_encode($output);
        }
    }
    public function api_change_new_password() {
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        if (!empty($json_input)) {
            $data = json_decode($json_input, TRUE);
                $is_exists = $this->api_model->check_field_exists('plain_password',$data['old_password'],'','',$data['id']);
                if ($is_exists != '') {
                    $update_data['password']=md5($data['new_password']);
                    $update_data['plain_password']=$data['new_password'];
                    $this->api_model->update_fields($data['id'],$update_data);
                    $output = array ('status' => 'Success', 'message' => 'Password updated successfully');
                    echo json_encode($output);
                }else{
                    $output = array ('status' => 'Error', 'message' => 'Invalid old password');
                    echo json_encode($output);
                    exit;
                }
               
        } else {
            $output = array ('status' => 'error', 'message' => 'Please enter password');
            echo json_encode($output);
        }
    }

    public function api_customer_login(){
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        if (!empty($json_input)) {
            $data = json_decode($json_input, TRUE);
                $login_result = $this->api_model->check_login_details($data);
                if ($login_result) {
                    if($login_result == 1){
                        $output = array ('status' => 'Error', 'message' => 'OTP not verified');
                        echo json_encode($output);
                    }else{
                        $output = array ('status' => 'Success', 'message' => 'Login successfully','data'=>$login_result);
                        echo json_encode($output);
                    }
                   
                } else {
                    $output = array ('status' => 'Error', 'message' => 'Invalid login credentials');
                    echo json_encode($output);
                }
        } else {
            $output = array ('status' => 'error', 'message' => 'Please mobile number and password');
            echo json_encode($output);
        }
    }

    public function api_get_scooter_details(){
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        if (!empty($json_input)) {
            $data = json_decode($json_input, TRUE);
                $scooter = $this->api_model->get_scooter_info();
                if ($scooter) {
                    $output = array ('status' => 'Success', 'message' => 'Scooter details','data'=>$scooter);
                    echo json_encode($output);
                } else {
                    $output = array ('status' => 'Error', 'message' => 'Scooter details not found');
                    echo json_encode($output);
                }
        } else {
            $output = array ('status' => 'error', 'message' => 'Please enter input data');
            echo json_encode($output);
        }
    }

    public function api_profile_details(){
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        if (!empty($json_input)) {
            $data = json_decode($json_input, TRUE);
                $profile = $this->api_model->get_customer_profile_details($data);
                if ($profile) {
                    $output = array ('status' => 'Success', 'message' => 'Profile details','data'=>$profile);
                    echo json_encode($output);
                } else {
                    $output = array ('status' => 'Error', 'message' => 'Profile details not found');
                    echo json_encode($output);
                }
        } else {
            $output = array ('status' => 'error', 'message' => 'Please enter input data');
            echo json_encode($output);
        }
    }
    public function api_update_profile_details(){
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        if (!empty($json_input)) {
            $data = json_decode($json_input, TRUE);
                $customer_data['name'] = $data['name'];
                $customer_data['dob'] = ($data['dob'] != '') ? date('Y-m-d',strtotime($data['dob'])) : '';
                $customer_data['gender'] = ($data['gender'] > 0) ? (($data['gender'] == 'Male') ? 1 : 2) : 0;
                $customer_data['email'] = $data['email'];
                $check_duplicate_email = $this->api_model->check_field_exists('email',$data['email'],$data['id']);
                if($check_duplicate_email){
                    $output = array ('status' => 'Error', 'message' => 'Email Address Already Exists');
                    echo json_encode($output);
                    exit;
                }
                $profile = $this->api_model->update_fields($data['id'],$customer_data);
                if ($profile) {
                    $update_data = $this->api_model->check_customer_otp('',$data['id']);
                    $output = array ('status' => 'Success', 'message' => 'Profile details updated','data'=>$update_data);
                    echo json_encode($output);
                } else {
                    $output = array ('status' => 'Error', 'message' => 'Profile details not updated');
                    echo json_encode($output);
                }
        } else {
            $output = array ('status' => 'error', 'message' => 'Please enter input data');
            echo json_encode($output);
        }
    }

    public function scan_qr_code(){
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        if (!empty($json_input)) {
            $data = json_decode($json_input, TRUE);
                $scootoro = $this->api_model->unlock_scootoro($data['id'],$data['qr_code']);
                if ($scootoro) {
                    if($scootoro != 1){
                        $check_position = $this->scootero_model->check_scootero_position($data['scoo_lat'],$data['scoo_long'],$scootoro['scooter_id']);
                        if(!$check_position){
                            //Scootero Position Updates
                            $insert_data['scootero_id']=$scootoro['scooter_id'];
                            $insert_data['scoo_lat']=$data['scoo_lat'];
                            $insert_data['scoo_long']=$data['scoo_long'];
                            $insert_data['customer_id']=$data['customer_id'];
                            $insert_data['is_current_position']=1;
                            $this->scootero_model->insert_scooterO_history($insert_data);
                            $this->scootero_model->update_scooterO(array("scoo_lat"=>$data['scoo_lat'],"scoo_long"=>$data['scoo_long']),$data['id']);
                        }
                        $output = array ('status' => 'Success', 'message' => 'Scootoro unlocked successfully','scootoro_details'=>$scootoro);
                        echo json_encode($output);
                    }else{
                        $output = array ('status' => 'Error', 'message' => 'Scootoro already unlocked');
                        echo json_encode($output);
                    }
                } else {
                    $output = array ('status' => 'Error', 'message' => 'Scootoro not exists');
                    echo json_encode($output);
                }
        } else {
            $output = array ('status' => 'error', 'message' => 'Please enter input data');
            echo json_encode($output);
        }
    }
    public function api_subscription_plan(){
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        if (!empty($json_input)) {
            $data = json_decode($json_input, TRUE);
                $subscriptions = $this->api_model->get_subscriptions_plan();
                $settings = $this->api_model->getSettings();
                if ($subscriptions) {
                        $output = array ('status' => 'Success', 'message' => 'Subscriptions Details','subscription_details'=>$subscriptions,'settings'=>$settings);
                        echo json_encode($output);
                } else {
                    $output = array ('status' => 'Error', 'message' => 'Subscriptions not exists');
                    echo json_encode($output);
                }
        } else {
            $output = array ('status' => 'error', 'message' => 'Please enter input data');
            echo json_encode($output);
        }
    }
    public function api_prepare_checkout(){
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        if (!empty($json_input)) {
            $data = json_decode($json_input, TRUE);
            //$url='http://52.59.56.185/';
            $amount= $data['amount'];
            //$url='http://52.59.56.185/';
            $url = "https://test.oppwa.com/v1/checkouts";
            $data = "entityId=8ac7a4c7762d42e301763890b1b81981" .
                        "&amount=" .$amount."".
                        "&currency=SAR" .
                        "&paymentType=DB".
                        "&card.holder=".$data['card_holder_name'].
                        "&card.number=".$data['card_number'].
                        "&card.expiryMonth=".$data['expire_month'].
                        "&card.expiryYear=".$data['expire_year'].
                        "&card.cvv=".$data['cvc'].
                        "&testMode=EXTERNAL";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        'Authorization:Bearer OGFjN2E0Yzc3NjJkNDJlMzAxNzYzODkwNDk1ZDE5N2R8SEVwNVJkZFlkdw=='));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $responseData = curl_exec($ch);
            if(curl_errno($ch)) {
                return curl_error($ch);
            }
            curl_close($ch);
            $responseData = json_decode($responseData);
            if ($responseData) {    
                $output = array ('status' => 'Success', 'message' => 'Checkout Details','data'=>$responseData);
                echo json_encode($output);
            } else {
                $output = array ('status' => 'Error', 'message' => 'Somthing Went Wrong');
                echo json_encode($output);
            }
        } else {
            $output = array ('status' => 'error', 'message' => 'Please enter input data');
            echo json_encode($output);
        }
    }

    public function api_create_order(){
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        if (!empty($json_input)) {
            $data = json_decode($json_input, TRUE);
            //$url='http://52.59.56.185/';
            $amount= $data['amount'];
            //$url='http://52.59.56.185/';
            $url = "https://api.razorpay.com/v1/orders";  
            $data= '{
                "amount":"'.$amount.'",
                "currency":"INR",
                "receipt":"rcptid_11"
            }';     
            $ch = curl_init();
            $key="rzp_test_LC3rkEXpCo1MSd";
            $secret="rdhF9yjz62Hs7u6GYy7W5xbi";
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER,['Content-Type:application/json']);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_USERPWD, $key . ":" . $secret);// this should be set to true in production
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $responseData = curl_exec($ch);
            if(curl_errno($ch)) {
                return curl_error($ch);
            }
            curl_close($ch);
            $responseData = json_decode($responseData);
            if ($responseData) {    
                $output = array ('status' => 'Success', 'message' => 'Order Details','data'=>$responseData);
                echo json_encode($output);
            } else {
                $output = array ('status' => 'Error', 'message' => 'Somthing Went Wrong');
                echo json_encode($output);
            }
        } else {
            $output = array ('status' => 'error', 'message' => 'Please enter input data');
            echo json_encode($output);
        }
    }

    public function api_payment_status(){
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        if (!empty($json_input)) {
            $data = json_decode($json_input, TRUE);
            //$url='http://52.59.56.185/';
            $checkout_id= $data['checkout_id'];
            $url = "https://test.oppwa.com/v1/checkouts/".$checkout_id."/payment";
            $url .= "?entityId=8ac7a4c7762d42e301763890b1b81981";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        'Authorization:Bearer OGFjN2E0Yzc3NjJkNDJlMzAxNzYzODkwNDk1ZDE5N2R8SEVwNVJkZFlkdw=='));
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $responseData = curl_exec($ch);
            if(curl_errno($ch)) {
                return curl_error($ch);
            }
            curl_close($ch);
            $responseData = json_decode($responseData);
            if ($responseData) {    
                    $output = array ('status' => 'Success', 'message' => 'Payment Status','data'=>$responseData);
                    echo json_encode($output);
            } else {
                $output = array ('status' => 'Error', 'message' => 'Somthing Went Wrong');
                echo json_encode($output);
            }
        } else {
            $output = array ('status' => 'error', 'message' => 'Please enter input data');
            echo json_encode($output);
        }
    }

    public function api_payments(){
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        if (!empty($json_input)) {
            $data = json_decode($json_input, TRUE);
            $pay_data['customer_id'] = $data['id'];
            $pay_data['pay_amount']=$data['amount'];
            $pay_data['status']=1;
            $pay_data['created_date']=date('Y-m-d h:i:s');
            $pay_fields['name']=$data['card_holder_name'];
            $pay_fields['card_num']=$data['card_number'];
            $pay_fields['card_exp_year']=$data['expire_year'];
            $pay_fields['card_exp_month']=$data['expire_month'];
            $pay_fields['card_cvc']=$data['cvc'];
            $pay_fields['amount']=$data['amount'];
            if($data['payment_method'] == 'wallet'){
                $pay_data['payment_method'] = 4;
                $check_wallet = $this->api_model->check_amount_in_wallet($pay_data,'check');
                $pay_data['wallet_id']=$check_wallet['id'];
                if($check_wallet){
                    $wallet_detail['wallet_id']=$check_wallet['id'];
                    $wallet_detail['amount']=($pay_data['pay_amount']);
                    $wallet_detail['type']='Debit';
                    $wallet_detail['source']='Wallet';
                    $wallet_detail['card']='111111111111';
                    $wallet_detail['txn_no']='TXN1';
                    $this->api_model->insert_wallet_details($wallet_detail);
                    $wallet_bal_amt = ($check_wallet['amount'] - $pay_data['pay_amount']);
                    $this->api_model->update_current_wallet_amt(array('amount' => $wallet_bal_amt),$check_wallet['id']);
                    $pay_fields['wallet_id']=$check_wallet['id'];
                    $pay_data['payment_data']=serialize($pay_fields);
                    //insert Payment Details
                    $payment_id = $this->api_model->insert_payment_details($pay_data);
                    $trp_no = $this->increment_model->get_increment_code('scootero_trip_code');
                    $trip_data['trip_number'] = $trp_no;
                    $trip_data['customer_id']=$data['id'];
                    $trip_data['scooter_id']=$data['scootoro_id'];
                    $trip_data['payment_id']=$payment_id;
                    $trip_data['ride_start']=date('Y-m-d h:i:s');
                    $trip_data['created_date']=date('Y-m-d h:i:s');
                    //insert Payment Details
                    $trip_id = $this->api_model->insert_trip_details($trip_data);
                    $this->increment_model->update_increment_code('scootero_trip_code');
                    if($payment_id && $trip_id){
                        $output = array ('status' => 'Success', 'message' => 'Your payment menthod has been added succcessfully.Enjoy the ride!','trip_details'=>$trip_data);
                        echo json_encode($output);
                    }else{
                        $output = array ('status' => 'Error', 'message' => 'There is some issue while adding payment method.Try adding again');
                        echo json_encode($output);
                    }

                }else{
                    $output = array ('status' => 'Error', 'message' => 'Wallet doest not have required amount');
                    echo json_encode($output);
                }

            }
            if($data['payment_method'] == 'credit'){
                $pay_data['payment_method'] = 2;
                $pay_data['payment_data']=serialize($pay_fields);
                //insert Payment Details
                $payment_id = $this->api_model->insert_payment_details($pay_data);
                $trp_no = $this->increment_model->get_increment_code('scootero_trip_code');
                $trip_data['trip_number'] = $trp_no;
                $trip_data['customer_id']=$data['id'];
                $trip_data['scooter_id']=$data['scootoro_id'];
                $trip_data['payment_id']=$payment_id;
                $trip_data['ride_start']=date('Y-m-d h:i:s');
                $trip_data['created_date']=date('Y-m-d h:i:s');
                 //insert Payment Details
                 $trip_id = $this->api_model->insert_trip_details($trip_data);
                 $this->increment_model->update_increment_code('scootero_trip_code');
                 if($payment_id && $trip_id){
                    $output = array ('status' => 'Success', 'message' => 'Your payment menthod has been added succcessfully.Enjoy the ride!','trip_details'=>$trip_data);
                    echo json_encode($output);
                 }else{
                    $output = array ('status' => 'Error', 'message' => 'There is some issue while adding payment method.Try adding again');
                    echo json_encode($output);
                 }
            }if($data['payment_method'] == 'debit'){
                $pay_data['payment_method'] = 3;

                $amount                  = $data['amount'];//$chargeJson['amount'];
                $balance_transaction     = '';//$chargeJson['balance_transaction'];
                $currency                = 'SAR';//$chargeJson['currency'];
                $status                  = 'Success';//$chargeJson['status'];
                     
                     
               $pay_fields = array(
                                 'name'                  => $data['card_holder_name'],
                                 'email'                 => '',
                                 'card_num'              => $data['card_number'],
                                 'card_cvc'              => $data['cvc'],
                                 'card_exp_month'        => $data['expire_month'],
                                 'card_exp_year'         => $data['expire_year'],
                                 'amount'            => $amount,
                                 'item_price_currency'   => $currency,
                                 'paid_amount'           => $amount,
                                 'paid_amount_currency'  => $currency,
                                 'payment_status'        => $status,
                                 'created_by'            => 1,
                                 'created_date'          => date('Y-m-d H:i:s')
                                  );
                $pay_data['payment_data']=serialize($pay_fields);
                //insert Payment Details
                $payment_id = $this->api_model->insert_payment_details($pay_data);
                $trp_no = $this->increment_model->get_increment_code('scootero_trip_code');
                $inv_no = $this->increment_model->get_increment_code('scootero_invoice_code');
                $trip_data['trip_number'] = $trp_no;
                $trip_data['invoice_number'] = $inv_no;
                $trip_data['customer_id']=$data['id'];
                $trip_data['scooter_id']=$data['scootoro_id'];
                $trip_data['payment_id']=$payment_id;
                $trip_data['subscription_id']=$data['subscription_id'];
                $trip_data['ride_start']=date('Y-m-d h:i:s');
                $trip_data['ride_mins']=$data['ride_time_taken'];
                $trip_data['total_ride_amt']=$data['total_ride_rent'];
                $trip_data['unlock_charge']=$data['unlock_charge'];
                $trip_data['sub_total']=$data['total_rent'];
                $trip_data['vat_charge']=$data['vat_charge'];
                $trip_data['grand_total']=$data['grand_total'];
                $trip_data['created_date']=date('Y-m-d h:i:s');
                 //insert Payment Details
                 $trip_id = $this->api_model->insert_trip_details($trip_data);
                 $this->increment_model->update_increment_code('scootero_trip_code');
                 $this->increment_model->update_increment_code('scootero_invoice_code');
                 if($payment_id && $trip_id){
                    $output = array ('status' => 'Success', 'message' => 'Your transaction has done successfully.Enjoy the ride!','trip_details'=>$trip_data);
                    echo json_encode($output);
                 }else{
                    $output = array ('status' => 'Error', 'message' => 'There is some issue while making payment.Try again');
                    echo json_encode($output);
                 }                 
            }
                
        } else {
            $output = array ('status' => 'error', 'message' => 'Please enter input data');
            echo json_encode($output);
        }
    }

    public function api_customer_pay_details(){
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        if (!empty($json_input)) {
            $data = json_decode($json_input, TRUE);
                $pay = $this->api_model->get_customer_pay_details($data);
                if ($pay) {
                        $output = array ('status' => 'Success', 'message' => 'Payments list','data'=>$pay);
                        echo json_encode($output);
                } else {
                    $output = array ('status' => 'Error', 'message' => 'Customer payments not found');
                    echo json_encode($output);
                }
        } else {
            $output = array ('status' => 'error', 'message' => 'Please enter input data');
            echo json_encode($output);
        }
    }
    
    public function api_ride_end(){

        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        if (!empty($json_input)) {
            $data = json_decode($json_input, TRUE);
            $this->api_model->update_scootero_status($data['scootoro_id'],array('lock_status'=>0));
            $trip = $this->api_model->update_trip_data($data);
            $check_position = $this->scootero_model->check_scootero_position($data['scoo_lat'],$data['scoo_long'],$data['scootoro_id']);
            if(!$check_position){
                //Scootero Position Updates
                $insert_data['scootero_id']=$data['scootoro_id'];
                $insert_data['scoo_lat']=$data['scoo_lat'];
                $insert_data['scoo_long']=$data['scoo_long'];
                $insert_data['customer_id']=$data['customer_id'];
                $insert_data['is_current_position']=1;
                $this->scootero_model->insert_scooterO_history($insert_data);
                $this->scootero_model->update_scooterO(array("scoo_lat"=>$data['scoo_lat'],"scoo_long"=>$data['scoo_long']),$data['scootoro_id']);
            }
            if ($trip) {
                    $output = array ('status' => 'Success', 'message' => 'Trip end successfully','trip_details'=>$trip);
                    echo json_encode($output);
            } else {
                $output = array ('status' => 'Error', 'message' => 'Somthing went wrong');
                echo json_encode($output);
            }
               
        } else {
            $output = array ('status' => 'error', 'message' => 'Please enter input data');
            echo json_encode($output);
        }
    }

    public function api_ride_feedback(){
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        if (!empty($json_input)) {
            $data = json_decode($json_input, TRUE);
                $feedback = $this->api_model->insert_customer_feedback($data);
                if ($feedback) {
                        $output = array ('status' => 'Success', 'message' => 'Feedback has been updated');
                        echo json_encode($output);
                } else {
                    $output = array ('status' => 'Error', 'message' => 'Somthing went wrong');
                    echo json_encode($output);
                }
        } else {
            $output = array ('status' => 'error', 'message' => 'Please enter input data');
            echo json_encode($output);
        }
    }

    public function api_invoice_list(){
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        if (!empty($json_input)) {
            $data = json_decode($json_input, TRUE);
                $invoice = $this->api_model->get_invoice_lists($data);
                if ($invoice) {
                        $output = array ('status' => 'Success', 'message' => 'Invoice list','data'=>$invoice);
                        echo json_encode($output);
                } else {
                    $output = array ('status' => 'Error', 'message' => 'Invoice list not found');
                    echo json_encode($output);
                }
        } else {
            $output = array ('status' => 'error', 'message' => 'Please enter input data');
            echo json_encode($output);
        }
    }

    public function api_invoice_details(){
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        if (!empty($json_input)) {
            $data = json_decode($json_input, TRUE);
                $invoice = $this->api_model->get_invoice_details($data);
                if ($invoice) {
                        $output = array ('status' => 'Success', 'message' => 'Invoice Details','data'=>$invoice);
                        echo json_encode($output);
                } else {
                    $output = array ('status' => 'Error', 'message' => 'Invoice Details not found');
                    echo json_encode($output);
                }
        } else {
            $output = array ('status' => 'error', 'message' => 'Please enter input data');
            echo json_encode($output);
        }
    }

    public function api_update_customer_wallet(){
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        if (!empty($json_input)) {
            $data = json_decode($json_input, TRUE);
                $check_wallet = $this->api_model->check_amount_in_wallet($data);
                
                if ($check_wallet) {
                        $wallet_detail['wallet_id']=$check_wallet['id'];
                        $wallet_detail['amount']=($data['pay_amount']);
                        $wallet_detail['type']='Credit';
                        $wallet_detail['source']='Wallet';
                        $wallet_detail['card']='111111111111';
                        $wallet_detail['txn_no']='TXN1';
                        $this->api_model->insert_wallet_details($wallet_detail);
                        $wallet_bal_amt = ($check_wallet['amount'] + $data['pay_amount']);
                        $this->api_model->update_current_wallet_amt(array('amount' => $wallet_bal_amt),$check_wallet['id']);
                        $output = array ('status' => 'Success', 'message' => 'Wallet Amount Added Successfully');
                        echo json_encode($output);
                } else {
                    $output = array ('status' => 'Error', 'message' => 'Wallet Details not found');
                    echo json_encode($output);
                }
        } else {
            $output = array ('status' => 'error', 'message' => 'Please enter input data');
            echo json_encode($output);
        }
    }
    public function api_customer_dashboard(){
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        if (!empty($json_input)) {
            $data = json_decode($json_input, TRUE);
                $customer_dashboard = $this->api_model->get_customer_dashboard_details($data['customer_id']);
                if ($customer_dashboard) {
                    $output = array ('status' => 'Success', 'message' => 'Customer Dashboard Details','data'=>$customer_dashboard);
                    echo json_encode($output);
                } 
        } else {
            $output = array ('status' => 'error', 'message' => 'Please enter input data');
            echo json_encode($output);
        }
    }

    public function api_customer_wallet_details(){
        $json_input = file_get_contents('php://input', TRUE); // JSON Input
        if (!empty($json_input)) {
            $data = json_decode($json_input, TRUE);
                $customer_wallet = $this->api_model->get_customer_wallet_details($data['customer_id']);
                if ($customer_wallet) {
                    $output = array ('status' => 'Success', 'message' => 'Customer Wallet Details','data'=>$customer_wallet);
                    echo json_encode($output);
                } 
        } else {
            $output = array ('status' => 'error', 'message' => 'Please enter input data');
            echo json_encode($output);
        }
    }
    
}
