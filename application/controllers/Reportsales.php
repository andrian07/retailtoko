<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
date_default_timezone_set('Asia/Jakarta');
require 'vendor/autoload.php';

use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Reportsales extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('global_model');
		$this->load->model('reportsales_model');
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

	



    // Report Sales
    public function reportsaless()
	{
		$modul = 'Report';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->view == 'Y'){
			$customer_list['customer_list'] = $this->masterdata_model->customer_list();
			$check_auth['check_auth'] = $check_auth;
			$data['data'] = array_merge($customer_list, $check_auth);
			$this->load->view('Pages/Report/Sales/reportsaless', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}
    
    public function reportsalesspdf()
    {
        $start_date       = $this->input->get('start_date');
		$end_date 	      = $this->input->get('end_date');
		$customer_report  = $this->input->get('customer_report');
		$status           = $this->input->get('status');
		
		$data['data'] = $this->reportsales_model->get_report_hd_sales($start_date, $end_date, $customer_report, $status)->result_array();
		$htmlView   = $this->load->view('Pages/Report/Sales/reportsalespdf', $data, true);
		$dompdf = new Dompdf();
		$dompdf->loadHtml($htmlView);
		$dompdf->setPaper('A4', 'landscape');
		$dompdf->render();
		$dompdf->stream('penjualan.pdf', array("Attachment" => false));
		exit();
    }

	public function reportsaless_excell()
	{
		$modul = 'Report';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->view == 'Y'){
			$start_date      = $this->input->get('start_date');
			$end_date        = $this->input->get('end_date');
			$customer_report = $this->input->get('customer_report');
			$status          = $this->input->get('status');

			$excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
			$sheet = $excel->getActiveSheet();

			// ===== JUDUL =====
			$sheet->setCellValue('A1', "LAPORAN PENJUALAN");
			$sheet->mergeCells('A1:O1');
			$sheet->getStyle('A1')->applyFromArray([
				'font'      => ['bold' => true, 'size' => 14, 'color' => ['argb' => 'FFFFFFFF']],
				'fill'      => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF1F4E79']],
				'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
			]);
			$sheet->getRowDimension(1)->setRowHeight(32);

			// ===== PERIODE =====
			$sheet->setCellValue('A2', "Periode: " . $start_date . "  s/d  " . $end_date);
			$sheet->mergeCells('A2:O2');
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
			$sheet->getStyle('A3:O3')->applyFromArray($headerStyle);
			$sheet->getRowDimension(3)->setRowHeight(28);

			$sheet->setCellValue('A3', "Invoice");
			$sheet->setCellValue('B3', "Tanggal");
			$sheet->setCellValue('C3', "Pelanggan");
			$sheet->setCellValue('D3', "Pembayaran");
			$sheet->setCellValue('E3', "Nama Barang");
			$sheet->setCellValue('F3', "Satuan");
			$sheet->setCellValue('G3', "Qty");
			$sheet->setCellValue('H3', "Harga");
			$sheet->setCellValue('I3', "Total Harga Barang");
			$sheet->setCellValue('J3', "Subtotal");
			$sheet->setCellValue('K3', "Diskon");
			$sheet->setCellValue('L3', "PPN");
			$sheet->setCellValue('M3', "Total");
			$sheet->setCellValue('N3', "Catatan");
			$sheet->setCellValue('O3', "Di Buat Oleh");

			$data = $this->reportsales_model->get_report_sales($start_date, $end_date, $customer_report, $status)->result_array();
			$i = 4;

			$last_invoice    = '';
			$group_start_row = 4;
			$color_toggle    = true;
			// Kolom header invoice yang akan di-merge jika invoice sama
			$merge_cols = ['A', 'B', 'C', 'D', 'J', 'K', 'L', 'M', 'N', 'O'];

			foreach ($data as $row) {
				$is_new_invoice = ($row['hd_sales_inv'] !== $last_invoice);

				if ($is_new_invoice) {
					if (!empty($last_invoice) && ($i - 1) > $group_start_row) {
						foreach ($merge_cols as $col) {
							$sheet->mergeCells($col . $group_start_row . ':' . $col . ($i - 1));
							$sheet->getStyle($col . $group_start_row . ':' . $col . ($i - 1))
								->getAlignment()->setVertical('center');
						}
					}
					$group_start_row = $i;
					$color_toggle    = !$color_toggle;
					$last_invoice    = $row['hd_sales_inv'];

					$sheet->setCellValue('A'.$i, $row['hd_sales_inv']);
					$sheet->setCellValue('B'.$i, $row['hd_sales_date']);
					$sheet->setCellValue('C'.$i, $row['customer_name']);
					$sheet->setCellValue('D'.$i, $row['payment_name']);
					$sheet->setCellValue('J'.$i, $row['hd_sales_sub_total']);
					$sheet->setCellValue('K'.$i, $row['hd_sales_total_discount']);
					$sheet->setCellValue('L'.$i, $row['hd_sales_ppn']);
					$sheet->setCellValue('M'.$i, $row['hd_sales_total']);
					$sheet->setCellValue('N'.$i, $row['hd_sales_note']);
					$sheet->setCellValue('O'.$i, $row['user_name']);
				}

				// Selalu tampilkan detail produk di setiap baris
				$sheet->setCellValue('E'.$i, $row['product_name']);
				$sheet->setCellValue('F'.$i, $row['unit_name']);
				$sheet->setCellValue('G'.$i, $row['dt_sales_qty']);
				$sheet->setCellValue('H'.$i, $row['dt_sales_price']);
				$sheet->setCellValue('I'.$i, $row['dt_sales_total']);

				// Warna baris bergantian per grup invoice
				$rowBgColor = $color_toggle ? 'FFDCE6F1' : 'FFFFFFFF';
				$sheet->getStyle('A'.$i.':O'.$i)->applyFromArray([
					'fill'      => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => $rowBgColor]],
					'borders'   => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => 'FFB8CCE4']]],
					'alignment' => ['vertical' => 'center'],
				]);
				$sheet->getRowDimension($i)->setRowHeight(18);
				$i++;
			}

			// Merge sel header invoice untuk grup terakhir
			if (!empty($last_invoice) && ($i - 1) > $group_start_row) {
				foreach ($merge_cols as $col) {
					$sheet->mergeCells($col . $group_start_row . ':' . $col . ($i - 1));
					$sheet->getStyle($col . $group_start_row . ':' . $col . ($i - 1))
						->getAlignment()->setVertical('center');
				}
			}

			// ===== LEBAR KOLOM =====
			$sheet->getColumnDimension('A')->setWidth(35);
			$sheet->getColumnDimension('B')->setWidth(14);
			$sheet->getColumnDimension('C')->setWidth(25);
			$sheet->getColumnDimension('D')->setWidth(18);
			$sheet->getColumnDimension('E')->setWidth(35);
			$sheet->getColumnDimension('F')->setWidth(15);
			$sheet->getColumnDimension('G')->setWidth(8);
			$sheet->getColumnDimension('H')->setWidth(18);
			$sheet->getColumnDimension('I')->setWidth(22);
			$sheet->getColumnDimension('J')->setWidth(18);
			$sheet->getColumnDimension('K')->setWidth(15);
			$sheet->getColumnDimension('L')->setWidth(15);
			$sheet->getColumnDimension('M')->setWidth(18);
			$sheet->getColumnDimension('N')->setWidth(30);
			$sheet->getColumnDimension('O')->setWidth(20);

			// ===== FORMAT ANGKA (hanya pada range data) =====
			if ($i > 4) {
				$lastRow = $i - 1;
				$sheet->getStyle('H4:H'.$lastRow)->getNumberFormat()->setFormatCode('#,##0');
				$sheet->getStyle('I4:I'.$lastRow)->getNumberFormat()->setFormatCode('#,##0');
				$sheet->getStyle('J4:J'.$lastRow)->getNumberFormat()->setFormatCode('#,##0');
				$sheet->getStyle('K4:K'.$lastRow)->getNumberFormat()->setFormatCode('#,##0');
				$sheet->getStyle('L4:L'.$lastRow)->getNumberFormat()->setFormatCode('#,##0');
				$sheet->getStyle('M4:M'.$lastRow)->getNumberFormat()->setFormatCode('#,##0');
			}

			$sheet->freezePane('A4');
			$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
			$sheet->setTitle("Laporan Penjualan");

			ob_end_clean();
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="sales_' . date('Y-m-d') . '.xlsx"');
			header('Cache-Control: max-age=0');

			$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($excel);
			exit($xlsxWriter->save('php://output'));
		} else {
			$msg = "No Access";
			echo json_encode(['code' => 0, 'result' => $msg]); die();
		}
	}
    // End Report Sales

	// Report Retur Sales
    public function reportretursales()
	{
		$modul = 'Report';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->view == 'Y'){
			$customer_list['customer_list'] = $this->masterdata_model->customer_list();
            $salesman_list['salesman_list'] = $this->masterdata_model->salesman_list();
            $warehouse_list['warehouse_list'] = $this->masterdata_model->warehouse_list();
			$check_auth['check_auth'] = $check_auth;
			$data['data'] = array_merge($customer_list, $salesman_list, $warehouse_list, $check_auth);
			$this->load->view('Pages/Report/Sales/reportretursales', $data);
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}
    
    public function reportretursalespdf()
    {
        $start_date       = $this->input->get('start_date');
		$end_date 	      = $this->input->get('end_date');
		$customer_report  = $this->input->get('customer_report');

		$data['data'] = $this->reportsales_model->get_report_retur_sales($start_date, $end_date, $customer_report)->result_array();
		$htmlView   = $this->load->view('Pages/Report/Sales/reportretursalespdf', $data, true);
		$dompdf = new Dompdf();
		$dompdf->loadHtml($htmlView);
		$dompdf->setPaper('A4', 'landscape');
		$dompdf->render();
		$dompdf->stream('retursales.pdf', array("Attachment" => false));
		exit();
    }

	public function reportretursales_excell()
	{
		$modul = 'Report';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->view == 'Y'){
			$start_date       = $this->input->get('start_date');
			$end_date 	      = $this->input->get('end_date');
		    $customer_report  = $this->input->get('customer_report');

			$excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
			$sheet = $excel->getActiveSheet();
			$sheet->setCellValue('A1', "Laporan Retur Penjualan"); 
			$sheet->mergeCells('A1:O1');
			$sheet->getStyle('A1')->getFont()->setBold(true);
			$sheet->getStyle('A3:O3')->getFont()->setBold(true);
			$sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
			$sheet->getStyle('A3:O3')->getAlignment()->setHorizontal('center');
			$sheet->setCellValue('A3', "Invoice"); 
			$sheet->setCellValue('B3', "Tanggal"); 
			$sheet->setCellValue('C3', "Pelanggan"); 
			$sheet->setCellValue('D3', "Rate"); 
            $sheet->setCellValue('E3', "Nama Barang");
            $sheet->setCellValue('F3', "Satuan");
            $sheet->setCellValue('G3', "Qty");
            $sheet->setCellValue('H3', "Harga");
            $sheet->setCellValue('I3', "Total Harga Barang");
			$sheet->setCellValue('J3', "Catatan Barang");
            $sheet->setCellValue('K3', "Total");
			$sheet->setCellValue('L3', "Status Retur");
			$sheet->setCellValue('M3', "Jenis Pembayaran");
            $sheet->setCellValue('N3', "Catatan");
            $sheet->setCellValue('O3', "Di Buat Oleh");

			$data = $this->reportsales_model->get_report_retur_sales($start_date, $end_date, $customer_report, $salesman_report, $warehouse_report)->result_array();
			$i = 4;

			foreach($data as $row){
				$sheet->setCellValue('A'.$i, $row['hd_retur_sales_inv']); 
				$sheet->setCellValue('B'.$i, $row['hd_retur_sales_date']); 
				$sheet->setCellValue('C'.$i, $row['customer_name']);
				$sheet->setCellValue('D'.$i, $row['customer_rate']); 
				$sheet->setCellValue('E'.$i, $row['product_name']); 
				$sheet->setCellValue('F'.$i, $row['unit_name']); 
				$sheet->setCellValue('G'.$i, $row['dt_retur_sales_qty']);
				$sheet->setCellValue('H'.$i, $row['dt_retur_sales_price']);
				$sheet->setCellValue('I'.$i, $row['dt_retur_sales_total']);
				$sheet->setCellValue('J'.$i, $row['dt_retur_sales_note']); 
				$sheet->setCellValue('K'.$i, $row['hd_retur_sales_total']);
                $sheet->setCellValue('L'.$i, $row['hd_retur_sales_status']); 
				if($row['hd_retur_sales_payment_type'] == 'PN'){
                	$sheet->setCellValue('M'.$i, 'Potong Nota'); 
				}else if($row['hd_retur_sales_payment_type'] == 'Cash'){
                	$sheet->setCellValue('M'.$i, 'Cash'); 
				}else{
					$sheet->setCellValue('M'.$i, 'Garansi'); 
				}
                $sheet->setCellValue('N'.$i, $row['hd_retur_sales_note']); 
                $sheet->setCellValue('O'.$i, $row['user_name']); 
				$i++;
			};

			$sheet->getColumnDimension('A')->setWidth(35); 
			$sheet->getColumnDimension('B')->setWidth(25); 
			$sheet->getColumnDimension('C')->setWidth(35);
			$sheet->getColumnDimension('D')->setWidth(35);
			$sheet->getColumnDimension('E')->setWidth(65);
			$sheet->getColumnDimension('F')->setWidth(20);
			$sheet->getColumnDimension('G')->setWidth(30);
			$sheet->getColumnDimension('H')->setWidth(30);
			$sheet->getColumnDimension('I')->setWidth(45);
			$sheet->getColumnDimension('J')->setWidth(30);
            $sheet->getColumnDimension('K')->setWidth(30);
            $sheet->getColumnDimension('L')->setWidth(30);
            $sheet->getColumnDimension('M')->setWidth(45);
            $sheet->getColumnDimension('N')->setWidth(30);


            $sheet->getStyle('H')->getNumberFormat()->setFormatCode('#,##0');	
            $sheet->getStyle('I')->getNumberFormat()->setFormatCode('#,##0');	
			$sheet->getStyle('K')->getNumberFormat()->setFormatCode('#,##0');


			$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
			$sheet->setTitle("Excell");
			ob_end_clean();
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="laporan_retur_sales_' .date('Y-m-d') . '.xlsx"');
			header('Cache-Control: max-age=0');

			$xlsxWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($excel, 'Xlsx');
			$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($excel);
			exit($xlsxWriter->save('php://output'));
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}
    // End Report Sales

	// Report Retur Sales

	
	// End report Retur Sales

}

?>