<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Report_model extends CI_Model {

    private $table_name = "scoo_trip as i";
    private $table_name1 = "scoo_feedback as f";
    var $joinTable1 = "scoo_customers as c";
    var $joinTable2 = "scoo_scootero as s";
    var $joinTable3 = "scoo_subscriptions as subs";
    var $joinTable4 = "scoo_payment_details as p";
    var $joinTable5 = "scoo_customer_wallet_details as wd";
    var $joinTable6 = "scoo_customer_wallet as w";
    var $invoice_column_order = array('i.trip_number','i.invoice_number','s.serial_number','c.name','i.ride_start','i.ride_end','i.ride_distance','i.total_ride_amt','i.unlock_charge','i.sub_total','i.vat_charge','i.grand_total');
    var $invoice_column_search = array('i.id','i.trip_number','i.invoice_number','s.serial_number','c.name','i.ride_start','i.ride_end','i.ride_distance','i.total_ride_amt','i.unlock_charge','i.sub_total','i.vat_charge','i.grand_total');
    var $invoice_order = array('i.id','ASC');
    var $feedback_column_order = array('i.trip_number','s.serial_number','c.name','f.feedback');
    var $feedback_column_search = array('f.id','i.trip_number','s.serial_number','c.name','f.feedback','f.ratings');
    var $feedback_order = array('f.id','ASC');
    var $payment_column_order = array('c.name','i.trip_number','s.serial_number','p.pay_amount','p.created_date');
    var $payment_column_search = array('c.name','i.trip_number','s.serial_number','p.pay_amount','p.created_date');
    var $payment_order = array('p.id','ASC');
    var $wallet_column_order = array('c.name','wd.type','wd.amount','wd.created_date');
    var $wallet_column_search = array('c.name','wd.type','wd.amount','wd.created_date');
    var $wallet_order = array('wd.id','ASC');
    function __construct() {
        parent::__construct();
        $this->export_invoice_fields = array();
    } 
    
    public function get_all_invoice_report($search_data=null) {
      $query = $this->get_all_invoice_report_qurery($search_data);
      if ($_POST['length'] != -1 && $_POST['length'])
         $this->db->limit($_POST['length'], $_POST['start']);
      $this->db->from($this->table_name);
      $query = $this->db->get();
      return $query->result_array();
     }

     public function get_all_invoice_report_qurery($search_data) {
        $this->db->select('i.*,c.name,s.serial_number');
        $this->db->join($this->joinTable1,'c.id = i.customer_id','LEFT');
        $this->db->join($this->joinTable2,'s.id = i.scooter_id','LEFT');
        $this->db->where('i.status',1);
        if($search_data != null){
           if($search_data['customer_id'] !='')
              $this->db->where('i.customer_id',$search_data['customer_id']);
              $search_data['from_date'] = ($search_data['from_date'] == '1970-01-01' && $search_data['from_date'] == '') ? '' : date('Y-m-d',strtotime($search_data['from_date']));
              $search_data['to_date'] = ($search_data['to_date'] == '1970-01-01' && $search_data['to_date'] == '') ? '' : date('Y-m-d',strtotime($search_data['to_date']));
            if (isset($search_data["from_date"]) && $search_data["from_date"] != "" && isset($search_data["to_date"]) && $search_data["to_date"] != "") {
                  $this->db->where("DATE_FORMAT(i.created_date,'%Y-%m-%d') >='" . $search_data["from_date"] . "' AND DATE_FORMAT(i.created_date,'%Y-%m-%d') <= '" . $search_data["to_date"] . "'");
            } elseif (isset($search_data["from_date"]) && $search_data["from_date"] != "" && isset($search_data["to_date"]) && $search_data["to_date"] == "") {
                  $this->db->where("DATE_FORMAT(i.created_date,'%Y-%m-%d') >='" . $search_data["from_date"] . "'");
            } elseif (isset($search_data["from_date"]) && $search_data["from_date"] == "" && isset($search_data["to_date"]) && $search_data["to_date"] != "") {
                  $this->db->where("DATE_FORMAT(i.created_date,'%Y-%m-%d') <= '" . $search_data["to_date"] . "'");
            }
        }
        $like='';
        $i = 0;
        foreach ($this->invoice_column_search as $item) { // loop column
              if ($_POST['search']['value']) { // if datatable send POST for search
                 if ($i === 0) { // first loop
                    $like = "" . $item . " LIKE '%" . $_POST['search']['value'] . "%'";
                 } else {
                    $like .= " OR " . $item . " LIKE '%" . $_POST['search']['value'] . "%'" . "";
                 }
              }
              $i++;
        }
        if ($like) {
              $where = "(" . $like . " )";
              $this->db->where($where);
        }
        if (isset($_POST['order']) && $this->invoice_column_order[$_POST['order'][0]['column']] != null) { // here order processing
           $this->db->order_by($this->invoice_column_order[$_POST['order'][0]['column']], $_POST['order'][0]['dir']);
        } else  {
           $this->db->order_by(key($this->invoice_order), $this->invoice_order[key($this->invoice_order)]);
        }
     }
  
     public function count_filtered_invoice($search_data) {
           $query = $this->get_all_invoice_report_qurery($search_data);
           $this->db->from($this->table_name);
           $query = $this->db->get();
           return $query->num_rows();
     }

     public function get_all_feedback_report($search_data=null) {
      $query = $this->get_all_feedback_report_qurery($search_data);
      if ($_POST['length'] != -1 && $_POST['length'])
         $this->db->limit($_POST['length'], $_POST['start']);
      $this->db->from($this->table_name1);
      $query = $this->db->get();
      return $query->result_array();
     }
     
     public function get_all_feedback_report_qurery($search_data) {
        $this->db->select('i.trip_number,s.serial_number,f.feedback,f.ratings,c.name');
        $this->db->join($this->table_name,'i.id = f.trip_id','LEFT');
        $this->db->join($this->joinTable1,'c.id = i.customer_id','LEFT');
        $this->db->join($this->joinTable2,'s.id = i.scooter_id','LEFT');
        $this->db->where('i.status',1);
        if($search_data != null){
           if($search_data['customer_id'] !='')
              $this->db->where('i.customer_id',$search_data['customer_id']);
              $search_data['from_date'] = ($search_data['from_date'] == '1970-01-01' && $search_data['from_date'] == '') ? '' : date('Y-m-d',strtotime($search_data['from_date']));
              $search_data['to_date'] = ($search_data['to_date'] == '1970-01-01' && $search_data['to_date'] == '') ? '' : date('Y-m-d',strtotime($search_data['to_date']));
            if (isset($search_data["from_date"]) && $search_data["from_date"] != "" && isset($search_data["to_date"]) && $search_data["to_date"] != "") {
                  $this->db->where("DATE_FORMAT(f.created_date,'%Y-%m-%d') >='" . $search_data["from_date"] . "' AND DATE_FORMAT(f.created_date,'%Y-%m-%d') <= '" . $search_data["to_date"] . "'");
            } elseif (isset($search_data["from_date"]) && $search_data["from_date"] != "" && isset($search_data["to_date"]) && $search_data["to_date"] == "") {
                  $this->db->where("DATE_FORMAT(f.created_date,'%Y-%m-%d') >='" . $search_data["from_date"] . "'");
            } elseif (isset($search_data["from_date"]) && $search_data["from_date"] == "" && isset($search_data["to_date"]) && $search_data["to_date"] != "") {
                  $this->db->where("DATE_FORMAT(f.created_date,'%Y-%m-%d') <= '" . $search_data["to_date"] . "'");
            }
        }
        $like='';
        $i = 0;
        foreach ($this->feedback_column_search as $item) { // loop column
              if ($_POST['search']['value']) { // if datatable send POST for search
                 if ($i === 0) { // first loop
                    $like = "" . $item . " LIKE '%" . $_POST['search']['value'] . "%'";
                 } else {
                    $like .= " OR " . $item . " LIKE '%" . $_POST['search']['value'] . "%'" . "";
                 }
              }
              $i++;
        }
        if ($like) {
              $where = "(" . $like . " )";
              $this->db->where($where);
        }
        if (isset($_POST['order']) && $this->feedback_column_order[$_POST['order'][0]['column']] != null) { // here order processing
           $this->db->order_by($this->feedback_column_order[$_POST['order'][0]['column']], $_POST['order'][0]['dir']);
        } else  {
           $this->db->order_by(key($this->feedback_order), $this->feedback_order[key($this->feedback_order)]);
        }
     }
  
     public function count_filtered_feedback($search_data) {
           $query = $this->get_all_feedback_report_qurery($search_data);
           $this->db->from($this->table_name1);
           $query = $this->db->get();
           return $query->num_rows();
     }

     public function get_all_transaction_report($search_data=null) {
      $query = $this->get_all_transaction_report_query($search_data);
      if ($_POST['length'] != -1 && $_POST['length'])
         $this->db->limit($_POST['length'], $_POST['start']);
      $this->db->from($this->table_name);
      $query = $this->db->get();
      return $query->result_array();
     }
     
     public function get_all_transaction_report_query($search_data) {
        $this->db->select('c.name as customer_name,i.trip_number,i.invoice_number,s.serial_number,(CASE WHEN p.wallet_id = 0 THEN "Card" ELSE "Wallet" END) As source,
        (CASE WHEN p.payment_method = "1" THEN "Apple" WHEN p.payment_method = "2" THEN "Credit" WHEN p.payment_method = "3" THEN "Debit" ELSE "Wallet" END) As payment_method_name,p.pay_amount as amount,p.created_date');
        $this->db->join($this->joinTable1,'c.id = i.customer_id','LEFT');
        $this->db->join($this->joinTable2,'s.id = i.scooter_id','LEFT');
        $this->db->join($this->joinTable4,'p.id = i.payment_id','LEFT');
        $this->db->where('i.status',1);
        if($search_data != null){
           if($search_data['customer_id'] !='')
              $this->db->where('p.customer_id',$search_data['customer_id']);
            if($search_data['payment_method_type'] !='')
              $this->db->where('p.payment_method',$search_data['payment_method_type']);
            $search_data['from_date'] = ($search_data['from_date'] == '1970-01-01' && $search_data['from_date'] == '') ? '' : date('Y-m-d',strtotime($search_data['from_date']));
            $search_data['to_date'] = ($search_data['to_date'] == '1970-01-01' && $search_data['to_date'] == '') ? '' : date('Y-m-d',strtotime($search_data['to_date']));
            if (isset($search_data["from_date"]) && $search_data["from_date"] != "" && isset($search_data["to_date"]) && $search_data["to_date"] != "") {
                  $this->db->where("DATE_FORMAT(p.created_date,'%Y-%m-%d') >='" . $search_data["from_date"] . "' AND DATE_FORMAT(p.created_date,'%Y-%m-%d') <= '" . $search_data["to_date"] . "'");
            } elseif (isset($search_data["from_date"]) && $search_data["from_date"] != "" && isset($search_data["to_date"]) && $search_data["to_date"] == "") {
                  $this->db->where("DATE_FORMAT(p.created_date,'%Y-%m-%d') >='" . $search_data["from_date"] . "'");
            } elseif (isset($search_data["from_date"]) && $search_data["from_date"] == "" && isset($search_data["to_date"]) && $search_data["to_date"] != "") {
                  $this->db->where("DATE_FORMAT(p.created_date,'%Y-%m-%d') <= '" . $search_data["to_date"] . "'");
            }
        }
        $like='';
        $i = 0;
        foreach ($this->payment_column_search as $item) { // loop column
              if ($_POST['search']['value']) { // if datatable send POST for search
                 if ($i === 0) { // first loop
                    $like = "" . $item . " LIKE '%" . $_POST['search']['value'] . "%'";
                 } else {
                    $like .= " OR " . $item . " LIKE '%" . $_POST['search']['value'] . "%'" . "";
                 }
              }
              $i++;
        }
        if ($like) {
              $where = "(" . $like . " )";
              $this->db->where($where);
        }
        if (isset($_POST['order']) && $this->payment_column_order[$_POST['order'][0]['column']] != null) { // here order processing
           $this->db->order_by($this->payment_column_order[$_POST['order'][0]['column']], $_POST['order'][0]['dir']);
        } else  {
           $this->db->order_by(key($this->payment_order), $this->payment_order[key($this->payment_order)]);
        }
     }
  
     public function count_filtered_transaction($search_data) {
           $query = $this->get_all_transaction_report_query($search_data);
           $this->db->from($this->table_name);
           $query = $this->db->get();
           return $query->num_rows();
     }

     public function get_all_wallet_report($search_data=null) {
      $query = $this->get_all_wallet_report_query($search_data);
      if ($_POST['length'] != -1 && $_POST['length'])
         $this->db->limit($_POST['length'], $_POST['start']);
      $this->db->from($this->joinTable5);
      $query = $this->db->get();
      return $query->result_array();
     }
     
     public function get_all_wallet_report_query($search_data) {
        $this->db->select('c.name as customer_name,wd.type,wd.amount,wd.created_date');
        $this->db->join($this->joinTable6,'w.id = wd.wallet_id','LEFT');
        $this->db->join($this->joinTable1,'c.id = w.customer_id','LEFT');
        $this->db->where('wd.status',1);
        if($search_data != null){
           if($search_data['customer_id'] !='')
              $this->db->where('w.customer_id',$search_data['customer_id']);
            if($search_data['payment_type'] !='')
              $this->db->where('wd.type',$search_data['payment_type']);
            $search_data['from_date'] = ($search_data['from_date'] == '1970-01-01' && $search_data['from_date'] == '') ? '' : date('Y-m-d',strtotime($search_data['from_date']));
            $search_data['to_date'] = ($search_data['to_date'] == '1970-01-01' && $search_data['to_date'] == '') ? '' : date('Y-m-d',strtotime($search_data['to_date']));
            if (isset($search_data["from_date"]) && $search_data["from_date"] != "" && isset($search_data["to_date"]) && $search_data["to_date"] != "") {
                  $this->db->where("DATE_FORMAT(wd.created_date,'%Y-%m-%d') >='" . $search_data["from_date"] . "' AND DATE_FORMAT(wd.created_date,'%Y-%m-%d') <= '" . $search_data["to_date"] . "'");
            } elseif (isset($search_data["from_date"]) && $search_data["from_date"] != "" && isset($search_data["to_date"]) && $search_data["to_date"] == "") {
                  $this->db->where("DATE_FORMAT(wd.created_date,'%Y-%m-%d') >='" . $search_data["from_date"] . "'");
            } elseif (isset($search_data["from_date"]) && $search_data["from_date"] == "" && isset($search_data["to_date"]) && $search_data["to_date"] != "") {
                  $this->db->where("DATE_FORMAT(wd.created_date,'%Y-%m-%d') <= '" . $search_data["to_date"] . "'");
            }
        }
        $like='';
        $i = 0;
        foreach ($this->wallet_column_search as $item) { // loop column
              if ($_POST['search']['value']) { // if datatable send POST for search
                 if ($i === 0) { // first loop
                    $like = "" . $item . " LIKE '%" . $_POST['search']['value'] . "%'";
                 } else {
                    $like .= " OR " . $item . " LIKE '%" . $_POST['search']['value'] . "%'" . "";
                 }
              }
              $i++;
        }
        if ($like) {
              $where = "(" . $like . " )";
              $this->db->where($where);
        }
        if (isset($_POST['order']) && $this->wallet_column_order[$_POST['order'][0]['column']] != null) { // here order processing
           $this->db->order_by($this->wallet_column_order[$_POST['order'][0]['column']], $_POST['order'][0]['dir']);
        } else  {
           $this->db->order_by(key($this->wallet_order), $this->wallet_order[key($this->wallet_order)]);
        }
     }
  
     public function count_filtered_wallet($search_data) {
           $query = $this->get_all_wallet_report_query($search_data);
           $this->db->from($this->joinTable5);
           $query = $this->db->get();
           return $query->num_rows();
     }

}
