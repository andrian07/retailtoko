<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");

class Sales extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->model('masterdata_model');
		$this->load->model('sales_model');
		$this->load->model('purchase_model');
		$this->load->model('global_model');
		$this->load->helper(array('url', 'html'));
	}

	public function index(){
		if(isset($_SESSION['user_name']) != null){
			redirect('Dashboard/Admin', 'refresh');
		}else{
			$this->load->view('Pages/login');
		}
	}


	private function check_auth($modul){
		if(isset($_SESSION['user_name']) == null){
			redirect('Masterdata', 'refresh');
		}else{
			$user_role_id = $_SESSION['user_role_id'];
			$check_auth_nav = $this->global_model->check_auth_nav($user_role_id);
			$check_access = $this->global_model->check_access($user_role_id, $modul);
			$array = array(
				'check_auth_nav' => $check_auth_nav,
				'check_access' => $check_access
			);
			return($array);
		}
	}

	// start sales

	public function salespage()
	{
		$modul = 'Sales';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->view == 'Y'){
			$customer_list['customer_list'] = $this->masterdata_model->customer_list();
			$payment_list['payment_list'] = $this->masterdata_model->payment_list();
			$check_auth['check_auth'] = $check_auth;
			$data['data'] = array_merge($customer_list, $payment_list, $check_auth);
			$this->load->view('Pages/Sales/sales', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function sales_list()
	{
		$modul = 'Sales';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->view == 'Y'){
			$search 				= $this->input->post('search');
			$length 				= $this->input->post('length');
			$start 			  		= $this->input->post('start');
			$cat 			  		= $this->input->post('cat');
			$start_date 			= $this->input->post('start_date');
			$end_date 			  	= $this->input->post('end_date');
			$customer_filter 		= $this->input->post('customer_filter');
			$payment_status_filter	= $this->input->post('payment_status_filter');

			if($search != null){
				$search = $search['value'];
			}
			$list = $this->sales_model->sales_list($search, $cat, $length, $start, $start_date, $end_date, $customer_filter, $payment_status_filter)->result_array();
			$count_list = $this->sales_model->sales_list_count($search, $cat, $start_date, $end_date, $customer_filter, $payment_status_filter)->result_array();
			$total_row = $count_list[0]['total_row'];
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $field) {

				if($field['hd_sales_status'] == 'Pending'){
					$hd_sales_status = '<span class="badge badge-info">Pending</span>';
				}else if($field['hd_sales_status'] == 'Success'){
					$hd_sales_status = '<span class="badge badge-success">Success</span>';
				}else{
					$hd_sales_status = '<span class="badge badge-danger">Cancel</span>';
				}
				

				if($field['hd_sales_remaining_debt'] > 0){
					$payment_status = '<span class="badge badge-danger">Belum Lunas</span>';
				}else{
					$payment_status = '<span class="badge badge-success">Lunas</span>';
				}

				if($check_auth['check_access'][0]->view == 'Y'){
					$url = base_url();
					$detail = '<a href="'.base_url().'Sales/detailsales?id='.$field['hd_sales_id'].'" data-fancybox="" data-type="iframe"><button type="button" class="btn btn-icon btn-primary btn-sm mb-2-btn" data-id="'.$field['hd_sales_id'].'"><i class="fas fa-eye sizing-fa"></i></button></a> ';
				}else{
					$detail = '<a href="'.base_url().'Sales/detailsales?id='.$field['hd_sales_id'].'" data-fancybox="" data-type="iframe"><button type="button" class="btn btn-icon btn-primary btn-sm mb-2-btn" disabled="disabled"><i class="fas fa-eye sizing-fa"></i></button></a> ';
				}


				if($check_auth['check_access'][0]->delete == 'Y'){
					if($field['hd_sales_status'] != 'Cancel'){
						$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn" onclick="deletes('.$field['hd_sales_id'].')"><i class="fas fa-trash-alt sizing-fa"></i></button> ';
					}else{
						$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn"  disabled="disabled"><i class="fas fa-trash-alt sizing-fa"></i></button> ';
					}
				}else{
					$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn"  disabled="disabled"><i class="fas fa-trash-alt sizing-fa"></i></button> ';
				}

				$print = '<button type="button" class="btn btn-icon btn-warning delete btn-sm mb-2-btn" data-id="'.$field['hd_sales_id'].'" data-bs-toggle="modal" data-bs-target="#print"><i class="fas fa-print sizing-fa"></i></button> ';

				$date = date_create($field['hd_sales_date']); 
				$no++;
				$row = array();
				$row[] 	= $field['hd_sales_inv'];
				$row[] 	= date_format($date,"d-M-Y");
				$row[] 	= $field['customer_name'];
				$row[] 	= 'Rp. '.number_format($field['hd_sales_total']);
				$row[] 	= 'Rp. '.number_format($field['hd_sales_remaining_debt']);
				$row[] 	= $payment_status;
				$row[]  = $hd_sales_status;
				$row[] 	= $detail.$delete.$print;
				$data[] = $row;
			}

			$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $total_row,
				"recordsFiltered" => $total_row,
				"data" => $data,
			);
			echo json_encode($output);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function detailsales()
	{
		$modul = 'Sales';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->view == 'Y'){
			$hd_sales_id  = $this->input->get('id');
			$header_sales['header_sales'] = $this->sales_model->header_sales($hd_sales_id);
			$detail_sales['detail_sales'] = $this->sales_model->detail_sales($hd_sales_id); 
			$data['data'] = array_merge($header_sales, $detail_sales);
			$this->load->view('Pages/Sales/detailsales', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function addsales()
	{
		$modul = 'Sales';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->view == 'Y'){
			$customer_list['customer_list'] = $this->masterdata_model->customer_list();
			$payment_list['payment_list'] = $this->masterdata_model->payment_list();
			$user_list['user_list'] = $this->masterdata_model->user_list();
			$check_auth['check_auth'] = $check_auth;
			$data['data'] = array_merge($customer_list, $payment_list, $user_list, $check_auth);
			$this->load->view('Pages/Sales/addsales', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

		public function temp_sales_list()
	{
		$modul = 'Sales';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->view == 'Y'){
			$search 			= $this->input->post('search');
			$length 			= $this->input->post('length');
			$start 			  	= $this->input->post('start');
			$user  				= $_SESSION['user_id'];

			if($search != null){
				$search = $search['value'];
			}
			$list = $this->sales_model->temp_sales_list($search, $length, $start, $user)->result_array();
			$count_list = $this->sales_model->temp_sales_list_count($search, $user)->result_array();
			$total_row = $count_list[0]['total_row'];
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $field) {

				$edit = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" onclick="edit_temp('.$field['temp_product_id'].')"><i class="fas fa-edit sizing-fa"></i></button> ';
				$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn" onclick="deletes('.$field['temp_product_id'].')"><i class="fas fa-trash-alt sizing-fa"></i></button> ';

				$no++;
				$row = array();
				$row[] 	= $field['product_code'];
				$row[] 	= $field['product_name'];
				$row[] 	= $field['temp_sales_qty'];
				$row[] 	= 'Rp. '.number_format($field['temp_sales_price']);
				$row[] 	= 'Rp. '.number_format($field['temp_sales_discount']);
				$row[] 	= 'Rp. '.number_format($field['temp_sales_total']);
				$row[] 	= $edit.$delete;
				$data[] = $row;
			}

			$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $total_row,
				"recordsFiltered" => $total_row,
				"data" => $data,
			);
			echo json_encode($output);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}
	// end sales

}