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
			redirect('Sales', 'refresh');
		}else{
			$user_role_id = $_SESSION['user_role_id'];
			$check_access = $this->global_model->check_access($user_role_id, $modul);
			return($check_access);
		}
	}

	// search produk && Rate //

	public function search_product()
	{	
		$supplier_id = $this->input->get('id');
		$keyword = $this->input->get('term');
		$result = ['success' => FALSE, 'num_product' => 0, 'data' => [], 'message' => ''];
		if (!($keyword == '' || $keyword == NULL)) {
			$find = $this->global_model->search_product($keyword)->result_array();
			$find_result = [];
			foreach ($find as $row) {
				$diplay_text = $row['product_code'].' - '.$row['product_name'].' - '.$row['unit_name'];
				$product_id = $row['product_id'];
				$stock = $this->global_model->total_stock_search($product_id)->result_array();
				$find_result[] = [
					'id'                  => $row['product_id'],
					'value'               => $diplay_text,
					'product_code'        => $row['product_code'],
					'product_price'       => $row['product_price'],
					'product_weight'      => $row['product_weight'],
					'curent_stock'        => $stock[0]['curent_stock']
				];
			}
			$result = ['success' => TRUE, 'num_product' => count($find_result), 'data' => $find_result, 'message' => ''];
		}
		echo json_encode($result);
	} 

	public function get_rate()
	{

		$product_id = $this->input->post('product_id');
		$get_rate   = $this->sales_model->get_rate($product_id);
		echo json_encode(['code'=>200, 'result'=>$get_rate]);
	}

	public function get_customer_rate()
	{
		$customer_id = $this->input->post('customer_id');
		$get_customer_rate   = $this->sales_model->get_customer_rate($customer_id);
		echo json_encode(['code'=>200, 'result'=>$get_customer_rate]);
	}
	// end search produk && Rate//

	// sales order //

	public function salesorder()
	{
		$modul = 'SalesOrder';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$warehouse_list['warehouse_list'] = $this->masterdata_model->warehouse_list();
			$salesman_list['salesman_list'] = $this->masterdata_model->salesman_list();
			$customer_list['customer_list'] = $this->masterdata_model->customer_list();
			$payment_list['payment_list'] = $this->masterdata_model->payment_list();
			$ekspedisi_list['ekspedisi_list'] = $this->masterdata_model->ekspedisi_list();
			$user_list['user_list'] = $this->masterdata_model->user_list();
			$data['data'] = array_merge($warehouse_list, $salesman_list, $customer_list, $payment_list, $ekspedisi_list, $user_list);
			$this->load->view('Pages/Sales/salesorder', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function sales_order_list()
	{
		$modul = 'SalesOrder';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$search 			= $this->input->post('search');
			$length 			= $this->input->post('length');
			$start 			  	= $this->input->post('start');

			$start_date         = $this->input->post('start_date');
			$end_date         	= $this->input->post('end_date');
			$customer_filter 	= $this->input->post('customer_filter');



			if($search != null){
				$search = $search['value'];
			}
			$list = $this->sales_model->sales_order_list($search, $length, $start, $start_date, $end_date, $customer_filter)->result_array();
			$count_list = $this->sales_model->sales_order_list_count($search, $start_date, $end_date, $customer_filter)->result_array();
			$total_row = $count_list[0]['total_row'];
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $field) {

				if($field['hd_sales_order_status'] == 'Pending'){
					$hd_sales_order_status = '<span class="badge badge-info">Pending</span>';
				}else if($field['hd_sales_order_status'] == 'Success'){
					$hd_sales_order_status = '<span class="badge badge-success">Success</span>';
				}else{
					$hd_sales_order_status = '<span class="badge badge-danger">Cancel</span>';
				}

				if($field['hd_sales_order_remaining_debt'] > 0){
					$hd_sales_remaining_debt = '<span class="badge badge-danger">Belum Lunas</span>';
				}else{
					$hd_sales_remaining_debt = '<span class="badge badge-success">Lunas</span>';
				}

				if($check_auth[0]->view == 'Y'){
					$url = base_url();
					$detail = '<a href="'.base_url().'Sales/detailsalesorder?id='.$field['hd_sales_order_id'].'" data-fancybox="" data-type="iframe"><button type="button" class="btn btn-icon btn-primary btn-sm mb-2-btn" data-id="'.$field['hd_sales_order_id'].'"><i class="fas fa-eye sizing-fa"></i></button></a> ';
				}else{
					$detail = '<a href="'.base_url().'Sales/detailsalesorder?id='.$field['hd_sales_order_id'].'" data-fancybox="" data-type="iframe"><button type="button" class="btn btn-icon btn-primary btn-sm mb-2-btn" disabled="disabled"><i class="fas fa-eye sizing-fa"></i></button></a> ';
				}

				$disable = ($check_auth[0]->edit != 'Y' || in_array($field['hd_sales_order_status'], ['Cancel', 'Success']));

				$print = '<button type="button" class="btn btn-icon btn-warning delete btn-sm mb-2-btn" data-id="'.$field['hd_sales_order_id'].'" data-bs-toggle="modal" data-bs-target="#print"><i class="fas fa-print sizing-fa"></i></button> ';

				if($disable){
					$edit = '<a>
								<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" disabled>
									<i class="fas fa-edit sizing-fa"></i>
								</button>
							</a>';
				}else{
					$edit = '<a href="'.base_url().'Sales/editsalesorder?id='.$field['hd_sales_order_id'].'">
								<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn">
									<i class="fas fa-edit sizing-fa"></i>
								</button>
							</a>';
				}

				if($check_auth[0]->delete == 'Y'){
					if($field['hd_sales_order_status'] != 'Success'){
						$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn" onclick="deletes('.$field['hd_sales_order_id'].')"><i class="fas fa-trash-alt sizing-fa"></i></button> ';
					}else{
						$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn"  disabled="disabled"><i class="fas fa-trash-alt sizing-fa"></i></button> ';
					}
				}else{
					$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn"  disabled="disabled"><i class="fas fa-trash-alt sizing-fa"></i></button> ';
				}

				$date = date_create($field['hd_sales_order_date']); 
				$no++;
				$row = array();
				$row[] 	= $field['hd_sales_order_inv'];
				$row[] 	= date_format($date,"d-M-Y");
				$row[] 	= $field['customer_name'];
				$row[] 	= $field['product_name'];
				$row[] 	= $field['dt_so_qty'];
				$row[] 	= $field['dt_so_rate'];
				$row[] 	= 'Rp. '.number_format($field['hd_sales_order_total']);
				$row[] 	= $field['hd_sales_order_top'];
				$row[] 	= 'Rp. '.number_format($field['hd_sales_order_remaining_debt']);
				$row[] 	= $field['salesman_name'];
				$row[]  = $hd_sales_order_status;
				$row[] 	= $detail.$edit.$delete.$print;
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

	public function detailsalesorder()
	{
		$modul = 'SalesOrder';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$hd_sales_order_id  = $this->input->get('id');
			$header_sales_order['header_sales_order'] = $this->sales_model->header_sales_order($hd_sales_order_id);
			$detail_sales_order['detail_sales_order'] = $this->sales_model->detail_sales_order($hd_sales_order_id); 
			$data['data'] = array_merge($header_sales_order, $detail_sales_order);
			$this->load->view('Pages/Sales/detailsalesorder', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function delete_sales_order()
	{
		$modul = 'SalesOrder';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->delete == 'Y'){
			$sales_order_id  	= $this->input->post('id');
			$header_sales_order = $this->sales_model->header_sales_order($sales_order_id);
			$inv 				= $header_sales_order[0]->hd_sales_order_inv;
			$user_id 			= $_SESSION['user_id'];

			$this->sales_model->delete_sales_order($sales_order_id);
			$data_insert_act = array(
				'activity_table_desc'	       => 'Batalkan Sales Order '.$inv,
				'activity_table_user'	       => $user_id
			);
			$this->global_model->save($data_insert_act);
			$msg = "Succes Delete";
			echo json_encode(['code'=>200, 'result'=>$msg]);
			die();
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);
		}
	}

	public function addsalesorder()
	{
		$modul = 'SalesOrder';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$warehouse_list['warehouse_list'] = $this->masterdata_model->warehouse_list();
			$salesman_list['salesman_list'] = $this->masterdata_model->salesman_list();
			$customer_list['customer_list'] = $this->masterdata_model->customer_list();
			$payment_list['payment_list'] = $this->masterdata_model->payment_list();
			$ekspedisi_list['ekspedisi_list'] = $this->masterdata_model->ekspedisi_list();
			$user_list['user_list'] = $this->masterdata_model->user_list();
			$data['data'] = array_merge($warehouse_list, $salesman_list, $customer_list, $payment_list, $ekspedisi_list, $user_list);
			$this->load->view('Pages/Sales/addsalesorder', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function editsalesorder()
	{
		$modul = 'SalesOrder';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->edit == 'Y'){

			$so_id 		= $this->input->get('id');
			$header_so  = $this->sales_model->header_so($so_id);
			$detail_so  = $this->sales_model->detail_so($so_id);
			$user_id   	= $_SESSION['user_id'];
			$this->sales_model->clear_temp_sales_order($user_id);
			foreach($detail_so as $row){
				$temp_product_id 	 	= $row->dt_so_product_id;
				$temp_so_rate 			= $row->dt_so_rate;
				$temp_so_price     		= $row->dt_so_price;
				$temp_so_qty      		= $row->dt_so_qty;
				$temp_so_discount 		= $row->dt_so_discount;
				$temp_so_total  		= $row->dt_so_total;
				$temp_so_note 			= $row->dt_so_note;
				$temp_user_id  			= $user_id;

				$data_insert = array(
					'temp_product_id'	=> $temp_product_id,
					'temp_so_rate'		=> $temp_so_rate,
					'temp_so_price'		=> $temp_so_price,
					'temp_so_qty'		=> $temp_so_qty,
					'temp_so_discount'	=> $temp_so_discount,
					'temp_so_total'		=> $temp_so_total,
					'temp_so_note'		=> $temp_so_note,
					'temp_user_id'		=> $temp_user_id,
				);

				$this->sales_model->add_temp_so($data_insert);
			}

			$header_so_data['header_so_data']  = $this->sales_model->header_so($so_id);
			$warehouse_list['warehouse_list'] = $this->masterdata_model->warehouse_list();
			$salesman_list['salesman_list'] = $this->masterdata_model->salesman_list();
			$customer_list['customer_list'] = $this->masterdata_model->customer_list();
			$payment_list['payment_list'] = $this->masterdata_model->payment_list();
			$ekspedisi_list['ekspedisi_list'] = $this->masterdata_model->ekspedisi_list();
			$user_list['user_list'] = $this->masterdata_model->user_list();

			$data['data'] = array_merge($warehouse_list, $salesman_list, $customer_list, $payment_list, $ekspedisi_list, $user_list, $header_so_data);
			$this->load->view('Pages/Sales/editsalesorder', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function get_edit_sales_order_data()
	{
		$modul = 'SalesOrder';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->edit == 'Y'){
			$hd_sales_order_id  = $this->input->post('sales_order_id');
			$header_sales_order = $this->sales_model->header_sales_order($hd_sales_order_id);
			$detail_sales_order = $this->sales_model->detail_sales_order($hd_sales_order_id); 
			echo json_encode(['code'=>200, 'header'=>$header_sales_order, 'detail'=>$detail_sales_order]);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function save_salesorder()
	{
		$modul = 'SalesOrder';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){
			$sales_type									= $this->input->post('sales_type');
			$sales_order_customer 						= $this->input->post('sales_order_customer');
			$sales_order_payment						= $this->input->post('sales_order_payment');
			$sales_order_top 							= $this->input->post('sales_order_top');
			$sales_order_top_id 						= $this->input->post('sales_order_top_id');
			$sales_order_salesman 						= $this->input->post('sales_order_salesman');
			$sales_order_prepare 						= $this->input->post('sales_order_prepare');
			//$sales_order_prepare_id 					= $this->input->post('sales_order_prepare_id');
			$sales_order_colly 							= $this->input->post('sales_order_colly');
			$sales_order_warehouse 						= $this->input->post('sales_order_warehouse');
			$sales_order_ekspedisi 						= $this->input->post('sales_order_ekspedisi');
			$footer_sub_total_submit 					= $this->input->post('footer_sub_total_submit');
			$sales_order_due_date 						= $this->input->post('sales_order_due_date');
			$drop_ship									= $this->input->post('drop_ship');
			$dropship_name							    = $this->input->post('dropship_name');
			$dropship_phone							    = $this->input->post('dropship_phone');
			$dropship_address							= $this->input->post('dropship_address');
			$sales_order_date 							= $this->input->post('sales_order_date');
			$footer_total_discount_submit 				= $this->input->post('footer_total_discount_submit');
			$edit_footer_discount_percentage1_submit 	= $this->input->post('edit_footer_discount_percentage1_submit');
			$edit_footer_discount_percentage2_submit 	= $this->input->post('edit_footer_discount_percentage2_submit');
			$edit_footer_discount_percentage3_submit 	= $this->input->post('edit_footer_discount_percentage3_submit');
			$edit_footer_discount1_submit 				= $this->input->post('edit_footer_discount1_submit');
			$edit_footer_discount2_submit 				= $this->input->post('edit_footer_discount2_submit');
			$edit_footer_discount3_submit 				= $this->input->post('edit_footer_discount3_submit');
			$footer_total_ppn_val 					    = $this->input->post('footer_total_ppn_val');
			$footer_total_invoice_val 					= $this->input->post('footer_total_invoice_val');
			$footer_dp_val 					    		= $this->input->post('footer_dp_val');
			$footer_remaining_debt_val 					= $this->input->post('footer_remaining_debt_val');
			$sales_order_remark 						= $this->input->post('sales_order_remark');
			$user_id 									= $_SESSION['user_id'];

			if($sales_order_customer == null){
				$msg = 'Silahkan Masukan Customer';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($sales_order_top == null){
				$msg = 'Silahkan Masukan TOP';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($sales_order_salesman == null){
				$msg = 'Silahkan Masukan Salesman';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($sales_order_payment == null){
				$msg = 'Silahkan Masukan Jenis Pembayaran';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($sales_order_warehouse == null){
				$msg = 'Silahkan Masukan Gudang';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($sales_order_ekspedisi == null){
				$msg = 'Silahkan Masukan Ekspedisi';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($footer_total_invoice_val <= 0){
				$msg = 'Silahkan Input Data Terlebih Dahulu';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			$warehouse_id 		= $sales_order_warehouse;
			$get_warehouse_code = $this->masterdata_model->get_warehouse_code($warehouse_id);
			$warehouse_code 	= $get_warehouse_code[0]->warehouse_code;
			$warehouse_name 	= $get_warehouse_code[0]->warehouse_name;

			$customer_id = $sales_order_customer;
			$get_customer_code = $this->masterdata_model->get_customer_code($customer_id);
			$customer_code = $get_customer_code[0]->customer_code;
			$customer_name = $get_customer_code[0]->customer_name;
			

			$maxCode  = $this->sales_model->last_so_inv();
			$inv_code = 'J/'.$customer_code.'/'.$warehouse_code.'/'.date("d/m/Y").'/';
			if ($maxCode == NULL) {
				$last_code = $inv_code.'000001';
			} else {
				$maxCode   = $maxCode[0]->hd_sales_order_inv;
				$last_code = substr($maxCode, -6);
				$last_code = $inv_code.substr('000000' . strval(floatval($last_code) + 1), -6);
			}

			if($sales_order_top_id == 1){
				$footer_dp_val = $footer_total_invoice_val;
				$footer_remaining_debt_val = 0;
			}

			$data_insert = array(
				'hd_sales_order_inv'				=> $last_code,
				'hd_sales_order_customer'			=> $sales_order_customer,
				'hd_sales_order_payment'			=> $sales_order_payment,
				'hd_sales_order_ekspedisi'			=> $sales_order_ekspedisi,
				'hd_sales_order_top'				=> $sales_order_top,
				'hd_sales_order_top_id'				=> $sales_order_top_id,
				'hd_sales_order_due_date'			=> $sales_order_due_date,

				'hd_sales_order_dropship'			=> $drop_ship,
				'hd_sales_order_dropship_name'		=> $dropship_name,
				'hd_sales_order_dropship_phone'		=> $dropship_phone,
				'hd_sales_order_dropship_address'	=> $dropship_address,

				'hd_sales_order_salesman'			=> $sales_order_salesman,
				'hd_sales_order_prepare'			=> $sales_order_prepare,
				//'hd_sales_order_prepare_id'			=> $sales_order_prepare_id,
				'hd_sales_order_colly'				=> $sales_order_colly,
				'hd_sales_order_date'				=> $sales_order_date,
				'hd_sales_order_warehouse'			=> $sales_order_warehouse,
				'hd_sales_order_sub_total'			=> $footer_sub_total_submit,
				'hd_sales_order_percentage1'		=> $edit_footer_discount_percentage1_submit,
				'hd_sales_order_percentage2'		=> $edit_footer_discount_percentage2_submit,
				'hd_sales_order_percentage3'		=> $edit_footer_discount_percentage3_submit,
				'hd_sales_order_disc1'				=> $edit_footer_discount1_submit,
				'hd_sales_order_disc2'				=> $edit_footer_discount2_submit,
				'hd_sales_order_disc3'				=> $edit_footer_discount3_submit,
				'hd_sales_order_total_discount'		=> $footer_total_discount_submit,
				'hd_sales_order_ppn'			    => $footer_total_ppn_val,
				'hd_sales_order_total'				=> $footer_total_invoice_val,
				'hd_sales_order_dp'					=> $footer_dp_val,
				'hd_sales_order_remaining_debt'		=> $footer_remaining_debt_val,
				'hd_sales_order_note'				=> $sales_order_remark,
				'created_by'						=> $user_id
			);	
			$save_sales_order = $this->sales_model->save_sales_order($data_insert);


			$get_temp_sales_order = $this->sales_model->get_temp_sales_order($user_id)->result_array();
			foreach($get_temp_sales_order  as $row){
				$data_insert_detail = array(
					'hd_sales_order_id'		=> $save_sales_order,
					'dt_so_product_id'		=> $row['temp_product_id'],
					'dt_so_rate'			=> $row['temp_so_rate'],
					'dt_so_price'			=> $row['temp_so_price'],
					'dt_so_qty'				=> $row['temp_so_qty'],
					'dt_so_discount'		=> $row['temp_so_discount'],
					'dt_so_total'			=> $row['temp_so_total'],
					'dt_so_note'			=> $row['temp_so_note']
				);

				$save_detail_sales_order = $this->sales_model->save_detail_sales_order($data_insert_detail);
			}


			$data_insert_act = array(
				'activity_table_desc'	       => 'Tambah Sales Order Cabang '.$warehouse_name.' '.$last_code.'',
				'activity_table_user'	       => $user_id,
			);

			$this->global_model->save($data_insert_act);

			$this->sales_model->clear_temp_sales_order($user_id);

			$msg = 'Success Tambah';
			echo json_encode(['code'=>200, 'result'=>$msg]);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function edit_save_salesorder()
	{
		$modul = 'SalesOrder';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->edit == 'Y'){
			$sales_order_id								= $this->input->post('sales_order_id');
			$sales_order_invoice 						= $this->input->post('sales_order_invoice');
			$sales_type									= $this->input->post('sales_type');
			$sales_order_customer 						= $this->input->post('sales_order_customer');
			$sales_order_payment						= $this->input->post('sales_order_payment');
			$sales_order_top 							= $this->input->post('sales_order_top');
			$sales_order_top_id 						= $this->input->post('sales_order_top_id');
			$sales_order_salesman 						= $this->input->post('sales_order_salesman');
			$sales_order_prepare 						= $this->input->post('sales_order_prepare');
			//$sales_order_prepare_id 					= $this->input->post('sales_order_prepare_id');
			$sales_order_colly 							= $this->input->post('sales_order_colly');
			$sales_order_warehouse 						= $this->input->post('sales_order_warehouse');
			$sales_order_ekspedisi 						= $this->input->post('sales_order_ekspedisi');
			$footer_sub_total_submit 					= $this->input->post('footer_sub_total_submit');
			$sales_order_due_date 						= $this->input->post('sales_order_due_date');
			$drop_ship									= $this->input->post('drop_ship');
			$dropship_name							    = $this->input->post('dropship_name');
			$dropship_phone							    = $this->input->post('dropship_phone');
			$dropship_address							= $this->input->post('dropship_address');
			$sales_order_date 							= $this->input->post('sales_order_date');
			$footer_total_discount_submit 				= $this->input->post('footer_total_discount_submit');
			$edit_footer_discount_percentage1_submit 	= $this->input->post('edit_footer_discount_percentage1_submit');
			$edit_footer_discount_percentage2_submit 	= $this->input->post('edit_footer_discount_percentage2_submit');
			$edit_footer_discount_percentage3_submit 	= $this->input->post('edit_footer_discount_percentage3_submit');
			$edit_footer_discount1_submit 				= $this->input->post('edit_footer_discount1_submit');
			$edit_footer_discount2_submit 				= $this->input->post('edit_footer_discount2_submit');
			$edit_footer_discount3_submit 				= $this->input->post('edit_footer_discount3_submit');
			$footer_total_ppn_val 					    = $this->input->post('footer_total_ppn_val');
			$footer_total_invoice_val 					= $this->input->post('footer_total_invoice_val');
			$footer_dp_val 					    		= $this->input->post('footer_dp_val');
			$footer_remaining_debt_val 					= $this->input->post('footer_remaining_debt_val');
			$sales_order_remark 						= $this->input->post('sales_order_remark');
			$user_id 									= $_SESSION['user_id'];

			if($sales_order_customer == null){
				$msg = 'Silahkan Masukan Customer';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($sales_order_top == null){
				$msg = 'Silahkan Masukan TOP';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($sales_order_salesman == null){
				$msg = 'Silahkan Masukan Salesman';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($sales_order_payment == null){
				$msg = 'Silahkan Masukan Jenis Pembayaran';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($sales_order_warehouse == null){
				$msg = 'Silahkan Masukan Gudang';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($sales_order_ekspedisi == null){
				$msg = 'Silahkan Masukan Ekspedisi';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($footer_total_invoice_val <= 0){
				$msg = 'Silahkan Input Data Terlebih Dahulu';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			$warehouse_id 		= $sales_order_warehouse;
			$get_warehouse_code = $this->masterdata_model->get_warehouse_code($warehouse_id);
			$warehouse_code 	= $get_warehouse_code[0]->warehouse_code;
			$warehouse_name 	= $get_warehouse_code[0]->warehouse_name;

			$customer_id = $sales_order_customer;
			$get_customer_code = $this->masterdata_model->get_customer_code($customer_id);
			$customer_code = $get_customer_code[0]->customer_code;
			$customer_name = $get_customer_code[0]->customer_name;

			if($sales_order_top_id == 1){
				$footer_dp_val = $footer_total_invoice_val;
				$footer_remaining_debt_val = 0;
			}

			$data_insert = array(
				'hd_sales_order_inv'				=> $sales_order_invoice,
				'hd_sales_order_customer'			=> $sales_order_customer,
				'hd_sales_order_payment'			=> $sales_order_payment,
				'hd_sales_order_ekspedisi'			=> $sales_order_ekspedisi,
				'hd_sales_order_top'				=> $sales_order_top,
				'hd_sales_order_top_id'				=> $sales_order_top_id,
				'hd_sales_order_due_date'			=> $sales_order_due_date,

				'hd_sales_order_dropship'			=> $drop_ship,
				'hd_sales_order_dropship_name'		=> $dropship_name,
				'hd_sales_order_dropship_phone'		=> $dropship_phone,
				'hd_sales_order_dropship_address'	=> $dropship_address,

				'hd_sales_order_salesman'			=> $sales_order_salesman,
				'hd_sales_order_prepare'			=> $sales_order_prepare,
				//'hd_sales_order_prepare_id'			=> $sales_order_prepare_id,
				'hd_sales_order_colly'				=> $sales_order_colly,
				'hd_sales_order_date'				=> $sales_order_date,
				'hd_sales_order_warehouse'			=> $sales_order_warehouse,
				'hd_sales_order_sub_total'			=> $footer_sub_total_submit,
				'hd_sales_order_percentage1'		=> $edit_footer_discount_percentage1_submit,
				'hd_sales_order_percentage2'		=> $edit_footer_discount_percentage2_submit,
				'hd_sales_order_percentage3'		=> $edit_footer_discount_percentage3_submit,
				'hd_sales_order_disc1'				=> $edit_footer_discount1_submit,
				'hd_sales_order_disc2'				=> $edit_footer_discount2_submit,
				'hd_sales_order_disc3'				=> $edit_footer_discount3_submit,
				'hd_sales_order_total_discount'		=> $footer_total_discount_submit,
				'hd_sales_order_ppn'			    => $footer_total_ppn_val,
				'hd_sales_order_total'				=> $footer_total_invoice_val,
				'hd_sales_order_dp'					=> $footer_dp_val,
				'hd_sales_order_remaining_debt'		=> $footer_remaining_debt_val,
				'hd_sales_order_note'				=> $sales_order_remark,
				'created_by'						=> $user_id
			);	
			$save_sales_order = $this->sales_model->edit_sales_order($data_insert, $sales_order_id);

			$delete_detail_sales_order = $this->sales_model->delete_detail_sales_order($sales_order_id);
			$get_temp_sales_order = $this->sales_model->get_temp_sales_order($user_id)->result_array();
			foreach($get_temp_sales_order  as $row){
				$data_insert_detail = array(
					'hd_sales_order_id'		=> $sales_order_id,
					'dt_so_product_id'		=> $row['temp_product_id'],
					'dt_so_rate'			=> $row['temp_so_rate'],
					'dt_so_price'			=> $row['temp_so_price'],
					'dt_so_qty'				=> $row['temp_so_qty'],
					'dt_so_discount'		=> $row['temp_so_discount'],
					'dt_so_total'			=> $row['temp_so_total'],
					'dt_so_note'			=> $row['temp_so_note']
				);

				$save_detail_sales_order = $this->sales_model->save_detail_sales_order($data_insert_detail);
			}

			
			$data_insert_act = array(
				'activity_table_desc'	       => 'Edit Sales Order Cabang '.$warehouse_name.' '.$sales_order_invoice.'',
				'activity_table_user'	       => $user_id,
			);

			$this->global_model->save($data_insert_act);

			$this->sales_model->clear_temp_sales_order($user_id);

			$msg = 'Success Tambah';
			echo json_encode(['code'=>200, 'result'=>$msg]);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function temp_salesorder_list()
	{
		$modul = 'SalesOrder';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$search 			= $this->input->post('search');
			$length 			= $this->input->post('length');
			$start 			  	= $this->input->post('start');
			$user 				= $_SESSION['user_id'];

			if($search != null){
				$search = $search['value'];
			}
			$list = $this->sales_model->temp_salesorder_list($search, $length, $start, $user)->result_array();
			$count_list = $this->sales_model->temp_salesorder_list_count($search, $user)->result_array();
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
				$row[] 	= $field['temp_so_rate'];
				$row[] 	= $field['temp_so_qty'];
				$row[] 	= 'Rp. '.number_format($field['temp_so_price']);
				$row[] 	= 'Rp. '.number_format($field['temp_so_discount']);
				$row[] 	= 'Rp. '.number_format($field['temp_so_total']);
				$row[] 	= $field['temp_so_note'];
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

	public function add_temp_sales_order()
	{
		$modul = 'SalesOrder';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){
			$warehouse_id 				= $this->input->post('warehouse_id');
			$product_id 				= $this->input->post('product_id');
			$temp_rate 					= $this->input->post('temp_rate');
			$temp_qty  					= $this->input->post('temp_qty');
			$temp_price_val 			= $this->input->post('temp_price_val');
			$temp_discount_val 			= $this->input->post('temp_discount_val');
			$temp_total_val 			= $this->input->post('temp_total_val');
			$temp_note 					= $this->input->post('temp_note');
			$user_id 					= $_SESSION['user_id'];

			if($warehouse_id == null){
				$msg = "Silahkan Pilih Gudang / Cabang Terlebih Dahulu";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($warehouse_id != 1){
				$check_stock  = $this->sales_model->check_stock($product_id, $warehouse_id);
				if($check_stock == null){
					$msg = "Stock Tidak Ada Di Gudang";
					echo json_encode(['code'=>0, 'result'=>$msg]);die();
				}else if($check_stock[0]->stock < $temp_qty)
				{
					$msg = "Stock Tidak Cukup";
					echo json_encode(['code'=>0, 'result'=>$msg]);die();
				}
			}

			$check_temp_so_input = $this->sales_model->check_temp_so_input($product_id, $user_id);
			$data_insert = array(
				'temp_product_id'		=> $product_id,
				'temp_so_rate'			=> $temp_rate,
				'temp_so_price'			=> $temp_price_val,
				'temp_so_qty'			=> $temp_qty,
				'temp_so_discount'		=> $temp_discount_val,
				'temp_so_total'			=> $temp_total_val,
				'temp_so_note'			=> $temp_note,
				'temp_user_id'			=> $user_id
			);	
			$msg = 'Success Tambah';
			if($check_temp_so_input != null){
				$this->sales_model->edit_temp_so($product_id, $user_id, $data_insert);
			}else{
				$this->sales_model->add_temp_so($data_insert);
			}
			echo json_encode(['code'=>200, 'result'=>$msg]);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function get_edit_temp_so()
	{
		$temp_product_id  	= $this->input->post('id');
		$temp_user_id  	  	= $_SESSION['user_id'];
		$check_edit_temp_so = $this->sales_model->check_edit_temp_so($temp_product_id, $temp_user_id)->result_array();
		echo json_encode(['code'=>200, 'result'=>$check_edit_temp_so]);
		die();
	}

	public function check_temp_so()
	{
		$user_id 		= $_SESSION['user_id'];
		$check_temp_so  = $this->sales_model->check_temp_so($user_id)->result_array();
		echo json_encode(['code'=>200, 'data'=>$check_temp_so]);
		die();
	}

	public function clear_temp()
	{
		$user_id 		= $_SESSION['user_id'];
		$this->sales_model->clear_temp_sales_order($user_id);
		echo json_encode(['code'=>200, 'data'=>"Cler Success"]);
	}

	public function clear_temp_sales()
	{
		$user_id 		= $_SESSION['user_id'];
		$this->sales_model->clear_temp_sales($user_id);
		echo json_encode(['code'=>200, 'data'=>"Cler Success"]);
	} 

	public function delete_temp_so()
	{
		$modul = 'SalesOrder';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){
			$product_id  = $this->input->post('id');
			$user_id 	 = $_SESSION['user_id'];
			$this->sales_model->delete_temp_so($product_id, $user_id);
			$msg = 'Success Delete';
			echo json_encode(['code'=>200, 'result'=>$msg]);
			die();
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);
		}
	}

	// end sales order

	// sales

	public function salespage()
	{
		$modul = 'Sales';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$warehouse_list['warehouse_list'] = $this->masterdata_model->warehouse_list();
			$salesman_list['salesman_list'] = $this->masterdata_model->salesman_list();
			$customer_list['customer_list'] = $this->masterdata_model->customer_list();
			$payment_list['payment_list'] = $this->masterdata_model->payment_list();
			$ekspedisi_list['ekspedisi_list'] = $this->masterdata_model->ekspedisi_list();
			$user_list['ekspedisi_list'] = $this->masterdata_model->ekspedisi_list();
			$data['data'] = array_merge($warehouse_list, $salesman_list, $customer_list, $payment_list, $ekspedisi_list, $user_list);
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
		if($check_auth[0]->view == 'Y'){
			$search 				= $this->input->post('search');
			$length 				= $this->input->post('length');
			$start 			  		= $this->input->post('start');
			$cat 			  		= $this->input->post('cat');
			$start_date 			= $this->input->post('start_date');
			$end_date 			  	= $this->input->post('end_date');
			$customer_filter 		= $this->input->post('customer_filter');
			$payment_status_filter	= $this->input->post('status_payment_filter');

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
					$hd_sales_remaining_debt = '<span class="badge badge-danger">Belum Lunas</span>';
				}else{
					$hd_sales_remaining_debt = '<span class="badge badge-success">Lunas</span>';
				}

				if($check_auth[0]->view == 'Y'){
					$url = base_url();
					$detail = '<a href="'.base_url().'Sales/detailsales?id='.$field['hd_sales_id'].'" data-fancybox="" data-type="iframe"><button type="button" class="btn btn-icon btn-primary btn-sm mb-2-btn" data-id="'.$field['hd_sales_order_id'].'"><i class="fas fa-eye sizing-fa"></i></button></a> ';
				}else{
					$detail = '<a href="'.base_url().'Sales/detailsales?id='.$field['hd_sales_id'].'" data-fancybox="" data-type="iframe"><button type="button" class="btn btn-icon btn-primary btn-sm mb-2-btn" disabled="disabled"><i class="fas fa-eye sizing-fa"></i></button></a> ';
				}


				if($check_auth[0]->delete == 'Y'){
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
				$row[] 	= $field['customer_rate'];
				$row[] 	= $field['product_name'];
				$row[] 	= $field['dt_sales_qty'];
				$row[] 	= 'Rp. '.number_format($field['hd_sales_total']);
				$row[] 	= $field['hd_sales_top'];
				$row[] 	= 'Rp. '.number_format($field['hd_sales_remaining_debt']);
				$row[] 	= $field['ekspedisi_name'];
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

	public function delete_sales()
	{
		$modul = 'Sales';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->delete == 'Y'){
			$sales_id  			= $this->input->post('id');
			$header_sales 		= $this->sales_model->header_sales($sales_id);
			$detail_sales 		= $this->sales_model->detail_sales($sales_id);
			$inv 				= $header_sales[0]->hd_sales_inv;
			$user_id 			= $_SESSION['user_id'];

		

			$check_payment_status = $this->sales_model->check_payment_receivable($sales_id)->result_array();
			if($check_payment_status != null){
				$msg = "Transaksi Ini Sudah Pernah Melakukan Pembayaran Piutang";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			$this->sales_model->delete_sales($sales_id);
			foreach($detail_sales as $row)
			{
				$product_id = $row->dt_sales_product_id;
				$qty_sell 	= $row->dt_sales_qty;
			}
			
			$data_insert_act = array(
				'activity_table_desc'	       => 'Batalkan Penjualan '.$inv,
				'activity_table_user'	       => $user_id
			);
			$this->global_model->save($data_insert_act);
			$msg = "Succes Delete";
			echo json_encode(['code'=>200, 'result'=>$msg]);
			die();
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);
		}
	}

	public function detailsales()
	{
		$modul = 'Sales';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
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
		if($check_auth[0]->view == 'Y'){
			$warehouse_list['warehouse_list'] = $this->masterdata_model->warehouse_list();
			$salesman_list['salesman_list'] = $this->masterdata_model->salesman_list();
			$customer_list['customer_list'] = $this->masterdata_model->customer_list();
			$payment_list['payment_list'] = $this->masterdata_model->payment_list();
			$ekspedisi_list['ekspedisi_list'] = $this->masterdata_model->ekspedisi_list();
			$user_list['user_list'] = $this->masterdata_model->user_list();
			$data['data'] = array_merge($warehouse_list, $salesman_list, $customer_list, $payment_list, $ekspedisi_list, $user_list);
			$this->load->view('Pages/Sales/addsales', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function printnota()
	{
		$modul = 'Sales';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$id  	      = $this->input->get('print_type');
			$hd_sales_id  = $this->input->get('sales_id');
			$header_sales['header_sales'] = $this->sales_model->header_sales($hd_sales_id);
			$detail_sales['detail_sales'] = $this->sales_model->detail_sales($hd_sales_id);
			$data['data'] = array_merge($header_sales, $detail_sales);
			if($id == 1){
				$this->load->view('Pages/Sales/printnota', $data);
			}else if($id == 2){
				$this->load->view('Pages/Sales/printnotapengambilan', $data);
			}else if($id == 3){
				$this->load->view('Pages/Sales/printnotalunas', $data);
			}else if($id == 4){
				$this->load->view('Pages/Sales/printnotanormal', $data);
			}else{
				$this->load->view('Pages/Sales/printdispatch', $data);
			}
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function printnota_so()
	{
		$modul = 'Sales';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$id  	      = $this->input->get('print_type');
			$hd_sales_order_id  = $this->input->get('sales_order_id');
			$header_sales_so['header_sales_so'] = $this->sales_model->header_sales_order($hd_sales_order_id);
			$detail_sales_so['detail_sales_so'] = $this->sales_model->detail_sales_order($hd_sales_order_id);
			$data['data'] = array_merge($header_sales_so, $detail_sales_so);
			if($id == 1){
				$this->load->view('Pages/Sales/printnotaso', $data);
			}else{
				$this->load->view('Pages/Sales/printnotapengambilanso', $data);
			}
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function temp_sales_list()
	{
		$modul = 'Sales';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
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
				$row[] 	= $field['temp_sales_rate'];
				$row[] 	= $field['temp_sales_qty'];
				$row[] 	= 'Rp. '.number_format($field['temp_sales_price']);
				$row[] 	= 'Rp. '.number_format($field['temp_sales_discount']);
				$row[] 	= $field['temp_desc_item'];
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

	public function add_temp_sales()
	{
		$modul = 'Sales';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){
			$warehouse_id 				= $this->input->post('warehouse_id');
			$product_id 				= $this->input->post('product_id');
			$temp_rate 					= $this->input->post('temp_rate');
			$temp_qty  					= $this->input->post('temp_qty');
			$temp_price_val 			= $this->input->post('temp_price_val');
			$temp_discount_val 			= $this->input->post('temp_discount_val');
			$temp_total_val 			= $this->input->post('temp_total_val');
			$desc_item 					= $this->input->post('desc_item');
			$user_id 					= $_SESSION['user_id'];

			if($warehouse_id == null){
				$msg = "Silahkan Pilih Gudang / Cabang Terlebih Dahulu";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}


			if($warehouse_id != 1){
				$check_stock  = $this->sales_model->check_stock($product_id, $warehouse_id);
				if($check_stock == null){
					$msg = "Stock Tidak Ada Di Gudang";
					echo json_encode(['code'=>0, 'result'=>$msg]);die();
				}else if($check_stock[0]->stock < $temp_qty)
				{
					$msg = "Stock Tidak Cukup";
					echo json_encode(['code'=>0, 'result'=>$msg]);die();
				}
			}

			$check_temp_sales_input = $this->sales_model->check_temp_sales_input($product_id, $user_id);
			$data_insert = array(
				'temp_product_id'			=> $product_id,
				'temp_sales_rate'			=> $temp_rate,
				'temp_sales_price'			=> $temp_price_val,
				'temp_sales_qty'			=> $temp_qty,
				'temp_sales_discount'		=> $temp_discount_val,
				'temp_sales_total'			=> $temp_total_val,
				'temp_desc_item'			=> $desc_item,
				'temp_user_id'				=> $user_id
			);	
			$msg = 'Success Tambah';
			if($check_temp_sales_input != null){
				$this->sales_model->edit_temp_sales($product_id, $user_id, $data_insert);
			}else{
				$this->sales_model->add_temp_sales($data_insert);
			}
			echo json_encode(['code'=>200, 'result'=>$msg]);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function get_edit_temp_sales()
	{
		$temp_product_id  	   = $this->input->post('id');
		$temp_user_id  	  	   = $_SESSION['user_id'];
		$check_edit_temp_sales = $this->sales_model->check_edit_temp_sales($temp_product_id, $temp_user_id)->result_array();
		echo json_encode(['code'=>200, 'result'=>$check_edit_temp_sales]);
		die();
	}

	public function check_temp_sales()
	{
		$user_id 			= $_SESSION['user_id'];
		$check_temp_sales   = $this->sales_model->check_temp_sales($user_id)->result_array();
		echo json_encode(['code'=>200, 'data'=>$check_temp_sales]);
		die();
	}

	public function search_so()
	{
		$keyword = $this->input->get('term');
		$result = ['success' => FALSE, 'num_product' => 0, 'data' => [], 'message' => ''];
		if (!($keyword == '' || $keyword == NULL)) {
			$find = $this->sales_model->search_so($keyword)->result_array();
			$find_result = [];
			foreach ($find as $row) {
				$diplay_text = $row['hd_sales_order_inv'];
				$find_result[] = [
					'id'                  => $row['hd_sales_order_id'],
					'value'               => $diplay_text
				];
			}
			$result = ['success' => TRUE, 'num_product' => count($find_result), 'data' => $find_result, 'message' => ''];
		}
		echo json_encode($result);
	}

	public function get_header_so()
	{
		$so_id 				= $this->input->post('id');
		$user_id 			= $_SESSION['user_id'];
		$this->sales_model->clear_temp_sales($user_id);
		$get_dt_so = $this->sales_model->get_dt_so($so_id);
		foreach($get_dt_so as $row)
		{
			$data_insert = array(
				'temp_product_id'			=> $row->dt_so_product_id,
				'temp_so_id'				=> $so_id,
				'temp_sales_rate'			=> $row->dt_so_rate,
				'temp_sales_price'			=> $row->dt_so_price,
				'temp_sales_qty'			=> $row->dt_so_qty,
				'temp_sales_discount'		=> $row->dt_so_discount,
				'temp_sales_total'			=> $row->dt_so_total,
				'temp_user_id'				=> $user_id
			);
			$this->sales_model->add_temp_sales($data_insert);
		}
		$get_hd_so = $this->sales_model->get_hd_so($so_id);
		echo json_encode(['code'=>200, 'data'=>$get_hd_so]);
	}

	public function refresh_header_so()
	{
		$user_id 			  = $_SESSION['user_id'];
		$get_temp_sales_so_id = $this->sales_model->get_temp_sales_so_id($user_id);
		if($get_temp_sales_so_id != null){
			$so_id 		= $get_temp_sales_so_id[0]->temp_so_id; 
			$get_hd_so  = $this->sales_model->get_hd_so($so_id);
		}else{
			$get_hd_so = 0;
		}
		echo json_encode(['code'=>200, 'data'=>$get_hd_so]);
	}

	public function save_sales()
	{
		$modul = 'Sales';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){
			$sales_customer             			  = $this->input->post('sales_customer');
			$sales_order_id  						  = $this->input->post('sales_order_id');
			$sales_payment            				  = $this->input->post('sales_payment');
			$sales_top              				  = $this->input->post('sales_top');
			$sales_top_id             				  = $this->input->post('sales_top_id');
			$drop_ship						  		  = $this->input->post('drop_ship');
			$dropship_name						  	  = $this->input->post('dropship_name');
			$dropship_phone						      = $this->input->post('dropship_phone');
			$dropship_address						  = $this->input->post('dropship_address');
			$sales_salesman             			  = $this->input->post('sales_salesman');
			$sales_prepare            				  = $this->input->post('sales_prepare');
			$sales_prepare_id           			  = $this->input->post('sales_prepare_id');
			$sales_colly              				  = $this->input->post('sales_colly');
			$sales_warehouse            			  = $this->input->post('sales_warehouse');
			$sales_ekspedisi            			  = $this->input->post('sales_ekspedisi');
			$footer_sub_total_submit          		  = $this->input->post('footer_sub_total_submit');
			$sales_due_date             			  = $this->input->post('sales_due_date');
			$sales_date               				  = $this->input->post('sales_date');
			$footer_total_discount_submit        	  = $this->input->post('footer_total_discount_submit');
			$edit_footer_discount_percentage1_submit  = $this->input->post('edit_footer_discount_percentage1_submit');
			$edit_footer_discount_percentage2_submit  = $this->input->post('edit_footer_discount_percentage2_submit');
			$edit_footer_discount_percentage3_submit  = $this->input->post('edit_footer_discount_percentage3_submit');
			$edit_footer_discount1_submit         	  = $this->input->post('edit_footer_discount1_submit');
			$edit_footer_discount2_submit         	  = $this->input->post('edit_footer_discount2_submit');
			$edit_footer_discount3_submit         	  = $this->input->post('edit_footer_discount3_submit');
			$footer_total_ppn_val                     = $this->input->post('footer_total_ppn_val');
			$footer_total_invoice_val           	  = $this->input->post('footer_total_invoice_val');
			$footer_dp_val                  		  = $this->input->post('footer_dp_val');
			$footer_remaining_debt_val          	  = $this->input->post('footer_remaining_debt_val');
			$sales_remark             				  = $this->input->post('sales_remark');
			$user_id                  			      = $_SESSION['user_id'];

			if($sales_customer == null){
				$msg = 'Silahkan Masukan Customer';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($sales_top == null){
				$msg = 'Silahkan Masukan TOP';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($sales_salesman == null){
				$msg = 'Silahkan Masukan Salesman';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($sales_payment == null){
				$msg = 'Silahkan Masukan Jenis Pembayaran';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($sales_warehouse == null){
				$msg = 'Silahkan Masukan Gudang';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($sales_ekspedisi == null){
				$msg = 'Silahkan Masukan Ekspedisi';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($footer_total_invoice_val <= 0){
				$msg = 'Silahkan Input Data Terlebih Dahulu';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($sales_top_id == 0){
				$footer_dp_val = $footer_total_invoice_val;
				$footer_remaining_debt_val = 0;
			}

			$warehouse_id     = $sales_warehouse;
			$get_warehouse_code = $this->masterdata_model->get_warehouse_code($warehouse_id);
			$warehouse_code   = $get_warehouse_code[0]->warehouse_code;
			$warehouse_name   = $get_warehouse_code[0]->warehouse_name;

			$customer_id = $sales_customer;
			$get_customer_code = $this->masterdata_model->get_customer_code($customer_id);
			$customer_code = $get_customer_code[0]->customer_code;
			$customer_name = $get_customer_code[0]->customer_name;


			$maxCode  = $this->sales_model->last_sales_inv();
			
			$inv_code = 'PJ/'.$customer_code.'/'.$warehouse_code.'/'.date("d/m/Y").'/';
			if ($maxCode == NULL) {
				$last_code = $inv_code.'000001';
			} else {
				$maxCode   = $maxCode[0]->hd_sales_inv;
				$last_code = substr($maxCode, -6);
				$last_code = $inv_code.substr('000000' . strval(floatval($last_code) + 1), -6);
			}
			$get_temp_sales_check_stock = $this->sales_model->get_temp_sales($user_id)->result_array();
			if($warehouse_id != 1){
				foreach($get_temp_sales_check_stock as $row){
					$product_id 			= $row['temp_product_id'];
					$qty 					= $row['temp_sales_qty'];
					$product_name 			= $row['product_name'];
					$get_last_stock_check 	= $this->purchase_model->get_last_stock($product_id, $warehouse_id);
					if($get_last_stock_check == null){
						$msg = "Tidak Ada Stock ".$product_name." Di Gudang";
						echo json_encode(['code'=>0, 'result'=>$msg]);die();
					}else{
						$stock_now          = $get_last_stock_check[0]->stock;
						if($stock_now < $qty){
							$msg = "Stock ".$product_name." Tidak Cukup";
							echo json_encode(['code'=>0, 'result'=>$msg]);die();
						}
					}	
				}
			}

			$get_temp_sales = $this->sales_model->get_temp_sales($user_id)->result_array();
			$data_insert = array(
				'hd_sales_inv'            	=> $last_code,
				'hd_sales_order_id'     	=> $sales_order_id,
				'hd_sales_customer'     	=> $sales_customer,
				'hd_sales_payment'      	=> $sales_payment,
				'hd_sales_ekspedisi'      	=> $sales_ekspedisi,
				'hd_sales_top'        		=> $sales_top,
				'hd_sales_top_id'			=> $sales_top_id,
				'hd_sales_due_date'			=> $sales_due_date,
				'hd_sales_dropship'			=> $drop_ship,
				'hd_sales_dropship_name'    => $dropship_name,
				'hd_sales_dropship_phone'   => $dropship_phone,
				'hd_sales_dropship_address' => $dropship_address,
				'hd_sales_salesman'     	=> $sales_salesman,
				'hd_sales_prepare'      	=> $sales_prepare,
				'hd_sales_prepare_id'      	=> $sales_prepare_id,
				'hd_sales_colly'        	=> $sales_colly,
				'hd_sales_date'       		=> $sales_date,
				'hd_sales_warehouse'      	=> $sales_warehouse,
				'hd_sales_sub_total'      	=> $footer_sub_total_submit,
				'hd_sales_percentage1'    	=> $edit_footer_discount_percentage1_submit,
				'hd_sales_percentage2'    	=> $edit_footer_discount_percentage2_submit,
				'hd_sales_percentage3'    	=> $edit_footer_discount_percentage3_submit,
				'hd_sales_disc1'        	=> $edit_footer_discount1_submit,
				'hd_sales_disc2'        	=> $edit_footer_discount2_submit,
				'hd_sales_disc3'        	=> $edit_footer_discount3_submit,
				'hd_sales_total_discount'   => $footer_total_discount_submit,
				'hd_sales_ppn'          	=> $footer_total_ppn_val,
				'hd_sales_total'        	=> $footer_total_invoice_val,
				'hd_sales_dp'         		=> $footer_dp_val,
				'hd_sales_remaining_debt'   => $footer_remaining_debt_val,
				'hd_sales_note'       		=> $sales_remark,
				'created_by'            	=> $user_id
			);  
			$save_sales = $this->sales_model->save_sales($data_insert);

			$get_temp_sales = $this->sales_model->get_temp_sales($user_id)->result_array();
			foreach($get_temp_sales  as $row){
				$data_insert_detail = array(
					'hd_sales_id'   	     => $save_sales,
					'dt_sales_product_id'    => $row['temp_product_id'],
					'dt_sales_rate'          => $row['temp_sales_rate'],
					'dt_sales_price'         => $row['temp_sales_price'],
					'dt_sales_qty'           => $row['temp_sales_qty'],
					'dt_sales_discount'      => $row['temp_sales_discount'],
					'dt_sales_total'         => $row['temp_sales_total'],
					'dt_sales_desc'          => $row['temp_desc_item']
				);
				$save_detail_sales = $this->sales_model->save_detail_sales($data_insert_detail);

				if($warehouse_id != 1){
					$product_id 	= $row['temp_product_id'];
					$qty 			= $row['temp_sales_qty'];
					$get_last_stock = $this->purchase_model->get_last_stock($product_id, $warehouse_id);

					$last_stock 	= $get_last_stock[0]->stock;
					$new_stock 		= $last_stock - $qty;
					$this->global_model->update_stock($product_id, $warehouse_id, $new_stock);

					$movement_stock = array(
						'stock_movement_product_id'		=> $product_id,
						'stock_movement_qty'			=> $qty,
						'stock_movement_before_stock'	=> $last_stock,
						'stock_movement_new_stock'		=> $new_stock,
						'stock_movement_desc'			=> 'Penjualan',
						'stock_movement_inv'			=> $last_code,
						'stock_movement_calculate'		=> 'Minus',
						'stock_movement_date'			=> $sales_date,
						'stock_movement_creted_by'		=> $user_id,	
					);	
					$this->global_model->insert_movement_stock($movement_stock);
				}
			}

			if($sales_order_id != null)
			{
				$this->sales_model->update_sales_order_status($sales_order_id);
			}


			$data_insert_act = array(
				'activity_table_desc'        => 'Tambah Penjualan Cabang '.$warehouse_name.' '.$last_code.'',
				'activity_table_user'        => $user_id,
			);

			$this->global_model->save($data_insert_act);

			$this->sales_model->clear_temp_sales($user_id);

			$msg = 'Success Tambah';
			echo json_encode(['code'=>200, 'result'=>$msg]);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function delete_temp_sales()
	{
		$modul = 'Sales';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){
			$product_id  = $this->input->post('id');
			$user_id 	 = $_SESSION['user_id'];
			$this->sales_model->delete_temp_sales($product_id, $user_id);
			$msg = 'Success Delete';
			echo json_encode(['code'=>200, 'result'=>$msg]);
			die();
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);
		}
	}

	// end sales

	// start retur sales
	public function retursales()
	{
		
		$modul = 'ReturSales';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$warehouse_list['warehouse_list'] = $this->masterdata_model->warehouse_list();
			$salesman_list['salesman_list'] = $this->masterdata_model->salesman_list();
			$supplier_list['supplier_list'] = $this->masterdata_model->supplier_list();
			$data['data'] = array_merge($warehouse_list, $salesman_list, $supplier_list);
			$this->load->view('Pages/Sales/retursales', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function retur_sales_list()
	{

		$modul = 'ReturSales';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$search 			= $this->input->post('search');
			$length 			= $this->input->post('length');
			$start 			  	= $this->input->post('start');
			if($search != null){
				$search = $search['value'];
			}

			$list = $this->sales_model->retursales_list($search, $length, $start)->result_array();
			$count_list = $this->sales_model->retursales_list_count($search)->result_array();
			$total_row = $count_list[0]['total_row'];
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $field) {

				if($field['hd_retur_sales_status'] == 'Success'){
					$hd_retur_sales_status = '<span class="badge badge-success">Success</span>';
				}else if($field['hd_retur_sales_status'] == 'Pending'){
					$hd_retur_sales_status = '<span class="badge badge-primary">Pending</span>';
				}else{
					$hd_retur_sales_status = '<span class="badge badge-danger multi-badge">Cancel</span>';
				}

				if($field['hd_retur_sales_payment_type'] == 'Cash'){
					$payment_sts = '<span class="badge badge-primary">Cash</span>';
				}else if($field['hd_retur_sales_payment_type'] == 'PN'){
					$payment_sts = '<span class="badge badge-primary">Potong Nota</span>';
				}else{
					$payment_sts = '<span class="badge badge-primary multi-badge">Garansi</span>';
				}

				if($check_auth[0]->view == 'Y'){
					$url = base_url();
					$detail = '<a href="'.base_url().'Sales/detailretursales?id='.$field['hd_retur_sales_id'].'" data-fancybox="" data-type="iframe"><button type="button" class="btn btn-icon btn-primary btn-sm mb-2-btn" data-id="'.$field['hd_retur_sales_id'].'"><i class="fas fa-eye sizing-fa"></i></button></a> ';
				}else{
					$detail = '<a href="'.base_url().'Sales/detailretursales?id='.$field['hd_retur_sales_id'].'" data-fancybox="" data-type="iframe"><button type="button" class="btn btn-icon btn-primary btn-sm mb-2-btn" disabled="disabled"><i class="fas fa-eye sizing-fa"></i></button></a> ';
				}


				if($check_auth[0]->delete == 'Y'){
					if($field['hd_retur_sales_status'] == 'Pending'){
						$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn" onclick="deletes('.$field['hd_retur_sales_id'].')"><i class="fas fa-trash-alt sizing-fa"></i></button> ';
					}else{
						$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn" onclick="deletes('.$field['hd_retur_sales_id'].')" disabled><i class="fas fa-trash-alt sizing-fa"></i></button> ';
					}
				}else{
					$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn"  disabled="disabled"><i class="fas fa-trash-alt sizing-fa"></i></button> ';
				}

				if($check_auth[0]->edit == 'Y'){
					if($field['hd_retur_sales_status'] == 'Pending'){
						$payment = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn edit" data-id="'.$field['hd_retur_sales_id'].'" data-inv="'.$field['hd_retur_sales_inv'].'" data-total="'.$field['hd_retur_sales_total'].'" data-bs-toggle="modal" data-bs-target="#exampleModaledit"><i class="fas fa-money-bill-wave sizing-fa"></i></button>';
					}else{
						$payment = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn edit" data-id="'.$field['hd_retur_sales_id'].'" data-inv="'.$field['hd_retur_sales_inv'].'" data-total="'.$field['hd_retur_sales_total'].'" data-bs-toggle="modal" data-bs-target="#exampleModaledit" disabled="disabled"><i class="fas fa-money-bill-wave sizing-fa"></i></button>';
					}
				}else{
					$payment = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn edit" data-id="'.$field['hd_retur_sales_id'].'" data-inv="'.$field['hd_retur_sales_inv'].'" data-total="'.$field['hd_retur_sales_total'].'" data-bs-toggle="modal" data-bs-target="#exampleModaledit" disabled="disabled"><i class="fas fa-money-bill-wave sizing-fa"></i></button>';
				}


				$date = date_create($field['hd_retur_sales_date']); 

				$no++;
				$row = array();
				$row[] 	= $field['hd_retur_sales_inv'];
				$row[] 	= date_format($date,"d-M-Y");
				$row[] 	= $field['product_name'];
				$row[] 	= $field['dt_retur_sales_qty'];
				$row[] 	= $field['customer_name'];
				$row[] 	= 'Rp. '.number_format($field['hd_retur_sales_total']);
				$row[]  = $hd_retur_sales_status;
				$row[] 	= $payment_sts;
				$row[] 	= $detail.$delete.$payment;
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

	public function addretursales()
	{
		
		$modul = 'ReturSales';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){
			$warehouse_list['warehouse_list'] = $this->masterdata_model->warehouse_list();
			$salesman_list['salesman_list'] = $this->masterdata_model->salesman_list();
			$customer_list['customer_list'] = $this->masterdata_model->customer_list();
			$data['data'] = array_merge($warehouse_list, $salesman_list, $customer_list);
			$this->load->view('Pages/Sales/addretursales', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function search_sales_inv()
	{
		$customer_id = $this->input->get('id');
		if($customer_id == null){
			$result = ['success' => False, 'message' => 'Silahkan Isi Customer Terlebih Dahulu'];
		}else{
			$keyword = $this->input->get('term');
			$result = ['success' => FALSE, 'num_product' => 0, 'data' => [], 'message' => ''];
			if (!($keyword == '' || $keyword == NULL)) {
				$find = $this->global_model->search_sales_inv($keyword, $customer_id)->result_array();
				$find_result = [];
				foreach ($find as $row) {
					$diplay_text = $row['hd_sales_inv'];
					$find_result[] = [
						'id'                  => $row['hd_sales_id'],
						'value'               => $diplay_text
					];
				}
				$result = ['success' => TRUE, 'num_product' => count($find_result), 'data' => $find_result, 'message' => ''];
			}
		}
		echo json_encode($result);
	}

	public function search_product_retur()
	{
		$sales_id = $this->input->get('id');
		$keyword = $this->input->get('term');
		$result = ['success' => FALSE, 'num_product' => 0, 'data' => [], 'message' => ''];
		if (!($keyword == '' || $keyword == NULL)) {
			$find = $this->sales_model->search_product_retur($keyword, $sales_id)->result_array(); 
			$find_result = [];
			foreach ($find as $row) {
				$diplay_text = $row['product_name'];
				$find_result[] = [
					'id'                  => $row['dt_sales_product_id'],
					'value'               => $diplay_text,
					'sales_price'      	  => $row['dt_sales_price'],
					'sales_qty'        	  => $row['dt_sales_qty'],
				];
			}
			$result = ['success' => TRUE, 'num_product' => count($find_result), 'data' => $find_result, 'message' => ''];
		}
		echo json_encode($result);
	}

	public function add_temp_retur_sales()
	{

		$modul = 'ReturSales';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){
			$sales_id 					= $this->input->post('sales_id');
			$sales_inv 					= $this->input->post('sales_inv');
			$product_id 				= $this->input->post('product_id');
			$product_name 				= $this->input->post('product_name');
			$temp_price_submit 			= $this->input->post('temp_price_submit');
			$temp_qty 					= $this->input->post('temp_qty');
			$temp_qty_sell 				= $this->input->post('temp_qty_sell');
			$temp_total_submit 			= $this->input->post('temp_total_submit');
			$temp_note 					= $this->input->post('temp_note');
			$customer_id 				= $this->input->post('customer_id');
			$user_id 					= $_SESSION['user_id'];

			$check_total_item_retur = $this->sales_model->check_total_item_retur($sales_id, $product_id);

			$total_qty_retur = $check_total_item_retur[0]->total_qty_retur;

			$total_qty_retur_count = $total_qty_retur + $temp_qty;

			if($total_qty_retur_count > $temp_qty_sell){
				$msg = "Qty Retur Tidak Bisa Lebih Besar Dari Qty Jual";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			$check_temp_retur_sales_input = $this->sales_model->check_temp_retur_sales_input($sales_id, $product_id, $user_id);
			$data_insert = array(
				'temp_retur_sales_b_id'				=> $sales_id,
				'temp_retur_sales_b_inv'			=> $sales_inv,
				'temp_retur_sales_product_id'		=> $product_id,
				'temp_retur_sales_product_name'		=> $product_name,
				'temp_retur_sales_price'			=> $temp_price_submit,
				'temp_retur_sales_qty'				=> $temp_qty,
				'temp_retur_sales_qty_sales'		=> $temp_qty_sell,
				'temp_retur_sales_total'			=> $temp_total_submit,
				'temp_retur_sales_note'				=> $temp_note,
				'temp_retur_sales_customer'			=> $customer_id,
				'temp_user_id'						=> $user_id,
			);	
			$msg = 'Success Tambah';
			if($check_temp_retur_sales_input != null){
				$this->sales_model->edit_temp_retur_sales($sales_id, $product_id, $user_id, $data_insert);
			}else{
				$this->sales_model->add_temp_retur_sales($data_insert);
			}
			echo json_encode(['code'=>200, 'result'=>$msg]);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}


	public function check_temp_retur_sales()
	{
		$user_id 		= $_SESSION['user_id'];
		$check_temp_retur_sales  = $this->sales_model->check_temp_retur_sales($user_id)->result_array();
		echo json_encode(['code'=>200, 'data'=>$check_temp_retur_sales]);
		die();
	}

	public function temp_retur_sales_list()
	{
		$modul = 'ReturSales';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){
			$search 			= $this->input->post('search');
			$length 			= $this->input->post('length');
			$start 			  	= $this->input->post('start');
			$user 			    = $_SESSION['user_id'];
			if($search != null){
				$search = $search['value'];
			}
			$list = $this->sales_model->temp_retur_sales_list($search, $length, $start, $user)->result_array();
			$count_list = $this->sales_model->temp_retur_sales_list_count($search, $user)->result_array();
			$total_row = $count_list[0]['total_row'];
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $field) {

				$edit = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" onclick="edit_temp('.$field['temp_retur_sales_product_id'].', '.$field['temp_retur_sales_b_id'].')"><i class="fas fa-edit sizing-fa"></i></button> ';
				$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn" onclick="deletes('.$field['temp_retur_sales_product_id'].', '.$field['temp_retur_sales_b_id'].')"><i class="fas fa-trash-alt sizing-fa"></i></button> ';

				$no++;
				$row = array();
				$row[] 	= $field['product_code'];
				$row[] 	= $field['product_name'];
				$row[] 	= $field['unit_name'];
				$row[] 	= $field['temp_retur_sales_qty'];
				$row[] 	= 'Rp. '.number_format($field['temp_retur_sales_total']);
				$row[] 	= $field['temp_retur_sales_note'];
				$row[] 	= $edit.$delete;
				$data[] = $row;
			}

			$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $total_row,
				"recordsFiltered" => $total_row,
				"data" => $data
			);
			echo json_encode($output);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}


	public function get_edit_temp_retur_sales()
	{
		$temp_product_id  = $this->input->post('id');
		$temp_sales_id    = $this->input->post('sales_id');
		$temp_user_id  	  = $_SESSION['user_id'];
		$check_edit_temp_retur_sales = $this->sales_model->check_edit_temp_retur_sales($temp_product_id, $temp_sales_id, $temp_user_id)->result_array();
		echo json_encode(['code'=>200, 'result'=>$check_edit_temp_retur_sales]);
		die();
	}


	public function delete_temp_retur_sales()
	{
		$product_id   = $this->input->post('id');
		$user_id 	  = $_SESSION['user_id'];
		$this->sales_model->delete_temp_retur_sales($product_id, $user_id);
		$msg = 'Success Delete';
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();
	}

	public function save_retur_sales()
	{

		$modul = 'ReturSales';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){

			$retur_sales_customer 	    = $this->input->post('retur_sales_customer');
			$retur_sales_date 			= $this->input->post('retur_sales_date');
			$footer_total_invoice_val	= $this->input->post('footer_total_invoice_val');
			$sales_retur_remark 		= $this->input->post('sales_retur_remark');
			$user_id 					= $_SESSION['user_id'];

			if($retur_sales_customer == null){
				$msg = 'Silahkan Masukan Customer';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($footer_total_invoice_val <= 0){
				$msg = 'Silahkan Masukan Data Retur';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			$customer_id = $retur_sales_customer;
			$get_customer_code = $this->masterdata_model->get_customer_code($customer_id);
			$customer_code = $get_customer_code[0]->customer_code;
			$customer_name = $get_customer_code[0]->customer_name;
			

			$maxCode  = $this->sales_model->last_retur_sales();
			$inv_code = 'RS/'.$customer_code.'/'.date("d/m/Y").'/';
			if ($maxCode == NULL) {
				$last_code = $inv_code.'000001';
			} else {
				$maxCode   = $maxCode[0]->hd_retur_sales_inv;
				$last_code = substr($maxCode, -6);
				$last_code = $inv_code.substr('000000' . strval(floatval($last_code) + 1), -6);
			}

			$data_insert = array(
				'hd_retur_sales_inv'			=> $last_code,
				'hd_retur_sales_customer_id'	=> $retur_sales_customer,
				'hd_retur_sales_date'			=> $retur_sales_date,
				'hd_retur_sales_total'			=> $footer_total_invoice_val,
				'hd_retur_sales_note'			=> $sales_retur_remark,
				'created_by'					=> $user_id
			);	
			$save_retur_sales = $this->sales_model->save_retur_sales($data_insert);

			$get_temp_retur_sales = $this->sales_model->get_temp_retur_sales($user_id)->result_array();
			foreach($get_temp_retur_sales  as $row){
				$data_insert_detail = array(
					'hd_retur_sales_id'				=> $save_retur_sales,
					'dt_retur_sales_b_id'			=> $row['temp_retur_sales_b_id'],
					'dt_retur_sales_product_id'		=> $row['temp_retur_sales_product_id'],
					'dt_retur_sales_price'			=> $row['temp_retur_sales_price'],
					'dt_retur_sales_qty'			=> $row['temp_retur_sales_qty'],
					'dt_retur_sales_total'			=> $row['temp_retur_sales_total'],
					'dt_retur_sales_note'			=> $row['temp_retur_sales_note'],
				);

				$save_detail_retur_sales = $this->sales_model->save_detail_retur_sales($data_insert_detail);

				/*$warehouse_id 	= $row['temp_retur_purchase_warehouse_id'];
				if($warehouse_id != 1){
					$product_id 	= $row['temp_retur_purchase_product_id'];
					$qty 			= $row['temp_retur_purchase_qty'];
					$get_last_stock = $this->purchase_model->get_last_stock($product_id, $warehouse_id);
					$last_stock 	= $get_last_stock[0]->stock;
					$new_stock 		= $last_stock - $qty;
					$this->global_model->update_stock($product_id, $warehouse_id, $new_stock);

					$movement_stock = array(
						'stock_movement_product_id'		=> $product_id,
						'stock_movement_qty'			=> $qty,
						'stock_movement_before_stock'	=> $last_stock,
						'stock_movement_new_stock'		=> $new_stock,
						'stock_movement_desc'			=> 'Retur Pembelian',
						'stock_movement_inv'			=> $last_code,
						'stock_movement_calculate'		=> 'Minus',
						'stock_movement_date'			=> $retur_purchase_date,
						'stock_movement_creted_by'		=> $user_id,	
					);	
					$this->global_model->insert_movement_stock($movement_stock);
				}*/
			}

			$data_insert_act = array(
				'activity_table_desc'	       => 'Tambah Retur Penjualan Ref: '.$last_code,
				'activity_table_ref'		   => $last_code,
				'activity_table_user'	       => $user_id,
			);

			$this->global_model->save($data_insert_act);

			$this->sales_model->clear_temp_retur_sales($user_id);

			$msg = 'Success Tambah';
			echo json_encode(['code'=>200, 'result'=>$msg]);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function edit_retur_sales()
	{
		$modul = 'ReturSales';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->edit == 'Y'){
			$user_id 					= $_SESSION['user_id'];
			$retur_sales_id 			= $this->input->post('retur_sales_id');
			$payment_type 			    = $this->input->post('payment_type');
			$retur_sales_invoice     	= $this->input->post('retur_sales_invoice');
			
	
			$get_detail_retur_sales_data = $this->sales_model->get_detail_retur_sales_data($retur_sales_id);
			foreach ($get_detail_retur_sales_data as $row)
			{
				$sales_id = $row->dt_retur_sales_b_id;
				$get_warehouse_retur = $this->sales_model->get_warehouse_retur($sales_id);
				$warehouse_id 	= $get_warehouse_retur[0]->hd_sales_warehouse;

				if($warehouse_id != 1){
					$product_id 	= $row->dt_retur_sales_product_id;
					$qty 			= $row->dt_retur_sales_qty;
					$get_last_stock = $this->purchase_model->get_last_stock($product_id, $warehouse_id);
					$last_stock 	= $get_last_stock[0]->stock;
					$new_stock 		= $last_stock + $qty;
					
					if($payment_type != 'Garansi'){
						$this->global_model->update_stock($product_id, $warehouse_id, $new_stock);
					}
					

					$movement_stock = array(
						'stock_movement_product_id'		=> $product_id,
						'stock_movement_qty'			=> $qty,
						'stock_movement_before_stock'	=> $last_stock,
						'stock_movement_new_stock'		=> $new_stock,
						'stock_movement_desc'			=> 'Confirm Retur Penjualan',
						'stock_movement_inv'			=> $retur_sales_invoice,
						'stock_movement_calculate'		=> 'Plus',
						'stock_movement_date'			=> date("Y/m/d"),
						'stock_movement_creted_by'		=> $user_id,	
					);	
					if($payment_type != 'Garansi'){
						$this->global_model->insert_movement_stock($movement_stock);
					}
				}
			}

			$update_retur_sales = $this->sales_model->update_retur_sales($retur_sales_id, $payment_type);

			$msg = "Success Edit";
			echo json_encode(['code'=>200, 'result'=>$msg]);die();
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function detailretursales()
	{
		$modul = 'ReturSales';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$retur_sales_id = $this->input->get('id');
			$header_retur_sales['header_retur_sales'] = $this->sales_model->header_retur_sales($retur_sales_id);
			$detail_retur_sales['detail_retur_sales'] = $this->sales_model->detail_retur_sales($retur_sales_id); 
			$data['data'] = array_merge($header_retur_sales, $detail_retur_sales);
			$this->load->view('Pages/Sales/detailretursales', $data);
			//echo json_encode($output);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function delete_retur_sales()
	{
		$modul = 'ReturSales';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->delete == 'Y'){
			$retur_sales_id = $this->input->post('id');
			$detail_retur_sales = $this->sales_model->detail_retur_sales_delete($retur_sales_id);
			$user_id 	= $_SESSION['user_id'];
			/*foreach($detail_retur_purchase as $row)
			{
				$warehouse_id = $row->warehouse_id;
				if($warehouse_id != 1){
					$last_code 	    = $row->hd_retur_purchase_inv;
					$product_id 	= $row->dt_retur_purchase_product_id;
					$qty 			= $row->dt_retur_purchase_qty;
					$get_last_stock = $this->purchase_model->get_last_stock($product_id, $warehouse_id);
					$last_stock 	= $get_last_stock[0]->stock;
					$new_stock 		= $last_stock + $qty;
					$this->global_model->update_stock($product_id, $warehouse_id, $new_stock);

					$movement_stock = array(
						'stock_movement_product_id'		=> $product_id,
						'stock_movement_qty'			=> $qty,
						'stock_movement_before_stock'	=> $last_stock,
						'stock_movement_new_stock'		=> $new_stock,
						'stock_movement_desc'			=> 'Batal Retur Pembelian',
						'stock_movement_inv'			=> $last_code,
						'stock_movement_calculate'		=> 'Plus',
						'stock_movement_date'			=> date("Y/m/d"),
						'stock_movement_creted_by'		=> $user_id,	
					);	
					$this->global_model->insert_movement_stock($movement_stock);
				}
			}*/
			$last_code 	    = $detail_retur_sales[0]->hd_retur_sales_inv;
			$data_insert_act = array(
				'activity_table_desc'	       => 'Batal Retur Penjualan Ref: '.$last_code,
				'activity_table_ref'		   => $last_code,
				'activity_table_user'	       => $user_id,
			);

			$this->global_model->save($data_insert_act);

			$this->sales_model->delete_retur_sales($retur_sales_id);

			$msg = "Berhasil Hapus";
			echo json_encode(['code'=>200, 'result'=>$msg]);die();
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	//


	// Revisi Sales

	public function revisisalespage()
	{
		$modul = 'RevisiSales';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$warehouse_list['warehouse_list'] = $this->masterdata_model->warehouse_list();
			$salesman_list['salesman_list'] = $this->masterdata_model->salesman_list();
			$customer_list['customer_list'] = $this->masterdata_model->customer_list();
			$payment_list['payment_list'] = $this->masterdata_model->payment_list();
			$ekspedisi_list['ekspedisi_list'] = $this->masterdata_model->ekspedisi_list();
			$user_list['ekspedisi_list'] = $this->masterdata_model->ekspedisi_list();
			$data['data'] = array_merge($warehouse_list, $salesman_list, $customer_list, $payment_list, $ekspedisi_list, $user_list);
			$this->load->view('Pages/Sales/revisisales', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}


	public function addrevisisales()
	{
		$modul = 'RevisiSales';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$warehouse_list['warehouse_list'] = $this->masterdata_model->warehouse_list();
			$salesman_list['salesman_list'] = $this->masterdata_model->salesman_list();
			$customer_list['customer_list'] = $this->masterdata_model->customer_list();
			$payment_list['payment_list'] = $this->masterdata_model->payment_list();
			$ekspedisi_list['ekspedisi_list'] = $this->masterdata_model->ekspedisi_list();
			$user_list['user_list'] = $this->masterdata_model->user_list();
			$data['data'] = array_merge($warehouse_list, $salesman_list, $customer_list, $payment_list, $ekspedisi_list, $user_list);
			$this->load->view('Pages/Sales/addrevisisales', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}


	public function search_sales_inv_ref()
	{
		$keyword = $this->input->get('term');
		$result = ['success' => FALSE, 'num_product' => 0, 'data' => [], 'message' => ''];
		if (!($keyword == '' || $keyword == NULL)) {
			$find = $this->global_model->search_sales_inv_ref($keyword)->result_array();
			$find_result = [];
			foreach ($find as $row) {
				$diplay_text = $row['hd_sales_inv'];
				$find_result[] = [
					'id'                  => $row['hd_sales_id'],
					'value'               => $diplay_text
				];
			}
			$result = ['success' => TRUE, 'num_product' => count($find_result), 'data' => $find_result, 'message' => ''];
		}
		echo json_encode($result);
	}

	public function get_header_sales()
	{
		$sales_id 			= $this->input->post('id');
		$user_id 			= $_SESSION['user_id'];
		$this->sales_model->clear_temp_sales($user_id);
		$get_sales_dt = $this->sales_model->get_sales_dt($sales_id);
		foreach($get_sales_dt as $row)
		{
			$data_insert = array(
				'temp_product_id'			=> $row->dt_sales_product_id,
				'temp_so_id'				=> 0,
				'temp_sales_rate'			=> $row->dt_sales_rate,
				'temp_sales_price'			=> $row->dt_sales_price,
				'temp_sales_qty'			=> $row->dt_sales_qty,
				'temp_sales_discount'		=> $row->dt_sales_discount,
				'temp_sales_total'			=> $row->dt_sales_total,
				'temp_desc_item'			=> $row->dt_sales_desc,
				'temp_user_id'				=> $user_id,
			);
			$this->sales_model->add_temp_sales($data_insert);
		}
		$get_hd_sales = $this->sales_model->get_hd_sales($sales_id);
		echo json_encode(['code'=>200, 'data'=>$get_hd_sales]);
	}


	public function save_sales_revisi()
	{
		$modul = 'Sales';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){
			$sales_customer             			  = $this->input->post('sales_customer');
			$sales_id  						  		  = $this->input->post('sales_inv_id');
			$sales_payment            				  = $this->input->post('sales_payment');
			$sales_top              				  = $this->input->post('sales_top');
			$sales_top_id             				  = $this->input->post('sales_top_id');

			$drop_ship						  		  = $this->input->post('drop_ship');
			$dropship_name						  	  = $this->input->post('dropship_name');
			$dropship_phone						      = $this->input->post('dropship_phone');
			$dropship_address						  = $this->input->post('dropship_address');

			$sales_salesman             			  = $this->input->post('sales_salesman');
			$sales_prepare            				  = $this->input->post('sales_prepare');
			$sales_prepare_id           			  = $this->input->post('sales_prepare_id');
			$sales_colly              				  = $this->input->post('sales_colly');
			$sales_warehouse            			  = $this->input->post('sales_warehouse');
			$sales_ekspedisi            			  = $this->input->post('sales_ekspedisi');
			$footer_sub_total_submit          		  = $this->input->post('footer_sub_total_submit');
			$sales_due_date             			  = $this->input->post('sales_due_date');
			$sales_date               				  = $this->input->post('sales_date');
			$footer_total_discount_submit        	  = $this->input->post('footer_total_discount_submit');
			$edit_footer_discount_percentage1_submit  = $this->input->post('edit_footer_discount_percentage1_submit');
			$edit_footer_discount_percentage2_submit  = $this->input->post('edit_footer_discount_percentage2_submit');
			$edit_footer_discount_percentage3_submit  = $this->input->post('edit_footer_discount_percentage3_submit');
			$edit_footer_discount1_submit         	  = $this->input->post('edit_footer_discount1_submit');
			$edit_footer_discount2_submit         	  = $this->input->post('edit_footer_discount2_submit');
			$edit_footer_discount3_submit         	  = $this->input->post('edit_footer_discount3_submit');
			$footer_total_ppn_val                     = $this->input->post('footer_total_ppn_val');
			$footer_total_invoice_val           	  = $this->input->post('footer_total_invoice_val');
			$footer_dp_val                  		  = $this->input->post('footer_dp_val');
			$footer_remaining_debt_val          	  = $this->input->post('footer_remaining_debt_val');
			$sales_remark             				  = $this->input->post('sales_remark');
			$user_id                  			      = $_SESSION['user_id'];
			
			if($sales_customer == null){
				$msg = 'Silahkan Masukan Customer';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($sales_top == null){
				$msg = 'Silahkan Masukan TOP';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($sales_salesman == null){
				$msg = 'Silahkan Masukan Salesman';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($sales_payment == null){
				$msg = 'Silahkan Masukan Jenis Pembayaran';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($sales_warehouse == null){
				$msg = 'Silahkan Masukan Gudang';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($sales_ekspedisi == null){
				$msg = 'Silahkan Masukan Ekspedisi';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($footer_total_invoice_val <= 0){
				$msg = 'Silahkan Input Data Terlebih Dahulu';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			$warehouse_id     = $sales_warehouse;
			$get_warehouse_code = $this->masterdata_model->get_warehouse_code($warehouse_id);
			$warehouse_code   = $get_warehouse_code[0]->warehouse_code;
			$warehouse_name   = $get_warehouse_code[0]->warehouse_name;

			$customer_id = $sales_customer;
			$get_customer_code = $this->masterdata_model->get_customer_code($customer_id);
			$customer_code = $get_customer_code[0]->customer_code;
			$customer_name = $get_customer_code[0]->customer_name;


			$maxCode   = $this->sales_model->get_sales_id_inv($sales_id);
			$maxCode   = $maxCode[0]->hd_sales_inv;
			$last_code = str_replace("PJ","RPJ", $maxCode);

			$get_temp_sales_check_stock = $this->sales_model->get_temp_sales($user_id)->result_array();
			if($warehouse_id != 1){
				foreach($get_temp_sales_check_stock as $row){
					$product_id 			= $row['temp_product_id'];
					$qty 					= $row['temp_sales_qty'];
					$product_name 			= $row['product_name'];
					$get_last_stock_check 	= $this->purchase_model->get_last_stock($product_id, $warehouse_id);
					if($get_last_stock_check == null){
						$msg = "Tidak Ada Stock ".$product_name." Di Gudang";
						echo json_encode(['code'=>0, 'result'=>$msg]);die();
					}else{
						$stock_now          = $get_last_stock_check[0]->stock;
						if($stock_now < $qty){
							$msg = "Stock ".$product_name." Tidak Cukup";
							echo json_encode(['code'=>0, 'result'=>$msg]);die();
						}
					}	
				}
			}

			$get_temp_sales = $this->sales_model->get_temp_sales($user_id)->result_array();
			$data_insert = array(
				'hd_sales_inv'            	=> $last_code,
				'hd_sales_revisi_inv'     	=> $sales_id,
				'hd_sales_customer'     	=> $sales_customer,
				'hd_sales_payment'      	=> $sales_payment,
				'hd_sales_ekspedisi'      	=> $sales_ekspedisi,
				'hd_sales_top'        		=> $sales_top,
				'hd_sales_top_id'			=> $sales_top_id,
				'hd_sales_dropship'			=> $drop_ship,
				'hd_sales_dropship_name'    => $dropship_name,
				'hd_sales_dropship_phone'   => $dropship_phone,
				'hd_sales_dropship_address' => $dropship_address,
				'hd_sales_due_date' 		=> $sales_due_date,
				'hd_sales_salesman'     	=> $sales_salesman,
				'hd_sales_prepare'      	=> $sales_prepare,
				'hd_sales_prepare_id'      	=> $sales_prepare_id,
				'hd_sales_colly'        	=> $sales_colly,
				'hd_sales_date'       		=> $sales_date,
				'hd_sales_warehouse'      	=> $sales_warehouse,
				'hd_sales_sub_total'      	=> $footer_sub_total_submit,
				'hd_sales_percentage1'    	=> $edit_footer_discount_percentage1_submit,
				'hd_sales_percentage2'    	=> $edit_footer_discount_percentage2_submit,
				'hd_sales_percentage3'    	=> $edit_footer_discount_percentage3_submit,
				'hd_sales_disc1'        	=> $edit_footer_discount1_submit,
				'hd_sales_disc2'        	=> $edit_footer_discount2_submit,
				'hd_sales_disc3'        	=> $edit_footer_discount3_submit,
				'hd_sales_total_discount'   => $footer_total_discount_submit,
				'hd_sales_ppn'          	=> $footer_total_ppn_val,
				'hd_sales_total'        	=> $footer_total_invoice_val,
				'hd_sales_dp'         		=> $footer_dp_val,
				'hd_sales_remaining_debt'   => $footer_remaining_debt_val,
				'hd_sales_note'       		=> $sales_remark,
				'hd_sales_type'				=> 'REVISI',
				'created_by'            	=> $user_id
			);  
			$save_sales = $this->sales_model->save_sales($data_insert);

			$get_temp_sales = $this->sales_model->get_temp_sales($user_id)->result_array();
			foreach($get_temp_sales  as $row){
				$data_insert_detail = array(
					'hd_sales_id'   	     => $save_sales,
					'dt_sales_product_id'    => $row['temp_product_id'],
					'dt_sales_rate'          => $row['temp_sales_rate'],
					'dt_sales_price'         => $row['temp_sales_price'],
					'dt_sales_qty'           => $row['temp_sales_qty'],
					'dt_sales_discount'      => $row['temp_sales_discount'],
					'dt_sales_total'         => $row['temp_sales_total']
				);
				$save_detail_sales = $this->sales_model->save_detail_sales($data_insert_detail);

				if($warehouse_id != 1){
					$product_id 	= $row['temp_product_id'];
					$qty 			= $row['temp_sales_qty'];
					$get_last_stock = $this->purchase_model->get_last_stock($product_id, $warehouse_id);
					
					if($get_last_stock == null){

					}	
					$last_stock 	= $get_last_stock[0]->stock;
					$new_stock 		= $last_stock - $qty;
					$this->global_model->update_stock($product_id, $warehouse_id, $new_stock);

					$movement_stock = array(
						'stock_movement_product_id'		=> $product_id,
						'stock_movement_qty'			=> $qty,
						'stock_movement_before_stock'	=> $last_stock,
						'stock_movement_new_stock'		=> $new_stock,
						'stock_movement_desc'			=> 'Penjualan',
						'stock_movement_inv'			=> $last_code,
						'stock_movement_calculate'		=> 'Minus',
						'stock_movement_date'			=> $sales_date,
						'stock_movement_creted_by'		=> $user_id,	
					);	
					$this->global_model->insert_movement_stock($movement_stock);
				}
			}

			$data_insert_act = array(
				'activity_table_desc'        => 'Tambah Penjualan Cabang '.$warehouse_name.' '.$last_code.'',
				'activity_table_user'        => $user_id,
			);

			$this->global_model->save($data_insert_act);

			$this->sales_model->clear_temp_sales($user_id);

			$msg = 'Success Tambah';
			echo json_encode(['code'=>200, 'result'=>$msg]);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	// End Revisi Sales


	// start dropship sales
	public function salesdropship()
	{
		
		$modul = 'Sales';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$warehouse_list['warehouse_list'] = $this->masterdata_model->warehouse_list();
			$salesman_list['salesman_list'] = $this->masterdata_model->salesman_list();
			$supplier_list['supplier_list'] = $this->masterdata_model->supplier_list();
			$data['data'] = array_merge($warehouse_list, $salesman_list, $supplier_list);
			$this->load->view('Pages/Sales/retursales', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}
	// end dropship sales
}	

?>