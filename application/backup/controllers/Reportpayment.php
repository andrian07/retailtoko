<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
date_default_timezone_set('Asia/Jakarta');
require 'vendor/autoload.php';

use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Reportpayment extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('global_model');
		$this->load->model('reportpayment_model');
		$this->load->model('masterdata_model');
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

	public function index(){
		echo 'Report Pembelian';die();
	}

	// Report Hutang Jatuh Tempo
	public function reportdebtduedate()
	{
		$modul = 'Report';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$warehouse_list['warehouse_list'] = $this->masterdata_model->warehouse_list();
			$supplier_list['supplier_list'] = $this->masterdata_model->supplier_list();
			$data['data'] = array_merge($warehouse_list, $supplier_list);
			$this->load->view('Pages/Report/Payment/reportdebtduedate', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function reportdebtduedatepdf()
	{
		$start_date       = $this->input->get('start_date');
		$end_date 	      = $this->input->get('end_date');
		$supplier_report  = $this->input->get('supplier_report');

		$data['data'] = $this->reportpayment_model->get_report_duedate($start_date, $end_date, $supplier_report)->result_array();
		$htmlView   = $this->load->view('Pages/Report/Payment/reportdebtduedatepdf', $data, true);
		$dompdf = new Dompdf();
		$dompdf->loadHtml($htmlView);
		$dompdf->setPaper('A4', 'landscape');
		$dompdf->render();
		$dompdf->stream('hutangjatuhtempo.pdf', array("Attachment" => false));
		exit();
	}

	public function reportdebtduedate_excell(){
		$modul = 'Report';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$start_date       = $this->input->get('start_date');
			$end_date 	      = $this->input->get('end_date');
			$supplier_report  = $this->input->get('supplier_report');

			$excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
			$sheet = $excel->getActiveSheet();
			$sheet->setCellValue('A1', "Laporan Hutang Jatuh Tempo"); 
			$sheet->mergeCells('A1:I1');
			$sheet->getStyle('A1')->getFont()->setBold(true);
			$sheet->getStyle('A3:H3')->getFont()->setBold(true);
			$sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
			$sheet->getStyle('A3:H3')->getAlignment()->setHorizontal('center');
			$sheet->setCellValue('A3', "Invoice"); 
			$sheet->setCellValue('B3', "Tanggal Jatuh Tempo"); 
			$sheet->setCellValue('C3', "Tanggal Pembelian"); 
			$sheet->setCellValue('D3', "Supplier");
			$sheet->setCellValue('E3', "No Telpon");
			$sheet->setCellValue('F3', "Total Nota");
			$sheet->setCellValue('G3', "DP 1");
			$sheet->setCellValue('H3', "Total Hutang");
			$data = $this->reportpayment_model->get_report_duedate($start_date, $end_date, $supplier_report)->result_array();
			$i = 4;
			foreach($data as $row){
				$sheet->setCellValue('A'.$i, $row['hd_purchase_invoice']); 
				$sheet->setCellValue('B'.$i, $row['hd_purchase_due_date']); 
				$sheet->setCellValue('C'.$i, $row['hd_purchase_date']);
				$sheet->setCellValue('D'.$i, $row['supplier_name']); 
				$sheet->setCellValue('E'.$i, $row['supplier_phone']); 
				$sheet->setCellValue('F'.$i, $row['hd_purchase_grand_total']);
				$sheet->setCellValue('G'.$i, $row['hd_purchase_dp']); 
				$sheet->setCellValue('H'.$i, $row['hd_purchase_remaining_debt']); 
				$i++;
			}
			$sheet->getColumnDimension('A')->setWidth(35); 
			$sheet->getColumnDimension('B')->setWidth(35); 
			$sheet->getColumnDimension('C')->setWidth(35);
			$sheet->getColumnDimension('D')->setWidth(40);
			$sheet->getColumnDimension('E')->setWidth(30);
			$sheet->getColumnDimension('F')->setWidth(30);
			$sheet->getColumnDimension('G')->setWidth(30);
			$sheet->getColumnDimension('H')->setWidth(30);

			$sheet->getStyle('F')->getNumberFormat()->setFormatCode('#,##0');	
			$sheet->getStyle('G')->getNumberFormat()->setFormatCode('#,##0');
			$sheet->getStyle('H')->getNumberFormat()->setFormatCode('#,##0');

			$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
			$sheet->setTitle("Excell");
			ob_end_clean();
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="laporan_hutang_jatuh_tempo_' .date('Y-m-d') . '.xlsx"');
			header('Cache-Control: max-age=0');

			$xlsxWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($excel, 'Xlsx');
			$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($excel);
			exit($xlsxWriter->save('php://output'));
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}
	// End Report Hutang Jatuh Tempo



	// Report Piutang Jatuh Tempo
	public function reportrepaymentduedate()
	{
		$modul = 'Report';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$warehouse_list['warehouse_list'] = $this->masterdata_model->warehouse_list();
			$customer_list['customer_list'] = $this->masterdata_model->customer_list();
			$data['data'] = array_merge($warehouse_list, $customer_list);
			$this->load->view('Pages/Report/Payment/reportrepaymentduedate', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function reportrepaymentduedatepdf()
	{
		$start_date       = $this->input->get('start_date');
		$end_date 	      = $this->input->get('end_date');
		$customer_report  = $this->input->get('customer_report');

		$data['data'] = $this->reportpayment_model->get_report_repayment_date($start_date, $end_date, $customer_report)->result_array();
		$htmlView   = $this->load->view('Pages/Report/Payment/reportrepaymentduedatepdf', $data, true);
		$dompdf = new Dompdf();
		$dompdf->loadHtml($htmlView);
		$dompdf->setPaper('A4', 'landscape');
		$dompdf->render();
		$dompdf->stream('piutangjatuhtempo.pdf', array("Attachment" => false));
		exit();
	}

	public function reportrepaymentduedate_excell(){
		$modul = 'Report';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$start_date       = $this->input->get('start_date');
			$end_date 	      = $this->input->get('end_date');
			$customer_report  = $this->input->get('customer_report');

			$excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
			$sheet = $excel->getActiveSheet();
			$sheet->setCellValue('A1', "Laporan Piutang Jatuh Tempo"); 
			$sheet->mergeCells('A1:I1');
			$sheet->getStyle('A1')->getFont()->setBold(true);
			$sheet->getStyle('A3:H3')->getFont()->setBold(true);
			$sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
			$sheet->getStyle('A3:H3')->getAlignment()->setHorizontal('center');
			$sheet->setCellValue('A3', "Invoice"); 
			$sheet->setCellValue('B3', "Tanggal Jatuh Tempo"); 
			$sheet->setCellValue('C3', "Tanggal Penjualan"); 
			$sheet->setCellValue('D3', "Pelanggan");
			$sheet->setCellValue('E3', "No Telpon");
			$sheet->setCellValue('F3', "Total Nota");
			$sheet->setCellValue('G3', "DP 1");
			$sheet->setCellValue('H3', "Total Hutang");
			$data = $this->reportpayment_model->get_report_repayment_date($start_date, $end_date, $customer_report)->result_array();
			$i = 4;
			foreach($data as $row){
				$sheet->setCellValue('A'.$i, $row['hd_sales_inv']); 
				$sheet->setCellValue('B'.$i, $row['hd_sales_due_date']); 
				$sheet->setCellValue('C'.$i, $row['hd_sales_date']);
				$sheet->setCellValue('D'.$i, $row['customer_name']); 
				$sheet->setCellValue('E'.$i, $row['customer_phone']); 
				$sheet->setCellValue('F'.$i, $row['hd_sales_total']);
				$sheet->setCellValue('G'.$i, $row['hd_sales_dp']); 
				$sheet->setCellValue('H'.$i, $row['hd_sales_remaining_debt']); 
				$i++;
			}
			$sheet->getColumnDimension('A')->setWidth(35); 
			$sheet->getColumnDimension('B')->setWidth(35); 
			$sheet->getColumnDimension('C')->setWidth(35);
			$sheet->getColumnDimension('D')->setWidth(40);
			$sheet->getColumnDimension('E')->setWidth(30);
			$sheet->getColumnDimension('F')->setWidth(30);
			$sheet->getColumnDimension('G')->setWidth(30);
			$sheet->getColumnDimension('H')->setWidth(30);

			$sheet->getStyle('F')->getNumberFormat()->setFormatCode('#,##0');	
			$sheet->getStyle('G')->getNumberFormat()->setFormatCode('#,##0');
			$sheet->getStyle('H')->getNumberFormat()->setFormatCode('#,##0');

			$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
			$sheet->setTitle("Excell");
			ob_end_clean();
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="laporan_piutang_jatuh_tempo_' .date('Y-m-d') . '.xlsx"');
			header('Cache-Control: max-age=0');

			$xlsxWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($excel, 'Xlsx');
			$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($excel);
			exit($xlsxWriter->save('php://output'));
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}
	// End Report Piutang Jatuh Tempo


	// start report payment hutang

	public function reportrepayments()
	{
		$modul = 'Report';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$warehouse_list['warehouse_list'] = $this->masterdata_model->warehouse_list();
			$supplier_list['supplier_list'] = $this->masterdata_model->supplier_list();
			$data['data'] = array_merge($warehouse_list, $supplier_list);
			$this->load->view('Pages/Report/Payment/reportrepayment', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}
	public function reportrepaymentpdf()
	{
		$start_date       = $this->input->get('start_date');
		$end_date 	      = $this->input->get('end_date');
		$supplier_report  = $this->input->get('supplier_report');

		$data['data'] = $this->reportpayment_model->get_report_repayment($start_date, $end_date, $supplier_report)->result_array();
		$htmlView   = $this->load->view('Pages/Report/Payment/reportrepaymentpdf', $data, true);
		$dompdf = new Dompdf();
		$dompdf->loadHtml($htmlView);
		$dompdf->setPaper('A4', 'landscape');
		$dompdf->render();
		$dompdf->stream('pembayaranhutang.pdf', array("Attachment" => false));
		exit();
	}

	public function reportrepayment_excell(){
		$modul = 'Report';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$start_date       = $this->input->get('start_date');
			$end_date 	      = $this->input->get('end_date');
			$supplier_report  = $this->input->get('supplier_report');

			$excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
			$sheet = $excel->getActiveSheet();
			$sheet->setCellValue('A1', "Laporan Pembayaran Hutang"); 
			$sheet->mergeCells('A1:G1');
			$sheet->getStyle('A1')->getFont()->setBold(true);
			$sheet->getStyle('A3:G3')->getFont()->setBold(true);
			$sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
			$sheet->getStyle('A3:G3')->getAlignment()->setHorizontal('center');
			$sheet->setCellValue('A3', "Invoice"); 
			$sheet->setCellValue('B3', "Nama Supplier"); 
			$sheet->setCellValue('C3', "Tanggal Pembayaran"); 
			$sheet->setCellValue('D3', "Metode Pembayaran");
			$sheet->setCellValue('E3', "Jlh Nota");
			$sheet->setCellValue('F3', "Total Bayar");
			$sheet->setCellValue('G3', "Status");
			$data = $this->reportpayment_model->get_report_repayment($start_date, $end_date, $supplier_report)->result_array();
			$i = 4;
			foreach($data as $row){
				$sheet->setCellValue('A'.$i, $row['payment_debt_invoice']); 
				$sheet->setCellValue('B'.$i, $row['supplier_name']); 
				$sheet->setCellValue('C'.$i, $row['payment_debt_date']);
				$sheet->setCellValue('D'.$i, $row['payment_name']); 
				$sheet->setCellValue('E'.$i, $row['payment_debt_total_nota']); 
				$sheet->setCellValue('F'.$i, $row['payment_debt_total_pay']);
				$sheet->setCellValue('G'.$i, $row['status']); 
				$i++;
			}
			$sheet->getColumnDimension('A')->setWidth(35); 
			$sheet->getColumnDimension('B')->setWidth(35); 
			$sheet->getColumnDimension('C')->setWidth(35);
			$sheet->getColumnDimension('D')->setWidth(40);
			$sheet->getColumnDimension('E')->setWidth(30);
			$sheet->getColumnDimension('F')->setWidth(30);
			$sheet->getColumnDimension('G')->setWidth(30);

			$sheet->getStyle('F')->getNumberFormat()->setFormatCode('#,##0');	

			$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
			$sheet->setTitle("Excell");
			ob_end_clean();
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="laporan_pembayaran_hutang_' .date('Y-m-d') . '.xlsx"');
			header('Cache-Control: max-age=0');

			$xlsxWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($excel, 'Xlsx');
			$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($excel);
			exit($xlsxWriter->save('php://output'));
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}
	// end report payment hutang

	public function reportpiutang()
	{
		$modul = 'Report';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$warehouse_list['warehouse_list'] = $this->masterdata_model->warehouse_list();
			$supplier_list['customer_list'] = $this->masterdata_model->customer_list();
			$data['data'] = array_merge($warehouse_list, $supplier_list);
			$this->load->view('Pages/Report/Payment/reportpiutang', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function reportpiutangpdf()
	{
		$start_date       = $this->input->get('start_date');
		$end_date 	      = $this->input->get('end_date');
		$customer_report  = $this->input->get('customer_report');

		$data['data'] = $this->reportpayment_model->get_report_piutang($start_date, $end_date, $customer_report)->result_array();
		$htmlView   = $this->load->view('Pages/Report/Payment/reportpiutangpdf', $data, true);
		$dompdf = new Dompdf();
		$dompdf->loadHtml($htmlView);
		$dompdf->setPaper('A4', 'landscape');
		$dompdf->render();
		$dompdf->stream('pembayaranpiutang.pdf', array("Attachment" => false));
		exit();
	}

	public function reportpiutang_excell(){
		$modul = 'Report';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$start_date       = $this->input->get('start_date');
			$end_date 	      = $this->input->get('end_date');
			$customer_report  = $this->input->get('customer_report');

			$excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
			$sheet = $excel->getActiveSheet();
			$sheet->setCellValue('A1', "Laporan Pembayaran Piutang"); 
			$sheet->mergeCells('A1:G1');
			$sheet->getStyle('A1')->getFont()->setBold(true);
			$sheet->getStyle('A3:G3')->getFont()->setBold(true);
			$sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
			$sheet->getStyle('A3:G3')->getAlignment()->setHorizontal('center');
			$sheet->setCellValue('A3', "Invoice"); 
			$sheet->setCellValue('B3', "Nama Pelanggan"); 
			$sheet->setCellValue('C3', "Tanggal Pembayaran"); 
			$sheet->setCellValue('D3', "Metode Pembayaran");
			$sheet->setCellValue('E3', "Jlh Nota");
			$sheet->setCellValue('F3', "Total Bayar");
			$sheet->setCellValue('G3', "Status");
			$data = $this->reportpayment_model->get_report_repayment($start_date, $end_date, $supplier_report)->result_array();
			$i = 4;
			foreach($data as $row){
				$sheet->setCellValue('A'.$i, $row['payment_receivable_invoice']); 
				$sheet->setCellValue('B'.$i, $row['customer_name']); 
				$sheet->setCellValue('C'.$i, $row['payment_receivable_date']);
				$sheet->setCellValue('D'.$i, $row['payment_name']); 
				$sheet->setCellValue('E'.$i, $row['payment_receivable_total_nota']); 
				$sheet->setCellValue('F'.$i, $row['payment_receivable_total_pay']);
				$sheet->setCellValue('G'.$i, $row['status']); 
				$i++;
			}
			$sheet->getColumnDimension('A')->setWidth(35); 
			$sheet->getColumnDimension('B')->setWidth(35); 
			$sheet->getColumnDimension('C')->setWidth(35);
			$sheet->getColumnDimension('D')->setWidth(40);
			$sheet->getColumnDimension('E')->setWidth(30);
			$sheet->getColumnDimension('F')->setWidth(30);
			$sheet->getColumnDimension('G')->setWidth(30);

			$sheet->getStyle('F')->getNumberFormat()->setFormatCode('#,##0');	

			$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
			$sheet->setTitle("Excell");
			ob_end_clean();
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="laporan_pembayaran_piutang_' .date('Y-m-d') . '.xlsx"');
			header('Cache-Control: max-age=0');

			$xlsxWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($excel, 'Xlsx');
			$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($excel);
			exit($xlsxWriter->save('php://output'));
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

}

?>