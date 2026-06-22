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

    public function index(){
		echo "Purchase";die();
	}

    // start po

    public function po()
	{
		$modul = 'PO';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->view == 'Y'){
			$supplier_list['supplier_list'] = $this->masterdata_model->supplier_list();
			$check_auth['check_auth'] = $check_auth;
			$data['data'] = array_merge($supplier_list, $check_auth);
			$this->load->view('Pages/Purchase/purchaseorder', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

    
	public function po_list()
	{
		
		$modul = 'PO';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->view == 'Y'){
			$search 			= $this->input->post('search');
			$length 			= $this->input->post('length');
			$start 			  	= $this->input->post('start');
			$start_date_val 	 = $this->input->post('start_date');
			$end_date_val 		 = $this->input->post('end_date');
			$supplier_filter_val = $this->input->post('supplier_filter');

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

				if($field['hd_po_status'] == 'Pending'){
					$hd_po_status = '<span class="badge badge-primary">Pending</span>';
				}else if($field['hd_po_status'] == 'Success'){
					$hd_po_status = '<span class="badge badge-success">Selesai</span>';
				}else{
					$hd_po_status = '<span class="badge badge-danger">Batal</span>';
				}


				if($check_auth['check_access'][0]->view == 'Y'){
					$url = base_url();
					$detail = '<a href="'.base_url().'Purchase/detailpo?id='.$field['hd_po_id'].'" data-fancybox="" data-type="iframe"><button type="button" class="btn btn-icon btn-primary btn-sm mb-2-btn" data-id="'.$field['hd_po_id'].'"><i class="fas fa-eye sizing-fa"></i></button></a> ';
				}else{
					$detail = '<a href="'.base_url().'Purchase/detailpo?id='.$field['hd_po_id'].'" data-fancybox="" data-type="iframe"><button type="button" class="btn btn-icon btn-primary btn-sm mb-2-btn" disabled="disabled"><i class="fas fa-eye sizing-fa"></i></button></a> ';
				}

				if($check_auth['check_access'][0]->edit == 'Y'){
					if($field['hd_po_status'] == 'Pending'){
						$edit = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" onclick="edit('.$field['hd_po_id'].')"><i class="fas fa-edit sizing-fa"></i></button> ';
					}else{
						$edit = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" disabled="disabled" onclick="edit('.$field['hd_po_id'].')"><i class="fas fa-edit sizing-fa"></i></button> ';
					}
				}else{
					$edit = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" disabled="disabled" onclick="edit('.$field['hd_po_id'].')"><i class="fas fa-edit sizing-fa"></i></button> <button type="button" class="btn btn-icon btn-info btn-sm mb-2-btn" disabled="disabled"> ';
				}

				if($check_auth['check_access'][0]->delete == 'Y'){
					if($field['hd_po_status'] == 'Pending'){
						$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn" onclick="deletes('.$field['hd_po_id'].')"><i class="fas fa-trash-alt sizing-fa"></i></button> ';
					}else{
						$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn"  disabled="disabled"><i class="fas fa-trash-alt sizing-fa"></i></button> ';
					}
				}else{
					$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn"  disabled="disabled"><i class="fas fa-trash-alt sizing-fa"></i></button> ';
				}
				
				if($field['hd_po_status'] == 'Pending'){
					$print = '<a href="'.base_url().'Purchase/printpo?id='.$field['hd_po_id'].'" target="_blank"><button type="button" class="btn btn-icon btn-info btn-sm mb-2-btn"><i class="fas fa-print sizing-fa"></i></button></a>';
				}else{
					$print = '<button type="button" class="btn btn-icon btn-info btn-sm mb-2-btn" disabled="disabled"><i class="fas fa-print sizing-fa"></i></button>';
				}


				$date = date_create($field['hd_po_date']); 

				$no++;
				$row = array();
				$row[] 	= $field['hd_po_invoice'];
				$row[] 	= date_format($date,"d-M-Y");
				$row[] 	= $tax;
				$row[] 	= $field['supplier_name'];
				$row[] 	= 'Rp. '.number_format($field['hd_po_sub_total']);
				$row[] 	= 'Rp. '.number_format($field['hd_po_total_discount']);
				$row[] 	= 'Rp. '.number_format($field['hd_po_ppn']);
				$row[] 	= 'Rp. '.number_format($field['hd_po_grand_total']);
				$row[] 	= $hd_po_status;
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

	public function addpo()
	{
		$modul = 'PO';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->add == 'Y'){
			$supplier_list['supplier_list'] = $this->masterdata_model->supplier_list();
			$payment_list['payment_list'] = $this->masterdata_model->payment_list();
			$check_auth['check_auth'] = $check_auth;
			$data['data'] = array_merge($supplier_list, $payment_list, $check_auth);
			$this->load->view('Pages/Purchase/purchaseorderadd', $data);
			//echo json_encode($output);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function temp_po_list()
	{
		$modul = 'PO';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->add == 'Y'){
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
				$row[] 	= $field['product_code'];
				$row[] 	= $field['product_name'];
				$row[] 	= $field['unit_name'];
				$row[] 	= 'Rp. '.number_format($field['temp_po_price']);
				$row[] 	= $field['temp_po_qty'];
				$row[] 	= 'Rp. '.number_format($field['temp_po_total']);
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

	public function check_temp_po()
	{
		$user_id 		= $_SESSION['user_id'];
		$check_temp_po = $this->purchase_model->check_temp_po($user_id)->result_array();;
		if($check_temp_po[0]['sub_total'] != null){
			$product_tax 	 = $check_temp_po[0]['is_ppn'];
			$sub_total  	 = $check_temp_po[0]['sub_total'];
			$supplier_id     = $check_temp_po[0]['temp_supplier_id'];
		}else{
			$supplier     = 0;
			$product_tax  = 0;
			$sub_total    = 0;
			$ongkir       = 0;
			$supplier_id  = 0;
		}
		echo json_encode(['code'=>200, 'product_tax'=>$product_tax, 'sub_total'=>$sub_total, 'supplier_id' => $supplier_id]);
		die();
	}

	public function add_temp_po()
	{

		$modul = 'PO';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->add == 'Y'){
			$po_supplier 			    = $this->input->post('po_supplier');
			$product_id 				= $this->input->post('product_id');
			$temp_price_val 			= $this->input->post('temp_price_val');
			$temp_qty 					= $this->input->post('temp_qty');
			$temp_total_val 			= $this->input->post('temp_total_val');
			$user_id 					= $_SESSION['user_id'];

			$check_temp_po_input = $this->purchase_model->check_temp_po_input($product_id, $user_id);
			$data_insert = array(
				'temp_supplier_id'		=> $po_supplier,
				'temp_product_id'		=> $product_id,
				'temp_po_price'			=> $temp_price_val,
				'temp_po_qty'			=> $temp_qty,
				'temp_po_total'			=> $temp_total_val,
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

	public function get_edit_temp_po()
	{
		$temp_po_id  = $this->input->post('id');
		$check_edit_temp_po = $this->purchase_model->check_edit_temp_po($temp_po_id)->result_array();
		echo json_encode(['code'=>200, 'result'=>$check_edit_temp_po]);
		die();
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

	public function save_po()
	{

		$modul = 'PO';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->add == 'Y'){
			$po_supplier 								= $this->input->post('po_supplier');
			$po_date 									= $this->input->post('po_date');
			$po_tax 									= $this->input->post('po_tax');
			$purchase_order_due_date 					= $this->input->post('purchase_order_due_date');
			$po_payment_method 							= $this->input->post('po_payment_method');
			$po_warehouse 								= 1;
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
			$footer_total_invoice_val 					= $this->input->post('footer_total_invoice_val');
			$purchase_order_remark 						= $this->input->post('purchase_order_remark');
			$user_id 									= $_SESSION['user_id'];

			if($po_supplier == null){
				$msg = 'Silahkan Masukan Supplier';
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

			if($purchase_order_due_date  == null){
				$purchase_order_due_date = date('Y-m-d');
			}

			$supplier_id = $po_supplier;
			$get_supplier_code = $this->masterdata_model->get_supplier_code($supplier_id);
			$supplier_code = $get_supplier_code[0]->supplier_code;
			$supplier_name = $get_supplier_code[0]->supplier_name;
			

			$maxCode  = $this->purchase_model->last_po();
			$inv_code = 'PO/'.$supplier_code.'/'.date("d/m/Y").'/';
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
				'hd_po_due_date'			=> $purchase_order_due_date,
				'hd_po_payment'				=> $po_payment_method,
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
				'hd_po_grand_total'			=> $footer_total_invoice_val,
				'hd_po_note'			    => $purchase_order_remark,
				'created_by'				=> $user_id
			);	
			
			$save_po = $this->purchase_model->save_po($data_insert);

			$get_temp_po = $this->purchase_model->get_temp_po($user_id)->result_array();
			foreach($get_temp_po  as $row){
				$data_insert_detail = array(
					'hd_po_id'				=> $save_po,
					'dt_product_id'			=> $row['temp_product_id'],
					'dt_po_price'			=> $row['temp_po_price'],
					'dt_po_qty'				=> $row['temp_po_qty'],
					'dt_po_total'			=> $row['temp_po_total']
				);	

				$dt_product_id = $row['temp_product_id'];
				$save_detail_po = $this->purchase_model->save_detail_po($data_insert_detail);
			}

			$data_insert_act = array(
				'activity_table_desc'	       => 'Tambah PO Ref: '.$last_code,
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

	
	public function detailpo()
	{
		$modul = 'PO';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->view == 'Y'){
			$po_id = $this->input->get('id');
			$header_po['header_po'] = $this->purchase_model->header_po($po_id)->result_array();
			$detail_po['detail_po'] = $this->purchase_model->detail_po($po_id)->result_array(); 
			$data['data'] = array_merge($header_po, $detail_po);
			$this->load->view('Pages/Purchase/detailpo', $data);
			//echo json_encode($output);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function editpo()
	{
		$modul = 'PO';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->edit == 'Y'){
			$po_id 					  = $this->input->get('id');
			$header_po 			      = $this->purchase_model->header_po($po_id)->result_array();
			$detail_po 				  = $this->purchase_model->detail_po($po_id)->result_array();
			$user_id   				  = $_SESSION['user_id'];
			$check_auth['check_auth'] = $check_auth;
			$this->purchase_model->clear_temp_po($user_id);
			foreach($detail_po as $row){
				$po_supplier     			= $header_po[0]['hd_po_supplier'];
				$product_id      			= $row['dt_product_id'];
				$temp_price_val 			= $row['dt_po_price'];
				$temp_qty  					= $row['dt_po_qty'];
				$temp_total_val				= $row['dt_po_total'];

				$data_insert = array(
					'temp_supplier_id'		=> $po_supplier,
					'temp_product_id'		=> $product_id,
					'temp_po_price'			=> $temp_price_val,
					'temp_po_qty'			=> $temp_qty,
					'temp_po_total'			=> $temp_total_val,
					'temp_user_id'			=> $user_id,
				);

				$this->purchase_model->insert_temp_po($data_insert);
			}
			$header_po_view['header_po_view'] = $this->purchase_model->header_po($po_id);
			$detail_po_view['detail_po_view'] = $this->purchase_model->detail_po($po_id);
			$supplier_list['supplier_list'] = $this->masterdata_model->supplier_list();
			$payment_list['payment_list'] = $this->masterdata_model->payment_list();
			$check_auth['check_auth'] = $check_auth;
			$data['data'] = array_merge($supplier_list, $payment_list, $header_po_view, $detail_po_view, $check_auth);
			$this->load->view('Pages/Purchase/purchaseorderedit', $data);
			//echo json_encode($output);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function get_header_edit()
	{
		$po_id = $this->input->post('purchase_order_id');
		$get_header_edit = $this->purchase_model->header_po($po_id)->result_array();
		echo json_encode(['code'=>200, 'data'=>$get_header_edit]);
		die();
	}
	
	public function save_edit()
	{

		$modul = 'PO';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->edit == 'Y'){
			$purchase_order_id  						= $this->input->post('purchase_order_id');
			$purchase_order_invoice						= $this->input->post('purchase_order_invoice');
			$po_supplier 								= $this->input->post('po_supplier');
			$po_date 									= $this->input->post('po_date');
			$po_supplier								= $this->input->post('po_supplier');
			$po_tax 									= $this->input->post('po_tax');
			$purchase_order_due_date 					= $this->input->post('purchase_order_due_date');
			$po_payment_method 							= $this->input->post('po_payment_method');
			$po_warehouse 								= 1;
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
			$footer_total_invoice_val 					= $this->input->post('footer_total_invoice_val');
			$purchase_order_remark 						= $this->input->post('purchase_order_remark');
			$user_id 									= $_SESSION['user_id'];

			if($po_supplier == null){
				$msg = 'Silahkan Masukan Supplier';
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

			$data_insert = array(
				'hd_po_date'				=> $po_date,
				'hd_po_warehouse'			=> $po_warehouse,
				'hd_po_supplier'			=> $po_supplier,
				'hd_po_tax'					=> $po_tax,
				'hd_po_due_date'			=> $purchase_order_due_date,
				'hd_po_payment'				=> $po_payment_method,
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
				'hd_po_grand_total'			=> $footer_total_invoice_val,
				'hd_po_note'			    => $purchase_order_remark,
				'created_by'				=> $user_id
			);	
			
			$save_po = $this->purchase_model->edit_po($data_insert, $purchase_order_id);

			$clear_detail_po = $this->purchase_model->clear_detail_po($purchase_order_id);
			$get_temp_po = $this->purchase_model->get_temp_po($user_id)->result_array();
			foreach($get_temp_po  as $row){
				$data_insert_detail = array(
					'hd_po_id'				=> $purchase_order_id,
					'dt_product_id'			=> $row['temp_product_id'],
					'dt_po_price'			=> $row['temp_po_price'],
					'dt_po_qty'				=> $row['temp_po_qty'],
					'dt_po_total'			=> $row['temp_po_total']
				);	
	
				$save_detail_po = $this->purchase_model->save_detail_po($data_insert_detail);
				
			}

			$data_insert_act = array(
				'activity_table_desc'	       => 'Edit PO Ref: '.$purchase_order_invoice,
				'activity_table_ref'		   => $purchase_order_invoice,
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

	public function delete_po()
	{
		$modul = 'PO';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->delete == 'Y'){
			$po_id  		= $this->input->post('id');
			$user_id 		= $_SESSION['user_id'];
			$get_po_code 	= $this->purchase_model->get_po_code($po_id);
			$hd_po_invoice 	= $get_po_code[0]->hd_po_invoice;

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

	public function printpo()
	{
		$modul = 'PO';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->edit == 'Y'){
			$po_id = $this->input->get('id');
			$header_po['header_po'] = $this->purchase_model->header_po($po_id)->result_array();
			$detail_po['detail_po'] = $this->purchase_model->detail_po($po_id)->result_array();
			$data['data'] = array_merge($header_po, $detail_po);
			$this->load->view('Pages/Purchase/printpo', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

    // end po


	// start purchase

	public function purchases()
	{
		$modul = 'Purchase';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->view == 'Y'){
			$supplier_list['supplier_list'] = $this->masterdata_model->supplier_list();
			$check_auth['check_auth'] = $check_auth;
			$data['data'] = array_merge($supplier_list, $check_auth);
			$this->load->view('Pages/Purchase/purchase', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	
	public function purchase_list(){
		$modul = 'Purchase';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->view == 'Y'){
			$search 			= $this->input->post('search');
			$length 			= $this->input->post('length');
			$start 			  	= $this->input->post('start');
			$start_date_val 	 = $this->input->post('start_date');
			$end_date_val 		 = $this->input->post('end_date');
			$supplier_filter_val = $this->input->post('supplier_filter');

			if($search != null){
				$search = $search['value'];
			}
			$list = $this->purchase_model->purchase_list($search, $length, $start, $start_date_val, $end_date_val, $supplier_filter_val)->result_array();
			$count_list = $this->purchase_model->purchase_list_count($search, $start_date_val, $end_date_val, $supplier_filter_val)->result_array();
			$total_row = $count_list[0]['total_row'];
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $field) {
				if($field['hd_purchase_tax'] == 'Y'){
					$tax = '<span class="badge badge-success">BKP</span>';
				}else{
					$tax = '<span class="badge badge-danger">NON BKP</span>';
				}

				if($field['hd_purchase_status'] == 'Cancel'){
					$status = '<span class="badge badge-danger">Cancel</span>';	
				}else{
					$status = '<span class="badge badge-success">Selesai</span>';	
				}

				if($field['hd_purchase_remaining_debt'] > 0){
					$hd_purchase_remaining_debt = '<span class="badge badge-danger">Belum Lunas</span>';
				}else{
					$hd_purchase_remaining_debt = '<span class="badge badge-success">Lunas</span>';
				}

				if($check_auth['check_access'][0]->view == 'Y'){
					$url = base_url();
					$detail = '<a href="'.base_url().'Purchase/detailpurchase?id='.$field['hd_purchase_id'].'" data-fancybox="" data-type="iframe"><button type="button" class="btn btn-icon btn-primary btn-sm mb-2-btn" data-id="'.$field['hd_purchase_id'].'"><i class="fas fa-eye sizing-fa"></i></button></a> ';
				}else{
					$detail = '<a href="'.base_url().'Purchase/detailpurchase?id='.$field['hd_purchase_id'].'" data-fancybox="" data-type="iframe"><button type="button" class="btn btn-icon btn-primary btn-sm mb-2-btn" disabled="disabled"><i class="fas fa-eye sizing-fa"></i></button></a> ';
				}

				if($check_auth['check_access'][0]->edit == 'Y'){
					if($field['hd_purchase_status'] != 'Cancel'){
						$edit = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" data-bs-toggle="modal" data-bs-target="#exampleModaledit" data-id="'.$field['hd_purchase_id'].'" data-name="'.$field['hd_purchase_invoice'].'"><i class="fas fa-edit sizing-fa"></i></button> ';
					}else{
						$edit = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" disabled="disabled" data-bs-toggle="modal" data-bs-target="#exampleModaledit" data-id="'.$field['hd_purchase_id'].'" data-name="'.$field['hd_purchase_invoice'].'"><i class="fas fa-edit sizing-fa"></i></button> ';
					}
				}else{
					$edit = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" disabled="disabled"><i class="fas fa-edit sizing-fa"></i></button> <button type="button" class="btn btn-icon btn-info btn-sm mb-2-btn" disabled="disabled"> ';
				}

				if($check_auth['check_access'][0]->delete == 'Y'){
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
				$row[] 	= $tax;
				$row[] 	= number_format($field['hd_purchase_sub_total']);
				$row[] 	= number_format($field['hd_purchase_total_discount']);
				$row[] 	= number_format($field['hd_purchase_ppn']);
				$row[] 	= number_format($field['hd_purchase_grand_total']);
				$row[] 	= $hd_purchase_remaining_debt;
				$row[] 	= $status;
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
		if($check_auth['check_access'][0]->add == 'Y'){
			$supplier_list['supplier_list'] = $this->masterdata_model->supplier_list();
			$payment_list['payment_list'] = $this->masterdata_model->payment_list();
			$check_auth['check_auth'] = $check_auth;
			$data['data'] = array_merge($supplier_list, $payment_list, $check_auth);
			$this->load->view('Pages/Purchase/purchaseadd', $data);
			//echo json_encode($output);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function detailpurchase()
	{
		$modul = 'Purchase';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->view == 'Y'){
			$purchase_id = $this->input->get('id');
			$header_purchase['header_purchase'] = $this->purchase_model->header_purchase($purchase_id)->result_array();
			$detail_purchase['detail_purchase'] = $this->purchase_model->detail_purchase($purchase_id)->result_array(); 
			$data['data'] = array_merge($header_purchase, $detail_purchase);
			$this->load->view('Pages/Purchase/detailpurchase', $data);
			//echo json_encode($output);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
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

		public function temp_purchase_list()
	{
		$modul = 'Purchase';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->add == 'Y'){
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
				$row[] 	= $field['temp_purchase_qty'];
				$row[] 	= 'Rp. '.number_format($field['temp_purchase_total']);
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
	
	public function add_temp_purchase()
	{
		$modul = 'Purchase';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->add == 'Y'){
			$product_id 				= $this->input->post('product_id');
			$temp_price_val 			= $this->input->post('temp_price_val');
			$temp_qty 					= $this->input->post('temp_qty');
			$temp_total_val 			= $this->input->post('temp_total_val');
			$temp_purchase_supplier_id 	= $this->input->post('supplier_id');
			$user_id 					= $_SESSION['user_id'];

			$check_temp_purchase_input = $this->purchase_model->check_temp_purchase_input($product_id, $user_id);
			$data_insert = array(
				'temp_product_id'				=> $product_id,
				'temp_purchase_price'			=> $temp_price_val,
				'temp_purchase_qty'				=> $temp_qty,
				'temp_purchase_total'			=> $temp_total_val,
				'temp_purchase_supplier_id'		=> $temp_purchase_supplier_id,
				'temp_user_id'					=> $user_id,
			);	
			$msg = 'Success Tambah';
			if($check_temp_purchase_input != null){
				$this->purchase_model->edit_temp_purchase($product_id, $user_id, $data_insert);
			}else{
				$this->purchase_model->insert_temp_purchase($data_insert);
			}
			echo json_encode(['code'=>200, 'result'=>$msg]);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function check_temp_purchase()
	{
		$user_id 		= $_SESSION['user_id'];
		$check_temp_po  = $this->purchase_model->check_temp_purchase($user_id)->result_array();
		echo json_encode(['code'=>200, 'data'=>$check_temp_po]);
		die();
	}

	public function delete_temp_purchase()
	{
		$modul = 'Purchase';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->add == 'Y'){
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
	
	public function get_edit_temp_purchase()
	{
		$temp_product_id  = $this->input->post('id');
		$temp_user_id  	  = $_SESSION['user_id'];
		$check_edit_temp_purchase = $this->purchase_model->check_edit_temp_purchase($temp_product_id, $temp_user_id)->result_array();
		echo json_encode(['code'=>200, 'result'=>$check_edit_temp_purchase]);
		die();
	}

	public function save_purchase()
	{

		$modul = 'Purchase';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->add == 'Y'){

			$po_inv 									= $this->input->post('po_inv');
			$po_id 										= $this->input->post('po_id');
			$purchase_payment_method 					= $this->input->post('purchase_payment_method');
			$purchase_supplier 							= $this->input->post('purchase_supplier');
			$no_faktur_supplier 						= $this->input->post('no_faktur_supplier');
			$faktur_date 								= $this->input->post('faktur_date');
			$purchase_tax 								= $this->input->post('purchase_tax');
			$purchase_date 					        	= $this->input->post('purchase_date');
			$purchase_warehouse 						= 1;
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
			$footer_total_invoice_val 					= $this->input->post('footer_total_invoice_val');
			$footer_dp_val                              = $this->input->post('footer_dp_val');
			$footer_remaining_payment_val               = $this->input->post('footer_remaining_payment_val');
			$purchase_remark 							= $this->input->post('purchase_remark');
			$user_id 									= $_SESSION['user_id'];

			if($purchase_supplier == null){
				$msg = 'Silahkan Masukan Supplier';
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
			$inv_code = 'LBM/'.$supplier_code.'/'.date("d/m/Y").'/';
			if ($maxCode == NULL) {
				$last_code = $inv_code.'000001';
			} else {
				$maxCode   = $maxCode[0]->hd_purchase_invoice;
				$last_code = substr($maxCode, -6);
				$last_code = $inv_code.substr('000000' . strval(floatval($last_code) + 1), -6);
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
				'hd_purchase_due_date'			=> $purchase_due_date,
				'hd_purchase_payment'			=> $purchase_payment_method,
				'hd_purchase_sub_total'			=> $footer_sub_total_submit,
				'hd_purchase_disc_percentage1'	=> $edit_footer_discount_percentage1_submit,
				'hd_purchase_disc_percentage2'	=> $edit_footer_discount_percentage2_submit,
				'hd_purchase_disc_percentage3'	=> $edit_footer_discount_percentage3_submit,
				'hd_purchase_disc_1'			=> $edit_footer_discount1_submit,
				'hd_purchase_disc_2'			=> $edit_footer_discount2_submit,
				'hd_purchase_disc_3'			=> $edit_footer_discount3_submit,
				'hd_purchase_total_discount'	=> $footer_total_discount_submit,
				'hd_purchase_dpp'				=> $footer_dpp_val,
				'hd_purchase_ppn'			    => $footer_total_ppn_val,
				'hd_purchase_dp'				=> $footer_dp_val,
				'hd_purchase_grand_total'		=> $footer_total_invoice_val,
				'hd_purchase_remaining_debt'	=> $footer_remaining_payment_val,
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
					'dt_purchase_total'			=> $row['temp_purchase_total']
				);

				$save_detail_purchase = $this->purchase_model->save_detail_purchase($data_insert_detail);

				$product_id = $row['temp_product_id'];
				$get_product_stock = $this->global_model->get_last_stock($product_id, $purchase_warehouse);
				$last_stock = $get_product_stock[0]->stock;
				$new_stock = $last_stock + $row['temp_purchase_qty'];
				$this->global_model->update_stock_plus($product_id, $purchase_warehouse, $new_stock);

				$data_movement_stock = array(
					'stock_movement_product_id'		=> $product_id,
					'stock_movement_qty'			=> $row['temp_purchase_qty'],
					'stock_movement_before_stock'	=> $last_stock,
					'stock_movement_new_stock'		=> $new_stock,
					'stock_movement_desc'			=> 'Pembelian',
					'stock_movement_inv'			=> $last_code,
					'stock_movement_calculate'		=> 'Plus',
					'stock_movement_date'			=> date('Y-m-d'),
					'stock_movement_creted_by'		=> $user_id,
				);
				$this->global_model->save_stock_movement($data_movement_stock);
			}

			$this->purchase_model->update_purchase_po($po_id);

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


	// end purchase

    }


?>