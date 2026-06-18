<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");

class Masterdata extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->model('masterdata_model');
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
			//print_r($array);die();
			return($array);
		}
	}


	// brand //
	public function brand()
	{
		$modul = 'Brand';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->view == 'Y'){
			$brand_list['brand_list'] = $this->masterdata_model->brand_list();
			$check_auth['check_auth'] = $check_auth;
		
			$data['data'] = array_merge($check_auth, $brand_list);
			$this->load->view('Pages/Masterdata/brand', $data);
		}else{
			print_r('Tidak Ada Akses');die();
		}
	}

	public function save_brand()
	{
		$modul = 'Brand';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->add == 'Y'){
			$brand_name = $this->input->post('brand_name');
			$brand_desc = $this->input->post('brand_desc');
			$user_id 	= $_SESSION['user_id'];
			if($brand_name == null){
				$msg = "Nama Brand Harus Di isi";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}
			$insert = array(
				'brand_name'	       => $brand_name,
				'brand_desc'	       => $brand_desc,
			);
			$this->masterdata_model->save_brand($insert);

			$data_insert_act = array(
				'activity_table_desc'	       => 'Tambah Master Brand Baru',
				'activity_table_user'	       => $user_id,
			);
			$this->global_model->save($data_insert_act);
			$msg = "Succes Input";
			echo json_encode(['code'=>200, 'result'=>$msg]);
			die();
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);
		}
	}

	public function delete_brand()
	{
		$modul = 'Brand';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->delete == 'Y'){
			$brand_id  	= $this->input->post('id');
			$user_id 	= $_SESSION['user_id'];
			$this->masterdata_model->delete_brand($brand_id);
			$data_insert_act = array(
				'activity_table_desc'	       => 'Hapus Master Brand',
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

	public function edit_brand()
	{
		$modul = 'Brand';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->edit == 'Y'){
			$brand_id   	   = $this->input->post('brand_id');
			$brand_name   	   = $this->input->post('brand_name_edit');
			$brand_desc        = $this->input->post('brand_desc_edit');
			$user_id 		   = $_SESSION['user_id'];

			if($brand_name == null){
				$msg = "Nama Brand Harus Di isi";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			$update = array(
				'brand_name'	       => $brand_name,
				'brand_desc'	       => $brand_desc,
			);

			$this->masterdata_model->update_brand($update, $brand_id);
			$data_insert_act = array(
				'activity_table_desc'	       => 'Ubah Master Brand',
				'activity_table_user'	       => $user_id,
			);
			$this->global_model->save($data_insert_act);
			$msg = "Succes Update";
			echo json_encode(['code'=>200, 'result'=>$msg]);
			die();
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);
		}	
	}
	// end brand //

	// customer //

	public function save_customer()
	{	

		$modul = 'Customer';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->add == 'Y'){
			$customer_name 				= $this->input->post('customer_name');
			$customer_dob 				= $this->input->post('customer_dob');
			$customer_gender	 		= $this->input->post('customer_gender');
			$customer_address 			= $this->input->post('customer_address');
			$customer_address_blok 		= $this->input->post('customer_address_blok');
			$customer_address_no 		= $this->input->post('customer_address_no');
			$customer_address_rt 		= $this->input->post('customer_address_rt');
			$customer_address_rw 		= $this->input->post('customer_address_rw');
			$customer_address_phone 	= $this->input->post('customer_address_phone');
			$customer_address_email 	= $this->input->post('customer_address_email');
			$customer_send_address 		= $this->input->post('customer_send_address');
			$customer_expedisi 			= $this->input->post('customer_expedisi');
			$customer_npwp 				= $this->input->post('customer_npwp');
			$customer_nik 				= $this->input->post('customer_nik');
			$customer_rate 				= $this->input->post('customer_rate');
			$customer_expedisi_text     = $this->input->post('customer_expedisi_text');
			$user_id 		   			= $_SESSION['user_id'];
			$customer_expedisi_tag_id 	= implode(",",$customer_expedisi);

			if($customer_name == null){
				$msg = "Nama Customer Harus Di isi";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($customer_address_phone == null){
				$msg = "No Hp Harus Di isi";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			$customer_code = strtoupper(substr($customer_name, 0, 3));
			$maxCode = $this->masterdata_model->last_customer_code($customer_code);
			if ($maxCode == NULL) {
				$last_code = $customer_code.'001';
			} else {
				$maxCode = $maxCode[0]->customer_code;
				$last_code = substr($maxCode, -3);
				$last_code = $customer_code.substr('000' . strval(floatval($last_code) + 1), -3);
			}

			$data_insert = array(
				'customer_code'	       		=> $last_code,
				'customer_name'	       		=> $customer_name,
				'customer_dob'	       		=> $customer_dob,
				'customer_gender'	    	=> $customer_gender,
				'customer_address'	    	=> $customer_address,
				'customer_address_blok'		=> $customer_address_blok,
				'customer_address_no'		=> $customer_address_no,
				'customer_rt'	       		=> $customer_address_rt,
				'customer_rw'	       		=> $customer_address_rw,
				'customer_phone'	   		=> $customer_address_phone,
				'customer_email'	    	=> $customer_address_email,
				'customer_send_address'		=> $customer_send_address,
				'customer_npwp'	       		=> $customer_npwp,
				'customer_nik'	       		=> $customer_nik,
				'customer_rate'	       		=> $customer_rate,
				'customer_expedisi_tag' 	=> $customer_expedisi_text,
				'customer_expedisi_tag_id' 	=> $customer_expedisi_tag_id

			);
			$this->masterdata_model->save_customer($data_insert);

			foreach($customer_expedisi as $row){
				$insert_exp = array(
					'customer_code'	       	=> $last_code,
					'expedisi_id'	       	=> $row,
				);
				$this->masterdata_model->save_customer_ekspedisi($insert_exp);
			}

			$data_insert_act = array(
				'activity_table_desc'	       => 'Tambah Master Customer',
				'activity_table_user'	       => $user_id,
			);
			$this->global_model->save($data_insert_act);

			$msg = "Succes Input";
			echo json_encode(['code'=>200, 'result'=>$msg]);
			die();
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);
		}	
	}

	public function edit_customer()
	{
		$modul = 'Customer';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->edit == 'Y'){
			$customer_id   				= $this->input->post('customer_id');
			$customer_code 				= $this->input->post('customer_code');
			$customer_name 				= $this->input->post('customer_name');
			$customer_dob 				= $this->input->post('customer_dob');
			$customer_gender	 		= $this->input->post('customer_gender');
			$customer_address 			= $this->input->post('customer_address');
			$customer_address_blok 		= $this->input->post('customer_address_blok');
			$customer_address_no 		= $this->input->post('customer_address_no');
			$customer_address_rt 		= $this->input->post('customer_address_rt');
			$customer_address_rw 		= $this->input->post('customer_address_rw');
			$customer_address_phone 	= $this->input->post('customer_address_phone');
			$customer_address_email 	= $this->input->post('customer_address_email');
			$customer_send_address 		= $this->input->post('customer_send_address');
			$customer_expedisi 			= $this->input->post('customer_expedisi');
			$customer_npwp 				= $this->input->post('customer_npwp');
			$customer_nik 				= $this->input->post('customer_nik');
			$customer_rate 				= $this->input->post('customer_rate');
			$customer_expedisi_text     = $this->input->post('customer_expedisi_text');
			$user_id 		   			= $_SESSION['user_id'];
			$customer_expedisi_tag_id 	= implode(",",$customer_expedisi);

			if($customer_name == null){
				$msg = "Nama Customer Harus Di isi";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			if($customer_address_phone == null){
				$msg = "No Hp Harus Di isi";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			$data_edit = array(
				'customer_name'	       		=> $customer_name,
				'customer_dob'	       		=> $customer_dob,
				'customer_gender'	    	=> $customer_gender,
				'customer_address'	    	=> $customer_address,
				'customer_address_blok'		=> $customer_address_blok,
				'customer_address_no'		=> $customer_address_no,
				'customer_rt'	       		=> $customer_address_rt,
				'customer_rw'	       		=> $customer_address_rw,
				'customer_phone'	   		=> $customer_address_phone,
				'customer_email'	    	=> $customer_address_email,
				'customer_send_address'		=> $customer_send_address,
				'customer_npwp'	       		=> $customer_npwp,
				'customer_nik'	       		=> $customer_nik,
				'customer_rate'	       		=> $customer_rate,
				'customer_expedisi_tag' 	=> $customer_expedisi_text,
				'customer_expedisi_tag_id' 	=> $customer_expedisi_tag_id
			);


			$this->masterdata_model->edit_customer($data_edit, $customer_code);


			$this->masterdata_model->delete_customer_expedisi($customer_code);

			foreach($customer_expedisi as $row){
				$insert_exp = array(
					'customer_code'	       	=> $customer_code,
					'expedisi_id'	       	=> $row,
				);
				$this->masterdata_model->save_customer_ekspedisi($insert_exp);
			}

			$data_insert_act = array(
				'activity_table_desc'	       => 'Ubah Master Customer',
				'activity_table_user'	       => $user_id,
			);
			$this->global_model->save($data_insert_act);

			$msg = "Succes Input";
			echo json_encode(['code'=>200, 'result'=>$msg]);
			die();
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);
		}	
	}

	public function customer(){
		$modul = 'Customer';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->view == 'Y'){
			$customer_list['customer_list'] = $this->masterdata_model->customer_list();
			$ekspedisi_list['ekspedisi_list'] = $this->masterdata_model->ekspedisi_list();
			$check_auth['check_auth'] = $check_auth;
			$data['data'] = array_merge($customer_list, $ekspedisi_list, $check_auth);
			$this->load->view('Pages/Masterdata/customer', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);
		}	
	}

	public function detailcustomer(){
		$modul = 'Customer';
		$check_auth = $this->check_auth($modul);
		if(($check_auth['check_access'][0]->view == 'Y')){
			$id = $this->input->get('id');
			$get_customer_by_id['get_customer_by_id'] = $this->masterdata_model->get_customer_by_id($id);
			$this->load->view('Pages/Masterdata/customer_detail', $get_customer_by_id);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);
		}
	}


	public function get_customer_id(){
		$id = $this->input->post('id');
		$get_customer_by_id['get_customer_by_id'] = $this->masterdata_model->get_customer_by_id($id);
		echo json_encode(['code'=>200, 'result'=>$get_customer_by_id]);
	}

	public function delete_customer()
	{
		$modul = 'Customer';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->delete == 'Y'){
			$customer_id  	= $this->input->post('id');
			$user_id 		= $_SESSION['user_id'];
			$this->masterdata_model->delete_customer($customer_id);
			$data_insert_act = array(
				'activity_table_desc'	       => 'Hapus Master Customer',
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
	// end customer //

	// category
	public function category(){
		$modul = 'Category';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->view == 'Y'){
			$category_list['category_list'] = $this->masterdata_model->category_list();
			$check_auth['check_auth'] = $check_auth;
			$data['data'] = array_merge($check_auth, $category_list);
			$this->load->view('Pages/Masterdata/category', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);
		}
	}

	public function save_category()
	{
		$modul = 'Category';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->add == 'Y'){
			$category_name 	= $this->input->post('category_name');
			$category_desc 	= $this->input->post('category_desc');
			$user_id 			= $_SESSION['user_id'];

			if($category_name == null){
				$msg = "Nama Kategori Harus Di isi";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}
			$insert = array(
				'category_name'	=> $category_name,
				'category_desc'	=> $category_desc
			);
			$this->masterdata_model->save_category($insert);

			$data_insert_act = array(
				'activity_table_desc'	       => 'Tambah Kategori Baru',
				'activity_table_user'	       => $user_id,
			);
			$this->global_model->save($data_insert_act);
			$msg = "Succes Input";
			echo json_encode(['code'=>200, 'result'=>$msg]);
			die();
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);
		}
	}

	public function edit_category()
	{
		$modul = 'Category';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->edit == 'Y'){
			$category_id 	= $this->input->post('category_id');
			$category_name 	= $this->input->post('category_name');
			$category_desc 	= $this->input->post('category_desc');
			$user_id 			= $_SESSION['user_id'];

			if($category_name == null){
				$msg = "Nama Kategori Harus Di isi";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			$data_edit = array(
				'category_name'	=> $category_name,
				'category_desc'	=> $category_desc
			);
			$this->masterdata_model->edit_category($data_edit, $category_id);

			$data_insert_act = array(
				'activity_table_desc'	       => 'Ubah Master Kategori',
				'activity_table_user'	       => $user_id,
			);
			$this->global_model->save($data_insert_act);
			$msg = "Succes Input";
			echo json_encode(['code'=>200, 'result'=>$msg]);
			die();
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);
		}
	}

	public function delete_category()
	{
		$modul = 'Category';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->delete == 'Y'){
			$category_id  	= $this->input->post('id');
			$user_id 		= $_SESSION['user_id'];
			$this->masterdata_model->delete_category($category_id);
			$data_insert_act = array(
				'activity_table_desc'	       => 'Hapus Master Kategori',
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
	// end category

	//unit
	public function unit(){
		$modul = 'Unit';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->view == 'Y'){
			$unit_list['unit_list'] = $this->masterdata_model->unit_list();
			$check_auth['check_auth'] = $check_auth;
			$data['data'] = array_merge($check_auth, $unit_list);
			$this->load->view('Pages/Masterdata/unit', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);
		}
	}

	public function save_unit()
	{
		$modul = 'Unit';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->add == 'Y'){
			$unit_name 	= $this->input->post('unit_name');
			$unit_desc 	= $this->input->post('unit_desc');
			$user_id 	= $_SESSION['user_id'];

			if($unit_name == null){
				$msg = "Nama Unit Harus Di isi";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}
			$insert = array(
				'unit_name'		=> $unit_name,
				'unit_desc'		=> $unit_desc
			);
			$this->masterdata_model->save_unit($insert);

			$data_insert_act = array(
				'activity_table_desc'	       => 'Tambah Satuan Baru',
				'activity_table_user'	       => $user_id,
			);
			$this->global_model->save($data_insert_act);
			$msg = "Succes Input";
			echo json_encode(['code'=>200, 'result'=>$msg]);
			die();
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);
		}
	}

	public function edit_unit()
	{
		
		$modul = 'Unit';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->edit == 'Y'){
			$unit_id 	= $this->input->post('unit_id');
			$unit_name 	= $this->input->post('unit_name');
			$unit_desc 	= $this->input->post('unit_desc');
			$user_id 	= $_SESSION['user_id'];

			if($unit_name == null){
				$msg = "Nama Unit Harus Di isi";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}
			$data_edit = array(
				'unit_name'		=> $unit_name,
				'unit_desc'		=> $unit_desc
			);

			$this->masterdata_model->edit_unit($data_edit, $unit_id);

			$data_insert_act = array(
				'activity_table_desc'	       => 'Ubah Master Satuan',
				'activity_table_user'	       => $user_id,
			);
			$this->global_model->save($data_insert_act);
			$msg = "Succes Input";
			echo json_encode(['code'=>200, 'result'=>$msg]);
			die();
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);
		}
	}

	public function delete_unit()
	{
		$modul = 'Unit';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->delete == 'Y'){
			$unit_id  		= $this->input->post('id');
			$user_id 		= $_SESSION['user_id'];
			$this->masterdata_model->delete_unit($unit_id);
			$data_insert_act = array(
				'activity_table_desc'	       => 'Hapus Master Satuan',
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
	// end unit

	//supplier
	public function supplier(){
		$modul = 'Supplier';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->view == 'Y'){
			$supplier_list['supplier_list'] = $this->masterdata_model->supplier_list();
			$check_auth['check_auth'] = $check_auth;
			$data['data'] = array_merge($check_auth, $supplier_list);
			$this->load->view('Pages/Masterdata/supplier', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);
		}
	}

	public function save_supplier()
	{
		$modul = 'Supplier';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->add == 'Y'){
			$supplier_name 		= $this->input->post('supplier_name');
			$supplier_telp 		= $this->input->post('supplier_telp');
			$supplier_address 	= $this->input->post('supplier_address');
			$user_id 			= $_SESSION['user_id'];

			if($supplier_name == null){
				$msg = "Nama Supplier Harus Di isi";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			$supplier_code = strtoupper(substr($supplier_name, 0, 2));
			$maxCode = $this->masterdata_model->get_last_supplier();
			if ($maxCode == NULL) {
				$last_code = $supplier_code.'-'.'001';
			} else {
				$maxCode = $maxCode[0]->supplier_code;
				$last_code = substr($maxCode, -3);
				$last_code = $supplier_code.'-'.substr('000' . strval(floatval($last_code) + 1), -3);
			}

			$insert = array(
				'supplier_code'		=> $last_code,
				'supplier_name'		=> $supplier_name,
				'supplier_address'	=> $supplier_address,
				'supplier_phone'	=> $supplier_telp
			);
			$this->masterdata_model->save_supplier($insert);

			$data_insert_act = array(
				'activity_table_desc'	       => 'Tambah Supplier Baru',
				'activity_table_user'	       => $user_id,
			);
			$this->global_model->save($data_insert_act);
			$msg = "Succes Input";
			echo json_encode(['code'=>200, 'result'=>$msg]);
			die();
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);
		}
	}

	public function edit_supplier()
	{
		
		$modul = 'Supplier';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->edit == 'Y'){
			$supplier_id 		= $this->input->post('supplier_id');
			$supplier_name 		= $this->input->post('supplier_name');
			$supplier_telp 		= $this->input->post('supplier_telp');
			$supplier_address 	= $this->input->post('supplier_address');
			$user_id 			= $_SESSION['user_id'];

			if($supplier_name == null){
				$msg = "Nama Supplier Harus Di isi";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			$data_edit = array(
				'supplier_name'		=> $supplier_name,
				'supplier_address'	=> $supplier_address,
				'supplier_phone'	=> $supplier_telp
			);

			$this->masterdata_model->edit_supplier($data_edit, $supplier_id);

			$data_insert_act = array(
				'activity_table_desc'	       => 'Ubah Master Supplier',
				'activity_table_user'	       => $user_id,
			);
			$this->global_model->save($data_insert_act);
			$msg = "Succes Input";
			echo json_encode(['code'=>200, 'result'=>$msg]);
			die();
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);
		}
	}

	public function delete_supplier()
	{
		$modul = 'Supplier';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->delete == 'Y'){
			$supplier_id  		= $this->input->post('id');
			$user_id 			= $_SESSION['user_id'];
			$this->masterdata_model->delete_supplier($supplier_id);
			$data_insert_act = array(
				'activity_table_desc'	       => 'Hapus Master Supplier',
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
	//end supplier


	//product
	public function product(){
		$modul = 'Product';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->view == 'Y'){
			$category_list['category_list'] = $this->masterdata_model->category_list();
			$brand_list['brand_list'] 		= $this->masterdata_model->brand_list();
			$supplier_list['supplier_list'] = $this->masterdata_model->supplier_list();
			$unit_list['unit_list'] 		= $this->masterdata_model->unit_list();
			$check_auth['check_auth'] 		= $check_auth;
			$data['data'] = array_merge($check_auth, $category_list, $brand_list, $supplier_list, $unit_list);
			$this->load->view('Pages/Masterdata/product', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);
		}
	}	

	public function product_list()
	{
		
		$modul = 'Product';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->view == 'Y'){
			$search 			= $this->input->post('search');
			$length 			= $this->input->post('length');
			$start 			  	= $this->input->post('start');
			$supplier_filter = $this->input->post('filter_supplier');
			$category_filter = $this->input->post('filter_category');
			$brand_filter = $this->input->post('filter_brand');
			$product_status_filter = $this->input->post('filter_product_status');

			if($search != null){
				$search = $search['value'];
			}
			$user_id = $_SESSION['user_id'];
			$list = $this->masterdata_model->product_list($search, $length, $start, $supplier_filter, $category_filter, $brand_filter,$product_status_filter)->result_array();
			$count_list = $this->masterdata_model->product_list_count($search, $supplier_filter, $category_filter, $brand_filter,$product_status_filter)->result_array();
			$total_row = $count_list[0]['total_row'];
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $field) {

				if($field['is_ppn'] == 'PPN'){
					$prodcut_ppn = '<span class="badge badge-success"><i class="fas fa-check-circle"></i></span>';
				}else{
					$prodcut_ppn = '<span class="badge badge-danger multi-badge"><i class="fas fa-times-circle"></i></span>';
				}

				if($field['is_package'] == 'Y'){
					$product_package = '<span class="badge badge-success"><i class="fas fa-check-circle"></i></span>';
				}else{
					$product_package = '<span class="badge badge-danger multi-badge"><i class="fas fa-times-circle"></i></span>';
				}

				if($check_auth['check_access'][0]->edit == 'Y'){
					$edit = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" data-bs-toggle="modal" data-bs-target="#exampleModaledit" data-id="'.$field['product_id'].'" data-name="'.$field['product_name'].'"><i class="fas fa-edit sizing-fa"></i></button> <button type="button" class="btn btn-icon btn-info btn-sm mb-2-btn btnprice" onclick="setprice('.$field['product_id'].')""><i class="fas fa-cog sizing-fa"></i></button> ';
				}else{
					$edit = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" disabled="disabled"><i class="fas fa-edit sizing-fa"></i></button> <button type="button" class="btn btn-icon btn-info btn-sm mb-2-btn" disabled="disabled"><i class="fas fa-cog sizing-fa"></i></button> ';
				}

				if($check_auth['check_access'][0]->delete == 'Y'){
					$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn" onclick="deletes('.$field['product_id'].')"><i class="fas fa-trash-alt sizing-fa"></i></button> ';
				}else{
					$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn"  disabled="disabled"><i class="fas fa-trash-alt sizing-fa"></i></button> ';
				}

				$product_sell_price_1 = '<span class="badge badge-primary">'.number_format($field['product_sell_price_1']).'</span>';


				if($field['product_status'] == 'Aktif'){
					$product_status = '<span class="badge badge-success">Aktif</span>';
				}else if($field['product_status'] == 'Tidak Aktif'){
					$product_status = '<span class="badge badge-danger">Tidak Aktif</span>';
				}else{
					$product_status = '<span class="badge badge-warning">Discontinue</span>';
				}


				$url_image = base_url().'assets/products/'.$field['product_image'];
				$no++;
				$row = array();
				$row[] = '<h2 class="table-product">'.$field['product_code'].'</h3><p>'.$field['product_name'].'</p>';
				$row[] = $field['unit_name'];
				$row[] = $field['brand_name'];
				$row[] = $field['category_name'];
				$row[] = $product_sell_price_1;
				$row[] = $field['product_supplier_tag'];
				$row[] = $product_status;
				$row[] = $product_package;
				$row[] = $prodcut_ppn;
				$row[] = '<img src="'.$url_image.'" width="50%">';
				$row[] = $edit.$delete;
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

	function generateRandomString($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';

		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[random_int(0, $charactersLength - 1)];
		}

		return $randomString;
	}

	public function save_product()
	{
		$modul = 'Product';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->add == 'Y'){
			$screenshoot 				= $this->input->post('screenshoot');
			$product_name 				= $this->input->post('product_name');
			$product_category 			= $this->input->post('product_category');
			$product_brand				= $this->input->post('product_brand');
			$product_supplier 			= $this->input->post('product_supplier');
			$product_supplier_text      = $this->input->post('product_supplier_text');
			$product_tax 				= $this->input->post('product_tax');
			$product_unit 				= $this->input->post('product_unit');
			$product_type 				= $this->input->post('product_type');
			$product_min_stock			= $this->input->post('product_min_stock');
			$product_description		= $this->input->post('product_description');
			$user_id 					= $_SESSION['user_id'];
			$product_supplier_id_tag 	= implode(",",$product_supplier);


			$product_code = strtoupper(substr($product_name, 0, 3));
			$maxCode = $this->masterdata_model->last_product_code();
			if ($maxCode == NULL) {
				$last_code = $product_code.'00001';
			} else {
				$maxCode = $maxCode[0]->product_code;
				$last_code = substr($maxCode, -5);
				$last_code = $product_code.substr('00000' . strval(floatval($last_code) + 1), -5);
			}
			if($_FILES['screenshoot']['name'] == null){
				$new_image_name = 'default.png';
			}else{
				$new_image_name = $last_code.$this->generateRandomString().'.png';
				$config['upload_path'] = './assets/products/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg|PNG';
				$config['file_name'] = $new_image_name;
				$this->load->library('upload', $config);
				if (!$this->upload->do_upload('screenshoot')) 
				{
					$error = array('error' => $this->upload->display_errors());
				} 
				else
				{
					$data = array('image_metadata' => $this->upload->data());
				}
			}

			$data_insert = array(
				'product_code'				=> $last_code,
				'product_name'				=> $product_name,
				'product_brand'				=> $product_brand,
				'product_unit'				=> $product_unit,
				'product_category'			=> $product_category,
				'product_supplier_id_tag'	=> $product_supplier_id_tag,
				'product_supplier_tag'		=> $product_supplier_text,
				'is_package'				=> $product_type,
				'is_ppn'					=> $product_tax,
				'product_min_stock'			=> $product_min_stock,
				'product_desc'				=> $product_description,
				'product_image'				=> $new_image_name
			);

			$insert = $this->masterdata_model->save_product($data_insert);

			foreach($product_supplier as $row){
				$insert_supplier = array(
					'product_id'				=> $insert,
					'supplier_id'				=> $row
				);
				$this->masterdata_model->save_product_supplier($insert_supplier);
			}	

			$data_insert_master_stock = array(
				'product_id'				=> $insert,
				'warehouse_id'				=> 1,
				'stock'						=> 0
			);

			$this->masterdata_model->save_product_stock($data_insert_master_stock);

			$data_insert_act = array(
				'activity_table_desc'	       => 'Tambah Produk Baru',
				'activity_table_user'	       => $user_id,
			);
			$this->global_model->save($data_insert_act);
			$msg = "Succes Input";
			echo json_encode(['code'=>200, 'result'=>$msg]);die();
			die();
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function edit_product()
	{
		$modul = 'Product';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->add == 'Y'){
			$screenshoot 				= $this->input->post('screenshoot_edit');
			$product_id 				= $this->input->post('product_id_edit');
			$product_code 				= $this->input->post('product_code_edit');
			$product_name 				= $this->input->post('product_name_edit');
			$product_category 			= $this->input->post('product_category_edit');
			$product_brand				= $this->input->post('product_brand_edit');
			$product_supplier 			= $this->input->post('product_supplier_edit');
			$product_supplier_text      = $this->input->post('product_supplier_text_edit');
			$product_tax 				= $this->input->post('product_tax_edit');
			$product_unit 				= $this->input->post('product_unit_edit');
			$product_type 				= $this->input->post('product_type_edit');
			$product_min_stock			= $this->input->post('product_min_stock_edit');
			$product_description		= $this->input->post('product_description_edit');
			$product_status				= $this->input->post('product_status_edit');
			$user_id 					= $_SESSION['user_id'];
			$product_supplier_id_tag 	= implode(",",$product_supplier);
			$reset_image 				= $this->input->post('reset_image');

			
			if($_FILES['screenshoot_edit']['name'] == null){
				$get_product_by_id   = $this->masterdata_model->get_product_by_id($product_id);
				$new_image_name 	 = $get_product_by_id[0]->product_image;
				if($reset_image == 1){
					$new_image_name = 'default.png';
					$config['upload_path'] = './assets/products/';
					$config['allowed_types'] = 'gif|jpg|png|jpeg|PNG';
					$config['file_name'] = $new_image_name;
					$this->load->library('upload', $config);
					if (!$this->upload->do_upload('screenshoot_edit')) 
					{
						$error = array('error' => $this->upload->display_errors());
					} 
					else
					{
						$data = array('image_metadata' => $this->upload->data());
						$data_edit = array('product_image' => $new_image_name);
					}
				}
			}else{
				$new_image_name = $product_code.$this->generateRandomString().'.png';
				$config['upload_path'] = './assets/products/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg|PNG';
				$config['file_name'] = $new_image_name;
				$this->load->library('upload', $config);
				if (!$this->upload->do_upload('screenshoot_edit')) 
				{
					$error = array('error' => $this->upload->display_errors());
				} 
				else
				{
					$data = array('image_metadata' => $this->upload->data());
					$data_edit = array('product_image' => $new_image_name);
				}
			}

			$data_edit = array(
				'product_code'				=> $product_code,
				'product_name'				=> $product_name,
				'product_brand'				=> $product_brand,
				'product_unit'				=> $product_unit,
				'product_category'			=> $product_category,
				'product_supplier_id_tag'	=> $product_supplier_id_tag,
				'product_supplier_tag'		=> $product_supplier_text,
				'is_package'				=> $product_type,
				'is_ppn'					=> $product_tax,
				'product_min_stock'			=> $product_min_stock,
				'product_desc'				=> $product_description,
				'product_image' 			=> $new_image_name,
				'product_status'			=> $product_status
			);	


			$this->masterdata_model->edit_product($data_edit, $product_id);


			$this->masterdata_model->delete_product_supplier($product_id);

			foreach($product_supplier as $row){
				$insert_supplier = array(
					'product_id'				=> $product_code,
					'supplier_id'				=> $product_name
				);
				$this->masterdata_model->save_product_supplier($insert_supplier);
			}	

			$data_insert_act = array(
				'activity_table_desc'	       => 'Edit Produk Baru',
				'activity_table_user'	       => $user_id,
			);
			$this->global_model->save($data_insert_act);
			$msg = "Succes Input";
			echo json_encode(['code'=>200, 'result'=>$msg]);die();
			die();
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}


	public function edit_price()
	{
		$modul = 'Product';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->add == 'Y'){
			$product_id 					= $this->input->post('item_id');
			$item_purchase_price_val 		= $this->input->post('item_purchase_price_val');
			$item_hpp_val 					= $this->input->post('item_hpp_val');
			$item_price_1_percentage_val 	= $this->input->post('item_price_1_percentage_val');
			$item_price_2_percentage_val 	= $this->input->post('item_price_2_percentage_val');
			$item_price_3_percentage_val	= $this->input->post('item_price_3_percentage_val');
			$item_price_4_percentage_val 	= $this->input->post('item_price_4_percentage_val');
			$item_price_1_val      			= $this->input->post('item_price_1_val');
			$item_price_2_val  				= $this->input->post('item_price_2_val');
			$item_price_3_val 				= $this->input->post('item_price_3_val');
			$item_price_4_val 				= $this->input->post('item_price_4_val');
			$disc_percentage_val 			= $this->input->post('disc_percentage_val');
			$start_disc_val					= $this->input->post('start_disc_val');
			$end_disc_val					= $this->input->post('end_disc_val');
			$user_id 						= $_SESSION['user_id'];

			$data_edit = array(
				'product_price'				=> $item_purchase_price_val,
				'product_hpp'				=> $item_hpp_val,
				'product_sell_percentage_1'	=> $item_price_1_percentage_val,
				'product_sell_percentage_2'	=> $item_price_2_percentage_val,
				'product_sell_percentage_3'	=> $item_price_3_percentage_val,
				'product_sell_percentage_4'	=> $item_price_4_percentage_val,
				'product_sell_price_1'		=> $item_price_1_val,
				'product_sell_price_2'		=> $item_price_2_val,
				'product_sell_price_3'		=> $item_price_3_val,
				'product_sell_price_4'		=> $item_price_4_val,
				'product_disc_percentage'	=> $disc_percentage_val,
				'product_disc_start_date'	=> $start_disc_val,
				'product_disc_end_date'		=> $end_disc_val,
			);	


			$this->masterdata_model->edit_product($data_edit, $product_id);

			$data_insert_act = array(
				'activity_table_desc'	       => 'Update Harga Produk Baru',
				'activity_table_user'	       => $user_id,
			);
			$this->global_model->save($data_insert_act);
			$msg = "Succes Input";
			echo json_encode(['code'=>200, 'result'=>$msg]);die();
			die();
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function delete_product()
	{
		$modul = 'Product';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->delete == 'Y'){
			$id  		= $this->input->post('id');
			$user_id 	= $_SESSION['user_id'];
			$this->masterdata_model->delete_product($id);
			$data_insert_act = array(
				'activity_table_desc'	       => 'Hapus Master Produk',
				'activity_table_user'	       => $user_id,
			);
			$this->global_model->save($data_insert_act);
			$msg = "Succes Delete";
			echo json_encode(['code'=>200, 'result'=>$msg]);
			die();
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function settingproduct(){
		$modul = 'Product';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->edit == 'Y'){
			$id = $this->input->get('id');
			$settingproduct['settingproduct'] = $this->masterdata_model->settingproduct($id);
			$product_stock['product_stock'] = $this->masterdata_model->product_stock($id);
			$check_auth['check_auth'] = $check_auth;
			$data['data'] = array_merge($settingproduct, $product_stock, $check_auth);
			$this->load->view('Pages/Masterdata/product_setting', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function get_edit_product()
	{
		$modul = 'Product';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->view == 'Y'){
			$id = $this->input->post('id');
			$settingproduct = $this->masterdata_model->settingproduct($id);
			echo json_encode(['code'=>200, 'result'=>$settingproduct]);die();
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function delete_product_note()
	{
		$modul = 'Product';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->delete == 'Y'){
			$note_id = $this->input->post('note_id');
			$this->masterdata_model->delete_product_note($note_id);
			echo json_encode(['code'=>200, 'result'=>'Deleted']);die();
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function delete_filter_product()
	{
		$user_id = $_SESSION['user_id'];
		$this->masterdata_model->delete_filter_product($user_id);
	}

	public function insert_filter_product()
	{
		$filter_supplier 		= $this->input->post('filter_supplier');
		$filter_category 		= $this->input->post('filter_category');
		$filter_brand    		= $this->input->post('filter_brand');
		$filter_product_status  = $this->input->post('filter_product_status');
		$user_id 		 		= $_SESSION['user_id'];

		$this->masterdata_model->delete_filter_product($user_id);

		if($filter_supplier == 'ALL'){
			$filter_supplier = '';
		}
		$data_insert = array(
			'supplier_filter' 		=> $filter_supplier,
			'category_filter'		=> $filter_category,
			'brand_filter'      	=> $filter_brand,
			'product_status_filter' => $filter_product_status,
			'user_id'				=> $user_id
		);
		$this->masterdata_model->insert_filter_product($data_insert);
		echo json_encode(['code'=>200]);die();

	}

	//end product


	// payment type

	public function payment()
	{
		$modul = 'Payment';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->view == 'Y'){
			$check_auth['check_auth'] 			= $check_auth;
			$payment_list['payment_list'] 		= $this->masterdata_model->payment_list();
			$data['data'] = array_merge($check_auth, $payment_list);
			$this->load->view('Pages/Masterdata/payment', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);
		}
	}	

	public function save_payment()
	{
		$modul = 'Payment';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->add == 'Y'){
			$payment_name 	= $this->input->post('payment_name');
			$payment_rek 	= $this->input->post('payment_rek');
			$user_id 		= $_SESSION['user_id'];
			if($payment_name == null){
				$msg = "Nama Pembayaran Harus Di isi";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}
			$insert = array(
				'payment_name'	       => $payment_name,
				'payment_rek'	       => $payment_rek,
			);
			$this->masterdata_model->save_payment($insert);

			$data_insert_act = array(
				'activity_table_desc'	       => 'Tambah Master Pembayaran',
				'activity_table_user'	       => $user_id,
			);
			$this->global_model->save($data_insert_act);
			$msg = "Succes Input";
			echo json_encode(['code'=>200, 'result'=>$msg]);
			die();
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);
		}
	}

	public function edit_payment()
	{
		$modul = 'Payment';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->edit == 'Y'){
			$payment_id 	= $this->input->post('payment_id');
			$payment_name 	= $this->input->post('payment_name');
			$payment_rek 	= $this->input->post('payment_rek');
			$user_id 		= $_SESSION['user_id'];

			if($payment_name == null){
				$msg = "Nama Pembayaran Harus Di isi";
				echo json_encode(['code'=>0, 'result'=>$msg]);die();
			}

			$update = array(
				'payment_name'	       => $payment_name,
				'payment_no_rek'	   => $payment_rek,
			);

			$this->masterdata_model->update_payment($update, $payment_id);
			$data_insert_act = array(
				'activity_table_desc'	       => 'Ubah Master Payment',
				'activity_table_user'	       => $user_id,
			);
			$this->global_model->save($data_insert_act);
			$msg = "Succes Update";
			echo json_encode(['code'=>200, 'result'=>$msg]);
			die();
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);
		}	
	}

	public function payment_list()
	{

		$modul = 'Payment';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->view == 'Y'){
			$search 			= $this->input->post('search');
			$length 			= $this->input->post('length');
			$start 			  	= $this->input->post('start');

			if($search != null){
				$search = $search['value'];
			}
			$user_id = $_SESSION['user_id'];
			$list = $this->masterdata_model->payment_list($search, $length, $start)->result_array();
			$count_list = $this->masterdata_model->payment_list_count($search)->result_array();
			$total_row = $count_list[0]['total_row'];
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $field) {

				if($field['is_ppn'] == 'PPN'){
					$prodcut_ppn = '<span class="badge badge-success"><i class="fas fa-check-circle"></i></span>';
				}else{
					$prodcut_ppn = '<span class="badge badge-danger multi-badge"><i class="fas fa-times-circle"></i></span>';
				}

				if($field['is_package'] == 'Y'){
					$product_package = '<span class="badge badge-success"><i class="fas fa-check-circle"></i></span>';
				}else{
					$product_package = '<span class="badge badge-danger multi-badge"><i class="fas fa-times-circle"></i></span>';
				}

				if($check_auth['check_access'][0]->edit == 'Y'){
					$edit = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" data-bs-toggle="modal" data-bs-target="#exampleModaledit" data-id="'.$field['product_id'].'" data-name="'.$field['product_name'].'"><i class="fas fa-edit sizing-fa"></i></button> <button type="button" class="btn btn-icon btn-info btn-sm mb-2-btn btnprice" onclick="setprice('.$field['product_id'].')""><i class="fas fa-cog sizing-fa"></i></button> ';
				}else{
					$edit = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" disabled="disabled"><i class="fas fa-edit sizing-fa"></i></button> <button type="button" class="btn btn-icon btn-info btn-sm mb-2-btn" disabled="disabled"><i class="fas fa-cog sizing-fa"></i></button> ';
				}

				if($check_auth['check_access'][0]->delete == 'Y'){
					$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn" onclick="deletes('.$field['product_id'].')"><i class="fas fa-trash-alt sizing-fa"></i></button> ';
				}else{
					$delete = '<button type="button" class="btn btn-icon btn-danger delete btn-sm mb-2-btn"  disabled="disabled"><i class="fas fa-trash-alt sizing-fa"></i></button> ';
				}

				$product_sell_price_1 = '<span class="badge badge-primary">'.number_format($field['product_sell_price_1']).'</span>';

				$url_image = base_url().'assets/products/'.$field['product_image'];
				$no++;
				$row = array();
				$row[] = '<h2 class="table-product">'.$field['product_code'].'</h3><p>'.$field['product_name'].'</p>';
				$row[] = $field['brand_name'];
				$row[] = $field['category_name'];
				$row[] = $product_sell_price_1;
				$row[] = $field['product_supplier_tag'];
				$row[] = $product_package;
				$row[] = $prodcut_ppn;
				$row[] = '<img src="'.$url_image.'" width="50%">';
				$row[] = $edit.$delete;
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
	// End payment type
}	

?>