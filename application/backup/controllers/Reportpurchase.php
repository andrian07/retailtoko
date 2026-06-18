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

	// Report Submission
	public function reportsubmission()
	{
		$modul = 'Report';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$warehouse_list['warehouse_list'] = $this->masterdata_model->warehouse_list();
			$supplier_list['supplier_list'] = $this->masterdata_model->supplier_list();
			$data['data'] = array_merge($warehouse_list, $supplier_list);
			$this->load->view('Pages/Report/Purchase/reportsubmission', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function reportsubmissionpdf()
	{
		$start_date       = $this->input->get('start_date');
		$end_date 	      = $this->input->get('end_date');
		$warehouse_report = $this->input->get('warehouse_report');
		$status  		  = $this->input->get('status');

		$data['data'] = $this->reportpurchase_model->get_report_submission($start_date, $end_date, $warehouse_report, $status)->result_array();
		$htmlView   = $this->load->view('Pages/Report/Purchase/reportsubmissionpdf', $data, true);
		$dompdf = new Dompdf();
		$dompdf->loadHtml($htmlView);
		$dompdf->setPaper('A4', 'landscape');
		$dompdf->render();
		$dompdf->stream('pengajuan.pdf', array("Attachment" => false));
		exit();
	}

	public function reportsubmission_excell(){
		$modul = 'Report';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$start_date       = $this->input->get('start_date');
			$end_date 	      = $this->input->get('end_date');
			$warehouse_report = $this->input->get('warehouse_report');
			$status  		  = $this->input->get('status');

			$excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
			$sheet = $excel->getActiveSheet();
			$sheet->setCellValue('A1', "Laporan Pengajuan"); 
			$sheet->mergeCells('A1:I1');
			$sheet->getStyle('A1')->getFont()->setBold(true);
			$sheet->getStyle('A3:I3')->getFont()->setBold(true);
			$sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
			$sheet->getStyle('A3:I3')->getAlignment()->setHorizontal('center');
			$sheet->setCellValue('A3', "Invoice"); 
			$sheet->setCellValue('B3', "Tanggal"); 
			$sheet->setCellValue('C3', "Kode Produk"); 
			$sheet->setCellValue('D3', "Nama Produk");
			$sheet->setCellValue('E3', "Qty");
			$sheet->setCellValue('F3', "Stock Terakhir");
			$sheet->setCellValue('G3', "Status");
			$sheet->setCellValue('H3', "Urgensi");
			$sheet->setCellValue('I3', "Keterangan");
			$data = $this->reportpurchase_model->get_report_submission($start_date, $end_date, $warehouse_report, $status)->result_array();
			$i = 4;
			foreach($data as $row){
				$sheet->setCellValue('A'.$i, $row['submission_invoice']); 
				$sheet->setCellValue('B'.$i, $row['submission_date']); 
				$sheet->setCellValue('C'.$i, $row['product_code']);
				$sheet->setCellValue('D'.$i, $row['product_name']); 
				$sheet->setCellValue('E'.$i, $row['submission_qty']); 
				$sheet->setCellValue('F'.$i, $row['last_stock']);
				$sheet->setCellValue('G'.$i, $row['submission_status']); 
				$sheet->setCellValue('H'.$i, $row['submission_desc']); 
				$sheet->setCellValue('I'.$i, $row['submission_text']);
				$i++;
			}
			$sheet->getColumnDimension('A')->setWidth(35); 
			$sheet->getColumnDimension('B')->setWidth(25); 
			$sheet->getColumnDimension('C')->setWidth(25);
			$sheet->getColumnDimension('D')->setWidth(40);
			$sheet->getColumnDimension('E')->setWidth(10);
			$sheet->getColumnDimension('F')->setWidth(10);
			$sheet->getColumnDimension('G')->setWidth(25);
			$sheet->getColumnDimension('H')->setWidth(40);
			$sheet->getColumnDimension('I')->setWidth(60);
			$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
			$sheet->setTitle("Excell");
			ob_end_clean();
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="pengajuan_' .date('Y-m-d') . '.xlsx"');
			header('Cache-Control: max-age=0');

			$xlsxWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($excel, 'Xlsx');
			$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($excel);
			exit($xlsxWriter->save('php://output'));
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}
	// End Report Submission

	// Start Report PO
	public function reportpo()
	{
		$modul = 'Report';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$warehouse_list['warehouse_list'] = $this->masterdata_model->warehouse_list();
			$supplier_list['supplier_list'] = $this->masterdata_model->supplier_list();
			$data['data'] = array_merge($warehouse_list, $supplier_list);
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
		$warehouse_report = $this->input->get('warehouse_report');
		$supplier_report  = $this->input->get('supplier_report');
		$status_gudang    = $this->input->get('status_gudang');
		$status_pembelian = $this->input->get('status_pembelian');

		$data['data'] = $this->reportpurchase_model->get_report_hd_po($start_date, $end_date, $warehouse_report, $supplier_report, $status_gudang, $status_pembelian)->result_array();
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
		if($check_auth[0]->view == 'Y'){
			$start_date       = $this->input->get('start_date');
			$end_date 	      = $this->input->get('end_date');
			$warehouse_report = $this->input->get('warehouse_report');
			$supplier_report  = $this->input->get('supplier_report');
			$status_gudang    = $this->input->get('status_gudang');
			$status_pembelian = $this->input->get('status_pembelian');

			$excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
			$sheet = $excel->getActiveSheet();
			$sheet->setCellValue('A1', "Laporan PO"); 
			$sheet->mergeCells('A1:X1');
			$sheet->getStyle('A1')->getFont()->setBold(true);
			$sheet->getStyle('A3:X3')->getFont()->setBold(true);
			$sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
			$sheet->getStyle('A3:X3')->getAlignment()->setHorizontal('center');
			$sheet->setCellValue('A3', "Invoice"); 
			$sheet->setCellValue('B3', "Tanggal"); 
			$sheet->setCellValue('C3', "Gudang"); 
			$sheet->setCellValue('D3', "Supplier");
			$sheet->setCellValue('E3', "Tax");
			$sheet->setCellValue('F3', "Top");
			$sheet->setCellValue('G3', "Jatuh Tempo");
			$sheet->setCellValue('H3', "Payment");
			$sheet->setCellValue('I3', "Ekspedisi");
			$sheet->setCellValue('J3', "Sub Total");
			$sheet->setCellValue('K3', "Total Diskon");
			$sheet->setCellValue('L3', "DPP");
			$sheet->setCellValue('M3', "PPN");;
			$sheet->setCellValue('N3', "Status Input Gudang");
			$sheet->setCellValue('O3', "Status Input Pembelian");
			$sheet->setCellValue('P3', "Catatan Pengiriman");
			$sheet->setCellValue('Q3', "Catatan PO");
			$sheet->setCellValue('R3', "Kode Barang");
			$sheet->setCellValue('S3', "Nama Barang");
			$sheet->setCellValue('T3', "Harga");
			$sheet->setCellValue('U3', "Qty");
			$sheet->setCellValue('V3', "Ongkir");
			$sheet->setCellValue('W3', "Total Item");
			$sheet->setCellValue('X3', "TotalInvoice");


			$data = $this->reportpurchase_model->get_report_po($start_date, $end_date, $warehouse_report, $supplier_report, $status_gudang, $status_pembelian)->result_array();
			$i = 4;

			$last_po_invoice = '';
			$last_date = '';
			$last_total_po = '';

			foreach($data as $row){

				$sheet->setCellValue('A'.$i, $row['hd_po_invoice']); 
				$sheet->setCellValue('B'.$i, $row['hd_po_date']); 
				$sheet->setCellValue('C'.$i, $row['warehouse_name']);
				$sheet->setCellValue('D'.$i, $row['supplier_name']); 
				$sheet->setCellValue('E'.$i, $row['hd_po_tax']); 
				$sheet->setCellValue('F'.$i, $row['hd_po_top']);
				$sheet->setCellValue('G'.$i, $row['hd_po_due_date']); 
				$sheet->setCellValue('H'.$i, $row['payment_name']); 
				$sheet->setCellValue('I'.$i, $row['ekspedisi_name']);
				$sheet->setCellValue('J'.$i, $row['hd_po_sub_total']);
				$sheet->setCellValue('K'.$i, $row['hd_po_total_discount']); 
				$sheet->setCellValue('L'.$i, $row['hd_po_dpp']); 
				$sheet->setCellValue('M'.$i, $row['hd_po_ppn']);
				$sheet->setCellValue('N'.$i, $row['hd_po_status']); 
				$sheet->setCellValue('O'.$i, $row['hd_po_purchase_status']); 
				$sheet->setCellValue('P'.$i, $row['hd_po_status_delivery']);
				$sheet->setCellValue('Q'.$i, $row['hd_po_note']);
				$sheet->setCellValue('R'.$i, $row['product_code']); 
				$sheet->setCellValue('S'.$i, $row['product_name']); 
				$sheet->setCellValue('T'.$i, $row['dt_po_price']);
				$sheet->setCellValue('U'.$i, $row['dt_po_qty']); 
				$sheet->setCellValue('V'.$i, $row['dt_po_ongkir']); 
				$sheet->setCellValue('W'.$i, $row['dt_po_total']);
				$sheet->setCellValue('X'.$i, $row['hd_po_grand_total']);
				$i++;
			};

			$sheet->getColumnDimension('A')->setWidth(35); 
			$sheet->getColumnDimension('B')->setWidth(25); 
			$sheet->getColumnDimension('C')->setWidth(25);
			$sheet->getColumnDimension('D')->setWidth(30);
			$sheet->getColumnDimension('E')->setWidth(10);
			$sheet->getColumnDimension('F')->setWidth(10);
			$sheet->getColumnDimension('G')->setWidth(30);
			$sheet->getColumnDimension('H')->setWidth(20);
			$sheet->getColumnDimension('I')->setWidth(30);
			$sheet->getColumnDimension('J')->setWidth(35); 
			$sheet->getColumnDimension('K')->setWidth(35); 
			$sheet->getColumnDimension('L')->setWidth(25);
			$sheet->getColumnDimension('M')->setWidth(25);
			$sheet->getColumnDimension('N')->setWidth(25);
			$sheet->getColumnDimension('O')->setWidth(25);
			$sheet->getColumnDimension('P')->setWidth(50);
			$sheet->getColumnDimension('Q')->setWidth(50);
			$sheet->getColumnDimension('R')->setWidth(30);
			$sheet->getColumnDimension('S')->setWidth(40); 
			$sheet->getColumnDimension('T')->setWidth(30); 
			$sheet->getColumnDimension('U')->setWidth(30);
			$sheet->getColumnDimension('V')->setWidth(30);
			$sheet->getColumnDimension('W')->setWidth(30);
			$sheet->getColumnDimension('X')->setWidth(30);


			$sheet->getStyle('J')->getNumberFormat()->setFormatCode('#,##0');	
			$sheet->getStyle('K')->getNumberFormat()->setFormatCode('#,##0');
			$sheet->getStyle('L')->getNumberFormat()->setFormatCode('#,##0');
			$sheet->getStyle('M')->getNumberFormat()->setFormatCode('#,##0');
			$sheet->getStyle('T')->getNumberFormat()->setFormatCode('#,##0');
			$sheet->getStyle('V')->getNumberFormat()->setFormatCode('#,##0');
			$sheet->getStyle('W')->getNumberFormat()->setFormatCode('#,##0');
			$sheet->getStyle('X')->getNumberFormat()->setFormatCode('#,##0');

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

	// Start Report Input Warehouse
	public function reportinputwarehouse()
	{
		$modul = 'Report';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$warehouse_list['warehouse_list'] = $this->masterdata_model->warehouse_list();
			$po_list['po_list'] = $this->reportpurchase_model->po_list()->result_array();
			$data['data'] = array_merge($warehouse_list, $po_list);
			$this->load->view('Pages/Report/Purchase/reportinputwarehouse', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	public function reportinputwarehousepdf()
	{
		$start_date       = $this->input->get('start_date');
		$end_date 	      = $this->input->get('end_date');
		$warehouse_report = $this->input->get('warehouse_report');
		$po_report  	  = $this->input->get('po_report');
		$status_pembelian = $this->input->get('status_pembelian');

		$data['data'] = $this->reportpurchase_model->get_report_input_warehouse($start_date, $end_date, $warehouse_report, $po_report, $status_pembelian)->result_array();
		$htmlView   = $this->load->view('Pages/Report/Purchase/reportinputwarehousepdf', $data, true);
		$dompdf = new Dompdf();
		$dompdf->loadHtml($htmlView);
		$dompdf->setPaper('A4', 'landscape');
		$dompdf->render();
		$dompdf->stream('inputgudang.pdf', array("Attachment" => false));
		exit();
	}

	public function reportinputwarehouse_excell()
	{
		$modul = 'Report';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$start_date       = $this->input->get('start_date');
			$end_date 	      = $this->input->get('end_date');
			$warehouse_report = $this->input->get('warehouse_report');
			$po_report  	  = $this->input->get('po_report');
			$status_pembelian = $this->input->get('status_pembelian');

			$excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
			$sheet = $excel->getActiveSheet();
			$sheet->setCellValue('A1', "Laporan Input Gudang"); 
			$sheet->mergeCells('A1:H1');
			$sheet->getStyle('A1')->getFont()->setBold(true);
			$sheet->getStyle('A3:H3')->getFont()->setBold(true);
			$sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
			$sheet->getStyle('A3:H3')->getAlignment()->setHorizontal('center');
			$sheet->setCellValue('A3', "Invoice"); 
			$sheet->setCellValue('B3', "Tanggal"); 
			$sheet->setCellValue('C3', "Gudang");
			$sheet->setCellValue('D3', "Nama Barang"); 
			$sheet->setCellValue('E3', "Supplier");
			$sheet->setCellValue('F3', "Qty Pesan");
			$sheet->setCellValue('G3', "Qty Terima");
			$sheet->setCellValue('H3', "Catatan");

			$data = $this->reportpurchase_model->get_report_input_warehouse($start_date, $end_date, $warehouse_report, $po_report, $status_pembelian)->result_array();
			$i = 4;

			foreach($data as $row){

				$sheet->setCellValue('A'.$i, $row['hd_input_stock_inv']); 
				$sheet->setCellValue('B'.$i, $row['hd_input_stock_date']); 
				$sheet->setCellValue('C'.$i, $row['warehouse_name']); 
				$sheet->setCellValue('D'.$i, $row['product_name']);
				$sheet->setCellValue('E'.$i, $row['supplier_name']); 
				$sheet->setCellValue('F'.$i, $row['dt_is_qty_order']); 
				$sheet->setCellValue('G'.$i, $row['dt_is_qty']);
				$sheet->setCellValue('H'.$i, $row['dt_is_note']); 
				$i++;
			};

			$sheet->getColumnDimension('A')->setWidth(35); 
			$sheet->getColumnDimension('B')->setWidth(25); 
			$sheet->getColumnDimension('C')->setWidth(30);
			$sheet->getColumnDimension('D')->setWidth(70);
			$sheet->getColumnDimension('E')->setWidth(30);
			$sheet->getColumnDimension('F')->setWidth(10);
			$sheet->getColumnDimension('G')->setWidth(10);
			$sheet->getColumnDimension('H')->setWidth(30);


			$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
			$sheet->setTitle("Excell");
			ob_end_clean();
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="inputstock_' .date('Y-m-d') . '.xlsx"');
			header('Cache-Control: max-age=0');

			$xlsxWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($excel, 'Xlsx');
			$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($excel);
			exit($xlsxWriter->save('php://output'));
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	// End Report Input Warehouse


	// Start Report purchases
	
	public function reportpurchases()
	{
		$modul = 'Report';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$warehouse_list['warehouse_list'] = $this->masterdata_model->warehouse_list();
			$supplier_list['supplier_list'] = $this->masterdata_model->supplier_list();
			$data['data'] = array_merge($warehouse_list, $supplier_list);
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
		$warehouse_report = $this->input->get('warehouse_report');
		$supplier_report  = $this->input->get('supplier_report');

		$data['data'] = $this->reportpurchase_model->get_report_purchases($start_date, $end_date, $warehouse_report, $supplier_report)->result_array();
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
		if($check_auth[0]->view == 'Y'){
			$start_date       = $this->input->get('start_date');
			$end_date 	      = $this->input->get('end_date');
			$warehouse_report = $this->input->get('warehouse_report');
			$supplier_report  = $this->input->get('supplier_report');;

			$excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
			$sheet = $excel->getActiveSheet();
			$sheet->setCellValue('A1', "Laporan Pembelian"); 
			$sheet->mergeCells('A1:X1');
			$sheet->getStyle('A1')->getFont()->setBold(true);
			$sheet->getStyle('A3:X3')->getFont()->setBold(true);
			$sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
			$sheet->getStyle('A3:X3')->getAlignment()->setHorizontal('center');
			$sheet->setCellValue('A3', "Invoice"); 
			$sheet->setCellValue('B3', "Tanggal"); 
			$sheet->setCellValue('C3', "Gudang"); 
			$sheet->setCellValue('D3', "Supplier");
			$sheet->setCellValue('E3', "Tax");
			$sheet->setCellValue('F3', "Top");
			$sheet->setCellValue('G3', "Jatuh Tempo");
			$sheet->setCellValue('H3', "Payment");
			$sheet->setCellValue('I3', "Ekspedisi");
			$sheet->setCellValue('J3', "Sub Total");
			$sheet->setCellValue('K3', "Total Diskon");
			$sheet->setCellValue('L3', "DPP");
			$sheet->setCellValue('M3', "PPN");
			$sheet->setCellValue('N3', "Catatan Pembelian");
			$sheet->setCellValue('O3', "Kode Barang");
			$sheet->setCellValue('P3', "Nama Barang");
			$sheet->setCellValue('Q3', "Harga");
			$sheet->setCellValue('R3', "Qty");
			$sheet->setCellValue('S3', "Ongkir");
			$sheet->setCellValue('T3', "Total Item");
			$sheet->setCellValue('U3', "TotalInvoice");

			$data = $this->reportpurchase_model->get_report_purchases($start_date, $end_date, $warehouse_report, $supplier_report)->result_array();
			$i = 4;

			foreach($data as $row){
				$sheet->setCellValue('A'.$i, $row['hd_purchase_invoice']); 
				$sheet->setCellValue('B'.$i, $row['hd_purchase_date']); 
				$sheet->setCellValue('C'.$i, $row['warehouse_name']);
				$sheet->setCellValue('D'.$i, $row['supplier_name']); 
				$sheet->setCellValue('E'.$i, $row['hd_purchase_tax']); 
				$sheet->setCellValue('F'.$i, $row['hd_purchase_top']);
				$sheet->setCellValue('G'.$i, $row['hd_purchase_due_date']); 
				$sheet->setCellValue('H'.$i, $row['payment_name']); 
				$sheet->setCellValue('I'.$i, $row['ekspedisi_name']);
				$sheet->setCellValue('J'.$i, $row['hd_purchase_sub_total']);
				$sheet->setCellValue('K'.$i, $row['hd_purchase_total_discount']); 
				$sheet->setCellValue('L'.$i, $row['hd_purchase_dpp']); 
				$sheet->setCellValue('M'.$i, $row['hd_purchase_ppn']);
				$sheet->setCellValue('N'.$i, $row['hd_purchase_note']);
				$sheet->setCellValue('O'.$i, $row['product_code']); 
				$sheet->setCellValue('P'.$i, $row['product_name']); 
				$sheet->setCellValue('Q'.$i, $row['dt_purchase_price']);
				$sheet->setCellValue('R'.$i, $row['dt_purchase_qty']); 
				$sheet->setCellValue('S'.$i, $row['dt_purchase_ongkir']); 
				$sheet->setCellValue('T'.$i, $row['dt_purchase_total']);
				$sheet->setCellValue('U'.$i, $row['hd_purchase_grand_total']);
				$i++;
			};

			$sheet->getColumnDimension('A')->setWidth(35); 
			$sheet->getColumnDimension('B')->setWidth(25); 
			$sheet->getColumnDimension('C')->setWidth(25);
			$sheet->getColumnDimension('D')->setWidth(30);
			$sheet->getColumnDimension('E')->setWidth(10);
			$sheet->getColumnDimension('F')->setWidth(10);
			$sheet->getColumnDimension('G')->setWidth(30);
			$sheet->getColumnDimension('H')->setWidth(20);
			$sheet->getColumnDimension('I')->setWidth(30);
			$sheet->getColumnDimension('J')->setWidth(35); 
			$sheet->getColumnDimension('K')->setWidth(35); 
			$sheet->getColumnDimension('L')->setWidth(25);
			$sheet->getColumnDimension('M')->setWidth(25);
			$sheet->getColumnDimension('Q')->setWidth(50);
			$sheet->getColumnDimension('R')->setWidth(30);
			$sheet->getColumnDimension('S')->setWidth(40); 
			$sheet->getColumnDimension('T')->setWidth(30); 
			$sheet->getColumnDimension('U')->setWidth(30);


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
		if($check_auth[0]->view == 'Y'){
			$warehouse_list['warehouse_list'] = $this->masterdata_model->warehouse_list();
			$supplier_list['supplier_list'] = $this->masterdata_model->supplier_list();
			$data['data'] = array_merge($warehouse_list, $supplier_list);
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

		$data['data'] = $this->reportpurchase_model->get_report_retur_purchases($start_date, $end_date, $supplier_report)->result_array();
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
		if($check_auth[0]->view == 'Y'){
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
			$sheet->setCellValue('C3', "Gudang"); 
			$sheet->setCellValue('D3', "Barang"); 
			$sheet->setCellValue('E3', "Qty Retur");
			$sheet->setCellValue('F3', "Sub Total");
			$sheet->setCellValue('G3', "Catatan");
			$sheet->setCellValue('H3', "Supplier");
			$sheet->setCellValue('I3', "Total Nota");
			$sheet->setCellValue('J3', "Jensi Retur");

			$data = $this->reportpurchase_model->get_report_retur_purchases($start_date, $end_date, $supplier_report)->result_array();
			$i = 4;

			foreach($data as $row){
				$sheet->setCellValue('A'.$i, $row['hd_retur_purchase_inv']); 
				$sheet->setCellValue('B'.$i, $row['hd_retur_purchase_date']); 
				$sheet->setCellValue('C'.$i, $row['warehouse_name']);
				$sheet->setCellValue('D'.$i, $row['product_name']); 
				$sheet->setCellValue('E'.$i, $row['dt_retur_purchase_qty']); 
				$sheet->setCellValue('F'.$i, $row['dt_retur_purchase_total']);
				$sheet->setCellValue('G'.$i, $row['dt_retur_purchase_note']);
				$sheet->setCellValue('H'.$i, $row['supplier_name']); 
				$sheet->setCellValue('I'.$i, $row['hd_retur_purchase_total']); 
				$sheet->setCellValue('J'.$i, $row['retur_type']); 
				$i++;
			};

			$sheet->getColumnDimension('A')->setWidth(35); 
			$sheet->getColumnDimension('B')->setWidth(25); 
			$sheet->getColumnDimension('C')->setWidth(25);
			$sheet->getColumnDimension('D')->setWidth(50);
			$sheet->getColumnDimension('E')->setWidth(10);
			$sheet->getColumnDimension('F')->setWidth(10);
			$sheet->getColumnDimension('G')->setWidth(50);
			$sheet->getColumnDimension('H')->setWidth(30);
			$sheet->getColumnDimension('I')->setWidth(30);
			$sheet->getColumnDimension('J')->setWidth(30);


			$sheet->getStyle('F')->getNumberFormat()->setFormatCode('#,##0');	
			$sheet->getStyle('I')->getNumberFormat()->setFormatCode('#,##0');	


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