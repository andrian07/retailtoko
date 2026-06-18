<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");

class Opname extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('masterdata_model');
		$this->load->model('global_model');
		$this->load->model('opname_model');
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


	// opname 
	public function index(){
		$modul = 'Opname';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$check_auth['check_auth'] = $check_auth;
			$this->load->view('Pages/Opname/opname', $check_auth);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function opname_list()
	{
		$modul = 'Opname';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$search 			= $this->input->post('search');
			$length 			= $this->input->post('length');
			$start 			  	= $this->input->post('start');

			if($search != null){
				$search = $search['value'];
			}
			$list = $this->opname_model->opname_list($search, $length, $start)->result_array();
			$count_list = $this->opname_model->opname_list_count($search)->result_array();
			$total_row = $count_list[0]['total_row'];
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $field) {

				if($check_auth[0]->view == 'Y'){
					$url = base_url();
					$detail = '<a href="'.base_url().'Opname/detailopname?id='.$field['opname_id'].'" data-fancybox="" data-type="iframe"><button type="button" class="btn btn-icon btn-primary btn-sm mb-2-btn" data-id="'.$field['opname_id'].'"><i class="fas fa-eye sizing-fa"></i></button></a> ';
				}else{
					$detail = '<a href="'.base_url().'Opname/detailopname?id='.$field['opname_id'].'" data-fancybox="" data-type="iframe"><button type="button" class="btn btn-icon btn-primary btn-sm mb-2-btn" disabled="disabled"><i class="fas fa-eye sizing-fa"></i></button></a> ';
				}

				$date = date_create($field['opname_date']); 

				$no++;
				$row = array();
				$row[] 	= $field['opname_code'];
				$row[] 	= date_format($date,"d-M-Y");
				$row[] 	= $field['user_name'];
				$row[] 	= 'Rp. '.number_format($field['opname_total']);
				$row[] 	= $detail;
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

	public function addopname()
	{
		$modul = 'Opname';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){
			$warehouse_list['warehouse_list'] = $this->masterdata_model->warehouse_list();
			$this->load->view('Pages/Opname/addopname', $warehouse_list);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function search_product_opname()
	{
		$warehouse = $this->input->get('id');
		if($warehouse != null){
			$keyword = $this->input->get('term');
			$result = ['success' => FALSE, 'num_product' => 0, 'data' => [], 'message' => ''];
			if (!($keyword == '' || $keyword == NULL)) {
				$find = $this->global_model->search_product_opname($keyword, $warehouse)->result_array();
				$find_result = [];
				foreach ($find as $row) {
					$diplay_text = $row['product_code'].' - '.$row['product_name'].' - '.$row['unit_name'];
					$find_result[] = [
						'id'                  => $row['product_id'],
						'value'               => $diplay_text,
						'product_code'        => $row['product_code'],
						'stock'      		  => $row['stock'],
						'product_hpp'     	  => $row['product_hpp'],
					];
				}
				$result = ['success' => TRUE, 'num_product' => count($find_result), 'data' => $find_result, 'message' => ''];
			}
			echo json_encode($result);
		}else{
			$result = ['success' => FALSE, 'num_product' => 0, 'data' => '', 'message' => 'Silahkan Isi Gudang Terlebih Dahulu'];
			echo json_encode($result);
		}
		
	}

	public function temp_opname()
	{
		$modul = 'Opname';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){
			$search 			= $this->input->post('search');
			$length 			= $this->input->post('length');
			$start 			  	= $this->input->post('start');
			$warehouse 			= $this->input->get('warehouse');
			$user 				= $_SESSION['user_id'];
			if($search != null){
				$search = $search['value'];
			}
			$list = $this->opname_model->temp_opname_list($search, $length, $start, $user, $warehouse)->result_array();
			$count_list = $this->opname_model->temp_opname_list_count($search, $user, $warehouse)->result_array();
			$total_row = $count_list[0]['total_row'];
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $field) {

				$edit = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" onclick="edit_temp('.$field['temp_opname_product_id'].')"><i class="fas fa-edit sizing-fa"></i></button> ';
				$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn" onclick="deletes('.$field['temp_opname_product_id'].')"><i class="fas fa-trash-alt sizing-fa"></i></button> ';

				$no++;
				$row = array();
				$row[] 	= $field['product_name'];
				$row[] 	= $field['product_code'];
				$row[] 	= $field['temp_opname_system_stock'];
				$row[] 	= $field['temp_opname_fisik_stock'];
				$row[] 	= $field['temp_opname_diferent_stock'];
				$row[] 	= 'Rp. '.number_format($field['temp_opname_diferent_hpp']);
				$row[] 	= $field['temp_opname_note'];
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

	public function add_temp_opname()
	{

		$modul = 'Opname';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){
			$warehouse 				= $this->input->post('warehouse');
			$product_id 			= $this->input->post('product_id');
			$system_stock 			= $this->input->post('system_stock');
			$fisik_stock 			= $this->input->post('fisik_stock');
			$stock_diferent 		= $this->input->post('stock_diferent');
			$hpp_submit 			= $this->input->post('hpp_submit');
			$hpp_diferent_submit 	= $this->input->post('hpp_diferent_submit');
			$temp_note 				= $this->input->post('temp_note');
			$user_id 				= $_SESSION['user_id'];

			$check_temp_opname_input = $this->opname_model->check_temp_opname_input($product_id, $user_id);
			$data_insert = array(
				'temp_opname_product_id'				=> $product_id,
				'temp_opname_warehouse_id'				=> $warehouse,
				'temp_opname_system_stock'				=> $system_stock,
				'temp_opname_fisik_stock'				=> $fisik_stock,
				'temp_opname_diferent_stock'			=> $stock_diferent,
				'temp_opname_diferent_hpp'				=> $hpp_diferent_submit,
				'temp_opname_note'						=> $temp_note,
				'user_id'								=> $user_id,
			);	
			
			if($check_temp_opname_input == null){
				$this->opname_model->add_temp_opname($data_insert);
				$msg = 'Success Tambah';
			}else{
				$this->opname_model->edit_temp_opname($product_id, $user_id, $data_insert);
				$msg = "Success Edit";
			}
			echo json_encode(['code'=>200, 'result'=>$msg]);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function delete_temp_opname()
	{
		$modul = 'Opname';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){
			$product_id  = $this->input->post('id');
			$user_id 	 = $_SESSION['user_id'];
			$this->opname_model->delete_temp_opname($product_id, $user_id);
			$msg = 'Success Delete';
			echo json_encode(['code'=>200, 'result'=>$msg]);
			die();
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);
		}
	}

	public function get_edit_temp_opname()
	{
		$temp_opname_product_id   	= $this->input->post('id');
		$user_id  	  				= $_SESSION['user_id'];
		$check_edit_temp_opname 	= $this->opname_model->check_edit_temp_opname($temp_opname_product_id, $user_id)->result_array();
		echo json_encode(['code'=>200, 'result'=>$check_edit_temp_opname]);
		die();
	}

	public function check_temp_opname()
	{
		$user_id 		= $_SESSION['user_id'];
		$check_temp_opname  = $this->opname_model->check_temp_opname($user_id);
		echo json_encode(['code'=>200, 'data'=>$check_temp_opname]);
		die();
	}

	public function save_opname()
	{
		

		$modul = 'Opname';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->add == 'Y'){
			$warehouse   	= $this->input->post('warehouse');
			$opname_date   	= $this->input->post('opname_date');
			$total_opname   = $this->input->post('total_opname');
			$user_id 		= $_SESSION['user_id'];

			if($total_opname == 0){
				$msg = 'Silahkan Isi Data Terlebih Dahulu';
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			$warehouse_id 		= $warehouse;
			$get_warehouse_code = $this->masterdata_model->get_warehouse_code($warehouse_id);
			$warehouse_code 	= $get_warehouse_code[0]->warehouse_code;
			$warehouse_name 	= $get_warehouse_code[0]->warehouse_name;

			$maxCode  = $this->opname_model->last_opname();

			$inv_code = 'OP/'.$warehouse_code.'/'.date("d/m/Y").'/';
			if ($maxCode == NULL) {
				$last_code = $inv_code.'000001';
			} else {
				$maxCode   = $maxCode[0]->opname_code;
				$last_code = substr($maxCode, -6);
				$last_code = $inv_code.substr('000000' . strval(floatval($last_code) + 1), -6);
			}
			$data_insert = array(
				'opname_code'			=> $last_code,
				'opname_warehouse'		=> $warehouse,
				'opname_date'			=> $opname_date,
				'opname_user'			=> $user_id,
				'opname_total'			=> $total_opname,
			);	
			$save_opname = $this->opname_model->save_opname($data_insert);

			$get_temp_opname = $this->opname_model->get_temp_opname($user_id)->result_array();
			foreach($get_temp_opname  as $row){
				$status_stock 	= $row['temp_opname_diferent_stock'];
				if($status_stock < 0){
					$status = 'Minus';
				}else{
					$status = 'Plus';
				}

				$data_insert_detail = array(
					'opname_id'							=> $save_opname,
					'dt_opname_product_id'				=> $row['temp_opname_product_id'],
					'dt_opname_stock_awal'				=> $row['temp_opname_system_stock'],
					'dt_opname_stock_akhir'				=> $row['temp_opname_fisik_stock'],
					'dt_opname_stock_difference'		=> $row['temp_opname_diferent_stock'],
					'dt_opname_stock_difference_hpp'	=> $row['temp_opname_diferent_hpp'],
					'dt_opname_stock_status'			=> $status,
				);

				$save_detail_opname = $this->opname_model->save_detail_opname($data_insert_detail);

				if($warehouse_id != 1){
					$product_id 	= $row['temp_opname_product_id'];
					$qty 			= $row['temp_opname_fisik_stock'];
					$last_stock 	= $row['temp_opname_system_stock'];
					$new_stock 		= $row['temp_opname_fisik_stock'];
					$get_last_stock = $this->purchase_model->get_last_stock($product_id, $warehouse_id);
					$this->global_model->update_stock($product_id, $warehouse_id, $new_stock);

					$movement_stock = array(
						'stock_movement_product_id'		=> $product_id,
						'stock_movement_qty'			=> $qty,
						'stock_movement_before_stock'	=> $last_stock,
						'stock_movement_new_stock'		=> $new_stock,
						'stock_movement_desc'			=> 'Opname Stock',
						'stock_movement_inv'			=> $last_code,
						'stock_movement_calculate'		=> $status,
						'stock_movement_date'			=> $opname_date,
						'stock_movement_creted_by'		=> $user_id,	
					);	
					$this->global_model->insert_movement_stock($movement_stock);
				}

			}

			$data_insert_act = array(
				'activity_table_desc'	       => 'Tambah Opname Cabang '.$warehouse_name.' Ref: '.$last_code,
				'activity_table_ref'		   => $last_code,
				'activity_table_user'	       => $user_id,
			);

			$this->global_model->save($data_insert_act);

			$this->opname_model->clear_temp_opname($user_id);

			$msg = 'Success Tambah';
			echo json_encode(['code'=>200, 'result'=>$msg]);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	// end opname

}

?>