<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
date_default_timezone_set('Asia/Jakarta');
require 'vendor/autoload.php';

use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Reportmaster extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('global_model');
		$this->load->model('reportmaster_model');
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
		echo 'Report Master';die();
	}

	// Report Brand
	public function reportbrand(){
		$modul = 'Report';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
			$sheet = $excel->getActiveSheet();
			$sheet->setCellValue('A1', "List Brand"); 
			$sheet->mergeCells('A1:C1');
			$sheet->getStyle('A1')->getFont()->setBold(true);
			$sheet->getStyle('A3:C3')->getFont()->setBold(true);
			$sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
			$sheet->getStyle('A3:C3')->getAlignment()->setHorizontal('center');
			$sheet->setCellValue('A3', "Kode Brand"); 
			$sheet->setCellValue('B3', "Nama Brand"); 
			$sheet->setCellValue('C3', "Keterangan Brand"); 
			$data = $this->reportmaster_model->brand_list()->result_array();
			$i = 4;
			foreach($data as $row){
				$sheet->setCellValue('A'.$i, $row['brand_id']); 
				$sheet->setCellValue('B'.$i, $row['brand_name']); 
				$sheet->setCellValue('C'.$i, $row['brand_desc']);
				$i++;
			}
			$sheet->getColumnDimension('A')->setWidth(25); 
			$sheet->getColumnDimension('B')->setWidth(35); 
			$sheet->getColumnDimension('C')->setWidth(55);
			$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
			$sheet->setTitle("Excell");
			ob_end_clean();
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="brand_' .date('Y-m-d') . '.xlsx"');
			header('Cache-Control: max-age=0');

			$xlsxWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($excel, 'Xlsx');
			$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($excel);
			exit($xlsxWriter->save('php://output'));
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}
	// End Report Brand


	// Report Customer
	public function reportcustomer(){
		$modul = 'Report';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
			$sheet = $excel->getActiveSheet();
			$sheet->setCellValue('A1', "List Customer"); 
			$sheet->mergeCells('A1:P1');
			$sheet->getStyle('A1')->getFont()->setBold(true);
			$sheet->getStyle('A3:P3')->getFont()->setBold(true);
			$sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
			$sheet->getStyle('A3:P3')->getAlignment()->setHorizontal('center');
			$sheet->setCellValue('A3', "Kode Customer"); 
			$sheet->setCellValue('B3', "Nama Customer"); 
			$sheet->setCellValue('C3', "Tanggal Lahir"); 
			$sheet->setCellValue('D3', "Gender");
			$sheet->setCellValue('E3', "No HP");
			$sheet->setCellValue('F3', "Email");
			$sheet->setCellValue('G3', "Alamat");
			$sheet->setCellValue('H3', "Blok");
			$sheet->setCellValue('I3', "No");
			$sheet->setCellValue('J3', "RT");
			$sheet->setCellValue('K3', "RW");
			$sheet->setCellValue('L3', "Alamat Pengiriman");
			$sheet->setCellValue('M3', "NPWP");
			$sheet->setCellValue('N3', "NIK");
			$sheet->setCellValue('O3', "RATE");
			$sheet->setCellValue('P3', "Ekspedisi Yang Di Gunakan");
			$data = $this->reportmaster_model->customer_list()->result_array();
			$i = 4;
			foreach($data as $row){
				$sheet->setCellValue('A'.$i, $row['customer_code']); 
				$sheet->setCellValue('B'.$i, $row['customer_name']); 
				$sheet->setCellValue('C'.$i, $row['customer_dob']);
				$sheet->setCellValue('D'.$i, $row['customer_gender']); 
				$sheet->setCellValue('E'.$i, $row['customer_phone']); 
				$sheet->setCellValue('F'.$i, $row['customer_email']);
				$sheet->setCellValue('G'.$i, $row['customer_address']); 
				$sheet->setCellValue('H'.$i, $row['customer_address_blok']); 
				$sheet->setCellValue('I'.$i, $row['customer_address_no']);
				$sheet->setCellValue('J'.$i, $row['customer_rt']); 
				$sheet->setCellValue('K'.$i, $row['customer_rw']); 
				$sheet->setCellValue('L'.$i, $row['customer_send_address']);
				$sheet->setCellValue('M'.$i, $row['customer_npwp']); 
				$sheet->setCellValue('N'.$i, $row['customer_nik']); 
				$sheet->setCellValue('O'.$i, $row['customer_rate']);
				$sheet->setCellValue('P'.$i, $row['customer_expedisi_tag']);
				$i++;
			}
			$sheet->getColumnDimension('A')->setWidth(35); 
			$sheet->getColumnDimension('B')->setWidth(35); 
			$sheet->getColumnDimension('C')->setWidth(25);
			$sheet->getColumnDimension('D')->setWidth(15); 
			$sheet->getColumnDimension('E')->setWidth(25); 
			$sheet->getColumnDimension('F')->setWidth(25);
			$sheet->getColumnDimension('G')->setWidth(60); 
			$sheet->getColumnDimension('H')->setWidth(25); 
			$sheet->getColumnDimension('I')->setWidth(25);
			$sheet->getColumnDimension('J')->setWidth(25); 
			$sheet->getColumnDimension('K')->setWidth(25); 
			$sheet->getColumnDimension('L')->setWidth(60);
			$sheet->getColumnDimension('M')->setWidth(35); 
			$sheet->getColumnDimension('N')->setWidth(35); 
			$sheet->getColumnDimension('O')->setWidth(35);
			$sheet->getColumnDimension('P')->setWidth(35); 
			$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
			$sheet->setTitle("Excell");
			ob_end_clean();
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="customer_' .date('Y-m-d') . '.xlsx"');
			header('Cache-Control: max-age=0');

			$xlsxWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($excel, 'Xlsx');
			$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($excel);
			exit($xlsxWriter->save('php://output'));
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}
	// End Report Customer

	// Report Exspedisi
	public function reportekspedisi(){
		$modul = 'Report';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
			$sheet = $excel->getActiveSheet();
			$sheet->setCellValue('A1', "List Ekspedisi"); 
			$sheet->mergeCells('A1:E1');
			$sheet->getStyle('A1')->getFont()->setBold(true);
			$sheet->getStyle('A3:E3')->getFont()->setBold(true);
			$sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
			$sheet->getStyle('A3:E3')->getAlignment()->setHorizontal('center');
			$sheet->setCellValue('A3', "Kode Ekspedisi"); 
			$sheet->setCellValue('B3', "Nama Ekspedisi"); 
			$sheet->setCellValue('C3', "No HP"); 
			$sheet->setCellValue('D3', "Alamat");
			$sheet->setCellValue('E3', "Keterangan");
			$data = $this->reportmaster_model->ekspedisi_list()->result_array();
			$i = 4;
			foreach($data as $row){
				$sheet->setCellValue('A'.$i, $row['ekspedisi_id']); 
				$sheet->setCellValue('B'.$i, $row['ekspedisi_name']); 
				$sheet->setCellValue('C'.$i, $row['ekspedisi_phone']);
				$sheet->setCellValue('D'.$i, $row['ekspedisi_address']); 
				$sheet->setCellValue('E'.$i, $row['ekspedisi_desc']);
				$i++;
			}
			$sheet->getColumnDimension('A')->setWidth(35); 
			$sheet->getColumnDimension('B')->setWidth(35); 
			$sheet->getColumnDimension('C')->setWidth(35);
			$sheet->getColumnDimension('D')->setWidth(35); 
			$sheet->getColumnDimension('E')->setWidth(35);
			$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
			$sheet->setTitle("Excell");
			ob_end_clean();
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="ekspedisi_' .date('Y-m-d') . '.xlsx"');
			header('Cache-Control: max-age=0');

			$xlsxWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($excel, 'Xlsx');
			$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($excel);
			exit($xlsxWriter->save('php://output'));
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}
	// End Report ekspedisi

	// Report warehouse
	public function reportwarehouse(){
		$modul = 'Report';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
			$sheet = $excel->getActiveSheet();
			$sheet->setCellValue('A1', "List Gudang"); 
			$sheet->mergeCells('A1:D1');
			$sheet->getStyle('A1')->getFont()->setBold(true);
			$sheet->getStyle('A3:D3')->getFont()->setBold(true);
			$sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
			$sheet->getStyle('A3:D3')->getAlignment()->setHorizontal('center');
			$sheet->setCellValue('A3', "ID"); 
			$sheet->setCellValue('B3', "Kode Gudang"); 
			$sheet->setCellValue('C3', "Nama Gudang"); 
			$sheet->setCellValue('D3', "Alamat");
			$data = $this->reportmaster_model->warehouse_list()->result_array();
			$i = 4;
			foreach($data as $row){
				$sheet->setCellValue('A'.$i, $row['warehouse_id']); 
				$sheet->setCellValue('B'.$i, $row['warehouse_code']); 
				$sheet->setCellValue('C'.$i, $row['warehouse_name']);
				$sheet->setCellValue('D'.$i, $row['warehouse_address']);
				$i++;
			}
			$sheet->getColumnDimension('A')->setWidth(35); 
			$sheet->getColumnDimension('B')->setWidth(35); 
			$sheet->getColumnDimension('C')->setWidth(35);
			$sheet->getColumnDimension('D')->setWidth(60); 
			$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
			$sheet->setTitle("Excell");
			ob_end_clean();
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="warehouse_' .date('Y-m-d') . '.xlsx"');
			header('Cache-Control: max-age=0');

			$xlsxWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($excel, 'Xlsx');
			$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($excel);
			exit($xlsxWriter->save('php://output'));
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}
	// End Report warehouse


	// Report category
	public function reportcategory(){
		$modul = 'Report';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
			$sheet = $excel->getActiveSheet();
			$sheet->setCellValue('A1', "List Kategori"); 
			$sheet->mergeCells('A1:C1');
			$sheet->getStyle('A1')->getFont()->setBold(true);
			$sheet->getStyle('A3:C3')->getFont()->setBold(true);
			$sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
			$sheet->getStyle('A3:C3')->getAlignment()->setHorizontal('center');
			$sheet->setCellValue('A3', "Kode Kategori"); 
			$sheet->setCellValue('B3', "Nama Kategori"); 
			$sheet->setCellValue('C3', "Keterangan"); 
			$data = $this->reportmaster_model->category_list()->result_array();
			$i = 4;
			foreach($data as $row){
				$sheet->setCellValue('A'.$i, $row['category_id']); 
				$sheet->setCellValue('B'.$i, $row['category_name']); 
				$sheet->setCellValue('C'.$i, $row['category_desc']);
				$i++;
			}
			$sheet->getColumnDimension('A')->setWidth(35); 
			$sheet->getColumnDimension('B')->setWidth(35); 
			$sheet->getColumnDimension('C')->setWidth(60); 
			$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
			$sheet->setTitle("Excell");
			ob_end_clean();
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="category_' .date('Y-m-d') . '.xlsx"');
			header('Cache-Control: max-age=0');

			$xlsxWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($excel, 'Xlsx');
			$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($excel);
			exit($xlsxWriter->save('php://output'));
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}
	// End Report category



	// Report Product

	public function reportproduct()
	{
		$modul = 'Report';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$brand_list['brand_list'] = $this->masterdata_model->brand_list();
			$category_list['category_list'] = $this->masterdata_model->category_list();
			$supplier_list['supplier_list'] = $this->masterdata_model->supplier_list();
			$data['data'] = array_merge($brand_list, $category_list, $supplier_list);
			$this->load->view('Pages/Report/Masterdata/reportproduct', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}


	public function reportproductpdf()
	{
		$brand_report 	 = $this->input->get('brand_report');
		$category_report = $this->input->get('category_report');
		$Supplier_report = $this->input->get('Supplier_report');

		$data['data'] = $this->reportmaster_model->get_report_product($brand_report, $category_report, $Supplier_report)->result_array();
		$htmlView   = $this->load->view('Pages/Report/Masterdata/reportproductpdf', $data, true);
		$dompdf = new Dompdf();
		$dompdf->loadHtml($htmlView);
		$dompdf->setPaper('A4', 'landscape');
		$dompdf->render();
		$dompdf->stream('daftar_product.pdf', array("Attachment" => false));
		exit();
	}

	public function reportproduct_excell()
	{
		$modul = 'Report';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$brand_report 	 = $this->input->get('brand_report');
			$category_report = $this->input->get('category_report');
			$Supplier_report = $this->input->get('Supplier_report');

			$excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
			$sheet = $excel->getActiveSheet();
			$sheet->setCellValue('A1', "List Produk"); 
			$sheet->mergeCells('A1:C1');
			$sheet->mergeCells('R3:S3');
			$sheet->mergeCells('T3:U3');
			$sheet->mergeCells('V3:W3');
			$sheet->mergeCells('X3:Y3');
			$sheet->getStyle('A1')->getFont()->setBold(true);
			$sheet->getStyle('A3:Y3')->getFont()->setBold(true);
			$sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
			$sheet->getStyle('A3:Y3')->getAlignment()->setHorizontal('center');
			$sheet->setCellValue('A3', "Kode Produk"); 
			$sheet->setCellValue('B3', "Nama Produk"); 
			$sheet->setCellValue('C3', "Satuan");
			$sheet->setCellValue('D3', "Kategori");
			$sheet->setCellValue('E3', "Brand");
			$sheet->setCellValue('F3', "Supplier");
			$sheet->setCellValue('G3', "Item Supplier");
			$sheet->setCellValue('H3', "Status");
			$sheet->setCellValue('I3', "Paket");
			$sheet->setCellValue('J3', "PPN");
			$sheet->setCellValue('K3', "Min Stock");
			$sheet->setCellValue('L3', "Catatan Penting");
			$sheet->setCellValue('M3', "Min Order");
			$sheet->setCellValue('N3', "Berat");
			$sheet->setCellValue('O3', "HPP");
			$sheet->setCellValue('P3', "Harga Beli");
			$sheet->setCellValue('Q3', "Lokasi Stok");
			$sheet->setCellValue('R3', "Umum");
			$sheet->setCellValue('T3', "Toko");
			$sheet->setCellValue('V3', "Sales");
			$sheet->setCellValue('X3', "Khusus");


			$sheet->setCellValue('R4', "Harga Jual");
			$sheet->setCellValue('S4', "Harga Diskon");
			$sheet->setCellValue('T4', "Harga Jual");
			$sheet->setCellValue('U4', "Harga Diskon");
			$sheet->setCellValue('V4', "Harga Jual");
			$sheet->setCellValue('W4', "Harga Diskon");
			$sheet->setCellValue('X4', "Harga Jual");
			$sheet->setCellValue('Y4', "Harga Diskon");

			$data = $this->reportmaster_model->get_report_product($brand_report, $category_report, $Supplier_report)->result_array();
			$i = 5;
			foreach($data as $row){

				if($row['is_active'] == 'Y'){
					$active = 'Aktif';
				}else{
					$active = 'Tidak Aktif';
				}	

				if($row['is_package'] == 'Y'){
					$package = 'Paket';
				}else{
					$package = 'Non Paket';
				}

				$sheet->setCellValue('A'.$i, $row['product_code']); 
				$sheet->setCellValue('B'.$i, $row['product_name']); 
				$sheet->setCellValue('C'.$i, $row['unit_name']);
				$sheet->setCellValue('D'.$i, $row['category_name']);
				$sheet->setCellValue('E'.$i, $row['brand_name']);
				$sheet->setCellValue('F'.$i, $row['product_supplier_tag']);
				$sheet->setCellValue('G'.$i, $row['product_supplier_name']);
				$sheet->setCellValue('H'.$i, $active);
				$sheet->setCellValue('I'.$i, $package);
				$sheet->setCellValue('J'.$i, $row['is_ppn']);
				$sheet->setCellValue('K'.$i, $row['product_min_stock']);
				$sheet->setCellValue('L'.$i, $row['product_desc']);
				$sheet->setCellValue('M'.$i, $row['product_min_order']);
				$sheet->setCellValue('N'.$i, $row['product_weight']);
				$sheet->setCellValue('O'.$i, $row['product_hpp']);
				$sheet->setCellValue('P'.$i, $row['product_price']);
				$sheet->setCellValue('Q'.$i, $row['product_location']);
				$sheet->setCellValue('R'.$i, $row['product_sell_price_1']);
				$sheet->setCellValue('S'.$i, $row['product_sell_percentage_1'].'%');
				$sheet->setCellValue('T'.$i, $row['product_sell_price_2']);
				$sheet->setCellValue('U'.$i, $row['product_sell_percentage_2'].'%');
				$sheet->setCellValue('V'.$i, $row['product_sell_price_3']);
				$sheet->setCellValue('W'.$i, $row['product_sell_percentage_3'].'%');
				$sheet->setCellValue('X'.$i, $row['product_sell_price_4']);
				$sheet->setCellValue('Y'.$i, $row['product_sell_percentage_4'].'%');
				$i++;
			}

			$sheet->getStyle('O')->getNumberFormat()->setFormatCode('#,##0');	
			$sheet->getStyle('P')->getNumberFormat()->setFormatCode('#,##0');
			$sheet->getStyle('R')->getNumberFormat()->setFormatCode('#,##0');
			$sheet->getStyle('T')->getNumberFormat()->setFormatCode('#,##0');
			$sheet->getStyle('V')->getNumberFormat()->setFormatCode('#,##0');
			$sheet->getStyle('X')->getNumberFormat()->setFormatCode('#,##0');

			$sheet->getColumnDimension('A')->setWidth(25); 
			$sheet->getColumnDimension('B')->setWidth(45); 
			$sheet->getColumnDimension('C')->setWidth(10);
			$sheet->getColumnDimension('D')->setWidth(15);
			$sheet->getColumnDimension('E')->setWidth(15);
			$sheet->getColumnDimension('F')->setWidth(30);
			$sheet->getColumnDimension('G')->setWidth(40);
			$sheet->getColumnDimension('H')->setWidth(10);
			$sheet->getColumnDimension('I')->setWidth(10);
			$sheet->getColumnDimension('J')->setWidth(10);
			$sheet->getColumnDimension('K')->setWidth(10);
			$sheet->getColumnDimension('L')->setWidth(60);
			$sheet->getColumnDimension('M')->setWidth(10);
			$sheet->getColumnDimension('N')->setWidth(10);
			$sheet->getColumnDimension('O')->setWidth(10);
			$sheet->getColumnDimension('P')->setWidth(10);
			$sheet->getColumnDimension('Q')->setWidth(60);
			$sheet->getColumnDimension('R')->setWidth(10);
			$sheet->getColumnDimension('S')->setWidth(10);
			$sheet->getColumnDimension('T')->setWidth(10);
			$sheet->getColumnDimension('U')->setWidth(10);
			$sheet->getColumnDimension('V')->setWidth(10);
			$sheet->getColumnDimension('W')->setWidth(10);
			$sheet->getColumnDimension('X')->setWidth(10);


			$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
			$sheet->setTitle("Excell");
			ob_end_clean();
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="produk_' .date('Y-m-d') . '.xlsx"');
			header('Cache-Control: max-age=0');

			$xlsxWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($excel, 'Xlsx');
			$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($excel);
			exit($xlsxWriter->save('php://output'));
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}

	// End Report Product

	
	// laporan salesman //

	public function reportsalesman(){
		$modul = 'Report';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
			$sheet = $excel->getActiveSheet();
			$sheet->setCellValue('A1', "List Kategori"); 
			$sheet->mergeCells('A1:D1');
			$sheet->getStyle('A1')->getFont()->setBold(true);
			$sheet->getStyle('A3:D3')->getFont()->setBold(true);
			$sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
			$sheet->getStyle('A3:D3')->getAlignment()->setHorizontal('center');
			$sheet->setCellValue('A3', "Nama Sales"); 
			$sheet->setCellValue('B3', "Alamat"); 
			$sheet->setCellValue('C3', "No HP");
			$sheet->setCellValue('D3', "Cabang");  
			$data = $this->reportmaster_model->salesman_list()->result_array();
			$i = 4;
			foreach($data as $row){
				$sheet->setCellValue('A'.$i, $row['salesman_name']); 
				$sheet->setCellValue('B'.$i, $row['salesman_address']); 
				$sheet->setCellValue('C'.$i, $row['salesman_phone']);
				$sheet->setCellValue('D'.$i, $row['warehouse_name']);
				$i++;
			}
			$sheet->getColumnDimension('A')->setWidth(35); 
			$sheet->getColumnDimension('B')->setWidth(35); 
			$sheet->getColumnDimension('C')->setWidth(60); 
			$sheet->getColumnDimension('D')->setWidth(35);
			$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
			$sheet->setTitle("Excell");
			ob_end_clean();
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="salesman_' .date('Y-m-d') . '.xlsx"');
			header('Cache-Control: max-age=0');

			$xlsxWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($excel, 'Xlsx');
			$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($excel);
			exit($xlsxWriter->save('php://output'));
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}
	// end laporan salsesman


	// laporan supplier //
	public function reportsupplier(){
		$modul = 'Report';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
			$sheet = $excel->getActiveSheet();
			$sheet->setCellValue('A1', "List Supplier"); 
			$sheet->mergeCells('A1:D1');
			$sheet->getStyle('A1')->getFont()->setBold(true);
			$sheet->getStyle('A3:D3')->getFont()->setBold(true);
			$sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
			$sheet->getStyle('A3:D3')->getAlignment()->setHorizontal('center');
			$sheet->setCellValue('A3', "Supplier Code"); 
			$sheet->setCellValue('B3', "Nama"); 
			$sheet->setCellValue('C3', "Alamat");
			$sheet->setCellValue('D3', "No HP");  
			$data = $this->reportmaster_model->supplier_list()->result_array();
			$i = 4;
			foreach($data as $row){
				$sheet->setCellValue('A'.$i, $row['supplier_code']); 
				$sheet->setCellValue('B'.$i, $row['supplier_name']); 
				$sheet->setCellValue('C'.$i, $row['supplier_address']);
				$sheet->setCellValue('D'.$i, $row['supplier_phone']);
				$i++;
			}
			$sheet->getColumnDimension('A')->setWidth(35); 
			$sheet->getColumnDimension('B')->setWidth(35); 
			$sheet->getColumnDimension('C')->setWidth(70); 
			$sheet->getColumnDimension('D')->setWidth(35);
			$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
			$sheet->setTitle("Excell");
			ob_end_clean();
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="saelsman_' .date('Y-m-d') . '.xlsx"');
			header('Cache-Control: max-age=0');

			$xlsxWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($excel, 'Xlsx');
			$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($excel);
			exit($xlsxWriter->save('php://output'));
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}
	// end laporan supplier

}

?>