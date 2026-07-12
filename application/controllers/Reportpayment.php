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
		echo 'Report Pembelian';die();
	}

	// Report Hutang Jatuh Tempo
	public function reportdebtduedate()
	{
		$modul = 'Report';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->view == 'Y'){
			$supplier_list['supplier_list'] = $this->masterdata_model->supplier_list();
			$check_auth['check_auth'] = $check_auth;
			$data['data'] = array_merge($supplier_list, $check_auth);
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
		if($check_auth['check_access'][0]->view == 'Y'){
			$start_date       = $this->input->get('start_date');
			$end_date 	      = $this->input->get('end_date');
			$supplier_report  = $this->input->get('supplier_report');

			$excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
			$sheet = $excel->getActiveSheet();

			// ===== JUDUL =====
			$sheet->setCellValue('A1', "LAPORAN HUTANG JATUH TEMPO");
			$sheet->mergeCells('A1:H1');
			$sheet->getStyle('A1')->applyFromArray([
				'font'      => ['bold' => true, 'size' => 14, 'color' => ['argb' => 'FFFFFFFF']],
				'fill'      => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF1F4E79']],
				'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
			]);
			$sheet->getRowDimension(1)->setRowHeight(32);

			// ===== PERIODE =====
			$sheet->setCellValue('A2', "Periode: " . $start_date . "  s/d  " . $end_date);
			$sheet->mergeCells('A2:H2');
			$sheet->getStyle('A2')->applyFromArray([
				'font'      => ['italic' => true, 'size' => 10, 'color' => ['argb' => 'FF1F4E79']],
				'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
				'fill'      => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFD6E4F0']],
			]);
			$sheet->getRowDimension(2)->setRowHeight(20);

			// ===== HEADER KOLOM =====
			$headerStyle = [
				'font'      => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
				'fill'      => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF2E75B6']],
				'alignment' => ['horizontal' => 'center', 'vertical' => 'center', 'wrapText' => true],
				'borders'   => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => 'FFFFFFFF']]],
			];
			$sheet->getStyle('A3:H3')->applyFromArray($headerStyle);
			$sheet->getRowDimension(3)->setRowHeight(28);

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
			$color_toggle = true;
			foreach($data as $row){
				$sheet->setCellValue('A'.$i, $row['hd_purchase_invoice']);
				$sheet->setCellValue('B'.$i, $row['hd_purchase_due_date']);
				$sheet->setCellValue('C'.$i, $row['hd_purchase_date']);
				$sheet->setCellValue('D'.$i, $row['supplier_name']);
				$sheet->setCellValue('E'.$i, $row['supplier_phone']);
				$sheet->setCellValue('F'.$i, $row['hd_purchase_grand_total']);
				$sheet->setCellValue('G'.$i, $row['hd_purchase_dp']);
				$sheet->setCellValue('H'.$i, $row['hd_purchase_remaining_debt']);
				$rowBgColor = $color_toggle ? 'FFDCE6F1' : 'FFFFFFFF';
				$color_toggle = !$color_toggle;
				$sheet->getStyle('A'.$i.':H'.$i)->applyFromArray([
					'fill'    => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => $rowBgColor]],
					'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => 'FFB8CCE4']]],
					'alignment' => ['vertical' => 'center'],
				]);
				$sheet->getRowDimension($i)->setRowHeight(18);
				$i++;
			}

			// ===== LEBAR KOLOM =====
			$sheet->getColumnDimension('A')->setWidth(35);
			$sheet->getColumnDimension('B')->setWidth(22);
			$sheet->getColumnDimension('C')->setWidth(22);
			$sheet->getColumnDimension('D')->setWidth(35);
			$sheet->getColumnDimension('E')->setWidth(20);
			$sheet->getColumnDimension('F')->setWidth(22);
			$sheet->getColumnDimension('G')->setWidth(18);
			$sheet->getColumnDimension('H')->setWidth(22);

			// ===== FORMAT ANGKA =====
			if ($i > 4) {
				$lastRow = $i - 1;
				$sheet->getStyle('F4:H'.$lastRow)->getNumberFormat()->setFormatCode('#,##0');
			}

			$sheet->freezePane('A4');
			$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
			$sheet->setTitle("Hutang Jatuh Tempo");
			ob_end_clean();
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="laporan_hutang_jatuh_tempo_' . date('Y-m-d') . '.xlsx"');
			header('Cache-Control: max-age=0');
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
		if($check_auth['check_access'][0]->view == 'Y'){
			$customer_list['customer_list'] = $this->masterdata_model->customer_list();
			$check_auth['check_auth'] = $check_auth;
			$data['data'] = array_merge($customer_list, $check_auth);
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
		if($check_auth['check_access'][0]->view == 'Y'){
			$start_date       = $this->input->get('start_date');
			$end_date 	      = $this->input->get('end_date');
			$customer_report  = $this->input->get('customer_report');

			$excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
			$sheet = $excel->getActiveSheet();

			// ===== JUDUL =====
			$sheet->setCellValue('A1', "LAPORAN PIUTANG JATUH TEMPO");
			$sheet->mergeCells('A1:H1');
			$sheet->getStyle('A1')->applyFromArray([
				'font'      => ['bold' => true, 'size' => 14, 'color' => ['argb' => 'FFFFFFFF']],
				'fill'      => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF1F4E79']],
				'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
			]);
			$sheet->getRowDimension(1)->setRowHeight(32);

			// ===== PERIODE =====
			$sheet->setCellValue('A2', "Periode: " . $start_date . "  s/d  " . $end_date);
			$sheet->mergeCells('A2:H2');
			$sheet->getStyle('A2')->applyFromArray([
				'font'      => ['italic' => true, 'size' => 10, 'color' => ['argb' => 'FF1F4E79']],
				'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
				'fill'      => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFD6E4F0']],
			]);
			$sheet->getRowDimension(2)->setRowHeight(20);

			// ===== HEADER KOLOM =====
			$headerStyle = [
				'font'      => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
				'fill'      => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF2E75B6']],
				'alignment' => ['horizontal' => 'center', 'vertical' => 'center', 'wrapText' => true],
				'borders'   => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => 'FFFFFFFF']]],
			];
			$sheet->getStyle('A3:H3')->applyFromArray($headerStyle);
			$sheet->getRowDimension(3)->setRowHeight(28);

			$sheet->setCellValue('A3', "Invoice");
			$sheet->setCellValue('B3', "Tanggal Jatuh Tempo");
			$sheet->setCellValue('C3', "Tanggal Penjualan");
			$sheet->setCellValue('D3', "Pelanggan");
			$sheet->setCellValue('E3', "No Telpon");
			$sheet->setCellValue('F3', "Total Nota");
			$sheet->setCellValue('G3', "DP 1");
			$sheet->setCellValue('H3', "Total Piutang");

			$data = $this->reportpayment_model->get_report_repayment_date($start_date, $end_date, $customer_report)->result_array();
			$i = 4;
			$color_toggle = true;
			foreach($data as $row){
				$sheet->setCellValue('A'.$i, $row['hd_sales_inv']);
				$sheet->setCellValue('B'.$i, $row['hd_sales_due_date']);
				$sheet->setCellValue('C'.$i, $row['hd_sales_date']);
				$sheet->setCellValue('D'.$i, $row['customer_name']);
				$sheet->setCellValue('E'.$i, $row['customer_phone']);
				$sheet->setCellValue('F'.$i, $row['hd_sales_total']);
				$sheet->setCellValue('G'.$i, $row['hd_sales_dp']);
				$sheet->setCellValue('H'.$i, $row['hd_sales_remaining_debt']);
				$rowBgColor = $color_toggle ? 'FFDCE6F1' : 'FFFFFFFF';
				$color_toggle = !$color_toggle;
				$sheet->getStyle('A'.$i.':H'.$i)->applyFromArray([
					'fill'    => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => $rowBgColor]],
					'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => 'FFB8CCE4']]],
					'alignment' => ['vertical' => 'center'],
				]);
				$sheet->getRowDimension($i)->setRowHeight(18);
				$i++;
			}

			// ===== LEBAR KOLOM =====
			$sheet->getColumnDimension('A')->setWidth(35);
			$sheet->getColumnDimension('B')->setWidth(22);
			$sheet->getColumnDimension('C')->setWidth(22);
			$sheet->getColumnDimension('D')->setWidth(35);
			$sheet->getColumnDimension('E')->setWidth(20);
			$sheet->getColumnDimension('F')->setWidth(22);
			$sheet->getColumnDimension('G')->setWidth(18);
			$sheet->getColumnDimension('H')->setWidth(22);

			// ===== FORMAT ANGKA =====
			if ($i > 4) {
				$lastRow = $i - 1;
				$sheet->getStyle('F4:H'.$lastRow)->getNumberFormat()->setFormatCode('#,##0');
			}

			$sheet->freezePane('A4');
			$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
			$sheet->setTitle("Piutang Jatuh Tempo");
			ob_end_clean();
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="laporan_piutang_jatuh_tempo_' . date('Y-m-d') . '.xlsx"');
			header('Cache-Control: max-age=0');
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
		if($check_auth['check_access'][0]->view == 'Y'){
			$supplier_list['supplier_list'] = $this->masterdata_model->supplier_list();
			$check_auth['check_auth'] = $check_auth;
			$data['data'] = array_merge($supplier_list, $check_auth);
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
		$status  		  = $this->input->get('status');

		$data['data'] = $this->reportpayment_model->get_report_repayment($start_date, $end_date, $supplier_report, $status)->result_array();
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
		if($check_auth['check_access'][0]->view == 'Y'){
			$start_date       = $this->input->get('start_date');
			$end_date 	      = $this->input->get('end_date');
			$supplier_report  = $this->input->get('supplier_report');
			$status  		  = $this->input->get('status');

			$excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
			$sheet = $excel->getActiveSheet();

			// ===== JUDUL =====
			$sheet->setCellValue('A1', "LAPORAN PEMBAYARAN HUTANG");
			$sheet->mergeCells('A1:G1');
			$sheet->getStyle('A1')->applyFromArray([
				'font'      => ['bold' => true, 'size' => 14, 'color' => ['argb' => 'FFFFFFFF']],
				'fill'      => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF1F4E79']],
				'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
			]);
			$sheet->getRowDimension(1)->setRowHeight(32);

			// ===== PERIODE =====
			$sheet->setCellValue('A2', "Periode: " . $start_date . "  s/d  " . $end_date);
			$sheet->mergeCells('A2:G2');
			$sheet->getStyle('A2')->applyFromArray([
				'font'      => ['italic' => true, 'size' => 10, 'color' => ['argb' => 'FF1F4E79']],
				'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
				'fill'      => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFD6E4F0']],
			]);
			$sheet->getRowDimension(2)->setRowHeight(20);

			// ===== HEADER KOLOM =====
			$headerStyle = [
				'font'      => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
				'fill'      => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF2E75B6']],
				'alignment' => ['horizontal' => 'center', 'vertical' => 'center', 'wrapText' => true],
				'borders'   => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => 'FFFFFFFF']]],
			];
			$sheet->getStyle('A3:G3')->applyFromArray($headerStyle);
			$sheet->getRowDimension(3)->setRowHeight(28);

			$sheet->setCellValue('A3', "Invoice");
			$sheet->setCellValue('B3', "Nama Supplier");
			$sheet->setCellValue('C3', "Tanggal Pembayaran");
			$sheet->setCellValue('D3', "Metode Pembayaran");
			$sheet->setCellValue('E3', "Jlh Nota");
			$sheet->setCellValue('F3', "Total Bayar");
			$sheet->setCellValue('G3', "Status");

			$data = $this->reportpayment_model->get_report_repayment($start_date, $end_date, $supplier_report, $status)->result_array();
			$i = 4;
			$color_toggle = true;
			foreach($data as $row){
				$sheet->setCellValue('A'.$i, $row['payment_debt_invoice']);
				$sheet->setCellValue('B'.$i, $row['supplier_name']);
				$sheet->setCellValue('C'.$i, $row['payment_debt_date']);
				$sheet->setCellValue('D'.$i, $row['payment_name']);
				$sheet->setCellValue('E'.$i, $row['payment_debt_total_nota']);
				$sheet->setCellValue('F'.$i, $row['payment_debt_total_pay']);
				$sheet->setCellValue('G'.$i, $row['status']);
				$rowBgColor = $color_toggle ? 'FFDCE6F1' : 'FFFFFFFF';
				$color_toggle = !$color_toggle;
				$sheet->getStyle('A'.$i.':G'.$i)->applyFromArray([
					'fill'    => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => $rowBgColor]],
					'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => 'FFB8CCE4']]],
					'alignment' => ['vertical' => 'center'],
				]);
				$sheet->getRowDimension($i)->setRowHeight(18);
				$i++;
			}

			// ===== LEBAR KOLOM =====
			$sheet->getColumnDimension('A')->setWidth(35);
			$sheet->getColumnDimension('B')->setWidth(30);
			$sheet->getColumnDimension('C')->setWidth(22);
			$sheet->getColumnDimension('D')->setWidth(25);
			$sheet->getColumnDimension('E')->setWidth(18);
			$sheet->getColumnDimension('F')->setWidth(22);
			$sheet->getColumnDimension('G')->setWidth(15);

			// ===== FORMAT ANGKA =====
			if ($i > 4) {
				$lastRow = $i - 1;
				$sheet->getStyle('F4:F'.$lastRow)->getNumberFormat()->setFormatCode('#,##0');
			}

			$sheet->freezePane('A4');
			$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
			$sheet->setTitle("Pembayaran Hutang");
			ob_end_clean();
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="laporan_pembayaran_hutang_' . date('Y-m-d') . '.xlsx"');
			header('Cache-Control: max-age=0');
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
		if($check_auth['check_access'][0]->view == 'Y'){
			$supplier_list['customer_list'] = $this->masterdata_model->customer_list();
			$check_auth['check_auth'] = $check_auth;
			$data['data'] = array_merge($supplier_list, $check_auth);
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
		$status  		  = $this->input->get('status');

		$data['data'] = $this->reportpayment_model->get_report_piutang($start_date, $end_date, $customer_report, $status)->result_array();
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
		if($check_auth['check_access'][0]->view == 'Y'){
			$start_date       = $this->input->get('start_date');
			$end_date 	      = $this->input->get('end_date');
			$customer_report  = $this->input->get('customer_report');
			$status  		  = $this->input->get('status');

			$excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
			$sheet = $excel->getActiveSheet();

			// ===== JUDUL =====
			$sheet->setCellValue('A1', "LAPORAN PEMBAYARAN PIUTANG");
			$sheet->mergeCells('A1:G1');
			$sheet->getStyle('A1')->applyFromArray([
				'font'      => ['bold' => true, 'size' => 14, 'color' => ['argb' => 'FFFFFFFF']],
				'fill'      => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF1F4E79']],
				'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
			]);
			$sheet->getRowDimension(1)->setRowHeight(32);

			// ===== PERIODE =====
			$sheet->setCellValue('A2', "Periode: " . $start_date . "  s/d  " . $end_date);
			$sheet->mergeCells('A2:G2');
			$sheet->getStyle('A2')->applyFromArray([
				'font'      => ['italic' => true, 'size' => 10, 'color' => ['argb' => 'FF1F4E79']],
				'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
				'fill'      => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFD6E4F0']],
			]);
			$sheet->getRowDimension(2)->setRowHeight(20);

			// ===== HEADER KOLOM =====
			$headerStyle = [
				'font'      => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
				'fill'      => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF2E75B6']],
				'alignment' => ['horizontal' => 'center', 'vertical' => 'center', 'wrapText' => true],
				'borders'   => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => 'FFFFFFFF']]],
			];
			$sheet->getStyle('A3:G3')->applyFromArray($headerStyle);
			$sheet->getRowDimension(3)->setRowHeight(28);

			$sheet->setCellValue('A3', "Invoice");
			$sheet->setCellValue('B3', "Nama Pelanggan");
			$sheet->setCellValue('C3', "Tanggal Pembayaran");
			$sheet->setCellValue('D3', "Metode Pembayaran");
			$sheet->setCellValue('E3', "Jlh Nota");
			$sheet->setCellValue('F3', "Total Bayar");
			$sheet->setCellValue('G3', "Status");

			$data = $this->reportpayment_model->get_report_piutang($start_date, $end_date, $customer_report, $status)->result_array();
			$i = 4;
			$color_toggle = true;
			foreach($data as $row){
				$sheet->setCellValue('A'.$i, $row['payment_receivable_invoice']);
				$sheet->setCellValue('B'.$i, $row['customer_name']);
				$sheet->setCellValue('C'.$i, $row['payment_receivable_date']);
				$sheet->setCellValue('D'.$i, $row['payment_name']);
				$sheet->setCellValue('E'.$i, $row['payment_receivable_total_nota']);
				$sheet->setCellValue('F'.$i, $row['payment_receivable_total_pay']);
				$sheet->setCellValue('G'.$i, $row['status']);
				$rowBgColor = $color_toggle ? 'FFDCE6F1' : 'FFFFFFFF';
				$color_toggle = !$color_toggle;
				$sheet->getStyle('A'.$i.':G'.$i)->applyFromArray([
					'fill'    => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => $rowBgColor]],
					'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => 'FFB8CCE4']]],
					'alignment' => ['vertical' => 'center'],
				]);
				$sheet->getRowDimension($i)->setRowHeight(18);
				$i++;
			}

			// ===== LEBAR KOLOM =====
			$sheet->getColumnDimension('A')->setWidth(35);
			$sheet->getColumnDimension('B')->setWidth(30);
			$sheet->getColumnDimension('C')->setWidth(22);
			$sheet->getColumnDimension('D')->setWidth(25);
			$sheet->getColumnDimension('E')->setWidth(18);
			$sheet->getColumnDimension('F')->setWidth(22);
			$sheet->getColumnDimension('G')->setWidth(15);

			// ===== FORMAT ANGKA =====
			if ($i > 4) {
				$lastRow = $i - 1;
				$sheet->getStyle('F4:F'.$lastRow)->getNumberFormat()->setFormatCode('#,##0');
			}

			$sheet->freezePane('A4');
			$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
			$sheet->setTitle("Pembayaran Piutang");
			ob_end_clean();
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="laporan_pembayaran_piutang_' . date('Y-m-d') . '.xlsx"');
			header('Cache-Control: max-age=0');
			$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($excel);
			exit($xlsxWriter->save('php://output'));
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

}

?>