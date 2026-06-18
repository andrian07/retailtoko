<?php

class reportpurchase_model extends CI_Model {

    public function get_report_submission($start_date, $end_date, $warehouse_report, $status)
    {
        if($start_date == null){
            $start_date = date('Y-m-01');
        }
        if($end_date == null){
            $end_date = date('Y-m-d');
        }
        $this->db->select('*');
        $this->db->from('submission');
        $this->db->join('ms_product', 'submission.submission_product_id = ms_product.product_id');
        $this->db->join('ms_warehouse', 'submission.submission_warehouse = ms_warehouse.warehouse_id');
        if($start_date != null){
            $this->db->where('submission_date between "'.$start_date.'" and "'.$end_date.'"');
        }
        if($warehouse_report != null){
            $this->db->where('submission.submission_warehouse', $warehouse_report);
        }
        if($status != null){
            $this->db->where('submission.submission_status', $status);
        }
        $query = $this->db->get();
        return $query;
    }

    public function get_report_hd_po($start_date, $end_date, $warehouse_report, $supplier_report, $status_gudang, $status_pembelian)
    {
        if($start_date == null){
            $start_date = date('Y-m-01');
        }
        if($end_date == null){
            $end_date = date('Y-m-d');
        }
        $this->db->select('*');
        $this->db->from('hd_po');
        $this->db->join('ms_warehouse', 'hd_po.hd_po_warehouse = ms_warehouse.warehouse_id');
        $this->db->join('ms_supplier', 'hd_po.hd_po_supplier = ms_supplier.supplier_id');
        $this->db->join('ms_payment', 'hd_po.hd_po_payment = ms_payment.payment_id');
        $this->db->join('ms_ekspedisi', 'hd_po.hd_po_ekspedisi = ms_ekspedisi.ekspedisi_id');
        if($start_date != null){
            $this->db->where('hd_po_date between "'.$start_date.'" and "'.$end_date.'"');
        }
        if($warehouse_report != null){
            $this->db->where('hd_po_warehouse', $warehouse_report);
        }
        if($supplier_report != null){
            $this->db->where('hd_po_supplier', $supplier_report);
        }
        if($status_gudang != null){
            $this->db->where('hd_po_status', $status_gudang);
        }
        if($status_pembelian != null){
            $this->db->where('hd_po_purchase_status', $status_pembelian);
        }
        $query = $this->db->get();
        return $query;
    }


    public function get_report_po($start_date, $end_date, $warehouse_report, $supplier_report, $status_gudang, $status_pembelian)
    {
        if($start_date == null){
            $start_date = date('Y-m-01');
        }
        if($end_date == null){
            $end_date = date('Y-m-d');
        }
        $this->db->select('*');
        $this->db->from('hd_po');
        $this->db->join('dt_po', 'hd_po.hd_po_id = dt_po.hd_po_id');
        $this->db->join('ms_product', 'dt_po.dt_product_id = ms_product.product_id');
        $this->db->join('ms_warehouse', 'hd_po.hd_po_warehouse = ms_warehouse.warehouse_id');
        $this->db->join('ms_supplier', 'hd_po.hd_po_supplier = ms_supplier.supplier_id');
        $this->db->join('ms_payment', 'hd_po.hd_po_payment = ms_payment.payment_id');
        $this->db->join('ms_ekspedisi', 'hd_po.hd_po_ekspedisi = ms_ekspedisi.ekspedisi_id');
        if($start_date != null){
            $this->db->where('hd_po_date between "'.$start_date.'" and "'.$end_date.'"');
        }
        if($warehouse_report != null){
            $this->db->where('hd_po_warehouse', $warehouse_report);
        }
        if($supplier_report != null){
            $this->db->where('hd_po_supplier', $supplier_report);
        }
        if($status_gudang != null){
            $this->db->where('hd_po_status', $status_gudang);
        }
        if($status_pembelian != null){
            $this->db->where('hd_po_purchase_status', $status_pembelian);
        }
        $query = $this->db->get();
        return $query;
    }

    public function po_list()
    {
        $this->db->select('*');
        $this->db->from('hd_po');
        $query = $this->db->get();
        return $query;
    }

