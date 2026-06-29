<?php

class reportsales_model extends CI_Model {

    public function get_report_hd_sales($start_date, $end_date, $customer_report, $status)
    {
        if($start_date == null){
            $start_date = date('Y-m-01');
        }
        if($end_date == null){
            $end_date = date('Y-m-d');
        }
        if($status == null){
            $status = 'Success';
        }
        
        $this->db->select('*');
        $this->db->from('hd_sales');
        $this->db->join('ms_customer', 'hd_sales.hd_sales_customer = ms_customer.customer_id');
        $this->db->join('ms_payment', 'hd_sales.hd_sales_payment = ms_payment.payment_id');
        $this->db->join('ms_warehouse', 'hd_sales.hd_sales_warehouse = ms_warehouse.warehouse_id');
        $this->db->join('ms_user', 'hd_sales.created_by = ms_user.user_id');
        if($start_date != null){
            $this->db->where('hd_sales.hd_sales_date between "'.$start_date.'" and "'.$end_date.'"');
        }
        if($customer_report != null){
            $this->db->where('hd_sales.hd_sales_customer', $customer_report);
        }
        if($status != null){
            $this->db->where('hd_sales.hd_sales_status', $status);
        }
        $query = $this->db->get();
        return $query;
    }

    public function get_report_sales($start_date, $end_date, $customer_report, $status)
    {
        if($start_date == null){
            $start_date = date('Y-m-01');
        }
        if($end_date == null){
            $end_date = date('Y-m-d');
        }
        if($status == null){
            $status = 'Success';
        }
        $this->db->select('*');
        $this->db->from('hd_sales');
        $this->db->join('dt_sales', 'hd_sales.hd_sales_id = dt_sales.hd_sales_id');
        $this->db->join('ms_customer', 'hd_sales.hd_sales_customer = ms_customer.customer_id');
        $this->db->join('ms_payment', 'hd_sales.hd_sales_payment = ms_payment.payment_id');
        $this->db->join('ms_warehouse', 'hd_sales.hd_sales_warehouse = ms_warehouse.warehouse_id');
        $this->db->join('ms_product', 'dt_sales.dt_sales_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_product.product_unit = ms_unit.unit_id');
        $this->db->join('ms_user', 'hd_sales.created_by = ms_user.user_id');
        if($start_date != null){
            $this->db->where('hd_sales.hd_sales_date between "'.$start_date.'" and "'.$end_date.'"');
        }
        if($customer_report != null){
            $this->db->where('hd_sales.hd_sales_customer', $customer_report);
        }
        if($status != null){
            $this->db->where('hd_sales.hd_sales_status', $status);
        }
        $query = $this->db->get();
        return $query;
    }


    public function get_report_retur_sales($start_date, $end_date, $customer_report, $status)
    {
         if($start_date == null){
            $start_date = date('Y-m-01');
        }
        if($end_date == null){
            $end_date = date('Y-m-d');
        }
        if($status == null){
            $status = 'Success';
        }

        $this->db->select('*');
        $this->db->from('hd_retur_sales');
        $this->db->join('dt_retur_sales', 'hd_retur_sales.hd_retur_sales_id = dt_retur_sales.hd_retur_sales_id');
        $this->db->join('ms_customer', 'hd_retur_sales.hd_retur_sales_customer_id = ms_customer.customer_id');
        $this->db->join('ms_product', 'dt_retur_sales.dt_retur_sales_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_product.product_unit = ms_unit.unit_id');
        $this->db->join('ms_user', 'hd_retur_sales.created_by = ms_user.user_id');
        if($start_date != null){
            $this->db->where('hd_retur_sales.hd_retur_sales_date between "'.$start_date.'" and "'.$end_date.'"');
        }
        if($customer_report != null){
            $this->db->where('hd_retur_sales.hd_retur_sales_customer_id', $customer_report);
        }
        if($status != null){
            $this->db->where('hd_retur_sales.hd_retur_sales_status', $status);
        }
        $query = $this->db->get();
        return $query;
    }

}

?>