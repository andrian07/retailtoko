<?php

class sales_model extends CI_Model {


    public function sales_list($search, $cat, $length, $start, $start_date, $end_date, $customer_filter, $payment_status_filter)
    {
        $this->db->select('*');
        $this->db->from('hd_sales');
        $this->db->join('ms_customer', 'hd_sales.hd_sales_customer = ms_customer.customer_id');
        $this->db->join('ms_warehouse', 'hd_sales.hd_sales_warehouse = ms_warehouse.warehouse_id');
        $this->db->join('ms_user', 'hd_sales.created_by = ms_user.user_id');
        if($start_date != null){
            $this->db->where('hd_sales_date between "'.$start_date.'" and "'.$end_date.'"');
        }
        if($customer_filter != null){
            $this->db->where('hd_sales_customer', $customer_filter);
        }
        if($payment_status_filter != null){
            if($payment_status_filter == 'Lunas'){
                $this->db->where('hd_sales_remaining_debt < 1');
            }else{
                $this->db->where('hd_sales_remaining_debt > 0');
            }
        }
        if($search != null){
            $this->db->where('(hd_sales.hd_sales_inv like "%'.$search.'%" OR ms_customer.customer_name like "%'.$search.'%") ');
        }
        $this->db->order_by('hd_sales.created_at', 'desc');
        $this->db->limit($length);
        $this->db->offset($start);
        $query = $this->db->get();
        return $query;
    }

    public function sales_list_count($search, $cat, $start_date, $end_date, $customer_filter, $payment_status_filter)
    {
        $this->db->select('count(*) as total_row');
        $this->db->from('hd_sales');
        $this->db->join('ms_customer', 'hd_sales.hd_sales_customer = ms_customer.customer_id');
        $this->db->join('ms_warehouse', 'hd_sales.hd_sales_warehouse = ms_warehouse.warehouse_id');
        $this->db->join('ms_user', 'hd_sales.created_by = ms_user.user_id');
        if($start_date != null){
            $this->db->where('hd_sales_date between "'.$start_date.'" and "'.$end_date.'"');
        }
        if($customer_filter != null){
            $this->db->where('hd_sales_customer', $customer_filter);
        }
        if($payment_status_filter != null){
            if($payment_status_filter == 'Lunas'){
                $this->db->where('hd_sales_remaining_debt < 1');
            }else{
                $this->db->where('hd_sales_remaining_debt > 0');
            }
        }
        if($search != null){
            $this->db->where('(hd_sales.hd_sales_inv like "%'.$search.'%" OR ms_customer.customer_name like "%'.$search.'%") ');
        }
        $query = $this->db->get();
        return $query;
    }

     public function header_sales($hd_sales_id)
    {
        $query = $this->db->query("select * from hd_sales a, ms_warehouse b, ms_customer c, ms_user d, ms_payment e where a.hd_sales_warehouse = b.warehouse_id and a.hd_sales_customer = c.customer_id and a.hd_sales_payment = e.payment_id and a.created_by = d.user_id and hd_sales_id = '".$hd_sales_id."'");
        $result = $query->result();
        return $result;
    }

    public function detail_sales($hd_sales_id)
    {
        $query = $this->db->query("select * from dt_sales a, hd_sales b, ms_product c, ms_unit d, ms_user e where a.hd_sales_id  = b.hd_sales_id  and a.dt_sales_product_id = c.product_id and c.product_unit = d.unit_id and b.created_by = e.user_id and a.hd_sales_id  = '".$hd_sales_id."'");
        $result = $query->result();
        return $result;
    }
    
}   

?>