<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");

class Globalext extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->model('auth_model');
		$this->load->model('global_model');
		$this->load->helper(array('url', 'html'));
	}

	public function index()
    {
		echo "Global";
	}

   	public function search_product_purchase()
	{	
		$supplier_id = $this->input->get('supid');
		$keyword = $this->input->get('term');
		$result = ['success' => FALSE, 'num_product' => 0, 'data' => [], 'message' => ''];
		if (!($keyword == '' || $keyword == NULL)) {
			$find = $this->global_model->search_product_purchase($keyword, $supplier_id)->result_array();
			$find_result = [];
			foreach ($find as $row) {
				$diplay_text = $row['product_code'].' - '.$row['product_name'].' - '.$row['unit_name'];
				$find_result[] = [
					'id'                  => $row['product_id'],
					'value'               => $diplay_text,
					'product_code'        => $row['product_code'],
					'product_price'       => $row['product_price']
				];
			}
			$result = ['success' => TRUE, 'num_product' => count($find_result), 'data' => $find_result, 'message' => ''];
		}
		echo json_encode($result);
	} 

	



}

?>