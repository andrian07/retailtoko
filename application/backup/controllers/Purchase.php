<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");

class Purchase extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('masterdata_model');
		$this->load->model('global_model');
		$this->load->model('purchase_model');
		$this->load->library('session');
		$this->load->helper(array('url', 'html'));
	}

	private function check_auth($modul){
		if(isset($_SESSION['user_name']) == null){
			redirect('Dashboard', 'refresh');
		}else{
			$user_role_id = $_SESSION['user_role_id'];
			$check_access = $this->global_model->check_access($user_role_id, $modul);
			return($check_access);
		}
	}


	// purchase 
	public function index(){
		$modul = 'Purchase';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$warehouse_list['warehouse_list'] = $this->masterdata_model->warehouse_list();
			$salesman_list['salesman_list'] = $this->masterdata_model->salesman_list();
			$supplier_list['supplier_list'] = $this->masterdata_model->supplier_list();
			$data['data'] = array_merge($warehouse_list, $salesman_list, $supplier_list);
			$this->load->view('Pages/Purchase/purchase', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function clear_temp_purchase()
	{
		$user_id 		= $_SESSION['user_id'];
		$this->purchase_model->clear_temp_purchase($user_id);
		echo json_encode(['code'=>200, 'data'=>"Cler Success"]);
	}

	public function purchase_list(){
		$modul = 'Purchase';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$search 			= $this->input->post('search');
			$length 			= $this->input->post('length');
			$start 			  	= $this->input->post('start');
			$purchase_type 		= $this->input->post('purchase_type');

			if($this->input->post('start_date_val') != null){
				$start_date_val 	 = $this->input->post('start_date_val');
				$end_date_val 		 = $this->input->post('end_date_val');
				$supplier_filter_val = $this->input->post('supplier_filter_val');
			}else{
				$start_date_val 	 = "";
				$end_date_val 		 = "";
				$supplier_filter_val = "";
			}

			if($search != null){
				$search = $search['value'];
			}
			$list = $this->purchase_model->purchase_list($search, $length, $start, $start_date_val, $end_date_val, $supplier_filter_val, $purchase_type)->result_array();
			$count_list = $this->purchase_model->purchase_list_count($search, $start_date_val, $end_date_val, $supplier_filter_val, $purchase_type)->result_array();
			$total_row = $count_list[0]['total_row'];
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $field) {
				if($field['hd_purchase_tax'] == 'Y'){
					$tax = '<span class="badge badge-success">BKP</span>';
				}else{
					$tax = '<span class="badge badge-danger">NON BKP</span>';
				}

				if($field['hd_purchase_remaining_debt'] > 0){
					$hd_purchase_remaining_debt = '<span class="badge badge-danger">Belum Lunas</span>';
				}else{
					$hd_purchase_remaining_debt = '<span class="badge badge-success">Lunas</span>';
				}

				if($check_auth[0]->view == 'Y'){
					$url = base_url();
					$detail = '<a href="'.base_url().'Purchase/detailpurchase?id='.$field['hd_purchase_id'].'" data-fancybox="" data-type="iframe"><button type="button" class="btn btn-icon btn-primary btn-sm mb-2-btn" data-id="'.$field['hd_purchase_id'].'"><i class="fas fa-eye sizing-fa"></i></button></a> ';
				}else{
					$detail = '<a href="'.base_url().'Purchase/detailpurchase?id='.$field['hd_purchase_id'].'" data-fancybox="" data-type="iframe"><button type="button" class="btn btn-icon btn-primary btn-sm mb-2-btn" disabled="disabled"><i class="fas fa-eye sizing-fa"></i></button></a> ';
				}

				if($check_auth[0]->edit == 'Y'){
					if($field['hd_purchase_status'] != 'Cancel'){
						$edit = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" data-bs-toggle="modal" data-bs-target="#exampleModaledit" data-id="'.$field['hd_purchase_id'].'" data-name="'.$field['hd_purchase_invoice'].'"><i class="fas fa-edit sizing-fa"></i></button> ';
					}else{
						$edit = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" disabled="disabled" data-bs-toggle="modal" data-bs-target="#exampleModaledit" data-id="'.$field['hd_purchase_id'].'" data-name="'.$field['hd_purchase_invoice'].'"><i class="fas fa-edit sizing-fa"></i></button> ';
					}
				}else{
					$edit = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" disabled="disabled"><i class="fas fa-edit sizing-fa"></i></button> <button type="button" class="btn btn-icon btn-info btn-sm mb-2-btn" disabled="disabled"> ';
				}

				if($check_auth[0]->delete == 'Y'){
					if($field['hd_purchase_status'] != 'Cancel'){
						$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn" onclick="deletes('.$field['hd_purchase_id'].')"><i class="fas fa-trash-alt sizing-fa"></i></button> ';
					}else{
						$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn"  disabled="disabled"><i class="fas fa-trash-alt sizing-fa"></i></button> ';
					}
				}else{
					$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn"  disabled="disabled"><i class="fas fa-trash-alt sizing-fa"></i></button> ';
				}

				$date = date_create($field['hd_purchase_date']); 

				$no++;
				$row = array();
				$row[] 	= $field['hd_purchase_invoice'];
				$row[] 	= $field['supplier_name'];
				$row[] 	= date_format($date,"d-M-Y");
				$row[] 	= $field['product_name'];
				$row[] 	= $field['unit_name'];
				$row[] 	= $field['dt_purchase_qty'];
				$row[] 	= number_format($field['dt_purchase_price']);
				$row[] 	= number_format($field['dt_purchase_total']);
				$row[] 	= $tax;
				$row[] 	= $hd_purchase_remaining_debt;
				$row[] 	= $detail.$delete;
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

	public function addpurchase()
	{
		$modul = 'Purchase';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){
			$supplier_list['supplier_list'] = $this->masterdata_model->supplier_list();
			$ekspedisi_list['ekspedisi_list'] = $this->masterdata_model->ekspedisi_list();
			$payment_list['payment_list'] = $this->masterdata_model->payment_list();
			$warehouse_list['warehouse_list'] = $this->masterdata_model->warehouse_list();
			$data['data'] = array_merge($supplier_list, $ekspedisi_list, $payment_list, $warehouse_list);
			$this->load->view('Pages/Purchase/purchaseadd', $data);
			//echo json_encode($output);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function temp_purchase_list()
	{
		$modul = 'Purchase';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){
			$search 			= $this->input->post('search');
			$length 			= $this->input->post('length');
			$start 			  	= $this->input->post('start');
			$user 				= $_SESSION['user_id'];
			if($search != null){
				$search = $search['value'];
			}
			$list = $this->purchase_model->temp_purchase_list($search, $length, $start, $user)->result_array();
			$count_list = $this->purchase_model->temp_purchase_list_count($search, $user)->result_array();
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
				$row[] 	= $field['unit_name'];
				$row[] 	= 'Rp. '.number_format($field['temp_purchase_price']);
				$row[] 	= 'Rp. '.number_format($field['product_sell_price_2']);
				$row[] 	= $field['temp_purchase_qty'];
				$row[] 	= 'Rp. '.number_format($field['temp_purchase_total_ongkir']);
				$row[] 	= 'Rp. '.number_format($field['temp_purchase_total']);
				$row[] 	= $field['temp_purchase_note'];
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


	public function delete_temp_purchase()
	{
		$modul = 'Purchase';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){
			$product_id  = $this->input->post('id');
			$user_id 	 = $_SESSION['user_id'];
			$this->purchase_model->delete_temp_purchase($product_id, $user_id);
			$msg = 'Success Delete';
			echo json_encode(['code'=>200, 'result'=>$msg]);
			die();
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);
		}
	}

	public function search_po_purchase()
	{
		$keyword = $this->input->get('term');
		$result = ['success' => FALSE, 'num_product' => 0, 'data' => [], 'message' => ''];
		if (!($keyword == '' || $keyword == NULL)) {
			$find = $this->purchase_model->search_po_purchase($keyword)->result_array(); 
			$find_result = [];
			foreach ($find as $row) {
				$diplay_text = $row['hd_po_invoice'];
				$find_result[] = [
					'id'                  => $row['hd_po_id'],
					'value'               => $diplay_text,
				];
			}
			$result = ['success' => TRUE, 'num_product' => count($find_result), 'data' => $find_result, 'message' => ''];
		}
		echo json_encode($result);
	}

	public function copy_po_to_temp_purchase()
	{
		$modul = 'Purchase';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){
			$po_id 		= $this->input->post('po_id');
			$user_id 	= $_SESSION['user_id'];
			$get_detail_po = $this->purchase_model->detail_po_purchase($po_id);
			$this->purchase_model->clear_temp_purchase($user_id);
			foreach($get_detail_po as $row)
			{
				$data_copy_temp = array(
					'temp_product_id'			 => $row->dt_product_id,
					'temp_purchase_price'		 => $row->dt_po_price,
					'temp_purchase_qty_order'	 => $row->dt_is_qty_order,
					'temp_purchase_qty'			 => $row->dt_is_qty,
					'temp_purchase_weight'		 => $row->dt_po_weight,
					'temp_purchase_ongkir'		 => $row->dt_po_ongkir,
					'temp_purchase_total_weight' => $row->dt_po_total_weight,
					'temp_purchase_total_ongkir' => $row->dt_po_total_ongkir,
					'temp_purchase_total'		 => $row->dt_po_total,
					'temp_purchase_po_id' 		 => $po_id,
					'temp_purchase_note' 		 => $row->dt_po_note,
					'temp_user_id'				 => $user_id
				);	

				$copy_temp_purchase = $this->purchase_model->copy_temp_purchase($data_copy_temp);
			}
			$msg = "Success Copy";
			echo json_encode(['code'=>200, 'result'=>$msg]);die();
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function check_temp_purchase()
	{
		$user_id 		= $_SESSION['user_id'];
		$check_temp_po  = $this->purchase_model->check_temp_purchase($user_id)->result_array();
		if($check_temp_po[0]['hd_po_top'] == 'CBD'){
			$hd_po_top_val = 0;
		}else{
			$hd_po_top_val = trim($check_temp_po[0]['hd_po_top'],"JT");
		}
		echo json_encode(['code'=>200, 'data'=>$check_temp_po, 'hd_po_top_val'=>$hd_po_top_val]);
		die();
	}

	public function get_edit_temp_purchase()
	{
		$temp_product_id  = $this->input->post('id');
		$temp_user_id  	  = $_SESSION['user_id'];
		$check_edit_temp_purchase = $this->purchase_model->check_edit_temp_purchase($temp_product_id, $temp_user_id)->result_array();
		echo json_encode(['code'=>200, 'result'=>$check_edit_temp_purchase]);
		die();
	}

	public function add_temp_purchase()
	{

		$modul = 'Purchase';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){
			$product_id 				= $this->input->post('product_id');
			$temp_price_val 			= $this->input->post('temp_price_val');
			$temp_qty 					= $this->input->post('temp_qty');
			$temp_weight 				= $this->input->post('temp_weight');
			$temp_delivery_price_val 	= $this->input->post('temp_delivery_price_val');
			$temp_total_weight 			= $this->input->post('temp_total_weight');
			$temp_ongkir_val 			= $this->input->post('temp_ongkir_val');
			$temp_total_val 			= $this->input->post('temp_total_val');
			$temp_note 					= $this->input->post('temp_note');
			$user_id 					= $_SESSION['user_id'];

			$check_temp_purchase_input = $this->purchase_model->check_temp_purchase_input($product_id, $user_id);
			$data_insert = array(
				'temp_product_id'				=> $product_id,
				'temp_purchase_price'			=> $temp_price_val,
				'temp_purchase_qty'				=> $temp_qty,
				'temp_purchase_weight'			=> $temp_weight,
				'temp_purchase_ongkir'			=> $temp_delivery_price_val,
				'temp_purchase_total_weight'	=> $temp_total_weight,
				'temp_purchase_total_ongkir'	=> $temp_ongkir_val,
				'temp_purchase_total'			=> $temp_total_val,
				'temp_purchase_note'			=> $temp_note,
				'temp_user_id'					=> $user_id,
			);	
			$msg = 'Success Tambah';
			if($check_temp_purchase_input != null){
				$this->purchase_model->edit_temp_purchase($product_id, $user_id, $data_insert);
			}else{
				$msg = "Tidak Bisa Tambah Item Di Luar PO";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}
			echo json_encode(['code'=>200, 'result'=>$msg]);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function save_purchase()
	{

		$modul = 'Purchase';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){

			$po_inv 									= $this->input->post('po_inv');
			$po_id 										= $this->input->post('po_id');
			$purchase_top								= $this->input->post('purchase_top');
			$purchase_top_id 							= $this->input->post('purchase_top_id');
			$purchase_payment_method 					= $this->input->post('purchase_payment_method');
			$purchase_supplier 							= $this->input->post('purchase_supplier');
			$no_faktur_supplier 						= $this->input->post('no_faktur_supplier');
			$faktur_date 								= $this->input->post('faktur_date');
			$purchase_ekspedisi 						= $this->input->post('purchase_ekspedisi');
			$purchase_tax 								= $this->input->post('purchase_tax');
			$purchase_date 					        	= $this->input->post('purchase_date');
			$purchase_warehouse 						= $this->input->post('purchase_warehouse');
			$purchase_due_date 							= $this->input->post('purchase_due_date');
			$footer_sub_total_submit 					= $this->input->post('footer_sub_total_submit');
			$footer_total_discount_submit 				= $this->input->post('footer_total_discount_submit');
			$edit_footer_discount_percentage1_submit 	= $this->input->post('edit_footer_discount_percentage1_submit');
			$edit_footer_discount_percentage2_submit 	= $this->input->post('edit_footer_discount_percentage2_submit');
			$edit_footer_discount_percentage3_submit 	= $this->input->post('edit_footer_discount_percentage3_submit');
			$edit_footer_discount1_submit 				= $this->input->post('edit_footer_discount1_submit');
			$edit_footer_discount2_submit 				= $this->input->post('edit_footer_discount2_submit');
			$edit_footer_discount3_submit 				= $this->input->post('edit_footer_discount3_submit');
			$footer_dpp_val 							= $this->input->post('footer_dpp_val');
			$footer_total_ppn_val 					    = $this->input->post('footer_total_ppn_val');
			$footer_total_ongkir_val 					= $this->input->post('footer_total_ongkir_val');
			$footer_total_invoice_val 					= $this->input->post('footer_total_invoice_val');
			$purchase_remark 							= $this->input->post('purchase_remark');
			$user_id 									= $_SESSION['user_id'];

			if($purchase_supplier == null){
				$msg = 'Silahkan Masukan Supplier';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($purchase_ekspedisi == null){
				$msg = 'Silahkan Masukan Ekspedisi';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($purchase_payment_method == null){
				$msg = 'Silahkan Masukan Jenis Pembayaran';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($purchase_warehouse == null){
				$msg = 'Silahkan Masukan Gudang';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($footer_total_invoice_val <= 0){
				$msg = 'Silahkan Input Data Terlebih Dahulu';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			$warehouse_id 		= $purchase_warehouse;
			$get_warehouse_code = $this->masterdata_model->get_warehouse_code($warehouse_id);
			$warehouse_code 	= $get_warehouse_code[0]->warehouse_code;
			$warehouse_name 	= $get_warehouse_code[0]->warehouse_name;

			$supplier_id = $purchase_supplier;
			$get_supplier_code = $this->masterdata_model->get_supplier_code($supplier_id);
			$supplier_code = $get_supplier_code[0]->supplier_code;
			$supplier_name = $get_supplier_code[0]->supplier_name;
			

			$maxCode  = $this->purchase_model->last_purchase();
			$inv_code = 'LBM/'.$supplier_code.'/'.$warehouse_code.'/'.date("d/m/Y").'/';
			if ($maxCode == NULL) {
				$last_code = $inv_code.'000001';
			} else {
				$maxCode   = $maxCode[0]->hd_purchase_invoice;
				$last_code = substr($maxCode, -6);
				$last_code = $inv_code.substr('000000' . strval(floatval($last_code) + 1), -6);
			}	

			if($purchase_top == 'CBD'){
				$hd_purchase_dp = $footer_total_invoice_val;
				$remaingin_debt = 0;
			}else{
				$hd_purchase_dp = 0;
				$remaingin_debt = $footer_total_invoice_val;
			}

			$data_insert = array(
				'hd_purchase_invoice'			=> $last_code,
				'hd_po_id'						=> $po_id,
				'hd_purchase_faktur'			=> $no_faktur_supplier,
				'hd_purchase_faktur_date'		=> $faktur_date,
				'hd_purchase_date'				=> $purchase_date,
				'hd_purchase_warehouse'			=> $purchase_warehouse,
				'hd_purchase_supplier'			=> $purchase_supplier,
				'hd_purchase_tax'				=> $purchase_tax,
				'hd_purchase_top'				=> $purchase_top,
				'hd_purchase_top_id'			=> $purchase_top_id,
				'hd_purchase_due_date'			=> $purchase_due_date,
				'hd_purchase_payment'			=> $purchase_payment_method,
				'hd_purchase_ekspedisi'			=> $purchase_ekspedisi,
				'hd_purchase_sub_total'			=> $footer_sub_total_submit,
				'hd_purchase_disc_percentage1'	=> $edit_footer_discount_percentage1_submit,
				'hd_purchase_disc_percentage2'	=> $edit_footer_discount_percentage2_submit,
				'hd_purchase_disc_percentage3'	=> $edit_footer_discount_percentage3_submit,
				'hd_purchase_disc_1'			=> $edit_footer_discount1_submit,
				'hd_purchase_disc_2'			=> $edit_footer_discount2_submit,
				'hd_purchase_disc_3'			=> $edit_footer_discount3_submit,
				'hd_purchase_total_discount'	=> $footer_total_discount_submit,
				'hd_purchase_dpp'				=> $hd_purchase_dp,
				'hd_purchase_ppn'			    => $footer_total_ppn_val,
				'hd_purchase_ongkir'			=> $footer_total_ongkir_val,
				'hd_purchase_dp'				=> 0,
				'hd_purchase_grand_total'		=> $footer_total_invoice_val,
				'hd_purchase_remaining_debt'	=> $remaingin_debt,
				'hd_purchase_note'				=> $purchase_remark,
				'created_by'					=> $user_id
			);	
			$save_purchase = $this->purchase_model->save_purchase($data_insert);

			$get_temp_purchase = $this->purchase_model->get_temp_purchase($user_id)->result_array();
			foreach($get_temp_purchase  as $row){
				$data_insert_detail = array(
					'hd_purchase_id'			=> $save_purchase,
					'dt_product_id'				=> $row['temp_product_id'],
					'dt_purchase_price'			=> $row['temp_purchase_price'],
					'dt_purchase_qty'			=> $row['temp_purchase_qty'],
					'dt_purchase_weight'		=> $row['temp_purchase_weight'],
					'dt_purchase_ongkir'		=> $row['temp_purchase_ongkir'],
					'dt_purchase_total_weight'	=> $row['temp_purchase_total_weight'],
					'dt_purchase_total_ongkir'	=> $row['temp_purchase_total_ongkir'],
					'dt_purchase_total'			=> $row['temp_purchase_total'],
					'dt_purchase_note'			=> $row['temp_purchase_note'],
				);

				$save_detail_purchase = $this->purchase_model->save_detail_purchase($data_insert_detail);
			}

			$this->purchase_model->update_purchase_po($po_id);
			$this->purchase_model->update_purchase_input_stock($po_id);

			$data_insert_act = array(
				'activity_table_desc'	       => 'Tambah Pembelian Cabang '.$warehouse_name.' Ref: '.$last_code,
				'activity_table_ref'		   => $last_code,
				'activity_table_user'	       => $user_id,
			);

			$this->global_model->save($data_insert_act);

			$this->purchase_model->clear_temp_purchase($user_id);

			$msg = 'Success Tambah';
			echo json_encode(['code'=>200, 'result'=>$msg]);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function detailpurchase()
	{
		$modul = 'Purchase';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$purchase_id = $this->input->get('id');
			$header_purchase['header_purchase'] = $this->purchase_model->header_purchase($purchase_id);
			$detail_purchase['detail_purchase'] = $this->purchase_model->detail_purchase($purchase_id); 
			$data['data'] = array_merge($header_purchase, $detail_purchase);
			$this->load->view('Pages/Purchase/detailpurchase', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	// end purchase
	// submission
	public function submission()
	{
		$modul = 'Submission';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$warehouse_list['warehouse_list'] = $this->masterdata_model->warehouse_list();
			$salesman_list['salesman_list'] = $this->masterdata_model->salesman_list();
			$supplier_list['supplier_list'] = $this->masterdata_model->supplier_list();
			$data['data'] = array_merge($warehouse_list, $salesman_list, $supplier_list);
			$this->load->view('Pages/Purchase/submission', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

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
				$find_result[] = [
					'id'                  => $row['product_id'],
					'value'               => $diplay_text,
					'product_code'        => $row['product_code'],
					'product_price'       => $row['product_price'],
					'product_weight'      => $row['product_weight']
				];
			}
			$result = ['success' => TRUE, 'num_product' => count($find_result), 'data' => $find_result, 'message' => ''];
		}
		echo json_encode($result);
	} 

	public function search_product_submission()
	{	
		$supplier_id = $this->input->get('id');
		$keyword = $this->input->get('term');
		$result = ['success' => FALSE, 'num_product' => 0, 'data' => [], 'message' => ''];
		if (!($keyword == '' || $keyword == NULL)) {
			$find = $this->global_model->search_product_submission($keyword)->result_array();
			$find_result = [];
			foreach ($find as $row) {
				$diplay_text = $row['product_code'].' - '.$row['product_name'].' - '.$row['unit_name'];
				$find_result[] = [
					'id'                  => $row['product_id'],
					'value'               => $diplay_text,
					'product_code'        => $row['product_code'],
					'product_price'       => $row['product_price'],
					'product_weight'      => $row['product_weight'],
					'last_supplier'       => $row['hd_po_supplier'],
				];
			}
			$result = ['success' => TRUE, 'num_product' => count($find_result), 'data' => $find_result, 'message' => ''];
		}
		echo json_encode($result);
	} 

	public function get_last_supplier_po()
	{
		$product_id = $this->input->post('product_id');
		$get_last_supplier_po = $this->global_model->get_last_supplier_po($product_id)->result_array();
		echo json_encode(['code'=>200, 'result'=>$get_last_supplier_po]);
		die();
	}

	public function submission_list()
	{
		
		$modul = 'Submission';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$search 			= $this->input->post('search');
			$length 			= $this->input->post('length');
			$start 			  	= $this->input->post('start');
			$start_date        = $this->input->post('start_date');
			$end_date          = $this->input->post('end_date');
			$supplier_filter   = $this->input->post('supplier_filter');
			$keterangan_filter = $this->input->post('keterangan_filter');
			$status_filter     = $this->input->post('status_filter');

			if($search != null){
				$search = $search['value'];
			}
			$list = $this->purchase_model->submission_list($search, $length, $start, $start_date, $end_date, $supplier_filter, $keterangan_filter, $status_filter)->result_array();
			$count_list = $this->purchase_model->submission_list_count($search, $start_date, $end_date, $supplier_filter, $keterangan_filter, $status_filter)->result_array();
			$total_row = $count_list[0]['total_row'];
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $field) {

				if($field['submission_status'] == 'Success'){
					$submission_status = '<span class="badge badge-success">Success</span>';
				}else if($field['submission_status'] == 'Pending'){
					$submission_status = '<span class="badge badge-primary multi-badge">Pending</span>';
				}else{
					$submission_status = '<span class="badge badge-danger multi-badge">Cancel</span>';
				}

				if($_SESSION['user_id'] == 1){
					$supplier_last = $field['supplier_name'];
				}else{
					$supplier_last = '-';
				}

				if($check_auth[0]->view == 'Y'){
					$url = base_url();
					$detail = '<a href="'.base_url().'Purchase/detailsubmission?id='.$field['submission_id'].'" data-fancybox="" data-type="iframe"><button type="button" class="btn btn-icon btn-primary btn-sm mb-2-btn" data-id="'.$field['submission_id'].'"><i class="fas fa-eye sizing-fa"></i></button></a> ';
				}else{
					$detail = '<a href="'.base_url().'Purchase/detailsubmission?id='.$field['submission_id'].'" data-fancybox="" data-type="iframe"><button type="button" class="btn btn-icon btn-primary btn-sm mb-2-btn" disabled="disabled"><i class="fas fa-eye sizing-fa"></i></button></a> ';
				}

				if($check_auth[0]->edit == 'Y'){
					if($field['submission_status'] == 'Pending'){
						$edit = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" data-bs-toggle="modal" data-bs-target="#exampleModaledit" data-id="'.$field['submission_id'].'" data-name="'.$field['submission_invoice'].'"><i class="fas fa-edit sizing-fa"></i></button> ';
					}else{
						$edit = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" data-bs-toggle="modal" data-bs-target="#exampleModaledit" data-id="'.$field['submission_id'].'" data-name="'.$field['submission_invoice'].'" disabled><i class="fas fa-edit sizing-fa"></i></button> ';
					}
				}else{
					$edit = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" disabled="disabled"><i class="fas fa-edit sizing-fa"></i></button> <button type="button" class="btn btn-icon btn-info btn-sm mb-2-btn" disabled="disabled"> ';
				}

				if($check_auth[0]->delete == 'Y'){
					if($field['submission_status'] == 'Pending'){
						$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn" onclick="deletes('.$field['submission_id'].')"><i class="fas fa-trash-alt sizing-fa"></i></button> ';
					}else{
						$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn" onclick="deletes('.$field['submission_id'].')" disabled><i class="fas fa-trash-alt sizing-fa"></i></button> ';
					}
				}else{
					$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn"  disabled="disabled"><i class="fas fa-trash-alt sizing-fa"></i></button> ';
				}

				$date = date_create($field['submission_date']); 

				$no++;
				$row = array();
				$row[] 	= $field['submission_invoice'];
				$row[] 	= date_format($date,"d-M-Y");
				$row[] 	= $field['user_name'];
				$row[] 	= $field['product_name'];
				$row[] 	= $field['submission_qty'].' '.$field['unit_name'];
				$row[] 	= $supplier_last;
				$row[] 	= $field['last_stock'];
				$row[] 	= $field['submission_desc'];
				$row[] 	= $submission_status;
				$row[] 	= $field['submission_text'];
				$row[] 	= $detail.$edit.$delete;
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

	public function detailsubmission()
	{
		$modul = 'Submission';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$id = $this->input->get('id');
			$submission_by_id['submission_by_id'] = $this->purchase_model->submission_by_id($id)->result_array(); 
			$this->load->view('Pages/Purchase/detailsubmission', $submission_by_id);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function delete_submission()
	{
		$modul = 'Submission';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->delete == 'Y'){
			$submission_id  = $this->input->post('id');
			$user_id 		= $_SESSION['user_id'];
			$get_submission_code = $this->purchase_model->get_submission_code($submission_id);
			$submission_invoice = $get_submission_code[0]->submission_invoice;
			$this->purchase_model->delete_submission($submission_id);
			$data_insert_act = array(
				'activity_table_desc'	       => 'Batalkan Pengajuan '.$submission_invoice,
				'activity_table_ref'		   => $submission_invoice,
				'activity_table_user'	       => $user_id,
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

	public function save_submission()
	{
		$modul = 'Submission';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){
			$submission_date 				= $this->input->post('submission_date');
			$submission_warehouse_name 		= $this->input->post('submission_warehouse_name');
			$submission_warehouse 			= $this->input->post('submission_warehouse');
			$submission_salesman 			= $this->input->post('submission_salesman');
			$submission_text 				= $this->input->post('submission_text');
			$submission_desc 				= $this->input->post('submission_desc');
			$submission_product_id 			= $this->input->post('submission_product_id');
			$submission_product_code 		= $this->input->post('submission_product_code');
			$submission_qty 				= $this->input->post('submission_qty');
			$submission_last_supplier       = $this->input->post('submission_last_supplier');
			$user_id 						= $_SESSION['user_id'];

			$maxCode = $this->purchase_model->last_submission_inv();
			$inv_code = 'PJ/'.$submission_product_code.'/'.$submission_warehouse_name.'/'.date("d/m/Y").'/';
			if ($maxCode == NULL) {
				$last_code = $inv_code.'000001';
			} else {
				$maxCode   = $maxCode[0]->submission_invoice;
				$last_code = substr($maxCode, -6);
				$last_code = $inv_code.substr('000000' . strval(floatval($last_code) + 1), -6);
			}

			$get_current_stock = $this->purchase_model->get_current_stock($submission_product_id);
			$last_stock = $get_current_stock[0]->total_last_stock;

			$data_insert = array(
				'submission_invoice'		=> $last_code,
				'submission_product_id'		=> $submission_product_id,
				'submission_product_code'	=> $submission_product_code,
				'submission_date'			=> $submission_date,
				'submission_warehouse'		=> $submission_warehouse,
				'submission_salesman'		=> $submission_salesman,
				'submission_qty'			=> $submission_qty,
				'last_stock'				=> $last_stock,
				'submission_desc'			=> $submission_desc,
				'submission_text'			=> $submission_text,
				'submission_last_supplier'	=> $submission_last_supplier,
				'created_by'				=> $user_id,
			);	

			$this->purchase_model->insert_submission($data_insert);
			$data_insert_act = array(
				'activity_table_desc'	       => 'Tambah Pengajuan Baru '.$last_code,
				'activity_table_ref'		   => $last_code,
				'activity_table_user'	       => $user_id,
			);
			$this->global_model->save($data_insert_act);
			$msg = "Succes Input";
			echo json_encode(['code'=>200, 'result'=>$msg]);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}


	public function edit_submission()
	{
		$modul = 'Submission';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->edit == 'Y'){
			$submission_id 					= $this->input->post('submission_id');
			$submission_inv 				= $this->input->post('submission_inv');
			$submission_date 				= $this->input->post('submission_date');
			$submission_warehouse_name 		= $this->input->post('submission_warehouse_name');
			$submission_warehouse 			= $this->input->post('submission_warehouse');
			$submission_salesman 			= $this->input->post('submission_salesman');
			$submission_text 				= $this->input->post('submission_text');
			$submission_desc 				= $this->input->post('submission_desc');
			$submission_product_id 			= $this->input->post('submission_product_id');
			$submission_product_code 		= $this->input->post('submission_product_code');
			$submission_qty 				= $this->input->post('submission_qty');
			$submission_last_supplier       = $this->input->post('submission_last_supplier');
			$user_id 						= $_SESSION['user_id'];

			$data_edit = array(
				'submission_product_id'		=> $submission_product_id,
				'submission_product_code'	=> $submission_product_code,
				'submission_date'			=> $submission_date,
				'submission_warehouse'		=> $submission_warehouse,
				'submission_salesman'		=> $submission_salesman,
				'submission_qty'			=> $submission_qty,
				'submission_desc'			=> $submission_desc,
				'submission_text'			=> $submission_text,
				'submission_last_supplier'	=> $submission_last_supplier,
				'created_by'				=> $user_id,
			);	

			$check_status_submission = $this->purchase_model->submission_by_id($submission_id)->result_array();
			if($check_status_submission[0]['submission_status'] == 'Cancel'){
				$msg = "Data Yang Sudah Di Cancel Tidak Bisa Di Edit";
				echo json_encode(['code'=>0, 'result'=>$msg]);
			}else{
				$this->purchase_model->edit_submission($data_edit, $submission_id);
				$data_insert_act = array(
					'activity_table_desc'	       => 'Edit Pengajuan '.$submission_inv,
					'activity_table_ref'		   => $submission_inv,
					'activity_table_user'	       => $user_id,
				);
				$this->global_model->save($data_insert_act);
				$msg = "Succes Input";
				echo json_encode(['code'=>200, 'result'=>$msg]);
			}
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function submission_by_id()
	{
		$id = $this->input->post('id');
		$submission_by_id = $this->purchase_model->submission_by_id($id)->result_array();; 
		echo json_encode(['code'=>200, 'result'=>$submission_by_id]);
	} 
	// end submission



	// pruchase order

	public function po()
	{
		$modul = 'PO';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$supplier_list['supplier_list'] = $this->masterdata_model->supplier_list();
			$this->load->view('Pages/Purchase/purchaseorder', $supplier_list);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function po_list()
	{
		
		$modul = 'PO';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$search 			= $this->input->post('search');
			$length 			= $this->input->post('length');
			$start 			  	= $this->input->post('start');

			if($this->input->post('start_date_val') != null){
				$start_date_val 	 = $this->input->post('start_date_val');
				$end_date_val 		 = $this->input->post('end_date_val');
				$supplier_filter_val = $this->input->post('supplier_filter_val');
			}else{
				$start_date_val 	 = "";
				$end_date_val 		 = "";
				$supplier_filter_val = "";
			}

			if($search != null){
				$search = $search['value'];
			}
			$list = $this->purchase_model->po_list($search, $length, $start, $start_date_val, $end_date_val, $supplier_filter_val)->result_array();
			$count_list = $this->purchase_model->po_list_count($search, $start_date_val, $end_date_val, $supplier_filter_val)->result_array();
			$total_row = $count_list[0]['total_row'];
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $field) {

				if($field['hd_po_tax'] == 'PPN'){
					$tax = '<span class="badge badge-success">BKP</span>';
				}else{
					$tax = '<span class="badge badge-danger">NON BKP</span>';
				}

				if($field['hd_po_purchase_status'] == 'Pending'){
					$hd_po_status = '<span class="badge badge-primary">Pending</span>';
				}else if($field['hd_po_status'] == 'Success'){
					$hd_po_status = '<span class="badge badge-success">Selesai</span>';
				}else{
					$hd_po_status = '<span class="badge badge-danger">Batal</span>';
				}

				if($field['hd_po_status'] == 'Pending'){
					$hd_po_status_input = '<span class="badge badge-primary">Pending</span>';
				}else if($field['hd_po_status'] == 'Success'){
					$hd_po_status_input = '<span class="badge badge-success">Selesai</span>';
				}else{
					$hd_po_status_input = '<span class="badge badge-danger">Batal</span>';
				}

				if($check_auth[0]->view == 'Y'){
					$url = base_url();
					$detail = '<a href="'.base_url().'Purchase/detailpo?id='.$field['hd_po_id'].'" data-fancybox="" data-type="iframe"><button type="button" class="btn btn-icon btn-primary btn-sm mb-2-btn" data-id="'.$field['hd_po_id'].'"><i class="fas fa-eye sizing-fa"></i></button></a> ';
				}else{
					$detail = '<a href="'.base_url().'Purchase/detailpo?id='.$field['hd_po_id'].'" data-fancybox="" data-type="iframe"><button type="button" class="btn btn-icon btn-primary btn-sm mb-2-btn" disabled="disabled"><i class="fas fa-eye sizing-fa"></i></button></a> ';
				}

				if($check_auth[0]->edit == 'Y'){
					if($field['hd_po_status'] == 'Pending'){
						$edit = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" onclick="edit('.$field['hd_po_id'].')"><i class="fas fa-edit sizing-fa"></i></button> ';
					}else{
						$edit = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" disabled="disabled" onclick="edit('.$field['hd_po_id'].')"><i class="fas fa-edit sizing-fa"></i></button> ';
					}
				}else{
					$edit = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" disabled="disabled" onclick="edit('.$field['hd_po_id'].')"><i class="fas fa-edit sizing-fa"></i></button> <button type="button" class="btn btn-icon btn-info btn-sm mb-2-btn" disabled="disabled"> ';
				}

				if($check_auth[0]->delete == 'Y'){
					if($field['hd_po_status'] == 'Pending'){
						$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn" onclick="deletes('.$field['hd_po_id'].')"><i class="fas fa-trash-alt sizing-fa"></i></button> ';
					}else{
						$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn"  disabled="disabled"><i class="fas fa-trash-alt sizing-fa"></i></button> ';
					}
				}else{
					$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn"  disabled="disabled"><i class="fas fa-trash-alt sizing-fa"></i></button> ';
				}

				if($check_auth[0]->view == 'Y'){
					$note = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" onclick="note('.$field['hd_po_id'].')" data-toggle="tooltip" title="Print Memo"><i class="fas fa-sticky-note sizing-fa"></i></button> ';
				}else{
					$note = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" disabled="disabled" onclick="edit('.$field['hd_po_id'].')"><i class="fas fa-sticky-note sizing-fa"></i></button> <button type="button" class="btn btn-icon btn-info btn-sm mb-2-btn" disabled="disabled"> ';
				}

				$date = date_create($field['hd_po_date']); 

				$no++;
				$row = array();
				$row[] 	= $field['hd_po_invoice'];
				$row[] 	= date_format($date,"d-M-Y");
				$row[] 	= $field['product_name'];
				$row[] 	= $tax;
				$row[] 	= $field['supplier_name'];
				$row[] 	= 'Rp. '.number_format($field['dt_po_price']);
				$row[] 	= $field['dt_po_qty'];
				$row[] 	= 'Rp. '.number_format($field['hd_po_grand_total']);
				$row[] 	= $hd_po_status;
				$row[] 	= $hd_po_status_input;
				$row[] 	= $field['hd_po_status_delivery'];
				$row[] 	= $detail.$edit.$delete.$note;
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

	public function printponote()
	{
		$modul = 'PO';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->edit == 'Y'){
			$po_id = $this->input->get('id');
			$header_po['header_po'] = $this->purchase_model->header_po($po_id);
			$detail_po['detail_po'] = $this->purchase_model->detail_po($po_id);
			$data['data'] = array_merge($header_po, $detail_po);
			$this->load->view('Pages/Purchase/printmemo', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function clear_temp_po()
	{
		$user_id   					= $_SESSION['user_id'];
		$this->purchase_model->clear_temp_po($user_id);
		echo json_encode(['code'=>200, 'result'=>'Success Clear Temp']);
		die();
	}
	
	public function editpo()
	{
		$modul = 'PO';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->edit == 'Y'){
			$po_id = $this->input->get('id');
			$header_po = $this->purchase_model->header_po($po_id);
			$detail_po = $this->purchase_model->detail_po($po_id);
			$user_id   					= $_SESSION['user_id'];
			$this->purchase_model->clear_temp_po($user_id);
			foreach($detail_po as $row){

				$submission_id 	 			= $row->submission_id;
				$submission_code 			= $row->submission_inv;
				$po_supplier     			= $header_po[0]->hd_po_supplier;
				$product_id      			= $row->dt_product_id;
				$temp_price_val 			= $row->dt_po_price;
				$temp_qty  					= $row->dt_po_qty;
				$temp_weight 				= $row->dt_po_weight;
				$temp_delivery_price_val  	= $row->dt_po_ongkir;
				$temp_total_weight			= $row->dt_po_total_weight;
				$temp_ongkir_val			= $row->dt_po_total_ongkir;
				$temp_total_val				= $row->dt_po_total;
				$temp_note_val				= $row->dt_po_note;

				$data_insert = array(
					'temp_submission_id'	=> $submission_id,
					'temp_submission_inv'	=> $submission_code,
					'temp_supplier_id'		=> $po_supplier,
					'temp_product_id'		=> $product_id,
					'temp_po_price'			=> $temp_price_val,
					'temp_po_qty'			=> $temp_qty,
					'temp_po_weight'		=> $temp_weight,
					'temp_po_ongkir'		=> $temp_delivery_price_val,
					'temp_po_total_weight'	=> $temp_total_weight,
					'temp_po_total_ongkir'	=> $temp_ongkir_val,
					'temp_po_total'			=> $temp_total_val,
					'temp_po_note'			=> $temp_note_val,
					'temp_user_id'			=> $user_id,
				);

				$this->purchase_model->insert_temp_po($data_insert);
			}
			$header_po_view['header_po_view'] = $this->purchase_model->header_po($po_id);
			$detail_po_view['detail_po_view'] = $this->purchase_model->detail_po($po_id);
			$supplier_list['supplier_list'] = $this->masterdata_model->supplier_list();
			$ekspedisi_list['ekspedisi_list'] = $this->masterdata_model->ekspedisi_list();
			$payment_list['payment_list'] = $this->masterdata_model->payment_list();
			$warehouse_list['warehouse_list'] = $this->masterdata_model->warehouse_list();
			$data['data'] = array_merge($supplier_list, $ekspedisi_list, $payment_list, $warehouse_list, $header_po_view, $detail_po_view);
			$this->load->view('Pages/Purchase/purchaseorderedit', $data);
			//echo json_encode($output);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function detailpo()
	{
		$modul = 'PO';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$po_id = $this->input->get('id');
			$header_po['header_po'] = $this->purchase_model->header_po($po_id);
			$detail_po['detail_po'] = $this->purchase_model->detail_po($po_id); 
			$data['data'] = array_merge($header_po, $detail_po);
			$this->load->view('Pages/Purchase/detailpo', $data);
			//echo json_encode($output);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function addpo()
	{
		$modul = 'PO';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){
			$supplier_list['supplier_list'] = $this->masterdata_model->supplier_list();
			$ekspedisi_list['ekspedisi_list'] = $this->masterdata_model->ekspedisi_list();
			$payment_list['payment_list'] = $this->masterdata_model->payment_list();
			$warehouse_list['warehouse_list'] = $this->masterdata_model->warehouse_list();
			$data['data'] = array_merge($supplier_list, $ekspedisi_list, $payment_list, $warehouse_list);
			$this->load->view('Pages/Purchase/purchaseorderadd', $data);
			//echo json_encode($output);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}


	public function search_submission()
	{
		$keyword = $this->input->get('term');
		$result = ['success' => FALSE, 'num_product' => 0, 'data' => [], 'message' => ''];
		if (!($keyword == '' || $keyword == NULL)) {
			$find = $this->purchase_model->search_submission($keyword)->result_array(); 
			$find_result = [];
			foreach ($find as $row) {
				$diplay_text = $row['product_name'].'('.$row['submission_invoice'].')';
				$find_result[] = [
					'id'                  => $row['submission_id'],
					'value'               => $diplay_text,
					'code'                => $row['submission_invoice'],
					'product_name'        => $row['product_name'],
					'product_id'          => $row['product_id'],
					'product_price'       => $row['product_price'],
					'product_weight'      => $row['product_weight'],
					'last_supplier'       => $row['submission_last_supplier'],
					'qty'      			  => $row['submission_qty'],
				];
			}
			$result = ['success' => TRUE, 'num_product' => count($find_result), 'data' => $find_result, 'message' => ''];
		}
		echo json_encode($result);
	}

	public function get_header_edit()
	{
		$po_id = $this->input->post('purchase_order_id');
		$get_header_edit = $this->purchase_model->header_po($po_id);
		echo json_encode(['code'=>200, 'data'=>$get_header_edit]);
		die();
	}

	public function add_temp_po()
	{

		$modul = 'PO';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){
			$submission_id 				= $this->input->post('submission_id');
			$submission_code 			= $this->input->post('submission_code');
			$po_supplier 			    = $this->input->post('po_supplier');
			$product_id 				= $this->input->post('product_id');
			$temp_price_val 			= $this->input->post('temp_price_val');
			$temp_qty 					= $this->input->post('temp_qty');
			$temp_weight 				= $this->input->post('temp_weight');
			$temp_delivery_price_val 	= $this->input->post('temp_delivery_price_val');
			$temp_total_weight 			= $this->input->post('temp_total_weight');
			$temp_ongkir_val 			= $this->input->post('temp_ongkir_val');
			$temp_total_val 			= $this->input->post('temp_total_val');
			$temp_note 					= $this->input->post('temp_note');
			$user_id 					= $_SESSION['user_id'];

			$check_temp_po_input = $this->purchase_model->check_temp_po_input($product_id, $user_id);
			$data_insert = array(
				'temp_submission_id'	=> $submission_id,
				'temp_submission_inv'	=> $submission_code,
				'temp_supplier_id'		=> $po_supplier,
				'temp_product_id'		=> $product_id,
				'temp_po_price'			=> $temp_price_val,
				'temp_po_qty'			=> $temp_qty,
				'temp_po_weight'		=> $temp_weight,
				'temp_po_ongkir'		=> $temp_delivery_price_val,
				'temp_po_total_weight'	=> $temp_total_weight,
				'temp_po_total_ongkir'	=> $temp_ongkir_val,
				'temp_po_total'			=> $temp_total_val,
				'temp_po_note'			=> $temp_note,
				'temp_user_id'			=> $user_id,
			);	
			$msg = 'Success Tambah';

			if($check_temp_po_input != null){
				$this->purchase_model->edit_temp_po($product_id, $user_id, $data_insert);
			}else{
				$this->purchase_model->insert_temp_po($data_insert);
			}
			echo json_encode(['code'=>200, 'result'=>$msg]);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function temp_po_list()
	{
		$modul = 'PO';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){
			$search 			= $this->input->post('search');
			$length 			= $this->input->post('length');
			$start 			  	= $this->input->post('start');
			$user 				= $_SESSION['user_id'];
			if($search != null){
				$search = $search['value'];
			}
			$list = $this->purchase_model->temp_po_list($search, $length, $start, $user)->result_array();
			$count_list = $this->purchase_model->temp_po_list_count($search, $user)->result_array();
			$total_row = $count_list[0]['total_row'];
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $field) {

				$edit = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" onclick="edit_temp('.$field['temp_po_id'].')"><i class="fas fa-edit sizing-fa"></i></button> ';
				$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn" onclick="deletes('.$field['temp_po_id'].')"><i class="fas fa-trash-alt sizing-fa"></i></button> ';

				$no++;
				$row = array();
				$row[] 	= $field['submission_invoice'];
				$row[] 	= $field['product_code'];
				$row[] 	= $field['product_name'];
				$row[] 	= $field['unit_name'];
				$row[] 	= 'Rp. '.number_format($field['temp_po_price']);
				$row[] 	= $field['temp_po_qty'];
				$row[] 	= 'Rp. '.number_format($field['temp_po_total_ongkir']);
				$row[] 	= 'Rp. '.number_format($field['temp_po_total']);
				$row[] 	= $field['temp_po_note'];
				$row[] 	= $edit.$delete;
				$data[] = $row;
			}

			if($total_row == 0){
				//$supplier = "0";
			}else{
				//print_r($list);die();
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

	public function delete_temp_po()
	{
		$temp_po_id  = $this->input->post('id');
		$user_id 	 = $_SESSION['user_id'];
		$this->purchase_model->delete_temp_po($temp_po_id);
		$msg = 'Success Delete';
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();
	}


	public function check_temp_po()
	{
		$user_id 		= $_SESSION['user_id'];
		$check_temp_po = $this->purchase_model->check_temp_po($user_id)->result_array();;
		if($check_temp_po[0]['sub_total'] != null){
			$product_tax 	 = $check_temp_po[0]['is_ppn'];
			$sub_total  	 = $check_temp_po[0]['sub_total'];
			$ongkir     	 = $check_temp_po[0]['ongkir'];
			$supplier_id     = $check_temp_po[0]['temp_supplier_id'];
		}else{
			$supplier     = 0;
			$product_tax  = 0;
			$sub_total    = 0;
			$ongkir       = 0;
			$supplier_id  = 0;
		}
		echo json_encode(['code'=>200, 'product_tax'=>$product_tax, 'sub_total'=>$sub_total, 'ongkir' => $ongkir, 'supplier_id' => $supplier_id]);
		die();
	}

	public function get_edit_temp_po()
	{
		$temp_po_id  = $this->input->post('id');
		$check_edit_temp_po = $this->purchase_model->check_edit_temp_po($temp_po_id)->result_array();
		echo json_encode(['code'=>200, 'result'=>$check_edit_temp_po]);
		die();
	}

	public function cal_due_date()
	{	
		$po_top = $this->input->post('po_top');
		if($po_top == null){
			$due_date = null;
		}else{
			if($po_top != 0){
				if($po_top == 'CBD'){
					$due_date = date('Y-m-d');
				}else{
					$po_top = $po_top - 1;
					$due_date = date('Y-m-d', strtotime("+".$po_top." day"));
				}
			}else{
				$due_date = date('Y-m-d');
			}
		}
	
		echo json_encode(['code'=>200, 'result'=>$due_date]);
		die();
	}

	public function save_po()
	{

		$modul = 'PO';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){
			$po_supplier 								= $this->input->post('po_supplier');
			$po_date 									= $this->input->post('po_date');
			$po_supplier								= $this->input->post('po_supplier');
			$po_tax 									= $this->input->post('po_tax');
			$po_ekspedisi 								= $this->input->post('po_ekspedisi');
			$po_top 									= $this->input->post('po_top');
			$purchase_order_due_date 					= $this->input->post('purchase_order_due_date');
			$po_payment_method 							= $this->input->post('po_payment_method');
			$po_warehouse 								= $this->input->post('po_warehouse');
			$footer_sub_total_submit 					= $this->input->post('footer_sub_total_submit');
			$footer_total_discount_submit 				= $this->input->post('footer_total_discount_submit');
			$edit_footer_discount_percentage1_submit 	= $this->input->post('edit_footer_discount_percentage1_submit');
			$edit_footer_discount_percentage2_submit 	= $this->input->post('edit_footer_discount_percentage2_submit');
			$edit_footer_discount_percentage3_submit 	= $this->input->post('edit_footer_discount_percentage3_submit');
			$edit_footer_discount1_submit 				= $this->input->post('edit_footer_discount1_submit');
			$edit_footer_discount2_submit 				= $this->input->post('edit_footer_discount2_submit');
			$edit_footer_discount3_submit 				= $this->input->post('edit_footer_discount3_submit');
			$footer_dpp_val 							= $this->input->post('footer_dpp_val');
			$footer_total_ppn_val 						= $this->input->post('footer_total_ppn_val');
			$footer_total_ongkir_val 					= $this->input->post('footer_total_ongkir_val');
			$footer_total_invoice_val 					= $this->input->post('footer_total_invoice_val');
			$purchase_order_remark 						= $this->input->post('purchase_order_remark');
			$user_id 									= $_SESSION['user_id'];

			if($po_supplier == null){
				$msg = 'Silahkan Masukan Supplier';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($po_ekspedisi == null){
				$msg = 'Silahkan Masukan Ekspedisi';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($po_payment_method == null){
				$msg = 'Silahkan Masukan Jenis Pembayaran';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($po_warehouse == null){
				$msg = 'Silahkan Masukan Gudang';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($footer_total_invoice_val <= 0){
				$msg = 'Silahkan Input Data Terlebih Dahulu';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			$warehouse_id = $po_warehouse;
			$get_warehouse_code = $this->masterdata_model->get_warehouse_code($warehouse_id);
			$warehouse_code = $get_warehouse_code[0]->warehouse_code;
			$warehouse_name = $get_warehouse_code[0]->warehouse_name;

			$supplier_id = $po_supplier;
			$get_supplier_code = $this->masterdata_model->get_supplier_code($supplier_id);
			$supplier_code = $get_supplier_code[0]->supplier_code;
			$supplier_name = $get_supplier_code[0]->supplier_name;
			

			$maxCode  = $this->purchase_model->last_po();
			$inv_code = 'PO/'.$supplier_code.'/'.$warehouse_code.'/'.date("d/m/Y").'/';
			if ($maxCode == NULL) {
				$last_code = $inv_code.'000001';
			} else {
				$maxCode   = $maxCode[0]->hd_po_invoice;
				$last_code = substr($maxCode, -6);
				$last_code = $inv_code.substr('000000' . strval(floatval($last_code) + 1), -6);
			}

			$data_insert = array(
				'hd_po_invoice'				=> $last_code,
				'hd_po_date'				=> $po_date,
				'hd_po_warehouse'			=> $po_warehouse,
				'hd_po_supplier'			=> $po_supplier,
				'hd_po_tax'					=> $po_tax,
				'hd_po_top'					=> $po_top,
				'hd_po_due_date'			=> $purchase_order_due_date,
				'hd_po_payment'				=> $po_payment_method,
				'hd_po_ekspedisi'			=> $po_ekspedisi,
				'hd_po_sub_total'			=> $footer_sub_total_submit,
				'hd_po_disc_percentage1'	=> $edit_footer_discount_percentage1_submit,
				'hd_po_disc_percentage2'	=> $edit_footer_discount_percentage2_submit,
				'hd_po_disc_percentage3'	=> $edit_footer_discount_percentage3_submit,
				'hd_po_disc_1'				=> $edit_footer_discount1_submit,
				'hd_po_disc_2'				=> $edit_footer_discount2_submit,
				'hd_po_disc_3'				=> $edit_footer_discount3_submit,
				'hd_po_total_discount'		=> $footer_total_discount_submit,
				'hd_po_dpp'					=> $footer_dpp_val,
				'hd_po_ppn'					=> $footer_total_ppn_val,
				'hd_po_ongkir'				=> $footer_total_ongkir_val,
				'hd_po_grand_total'			=> $footer_total_invoice_val,
				'hd_po_note'			    => $purchase_order_remark,
				'created_by'				=> $user_id
			);	
			
			$save_po = $this->purchase_model->save_po($data_insert);

			$get_temp_po = $this->purchase_model->get_temp_po($user_id)->result_array();
			foreach($get_temp_po  as $row){
				$data_insert_detail = array(
					'hd_po_id'				=> $save_po,
					'submission_id'			=> $row['temp_submission_id'],
					'submission_inv'		=> $row['temp_submission_inv'],
					'dt_product_id'			=> $row['temp_product_id'],
					'dt_po_price'			=> $row['temp_po_price'],
					'dt_po_qty'				=> $row['temp_po_qty'],
					'dt_po_weight'			=> $row['temp_po_weight'],
					'dt_po_ongkir'			=> $row['temp_po_ongkir'],
					'dt_po_total_weight'	=> $row['temp_po_total_weight'],
					'dt_po_total_ongkir'	=> $row['temp_po_total_ongkir'],
					'dt_po_total'			=> $row['temp_po_total'],
					'dt_po_note'			=> $row['temp_po_note'],
				);	

				$dt_product_id = $row['temp_product_id'];
				$save_detail_po = $this->purchase_model->save_detail_po($data_insert_detail);

				$check_supplier_stock = $this->purchase_model->check_supplier_stock($dt_product_id, $supplier_id);
				if($check_supplier_stock == null){
					$insert_supplier = array(
						'product_id'			=> $dt_product_id,
						'supplier_id'			=> $supplier_id,
					);	
					$this->masterdata_model->save_product_supplier($insert_supplier);

					$get_master_product_supplier = $this->masterdata_model->get_master_product_supplier($dt_product_id);
					$product_supplier_id_tag = $get_master_product_supplier[0]->product_supplier_id_tag;
					$product_supplier_tag    = $get_master_product_supplier[0]->product_supplier_tag;

					$product_supplier_id_tag = $product_supplier_id_tag.','.$supplier_id;
					$product_supplier_tag    = $product_supplier_tag.','.$supplier_name;

					$update_product_tag = $this->purchase_model->update_product_tag($product_supplier_id_tag, $product_supplier_tag, $dt_product_id);
				}

				$last_product_po_status = $this->purchase_model->last_product_po_status($dt_product_id);
				$last_product_po_status_number = $last_product_po_status[0]->product_po_status;
				$new_product_po_status_number  = $last_product_po_status_number + 1;
				$update_product_po_status = $this->purchase_model->update_product_po_status($dt_product_id, $new_product_po_status_number);

				if($row['temp_submission_id'] > 0 || $row['temp_submission_id'] != ''){
					$submission_id_val = $row['temp_submission_id'];
					$update_submission = $this->purchase_model->update_submission($submission_id_val);
				}
				
			}

			$data_insert_act = array(
				'activity_table_desc'	       => 'Tambah PO Cabang '.$warehouse_name.' Ref: '.$last_code,
				'activity_table_ref'		   => $last_code,
				'activity_table_user'	       => $user_id,
			);

			$this->global_model->save($data_insert_act);

			$this->purchase_model->clear_temp_po($user_id);

			$msg = 'Success Tambah';
			echo json_encode(['code'=>200, 'result'=>$msg]);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function save_edit()
	{

		$modul = 'PO';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->edit == 'Y'){
			$purchase_order_id  						= $this->input->post('purchase_order_id');
			$purchase_order_invoice						= $this->input->post('purchase_order_invoice');
			$po_supplier 								= $this->input->post('po_supplier');
			$po_date 									= $this->input->post('po_date');
			$po_supplier								= $this->input->post('po_supplier');
			$po_tax 									= $this->input->post('po_tax');
			$po_ekspedisi 								= $this->input->post('po_ekspedisi');
			$po_top 									= $this->input->post('po_top');
			$purchase_order_due_date 					= $this->input->post('purchase_order_due_date');
			$po_payment_method 							= $this->input->post('po_payment_method');
			$po_warehouse 								= $this->input->post('po_warehouse');
			$footer_sub_total_submit 					= $this->input->post('footer_sub_total_submit');
			$footer_total_discount_submit 				= $this->input->post('footer_total_discount_submit');
			$edit_footer_discount_percentage1_submit 	= $this->input->post('edit_footer_discount_percentage1_submit');
			$edit_footer_discount_percentage2_submit 	= $this->input->post('edit_footer_discount_percentage2_submit');
			$edit_footer_discount_percentage3_submit 	= $this->input->post('edit_footer_discount_percentage3_submit');
			$edit_footer_discount1_submit 				= $this->input->post('edit_footer_discount1_submit');
			$edit_footer_discount2_submit 				= $this->input->post('edit_footer_discount2_submit');
			$edit_footer_discount3_submit 				= $this->input->post('edit_footer_discount3_submit');
			$footer_dpp_val 							= $this->input->post('footer_dpp_val');
			$footer_total_ppn_val 						= $this->input->post('footer_total_ppn_val');
			$footer_total_ongkir_val 					= $this->input->post('footer_total_ongkir_val');
			$footer_total_invoice_val 					= $this->input->post('footer_total_invoice_val');
			$purchase_order_remark 						= $this->input->post('purchase_order_remark');
			$user_id 									= $_SESSION['user_id'];

			if($po_supplier == null){
				$msg = 'Silahkan Masukan Supplier';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($po_ekspedisi == null){
				$msg = 'Silahkan Masukan Ekspedisi';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($purchase_order_due_date == null){
				$msg = 'Silahkan Masukan Jatuh Tempo';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($po_payment_method == null){
				$msg = 'Silahkan Masukan Jenis Pembayaran';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($po_warehouse == null){
				$msg = 'Silahkan Masukan Gudang';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($footer_total_invoice_val <= 0){
				$msg = 'Silahkan Input Data Terlebih Dahulu';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			$warehouse_id = $po_warehouse;
			$get_warehouse_code = $this->masterdata_model->get_warehouse_code($warehouse_id);
			$warehouse_code = $get_warehouse_code[0]->warehouse_code;
			$warehouse_name = $get_warehouse_code[0]->warehouse_name;

			$supplier_id = $po_supplier;
			$get_supplier_code = $this->masterdata_model->get_supplier_code($supplier_id);
			$supplier_code = $get_supplier_code[0]->supplier_code;
			$supplier_name = $get_supplier_code[0]->supplier_name;

			$last_code = $purchase_order_invoice;

			$data_insert = array(
				'hd_po_date'				=> $po_date,
				'hd_po_warehouse'			=> $po_warehouse,
				'hd_po_supplier'			=> $po_supplier,
				'hd_po_tax'					=> $po_tax,
				'hd_po_top'					=> $po_top,
				'hd_po_due_date'			=> $purchase_order_due_date,
				'hd_po_payment'				=> $po_payment_method,
				'hd_po_ekspedisi'			=> $po_ekspedisi,
				'hd_po_sub_total'			=> $footer_sub_total_submit,
				'hd_po_disc_percentage1'	=> $edit_footer_discount_percentage1_submit,
				'hd_po_disc_percentage2'	=> $edit_footer_discount_percentage2_submit,
				'hd_po_disc_percentage3'	=> $edit_footer_discount_percentage3_submit,
				'hd_po_disc_1'				=> $edit_footer_discount1_submit,
				'hd_po_disc_2'				=> $edit_footer_discount2_submit,
				'hd_po_disc_3'				=> $edit_footer_discount3_submit,
				'hd_po_total_discount'		=> $footer_total_discount_submit,
				'hd_po_dpp'					=> $footer_dpp_val,
				'hd_po_ppn'					=> $footer_total_ppn_val,
				'hd_po_ongkir'				=> $footer_total_ongkir_val,
				'hd_po_grand_total'			=> $footer_total_invoice_val,
				'hd_po_note'			    => $purchase_order_remark,
				'created_by'				=> $user_id
			);	
			
			$save_po = $this->purchase_model->edit_po($data_insert, $purchase_order_id);

			$get_temp_po = $this->purchase_model->get_temp_po($user_id)->result_array();
			foreach($get_temp_po  as $row){
				$data_insert_detail = array(
					'hd_po_id'				=> $purchase_order_id,
					'submission_id'			=> $row['temp_submission_id'],
					'submission_inv'		=> $row['temp_submission_inv'],
					'dt_product_id'			=> $row['temp_product_id'],
					'dt_po_price'			=> $row['temp_po_price'],
					'dt_po_qty'				=> $row['temp_po_qty'],
					'dt_po_weight'			=> $row['temp_po_weight'],
					'dt_po_ongkir'			=> $row['temp_po_ongkir'],
					'dt_po_total_weight'	=> $row['temp_po_total_weight'],
					'dt_po_total_ongkir'	=> $row['temp_po_total_ongkir'],
					'dt_po_total'			=> $row['temp_po_total'],
					'dt_po_note'			=> $row['temp_po_note'],
				);	

				$dt_product_id = $row['temp_product_id'];
				$clear_detail_po = $this->purchase_model->clear_detail_po($purchase_order_id);
				$save_detail_po = $this->purchase_model->save_detail_po($data_insert_detail);

				$check_supplier_stock = $this->purchase_model->check_supplier_stock($dt_product_id, $supplier_id);
				if($check_supplier_stock == null){
					$insert_supplier = array(
						'product_id'			=> $dt_product_id,
						'supplier_id'			=> $supplier_id,
					);	
					$this->masterdata_model->save_product_supplier($insert_supplier);

					$get_master_product_supplier = $this->masterdata_model->get_master_product_supplier($dt_product_id);
					$product_supplier_id_tag = $get_master_product_supplier[0]->product_supplier_id_tag;
					$product_supplier_tag    = $get_master_product_supplier[0]->product_supplier_tag;

					$product_supplier_id_tag = $product_supplier_id_tag.','.$supplier_id;
					$product_supplier_tag    = $product_supplier_tag.','.$supplier_name;

					$update_product_tag = $this->purchase_model->update_product_tag($product_supplier_id_tag, $product_supplier_tag, $dt_product_id);
				}

				$last_product_po_status = $this->purchase_model->last_product_po_status($dt_product_id);
				$last_product_po_status_number = $last_product_po_status[0]->product_po_status;
				$new_product_po_status_number  = $last_product_po_status_number + 1;
				$update_product_po_status = $this->purchase_model->update_product_po_status($dt_product_id, $new_product_po_status_number);

				if($row['temp_submission_id'] > 0 || $row['temp_submission_id'] != ''){
					$submission_id_val = $row['temp_submission_id'];
					$update_submission = $this->purchase_model->update_submission($submission_id_val);
				}
				
			}

			$data_insert_act = array(
				'activity_table_desc'	       => 'Tambah PO Cabang '.$warehouse_name.' Ref: '.$last_code,
				'activity_table_ref'		   => $last_code,
				'activity_table_user'	       => $user_id,
			);

			$this->global_model->save($data_insert_act);

			$this->purchase_model->clear_temp_po($user_id);

			$msg = 'Success Tambah';
			echo json_encode(['code'=>200, 'result'=>$msg]);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}


	public function search_product_po()
	{	
		$supplier_id = $this->input->get('id');
		$keyword = $this->input->get('term');
		$result = ['success' => FALSE, 'num_product' => 0, 'data' => [], 'message' => ''];
		/*if($supplier_id == '' || $supplier_id == NULL){
			$result = ['success' => FALSE, 'message' => 'Masukan Nama Supplier Terlebih Dahulu'];
		}*/
		if (!($keyword == '' || $keyword == NULL)) {
			if($supplier_id == null){
				$find = $this->global_model->search_product($keyword, $supplier_id);
			}else{
				$find = $this->global_model->search_product_by_supplier($keyword, $supplier_id);
			}
			$find_result = [];
			foreach ($find as $row) {
				$diplay_text = $row->product_code.' - '.$row->product_name;
				$find_result[] = [
					'id'                  => '',
					'value'               => $diplay_text,
					'product_name'        => $row->product_name,
					'product_id'          => $row->product_id,
					'product_price'       => $row->product_price,
					'product_weight'      => $row->product_weight
				];
			}
			$result = ['success' => TRUE, 'num_product' => count($find_result), 'data' => $find_result, 'message' => ''];
		}
		echo json_encode($result);
	} 

	public function delete_po()
	{
		$modul = 'PO';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->delete == 'Y'){
			$po_id  		= $this->input->post('id');
			$user_id 		= $_SESSION['user_id'];
			$get_po_code 	= $this->purchase_model->get_po_code($po_id);
			$hd_po_invoice 	= $get_po_code[0]->hd_po_invoice;

			$get_detail_po = $this->purchase_model->detail_po($po_id);
			foreach($get_detail_po as $row)
			{
				$dt_product_id 				 	= $row->dt_product_id;
				$last_product_po_status 		= $this->purchase_model->last_product_po_status($dt_product_id);
				$last_product_po_status_number  = $last_product_po_status[0]->product_po_status;
				$new_product_po_status_number   = $last_product_po_status_number - 1;
				$update_product_po_status 		= $this->purchase_model->update_product_po_status($dt_product_id, $new_product_po_status_number);
			}

			$this->purchase_model->delete_po($po_id);
			$data_insert_act = array(
				'activity_table_desc'	       => 'Batalkan PO Ref: '.$hd_po_invoice,
				'activity_table_ref'	       => $hd_po_invoice,
				'activity_table_user'	       => $user_id,
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
	// end purchase order



	// warehouse input

	public function warehouseinput_list()
	{
		
		$modul = 'WarehouseInput';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$search 			 = $this->input->post('search');
			$length 			 = $this->input->post('length');
			$start 			  	 = $this->input->post('start');
			$start_date_val 	 = $this->input->post('start_date');
			$end_date_val 		 = $this->input->post('end_date');
			$warehouse_filter_val = $this->input->post('warehouse_filter');
			$supplier_filter_val 	 = $this->input->post('supplier_filter');

			if($search != null){
				$search = $search['value'];
			}
			$list = $this->purchase_model->warehouseinput_list($search, $length, $start, $start_date_val, $end_date_val, $warehouse_filter_val, $supplier_filter_val)->result_array();
			$count_list = $this->purchase_model->warehouseinput_list_count($search, $start_date_val, $end_date_val, $warehouse_filter_val, $supplier_filter_val)->result_array();
			$total_row = $count_list[0]['total_row'];
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $field) {

				if($field['hd_input_stock_status'] == 'Pending'){
					$hd_input_stock_status = '<span class="badge badge-primary">Pending</span>';
				}else if($field['hd_input_stock_status'] == 'Success'){
					$hd_input_stock_status = '<span class="badge badge-success">Selesai</span>';
				}else{
					$hd_input_stock_status = '<span class="badge badge-danger">Batal</span>';
				}

				if($check_auth[0]->view == 'Y'){
					$url = base_url();
					$detail = '<a href="'.base_url().'Purchase/detailinputstock?id='.$field['hd_input_stock_id'].'" data-fancybox="" data-type="iframe"><button type="button" class="btn btn-icon btn-primary btn-sm mb-2-btn" data-id="'.$field['hd_input_stock_id'].'"><i class="fas fa-eye sizing-fa"></i></button></a> ';
				}else{
					$detail = '<a href="'.base_url().'Purchase/detailinputstock?id='.$field['hd_input_stock_id'].'" data-fancybox="" data-type="iframe"><button type="button" class="btn btn-icon btn-primary btn-sm mb-2-btn" disabled="disabled"><i class="fas fa-eye sizing-fa"></i></button></a> ';
				}

				if($check_auth[0]->delete == 'Y'){
					if($field['hd_input_stock_status'] == 'Pending'){
						$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn" onclick="deletes('.$field['hd_input_stock_id'].')"><i class="fas fa-trash-alt sizing-fa"></i></button> ';
					}else{
						$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn"  disabled="disabled"><i class="fas fa-trash-alt sizing-fa"></i></button> ';
					}
				}else{
					$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn"  disabled="disabled"><i class="fas fa-trash-alt sizing-fa"></i></button> ';
				}

				$date = date_create($field['hd_input_stock_date']); 

				$no++;
				$row = array();
				$row[] 	= $field['hd_input_stock_inv'];
				$row[] 	= date_format($date,"d-M-Y");
				$row[] 	= $field['product_name'];
				$row[] 	= $field['supplier_name'];
				$row[] 	= $field['dt_is_qty_order'];
				$row[] 	= $field['dt_is_qty'];
				$row[] 	= $field['dt_is_note'];
				$row[] 	= $hd_input_stock_status;
				$row[] 	= $detail.$delete;
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


	public function warehouseinput()
	{
		$modul = 'WarehouseInput';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$warehouse_list['warehouse_list'] = $this->masterdata_model->warehouse_list();
			$supplier_list['supplier_list'] = $this->masterdata_model->supplier_list();
			$this->load->view('Pages/Purchase/warehouseinput', array_merge($warehouse_list, $supplier_list));
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function addwarehouseinput()
	{
		$modul = 'WarehouseInput';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){
			$supplier_list['supplier_list'] = $this->masterdata_model->supplier_list();
			$warehouse_list['warehouse_list'] = $this->masterdata_model->warehouse_list();
			$ekspedisi_list['ekspedisi_list'] = $this->masterdata_model->ekspedisi_list();
			$data['data'] = array_merge($supplier_list, $warehouse_list, $ekspedisi_list);
			$this->load->view('Pages/Purchase/warehouseinputadd', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}


	public function search_po()
	{
		$keyword = $this->input->get('term');
		$result = ['success' => FALSE, 'num_product' => 0, 'data' => [], 'message' => ''];
		if (!($keyword == '' || $keyword == NULL)) {
			$find = $this->purchase_model->search_po($keyword)->result_array(); 
			$find_result = [];
			foreach ($find as $row) {
				$diplay_text = $row['hd_po_invoice'];
				$find_result[] = [
					'id'                  => $row['hd_po_id'],
					'value'               => $diplay_text,
				];
			}
			$result = ['success' => TRUE, 'num_product' => count($find_result), 'data' => $find_result, 'message' => ''];
		}
		echo json_encode($result);
	}

	public function temp_input_stock_list()
	{
		$modul = 'WarehouseInput';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$search 			= $this->input->post('search');
			$length 			= $this->input->post('length');
			$start 			  	= $this->input->post('start');
			$user 				= $_SESSION['user_id'];
			if($search != null){
				$search = $search['value'];
			}
			$list = $this->purchase_model->temp_input_stock_list($search, $length, $start, $user)->result_array();
			$count_list = $this->purchase_model->temp_input_stock_count($search, $user)->result_array();
			$total_row = $count_list[0]['total_row'];
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $field) {

				$edit = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" onclick="edit_temp('.$field['temp_is_product_id'].')"><i class="fas fa-edit sizing-fa"></i></button> ';
				$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn" onclick="deletes('.$field['temp_is_product_id'].')"><i class="fas fa-trash-alt sizing-fa"></i></button> ';

				$no++;
				$row = array();
				$row[] 	= $field['product_code'];
				$row[] 	= $field['product_name'];
				$row[] 	= $field['unit_name'];
				$row[] 	= $field['temp_is_qty_order'];
				$row[] 	= $field['temp_is_qty'];
				$row[] 	= $field['temp_is_note'];
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

	public function clear_temp_input_stock()
	{
		$user_id = $_SESSION['user_id'];
		$this->purchase_model->clear_temp_input_stock($user_id);
		echo json_encode(['code'=>200]);die();
	}
	public function copy_po_to_temp()
	{
		$modul = 'WarehouseInput';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){
			$po_id 		= $this->input->post('po_id');
			$user_id 	= $_SESSION['user_id'];
			$get_detail_po = $this->purchase_model->detail_po($po_id);
			$this->purchase_model->clear_temp_input_stock($user_id);
			foreach($get_detail_po as $row)
			{
				$data_copy_temp_po = array(
					'temp_is_product_id'		=> $row->dt_product_id,
					'temp_is_qty_order'			=> $row->dt_po_qty,
					'temp_is_qty'				=> $row->dt_po_qty,
					'temp_is_supplier'			=> $row->hd_po_supplier,
					'temp_is_po_id'				=> $row->hd_po_id,
					'temp_is_po_code'			=> $row->hd_po_invoice,
					'temp_is_warehouse'			=> $row->hd_po_warehouse,
					'temp_is_ekspedisi'			=> $row->hd_po_ekspedisi,
					'temp_is_note'				=> $row->dt_po_note,
					'temp_is_user_id'			=> $user_id,
				);	

				$copy_temp_po = $this->purchase_model->copy_temp_po($data_copy_temp_po);
			}
			$msg = "Success Copy";
			echo json_encode(['code'=>200, 'result'=>$msg]);die();
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function check_temp_input_stock()
	{
		$user_id 		= $_SESSION['user_id'];
		$check_temp_input_stock = $this->purchase_model->check_temp_input_stock($user_id)->result_array();;
		if($check_temp_input_stock[0]['total_item'] != null){
			$supplier 	 	 = $check_temp_input_stock[0]['temp_is_supplier'];
			$po_code 	     = $check_temp_input_stock[0]['temp_is_po_code'];
			$po_id 	     	 = $check_temp_input_stock[0]['temp_is_po_id'];
			$warehouse 	     = $check_temp_input_stock[0]['temp_is_warehouse'];
			$ekspedisi 	     = $check_temp_input_stock[0]['temp_is_ekspedisi'];
			$total_item  	 = $check_temp_input_stock[0]['total_item'];
		}else{
			$po_code 		= 0;
			$po_id 			= 0;
			$supplier     	= 0;
			$warehouse  	= 0;
			$total_item    	= 0;
			$ekspedisi      = 0;
		}
		echo json_encode(['code'=>200, 'supplier'=>$supplier, 'ekspedisi'=>$ekspedisi, 'po_code'=>$po_code, 'po_id'=>$po_id, 'warehouse'=>$warehouse, 'total_item'=>$total_item]);
		die();
	}

	public function get_edit_temp_input_stock()
	{
		$product_id  = $this->input->post('id');
		$user_id 	 = $_SESSION['user_id'];
		$check_edit_temp_input_stock = $this->purchase_model->check_edit_temp_input_stock($product_id, $user_id)->result_array();
		echo json_encode(['code'=>200, 'result'=>$check_edit_temp_input_stock]);
		die();
	}

	public function add_temp_input_stock()
	{
		$modul = 'WarehouseInput';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){
			$product_id 				= $this->input->post('product_id');
			$temp_qty_recive 			= $this->input->post('temp_qty_recive');
			$input_stock_detail_remark  = $this->input->post('input_stock_detail_remark');
			$user_id 					= $_SESSION['user_id'];
			$check_temp_input_stock_product = $this->purchase_model->check_edit_temp_input_stock($product_id, $user_id);
			$data_edit = array(
				'temp_is_qty'			=> $temp_qty_recive,
				'temp_is_note'			=> $input_stock_detail_remark,
				'temp_is_user_id'		=> $user_id,
			);	
			if($check_temp_input_stock_product != null){
				$this->purchase_model->edit_temp_input_stock($product_id, $user_id, $data_edit);
			}
			$msg = 'Success Tambah';
			echo json_encode(['code'=>200, 'result'=>$msg]);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}


	public function delete_temp_input_stock()
	{
		$product_id  = $this->input->post('id');
		$user_id 	 = $_SESSION['user_id'];
		$this->purchase_model->delete_temp_input_stock($product_id, $user_id);
		$msg = 'Success Delete';
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();
	}

	public function save_input_stock()
	{
		$modul = 'WarehouseInput';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){
			$po_inv_id  		 = $this->input->post('po_inv_id');
			$warehouseinput_date = $this->input->post('warehouseinput_date');
			$warehouse 			 = $this->input->post('warehouse');
			$desc 				 = $this->input->post('desc');
			$user_id 			 = $_SESSION['user_id'];

			$maxCode = $this->purchase_model->last_save_input();
			$inv_code = 'IS/'.date("d/m/Y").'/';
			if ($maxCode == NULL) {
				$last_code = $inv_code.'000001';
			} else {
				$maxCode   = $maxCode[0]->hd_input_stock_inv;
				$last_code = substr($maxCode, -6);
				$last_code = $inv_code.substr('000000' . strval(floatval($last_code) + 1), -6);
			}
			$data_insert = array(
				'hd_input_stock_inv'		=> $last_code,
				'hd_input_stock_warehouse'  => $warehouse,
				'hd_po_id'					=> $po_inv_id,
				'hd_input_stock_date'		=> $warehouseinput_date,
				'hd_input_stock_desc'		=> $desc,
				'created_by'				=> $user_id
			);	
			$save_input_stock = $this->purchase_model->save_input_stock($data_insert);

			$get_temp_input_stock = $this->purchase_model->get_temp_input_stock($user_id)->result_array();
			foreach($get_temp_input_stock as $row){
				$data_insert_detail = array(
					'hd_is_id'				=> $save_input_stock,
					'dt_is_product_id'		=> $row['temp_is_product_id'],
					'dt_is_qty_order'		=> $row['temp_is_qty_order'],
					'dt_is_note'			=> $row['temp_is_note'],
					'dt_is_qty'				=> $row['temp_is_qty']
				);	
				$insert_detail_input_stock = $this->purchase_model->insert_detail_input_stock($data_insert_detail);

				$dt_product_id 				 	= $row['temp_is_product_id'];
				$last_product_po_status 		= $this->purchase_model->last_product_po_status($dt_product_id);
				$last_product_po_status_number  = $last_product_po_status[0]->product_po_status;
				$new_product_po_status_number   = $last_product_po_status_number - 1;
				$update_product_po_status 		= $this->purchase_model->update_product_po_status($dt_product_id, $new_product_po_status_number);
				

				$warehouse_id = $row['temp_is_warehouse'];
				if($warehouse_id != 1){
					$product_id 	= $row['temp_is_product_id'];
					$qty 			= $row['temp_is_qty'];
					$get_last_stock = $this->purchase_model->get_last_stock($product_id, $warehouse_id);
					if($get_last_stock == null){
						$insert_product_stock = array(
							'product_id'		=> $product_id,
							'warehouse_id'		=> $warehouse_id,
							'stock'				=> 0,
						);	
						$this->global_model->insert_product_stock($insert_product_stock);
						$last_stock 	= 0;
					}else{
						$last_stock 	= $get_last_stock[0]->stock;
					}
					$new_stock 		= $last_stock + $qty;
					$this->global_model->update_stock($product_id, $warehouse_id, $new_stock);

					$movement_stock = array(
						'stock_movement_product_id'		=> $product_id,
						'stock_movement_qty'			=> $qty,
						'stock_movement_before_stock'	=> $last_stock,
						'stock_movement_new_stock'		=> $new_stock,
						'stock_movement_desc'			=> 'Input Stock Pembelian',
						'stock_movement_inv'			=> $last_code,
						'stock_movement_calculate'		=> 'Plus',
						'stock_movement_date'			=> $warehouseinput_date,
						'stock_movement_creted_by'		=> $user_id,	
					);	
					$this->global_model->insert_movement_stock($movement_stock);
				}
			}

			$this->purchase_model->clear_temp_input_stock($user_id);
			
			$update_po_status = $this->purchase_model->update_po_status($po_inv_id);
			$data_insert_act = array(
				'activity_table_desc'	       => 'Tambah Input Stok Ref: '.$last_code,
				'activity_table_ref'	       => $last_code,
				'activity_table_user'	       => $user_id,
			);
			$this->global_model->save($data_insert_act);
			$msg = "Success Input";
			echo json_encode(['code'=>200, 'result'=>$msg]);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);
		}
	}


	public function detailinputstock()
	{
		$modul = 'WarehouseInput';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$input_stock_id = $this->input->get('id');
			$header_input_stock['header_input_stock'] = $this->purchase_model->header_input_stock($input_stock_id);
			$detail_input_stock['detail_input_stock'] = $this->purchase_model->detail_input_stock($input_stock_id); 
			$data['data'] = array_merge($header_input_stock, $detail_input_stock);
			$this->load->view('Pages/Purchase/detailinputstock', $data);
			//echo json_encode($output);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function delete_warehouse_input()
	{
		$modul = 'WarehouseInput';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->delete == 'Y'){
			$input_stock_id = $this->input->post('id');
			$user_id 		= $_SESSION['user_id'];
			$get_input_warehouse_code 	= $this->purchase_model->get_input_warehouse_code($input_stock_id);
			$hd_input_stock_inv 	= $get_input_warehouse_code[0]->hd_input_stock_inv;
			$get_dt_input_stock     = $this->purchase_model->detail_input_stock($input_stock_id);

			$date 					= date("d/m/Y");
			foreach($get_dt_input_stock as $row){
				$warehouse_id  	= $row->hd_input_stock_warehouse;
				if($warehouse_id != 1){
					$product_id 	= $row->dt_is_product_id;
					$qty 			= $row->dt_is_qty;
					$get_last_stock = $this->purchase_model->get_last_stock($product_id, $warehouse_id);
					$last_stock 	= $get_last_stock[0]->stock;
					$new_stock 		= $last_stock - $qty;
					$this->global_model->update_stock($product_id, $warehouse_id, $new_stock);

					$movement_stock = array(
						'stock_movement_product_id'		=> $product_id,
						'stock_movement_qty'			=> $qty,
						'stock_movement_before_stock'	=> $last_stock,
						'stock_movement_new_stock'		=> $new_stock,
						'stock_movement_desc'			=> 'Batal Input Stock',
						'stock_movement_inv'			=> $hd_input_stock_inv,
						'stock_movement_calculate'		=> 'Minus',
						'stock_movement_date'			=> $date,
						'stock_movement_creted_by'		=> $user_id,	
					);	
					$this->global_model->insert_movement_stock($movement_stock);
				}
			}
			$this->purchase_model->delete_warehouse_input($input_stock_id);
			$data_insert_act = array(
				'activity_table_desc'	       => 'Batalkan Input Stock Ref: '.$hd_input_stock_inv,
				'activity_table_ref'	       => $hd_input_stock_inv,
				'activity_table_user'	       => $user_id,
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
	// end warehouse input

	// start retur purchase
	public function returpurchase()
	{
		
		$modul = 'ReturPurchase';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$warehouse_list['warehouse_list'] = $this->masterdata_model->warehouse_list();
			$salesman_list['salesman_list'] = $this->masterdata_model->salesman_list();
			$supplier_list['supplier_list'] = $this->masterdata_model->supplier_list();
			$data['data'] = array_merge($warehouse_list, $salesman_list, $supplier_list);
			$this->load->view('Pages/Purchase/returpurchase', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function addreturpurchase()
	{
		
		$modul = 'ReturPurchase';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){
			$warehouse_list['warehouse_list'] = $this->masterdata_model->warehouse_list();
			$salesman_list['salesman_list'] = $this->masterdata_model->salesman_list();
			$supplier_list['supplier_list'] = $this->masterdata_model->supplier_list();
			$data['data'] = array_merge($warehouse_list, $salesman_list, $supplier_list);
			$this->load->view('Pages/Purchase/addreturpurchase', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function retur_purchase_list()
	{

		$modul = 'ReturPurchase';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$search 			= $this->input->post('search');
			$length 			= $this->input->post('length');
			$start 			  	= $this->input->post('start');
			if($search != null){
				$search = $search['value'];
			}

			$list = $this->purchase_model->returpurchase_list($search, $length, $start)->result_array();
			$count_list = $this->purchase_model->returpurchase_list_count($search)->result_array();
			$total_row = $count_list[0]['total_row'];
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $field) {

				if($field['hd_retur_purchase_status'] == 'Success'){
					$hd_retur_purchase_status = '<span class="badge badge-success">Success</span>';
				}else if($field['hd_retur_purchase_status'] == 'Pending'){
					$hd_retur_purchase_status = '<span class="badge badge-primary">Pending</span>';
				}else{
					$hd_retur_purchase_status = '<span class="badge badge-danger multi-badge">Cancel</span>';
				}

				if($field['hd_retur_purchase_payment_type'] == 'PN'){
					$payment_type = 'POTONG NOTA';
				}else if($field['hd_retur_purchase_payment_type'] == 'Cash'){
					$payment_type = 'CASH';
				}else{
					$payment_type = 'GARANSI';
				}

				if($check_auth[0]->view == 'Y'){
					$url = base_url();
					$detail = '<a href="'.base_url().'Purchase/detailreturpurchase?id='.$field['hd_retur_purchase_id'].'" data-fancybox="" data-type="iframe"><button type="button" class="btn btn-icon btn-primary btn-sm mb-2-btn" data-id="'.$field['hd_retur_purchase_id'].'"><i class="fas fa-eye sizing-fa"></i></button></a> ';
				}else{
					$detail = '<a href="'.base_url().'Purchase/detailreturpurchase?id='.$field['hd_retur_purchase_id'].'" data-fancybox="" data-type="iframe"><button type="button" class="btn btn-icon btn-primary btn-sm mb-2-btn" disabled="disabled"><i class="fas fa-eye sizing-fa"></i></button></a> ';
				}


				if($check_auth[0]->delete == 'Y'){
					if($field['hd_retur_purchase_status'] == 'Pending'){
						$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn" onclick="deletes('.$field['hd_retur_purchase_id'].')"><i class="fas fa-trash-alt sizing-fa"></i></button> ';
					}else{
						$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn" onclick="deletes('.$field['hd_retur_purchase_id'].')" disabled><i class="fas fa-trash-alt sizing-fa"></i></button> ';
					}
				}else{
					$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn"  disabled="disabled"><i class="fas fa-trash-alt sizing-fa"></i></button> ';
				}

				if($check_auth[0]->edit == 'Y'){
					if($field['hd_retur_purchase_status'] == 'Pending'){
						$payment = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn edit" data-id="'.$field['hd_retur_purchase_id'].'" data-inv="'.$field['hd_retur_purchase_inv'].'" data-total="'.$field['hd_retur_purchase_total'].'" data-bs-toggle="modal" data-bs-target="#exampleModaledit"><i class="fas fa-money-bill-wave sizing-fa"></i></button>';
					}else{
						$payment = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn edit" data-id="'.$field['hd_retur_purchase_id'].'" data-inv="'.$field['hd_retur_purchase_inv'].'" data-total="'.$field['hd_retur_purchase_total'].'" data-bs-toggle="modal" data-bs-target="#exampleModaledit" disabled="disabled"><i class="fas fa-money-bill-wave sizing-fa"></i></button>';
					}
				}else{
					$payment = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn edit" data-id="'.$field['hd_retur_purchase_id'].'" data-inv="'.$field['hd_retur_purchase_inv'].'" data-total="'.$field['hd_retur_purchase_total'].'" data-bs-toggle="modal" data-bs-target="#exampleModaledit" disabled="disabled"><i class="fas fa-money-bill-wave sizing-fa"></i></button>';
				}

				$date = date_create($field['hd_retur_purchase_date']); 

				$no++;
				$row = array();
				$row[] 	= $field['hd_retur_purchase_inv'];
				$row[] 	= date_format($date,"d-M-Y");
				$row[] 	= $field['product_name'];
				$row[] 	= $field['dt_retur_purchase_qty'];
				$row[] 	= $field['supplier_name'];
				$row[] 	= 'Rp. '.number_format($field['hd_retur_purchase_total']);
				$row[]  = $hd_retur_purchase_status;
				$row[]  = $payment_type;
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

	public function search_purchase_inv()
	{
		$supplier_id = $this->input->get('id');
		if($supplier_id == null){
			$result = ['success' => False, 'message' => 'Silahkan Isi Supplier Terlebih Dahulu'];
		}else{
			$keyword = $this->input->get('term');
			$result = ['success' => FALSE, 'num_product' => 0, 'data' => [], 'message' => ''];
			if (!($keyword == '' || $keyword == NULL)) {
				$find = $this->global_model->search_purchase_inv($keyword, $supplier_id)->result_array();
				$find_result = [];
				foreach ($find as $row) {
					$diplay_text = $row['hd_purchase_invoice'];
					$find_result[] = [
						'id'                  => $row['hd_purchase_id'],
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
		$purchase_id = $this->input->get('id');
		$keyword = $this->input->get('term');
		$result = ['success' => FALSE, 'num_product' => 0, 'data' => [], 'message' => ''];
		if (!($keyword == '' || $keyword == NULL)) {
			$find = $this->purchase_model->search_product_retur($keyword, $purchase_id)->result_array(); 
			$find_result = [];
			foreach ($find as $row) {
				$diplay_text = $row['product_name'];
				$find_result[] = [
					'id'                  		=> $row['dt_product_id'],
					'value'               		=> $diplay_text,
					'warehouse'           		=> $row['hd_purchase_warehouse'],
					'purchase_price'      		=> $row['dt_purchase_price'],
					'purchase_qty'        		=> $row['dt_purchase_qty'],
					'purchase_weight'     		=> $row['dt_purchase_weight'],
					'purchase_ongkir'     		=> $row['dt_purchase_ongkir'],
					'purchase_total_weight'     => $row['dt_purchase_weight'],
					'purchase_total_ongkir'     => $row['dt_purchase_total_ongkir'],
				];
			}
			$result = ['success' => TRUE, 'num_product' => count($find_result), 'data' => $find_result, 'message' => ''];
		}
		echo json_encode($result);
	}

	public function add_temp_retur_purchase()
	{

		$modul = 'ReturPurchase';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){
			$purchase_id 				= $this->input->post('purchase_id');
			$purchase_inv 				= $this->input->post('purchase_inv');
			$product_id 				= $this->input->post('product_id');
			$product_name 				= $this->input->post('product_name');
			$purchase_warehouse 		= $this->input->post('purchase_warehouse');
			$temp_price_submit 			= $this->input->post('temp_price_submit');
			$temp_qty 					= $this->input->post('temp_qty');
			$temp_qty_buy 				= $this->input->post('temp_qty_buy');
			$temp_ongkir_submit 		= $this->input->post('temp_ongkir_submit');
			$temp_total_submit 			= $this->input->post('temp_total_submit');
			$temp_note 					= $this->input->post('temp_note');
			$supplier_id 				= $this->input->post('supplier_id');
			$user_id 					= $_SESSION['user_id'];

			$check_total_item_retur = $this->purchase_model->check_total_item_retur($purchase_id, $product_id);

			$total_qty_retur = $check_total_item_retur[0]->total_qty_retur;

			$total_qty_retur_count = $total_qty_retur + $temp_qty;

			if($total_qty_retur_count > $temp_qty_buy){
				$msg = "Qty Retur Tidak Bisa Lebih Besar Dari Qty Beli";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			$check_temp_retur_purchase_input = $this->purchase_model->check_temp_retur_purchase_input($purchase_id, $product_id, $user_id);
			$data_insert = array(
				'temp_retur_purchase_b_id'				=> $purchase_id,
				'temp_retur_purchase_b_inv'				=> $purchase_inv,
				'temp_retur_purchase_warehouse_id'		=> $purchase_warehouse,
				'temp_retur_purchase_product_id'		=> $product_id,
				'temp_retur_purchase_product_name'		=> $product_name,
				'temp_retur_purchase_price'				=> $temp_price_submit,
				'temp_retur_purchase_qty'				=> $temp_qty,
				'temp_retur_purchase_qty_buy'			=> $temp_qty_buy,
				'temp_retur_purchase_ongkir'			=> $temp_ongkir_submit,
				'temp_retur_purchase_total'				=> $temp_total_submit,
				'temp_retur_purchase_note'				=> $temp_note,
				'temp_retur_purchase_supplier'			=> $supplier_id,
				'temp_user_id'							=> $user_id,
			);	
			$msg = 'Success Tambah';
			if($check_temp_retur_purchase_input != null){
				$this->purchase_model->edit_temp_retur_purchase($purchase_id, $product_id, $user_id, $data_insert);
			}else{
				$this->purchase_model->add_temp_retur_purchase($data_insert);
			}
			echo json_encode(['code'=>200, 'result'=>$msg]);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function temp_retur_purchase_list()
	{
		$modul = 'ReturPurchase';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){
			$search 			= $this->input->post('search');
			$length 			= $this->input->post('length');
			$start 			  	= $this->input->post('start');
			$user 			  	= $_SESSION['user_id'];

			if($search != null){
				$search = $search['value'];
			}
			$list = $this->purchase_model->temp_retur_purchase_list($search, $length, $start, $user)->result_array();
			$count_list = $this->purchase_model->temp_retur_purchase_list_count($search, $user)->result_array();
			$total_row = $count_list[0]['total_row'];
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $field) {

				$edit = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" onclick="edit_temp('.$field['temp_retur_purchase_product_id'].', '.$field['temp_retur_purchase_b_id'].')"><i class="fas fa-edit sizing-fa"></i></button> ';
				$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn" onclick="deletes('.$field['temp_retur_purchase_product_id'].', '.$field['temp_retur_purchase_b_id'].')"><i class="fas fa-trash-alt sizing-fa"></i></button> ';

				$no++;
				$row = array();
				$row[] 	= $field['product_code'];
				$row[] 	= $field['product_name'];
				$row[] 	= $field['unit_name'];
				$row[] 	= 'Rp. '.number_format($field['temp_retur_purchase_price']);
				$row[] 	= $field['temp_retur_purchase_qty'];
				$row[] 	= 'Rp. '.number_format($field['temp_retur_purchase_ongkir']);
				$row[] 	= 'Rp. '.number_format($field['temp_retur_purchase_total']);
				$row[] 	= $field['temp_retur_purchase_supplier'];
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

	public function check_temp_retur_purchase()
	{
		$user_id 		= $_SESSION['user_id'];
		$check_temp_retur_purchase  = $this->purchase_model->check_temp_retur_purchase($user_id)->result_array();
		echo json_encode(['code'=>200, 'data'=>$check_temp_retur_purchase]);
		die();
	}

	public function get_edit_temp_retur_purchase()
	{
		$temp_product_id  = $this->input->post('id');
		$temp_purchase_id  = $this->input->post('purchase_id');
		$temp_user_id  	  = $_SESSION['user_id'];
		$check_edit_temp_retur_purchase = $this->purchase_model->check_edit_temp_retur_purchase($temp_product_id, $temp_purchase_id, $temp_user_id)->result_array();
		echo json_encode(['code'=>200, 'result'=>$check_edit_temp_retur_purchase]);
		die();
	}

	public function delete_temp_retur_purchase()
	{
		$product_id   = $this->input->post('id');
		$purchase_id  = $this->input->post('purchase_id');
		$user_id 	 = $_SESSION['user_id'];
		$this->purchase_model->delete_temp_retur_purchase($product_id, $purchase_id);
		$msg = 'Success Delete';
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();
	}


	public function save_retur_purchase()
	{

		$modul = 'ReturPurchase';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){

			$retur_purchase_supplier 	= $this->input->post('retur_purchase_supplier');
			$retur_purchase_date 		= $this->input->post('retur_purchase_date');
			$footer_total_invoice_val	= $this->input->post('footer_total_invoice_val');
			$purchase_retur_remark 		= $this->input->post('purchase_retur_remark');
			$user_id 					= $_SESSION['user_id'];

			if($retur_purchase_supplier == null){
				$msg = 'Silahkan Masukan Supplier';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($footer_total_invoice_val <= 0){
				$msg = 'Silahkan Masukan Data Retur';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			$supplier_id = $retur_purchase_supplier;
			$get_supplier_code = $this->masterdata_model->get_supplier_code($supplier_id);
			$supplier_code = $get_supplier_code[0]->supplier_code;
			$supplier_name = $get_supplier_code[0]->supplier_name;
			

			$maxCode  = $this->purchase_model->last_retur_purchase();
			$inv_code = 'RP/'.$supplier_code.'/'.date("d/m/Y").'/';
			if ($maxCode == NULL) {
				$last_code = $inv_code.'000001';
			} else {
				$maxCode   = $maxCode[0]->hd_retur_purchase_inv;
				$last_code = substr($maxCode, -6);
				$last_code = $inv_code.substr('000000' . strval(floatval($last_code) + 1), -6);
			}

			$data_insert = array(
				'hd_retur_purchase_inv'			=> $last_code,
				'hd_retur_purchase_supplier_id'	=> $retur_purchase_supplier,
				'hd_retur_purchase_date'		=> $retur_purchase_date,
				'hd_retur_purchase_total'		=> $footer_total_invoice_val,
				'hd_retur_purchase_note'		=> $purchase_retur_remark,
				'created_by'					=> $user_id
			);	
			$save_retur_purchase = $this->purchase_model->save_retur_purchase($data_insert);

			$get_temp_retur_purchase = $this->purchase_model->get_temp_retur_purchase($user_id)->result_array();
			foreach($get_temp_retur_purchase  as $row){
				$data_insert_detail = array(
					'hd_retur_purchase_id'				=> $save_retur_purchase,
					'dt_retur_purchase_b_id'			=> $row['temp_retur_purchase_b_id'],
					'dt_retur_warehouse_id'				=> $row['temp_retur_purchase_warehouse_id'],
					'dt_retur_purchase_product_id'		=> $row['temp_retur_purchase_product_id'],
					'dt_retur_purchase_price'			=> $row['temp_retur_purchase_price'],
					'dt_retur_purchase_qty'				=> $row['temp_retur_purchase_qty'],
					'dt_retur_purchase_ongkir'			=> $row['temp_retur_purchase_ongkir'],
					'dt_retur_purchase_total'			=> $row['temp_retur_purchase_total'],
					'dt_retur_purchase_note'			=> $row['temp_retur_purchase_note'],
				);

				$save_detail_retur_purchase = $this->purchase_model->save_detail_retur_purchase($data_insert_detail);

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
						'stock_movement_date'			=> $sse_date,
						'stock_movement_creted_by'		=> $user_id,	
					);	
					$this->global_model->insert_movement_stock($movement_stock);
				}
				*/
			}

			$data_insert_act = array(
				'activity_table_desc'	       => 'Tambah Retur Pembelian Ref: '.$last_code,
				'activity_table_ref'		   => $last_code,
				'activity_table_user'	       => $user_id,
			);

			$this->global_model->save($data_insert_act);

			$this->purchase_model->clear_temp_retur_purchase($user_id);

			$msg = 'Success Tambah';
			echo json_encode(['code'=>200, 'result'=>$msg]);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function edit_retur_purchase()
	{
		$modul = 'ReturPurchase';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->edit == 'Y'){
			$user_id 					= $_SESSION['user_id'];
			$retur_purchase_id 			= $this->input->post('retur_purchase_id');
			$payment_type 			    = $this->input->post('payment_type');
			$retur_purchase_invoice     = $this->input->post('retur_purchase_invoice');
			
			$get_detail_retur_purchase_data = $this->purchase_model->get_detail_retur_purchase_data($retur_purchase_id);
			foreach ($get_detail_retur_purchase_data as $row)
			{
				$warehouse_id 	= $row->dt_retur_warehouse_id;
				if($warehouse_id != 1){
					$product_id 	= $row->dt_retur_purchase_product_id;
					$qty 			= $row->dt_retur_purchase_qty;
					$get_last_stock = $this->purchase_model->get_last_stock($product_id, $warehouse_id);
					$last_stock 	= $get_last_stock[0]->stock;
					$new_stock 		= $last_stock - $qty;
					$this->global_model->update_stock($product_id, $warehouse_id, $new_stock);

					$movement_stock = array(
						'stock_movement_product_id'		=> $product_id,
						'stock_movement_qty'			=> $qty,
						'stock_movement_before_stock'	=> $last_stock,
						'stock_movement_new_stock'		=> $new_stock,
						'stock_movement_desc'			=> 'Confirm Retur Pembelian',
						'stock_movement_inv'			=> $retur_purchase_invoice,
						'stock_movement_calculate'		=> 'Minus',
						'stock_movement_date'			=> date("Y/m/d"),
						'stock_movement_creted_by'		=> $user_id,	
					);	
					$this->global_model->insert_movement_stock($movement_stock);
				}
			}

			$update_retur_purchase = $this->purchase_model->update_retur_purchase($retur_purchase_id, $payment_type);

			$msg = "Success Edit";
			echo json_encode(['code'=>200, 'result'=>$msg]);die();
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function detailreturpurchase()
	{
		$modul = 'ReturPurchase';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$retur_purchase_id = $this->input->get('id');
			$header_retur_purchase['header_retur_purchase'] = $this->purchase_model->header_retur_purchase($retur_purchase_id);
			$detail_retur_purchase['detail_retur_purchase'] = $this->purchase_model->detail_retur_purchase($retur_purchase_id); 
			$data['data'] = array_merge($header_retur_purchase, $detail_retur_purchase);
			$this->load->view('Pages/Purchase/detailreturpurchase', $data);
			//echo json_encode($output);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function delete_retur_purchase()
	{
		$modul = 'ReturPurchase';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->delete == 'Y'){
			$retur_purchase_id = $this->input->post('id');
			$detail_retur_purchase = $this->purchase_model->detail_retur_purchase_delete($retur_purchase_id);
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
			$last_code 	    = $detail_retur_purchase[0]->hd_retur_purchase_inv;
			$data_insert_act = array(
				'activity_table_desc'	       => 'Batal Retur Pembelian Ref: '.$last_code,
				'activity_table_ref'		   => $last_code,
				'activity_table_user'	       => $user_id,
			);

			$this->global_model->save($data_insert_act);

			$this->purchase_model->delete_retur_purchase($retur_purchase_id);

			$msg = "Berhasil Hapus";
			echo json_encode(['code'=>200, 'result'=>$msg]);die();
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}
	// end retur purchase



	// revisi purchase

	public function purchaserevisi(){
		$modul = 'RevisiPurchase';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$warehouse_list['warehouse_list'] = $this->masterdata_model->warehouse_list();
			$salesman_list['salesman_list'] = $this->masterdata_model->salesman_list();
			$supplier_list['supplier_list'] = $this->masterdata_model->supplier_list();
			$data['data'] = array_merge($warehouse_list, $salesman_list, $supplier_list);
			$this->load->view('Pages/Purchase/revisipurchase', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function addpurchaserevisi()
	{
		$modul = 'RevisiPurchase';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){
			$supplier_list['supplier_list'] = $this->masterdata_model->supplier_list();
			$ekspedisi_list['ekspedisi_list'] = $this->masterdata_model->ekspedisi_list();
			$payment_list['payment_list'] = $this->masterdata_model->payment_list();
			$warehouse_list['warehouse_list'] = $this->masterdata_model->warehouse_list();
			$data['data'] = array_merge($supplier_list, $ekspedisi_list, $payment_list, $warehouse_list);
			$this->load->view('Pages/Purchase/purchaseaddrevisi', $data);
			//echo json_encode($output);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function search_purchase()
	{
		$supplier_id = $this->input->get('id');
		$keyword = $this->input->get('term');
		$result = ['success' => FALSE, 'num_product' => 0, 'data' => [], 'message' => ''];
		if (!($keyword == '' || $keyword == NULL)) {
			$find = $this->global_model->search_purchase($keyword, $supplier_id)->result_array();
			$find_result = [];
			foreach ($find as $row) {
				$diplay_text = $row['hd_purchase_invoice'];
				$find_result[] = [
					'id'                  => $row['hd_purchase_id'],
					'value'               => $diplay_text
				];
			}
			$result = ['success' => TRUE, 'num_product' => count($find_result), 'data' => $find_result, 'message' => ''];
		}
		echo json_encode($result);
	}


	public function copy_purchase_to_temp_purchase()
	{
		$modul = 'RevisiPurchase';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){
			$purchase_id 			= $this->input->post('purchase_id');
			$user_id 				= $_SESSION['user_id'];
			$get_hd_purcahse 		= $this->purchase_model->header_purchase($purchase_id);
			$get_detail_purcahse 	= $this->purchase_model->detail_purchase($purchase_id);
			$this->purchase_model->clear_temp_purchase($user_id);
			foreach($get_detail_purcahse as $row)
			{
				$data_copy_temp = array(
					'temp_product_id'			 => $row->dt_product_id,
					'temp_purchase_price'		 => $row->dt_purchase_price,
					'temp_purchase_qty'			 => $row->dt_purchase_qty,
					'temp_purchase_weight'		 => $row->dt_purchase_weight,
					'temp_purchase_ongkir'		 => $row->dt_purchase_ongkir,
					'temp_purchase_total_weight' => $row->dt_purchase_total_weight,
					'temp_purchase_total_ongkir' => $row->dt_purchase_total_ongkir,
					'temp_purchase_total'		 => $row->dt_purchase_total,
					'temp_user_id'				 => $user_id
				);	

				$copy_temp_purchase = $this->purchase_model->copy_temp_purchase($data_copy_temp);
			}
			$msg = "Success Copy";
			echo json_encode(['code'=>200, 'data'=>$get_hd_purcahse]);die();
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function check_temp_purchase_revisi()
	{
		$user_id 			= $_SESSION['user_id'];
		$check_temp_po  	= $this->purchase_model->check_temp_purchase_revisi($user_id)->result_array();
		echo json_encode(['code'=>200, 'data'=>$check_temp_po]);
		die();
	}

	// end revisi purchase
}

?>