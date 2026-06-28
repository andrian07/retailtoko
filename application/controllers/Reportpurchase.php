<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
date_default_timezone_set('Asia/Jakarta');
require 'vendor/autoload.php';

use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Reportpurchase extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('global_model');
		$this->load->model('reportpurchase_model');
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

	public function reportpo()
	{
		$modul = 'Report';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->view == 'Y'){
			$supplier_list['supplier_list'] = $this->masterdata_model->supplier_list();
			$check_auth['check_auth'] = $check_auth;
			$data['data'] = array_merge($supplier_list, $check_auth);
			$this->load->view('Pages/Report/Purchase/reportpo', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function reportpopdf()
	{
		$start_date       = $this->input->get('start_date');
		$end_date 	      = $this->input->get('end_date');
		$supplier_report  = $this->input->get('supplier_report');
		$status_pembelian = $this->input->get('status_pembelian');

		$data['data'] = $this->reportpurchase_model->get_report_hd_po($start_date, $end_date, $supplier_report, $status_pembelian)->result_array();
		$htmlView   = $this->load->view('Pages/Report/Purchase/reportpopdf', $data, true);
		$dompdf = new Dompdf();
		$dompdf->loadHtml($htmlView);
		$dompdf->setPaper('A4', 'landscape');
		$dompdf->render();
		$dompdf->stream('po.pdf', array("Attachment" => false));
		exit();
	}


	public function reportpo_excell()
	{

		$modul = 'Report';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->view == 'Y'){
			$start_date       = $this->input->get('start_date');
			$end_date 	      = $this->input->get('end_date');
			$supplier_report  = $this->input->get('supplier_report');
			$status_pembelian = $this->input->get('status_pembelian');

			$excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
			$sheet = $excel->getActiveSheet();
			$sheet->setCellValue('A1', "Laporan PO"); 
			$sheet->mergeCells('A1:R1');
			$sheet->getStyle('A1')->getFont()->setBold(true);
			$sheet->getStyle('A3:R3')->getFont()->setBold(true);
			$sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
			$sheet->getStyle('A3:R3')->getAlignment()->setHorizontal('center');
			$sheet->setCellValue('A3', "Invoice"); 
			$sheet->setCellValue('B3', "Tanggal"); 
			$sheet->setCellValue('C3', "Supplier");
			$sheet->setCellValue('D3', "Tax");
			$sheet->setCellValue('E3', "Jatuh Tempo");
			$sheet->setCellValue('F3', "Payment");
			$sheet->setCellValue('G3', "Sub Total");
			$sheet->setCellValue('H3', "Total Diskon");
			$sheet->setCellValue('I3', "DPP");
			$sheet->setCellValue('J3', "PPN");;
			$sheet->setCellValue('K3', "Status");
			$sheet->setCellValue('L3', "Catatan PO");
			$sheet->setCellValue('M3', "Kode Barang");
			$sheet->setCellValue('N3', "Nama Barang");
			$sheet->setCellValue('O3', "Harga");
			$sheet->setCellValue('P3', "Qty");
			$sheet->setCellValue('Q3', "Total Item");
			$sheet->setCellValue('R3', "TotalInvoice");


			$data = $this->reportpurchase_model->get_report_po($start_date, $end_date, $supplier_report, $status_pembelian)->result_array();
			$i = 4;

			$last_po_invoice = '';
			$last_date = '';
			$last_total_po = '';

			foreach($data as $row){

				$sheet->setCellValue('A'.$i, $row['hd_po_invoice']); 
				$sheet->setCellValue('B'.$i, $row['hd_po_date']); 
				$sheet->setCellValue('C'.$i, $row['supplier_name']); 
				$sheet->setCellValue('D'.$i, $row['hd_po_tax']); 
				$sheet->setCellValue('E'.$i, $row['hd_po_due_date']); 
				$sheet->setCellValue('F'.$i, $row['payment_name']); 
				$sheet->setCellValue('G'.$i, $row['hd_po_sub_total']);
				$sheet->setCellValue('H'.$i, $row['hd_po_total_discount']); 
				$sheet->setCellValue('I'.$i, $row['hd_po_dpp']); 
				$sheet->setCellValue('J'.$i, $row['hd_po_ppn']);
				$sheet->setCellValue('K'.$i, $row['hd_po_status']); 
				$sheet->setCellValue('L'.$i, $row['hd_po_note']);
  				$sheet->setCellValue('M'.$i, $row['product_code']);
				$sheet->setCellValue('N'.$i, $row['product_name']); 
				$sheet->setCellValue('O'.$i, $row['dt_po_price']);
				$sheet->setCellValue('P'.$i, $row['dt_po_qty']); 
				$sheet->setCellValue('Q'.$i, $row['dt_po_total']);
				$sheet->setCellValue('R'.$i, $row['hd_po_grand_total']);
				$i++;
			};

			$sheet->getColumnDimension('A')->setWidth(35); 
			$sheet->getColumnDimension('B')->setWidth(25); 
			$sheet->getColumnDimension('C')->setWidth(25);
			$sheet->getColumnDimension('D')->setWidth(30);
			$sheet->getColumnDimension('E')->setWidth(40);
			$sheet->getColumnDimension('F')->setWidth(40);
			$sheet->getColumnDimension('G')->setWidth(30);
			$sheet->getColumnDimension('H')->setWidth(30);
			$sheet->getColumnDimension('I')->setWidth(30);
			$sheet->getColumnDimension('J')->setWidth(30); 
			$sheet->getColumnDimension('K')->setWidth(30); 
			$sheet->getColumnDimension('L')->setWidth(30);
			$sheet->getColumnDimension('M')->setWidth(30);
			$sheet->getColumnDimension('N')->setWidth(45);
			$sheet->getColumnDimension('O')->setWidth(30);
			$sheet->getColumnDimension('P')->setWidth(30);
			$sheet->getColumnDimension('Q')->setWidth(30);
			$sheet->getColumnDimension('R')->setWidth(30);


			$sheet->getStyle('G')->getNumberFormat()->setFormatCode('#,##0');	
			$sheet->getStyle('H')->getNumberFormat()->setFormatCode('#,##0');
			$sheet->getStyle('I')->getNumberFormat()->setFormatCode('#,##0');	
			$sheet->getStyle('J')->getNumberFormat()->setFormatCode('#,##0');
			$sheet->getStyle('O')->getNumberFormat()->setFormatCode('#,##0');
			$sheet->getStyle('Q')->getNumberFormat()->setFormatCode('#,##0');
			$sheet->getStyle('R')->getNumberFormat()->setFormatCode('#,##0');

			$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
			$sheet->setTitle("Excell");
			ob_end_clean();
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="po_' .date('Y-m-d') . '.xlsx"');
			header('Cache-Control: max-age=0');

			$xlsxWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($excel, 'Xlsx');
			$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($excel);
			exit($xlsxWriter->save('php://output'));
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	// End Report PO



	// Start Report purchases
	
	public function reportpurchases()
	{
		$modul = 'Report';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->view == 'Y'){
			$supplier_list['supplier_list'] = $this->masterdata_model->supplier_list();
			$check_auth['check_auth'] = $check_auth;
			$data['data'] = array_merge($supplier_list, $check_auth);
			$this->load->view('Pages/Report/Purchase/reportpurchases', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function reportpurchasespdf()
	{
		$start_date       = $this->input->get('start_date');
		$end_date 	      = $this->input->get('end_date');
		$supplier_report  = $this->input->get('supplier_report');

		$data['data'] = $this->reportpurchase_model->get_report_hd_purchases($start_date, $end_date, $supplier_report)->result_array();
		$htmlView   = $this->load->view('Pages/Report/Purchase/reportpurchasespdf', $data, true);
		$dompdf = new Dompdf();
		$dompdf->loadHtml($htmlView);
		$dompdf->setPaper('A4', 'landscape');
		$dompdf->render();
		$dompdf->stream('pembelian.pdf', array("Attachment" => false));
		exit();
	}

	public function reportpurchases_excell()
	{
		$modul = 'Report';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->view == 'Y'){
			$start_date       = $this->input->get('start_date');
			$end_date 	      = $this->input->get('end_date');
			$supplier_report  = $this->input->get('supplier_report');;

			$excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
			$sheet = $excel->getActiveSheet();
			$sheet->setCellValue('A1', "Laporan Pembelian"); 
			$sheet->mergeCells('A1:Q1');
			$sheet->getStyle('A1')->getFont()->setBold(true);
			$sheet->getStyle('A3:Q3')->getFont()->setBold(true);
			$sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
			$sheet->getStyle('A3:Q3')->getAlignment()->setHorizontal('center');
			$sheet->setCellValue('A3', "Invoice"); 
			$sheet->setCellValue('B3', "Tanggal"); 
			$sheet->setCellValue('C3', "Supplier");
			$sheet->setCellValue('D3', "Tax");
			$sheet->setCellValue('E3', "Jatuh Tempo");
			$sheet->setCellValue('F3', "Payment");
			$sheet->setCellValue('G3', "Sub Total");
			$sheet->setCellValue('H3', "Total Diskon");
			$sheet->setCellValue('I3', "DPP");
			$sheet->setCellValue('J3', "PPN");
			$sheet->setCellValue('K3', "Catatan Pembelian");
			$sheet->setCellValue('L3', "Kode Barang");
			$sheet->setCellValue('M3', "Nama Barang");
			$sheet->setCellValue('N3', "Harga");
			$sheet->setCellValue('O3', "Qty");
			$sheet->setCellValue('P3', "Total Item");
			$sheet->setCellValue('Q3', "TotalInvoice");

			$data = $this->reportpurchase_model->get_report_purchases($start_date, $end_date, $supplier_report)->result_array();
			$i = 4;

			foreach($data as $row){
				$sheet->setCellValue('A'.$i, $row['hd_purchase_invoice']); 
				$sheet->setCellValue('B'.$i, $row['hd_purchase_date']); 
				$sheet->setCellValue('C'.$i, $row['supplier_name']); 
				$sheet->setCellValue('D'.$i, $row['hd_purchase_tax']); 
				$sheet->setCellValue('E'.$i, $row['hd_purchase_due_date']); 
				$sheet->setCellValue('F'.$i, $row['payment_name']); 
				$sheet->setCellValue('G'.$i, $row['hd_purchase_sub_total']);
				$sheet->setCellValue('H'.$i, $row['hd_purchase_total_discount']); 
				$sheet->setCellValue('I'.$i, $row['hd_purchase_dpp']); 
				$sheet->setCellValue('J'.$i, $row['hd_purchase_ppn']);
				$sheet->setCellValue('K'.$i, $row['hd_purchase_note']);
				$sheet->setCellValue('L'.$i, $row['product_code']); 
				$sheet->setCellValue('M'.$i, $row['product_name']); 
				$sheet->setCellValue('N'.$i, $row['dt_purchase_price']);
				$sheet->setCellValue('O'.$i, $row['dt_purchase_qty']); 
				$sheet->setCellValue('P'.$i, $row['dt_purchase_total']);
				$sheet->setCellValue('Q'.$i, $row['hd_purchase_grand_total']);
				$i++;
			};

			$sheet->getColumnDimension('A')->setWidth(35); 
			$sheet->getColumnDimension('B')->setWidth(35); 
			$sheet->getColumnDimension('C')->setWidth(35);
			$sheet->getColumnDimension('D')->setWidth(35);
			$sheet->getColumnDimension('E')->setWidth(35);
			$sheet->getColumnDimension('F')->setWidth(35);
			$sheet->getColumnDimension('G')->setWidth(35);
			$sheet->getColumnDimension('H')->setWidth(35);
			$sheet->getColumnDimension('I')->setWidth(35);
			$sheet->getColumnDimension('J')->setWidth(35); 
			$sheet->getColumnDimension('K')->setWidth(35); 
			$sheet->getColumnDimension('L')->setWidth(35);
			$sheet->getColumnDimension('M')->setWidth(35);
			$sheet->getColumnDimension('Q')->setWidth(35);


			$sheet->getStyle('J')->getNumberFormat()->setFormatCode('#,##0');	
			$sheet->getStyle('K')->getNumberFormat()->setFormatCode('#,##0');
			$sheet->getStyle('L')->getNumberFormat()->setFormatCode('#,##0');
			$sheet->getStyle('M')->getNumberFormat()->setFormatCode('#,##0');
			$sheet->getStyle('Q')->getNumberFormat()->setFormatCode('#,##0');
			$sheet->getStyle('S')->getNumberFormat()->setFormatCode('#,##0');
			$sheet->getStyle('T')->getNumberFormat()->setFormatCode('#,##0');
			$sheet->getStyle('U')->getNumberFormat()->setFormatCode('#,##0');


			$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
			$sheet->setTitle("Excell");
			ob_end_clean();
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="pembelian_' .date('Y-m-d') . '.xlsx"');
			header('Cache-Control: max-age=0');

			$xlsxWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($excel, 'Xlsx');
			$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($excel);
			exit($xlsxWriter->save('php://output'));
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	// End Report Purchases

	// start Report Retur Purchase
	public function reportreturpurchase()
	{
		$modul = 'Report';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->view == 'Y'){
			$supplier_list['supplier_list'] = $this->masterdata_model->supplier_list();
			$check_auth['check_auth'] = $check_auth;
			$data['data'] = array_merge($supplier_list, $check_auth);
			$this->load->view('Pages/Report/Purchase/reportreturpurchase', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function reportreturpurchasespdf()
	{
		$start_date       = $this->input->get('start_date');
		$end_date 	      = $this->input->get('end_date');
		$supplier_report  = $this->input->get('supplier_report');

		$data['data'] = $this->reportpurchase_model->get_report_retur_hd_purchases($start_date, $end_date, $supplier_report)->result_array();
		$htmlView   = $this->load->view('Pages/Report/Purchase/reportreturpurchasespdf', $data, true);
		$dompdf = new Dompdf();
		$dompdf->loadHtml($htmlView);
		$dompdf->setPaper('A4', 'landscape');
		$dompdf->render();
		$dompdf->stream('returpembelian.pdf', array("Attachment" => false));
		exit();
	}

	public function reportreturpurchases_excell()
	{
		$modul = 'Report';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->view == 'Y'){
			$start_date       = $this->input->get('start_date');
			$end_date 	      = $this->input->get('end_date');
			$warehouse_report = $this->input->get('warehouse_report');
			$supplier_report  = $this->input->get('supplier_report');;

			$excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
			$sheet = $excel->getActiveSheet();
			$sheet->setCellValue('A1', "Laporan Retur Pembelian"); 
			$sheet->mergeCells('A1:J1');
			$sheet->getStyle('A1')->getFont()->setBold(true);
			$sheet->getStyle('A3:J3')->getFont()->setBold(true);
			$sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
			$sheet->getStyle('A3:J3')->getAlignment()->setHorizontal('center');
			$sheet->setCellValue('A3', "Invoice"); 
			$sheet->setCellValue('B3', "Tanggal"); 
			$sheet->setCellValue('C3', "Supplier");
			$sheet->setCellValue('D3', "Nama Barang");
			$sheet->setCellValue('E3', "Satuan");
			$sheet->setCellValue('F3', "Harga");
			$sheet->setCellValue('G3', "Qty Retur");
			$sheet->setCellValue('H3', "Sub Total");
			$sheet->setCellValue('I3', "Catatan");
			$sheet->setCellValue('J3', "Total Transaksi"); 
			$sheet->setCellValue('K3', "Status");
			$sheet->setCellValue('L3', "Jenis Retur");

			$data = $this->reportpurchase_model->get_report_retur_purchases($start_date, $end_date, $supplier_report)->result_array();
			$i = 4;

			foreach($data as $row){
				$sheet->setCellValue('A'.$i, $row['hd_retur_purchase_inv']); 
				$sheet->setCellValue('B'.$i, $row['hd_retur_purchase_date']);
				$sheet->setCellValue('C'.$i, $row['supplier_name']); 
				$sheet->setCellValue('D'.$i, $row['product_name']); 
				$sheet->setCellValue('E'.$i, $row['unit_name']);
				$sheet->setCellValue('F'.$i, $row['dt_retur_purchase_price']); 
				$sheet->setCellValue('G'.$i, $row['dt_retur_purchase_qty']); 
				$sheet->setCellValue('H'.$i, $row['dt_retur_purchase_total']); 
				$sheet->setCellValue('I'.$i, $row['hd_retur_purchase_note']); 
				$sheet->setCellValue('J'.$i, $row['hd_retur_purchase_total']); 
				$sheet->setCellValue('K'.$i, $row['hd_retur_purchase_status']); 
				$sheet->setCellValue('L'.$i, $row['hd_retur_purchase_payment_type']); 
				$i++;
			};

			$sheet->getColumnDimension('A')->setWidth(35); 
			$sheet->getColumnDimension('B')->setWidth(35); 
			$sheet->getColumnDimension('C')->setWidth(35);
			$sheet->getColumnDimension('D')->setWidth(35);
			$sheet->getColumnDimension('E')->setWidth(35);
			$sheet->getColumnDimension('F')->setWidth(35);
			$sheet->getColumnDimension('G')->setWidth(35);
			$sheet->getColumnDimension('H')->setWidth(35);
			$sheet->getColumnDimension('I')->setWidth(35);
			$sheet->getColumnDimension('J')->setWidth(35);
			$sheet->getColumnDimension('K')->setWidth(35);
			$sheet->getColumnDimension('L')->setWidth(35);


			$sheet->getStyle('F')->getNumberFormat()->setFormatCode('#,##0');	
			$sheet->getStyle('H')->getNumberFormat()->setFormatCode('#,##0');	
			$sheet->getStyle('J')->getNumberFormat()->setFormatCode('#,##0');	


			$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
			$sheet->setTitle("Excell");
			ob_end_clean();
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="retur_pembelian_' .date('Y-m-d') . '.xlsx"');
			header('Cache-Control: max-age=0');

			$xlsxWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($excel, 'Xlsx');
			$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($excel);
			exit($xlsxWriter->save('php://output'));
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	// End Report Retur Purchase

}

?>