<?php

class reportpurchase_model extends CI_Model {


    public function get_report_hd_po($start_date, $end_date, $supplier_report, $status_pembelian)
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
        if($start_date != null){
            $this->db->where('hd_po_date between "'.$start_date.'" and "'.$end_date.'"');
        }
        if($supplier_report != null){
            $this->db->where('hd_po_supplier', $supplier_report);
        }
        if($status_pembelian != null){
            $this->db->where('hd_po_status', $status_pembelian);
        }
        $query = $this->db->get();
        return $query;
    }


    public function get_report_po($start_date, $end_date, $supplier_report, $status_pembelian)
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
        if($start_date != null){
            $this->db->where('hd_po_date between "'.$start_date.'" and "'.$end_date.'"');
        }
        if($supplier_report != null){
            $this->db->where('hd_po_supplier', $supplier_report);
        }
        if($status_pembelian != null){
            $this->db->where('hd_po_status', $status_pembelian);
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


    public function get_report_hd_purchases($start_date, $end_date, $supplier_report)
    {
        if($start_date == null){
            $start_date = date('Y-m-01');
        }
        if($end_date == null){
            $end_date = date('Y-m-d');
        }
        $this->db->select('*');
        $this->db->from('hd_purchase');
        $this->db->join('ms_warehouse', 'hd_purchase.hd_purchase_warehouse = ms_warehouse.warehouse_id');
        $this->db->join('ms_supplier', 'hd_purchase.hd_purchase_supplier = ms_supplier.supplier_id');
        $this->db->join('ms_payment', 'hd_purchase.hd_purchase_payment = ms_payment.payment_id');
        if($start_date != null){
            $this->db->where('hd_purchase_date between "'.$start_date.'" and "'.$end_date.'"');
        }
        if($supplier_report != null){
            $this->db->where('hd_purchase_supplier', $supplier_report);
        }
        $query = $this->db->get();
        return $query;

    }

    public function get_report_retur_hd_purchases($start_date, $end_date, $supplier_report)
    {
        if($start_date == null){
            $start_date = date('Y-m-01');
        }
        if($end_date == null){
            $end_date = date('Y-m-d');
        }
        $this->db->select('*');
        $this->db->from('hd_retur_purchase');
        $this->db->join('ms_supplier', 'hd_retur_purchase.hd_retur_purchase_supplier_id = ms_supplier.supplier_id');
        $this->db->join('ms_payment', 'hd_retur_purchase.hd_retur_purchase_payment_type = ms_payment.payment_id');
        if($start_date != null){
            $this->db->where('hd_retur_purchase_date between "'.$start_date.'" and "'.$end_date.'"');
        }
        if($supplier_report != null){
            $this->db->where('hd_retur_purchase_supplier_id', $supplier_report);
        }
        $query = $this->db->get();
        return $query;

    }
    
    public function get_report_purchases($start_date, $end_date, $supplier_report)
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
        if($start_date != null){
            $this->db->where('hd_purchase_date between "'.$start_date.'" and "'.$end_date.'"');
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
        $this->db->join('ms_unit', 'dt_retur_purchase.dt_retur_purchase_unit_id = ms_unit.unit_id');
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