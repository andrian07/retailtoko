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
			$end_date         = $this->input->get('end_date');
			$supplier_report  = $this->input->get('supplier_report');
			$status_pembelian = $this->input->get('status_pembelian');

			$excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
			$sheet = $excel->getActiveSheet();

			// ===== JUDUL =====
			$sheet->setCellValue('A1', "LAPORAN PURCHASE ORDER");
			$sheet->mergeCells('A1:R1');
			$sheet->getStyle('A1')->applyFromArray([
				'font'      => ['bold' => true, 'size' => 14, 'color' => ['argb' => 'FFFFFFFF']],
				'fill'      => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF1F4E79']],
				'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
			]);
			$sheet->getRowDimension(1)->setRowHeight(32);

			// ===== PERIODE =====
			$sheet->setCellValue('A2', "Periode: " . $start_date . "  s/d  " . $end_date);
			$sheet->mergeCells('A2:R2');
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
			$sheet->getStyle('A3:R3')->applyFromArray($headerStyle);
			$sheet->getRowDimension(3)->setRowHeight(28);

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
			$sheet->setCellValue('K3', "Status");
			$sheet->setCellValue('L3', "Catatan PO");
			$sheet->setCellValue('M3', "Kode Barang");
			$sheet->setCellValue('N3', "Nama Barang");
			$sheet->setCellValue('O3', "Harga");
			$sheet->setCellValue('P3', "Qty");
			$sheet->setCellValue('Q3', "Total Item");
			$sheet->setCellValue('R3', "Total Invoice");

			$data = $this->reportpurchase_model->get_report_po($start_date, $end_date, $supplier_report, $status_pembelian)->result_array();
			$i = 4;

			$last_po_invoice  = '';
			$group_start_row  = 4;
			$color_toggle     = true;
			// Kolom header PO yang akan di-merge jika invoice sama
			$merge_cols = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'R'];

			foreach ($data as $row) {
				$is_new_invoice = ($row['hd_po_invoice'] !== $last_po_invoice);

				if ($is_new_invoice) {
					// Merge sel header invoice sebelumnya jika lebih dari 1 baris
					if (!empty($last_po_invoice) && ($i - 1) > $group_start_row) {
						foreach ($merge_cols as $col) {
							$sheet->mergeCells($col . $group_start_row . ':' . $col . ($i - 1));
							$sheet->getStyle($col . $group_start_row . ':' . $col . ($i - 1))
								->getAlignment()->setVertical('center');
						}
					}
					$group_start_row = $i;
					$color_toggle    = !$color_toggle;
					$last_po_invoice = $row['hd_po_invoice'];

					// Tulis data header invoice (hanya 1x per invoice)
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
					$sheet->setCellValue('R'.$i, $row['hd_po_grand_total']);
				}

				// Selalu tampilkan detail produk di setiap baris
				$sheet->setCellValue('M'.$i, $row['product_code']);
				$sheet->setCellValue('N'.$i, $row['product_name']);
				$sheet->setCellValue('O'.$i, $row['dt_po_price']);
				$sheet->setCellValue('P'.$i, $row['dt_po_qty']);
				$sheet->setCellValue('Q'.$i, $row['dt_po_total']);

				// Warna baris bergantian per grup invoice
				$rowBgColor = $color_toggle ? 'FFDCE6F1' : 'FFFFFFFF';
				$sheet->getStyle('A'.$i.':R'.$i)->applyFromArray([
					'fill'      => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => $rowBgColor]],
					'borders'   => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => 'FFB8CCE4']]],
					'alignment' => ['vertical' => 'center'],
				]);
				$sheet->getRowDimension($i)->setRowHeight(18);
				$i++;
			}

			// Merge sel header invoice untuk grup terakhir
			if (!empty($last_po_invoice) && ($i - 1) > $group_start_row) {
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
			$sheet->getColumnDimension('D')->setWidth(10);
			$sheet->getColumnDimension('E')->setWidth(14);
			$sheet->getColumnDimension('F')->setWidth(15);
			$sheet->getColumnDimension('G')->setWidth(18);
			$sheet->getColumnDimension('H')->setWidth(18);
			$sheet->getColumnDimension('I')->setWidth(18);
			$sheet->getColumnDimension('J')->setWidth(15);
			$sheet->getColumnDimension('K')->setWidth(14);
			$sheet->getColumnDimension('L')->setWidth(25);
			$sheet->getColumnDimension('M')->setWidth(18);
			$sheet->getColumnDimension('N')->setWidth(35);
			$sheet->getColumnDimension('O')->setWidth(18);
			$sheet->getColumnDimension('P')->setWidth(8);
			$sheet->getColumnDimension('Q')->setWidth(18);
			$sheet->getColumnDimension('R')->setWidth(18);

			// ===== FORMAT ANGKA (hanya pada range data) =====
			if ($i > 4) {
				$lastRow = $i - 1;
				$sheet->getStyle('G4:G'.$lastRow)->getNumberFormat()->setFormatCode('#,##0');
				$sheet->getStyle('H4:H'.$lastRow)->getNumberFormat()->setFormatCode('#,##0');
				$sheet->getStyle('I4:I'.$lastRow)->getNumberFormat()->setFormatCode('#,##0');
				$sheet->getStyle('J4:J'.$lastRow)->getNumberFormat()->setFormatCode('#,##0');
				$sheet->getStyle('O4:O'.$lastRow)->getNumberFormat()->setFormatCode('#,##0');
				$sheet->getStyle('Q4:Q'.$lastRow)->getNumberFormat()->setFormatCode('#,##0');
				$sheet->getStyle('R4:R'.$lastRow)->getNumberFormat()->setFormatCode('#,##0');
			}

			$sheet->freezePane('A4');
			$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
			$sheet->setTitle("Laporan PO");

			ob_end_clean();
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="po_' . date('Y-m-d') . '.xlsx"');
			header('Cache-Control: max-age=0');

			$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($excel);
			exit($xlsxWriter->save('php://output'));
		} else {
			$msg = "No Access";
			echo json_encode(['code' => 0, 'result' => $msg]); die();
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
		$status 		  = $this->input->get('status');	


		$data['data'] = $this->reportpurchase_model->get_report_hd_purchases($start_date, $end_date, $supplier_report, $status)->result_array();
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
			$start_date      = $this->input->get('start_date');
			$end_date        = $this->input->get('end_date');
			$supplier_report = $this->input->get('supplier_report');
			$status 		  = $this->input->get('status');

			$excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
			$sheet = $excel->getActiveSheet();

			// ===== JUDUL =====
			$sheet->setCellValue('A1', "LAPORAN PEMBELIAN");
			$sheet->mergeCells('A1:Q1');
			$sheet->getStyle('A1')->applyFromArray([
				'font'      => ['bold' => true, 'size' => 14, 'color' => ['argb' => 'FFFFFFFF']],
				'fill'      => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF1F4E79']],
				'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
			]);
			$sheet->getRowDimension(1)->setRowHeight(32);

			// ===== PERIODE =====
			$sheet->setCellValue('A2', "Periode: " . $start_date . "  s/d  " . $end_date);
			$sheet->mergeCells('A2:Q2');
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
			$sheet->getStyle('A3:Q3')->applyFromArray($headerStyle);
			$sheet->getRowDimension(3)->setRowHeight(28);

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
			$sheet->setCellValue('Q3', "Total Invoice");

			$data = $this->reportpurchase_model->get_report_purchases($start_date, $end_date, $supplier_report)->result_array();
			$i = 4;

			$last_invoice    = '';
			$group_start_row = 4;
			$color_toggle    = true;
			$merge_cols      = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'Q'];

			foreach ($data as $row) {
				$is_new_invoice = ($row['hd_purchase_invoice'] !== $last_invoice);

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
					$last_invoice    = $row['hd_purchase_invoice'];

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
					$sheet->setCellValue('Q'.$i, $row['hd_purchase_grand_total']);
				}

				$sheet->setCellValue('L'.$i, $row['product_code']);
				$sheet->setCellValue('M'.$i, $row['product_name']);
				$sheet->setCellValue('N'.$i, $row['dt_purchase_price']);
				$sheet->setCellValue('O'.$i, $row['dt_purchase_qty']);
				$sheet->setCellValue('P'.$i, $row['dt_purchase_total']);

				$rowBgColor = $color_toggle ? 'FFDCE6F1' : 'FFFFFFFF';
				$sheet->getStyle('A'.$i.':Q'.$i)->applyFromArray([
					'fill'      => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => $rowBgColor]],
					'borders'   => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => 'FFB8CCE4']]],
					'alignment' => ['vertical' => 'center'],
				]);
				$sheet->getRowDimension($i)->setRowHeight(18);
				$i++;
			}

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
			$sheet->getColumnDimension('D')->setWidth(10);
			$sheet->getColumnDimension('E')->setWidth(14);
			$sheet->getColumnDimension('F')->setWidth(15);
			$sheet->getColumnDimension('G')->setWidth(18);
			$sheet->getColumnDimension('H')->setWidth(18);
			$sheet->getColumnDimension('I')->setWidth(18);
			$sheet->getColumnDimension('J')->setWidth(15);
			$sheet->getColumnDimension('K')->setWidth(25);
			$sheet->getColumnDimension('L')->setWidth(18);
			$sheet->getColumnDimension('M')->setWidth(35);
			$sheet->getColumnDimension('N')->setWidth(18);
			$sheet->getColumnDimension('O')->setWidth(8);
			$sheet->getColumnDimension('P')->setWidth(18);
			$sheet->getColumnDimension('Q')->setWidth(18);

			// ===== FORMAT ANGKA =====
			if ($i > 4) {
				$lastRow = $i - 1;
				$sheet->getStyle('G4:G'.$lastRow)->getNumberFormat()->setFormatCode('#,##0');
				$sheet->getStyle('H4:H'.$lastRow)->getNumberFormat()->setFormatCode('#,##0');
				$sheet->getStyle('I4:I'.$lastRow)->getNumberFormat()->setFormatCode('#,##0');
				$sheet->getStyle('J4:J'.$lastRow)->getNumberFormat()->setFormatCode('#,##0');
				$sheet->getStyle('N4:N'.$lastRow)->getNumberFormat()->setFormatCode('#,##0');
				$sheet->getStyle('P4:P'.$lastRow)->getNumberFormat()->setFormatCode('#,##0');
				$sheet->getStyle('Q4:Q'.$lastRow)->getNumberFormat()->setFormatCode('#,##0');
			}

			$sheet->freezePane('A4');
			$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
			$sheet->setTitle("Laporan Pembelian");

			ob_end_clean();
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="pembelian_' . date('Y-m-d') . '.xlsx"');
			header('Cache-Control: max-age=0');

			$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($excel);
			exit($xlsxWriter->save('php://output'));
		} else {
			$msg = "No Access";
			echo json_encode(['code' => 0, 'result' => $msg]); die();
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
		$status 		  = $this->input->get('status');

		$data['data'] = $this->reportpurchase_model->get_report_retur_hd_purchases($start_date, $end_date, $supplier_report, $status)->result_array();
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
			$end_date         = $this->input->get('end_date');
			$status 			= $this->input->get('status');
			$supplier_report  = $this->input->get('supplier_report');

			$excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
			$sheet = $excel->getActiveSheet();

			// ===== JUDUL =====
			$sheet->setCellValue('A1', "LAPORAN RETUR PEMBELIAN");
			$sheet->mergeCells('A1:L1');
			$sheet->getStyle('A1')->applyFromArray([
				'font'      => ['bold' => true, 'size' => 14, 'color' => ['argb' => 'FFFFFFFF']],
				'fill'      => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF1F4E79']],
				'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
			]);
			$sheet->getRowDimension(1)->setRowHeight(32);

			// ===== PERIODE =====
			$sheet->setCellValue('A2', "Periode: " . $start_date . "  s/d  " . $end_date);
			$sheet->mergeCells('A2:L2');
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
			$sheet->getStyle('A3:L3')->applyFromArray($headerStyle);
			$sheet->getRowDimension(3)->setRowHeight(28);

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

			$data = $this->reportpurchase_model->get_report_retur_purchases($start_date, $end_date, $supplier_report, $status)->result_array();
			$i = 4;

			$last_invoice    = '';
			$group_start_row = 4;
			$color_toggle    = true;
			// Kolom invoice-level yang di-merge: A, B, C (header) + I, J, K, L (ringkasan transaksi)
			$merge_cols = ['A', 'B', 'C', 'I', 'J', 'K', 'L'];

			foreach ($data as $row) {
				$is_new_invoice = ($row['hd_retur_purchase_inv'] !== $last_invoice);

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
					$last_invoice    = $row['hd_retur_purchase_inv'];

					$sheet->setCellValue('A'.$i, $row['hd_retur_purchase_inv']);
					$sheet->setCellValue('B'.$i, $row['hd_retur_purchase_date']);
					$sheet->setCellValue('C'.$i, $row['supplier_name']);
					$sheet->setCellValue('I'.$i, $row['hd_retur_purchase_note']);
					$sheet->setCellValue('J'.$i, $row['hd_retur_purchase_total']);
					$sheet->setCellValue('K'.$i, $row['hd_retur_purchase_status']);
					$sheet->setCellValue('L'.$i, $row['hd_retur_purchase_payment_type']);
				}

				$sheet->setCellValue('D'.$i, $row['product_name']);
				$sheet->setCellValue('E'.$i, $row['unit_name']);
				$sheet->setCellValue('F'.$i, $row['dt_retur_purchase_price']);
				$sheet->setCellValue('G'.$i, $row['dt_retur_purchase_qty']);
				$sheet->setCellValue('H'.$i, $row['dt_retur_purchase_total']);

				$rowBgColor = $color_toggle ? 'FFDCE6F1' : 'FFFFFFFF';
				$sheet->getStyle('A'.$i.':L'.$i)->applyFromArray([
					'fill'      => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => $rowBgColor]],
					'borders'   => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => 'FFB8CCE4']]],
					'alignment' => ['vertical' => 'center'],
				]);
				$sheet->getRowDimension($i)->setRowHeight(18);
				$i++;
			}

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
			$sheet->getColumnDimension('D')->setWidth(35);
			$sheet->getColumnDimension('E')->setWidth(15);
			$sheet->getColumnDimension('F')->setWidth(18);
			$sheet->getColumnDimension('G')->setWidth(12);
			$sheet->getColumnDimension('H')->setWidth(18);
			$sheet->getColumnDimension('I')->setWidth(25);
			$sheet->getColumnDimension('J')->setWidth(18);
			$sheet->getColumnDimension('K')->setWidth(15);
			$sheet->getColumnDimension('L')->setWidth(18);

			// ===== FORMAT ANGKA =====
			if ($i > 4) {
				$lastRow = $i - 1;
				$sheet->getStyle('F4:F'.$lastRow)->getNumberFormat()->setFormatCode('#,##0');
				$sheet->getStyle('H4:H'.$lastRow)->getNumberFormat()->setFormatCode('#,##0');
				$sheet->getStyle('J4:J'.$lastRow)->getNumberFormat()->setFormatCode('#,##0');
			}

			$sheet->freezePane('A4');
			$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
			$sheet->setTitle("Laporan Retur Pembelian");

			ob_end_clean();
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="retur_pembelian_' . date('Y-m-d') . '.xlsx"');
			header('Cache-Control: max-age=0');

			$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($excel);
			exit($xlsxWriter->save('php://output'));
		} else {
			$msg = "No Access";
			echo json_encode(['code' => 0, 'result' => $msg]); die();
		}
	}

	// End Report Retur Purchase

}

?>