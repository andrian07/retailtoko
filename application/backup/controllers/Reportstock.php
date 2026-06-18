<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
date_default_timezone_set('Asia/Jakarta');
require 'vendor/autoload.php';

use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Reportstock extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('global_model');
		$this->load->model('reportstock_model');
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

	// Report stok
	public function stockist()
	{
		$modul = 'Report';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
            $category_list['category_list'] = $this->masterdata_model->category_list();
            $brand_list['brand_list'] = $this->masterdata_model->brand_list();
            $warehouse_list['warehouse_list'] = $this->masterdata_model->warehouse_list();
			$data['data'] = array_merge($category_list, $brand_list, $warehouse_list);
			$this->load->view('Pages/Report/Stock/stockist', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}
    
    public function stockistpdf()
    {
		$warehouse_report  = $this->input->get('warehouse_report');
        $brand_report  = $this->input->get('brand_report');
        $category_report = $this->input->get('category_report');

		$data['data'] = $this->reportstock_model->get_report_stock($warehouse_report, $brand_report, $category_report)->result_array();
		$htmlView   = $this->load->view('Pages/Report/Stock/reportstockpdf', $data, true);
		$dompdf = new Dompdf();
		$dompdf->loadHtml($htmlView);
		$dompdf->setPaper('A4', 'landscape');
		$dompdf->render();
		$dompdf->stream('stock.pdf', array("Attachment" => false));
		exit();
    }

    public function stockist_excell()
	{
		$modul = 'Report';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$warehouse_report  = $this->input->get('warehouse_report');
        	$brand_report  = $this->input->get('brand_report');
        	$category_report = $this->input->get('category_report');


			$excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
			$sheet = $excel->getActiveSheet();
			$sheet->setCellValue('A1', "Laporan Stok"); 
			$sheet->mergeCells('A1:D1');
			$sheet->getStyle('A1')->getFont()->setBold(true);
			$sheet->getStyle('A3:D3')->getFont()->setBold(true);
			$sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
			$sheet->getStyle('A3:D3')->getAlignment()->setHorizontal('center');
			$sheet->setCellValue('A3', "Nama Barang"); 
			$sheet->setCellValue('B3', "Kode Barang"); 
			$sheet->setCellValue('C3', "Gudang"); 
			$sheet->setCellValue('D3', "Stok");

			$data = $this->reportstock_model->get_report_stock($warehouse_report, $brand_report, $category_report)->result_array();
			$i = 4;

			foreach($data as $row){
				$sheet->setCellValue('A'.$i, $row['product_name']); 
				$sheet->setCellValue('B'.$i, $row['product_code']); 
				$sheet->setCellValue('C'.$i, $row['warehouse_name']);
				$sheet->setCellValue('D'.$i, $row['stock']); 
				$i++;
			};

			$sheet->getColumnDimension('A')->setWidth(65); 
			$sheet->getColumnDimension('B')->setWidth(35);
			$sheet->getColumnDimension('C')->setWidth(35);
			$sheet->getColumnDimension('D')->setWidth(35);


			$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
			$sheet->setTitle("Excell");
			ob_end_clean();
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="stock_' .date('Y-m-d') . '.xlsx"');
			header('Cache-Control: max-age=0');

			$xlsxWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($excel, 'Xlsx');
			$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($excel);
			exit($xlsxWriter->save('php://output'));
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}
	// End Report stok



    // Report stok card
    public function stockcard()
	{
		$modul = 'Report';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$this->load->view('Pages/Report/Stock/stockcard');
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}
    
    public function stockcardpdf()
    {
        $product_id       = $this->input->get('product_id');

		$data['data'] = $this->reportstock_model->get_movement_stock($product_id)->result_array();
		$htmlView   = $this->load->view('Pages/Report/Stock/movementstockpdf', $data, true);
		$dompdf = new Dompdf();
		$dompdf->loadHtml($htmlView);
		$dompdf->setPaper('A4', 'landscape');
		$dompdf->render();
		$dompdf->stream('pembelian.pdf', array("Attachment" => false));
		exit();
    }

	public function stockcard_excell()
	{
		$modul = 'Report';
		$check_auth = $this->check_auth($modul);
		if($check_auth[0]->view == 'Y'){
			$product_id       = $this->input->get('product_id');

			$excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
			$sheet = $excel->getActiveSheet();
			$sheet->setCellValue('A1', "Laporan Penjualan"); 
			$sheet->mergeCells('A1:S1');
			$sheet->getStyle('A1')->getFont()->setBold(true);
			$sheet->getStyle('A3:S3')->getFont()->setBold(true);
			$sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
			$sheet->getStyle('A3:S3')->getAlignment()->setHorizontal('center');
			$sheet->setCellValue('A3', "Nama Barang"); 
			$sheet->setCellValue('B3', "Kode Barang"); 
			$sheet->setCellValue('C3', "Tanggal"); 
			$sheet->setCellValue('D3', "Keterangan"); 
			$sheet->setCellValue('E3', "Stok Awal");
            $sheet->setCellValue('F3', "Qty");
            $sheet->setCellValue('G3', "Stok Akhir");

			$data = $this->reportstock_model->get_movement_stock($product_id)->result_array();
			$i = 4;
			foreach($data as $row){
				if($row['stock_movement_calculate'] == 'Plus'){
					$status = '+';
				}else{
					$status = '-';
				}   

				$sheet->setCellValue('A'.$i, $row['product_name']); 
				$sheet->setCellValue('B'.$i, $row['product_code']); 
				$sheet->setCellValue('C'.$i, $row['stock_movement_date']);
				$sheet->setCellValue('D'.$i, $row['stock_movement_desc'].'-'.$row['stock_movement_inv']); 
				$sheet->setCellValue('E'.$i, $row['stock_movement_before_stock']); 
				$sheet->setCellValue('F'.$i, $status.$row['stock_movement_qty']);
				$sheet->setCellValue('G'.$i, $row['stock_movement_new_stock']);
				$i++;
			};

			$sheet->getColumnDimension('A')->setWidth(55); 
			$sheet->getColumnDimension('B')->setWidth(35); 
			$sheet->getColumnDimension('C')->setWidth(35);
			$sheet->getColumnDimension('D')->setWidth(35);
			$sheet->getColumnDimension('E')->setWidth(35);
			$sheet->getColumnDimension('F')->setWidth(35);
			$sheet->getColumnDimension('G')->setWidth(35);

			$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
			$sheet->setTitle("Excell");
			ob_end_clean();
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="kartu_stock_' .date('Y-m-d') . '.xlsx"');
			header('Cache-Control: max-age=0');

			$xlsxWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($excel, 'Xlsx');
			$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($excel);
			exit($xlsxWriter->save('php://output'));
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}
    // End stok card


	

}

?>