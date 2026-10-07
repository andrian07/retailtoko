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
				
				if($field['hd_sales_status'] != 'Cancel'){
					$print = '<button type="button" class="btn btn-icon btn-warning delete btn-sm mb-2-btn" data-id="'.$field['hd_sales_id'].'" data-bs-toggle="modal" data-bs-target="#print"><i class="fas fa-print sizing-fa"></i></button> ';
				}else{
					$print = '<button type="button" class="btn btn-icon btn-warning delete btn-sm mb-2-btn" data-id="'.$field['hd_sales_id'].'" data-bs-toggle="modal" data-bs-target="#print" disabled="disabled"><i class="fas fa-print sizing-fa"></i></button> ';
				}

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

				$edit = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" onclick="edit_temp('.$field['temp_product_id'].', '.(int) $field['temp_package_id'].')"><i class="fas fa-edit sizing-fa"></i></button> ';
				$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn" onclick="deletes('.$field['temp_product_id'].', '.(int) $field['temp_package_id'].')"><i class="fas fa-trash-alt sizing-fa"></i></button> ';

				$no++;
				$row = array();
				$row[] 	= $field['product_code'];
				$row[] 	= $field['product_name'];
				if($field['temp_package_id'] > 0 && $field['package_name'] != null){
					$row[] 	= $field['temp_sales_qty'].' '.htmlspecialchars($field['package_name']).' <small class="text-muted">('.($field['temp_sales_qty'] * $field['temp_package_conv']).' '.$field['unit_name'].')</small>';
				}else{
					$row[] 	= $field['temp_sales_qty'].' '.$field['unit_name'];
				}
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

	public function check_temp_sales()
	{
		$user_id 			= $_SESSION['user_id'];
		$check_temp_sales   = $this->sales_model->check_temp_sales($user_id)->result_array();
		echo json_encode(['code'=>200, 'data'=>$check_temp_sales]);
		die();
	}

	public function search_product()
	{	
		$pricetype = $this->input->get('pricetype');
		$keyword = $this->input->get('term');
		$result = ['success' => FALSE, 'num_product' => 0, 'data' => [], 'message' => ''];
		if (!($keyword == '' || $keyword == NULL)) {
			$find = $this->global_model->search_product_sales($keyword)->result_array();
			$find_result = [];
			$packages = $this->sales_model->packages_by_products(array_column($find, 'product_id'));
			foreach ($find as $row) {
				$product_id = $row['product_id'];
				$stock = $this->global_model->total_stock_search($product_id)->result_array();
				$base_stock = (int) $stock[0]['curent_stock'];
				if($pricetype == 'Umum'){
					$product_price = $row['product_sell_price_1'];
				}else if($pricetype == 'Toko'){
					$product_price = $row['product_sell_price_2'];
				}else if($pricetype == 'Sales'){
					$product_price = $row['product_sell_price_3'];
				}else if($pricetype == 'Khusus'){
					$product_price = $row['product_sell_price_4'];
				}else if($pricetype == 'Hulu'){
					$product_price = $row['product_sell_price_5'];
				}
				$modal = ((float) $row['product_hpp_discount'] > 0 ? $row['product_hpp_discount'] : $row['product_hpp']);

				// satuan terkecil + satu entri untuk tiap satuan besar (muncul sebagai produk terpisah)
				$units = [['package_id' => 0, 'name' => $row['unit_name'], 'conv' => 1]];
				if(isset($packages[$product_id])){
					foreach($packages[$product_id] as $pk){
						$units[] = ['package_id' => $pk['id'], 'name' => $pk['name'], 'conv' => $pk['qty']];
					}
				}
				foreach($units as $u){
					$diplay_text = $row['product_code'].' - '.$row['product_name'].' - '.$u['name'];
					$find_result[] = [
						'id'                  => $row['product_id'],
						'value'               => $diplay_text,
						'product_code'        => $row['product_code'],
						'product_price'       => $product_price * $u['conv'],
						'label'               => $diplay_text.($u['conv'] > 1 ? ' (isi '.$u['conv'].' '.$row['unit_name'].')' : '').'  |  Modal: Rp '.number_format($modal * $u['conv'], 0, ',', '.'),
						'curent_stock'        => (int) floor($base_stock / $u['conv']),
						'unit_name'           => $u['name'],
						'package_id'          => $u['package_id'],
						'package_conv'        => $u['conv']
					];
				}
			}
			$result = ['success' => TRUE, 'num_product' => count($find_result), 'data' => $find_result, 'message' => ''];
		}
		echo json_encode($result);
	} 

	
	public function add_temp_sales()
	{
		$modul = 'Sales';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->add == 'Y'){
			$warehouse_id 				= 1;
			$product_id 				= $this->input->post('product_id');
			$temp_qty  					= $this->input->post('temp_qty');
			$temp_price_val 			= $this->input->post('temp_price_val');
			$temp_discount_val 			= $this->input->post('temp_discount_val');
			$temp_total_val 			= $this->input->post('temp_total_val');
			$desc_item 					= $this->input->post('desc_item');
			$package_id 				= (int) $this->input->post('package_id');
			$user_id 					= $_SESSION['user_id'];

			// satuan besar: qty & harga yang diinput dalam satuan besar, stok dihitung dalam satuan terkecil
			$package_conv = 1;
			if($package_id > 0){
				$package = $this->sales_model->get_package($product_id, $package_id);
				if($package == null){
					$msg = "Satuan Besar Tidak Valid";
					echo json_encode(['code'=>0, 'result'=>$msg]);die();
				}
				$package_conv = (int) $package['package_qty'];
			}

			if((int) $temp_qty <= 0){
				$msg = "Qty Harus Lebih Dari 0";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($temp_price_val == null || $temp_price_val == 0){
				$msg = "Silahkan Masukan Harga";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}
			
			if($warehouse_id == null){
				$msg = "Silahkan Pilih Gudang / Cabang Terlebih Dahulu";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			$check_stock  = $this->sales_model->check_stock($product_id, $warehouse_id);
			if($check_stock == null){
				$msg = "Stock Tidak Ada Di Gudang";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}else if($check_stock[0]->stock < $temp_qty * $package_conv + $this->sales_model->temp_base_qty_other($product_id, $user_id, $package_id))
			{
				$msg = "Stock Tidak Cukup";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}
			

			$check_temp_sales_input = $this->sales_model->check_temp_sales_input($product_id, $user_id, $package_id);
			$data_insert = array(
				'temp_product_id'			=> $product_id,
				'temp_sales_price'			=> $temp_price_val,
				'temp_sales_qty'			=> $temp_qty,
				'temp_sales_discount'		=> $temp_discount_val,
				'temp_sales_total'			=> $temp_total_val,
				'temp_package_id'			=> $package_id,
				'temp_package_conv'			=> $package_conv,
				'temp_desc_item'			=> $desc_item,
				'temp_user_id'				=> $user_id
			);	
			$msg = 'Success Tambah';
			if($check_temp_sales_input != null){
				$this->sales_model->edit_temp_sales($product_id, $user_id, $package_id, $data_insert);
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
		$warehouse_id  	  	   = 1;
		$temp_user_id  	  	   = $_SESSION['user_id'];
		$temp_package_id 	   = (int) $this->input->post('package_id');
		$check_edit_temp_sales = $this->sales_model->check_edit_temp_sales($temp_product_id, $temp_user_id, $temp_package_id)->result_array();
		$check_stock  		   = $this->sales_model->check_stock($temp_product_id, $warehouse_id);
		echo json_encode(['code'=>200, 'result'=>$check_edit_temp_sales, 'stock'=>$check_stock]);
		die();
	}

	public function delete_temp_sales()
	{
		$modul = 'Sales';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->add == 'Y'){
			$product_id  = $this->input->post('id');
			$user_id 	 = $_SESSION['user_id'];
			$package_id  = (int) $this->input->post('package_id');
			$this->sales_model->delete_temp_sales($product_id, $user_id, $package_id);
			$msg = 'Success Delete';
			echo json_encode(['code'=>200, 'result'=>$msg]);
			die();
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);
		}
	}

	public function clear_temp_sales()
	{
		$user_id 		= $_SESSION['user_id'];
		$this->sales_model->clear_temp_sales($user_id);
		echo json_encode(['code'=>200, 'data'=>"Cler Success"]);
	} 

	public function save_sales()
	{
		$modul = 'Sales';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->add == 'Y'){
			$sales_customer             			  = $this->input->post('sales_customer');
			$sales_payment            				  = $this->input->post('sales_payment');
			$sales_warehouse            			  = 1;
			$sales_due_date             			  = $this->input->post('sales_due_date');
			$sales_date               				  = $this->input->post('sales_date');
			$footer_sub_total_submit          		  = $this->input->post('footer_sub_total_submit');
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

			if($sales_payment == null){
				$msg = 'Silahkan Masukan Jenis Pembayaran';
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
	
			// satu produk bisa ada di beberapa baris (satuan berbeda): jumlahkan dalam satuan terkecil
			$need_by_product = array();
			foreach($get_temp_sales_check_stock as $row){
				$pid = $row['temp_product_id'];
				$need_by_product[$pid] = (isset($need_by_product[$pid]) ? $need_by_product[$pid] : 0) + $row['temp_sales_qty'] * $row['temp_package_conv'];
			}
			foreach($get_temp_sales_check_stock as $row){
				$product_id 			= $row['temp_product_id'];
				$qty 					= $need_by_product[$product_id];
				$product_name 			= $row['product_name'];
				$get_last_stock_check 	= $this->global_model->get_last_stock($product_id, $warehouse_id);
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
		
			$data_insert = array(
				'hd_sales_inv'            	=> $last_code,
				'hd_sales_customer'     	=> $sales_customer,
				'hd_sales_payment'      	=> $sales_payment,
				'hd_sales_due_date'			=> $sales_due_date,
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
				// dt_sales_qty & stok selalu dalam satuan terkecil; harga disimpan per satuan terkecil
				$conv      = max(1, (int) $row['temp_package_conv']);
				$base_qty  = $row['temp_sales_qty'] * $conv;
				$data_insert_detail = array(
					'hd_sales_id'   	     => $save_sales,
					'dt_sales_product_id'    => $row['temp_product_id'],
					'dt_sales_price'         => (int) round($row['temp_sales_price'] / $conv),
					'dt_sales_qty'           => $base_qty,
					'dt_sales_discount'      => $row['temp_sales_discount'],
					'dt_sales_total'         => $row['temp_sales_total'],
					'dt_sales_desc'          => $row['temp_desc_item']
				);
				if($row['temp_package_id'] > 0 && $row['package_name'] != null){
					$data_insert_detail['dt_sales_package_name']  = $row['package_name'];
					$data_insert_detail['dt_sales_package_conv']  = $conv;
					$data_insert_detail['dt_sales_package_count'] = $row['temp_sales_qty'];
				}
				$save_detail_sales = $this->sales_model->save_detail_sales($data_insert_detail);

	
					$product_id 	= $row['temp_product_id'];
					$qty 			= $base_qty;
					$get_last_stock = $this->global_model->get_last_stock($product_id, $warehouse_id);

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

			$data_insert_act = array(
				'activity_table_desc'        => 'Tambah Penjualan Cabang '.$warehouse_name.' '.$last_code.'',
				'activity_table_user'        => $user_id,
			);

			$this->global_model->save($data_insert_act);

			$this->sales_model->clear_temp_sales($user_id);

			$msg = 'Success Tambah';
			echo json_encode(['code'=>200, 'result'=>$msg, 'sales_id'=>$save_sales]);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function delete_sales()
	{
		$modul = 'Sales';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->delete == 'Y'){
			$sales_id  			= $this->input->post('id');
			$header_sales 		= $this->sales_model->header_sales($sales_id);
			$detail_sales 		= $this->sales_model->detail_sales($sales_id);
			$warehouse_id 		= 1;
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
				$get_last_stock = $this->global_model->get_last_stock($product_id, $warehouse_id);

				$last_stock 	= $get_last_stock[0]->stock;
				$new_stock 		= $last_stock + $qty_sell;
				$this->global_model->update_stock($product_id, $warehouse_id, $new_stock);

				$movement_stock = array(
					'stock_movement_product_id'		=> $product_id,
					'stock_movement_qty'			=> $qty_sell,
					'stock_movement_before_stock'	=> $last_stock,
					'stock_movement_new_stock'		=> $new_stock,
					'stock_movement_desc'			=> 'Batalkan Penjualan',
					'stock_movement_inv'			=> $inv,
					'stock_movement_calculate'		=> 'Plus',
					'stock_movement_date'			=> date('Y-m-d H:i:s'),
					'stock_movement_creted_by'		=> $user_id,	
				);	
				$this->global_model->insert_movement_stock($movement_stock);
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

	public function printnota()
	{
		$modul = 'Sales';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->view == 'Y'){
			$id  	      = $this->input->get('print_type');
			$hd_sales_id  = $this->input->get('sales_id');
			$header_sales['header_sales'] = $this->sales_model->header_sales($hd_sales_id);
			$detail_sales['detail_sales'] = $this->sales_model->detail_sales($hd_sales_id);
			$data['data'] = array_merge($header_sales, $detail_sales);
			if($id == 1){
				$this->load->view('Pages/Sales/printnotanormal', $data);
			}else{
				$this->load->view('Pages/Sales/printdispatch', $data);
			}
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	// end sales


	// start pos

	public function pos()
	{
		$modul = 'Sales';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->add == 'Y'){
			$customer_list['customer_list'] = $this->masterdata_model->customer_list();
			$payment_list['payment_list'] = $this->masterdata_model->payment_list();
			$category_list['category_list'] = $this->sales_model->pos_categories();
			$check_auth['check_auth'] = $check_auth;
			$data['data'] = array_merge($customer_list, $payment_list, $category_list, $check_auth);
			$this->load->view('Pages/Sales/pos', $data);
		}else{
			print_r('Tidak Ada Akses');die();
		}
	}

	public function pos_products()
	{
		$modul = 'Sales';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->view == 'Y'){
			$price_types = array('Umum' => 1, 'Toko' => 2, 'Sales' => 3, 'Khusus' => 4, 'Hulu' => 5);
			$pricetype   = $this->input->get('pricetype');
			$price_no    = isset($price_types[$pricetype]) ? $price_types[$pricetype] : 1;
			$keyword     = $this->input->get('keyword');
			$category_id = $this->input->get('category');
			$sort        = $this->input->get('sort');

			$rows = $this->sales_model->pos_products($keyword, $category_id, $sort, $price_no, 1, 60);
			$products = array();
			$packages = $this->sales_model->packages_by_products(array_column($rows, 'product_id'));
			foreach($rows as $row){
				$image = null;
				if($row['product_image'] != '' && file_exists(FCPATH.'assets/products/'.$row['product_image'])){
					$image = base_url().'assets/products/'.$row['product_image'];
				}
				// satuan terkecil + satu kartu untuk tiap satuan besar (muncul sebagai produk terpisah)
				$units = array(array('package_id' => 0, 'name' => $row['unit_name'], 'conv' => 1));
				if(isset($packages[$row['product_id']])){
					foreach($packages[$row['product_id']] as $pk){
						$units[] = array('package_id' => $pk['id'], 'name' => $pk['name'], 'conv' => $pk['qty']);
					}
				}
				foreach($units as $u){
					// bentuk data sama seperti search_product supaya bisa langsung masuk keranjang
					$products[] = array(
						'id'            => $row['product_id'],
						'value'         => $row['product_code'].' - '.$row['product_name'].' - '.$u['name'],
						'product_code'  => $row['product_code'],
						'product_name'  => $row['product_name'],
						'unit_name'     => $u['name'],
						'base_unit_name'=> $row['unit_name'],
						'package_id'    => $u['package_id'],
						'conv'          => $u['conv'],
						'category_name' => $row['category_name'],
						'image'         => $image,
						'product_price' => $row['product_sell_price_'.$price_no] * $u['conv'],
						'curent_stock'  => (int) floor($row['stock'] / $u['conv']),
						'base_stock'    => (int) $row['stock'],
						'modal'         => (float) $row['cost'] * $u['conv'],
					);
				}
			}
			echo json_encode(['code'=>200, 'data'=>$products]);
		}else{
			echo json_encode(['code'=>0, 'result'=>'No Access']);
		}
	}

	public function save_pos()
	{
		$modul = 'Sales';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->add == 'Y'){
			$sales_customer = $this->input->post('sales_customer');
			$sales_payment  = $this->input->post('sales_payment');
			$items          = json_decode($this->input->post('items'), true);
			$warehouse_id   = 1;
			$sales_date     = date('Y-m-d');
			$user_id        = $_SESSION['user_id'];

			if($sales_customer == null){
				$msg = 'Silahkan Pilih Customer';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($sales_payment == null){
				$msg = 'Silahkan Pilih Metode Bayar';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if(empty($items) || !is_array($items)){
				$msg = 'Keranjang Masih Kosong';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			// hitung ulang total di server & cek stok
			$details   = array();
			$sub_total = 0;
			$need_by_product = array();
			foreach($items as $item){
				$product_id = (int) $item['product_id'];
				$count      = (int) $item['qty'];
				$price      = (int) $item['price'];
				$discount   = (int) $item['discount'];
				$total      = $price * $count - $discount;

				// satuan besar: qty & harga dari kasir dalam satuan besar, stok dihitung dalam satuan terkecil
				$package_id   = isset($item['package_id']) ? (int) $item['package_id'] : 0;
				$package_name = '';
				$conv         = 1;
				if($package_id > 0){
					$package = $this->sales_model->get_package($product_id, $package_id);
					if($package == null){
						$msg = 'Satuan Besar Tidak Valid';
						echo json_encode(['code'=>0, 'result'=>$msg]);die();
					}
					$package_name = $package['package_name'];
					$conv         = (int) $package['package_qty'];
				}
				$qty = $count * $conv;

				if($product_id <= 0 || $qty <= 0 || $price <= 0 || $total < 0){
					$msg = 'Data Item Tidak Valid';
					echo json_encode(['code'=>0, 'result'=>$msg]);die();
				}

				// satu produk bisa ada di beberapa baris (satuan berbeda): jumlahkan dalam satuan terkecil
				$need_by_product[$product_id] = (isset($need_by_product[$product_id]) ? $need_by_product[$product_id] : 0) + $qty;
				$get_last_stock_check = $this->global_model->get_last_stock($product_id, $warehouse_id);
				if($get_last_stock_check == null){
					$msg = "Tidak Ada Stock ".$item['product_name']." Di Gudang";
					echo json_encode(['code'=>0, 'result'=>$msg]);die();
				}else if($get_last_stock_check[0]->stock < $need_by_product[$product_id]){
					$msg = "Stock ".$item['product_name']." Tidak Cukup";
					echo json_encode(['code'=>0, 'result'=>$msg]);die();
				}

				$details[] = array(
					'product_id'   => $product_id,
					'price'        => (int) round($price / $conv),
					'qty'          => $qty,
					'discount'     => $discount,
					'total'        => $total,
					'package_name' => $package_name,
					'package_conv' => $conv,
					'package_count'=> $package_id > 0 ? $count : 0
				);
				$sub_total += $total;
			}

			$get_warehouse_code = $this->masterdata_model->get_warehouse_code($warehouse_id);
			$warehouse_code     = $get_warehouse_code[0]->warehouse_code;
			$warehouse_name     = $get_warehouse_code[0]->warehouse_name;

			$get_customer_code = $this->masterdata_model->get_customer_code($sales_customer);
			$customer_code     = $get_customer_code[0]->customer_code;

			$this->db->trans_start();

			$maxCode  = $this->sales_model->last_sales_inv();
			$inv_code = 'PJ/'.$customer_code.'/'.$warehouse_code.'/'.date("d/m/Y").'/';
			if ($maxCode == NULL) {
				$last_code = $inv_code.'000001';
			} else {
				$maxCode   = $maxCode[0]->hd_sales_inv;
				$last_code = substr($maxCode, -6);
				$last_code = $inv_code.substr('000000' . strval(floatval($last_code) + 1), -6);
			}

			// POS selalu lunas: tanpa jatuh tempo, dp, ppn, dan diskon footer
			$data_insert = array(
				'hd_sales_inv'            	=> $last_code,
				'hd_sales_customer'     	=> $sales_customer,
				'hd_sales_payment'      	=> $sales_payment,
				'hd_sales_due_date'			=> $sales_date,
				'hd_sales_date'       		=> $sales_date,
				'hd_sales_warehouse'      	=> $warehouse_id,
				'hd_sales_sub_total'      	=> $sub_total,
				'hd_sales_percentage1'    	=> 0,
				'hd_sales_percentage2'    	=> 0,
				'hd_sales_percentage3'    	=> 0,
				'hd_sales_disc1'        	=> 0,
				'hd_sales_disc2'        	=> 0,
				'hd_sales_disc3'        	=> 0,
				'hd_sales_total_discount'   => 0,
				'hd_sales_ppn'          	=> 0,
				'hd_sales_total'        	=> $sub_total,
				'hd_sales_dp'         		=> $sub_total,
				'hd_sales_remaining_debt'   => 0,
				'hd_sales_note'       		=> 'POS',
				'created_by'            	=> $user_id
			);
			$save_sales = $this->sales_model->save_sales($data_insert);

			foreach($details as $row){
				$data_insert_detail = array(
					'hd_sales_id'   	     => $save_sales,
					'dt_sales_product_id'    => $row['product_id'],
					'dt_sales_price'         => $row['price'],
					'dt_sales_qty'           => $row['qty'],
					'dt_sales_discount'      => $row['discount'],
					'dt_sales_total'         => $row['total'],
					'dt_sales_desc'          => ''
				);
				if($row['package_count'] > 0){
					$data_insert_detail['dt_sales_package_name']  = $row['package_name'];
					$data_insert_detail['dt_sales_package_conv']  = $row['package_conv'];
					$data_insert_detail['dt_sales_package_count'] = $row['package_count'];
				}
				$this->sales_model->save_detail_sales($data_insert_detail);

				$product_id 	= $row['product_id'];
				$qty 			= $row['qty'];
				$get_last_stock = $this->global_model->get_last_stock($product_id, $warehouse_id);
				$last_stock 	= $get_last_stock[0]->stock;
				$new_stock 		= $last_stock - $qty;
				$this->global_model->update_stock($product_id, $warehouse_id, $new_stock);

				$movement_stock = array(
					'stock_movement_product_id'		=> $product_id,
					'stock_movement_qty'			=> $qty,
					'stock_movement_before_stock'	=> $last_stock,
					'stock_movement_new_stock'		=> $new_stock,
					'stock_movement_desc'			=> 'Penjualan POS',
					'stock_movement_inv'			=> $last_code,
					'stock_movement_calculate'		=> 'Minus',
					'stock_movement_date'			=> $sales_date,
					'stock_movement_creted_by'		=> $user_id,
				);
				$this->global_model->insert_movement_stock($movement_stock);
			}

			$data_insert_act = array(
				'activity_table_desc'        => 'Tambah Penjualan POS Cabang '.$warehouse_name.' '.$last_code.'',
				'activity_table_user'        => $user_id,
			);
			$this->global_model->save($data_insert_act);

			$this->db->trans_complete();

			if($this->db->trans_status() === FALSE){
				$msg = 'Gagal Menyimpan Transaksi';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			echo json_encode(['code'=>200, 'result'=>'Success Tambah', 'sales_id'=>$save_sales, 'invoice'=>$last_code]);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function printpos()
	{
		$modul = 'Sales';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->view == 'Y'){
			$hd_sales_id  = $this->input->get('sales_id');
			$header_sales['header_sales'] = $this->sales_model->header_sales($hd_sales_id);
			$detail_sales['detail_sales'] = $this->sales_model->detail_sales($hd_sales_id);
			$pay['pay'] = (int) $this->input->get('pay');
			$data['data'] = array_merge($header_sales, $detail_sales, $pay);
			$this->load->view('Pages/Sales/printnotalunas', $data);
		}else{
			print_r('Tidak Ada Akses');die();
		}
	}

	// end pos


	// retur sales

	public function retursales()
	{
		
		$modul = 'ReturSales';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->view == 'Y'){
			$supplier_list['supplier_list'] = $this->masterdata_model->supplier_list();
			$check_auth['check_auth'] = $check_auth;
			$data['data'] = array_merge($supplier_list, $check_auth);
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
		if($check_auth['check_access'][0]->view == 'Y'){
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

				if($check_auth['check_access'][0]->view == 'Y'){
					$url = base_url();
					$detail = '<a href="'.base_url().'Sales/detailretursales?id='.$field['hd_retur_sales_id'].'" data-fancybox="" data-type="iframe"><button type="button" class="btn btn-icon btn-primary btn-sm mb-2-btn" data-id="'.$field['hd_retur_sales_id'].'"><i class="fas fa-eye sizing-fa"></i></button></a> ';
				}else{
					$detail = '<a href="'.base_url().'Sales/detailretursales?id='.$field['hd_retur_sales_id'].'" data-fancybox="" data-type="iframe"><button type="button" class="btn btn-icon btn-primary btn-sm mb-2-btn" disabled="disabled"><i class="fas fa-eye sizing-fa"></i></button></a> ';
				}


				if($check_auth['check_access'][0]->delete == 'Y'){
					$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn" onclick="deletes('.$field['hd_retur_sales_id'].')"><i class="fas fa-trash-alt sizing-fa"></i></button> ';
				
				}else{
					$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn"  disabled="disabled"><i class="fas fa-trash-alt sizing-fa"></i></button> ';
				}

				if($check_auth['check_access'][0]->edit == 'Y'){
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


	public function detailretursales()
	{
		$modul = 'ReturSales';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->view == 'Y'){
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

		if($check_auth['check_access'][0]->delete == 'Y'){
			$retur_sales_id = $this->input->post('id');
			$retur_sales_delete = $this->sales_model->retur_sales_delete($retur_sales_id);
			$user_id 	= $_SESSION['user_id'];
			foreach($retur_sales_delete as $row)
			{
				$warehouse_id   = 1;
				$last_code 	    = $row->hd_retur_sales_inv;
				$product_id 	= $row->dt_retur_sales_product_id;
				$qty 			= $row->dt_retur_sales_qty;
				$get_last_stock = $this->global_model->get_last_stock($product_id, $warehouse_id);
				$last_stock 	= $get_last_stock[0]->stock;
				$new_stock 		= $last_stock - $qty;
				$this->global_model->update_stock($product_id, $warehouse_id, $new_stock);

				$movement_stock = array(
						'stock_movement_product_id'		=> $product_id,
						'stock_movement_qty'			=> $qty,
						'stock_movement_before_stock'	=> $last_stock,
						'stock_movement_new_stock'		=> $new_stock,
						'stock_movement_desc'			=> 'Batal Retur Penjualan',
						'stock_movement_inv'			=> $last_code,
						'stock_movement_calculate'		=> 'Minus',
						'stock_movement_date'			=> date("Y/m/d"),
						'stock_movement_creted_by'		=> $user_id,	
					);	
					$this->global_model->insert_movement_stock($movement_stock);
			}
			$last_code 	    = $retur_sales_delete[0]->hd_retur_sales_inv;
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

	public function addretursales()
	{
		
		$modul = 'ReturSales';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->add == 'Y'){
			$customer_list['customer_list'] = $this->masterdata_model->customer_list();
			$check_auth['check_auth'] = $check_auth;
			$data['data'] = array_merge($customer_list, $check_auth);
			$this->load->view('Pages/Sales/addretursales', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function temp_retur_sales_list()
	{
		$modul = 'ReturSales';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->add == 'Y'){
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

	public function check_temp_retur_sales()
	{
		$user_id 		= $_SESSION['user_id'];
		$check_temp_retur_sales  = $this->sales_model->check_temp_retur_sales($user_id)->result_array();
		echo json_encode(['code'=>200, 'data'=>$check_temp_retur_sales]);
		die();
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
		if($check_auth['check_access'][0]->add == 'Y'){
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

			$check_stock = $this->global_model->get_last_stock($product_id, 1);
			$stock_now = $check_stock[0]->stock;
			if($stock_now - $temp_qty < 0){
				$msg = "Stock Tidak Cukup Untuk Retur";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

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

	public function save_retur_sales()
	{

		$modul = 'ReturSales';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->add == 'Y'){

			$retur_sales_customer 	    = $this->input->post('retur_sales_customer');
			$retur_sales_date 			= $this->input->post('retur_sales_date');
			$footer_total_invoice_val	= $this->input->post('footer_total_invoice_val');
			$sales_retur_remark 		= $this->input->post('sales_retur_remark');
			$payment_type 				= $this->input->post('payment_type');
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
				'hd_retur_sales_payment_type'	=> $payment_type,
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

				$warehouse_id 	= 1;
				$product_id 	= $row['temp_retur_sales_product_id'];
				$qty 			= $row['temp_retur_sales_qty'];
				$get_last_stock = $this->global_model->get_last_stock($product_id, $warehouse_id);
				$last_stock 	= $get_last_stock[0]->stock;
				$new_stock 		= $last_stock + $qty;
				$this->global_model->update_stock($product_id, $warehouse_id, $new_stock);

				$movement_stock = array(
					'stock_movement_product_id'		=> $product_id,
					'stock_movement_qty'			=> $qty,
					'stock_movement_before_stock'	=> $last_stock,
					'stock_movement_new_stock'		=> $new_stock,
					'stock_movement_desc'			=> 'Retur Penjualan',
					'stock_movement_inv'			=> $last_code,
					'stock_movement_calculate'		=> 'Plus',
					'stock_movement_date'			=> $retur_sales_date,
					'stock_movement_creted_by'		=> $user_id,	
				);	
				$this->global_model->insert_movement_stock($movement_stock);
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


	// end retur sales

}