    public function get_report_input_warehouse($start_date, $end_date, $warehouse_report, $po_report, $status_pembelian)
    {
        if($start_date == null){
            $start_date = date('Y-m-01');
        }
        if($end_date == null){
            $end_date = date('Y-m-d');
        }
        $this->db->select('*');
        $this->db->from('hd_input_stock');
        $this->db->join('ms_warehouse', 'hd_input_stock.hd_input_stock_warehouse = ms_warehouse.warehouse_id');
        $this->db->join('dt_input_stock', 'hd_input_stock.hd_input_stock_id  = dt_input_stock.hd_is_id');
        $this->db->join('hd_po', 'hd_input_stock.hd_po_id = hd_po.hd_po_id');
        $this->db->join('ms_supplier', 'hd_po.hd_po_supplier = ms_supplier.supplier_id');
        $this->db->join('ms_product', 'dt_input_stock.dt_is_product_id  = ms_product.product_id');
        $this->db->join('ms_user', 'hd_input_stock.created_by  = ms_user.user_id');
        if($start_date != null){
            $this->db->where('hd_input_stock_date between "'.$start_date.'" and "'.$end_date.'"');
        }
        if($warehouse_report != null){
            $this->db->where('hd_input_stock_warehouse', $warehouse_report);
        }
        if($po_report != null){
            $this->db->where('hd_input_stock.hd_po_id', $po_report);
        }
        if($status_pembelian != null){
            $this->db->where('hd_input_stock_status', $status_pembelian);
        }
        $query = $this->db->get();
        return $query;
    }


    public function get_report_purchases($start_date, $end_date, $warehouse_report, $supplier_report)
    {
        if($start_date == null){
            $start_date = date('Y-m-01');
        }
        if($end_date == null){
            $end_date = date('Y-m-d');
        }
        $this->db->select('*');
        $this->db->from('hd_purchase');
        $this->db->join('dt_purchase', 'hd_purchase.hd_purchase_id = dt_purchase.hd_purchase_id');
        $this->db->join('ms_product', 'dt_purchase.dt_product_id = ms_product.product_id');
        $this->db->join('ms_warehouse', 'hd_purchase.hd_purchase_warehouse = ms_warehouse.warehouse_id');
        $this->db->join('ms_supplier', 'hd_purchase.hd_purchase_supplier = ms_supplier.supplier_id');
        $this->db->join('ms_payment', 'hd_purchase.hd_purchase_payment = ms_payment.payment_id');
        $this->db->join('ms_ekspedisi', 'hd_purchase.hd_purchase_ekspedisi = ms_ekspedisi.ekspedisi_id');
        if($start_date != null){
            $this->db->where('hd_purchase_date between "'.$start_date.'" and "'.$end_date.'"');
        }
        if($warehouse_report != null){
            $this->db->where('hd_purchase_warehouse', $warehouse_report);
        }
        if($supplier_report != null){
            $this->db->where('hd_purchase_supplier', $supplier_report);
        }
        $query = $this->db->get();
        return $query;
    }


    public function get_report_retur_purchases($start_date, $end_date, $supplier_report)
    {
        if($start_date == null){
            $start_date = date('Y-m-01');
        }
        if($end_date == null){
            $end_date = date('Y-m-d');
        }
        $this->db->select('*');
        $this->db->from('hd_retur_purchase');
        $this->db->join('dt_retur_purchase', 'hd_retur_purchase.hd_retur_purchase_id = dt_retur_purchase.hd_retur_purchase_id');
        $this->db->join('ms_product', 'dt_retur_purchase.dt_retur_purchase_product_id = ms_product.product_id');
        $this->db->join('ms_supplier', 'hd_retur_purchase.hd_retur_purchase_supplier_id = ms_supplier.supplier_id');
        $this->db->join('ms_payment', 'hd_retur_purchase.hd_retur_purchase_payment_type = ms_payment.payment_id');
        $this->db->join('ms_warehouse', 'dt_retur_purchase.dt_retur_warehouse_id = ms_warehouse.warehouse_id');
        if($start_date != null){
            $this->db->where('hd_retur_purchase_date between "'.$start_date.'" and "'.$end_date.'"');
        }
        if($supplier_report != null){
            $this->db->where('hd_retur_purchase_supplier_id', $supplier_report);
        }
        $query = $this->db->get();
        return $query;
    }

}

?>