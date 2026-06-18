<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");

class Search extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->model('global_model');
		$this->load->model('masterdata_model');
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
		$modul = 'Search';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_auth_nav'][0]->view == 'Y'){
			$check_auth['check_auth'] = $check_auth;
			$unit_list['unit_list'] = $this->masterdata_model->unit_list();
			$brand_list['brand_list'] = $this->masterdata_model->brand_list();
			$category_list['category_list'] = $this->masterdata_model->category_list();
			$supplier_list['supplier_list'] = $this->masterdata_model->supplier_list();
			$data['data'] = array_merge($unit_list, $brand_list, $category_list, $supplier_list, $check_auth);	
			$this->load->view('Pages/Search/search', $data);
		}else{
			print_r('Tidak Ada Akses');die();
		}
	}

	public function product_list(){
		
		$searchin_key = $this->input->post('key');
		$unit		  = $this->input->post('unit');
		$category 	  = $this->input->post('category');
		$brand 	      = $this->input->post('brand');
		$supplier 	  = $this->input->post('supplier');
		$status 	  = $this->input->post('status');
		$paket 		  = $this->input->post('paket');
		$ppn 		  = $this->input->post('ppn');
		$sort         = $this->input->post('sort');
		$limit        = (int)$this->input->post('limit', true) ?: 50;
		$page         = (int)$this->input->post('page', true) ?: 1;
		$offset       = ($page - 1) * $limit;

		$product_list = $this->masterdata_model->search_product_list($searchin_key, $unit, $category, $brand, $supplier, $status, $paket, $ppn, $sort, $limit, $offset)->result_array();
		$total_items = $this->masterdata_model->search_product_list_count($searchin_key, $unit, $category, $brand, $supplier, $status, $paket, $ppn);
		$total_pages = ceil($total_items / $limit);
		
		$response = array(
			'data' => $product_list,
			'total_items' => $total_items,
			'total_pages' => $total_pages,
			'current_page' => $page,
			'items_per_page' => $limit
		);
		
		echo json_encode($response);
	}

	public function detailsearch(){
		$id = $this->input->get('id');
		$get_product_by_id['get_product_by_id'] = $this->masterdata_model->settingproduct($id);
		$product_stock['product_stock'] = $this->masterdata_model->product_stock($id);
		$data['data'] = array_merge($get_product_by_id, $product_stock);
		if($get_product_by_id['get_product_by_id'] == null){
			print_r("Barang Tidak Ada Di Gudang");die();
		}else{
			$this->load->view('Pages/Search/detailsearch', $data);
		}
		
	}

	public function search_item_selected(){
		$item_id = $this->input->post('item_id');
		$item_data = $this->masterdata_model->search_item_selected($item_id);
		echo json_encode($item_data);
	}

	public function search_item_selected_details(){
		$item_id = $this->input->post('item_id');
		$item_data = $this->masterdata_model->search_item_selected_details($item_id);
		$stock_data = $this->masterdata_model->product_stock($item_id);
		echo json_encode(['item' => $item_data, 'stocks' => $stock_data]);
	}

}
