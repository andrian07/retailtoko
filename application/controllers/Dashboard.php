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
			redirect('Masterdata', 'refresh');
		}else{
			$user_role_id = $_SESSION['user_role_id'];
			$check_auth_nav = $this->global_model->check_auth_nav($user_role_id);
			$check_access = $this->global_model->check_access_dashboard($user_role_id);
			$array = array(
				'check_auth_nav' => $check_auth_nav,
				'check_access' => $check_access
			);
			return($array);
		}
	}

	// notifikasi lonceng: item yang stoknya sudah di bawah / sama dengan minimal stock
	public function notif_stock(){
		if(!isset($_SESSION['user_name'])){
			echo json_encode(['code'=>0, 'total'=>0, 'items'=>[]]);die();
		}
		$items = $this->global_model->dash_low_stock(5);
		$total = $this->global_model->dash_low_stock_count();
		$out = array();
		foreach($items as $row){
			$out[] = array(
				'name'  => $row['product_name'],
				'stock' => (float) $row['stock'],
				'min'   => (float) $row['product_min_stock'],
			);
		}
		echo json_encode(['code'=>200, 'total'=>(int) $total, 'items'=>$out]);
	}

	public function Admin(){
		$check_auth = $this->check_auth();
		$check_auth['check_auth'] = $check_auth;

		$today      = date('Y-m-d');
		$yesterday  = date('Y-m-d', strtotime('-1 day'));
		$month_start = date('Y-m-01');
		$last_month_start = date('Y-m-01', strtotime('first day of last month'));
		// bulan lalu dibandingkan di periode yang sama (tgl 1 s/d tanggal hari ini)
		$last_month_end = date('Y-m-d', min(strtotime($last_month_start.' +'.(date('j') - 1).' days'), strtotime(date('Y-m-t', strtotime($last_month_start)))));

		$sales_today      = $this->global_model->dash_sales_summary($today, $today);
		$sales_yesterday  = $this->global_model->dash_sales_summary($yesterday, $yesterday);
		$sales_month      = $this->global_model->dash_sales_summary($month_start, $today);
		$sales_last_month = $this->global_model->dash_sales_summary($last_month_start, $last_month_end);

		$dashboard = array(
			'today' => array(
				'total'  => $sales_today['total'],
				'trx'    => $sales_today['trx'],
				'qty'    => $this->global_model->dash_sales_item($today, $today)['qty'],
				'growth' => $this->growth($sales_today['total'], $sales_yesterday['total']),
			),
			'month' => array(
				'total'  => $sales_month['total'],
				'trx'    => $sales_month['trx'],
				'qty'    => $this->global_model->dash_sales_item($month_start, $today)['qty'],
				'growth' => $this->growth($sales_month['total'], $sales_last_month['total']),
			),
			'asset'         => $this->global_model->dash_stock_asset(),
			'activity'      => $this->activity_list(5),
			'chart'         => array('7' => $this->chart_data(7), '30' => $this->chart_data(30)),
			'top_product'   => $this->global_model->dash_top_product(5),
			'overdue'       => $this->global_model->dash_overdue_invoice(5),
			'overdue_count' => $this->global_model->dash_overdue_count(),
			'low_stock'     => $this->global_model->dash_low_stock(5),
		);

		$data['data'] = array_merge(array('dashboard' => $dashboard), $check_auth);
		$this->load->view('Pages/dashboard', $data);
	}

	private function growth($now, $before)
	{
		if($before <= 0){
			return null;
		}
		return round(($now - $before) / $before * 100);
	}

	private function chart_data($days)
	{
		$start = date('Y-m-d', strtotime('-'.($days - 1).' days'));
		$end   = date('Y-m-d');
		$rows  = $this->global_model->dash_sales_daily($start, $end);
		$by_date = array();
		foreach($rows as $row){
			$by_date[$row['tgl']] = $row;
		}

		$labels = array(); $totals = array(); $trx = array(); $sum = 0;
		for($i = 0; $i < $days; $i++){
			$d = date('Y-m-d', strtotime($start.' +'.$i.' days'));
			$labels[] = date('d M', strtotime($d));
			$totals[] = isset($by_date[$d]) ? (int) $by_date[$d]['total'] : 0;
			$trx[]    = isset($by_date[$d]) ? (int) $by_date[$d]['trx'] : 0;
			$sum += end($totals);
		}

		$prev_start = date('Y-m-d', strtotime($start.' -'.$days.' days'));
		$prev_end   = date('Y-m-d', strtotime($start.' -1 day'));
		$prev       = $this->global_model->dash_sales_summary($prev_start, $prev_end);

		return array(
			'labels' => $labels,
			'totals' => $totals,
			'trx'    => $trx,
			'sum'    => $sum,
			'avg'    => round($sum / $days),
			'growth' => $this->growth($sum, $prev['total']),
		);
	}

	private function activity_list($limit)
	{
		$types = array(
			'Penjualan POS'     => array('fas fa-cart-plus', 'green'),
			'Retur Penjualan'   => array('fas fa-undo', 'red'),
			'Retur Pembelian'   => array('fas fa-undo', 'red'),
			'Batalkan'          => array('fas fa-ban', 'red'),
			'Pelunasan'         => array('fas fa-credit-card', 'blue'),
			'Penjualan'         => array('fas fa-shopping-cart', 'green'),
			'Pembelian'         => array('fas fa-truck', 'purple'),
			'PO'                => array('fas fa-file-alt', 'purple'),
			'Opname'            => array('fas fa-clipboard-check', 'orange'),
			'Produk'            => array('fas fa-box', 'orange'),
		);

		$list = array();
		foreach($this->global_model->dash_last_activity($limit) as $row){
			$desc = trim(explode('Ref:', $row['activity_table_desc'])[0]);
			$inv  = $row['activity_table_ref'];
			if($inv == '' && preg_match('#\b([A-Z]{2,}/[A-Z0-9/]+)#', $row['activity_table_desc'], $m)){
				$inv = $m[1];
			}
			if($inv != ''){
				$desc = trim(str_replace($inv, '', $desc));
			}

			$icon = array('fas fa-bolt', 'gray');
			foreach($types as $keyword => $type){
				if(stripos($row['activity_table_desc'], $keyword) !== false){
					$icon = $type;
					break;
				}
			}

			$list[] = array(
				'time'   => $row['created_at'],
				'desc'   => $desc,
				'inv'    => $inv,
				'amount' => $inv != '' ? $this->global_model->dash_invoice_amount($inv) : null,
				'icon'   => $icon[0],
				'color'  => $icon[1],
			);
		}
		return $list;
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