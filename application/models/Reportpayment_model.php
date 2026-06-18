<?php

class reportpayment_model extends CI_Model {

    public function get_report_duedate($start_date, $end_date, $supplier_report)
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
        $this->db->where('hd_purchase_remaining_debt > 0');
        if($start_date != null){
            $this->db->where('hd_purchase_due_date between "'.$start_date.'" and "'.$end_date.'"');
        }
        if($supplier_report != null){
            $this->db->where('hd_purchase_supplier', $supplier_report);
        }
        $query = $this->db->get();
        return $query;
    }


      public function get_report_repayment_date($start_date, $end_date, $customer_report)
    {
        if($start_date == null){
            $start_date = date('Y-m-01');
        }
        if($end_date == null){
            $end_date = date('Y-m-d');
        }
        $this->db->select('*');
        $this->db->from('hd_sales');
        $this->db->join('ms_warehouse', 'hd_sales.hd_sales_warehouse = ms_warehouse.warehouse_id');
        $this->db->join('ms_customer', 'hd_sales.hd_sales_customer = ms_customer.customer_id');
        $this->db->where('hd_sales_remaining_debt > 0');
        if($start_date != null){
            $this->db->where('hd_sales_due_date between "'.$start_date.'" and "'.$end_date.'"');
        }
        if($customer_report != null){
            $this->db->where('hd_sales_customer', $customer_report);
        }
        $query = $this->db->get();
        return $query;
    }

    public function get_report_repayment($start_date, $end_date, $supplier_report)
    {
        if($start_date == null){
            $start_date = date('Y-m-01');
        }
        if($end_date == null){
            $end_date = date('Y-m-d');
        }
        $this->db->select('*');
        $this->db->from('hd_payment_debt');
        $this->db->join('ms_supplier', 'hd_payment_debt.payment_debt_supplier_id = ms_supplier.supplier_id');
        $this->db->join('ms_payment', 'hd_payment_debt.payment_debt_method_id = ms_payment.payment_id');
        if($start_date != null){
            $this->db->where('payment_debt_date between "'.$start_date.'" and "'.$end_date.'"');
        }
        if($supplier_report != null){
            $this->db->where('payment_debt_supplier_id', $supplier_report);
        }
        $query = $this->db->get();
        return $query;
    }

    public function get_report_piutang($start_date, $end_date, $customer_report)
    {
        if($start_date == null){
            $start_date = date('Y-m-01');
        }
        if($end_date == null){
            $end_date = date('Y-m-d');
        }
        $this->db->select('*');
        $this->db->from('hd_payment_receivable');
        $this->db->join('ms_customer', 'hd_payment_receivable.payment_receivable_customer_id = ms_customer.customer_id');
        $this->db->join('ms_payment', 'hd_payment_receivable.payment_receivable_method_id = ms_payment.payment_id');
        if($start_date != null){
            $this->db->where('payment_receivable_date between "'.$start_date.'" and "'.$end_date.'"');
        }
        if($customer_report != null){
            $this->db->where('payment_receivable_customer_id', $customer_report);
        }
        $query = $this->db->get();
        return $query;
    }
}

?>