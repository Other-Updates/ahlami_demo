<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Api_model extends CI_Model {

    private $customers = 'scoo_customers';
    private $settings = 'scoo_general_setting';
    private $scootoro = 'scoo_scootero';
    private $payment_details = 'scoo_payment_details';
    private $trip_details = 'scoo_trip';
    private $subscriptions = 'scoo_subscriptions';
    private $feedback ='scoo_feedback';
    private $wallet ='scoo_customer_wallet';
    private $wallet_details ='scoo_customer_wallet_details';
    private $payments_view = 'scoo_payments_view';

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function insert_customer_details($data){
        if ($this->db->insert($this->customers, $data)) {
            $customer_id = $this->db->insert_id();
            return $customer_id;
        }
        return FALSE;
    }

    public function generateNumericOTP($n) {  
        $generator = "135792468"; 
        $result = ""; 
        for ($i = 1; $i <= $n; $i++) { 
            $result .= substr($generator, (rand()%(strlen($generator))), 1); 
        }  
        return $result; 
    }
    
    public function update_profile_fields($id,$field_name,$field_data,$update_data=NULL,$otp=NULL){
        if($update_data == NULL)
            $update_data[$field_name]=$field_data;
        if($otp != NULL)
            $update_data['otp_updates']=1;
        $update_data['updated_at']=date('Y-m-d h:i:s');
        $this->db->where('id',$id);
        if($this->db->update($this->customers,$update_data)){
            return true;
        }
        return false;
    }

    public function check_field_exists($column,$data,$id='',$check_otp=NULL,$pri_id=NULL){
        $this->db->select('id,name,mobile_number,email,otp_verify');
        $this->db->where($column,$data);
        $this->db->where('is_deleted',0);
        if($pri_id != NULL)
         $this->db->where('id',$pri_id);
        if($id != '')
            $this->db->where('id !=',$id);
        $result = $this->db->get($this->customers)->row_array();
        if(!empty($result)){
            if($check_otp != NULL && $result['otp_verify'] == 0){
                $this->db->where('id',$result['id']);
                $this->db->delete($this->customers);
                return false;
            }else{
                return $result;
            }
        }
        return false;
    }

    public function update_fields($id,$data){
        $data['updated_at']=date('Y-m-d h:i:s');
        $this->db->where('id',$id);
        $this->db->update($this->customers,$data);
        return true;
    }

    public function check_login_details($data){
        $this->db->select('*');
        if($data['googleid']){
            $this->db->where('google_id',$data['googleid']);
            $this->db->where('is_google',1);
        }else{
            $this->db->where('mobile_number',$data['mobile_number']);
            $this->db->where('plain_password',($data['password']));
        }
        $this->db->where('is_deleted',0);
        $query = $this->db->get($this->customers)->row_array();
        $result=array();
        if(!empty($query)){
            if($query['otp_verify'] == 1){
                $result['customer_details']=$query;
                $result['settings'] = $this->getSettings();
                return $result;
            }else{
                return 1;
            }
        }
        return false;
    }

    public function check_customer_otp($data,$id=NULL){
        $this->db->select('*');
        if($id == NULL){
            if($data['googleid']){
                $this->db->where('google_id',$data['googleid']);
                $this->db->where('is_google',1);
            }
            if($data['email']){
                $this->db->where('email',$data['email']);
            }
            if($data['mobile_number']){
                $this->db->where('mobile_number',$data['mobile_number']);
            }
            $this->db->where('otp_code',$data['otp_code']);
            $this->db->where('otp_verify',0);
        }else{
            $this->db->where('id',$id);
        }
        $query = $this->db->get($this->customers)->row_array();
        if(!empty($query)){
            //$result['customer_id']=$query['id'];
            //$result['customer_details']=$query;
            //$result['settings'] = $this->getSettings();
            return $query;
        } 
        return false;
    }

    public function get_customer_profile_details($data){
        $this->db->select('id,name,mobile_number,dob,email,gender');
        $this->db->where('id',$data['id']);
        $data =  $this->db->get($this->customers)->row_array();
        $data['gender'] = ($data['gender'] > 0) ? (($data['gender'] == 'Male') ? 1 : 2) : 0;
        return $data;
    }
    public function getSettings(){
        return $this->db->get($this->settings)->row_array();
    }
    public function get_scooter_info(){
        $this->db->select('id,serial_number,battery_life,scoo_lat,scoo_long');
        $this->db->where('is_deleted',0);
        $this->db->where('status',1);
        $query = $this->db->get($this->scootoro)->result_array();
        if(!empty($query)){
            return $query;
        }
        return false;
    }

    public function unlock_scootoro($id,$qr_code){
        $this->db->select('id,serial_number,battery_life,lock_status');
        $this->db->where('is_deleted',0);
        $this->db->where('status',1);
        $this->db->where('qr_code',$qr_code);
        $query = $this->db->get($this->scootoro)->row_array();
        if($query){
            if($query['lock_status'] == 0){
                $this->db->where('id',$query['id']);
                $this->db->update($this->scootoro,array('lock_status'=>1));
                $scootoro['scooter_id']=$query['id'];
                $scootoro['serial_number']=$query['serial_number'];
                $scootoro['battery_life']=$query['battery_life']."%";
                return $scootoro;
            }else{
                return 1;
            }
        }
        return false;
    }

    public function insert_payment_details($data){
        if ($this->db->insert($this->payment_details, $data)) {
            $payment_id = $this->db->insert_id();
            return $payment_id;
        }
        return FALSE;
    }

    public function insert_trip_details($data){
        if ($this->db->insert($this->trip_details, $data)) {
            $trip_id = $this->db->insert_id();
            return $trip_id;
        }
        return FALSE;
    }

    public function get_subscriptions_plan(){
        $this->db->select('id,name,mins,amount');
        $this->db->where('is_deleted',0);
        $this->db->where('status',1);
        $query = $this->db->get($this->subscriptions)->result_array();
        if(!empty($query)){
            return $query;
        }
        return false;
    }

    // get curl handle method
    public function get_curl_handle($data) {
        $url = 'https://api.stripe.com/v1/charges';
        $key_secret = $this->config->item('stripe_secret');
        //cURL Request
        $ch = curl_init();
        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERPWD, $key_secret);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_POST, 1);
        $params = http_build_query($data);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        $output = curl_exec ($ch);
        return $output;
    }

    public function update_scootero_status($id,$data){
        $data['updated_at']=date('Y-m-d h:i:s');
        $this->db->where('id',$id);
        $this->db->update($this->scootoro,$data);
        return true;
    }

    public function update_trip_data($data){
        $update_data['ride_distance']=$data['distance'];
        $update_data['ride_end']=date('Y-m-d h:i:s');
        $update_data['updated_date']=date('Y-m-d h:i:s');
        $this->db->where('trip_number',$data['trip_number']);
        $this->db->update($this->trip_details,$update_data);
        
        $this->db->where('trip_number',$data['trip_number']);
        $trip_data =  $this->db->get($this->trip_details)->row_array();
        return $trip_data;
    }

    public function insert_customer_feedback($inputs){
        $data['scootoro_id'] = $inputs['scootoro_id'];
        $data['trip_id'] = $inputs['trip_id'];
        if($inputs['feedback'])
            $data['feedback'] = $inputs['feedback'];
        if($inputs['ratings'])
            $data['ratings'] = $inputs['ratings'];

        $this->db->where('trip_id',$inputs['trip_id']);
        $check_feedback = $this->db->get($this->feedback)->row_array();
        if($check_feedback){
            $this->db->where('trip_id',$inputs['trip_id']);
            $data['updated_date']=date('Y-m-d h:i:s');
            $feedback = $this->db->update($this->feedback,$data);
        }else{
            $data['created_date']=date('Y-m-d h:i:s');
            $feedback = $this->db->insert($this->feedback,$data);
        }
        return $feedback;
    }

    public function get_invoice_lists($data){
        $this->db->select('*');
        $this->db->where('status',1);
        $this->db->where('customer_id',$data['id']);
        $this->db->where('ride_end <>','');
        $query = $this->db->get($this->trip_details)->result_array();
        $invoice=array();
        if(!empty($query)){
            foreach($query as $key=>$result){
                $invoice[$key]['id']=$result['id'];
                $invoice[$key]['trip_number']=$result['trip_number'];
                $invoice[$key]['amount']=number_format($result['grand_total'],2);
                $invoice[$key]['date']=date('d M Y',strtotime($result['created_date']));
            }
            return $invoice;
        }
        return false;
    }

    public function get_invoice_details($data){
        $this->db->select('t.*,s.serial_number');
        $this->db->where('t.status',1);
        $this->db->where('t.customer_id',$data['id']);
        $this->db->where('t.id',$data['trip_id']);
        $this->db->join($this->scootoro.' As s','s.id = t.scooter_id','left');
        $result = $this->db->get($this->trip_details.' As t')->row_array();
        $invoice=array();
        if(!empty($result)){
                $invoice['id']=$result['id'];
                $invoice['trip_number']=$result['trip_number'];
                $invoice['invoice_number']=$result['invoice_number'];
                $invoice['scootoro_number']=$result['serial_number'];
                $invoice['start_time']=date('H:i a',strtotime($result['ride_start']));
                $invoice['end_time']=date('H:i a',strtotime($result['ride_end']));
                $invoice['ride_distance']=$result['ride_distance'];
                $invoice['total_ride_time']=$result['ride_mins'];
                $invoice['total_ride_amt']=number_format($result['total_ride_amt'],2);
                $invoice['unlock_charge']=number_format($result['unlock_charge'],2);
                $invoice['sub_total']=number_format($result['sub_total'],2);
                $invoice['vat_charge']=number_format($result['vat_charge'],2);
                $invoice['grand_total']=number_format($result['grand_total'],2);
            return $invoice;
        }
        return false;
    }

    function time_difference($in_time, $out_time)
    {

        if ($out_time > "24:00:00")
            $out_time = "24:00:00";

        $time1 = new DateTime($in_time);
        $time2 = new DateTime($out_time);


        $inter = $time2->diff($time1);

        $hours = $inter->h;
        if ($inter->h < 10) {
            $hours = "0" . $inter->h;
        }
        $mins = $inter->i;
        if ($inter->i < 10) {
            $mins = "0" . $inter->i;
        }
        $sec = $inter->s;
        if ($inter->s < 10) {
            $sec = "0" . $inter->s;
        }

        return $hours . ":" . $mins . ":" . $sec;
    }

    function sum_the_time($time1, $time2)
    {
        $times = array($time1, $time2);
        $seconds = 0;
        foreach ($times as $time) {
            list($hour, $minute, $second) = explode(':', $time);
            $seconds += $hour * 3600;
            $seconds += $minute * 60;
            $seconds += $second;
        }
        $hours = floor($seconds / 3600);
        $seconds -= $hours * 3600;
        $minutes = floor($seconds / 60);
        $seconds -= $minutes * 60;
        // return "{$hours}:{$minutes}:{$seconds}";
        return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds); // Thanks to Patrick
    }

    function explode_time($time)
    {
        $explode_time = explode(':', $time);
        $time = $explode_time[0] . ":" . $explode_time[1];
        return $time;
    }

    function sum_multi_time($times)
    {

        $seconds = 0;

        if ($times) {
            foreach ($times as $time) {

                list($hour, $minute, $second) = explode(':', $time);
                $seconds += $hour * 3600;
                $seconds += $minute * 60;
                $seconds += $second;
            }
        }
        $hours = floor($seconds / 3600);
        $seconds -= $hours * 3600;
        $minutes = floor($seconds / 60);
        $seconds -= $minutes * 60;

        //  return "{$hours}:{$minutes}:{$seconds}";
        return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds); // Thanks to Patrick
    }

    public function insert_customer_walltet($data){
        if ($this->db->insert($this->wallet, $data)) {
            $wallet_id = $this->db->insert_id();
            return $wallet_id;
        }
        return FALSE;
    }

    function check_amount_in_wallet($data,$type=null){
        $this->db->where('customer_id',$data['customer_id']);
        if($type == 'check')
         $this->db->where('amount >=',$data['pay_amount']);
        $query = $this->db->get($this->wallet)->row_array();
        if(!empty($query)){
            return $query;
        }
        return false;
    }

    public function insert_wallet_details($data){
        if ($this->db->insert($this->wallet_details, $data)) {
            $wallet_detail_id = $this->db->insert_id();
            return $wallet_detail_id;
        }
        return FALSE;
    }

    public function update_current_wallet_amt($data,$id){
        $data['updated_date']=date('Y-m-d h:i:s');
        $this->db->where('id',$id);
        $this->db->update($this->wallet,$data);
        return true;
    }

    public function get_customer_dashboard_details($id){
        $result='';
        $result['unlock_counts']=$this->get_customer_unlocks($id);
        $result['total_distance']=$this->get_total_ride_distance($id);
        $result['wallet_amount']=$this->get_customer_wallet_amount($id);
        $result['total_ride_time']=$this->get_customer_total_ride_time($id);
        return $result;
    }

    public function get_customer_unlocks($id){
        $this->db->select('COUNT(id) as trip_counts');
        $this->db->where('customer_id',$id);
        $query = $this->db->get($this->trip_details)->result_array();
        return ($query[0]['trip_counts']) ? $query[0]['trip_counts'] : 0;
    }

    public function get_total_ride_distance($id){
        $this->db->select('SUM(ride_distance) as trip_distance');
        $this->db->where('customer_id',$id);
        $query = $this->db->get($this->trip_details)->result_array();
        return ($query[0]['trip_distance']) ? $query[0]['trip_distance'] : 0;
    }

    public function get_customer_total_ride_time($id){
        $this->db->select('ride_mins');
        $this->db->where('customer_id',$id);
        $query = $this->db->get($this->trip_details)->result_array();
        if(!empty($query)){ 
            $mins = array_map(function($query) {
                return $query['ride_mins'];
            }, $query);
            return $this->sum_multi_time($mins);
        }else{
            return '00:00:00';
        }
    }

    public function get_customer_wallet_amount($id){
        $this->db->select('amount');
        $this->db->where('customer_id',$id);
        $query = $this->db->get($this->wallet)->result_array();
        return ($query[0]['amount']) ? $query[0]['amount'] : 0;
    }

    public function get_customer_wallet_details($id){
        $this->db->select('w.id,w.amount,DATE_FORMAT(w.created_date, ("%d/%m/%Y")) as created_date');
        $this->db->where('w.customer_id',$id);
        $query = $this->db->get($this->wallet.' As w')->result_array();
        $result = [];
        if($query){
            $result[0]['wallet']=$query;
            $this->db->select('wd.type,wd.amount,DATE_FORMAT(wd.created_date, ("%d/%m/%Y")) as created_date');
            $this->db->where('wd.wallet_id',$query[0]['id']);
            $result[0]['wallet_details'] =  $this->db->get($this->wallet_details.' As wd')->result_array();
        }
        return $result;
    }

    public function sendSMS($mobileno,$msgtext){
        $settings=$this->getSettings();
        $profileid = $settings['sms_gateway_username'];
        $pwd=$settings['sms_gateway_password'];
        $senderid='MOBSMS';
        $CountryCode='966';
        $mobileno=$mobileno;
        $msgtext=rawurlencode($msgtext);
        $scheduledDate=date('m/d/Y h:m a');
        //$url="http://www.mshastra.com/sendurlcomma.aspx?user=".$profileid."&pwd=".$pwd."&senderid=".$senderid."&CountryCode=91&mobileno=9500746789&msgtext=".$msgtext."&smstype=0/4/3";
        //$url="http://www.mshastra.com/balance.aspx?user=".$profileid."&pwd=".$pwd.""; // Check Balance
       // $url="http://mshastra.com/sendurlcomma.aspx?user=".$profileid."&pwd=".$pwd."&senderid=".$senderid."&mobileno=".$mobileno."&msgtext=".$msgtext."&CountryCode=".$CountryCode."&scheduledDate=".$scheduledDate." ";
        $url="http://mshastra.com/sendurlcomma.aspx?user=".trim($profileid)."&pwd=".trim($pwd)."&CountryCode=".$CountryCode."&senderid=".$senderid."&mobileno=".$mobileno."&msgtext=".$msgtext."&language=Arabic";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Connection: close'
        ));
        $data = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
    }

    public function get_customer_pay_details($data){
        $data['payemnt_type'] = ($data['payemnt_type'] == 'Credit') ? '2' : '3';
        $this->db->select('*');
        $this->db->where('pv.payment_method',$data['payemnt_type']);
        $this->db->where('pv.customer_id',$data['customer_id']);
        $query = $this->db->get($this->payments_view.' As pv')->result_array();
        $result = '';
        if(!empty($query)){
            $i= 0;
            foreach($query as $key=>$datas){
                $result[$i]['amount']=$datas['pay_amount'];
                $result[$i]['created_date']=date('d M Y',strtotime($datas['created_date']));
                $pay_data = unserialize($datas['payment_data']);
                $result[$i]['pay_description']=($pay_data) ? (($datas['pay_description']) ? $datas['pay_description'] : '') : 'Loaded to Wallet';
                $result[$i]['card']=($pay_data) ? $pay_data['card_num'] : $datas['payment_data'];
                $result[$i]['txn_no']=($pay_data) ? '': $datas['pay_description'];
                $i++;
            }
            return $result;
        }
        return false;
    }


    }
