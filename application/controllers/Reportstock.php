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

	// Report stok
	public function stockist()
	{
		$modul = 'Report';
		$check_auth = $this->check_auth($modul);
		if($check_auth['check_access'][0]->view == 'Y'){
            $category_list['category_list'] = $this->masterdata_model->category_list();
            $brand_list['brand_list'] = $this->masterdata_model->brand_list();
			$check_auth['check_auth'] = $check_auth;
			$data['data'] = array_merge($category_list, $brand_list, $check_auth);
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
		if($check_auth['check_access'][0]->view == 'Y'){
			$warehouse_report  = $this->input->get('warehouse_report');
        	$brand_report  = $this->input->get('brand_report');
        	$category_report = $this->input->get('category_report');


			$excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
			$sheet = $excel->getActiveSheet();

			// ===== JUDUL =====
			$sheet->setCellValue('A1', "LAPORAN STOK");
			$sheet->mergeCells('A1:D1');
			$sheet->getStyle('A1')->applyFromArray([
				'font'      => ['bold' => true, 'size' => 14, 'color' => ['argb' => 'FFFFFFFF']],
				'fill'      => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF1F4E79']],
				'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
			]);
			$sheet->getRowDimension(1)->setRowHeight(32);

			// ===== TANGGAL CETAK =====
			$sheet->setCellValue('A2', "Dicetak pada: " . date('d-m-Y H:i'));
			$sheet->mergeCells('A2:D2');
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
			$sheet->getStyle('A3:D3')->applyFromArray($headerStyle);
			$sheet->getRowDimension(3)->setRowHeight(28);

			$sheet->setCellValue('A3', "Nama Barang");
			$sheet->setCellValue('B3', "Kode Barang");
			$sheet->setCellValue('C3', "Gudang");
			$sheet->setCellValue('D3', "Stok");

			$data = $this->reportstock_model->get_report_stock($warehouse_report, $brand_report, $category_report)->result_array();
			$i = 4;
			$color_toggle = true;
			foreach($data as $row){
				$sheet->setCellValue('A'.$i, $row['product_name']);
				$sheet->setCellValue('B'.$i, $row['product_code']);
				$sheet->setCellValue('C'.$i, $row['warehouse_name']);
				$sheet->setCellValue('D'.$i, $row['stock']);
				$rowBgColor = $color_toggle ? 'FFDCE6F1' : 'FFFFFFFF';
				$color_toggle = !$color_toggle;
				$sheet->getStyle('A'.$i.':D'.$i)->applyFromArray([
					'fill'    => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => $rowBgColor]],
					'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => 'FFB8CCE4']]],
					'alignment' => ['vertical' => 'center'],
				]);
				$sheet->getRowDimension($i)->setRowHeight(18);
				$i++;
			}

			// ===== LEBAR KOLOM =====
			$sheet->getColumnDimension('A')->setWidth(55);
			$sheet->getColumnDimension('B')->setWidth(25);
			$sheet->getColumnDimension('C')->setWidth(30);
			$sheet->getColumnDimension('D')->setWidth(15);

			// ===== FORMAT ANGKA =====
			if ($i > 4) {
				$lastRow = $i - 1;
				$sheet->getStyle('D4:D'.$lastRow)->getNumberFormat()->setFormatCode('#,##0');
			}

			$sheet->freezePane('A4');
			$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
			$sheet->setTitle("Laporan Stok");
			ob_end_clean();
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="stock_' . date('Y-m-d') . '.xlsx"');
			header('Cache-Control: max-age=0');
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
		if($check_auth['check_access'][0]->view == 'Y'){
			$title['title'] = "Kartu Stok";
			$check_auth['check_auth'] = $check_auth;
			$data['data'] = array_merge($title, $check_auth);
			$this->load->view('Pages/Report/Stock/stockcard', $data);
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
		if($check_auth['check_access'][0]->view == 'Y'){
			$product_id       = $this->input->get('product_id');

			$excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
			$sheet = $excel->getActiveSheet();

			// ===== JUDUL =====
			$sheet->setCellValue('A1', "KARTU STOK");
			$sheet->mergeCells('A1:G1');
			$sheet->getStyle('A1')->applyFromArray([
				'font'      => ['bold' => true, 'size' => 14, 'color' => ['argb' => 'FFFFFFFF']],
				'fill'      => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF1F4E79']],
				'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
			]);
			$sheet->getRowDimension(1)->setRowHeight(32);

			// ===== TANGGAL CETAK =====
			$sheet->setCellValue('A2', "Dicetak pada: " . date('d-m-Y H:i'));
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

			$sheet->setCellValue('A3', "Nama Barang");
			$sheet->setCellValue('B3', "Kode Barang");
			$sheet->setCellValue('C3', "Tanggal");
			$sheet->setCellValue('D3', "Keterangan");
			$sheet->setCellValue('E3', "Stok Awal");
			$sheet->setCellValue('F3', "Qty");
			$sheet->setCellValue('G3', "Stok Akhir");

			$data = $this->reportstock_model->get_movement_stock($product_id)->result_array();
			$i = 4;
			$color_toggle = true;
			foreach($data as $row){
				$status = ($row['stock_movement_calculate'] == 'Plus') ? '+' : '-';
				$sheet->setCellValue('A'.$i, $row['product_name']);
				$sheet->setCellValue('B'.$i, $row['product_code']);
				$sheet->setCellValue('C'.$i, $row['stock_movement_date']);
				$sheet->setCellValue('D'.$i, $row['stock_movement_desc'] . ' - ' . $row['stock_movement_inv']);
				$sheet->setCellValue('E'.$i, $row['stock_movement_before_stock']);
				$sheet->setCellValue('F'.$i, $status . $row['stock_movement_qty']);
				$sheet->setCellValue('G'.$i, $row['stock_movement_new_stock']);
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
			$sheet->getColumnDimension('A')->setWidth(45);
			$sheet->getColumnDimension('B')->setWidth(20);
			$sheet->getColumnDimension('C')->setWidth(16);
			$sheet->getColumnDimension('D')->setWidth(45);
			$sheet->getColumnDimension('E')->setWidth(14);
			$sheet->getColumnDimension('F')->setWidth(12);
			$sheet->getColumnDimension('G')->setWidth(14);

			// ===== FORMAT ANGKA =====
			if ($i > 4) {
				$lastRow = $i - 1;
				$sheet->getStyle('E4:E'.$lastRow)->getNumberFormat()->setFormatCode('#,##0');
				$sheet->getStyle('G4:G'.$lastRow)->getNumberFormat()->setFormatCode('#,##0');
			}

			$sheet->freezePane('A4');
			$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
			$sheet->setTitle("Kartu Stok");
			ob_end_clean();
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="kartu_stock_' . date('Y-m-d') . '.xlsx"');
			header('Cache-Control: max-age=0');
			$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($excel);
			exit($xlsxWriter->save('php://output'));
		}else{
			$msg = "No Access";
			echo json_encode(['code'=>0, 'result'=>$msg]);die();
		}
	}
    // End stok card


    /* =====================================================================
     *  PROFIT & LOSS
     * ===================================================================== */

    public function profit_and_loss()
    {
        $modul = 'Report';
        $check_auth = $this->check_auth($modul);
        if ($check_auth['check_access'][0]->view == 'Y') {
            $check_auth['check_auth'] = $check_auth;
            $data['data'] = $check_auth;
            $this->load->view('Pages/Report/Stock/profit_and_loss', $data);
        } else {
            echo json_encode(['code' => 0, 'result' => 'No Access']); die();
        }
    }

    public function profit_and_loss_pdf()
    {
        $start_date = $this->input->get('start_date') ?: date('Y-m-01');
        $end_date   = $this->input->get('end_date')   ?: date('Y-m-d');

        $total_sales        = $this->reportstock_model->get_total_sales($start_date, $end_date);
        $total_retur_sales  = $this->reportstock_model->get_total_retur_sales($start_date, $end_date);
        $total_hpp          = $this->reportstock_model->get_total_hpp($start_date, $end_date);
        $total_hpp_retur    = $this->reportstock_model->get_total_hpp_retur($start_date, $end_date);
        $detail             = $this->reportstock_model->get_pl_detail_by_product($start_date, $end_date);

        $penjualan_bersih = $total_sales - $total_retur_sales;
        $hpp_bersih       = $total_hpp   - $total_hpp_retur;
        $laba_kotor       = $penjualan_bersih - $hpp_bersih;

        $data['data'] = compact(
            'start_date', 'end_date',
            'total_sales', 'total_retur_sales', 'penjualan_bersih',
            'total_hpp', 'total_hpp_retur', 'hpp_bersih',
            'laba_kotor', 'detail'
        );

        $htmlView = $this->load->view('Pages/Report/Stock/profit_and_loss_pdf', $data, true);
        $dompdf   = new Dompdf();
        $dompdf->loadHtml($htmlView);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('laba_rugi.pdf', ['Attachment' => false]);
        exit();
    }

    public function profit_and_loss_excell()
    {
        $modul = 'Report';
        $check_auth = $this->check_auth($modul);
        if ($check_auth['check_access'][0]->view == 'Y') {
            $start_date = $this->input->get('start_date') ?: date('Y-m-01');
            $end_date   = $this->input->get('end_date')   ?: date('Y-m-d');

            $total_sales       = $this->reportstock_model->get_total_sales($start_date, $end_date);
            $total_retur_sales = $this->reportstock_model->get_total_retur_sales($start_date, $end_date);
            $total_hpp         = $this->reportstock_model->get_total_hpp($start_date, $end_date);
            $total_hpp_retur   = $this->reportstock_model->get_total_hpp_retur($start_date, $end_date);
            $detail            = $this->reportstock_model->get_pl_detail_by_product($start_date, $end_date);

            $penjualan_bersih = $total_sales - $total_retur_sales;
            $hpp_bersih       = $total_hpp   - $total_hpp_retur;
            $laba_kotor       = $penjualan_bersih - $hpp_bersih;

            $excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $excel->getActiveSheet();
            $sheet->setTitle("Laba Rugi");

            $numFmt   = '#,##0';
            $colCount = 6; // A-F

            // ── Title ──
            $sheet->setCellValue('A1', 'CV. ANUGRAH HARAPAN UTAMA');
            $sheet->mergeCells('A1:F1');
            $sheet->getStyle('A1')->applyFromArray([
                'font'      => ['bold' => true, 'size' => 14, 'color' => ['argb' => 'FFFFFFFF']],
                'fill'      => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF1F4E79']],
                'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
            ]);
            $sheet->getRowDimension(1)->setRowHeight(30);

            $sheet->setCellValue('A2', 'LAPORAN LABA RUGI');
            $sheet->mergeCells('A2:F2');
            $sheet->getStyle('A2')->applyFromArray([
                'font'      => ['bold' => true, 'size' => 12, 'color' => ['argb' => 'FF1F4E79']],
                'fill'      => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFD6E4F0']],
                'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
            ]);
            $sheet->getRowDimension(2)->setRowHeight(22);

            $sheet->setCellValue('A3', 'Periode: ' . date('d/m/Y', strtotime($start_date)) . ' s/d ' . date('d/m/Y', strtotime($end_date)));
            $sheet->mergeCells('A3:F3');
            $sheet->getStyle('A3')->applyFromArray([
                'font'      => ['italic' => true, 'size' => 10, 'color' => ['argb' => 'FF444444']],
                'alignment' => ['horizontal' => 'center'],
            ]);
            $sheet->getRowDimension(3)->setRowHeight(16);

            // ── Summary ──
            $summaryStyle = [
                'font'      => ['bold' => true],
                'fill'      => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFEBF3FB']],
                'borders'   => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => 'FFB8CCE4']]],
                'alignment' => ['vertical' => 'center'],
            ];
            $labelCol = 'A'; $valCol = 'F';
            $rows = [
                5  => ['label' => 'PENDAPATAN', 'val' => null, 'header' => true, 'color' => 'FF1F4E79', 'txtColor' => 'FFFFFFFF'],
                6  => ['label' => 'Penjualan Bruto',       'val' => $total_sales],
                7  => ['label' => 'Retur Penjualan',       'val' => '(' . $total_retur_sales . ')'],
                8  => ['label' => 'Penjualan Bersih',      'val' => $penjualan_bersih, 'bold' => true],
                9  => ['label' => 'HARGA POKOK PENJUALAN', 'val' => null, 'header' => true, 'color' => 'FF2E75B6', 'txtColor' => 'FFFFFFFF'],
                10 => ['label' => 'HPP (biaya pokok penjualan)', 'val' => $total_hpp],
                11 => ['label' => 'Retur HPP',             'val' => '(' . $total_hpp_retur . ')'],
                12 => ['label' => 'HPP Bersih',            'val' => $hpp_bersih, 'bold' => true],
                13 => ['label' => ($laba_kotor >= 0 ? 'LABA KOTOR' : 'RUGI KOTOR'), 'val' => $laba_kotor, 'header' => true,
                        'color' => ($laba_kotor >= 0 ? 'FF1F7A1F' : 'FF7A1F1F'), 'txtColor' => 'FFFFFFFF'],
            ];

            foreach ($rows as $r => $row) {
                $sheet->mergeCells('A'.$r.':E'.$r);
                $sheet->setCellValue('A'.$r, $row['label']);
                if ($row['val'] !== null) {
                    $sheet->setCellValue('F'.$r, $row['val']);
                }
                if (!empty($row['header'])) {
                    $sheet->getStyle('A'.$r.':F'.$r)->applyFromArray([
                        'font'      => ['bold' => true, 'color' => ['argb' => $row['txtColor']]],
                        'fill'      => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => $row['color']]],
                        'borders'   => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => 'FFFFFFFF']]],
                    ]);
                } else {
                    $style = $summaryStyle;
                    if (!empty($row['bold'])) { $style['font'] = ['bold' => true]; }
                    $sheet->getStyle('A'.$r.':F'.$r)->applyFromArray($style);
                }
                if (is_numeric($row['val'])) {
                    $sheet->getStyle('F'.$r)->getNumberFormat()->setFormatCode($numFmt);
                }
                $sheet->getRowDimension($r)->setRowHeight(20);
            }

            // ── Detail table ──
            $startRow = 15;
            $sheet->setCellValue('A'.$startRow, 'RINCIAN PER PRODUK');
            $sheet->mergeCells('A'.$startRow.':F'.$startRow);
            $sheet->getStyle('A'.$startRow)->applyFromArray([
                'font'      => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill'      => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF1F4E79']],
                'alignment' => ['horizontal' => 'center'],
            ]);
            $sheet->getRowDimension($startRow)->setRowHeight(20);

            $hRow = $startRow + 1;
            $headers = ['No', 'Kode Produk', 'Nama Produk', 'Qty Terjual', 'Total Penjualan', 'Laba'];
            $cols    = ['A', 'B', 'C', 'D', 'E', 'F'];
            foreach ($headers as $i => $h) {
                $sheet->setCellValue($cols[$i].$hRow, $h);
            }
            $sheet->getStyle('A'.$hRow.':F'.$hRow)->applyFromArray([
                'font'      => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill'      => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF2E75B6']],
                'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
                'borders'   => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => 'FFFFFFFF']]],
            ]);
            $sheet->getRowDimension($hRow)->setRowHeight(22);

            $i = $hRow + 1;
            $no = 1;
            $toggle = true;
            foreach ($detail as $row) {
                $sheet->setCellValue('A'.$i, $no++);
                $sheet->setCellValue('B'.$i, $row['product_code']);
                $sheet->setCellValue('C'.$i, $row['product_name']);
                $sheet->setCellValue('D'.$i, $row['qty_jual']);
                $sheet->setCellValue('E'.$i, $row['total_jual']);
                $sheet->setCellValue('F'.$i, $row['laba']);
                $bg = $toggle ? 'FFDCE6F1' : 'FFFFFFFF';
                $toggle = !$toggle;
                $sheet->getStyle('A'.$i.':F'.$i)->applyFromArray([
                    'fill'    => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => $bg]],
                    'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => 'FFB8CCE4']]],
                ]);
                $sheet->getStyle('D'.$i.':F'.$i)->getNumberFormat()->setFormatCode($numFmt);
                $sheet->getRowDimension($i)->setRowHeight(18);
                $i++;
            }

            $sheet->getColumnDimension('A')->setWidth(6);
            $sheet->getColumnDimension('B')->setWidth(16);
            $sheet->getColumnDimension('C')->setWidth(40);
            $sheet->getColumnDimension('D')->setWidth(14);
            $sheet->getColumnDimension('E')->setWidth(20);
            $sheet->getColumnDimension('F')->setWidth(20);

            $sheet->freezePane('A'.$hRow);
            ob_end_clean();
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="laba_rugi_' . date('Y-m-d') . '.xlsx"');
            header('Cache-Control: max-age=0');
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($excel);
            exit($writer->save('php://output'));
        } else {
            echo json_encode(['code' => 0, 'result' => 'No Access']); die();
        }
    }
    // End Profit & Loss



}

?>