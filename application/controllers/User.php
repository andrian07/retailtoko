	<?php

	defined('BASEPATH') OR exit('No direct script access allowed');
	header('Access-Control-Allow-Origin: *');
	header("Access-Control-Allow-Methods: GET, OPTIONS");

	class User extends CI_Controller {

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
				return($array);
			}
		}

		public function role(){
			$modul = 'Role';
			$check_auth = $this->check_auth($modul);
			if($check_auth['check_access'][0]->view == 'Y'){
				$check_auth['check_auth'] = $check_auth;
				$group_role['group_role'] = $this->masterdata_model->group_role();
				$data['data'] = array_merge($check_auth, $group_role);
				$this->load->view('Pages/User/group', $data);
			}else{
				print_r('Tidak Ada Akses');die();
			}
		}

		public function get_setting_permission()
		{
			$modul = 'Role';
			$check_auth = $this->check_auth($modul);
			if($check_auth['check_access'][0]->view == 'Y'){
				$id = $this->input->post('id');
				$get_setting_permission['get_setting_permission'] = $this->masterdata_model->get_setting_permission($id);
				$get_settting_product['get_settting_product'] = $this->masterdata_model->get_settting_product($id)->result_array();
				$data['data'] = array_merge($get_setting_permission, $get_settting_product);
				echo json_encode($data);
			}else{
				print_r('Tidak Ada Akses');die();
			}
		}

		public function save_role(){
			$modul = 'Role';
			$check_auth = $this->check_auth($modul);
			if($check_auth['check_access'][0]->add == 'Y'){
				$role_name = $this->input->post('role_name');
				$user_id   = $_SESSION['user_id'];
				if($role_name == null){
					$msg = "Nama Group Harus Di isi";
					echo json_encode(['code'=>0, 'result'=>$msg]);die();
				}
				$check_role = $this->masterdata_model->check_role($role_name);
				if($check_role != null){
					$msg = "Nama Group Sudah Ada";
					echo json_encode(['code'=>0, 'result'=>$msg]);die();
				}
				$insert = array(
					'role_name'	       => $role_name
				);
				$this->masterdata_model->save_role($insert);
				$role_id = $this->db->insert_id();

				for($i = 1; $i<=28 ; $i++){
					$data_insert_permision = array(
						'role_id'	       => $role_id,
						'module_id'        => $i
					);

					$this->masterdata_model->save_permision($data_insert_permision);
				}
				
				$data_product_role = array(
					'role_id'	       => $role_id
				);
				$this->masterdata_model->save_product_role($data_product_role);

				$data_insert_act = array(
					'activity_table_desc'	       => 'Tambah Group Baru '. $role_name,
					'activity_table_user'	       => $user_id,
				);
				$this->global_model->save($data_insert_act);
				$msg = "Succes Input";
				echo json_encode(['code'=>200, 'result'=>$msg]);
				die();
			}else{
				print_r('Tidak Ada Akses');die();
			}
		}

		public function edit_role()
		{

			$modul = 'Role';
			$check_auth = $this->check_auth($modul);
			if($check_auth['check_access'][0]->edit == 'Y'){
				$role_id   	       = $this->input->post('role_id');
				$role_name   	   = $this->input->post('role_name_edit');
				$user_id   		   = $_SESSION['user_id'];

				if($role_name == null){
					$msg = "Nama Group Harus Di isi";
					echo json_encode(['code'=>0, 'result'=>$msg]);die();
				}

				$update = array(
					'role_name'	       => $role_name
				);

				$this->masterdata_model->update_role($update, $role_id);

				$data_insert_act = array(
					'activity_table_desc'	       => 'Update Group Menjadi '. $role_name,
					'activity_table_user'	       => $user_id,
				);
				$this->global_model->save($data_insert_act);

				$msg = "Succes Update";
				echo json_encode(['code'=>200, 'result'=>$msg]);
				die();
				echo json_encode($get_setting_permission);
			}else{
				print_r('Tidak Ada Akses');die();
			}
			
		}

		public function edit_acc_product()
		{
			$modul = 'Role';
			$check_auth = $this->check_auth($modul);
			if($check_auth['check_access'][0]->edit == 'Y'){
				$role_id   	       			= $this->input->post('role_id');
				$access_price_umum 			= $this->input->post('access_price_umum');
				$access_price_toko   	   	= $this->input->post('access_price_toko');
				$access_price_sales   	   	= $this->input->post('access_price_sales');
				$access_price_khusus   	   	= $this->input->post('access_price_khusus');
				$access_purchase_price   	= $this->input->post('access_purchase_price');
				$access_stock   	   		= $this->input->post('access_stock');
				$access_supplier   	   		= $this->input->post('access_supplier');
				$access_item_supplier   	= $this->input->post('access_item_supplier');
				$access_status   	   		= $this->input->post('access_status');
				$user_id   		   			= $_SESSION['user_id'];

				if($role_id == null){
					$msg = "Terjadi Kesalahan Silahkan Refresh Kembali";
					echo json_encode(['code'=>0, 'result'=>$msg]);die();
				}

				$update = array(
					'access_umum_price'	  	=> $access_price_umum,
					'access_store_price'	=> $access_price_toko,
					'access_sales_price'	=> $access_price_sales,
					'access_special_price'	=> $access_price_khusus,
					'access_purchase_price'	=> $access_purchase_price,
					'access_stock'	       	=> $access_stock,
					'access_item_supplier'	=> $access_supplier,
					'access_supplier'	    => $access_item_supplier,
					'access_status'	       	=> $access_status

				);
				$this->masterdata_model->update_acc_product($update, $role_id);

				$data_insert_act = array(
					'activity_table_desc'	       => 'Update Aksess Produk',
					'activity_table_user'	       => $user_id,
				);
				$this->global_model->save($data_insert_act);

				$msg = "Succes Update";
				echo json_encode(['code'=>200, 'result'=>$msg]);
				die();
				echo json_encode($get_setting_permission);
			}else{
				print_r('Tidak Ada Akses');die();
			}
		}

		public function delete_role()
		{
			$modul = 'Role';
			$check_auth = $this->check_auth($modul);
			if($check_auth['check_access'][0]->delete == 'Y'){
				$role_id  	= $this->input->post('id');
				$role_name  = $this->input->post('role_name');
				$user_id   	= $_SESSION['user_id'];
				$this->masterdata_model->delete_role($role_id);
				$msg = "Succes Delete";
				$data_insert_act = array(
					'activity_table_desc'	       => 'Delete Group '. $role_name,
					'activity_table_user'	       => $user_id,
				);
				$this->global_model->save($data_insert_act);

				echo json_encode(['code'=>200, 'result'=>$msg]);
				die();
			}else{
				print_r('Tidak Ada Akses');die();
			}
		}

		public function updatepermision()
		{
			$modul = 'Role';
			$check_auth = $this->check_auth($modul);
			if($check_auth['check_access'][0]->edit == 'Y'){
				$role_permission 			= $this->input->post('role_permission');
				$value_permission_view      = $this->input->post('value_permission_view');
				$value_permission_add      	= $this->input->post('value_permission_add');
				$value_permission_edit      = $this->input->post('value_permission_edit');
				$value_permission_delete    = $this->input->post('value_permission_delete');

				if($value_permission_view == 'true'){
					$view = 'Y';
					$navbar = 'Y';
				}else{
					$view 	= 'N';
					$add 	= 'N';
					$edit 	= 'N';
					$delete = 'N';
					$navbar = 'N';
				}
				
				if($view == 'Y'){
					if($value_permission_add == 'true'){
						$add = 'Y';
					}else{
						$add = 'N';
					}
				}
				
				if($view == 'Y'){
					if($value_permission_edit == 'true'){
						$edit = 'Y';
					}else{
						$edit = 'N';
					}
				}

				if($view == 'Y'){
					if($value_permission_delete == 'true'){
						$delete = 'Y';
					}else{
						$delete = 'N';
					}
				}

				$data_edit = array(
					'view'	  => $view,
					'add'	  => $add,
					'edit'	  => $edit,
					'delete'  => $delete,
					'nav_bar'  => $navbar,
				);

				$this->masterdata_model->update_role_permision($data_edit, $role_permission);
				$msg = "Succes Input";
				echo json_encode(['code'=>200, 'result'=>$msg]);
			}else{
				$msg = "No Access";
				echo json_encode(['code'=>0, 'result'=>$msg]);
			}
		}


		// start account

		public function account()
		{
			$modul = 'Accountuser';
			$check_auth = $this->check_auth($modul);
			if($check_auth['check_access'][0]->view == 'Y'){
				$role_list['role_list'] = $this->masterdata_model->role_list()->result_array();
				$check_auth['check_auth'] = $check_auth;
				$data['data'] = array_merge($check_auth, $role_list);
				$this->load->view('Pages/User/account', $data);
			}else{
				$msg = "No Access";
				echo json_encode(['code'=>0, 'result'=>$msg]);
			}
		}

		public function user_list()
		{
			$modul = 'Accountuser';
			$check_auth = $this->check_auth($modul);
			if($check_auth['check_access'][0]->view == 'Y'){
				$search 			= $this->input->post('search');
				$length 			= $this->input->post('length');
				$start 			  	= $this->input->post('start');

				if($search != null){
					$search = $search['value'];
				}
				$list = $this->masterdata_model->account_list($search, $length, $start)->result_array();
				$count_list = $this->masterdata_model->account_list_count($search)->result_array();
				$total_row = $count_list[0]['total_row'];
				$data = array();
				$no = $_POST['start'];
				foreach ($list as $field) {

					if($check_auth['check_access'][0]->edit == 'Y'){
						$edit = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" data-bs-toggle="modal" data-bs-target="#exampleModaledit" data-id="'.$field['user_id'].'" data-name="'.$field['user_name'].'" data-role="'.$field['user_role'].'"><i class="fas fa-edit sizing-fa"></i></button> ';
					}else{
						$edit = '<button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn" disabled="disabled"><i class="fas fa-edit sizing-fa"></i></button> <button type="button" class="btn btn-icon btn-info btn-sm mb-2-btn" disabled="disabled"><i class="fas fa-cog sizing-fa"></i></button> ';
					}
					if($check_auth['check_access'][0]->delete == 'Y'){
						$delete = '<button type="button" class="btn btn-icon btn-danger btn-sm mb-2-btn delete" onclick="delete_account('.$field['user_id'].')"><i class="fas fa-trash-alt sizing-fa"></i></button> ';
					}else{
						$delete = '<button type="button" class="btn btn-icon btn-danger btn-sm mb-2-btn delete" disabled="disabled"><i class="fas fa-trash-alt sizing-fa"></i></button> ';
					}

					$no++;
					$row = array();
					$row[] = $field['user_name'];
					$row[] = $field['role_name'];
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

		public function save_user()
		{
			$modul = 'Accountuser';
			$check_auth = $this->check_auth($modul);
			if($check_auth['check_access'][0]->add == 'Y'){
				$user_name  		= $this->input->post('user_name');
				$user_role 			= $this->input->post('user_role');
				$user_id_inp	   	= $this->input->post('user_id_inp');
				$user_id 		   	= $_SESSION['user_id'];
				$data_insert = array(
					'user_name'	       	=> $user_name,
					'user_password'		=> md5($user_name),
					'user_role'	       	=> $user_role
				);
				if($user_id_inp == null){
					$this->masterdata_model->save_user($data_insert);
				}else{
					$this->masterdata_model->edit_user($data_insert, $user_id_inp);
				}
				$msg = "Sukses";
				echo json_encode(['code'=>200, 'result'=>$msg]);
				die();
			}else{
				$msg = "No Access";
				echo json_encode(['code'=>0, 'result'=>$msg]);
			}	
		}

		public function delete_account()
		{
			$modul = 'Accountuser';
			$check_auth = $this->check_auth($modul);
			if($check_auth['check_access'][0]->add == 'Y'){
				$id  		= $this->input->post('id');
				$user_id 	= $_SESSION['user_id'];
				$this->masterdata_model->delete_account($id);
				$msg = "Sukses";
				echo json_encode(['code'=>200, 'result'=>$msg]);
				die();
			}else{
				$msg = "No Access";
				echo json_encode(['code'=>0, 'result'=>$msg]);
			}	
		}
		// end account

	}

?>