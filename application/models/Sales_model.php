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

    public function temp_sales_list($search, $length, $start, $user)
    {
        $this->db->select('*');
        $this->db->from('temp_sales');
        $this->db->join('ms_product', 'temp_sales.temp_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_unit.unit_id = ms_product.product_unit');
        $this->db->join('ms_user', 'temp_sales.temp_user_id = ms_user.user_id');
        $this->db->where('temp_user_id', $user);
        if($search != null){
            $this->db->where('ms_product.product_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_code like "%'.$search.'%"');
        }
        $this->db->order_by('temp_sales.created_at', 'desc');
        $this->db->limit($length);
        $this->db->offset($start);
        $query = $this->db->get();
        return $query;
    }

    public function temp_sales_list_count($search, $user)
    {
        $this->db->select('count(*) as total_row');
        $this->db->from('temp_sales');
        $this->db->join('ms_product', 'temp_sales.temp_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_unit.unit_id = ms_product.product_unit');
        $this->db->join('ms_user', 'temp_sales.temp_user_id = ms_user.user_id');
        $this->db->where('temp_user_id', $user);
        if($search != null){
            $this->db->where('ms_product.product_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_code like "%'.$search.'%"');
        }
        $this->db->order_by('temp_sales.created_at', 'desc');
        $query = $this->db->get();
        return $query;
    }
    
    public function check_temp_sales($user_id)
    {
        $this->db->select('sum(temp_sales_total) as sub_total');
        $this->db->from('temp_sales');
        $this->db->where('temp_user_id', $user_id);
        $query = $this->db->get();
        return $query;
    }

    public function edit_temp_sales($product_id, $user_id, $data_insert)
    {
        $this->db->set($data_insert);
        $this->db->where('temp_product_id ', $product_id);
        $this->db->where('temp_user_id ', $user_id);
        $this->db->update('temp_sales');
    }   

    public function add_temp_sales($data_insert)
    {
        $this->db->insert('temp_sales', $data_insert);
    }

    public function check_temp_sales_input($product_id, $user_id)
    {
        $query = $this->db->query("select * from temp_sales where temp_product_id = '".$product_id."' and temp_user_id = '".$user_id."'");
        $result = $query->result();
        return $result;
    }

    public function check_edit_temp_sales($temp_product_id, $temp_user_id)
    {
        $this->db->select('*');
        $this->db->from('temp_sales');
        $this->db->join('ms_product', 'temp_sales.temp_product_id = ms_product.product_id');
        $this->db->where('temp_product_id', $temp_product_id);
        $this->db->where('temp_user_id', $temp_user_id);
        $query = $this->db->get();
        return $query;
    }

    public function check_stock($product_id, $warehouse_id)
    {
        $query = $this->db->query("select stock from ms_product_stock where product_id = '".$product_id."' and warehouse_id = '".$warehouse_id."'");
        $result = $query->result();
        return $result;
    }

    public function delete_temp_sales($product_id, $user_id)
    {
        $this->db->where('temp_product_id', $product_id);
        $this->db->where('temp_user_id', $user_id);
        $this->db->delete('temp_sales');
    }

    public function clear_temp_sales($user_id)
    {
        $this->db->where('temp_user_id', $user_id);
        $this->db->delete('temp_sales');
    }

    public function last_sales_inv()
    {
        $query = $this->db->query("select hd_sales_inv from hd_sales order by hd_sales_id desc limit 1");
        $result = $query->result();
        return $result;
    }

    public function get_temp_sales($user_id)
    {
        $this->db->select('*');
        $this->db->from('temp_sales');
        $this->db->join('ms_product', 'temp_sales.temp_product_id = ms_product.product_id');
        $this->db->join('ms_user', 'temp_sales.temp_user_id = ms_user.user_id');
        $this->db->where('temp_user_id ', $user_id);
        $query = $this->db->get();
        return $query;
    }

    public function save_sales($data_insert)
    {
        $this->db->trans_start();
        $this->db->insert('hd_sales', $data_insert);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return  $insert_id;
    }

    public function save_detail_sales($data_insert_detail)
    {
        $this->db->insert('dt_sales', $data_insert_detail);
    }

    public function delete_sales($sales_id)
    {
        $this->db->set('hd_sales_status', 'Cancel');
        $this->db->where('hd_sales_id', $sales_id);
        $this->db->update('hd_sales');
    }


    public function retursales_list($search, $length, $start)
    {
        $this->db->select('*');
        $this->db->from('hd_retur_sales');
        $this->db->join('ms_customer', 'hd_retur_sales.hd_retur_sales_customer_id = ms_customer.customer_id');
        $this->db->join('ms_user', 'hd_retur_sales.created_by = ms_user.user_id');
        if($search != null){
            $this->db->where('hd_retur_sales.hd_retur_sales_inv like "%'.$search.'%"');
            $this->db->or_where('ms_customer.customer_name like "%'.$search.'%"');
        }
        $this->db->order_by('hd_retur_sales.created_at', 'desc');
        $this->db->limit($length);
        $this->db->offset($start);
        $query = $this->db->get();
        return $query;
    }

    public function retursales_list_count($search)
    {
        $this->db->select('count(*) as total_row');
        $this->db->from('hd_retur_sales');
        $this->db->join('ms_customer', 'hd_retur_sales.hd_retur_sales_customer_id = ms_customer.customer_id');
        $this->db->join('ms_user', 'hd_retur_sales.created_by = ms_user.user_id');
        if($search != null){
            $this->db->where('hd_retur_sales.hd_retur_sales_inv like "%'.$search.'%"');
            $this->db->or_where('ms_customer.customer_name like "%'.$search.'%"');
        }
        $query = $this->db->get();
        return $query;
    }

     public function header_retur_sales($retur_sales_id)
    {
        $query = $this->db->query("select * from hd_retur_sales a, ms_customer c, ms_user d where a.hd_retur_sales_customer_id = c.customer_id and a.created_by = d.user_id and hd_retur_sales_id  = '".$retur_sales_id."'");
        $result = $query->result();
        return $result;
    }


    public function detail_retur_sales($retur_sales_id)
    {
        $query = $this->db->query("select * from dt_retur_sales a,  hd_sales b, ms_product c, ms_unit d, hd_retur_sales e where  a.hd_retur_sales_id = e.hd_retur_sales_id and a.dt_retur_sales_product_id = c.product_id and c.product_unit = d.unit_id where a.hd_retur_sales_id = '".$retur_sales_id."'");
        $result = $query->result();
        return $result;
    }


    
}   

?>