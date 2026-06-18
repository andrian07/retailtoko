<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");

class Dashboard extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->model('global_model');
		$this->load->helper(array('url', 'html'));
	}

	public function index()
	{
		if(isset($_SESSION['user_name'] ) != null || isset($_SESSION['user_branch'] ) != null){
			redirect('Dashboard/Admin', 'refresh');
		}else{
			$this->load->view('Pages/login');
		}
	}

	private function check_auth(){
		if(isset($_SESSION['user_name']) == null){
			redirect('Dashboard', 'refresh');
		}
	}

	public function Admin(){
		$this->check_auth();
		$get_transaction_today['get_transaction_today'] = $this->global_model->get_transaction_today()->result_array();
		$get_transaction_today_item['get_transaction_today_item'] = $this->global_model->get_transaction_today_item()->result_array();
		$get_transaction_month['get_transaction_month'] = $this->global_model->get_transaction_month()->result_array();
		$get_transaction_month_item['get_transaction_month_item'] = $this->global_model->get_transaction_month_item()->result_array();
		$get_total_asset['get_total_asset'] = $this->global_model->get_total_asset()->result_array();
		$get_total_asset_item['get_total_asset_item'] = $this->global_model->get_total_asset_item()->result_array();
		$get_last_activity['get_last_activity'] = $this->global_model->get_last_activity()->result_array();
		$get_next_activity['get_next_activity'] = $this->global_model->get_next_activity()->result_array();
		$transfer_stock['transfer_stock'] = $this->global_model->transfer_stock()->result_array();
		$lost_faktur['lost_faktur'] = $this->global_model->lost_faktur()->result_array();
		$top_product_3_month['top_product_3_month'] = $this->global_model->top_product_3_month()->result_array();
		$get_note['get_note'] = $this->global_model->get_note()->result_array();
		$data['data'] = array_merge($get_transaction_today, $get_transaction_month, $get_transaction_today_item, $get_transaction_month_item, $get_total_asset, $get_total_asset_item, $get_last_activity, $get_next_activity, $transfer_stock, $lost_faktur, $top_product_3_month, $get_note);
		$this->load->view('Pages/dashboard', $data);
	}

	public function save_comment()
	{
		$comment = $this->input->post('comment');
		$insert = array(
			'ms_note_text'	=> $comment
		);
		$this->global_model->save_comment($insert);
		$msg = 'Success Tambah';
		echo json_encode(['code'=>200, 'result'=>$msg]);
	}

}

?>