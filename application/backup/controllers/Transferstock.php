<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");

class Transferstock extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->model('global_model');
		$this->load->model('masterdata_model');
		$this->load->model('transferstock_model');
		$this->load->helper(array('url', 'html'));
	}


	private function check_auth($modul){
		if(isset($_SESSION['user_name']) == null){
			redirect('Masterdata', 'refresh');
		}else{
			$user_role_id = $_SESSION['user_role_id'];
			$check_access = $this->global_model->check_access($user_role_id, $modul);
			return($check_access);
		}
	}

	public function index()
	{
		$modul = 'TransferStock';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$check_auth['check_auth'] = $check_auth;
			$this->load->view('Pages/Transferstock/transferstock', $check_auth);
		}else{
			print_r('Tidak Ada Akses');die();
		}
	}

	public function transfer_stock_list()
	{
		$modul = 'TransferStock';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){

			$search 			= $this->input->post('search');
			$length 			= $this->input->post('length');
			$start 			  	= $this->input->post('start');

			if($search != null){
				$search = $search['value'];
			}
			$list = $this->transferstock_model->transferstock_list($search, $length, $start)->result_array();
			$count_list = $this->transferstock_model->transferstock_list_count($search)->result_array();
			$total_row = $count_list[0]['total_row'];
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $field) {
				if($check_auth[0]->view == 'Y'){
					$url = base_url();
					$detail = '<a href="'.base_url().'Transferstock/detailtransfer?id='.$field['hd_transfer_stock_id'].'" data-fancybox="" data-type="iframe"><button type="button" class="btn btn-icon btn-primary btn-sm mb-2-btn" data-id="'.$field['hd_transfer_stock_id'].'"><i class="fas fa-eye sizing-fa"></i></button></a> ';
				}else{
					$detail = '<a href="'.base_url().'Transferstock/detailtransfer?id='.$field['hd_transfer_stock_id'].'" data-fancybox="" data-type="iframe"><button type="button" class="btn btn-icon btn-primary btn-sm mb-2-btn" disabled="disabled"><i class="fas fa-eye sizing-fa"></i></button></a> ';
				}

				if($check_auth[0]->edit == 'Y'){
					if($field['hd_transfer_stock_status'] != 'Cancel'){
						$edit = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" data-bs-toggle="modal" data-bs-target="#exampleModaledit" data-id="'.$field['hd_transfer_stock_id'].'" data-name="'.$field['hd_transfer_stock_code'].'"><i class="fas fa-edit sizing-fa"></i></button> ';
					}else{
						$edit = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" disabled="disabled" data-bs-toggle="modal" data-bs-target="#exampleModaledit" data-id="'.$field['hd_transfer_stock_id'].'" data-name="'.$field['hd_transfer_stock_code'].'"><i class="fas fa-edit sizing-fa"></i></button> ';
					}
				}else{
					$edit = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" disabled="disabled"><i class="fas fa-edit sizing-fa"></i></button> <button type="button" class="btn btn-icon btn-info btn-sm mb-2-btn" disabled="disabled"> ';
				}


				if($check_auth[0]->delete == 'Y'){
					if($field['hd_transfer_stock_status'] != 'Cancel'){
						$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn" onclick="deletes('.$field['hd_transfer_stock_id'].')"><i class="fas fa-trash-alt sizing-fa"></i></button> ';
					}else{
						$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn"  disabled="disabled"><i class="fas fa-trash-alt sizing-fa"></i></button> ';
					}
				}else{
					$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn"  disabled="disabled"><i class="fas fa-trash-alt sizing-fa"></i></button> ';
				}

				if($field['hd_transfer_stock_status'] == 'Success'){
					$status = '<span class="badge badge-success">Success</span>';
				}else{
					$status = '<span class="badge badge-danger multi-badge">Cancel</span>';
				}

				$dispatch = '<button type="button" class="btn btn-icon btn-info dispatch btn-sm mb-2-btn" onclick="dispatch('.$field['hd_transfer_stock_id'].')"><i class="fas fa-truck sizing-fa"></i></button> ';

				$date = date_create($field['hd_transfer_stock_date']); 

				$no++;
				$row = array();
				$row[] 	= $field['hd_transfer_stock_code'];
				$row[] 	= $field['hd_transfer_stock_initial'];
				$row[] 	= $field['product_name'];
				$row[] 	= date_format($date,"d-M-Y");
				$row[] 	= $field['unit_name'];
				$row[] 	= $field['dt_transfer_stock_qty'];
				$row[] 	= $field['from'];
				$row[] 	= $field['to'];
				$row[] 	= $field['dt_transfer_stock_from_qty'];
				$row[] 	= $field['dt_transfer_stock_to_qty'];
				$row[] 	= $detail.$delete.$dispatch;
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


	public function printdispatch()
	{
		$modul = 'TransferStock';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$id  	      = $this->input->get('print_type');
			$hd_transfer_id  = $this->input->get('transfer_id');
			$header_transfer['header_transfer'] = $this->transferstock_model->header_transfer_stock($hd_transfer_id);
			$detail_transfer['detail_transfer'] = $this->transferstock_model->detail_transfer_stock($hd_transfer_id)->result_array();
			$data['data'] = array_merge($header_transfer, $detail_transfer);
			$this->load->view('Pages/Transferstock/printdispatch', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}
	

	public function addtransferstock()
	{
		$modul = 'TransferStock';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$check_auth['check_auth'] = $check_auth;
			$warehouse_list['warehouse_list'] = $this->masterdata_model->warehouse_list();
			$data['data'] = array_merge($check_auth, $warehouse_list);
			$this->load->view('Pages/Transferstock/addtransferstock', $data);
		}else{
			print_r('Tidak Ada Akses');die();
		}
	}

	public function detailtransfer()
	{
		$modul = 'TransferStock';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$hd_transfer_id  = $this->input->get('id');
			$header_transfer['header_transfer'] = $this->transferstock_model->header_transfer_stock($hd_transfer_id);
			$detail_transfer['detail_transfer'] = $this->transferstock_model->detail_transfer_stock($hd_transfer_id)->result_array(); 
			$data['data'] = array_merge($header_transfer, $detail_transfer); 
			$this->load->view('Pages/Transferstock/detailtransfer', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function search_product()
	{
		$purchase_id = $this->input->get('id');
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

	public function check_temp_transfer_stock()
	{
		$user_id 				    = $_SESSION['user_id'];
		$check_temp_transfer_stock  = $this->transferstock_model->check_temp_transfer_stock($user_id)->result_array();
		echo json_encode(['code'=>200, 'data'=>$check_temp_transfer_stock]);
		die();
	}

	public function temp_transfer_stock_list()
	{
		$modul = 'TransferStock';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){
			$search 			= $this->input->post('search');
			$length 			= $this->input->post('length');
			$start 			  	= $this->input->post('start');
			$user 			  	= $_SESSION['user_id'];

			if($search != null){
				$search = $search['value'];
			}
			$list 		= $this->transferstock_model->temp_transfer_stock_list($search, $length, $start, $user)->result_array();
			$count_list = $this->transferstock_model->temp_transfer_stock_list_count($search, $user)->result_array();
			$total_row 	= $count_list[0]['total_row'];
			$data 		= array();
			$no 		= $_POST['start'];
			foreach ($list as $field) {

				$edit = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" onclick="edit_temp('.$field['temp_transfer_stock_product_id'].', '.$field['user_id'].')"><i class="fas fa-edit sizing-fa"></i></button> ';
				$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn" onclick="deletes('.$field['temp_transfer_stock_product_id'].', '.$field['user_id'].')"><i class="fas fa-trash-alt sizing-fa"></i></button> ';

				$no++;
				$row = array();
				$row[] 	= $field['product_code'];
				$row[] 	= $field['product_name'];
				$row[] 	= $field['unit_name'];
				$row[] 	= $field['temp_transfer_stock_qty'];
				$row[] 	= $field['from'];
				$row[] 	= $field['to'];
				$row[] = '<span class="text-danger">'.$field['temp_transfer_stock_from_qty'].'</span>';
				$row[] = '<span class="text-primary">'.$field['temp_transfer_stock_to_qty'].'</span>';
				$row[] 	= $field['temp_transfer_stock_note'];
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


	public function add_temp_transferstock()
	{
		$modul = 'TransferStock';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){
			$product_id 				= $this->input->post('product_id');
			$transfer_from 				= $this->input->post('transfer_from');
			$transfer_to 				= $this->input->post('transfer_to');
			$temp_qty 					= $this->input->post('qty');
			$temp_note 					= $this->input->post('temp_note');
			$user_id 					= $_SESSION['user_id'];

			if($transfer_from == $transfer_to){
				$msg = "Transfer Stock Tidak Bisa Ke Tujuan Yang Sama";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($temp_qty < 1){
				$msg = "Jumlah Qty Harus Lebih Besar Dari 1";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			$get_last_stock_from 	= $this->transferstock_model->get_last_stock($product_id, $transfer_from);
			if($get_last_stock_from == null){
				$msg = "Stock Tidak Ada di Gudang";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}else{
				$last_stock_from  = $get_last_stock_from[0]->stock;
				if($last_stock_from < $temp_qty){
					$msg = "Stock Gudang Tidak Cukup";
					echo json_encode(['code'=>0, 'result'=>$msg]);die();
				}
			}

			$get_last_stock_to = $this->transferstock_model->get_last_stock($product_id, $transfer_to);
			if($get_last_stock_to == null){
				$last_stock_to = 0;
			}else{
				$last_stock_to 		= $get_last_stock_to[0]->stock;
			}
			
			$check_temp_transfer_stock_input = $this->transferstock_model->check_temp_transfer_stock_input($product_id, $user_id, $transfer_to)->result_array();
			$data_insert = array(
				'temp_transfer_stock_product_id'	 => $product_id,
				'temp_transfer_stock_qty'			 => $temp_qty,
				'temp_transfer_stock_warehouse_from' => $transfer_from,
				'temp_transfer_stock_warehouse_to'	 => $transfer_to,
				'temp_transfer_stock_from_qty'	 	 => $last_stock_from,
				'temp_transfer_stock_to_qty'	 	 => $last_stock_to,
				'temp_transfer_stock_note'			 => $temp_note,
				'user_id'							 => $user_id,
			);	

			if($check_temp_transfer_stock_input == null){
				$this->transferstock_model->add_temp_transfer_stock($data_insert);
				$msg = 'Success Tambah';
			}else{
				$this->transferstock_model->edit_temp_transfer_stock($product_id, $user_id, $data_insert);
				$msg = 'Success Edit';
			}
			echo json_encode(['code'=>200, 'result'=>$msg]);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function get_edit_temp_transfer_stock()
	{
		$product_id  = $this->input->post('product_id');
		$user_id  	 = $this->input->post('user_id');
		$check_edit_temp_transfer_stock = $this->transferstock_model->check_edit_temp_transfer_stock($product_id, $user_id)->result_array();
		echo json_encode(['code'=>200, 'result'=>$check_edit_temp_transfer_stock]);
		die();
	}

	public function delete_temp_transfer_stock()
	{
		$product_id  = $this->input->post('product_id');
		$user_id 	 = $_SESSION['user_id'];
		$this->transferstock_model->delete_temp_transfer_stock($product_id, $user_id);
		$msg = 'Success Delete';
		echo json_encode(['code'=>200, 'result'=>$msg]);
		die();
	}


	public function save_transfer_stock()
	{

		$modul = 'TransferStock';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){
			$footer_total  			= $this->input->post('footer_total');
			$transfer_stock_remark  = $this->input->post('transfer_stock_remark');
			$transfer_stock_date    = $this->input->post('transfer_stock_date');
			$transfer_stock_inisial = $this->input->post('transfer_stock_inisial');
			$user_id 				= $_SESSION['user_id'];
			
			if($transfer_stock_inisial == ''){
				$msg = "Silahkan Isi Inisial";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}
			
			if($footer_total < 1){
				$msg = "Silahkan Isi Data Terlebih Dahulu";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}
			
			$maxCode  = $this->transferstock_model->last_transfer_stock();
			$inv_code = 'TS/'.$user_id.'/'.date("d/m/Y").'/';
			if ($maxCode == NULL) {
				$last_code = $inv_code.'000001';
			} else {
				$maxCode   = $maxCode[0]->hd_transfer_stock_code;
				$last_code = substr($maxCode, -6);
				$last_code = $inv_code.substr('000000' . strval(floatval($last_code) + 1), -6);
			}

			$data_insert = array(
				'hd_transfer_stock_code'	=> $last_code,
				'hd_transfer_stock_initial'	=> $transfer_stock_inisial,
				'hd_transfer_stock_date'	=> $transfer_stock_date,
				'hd_transfer_stock_qty' 	=> $footer_total,
				'hd_transfer_stock_desc'	=> $transfer_stock_remark,
				'user_id'	 				=> $user_id
			);
			$save_transfer_stock = $this->transferstock_model->save_transfer_stock($data_insert);

			$get_temp_transfer_stock = $this->transferstock_model->temp_transfer_stock($user_id)->result_array();

			foreach($get_temp_transfer_stock as $row)
			{
				$product_id_check = $row['temp_transfer_stock_product_id'];
				$from_check 	  = $row['temp_transfer_stock_warehouse_from'];
				$to_check 	      = $row['temp_transfer_stock_warehouse_to'];
				
				$last_stock_from = $this->transferstock_model->last_stock_from($product_id_check, $from_check)->result_array();
				$last_stock_to = $this->transferstock_model->last_stock_from($product_id_check, $to_check)->result_array();

				$data_insert_detail = array(
					'hd_transfer_stock_id'	 			 => $save_transfer_stock,
					'dt_transfer_stock_product_id'		 => $row['temp_transfer_stock_product_id'],
					'dt_transfer_stock_qty' 			 => $row['temp_transfer_stock_qty'],
					'dt_transfer_stock_warehouse_from'	 => $row['temp_transfer_stock_warehouse_from'],
					'dt_transfer_stock_warehouse_to'	 => $row['temp_transfer_stock_warehouse_to'],
					'dt_transfer_stock_from_qty'		 => $last_stock_from[0]['stock'],
					'dt_transfer_stock_to_qty'			 => $last_stock_to[0]['stock'] + $row['temp_transfer_stock_qty'],
					'dt_transfer_stock_note'			 => $row['temp_transfer_stock_note']
				);

				$this->transferstock_model->save_detail_transfer_stock($data_insert_detail);

				$warehouse_from 	= $row['temp_transfer_stock_warehouse_from'];
				$warehouse_to 	 	= $row['temp_transfer_stock_warehouse_to'];

				if($warehouse_from != 1){
					$product_id 		= $row['temp_transfer_stock_product_id'];
					$qty 				= $row['temp_transfer_stock_qty'];

					$get_last_stock_from 	= $this->transferstock_model->get_last_stock($product_id, $warehouse_from);
					$last_stock_from 		= $get_last_stock_from[0]->stock;
					$new_stock_from 		= $last_stock_from - $qty;
					$this->global_model->update_stock($product_id, $warehouse_from, $new_stock_from);

					$movement_stock = array(
						'stock_movement_product_id'		=> $product_id,
						'stock_movement_qty'			=> $qty,
						'stock_movement_before_stock'	=> $last_stock_from,
						'stock_movement_new_stock'		=> $new_stock_from,
						'stock_movement_desc'			=> 'Transfer Stock',
						'stock_movement_inv'			=> $last_code,
						'stock_movement_calculate'		=> 'Minus',
						'stock_movement_date'			=> $transfer_stock_date,
						'stock_movement_creted_by'		=> $user_id,	
					);	
					$this->global_model->insert_movement_stock($movement_stock);
				}


				if($warehouse_to != 1){
					$product_id 		= $row['temp_transfer_stock_product_id'];
					$qty 				= $row['temp_transfer_stock_qty'];	

					$get_last_stock_to = $this->transferstock_model->get_last_stock($product_id, $warehouse_to);
					if($get_last_stock_to == null){
						$insert_master_stock = array(
							'product_id '	=> $product_id,
							'warehouse_id'	=> $warehouse_to,
							'stock'			=> $qty,
						);	
						$this->global_model->insert_master_stock($insert_master_stock);
					}else{
						$last_stock_to 		= $get_last_stock_to[0]->stock;
						$new_stock_to 		= $last_stock_to + $qty;
						$this->global_model->update_stock($product_id, $warehouse_to, $new_stock_to);
					}
					$movement_stock = array(
						'stock_movement_product_id'		=> $product_id,
						'stock_movement_qty'			=> $qty,
						'stock_movement_before_stock'	=> $last_stock_to,
						'stock_movement_new_stock'		=> $new_stock_to,
						'stock_movement_desc'			=> 'Transfer Stock',
						'stock_movement_inv'			=> $last_code,
						'stock_movement_calculate'		=> 'Plus',
						'stock_movement_date'			=> $transfer_stock_date,
						'stock_movement_creted_by'		=> $user_id,	
					);	
					$this->global_model->insert_movement_stock($movement_stock);
				}
			}
			$this->transferstock_model->clear_transfer_stock($user_id);
			$msg = 'Success Tambah';
			echo json_encode(['code'=>200, 'result'=>$msg]);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}

	}

	public function delete_transfer_stock()
	{
		$modul = 'TransferStock';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->delete == 'Y'){
			$hd_transfer_id  	= $this->input->post('id');
			$user_id 		 	= $_SESSION['user_id'];
			$header_transfer 	= $this->transferstock_model->header_transfer_stock($hd_transfer_id);
			$detail_transfer 	= $this->transferstock_model->detail_transfer_stock($hd_transfer_id)->result_array();
			$last_code          = $header_transfer[0]->hd_transfer_stock_code;
			foreach($detail_transfer as $row)
			{
				$product_id 		= $row['dt_transfer_stock_product_id'];
				$qty 				= $row['dt_transfer_stock_qty'];
				$warehouse_to 		= $row['dt_transfer_stock_warehouse_to'];
				$warehouse_from 	= $row['dt_transfer_stock_warehouse_from'];

				if($warehouse_from != 1){
					$get_last_stock_from = $this->transferstock_model->get_last_stock($product_id, $warehouse_from);
					$last_stock_from 	 = $get_last_stock_from[0]->stock;
					$new_stock_from 	 = $last_stock_from + $qty;
					$this->global_model->update_stock($product_id, $warehouse_from, $new_stock_from);
					$movement_stock = array(
						'stock_movement_product_id'		=> $product_id,
						'stock_movement_qty'			=> $qty,
						'stock_movement_before_stock'	=> $last_stock_from,
						'stock_movement_new_stock'		=> $new_stock_from,
						'stock_movement_desc'			=> 'Batal Transfer Stock',
						'stock_movement_inv'			=> $last_code,
						'stock_movement_calculate'		=> 'Plus',
						'stock_movement_date'			=> date('Y-m-d'),
						'stock_movement_creted_by'		=> $user_id,	
					);	
					$this->global_model->insert_movement_stock($movement_stock);
				}


				if($warehouse_to != 1){

					$get_last_stock_to	 = $this->transferstock_model->get_last_stock($product_id, $warehouse_to);
					$last_stock_to 		 = $get_last_stock_to[0]->stock;
					$new_stock_to 		 = $last_stock_to - $qty;
					$this->global_model->update_stock($product_id, $warehouse_to, $new_stock_to);
					$movement_stock = array(
						'stock_movement_product_id'		=> $product_id,
						'stock_movement_qty'			=> $qty,
						'stock_movement_before_stock'	=> $last_stock_to,
						'stock_movement_new_stock'		=> $new_stock_to,
						'stock_movement_desc'			=> 'Batal Transfer Stock',
						'stock_movement_inv'			=> $last_code,
						'stock_movement_calculate'		=> 'Minus',
						'stock_movement_date'			=> date('Y-m-d'),
						'stock_movement_creted_by'		=> $user_id,	
					);	
					$this->global_model->insert_movement_stock($movement_stock);
				}

			}
			
			$data_insert_act = array(
				'activity_table_desc'	       => 'Batal Transfer Stok Ref: '.$last_code,
				'activity_table_ref'		   => $last_code,
				'activity_table_user'	       => $user_id,
			);
			$this->transferstock_model->update_transfer_stock($hd_transfer_id);
			$this->global_model->save($data_insert_act);

			$msg = "Berhasil Hapus";
			echo json_encode(['code'=>200, 'result'=>$msg]);die();
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

}

?>