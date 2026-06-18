<?php

class sales_model extends CI_Model {


    public function get_rate($product_id)
    {
        $query = $this->db->query("select product_sell_price_1 as Umum, product_sell_price_2 as Toko, product_sell_price_3 as Sales, product_sell_price_4 as Khusus from ms_product where product_id = '".$product_id."'");
        $result = $query->result();
        return $result;
    }

    public function get_customer_rate($customer_id)
    {
        $query = $this->db->query("select customer_rate from ms_customer where customer_id = '".$customer_id."'");
        $result = $query->result();
        return $result;
    }
    // sales order

    public function add_temp_so($data_insert)
    {
        $this->db->insert('temp_sales_order', $data_insert);
    }


    public function save_sales_order($data_insert)
    {
        $this->db->trans_start();
        $this->db->insert('hd_sales_order', $data_insert);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return  $insert_id;
    }

    public function save_detail_sales_order($data_insert_detail)
    {
        $this->db->insert('dt_sales_order', $data_insert_detail);
    }

    public function sales_order_list($search, $length, $start, $start_date, $end_date, $customer_filter)
    {
        $this->db->select('*');
        $this->db->from('hd_sales_order');
        $this->db->join('dt_sales_order', 'hd_sales_order.hd_sales_order_id = dt_sales_order.hd_sales_order_id');
        $this->db->join('ms_customer', 'hd_sales_order.hd_sales_order_customer = ms_customer.customer_id');
        $this->db->join('ms_product', 'dt_sales_order.dt_so_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_unit.unit_id = ms_product.product_unit');
        $this->db->join('ms_warehouse', 'hd_sales_order.hd_sales_order_warehouse = ms_warehouse.warehouse_id');
        $this->db->join('ms_salesman', 'hd_sales_order.hd_sales_order_salesman = ms_salesman.salesman_id', 'left');
        $this->db->join('ms_user', 'hd_sales_order.created_by = ms_user.user_id');
        if($start_date != null){
            $this->db->where('hd_sales_order_date between "'.$start_date.'" and "'.$end_date.'"');
        }
        if($customer_filter != null){
            $this->db->where('hd_sales_order_customer', $customer_filter);
        }
        if($search != null){
            $this->db->where('(ms_product.product_name like "%'.$search.'%" OR ms_product.product_code like "%'.$keyword.'%" OR ms_product.product_supplier_name like "%'.$keyword.'%" OR ms_product.product_key like "%'.$keyword.'%" OR ms_product.product_desc like "%'.$keyword.'%") ');
        }
        $this->db->order_by('hd_sales_order.created_at', 'desc');
        $this->db->limit($length);
        $this->db->offset($start);
        $query = $this->db->get();
        return $query;
    }

    public function sales_order_list_count($search, $start_date, $end_date, $customer_filter)
    {
        $this->db->select('count(*) as total_row');
        $this->db->from('hd_sales_order');
        $this->db->join('dt_sales_order', 'hd_sales_order.hd_sales_order_id = dt_sales_order.hd_sales_order_id');
        $this->db->join('ms_customer', 'hd_sales_order.hd_sales_order_customer = ms_customer.customer_id');
        $this->db->join('ms_product', 'dt_sales_order.dt_so_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_unit.unit_id = ms_product.product_unit');
        $this->db->join('ms_warehouse', 'hd_sales_order.hd_sales_order_warehouse = ms_warehouse.warehouse_id');
        $this->db->join('ms_salesman', 'hd_sales_order.hd_sales_order_salesman = ms_salesman.salesman_id', 'left');
        $this->db->join('ms_user', 'hd_sales_order.created_by = ms_user.user_id');
        if($start_date != null){
            $this->db->where('hd_sales_order_date between "'.$start_date.'" and "'.$end_date.'"');
        }
        if($customer_filter != null){
            $this->db->where('hd_sales_order_customer', $customer_filter);
        }
        if($search != null){
            $this->db->where('(ms_product.product_name like "%'.$search.'%" OR ms_product.product_code like "%'.$keyword.'%" OR ms_product.product_supplier_name like "%'.$keyword.'%" OR ms_product.product_key like "%'.$keyword.'%" OR ms_product.product_desc like "%'.$keyword.'%") ');
        }
        $query = $this->db->get();
        return $query;
    }


    public function temp_salesorder_list($search, $length, $start, $user)
    {
        $this->db->select('*');
        $this->db->from('temp_sales_order');
        $this->db->join('ms_product', 'temp_sales_order.temp_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_unit.unit_id = ms_product.product_unit');
        $this->db->join('ms_user', 'temp_sales_order.temp_user_id = ms_user.user_id');
        $this->db->where('temp_user_id', $user);
        if($search != null){
            $this->db->where('ms_product.product_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_code like "%'.$search.'%"');
        }
        $this->db->order_by('temp_sales_order.created_at', 'desc');
        $this->db->limit($length);
        $this->db->offset($start);
        $query = $this->db->get();
        return $query;
    }

    public function temp_salesorder_list_count($search, $user)
    {
        $this->db->select('count(*) as total_row');
        $this->db->from('temp_sales_order');
        $this->db->join('ms_product', 'temp_sales_order.temp_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_unit.unit_id = ms_product.product_unit');
        $this->db->join('ms_user', 'temp_sales_order.temp_user_id = ms_user.user_id');
        $this->db->where('temp_user_id', $user);
        if($search != null){
            $this->db->where('ms_product.product_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_code like "%'.$search.'%"');
        }
        $this->db->order_by('temp_sales_order.created_at', 'desc');
        $query = $this->db->get();
        return $query;
    }

    public function check_temp_so_input($product_id, $user_id)
    {
        $query = $this->db->query("select * from temp_sales_order where temp_product_id = '".$product_id."' and temp_user_id = '".$user_id."'");
        $result = $query->result();
        return $result;
    }

    public function edit_temp_so($product_id, $user_id, $data_insert)
    {
        $this->db->set($data_insert);
        $this->db->where('temp_product_id ', $product_id);
        $this->db->where('temp_user_id ', $user_id);
        $this->db->update('temp_sales_order');
    }   

    public function check_edit_temp_so($temp_product_id, $temp_user_id)
    {
        $this->db->select('*');
        $this->db->from('temp_sales_order');
        $this->db->join('ms_product', 'temp_sales_order.temp_product_id = ms_product.product_id');
        $this->db->where('temp_product_id', $temp_product_id);
        $this->db->where('temp_user_id', $temp_user_id);
        $query = $this->db->get();
        return $query;
    }

    public function check_temp_so($user_id)
    {
        $this->db->select('sum(temp_so_total) as sub_total');
        $this->db->from('temp_sales_order');
        $this->db->where('temp_user_id', $user_id);
        $query = $this->db->get();
        return $query;
    }

    public function last_so_inv()
    {
        $query = $this->db->query("select hd_sales_order_inv from hd_sales_order  order by hd_sales_order_id   desc limit 1");
        $result = $query->result();
        return $result;
    }

    public function get_temp_sales_order($user_id)
    {
        $this->db->select('*');
        $this->db->from('temp_sales_order');
        $this->db->join('ms_product', 'temp_sales_order.temp_product_id = ms_product.product_id');
        $this->db->join('ms_user', 'temp_sales_order.temp_user_id = ms_user.user_id');
        $this->db->where('temp_user_id ', $user_id);
        $query = $this->db->get();
        return $query;
    }

    public function clear_temp_sales_order($user_id)
    {
        $this->db->where('temp_user_id', $user_id);
        $this->db->delete('temp_sales_order');
    }

  

    public function header_sales_order($hd_sales_order_id)
    {
        $query = $this->db->query("select * from hd_sales_order a, ms_warehouse b, ms_customer c, ms_user d, ms_ekspedisi e, ms_payment f where a.hd_sales_order_warehouse = b.warehouse_id and a.hd_sales_order_customer = c.customer_id and a.hd_sales_order_payment = f.payment_id and a.created_by = d.user_id and a.hd_sales_order_ekspedisi = e.ekspedisi_id and hd_sales_order_id = '".$hd_sales_order_id."'");
        $result = $query->result();
        return $result;
    }

    public function detail_sales_order($hd_sales_order_id)
    {
        $query = $this->db->query("select * from dt_sales_order a, hd_sales_order b, ms_product c, ms_unit d, ms_user e where a.hd_sales_order_id  = b.hd_sales_order_id  and a.dt_so_product_id = c.product_id and c.product_unit = d.unit_id and b.created_by = e.user_id and a.hd_sales_order_id  = '".$hd_sales_order_id."'");
        $result = $query->result();
        return $result;
    }

    public function delete_sales_order($hd_sales_order_id )
    {
        $this->db->set('hd_sales_order_status', 'Cancel');
        $this->db->where('hd_sales_order_id  ', $hd_sales_order_id );
        $this->db->update('hd_sales_order');
    }

    public function check_stock($product_id, $warehouse_id)
    {
        $query = $this->db->query("select stock from ms_product_stock where product_id = '".$product_id."' and warehouse_id = '".$warehouse_id."'");
        $result = $query->result();
        return $result;
    }

    public function delete_temp_so($product_id, $user_id)
    {
        $this->db->where('temp_product_id', $product_id);
        $this->db->where('temp_user_id', $user_id);
        $this->db->delete('temp_sales_order');
    }

    public function get_edit_sales_order($hd_sales_order_id)
    {
        $query = $this->db->query("select * from hd_sales_order where hd_sales_order_id  = '".$hd_sales_order_id."'");
        $result = $query->result();
        return $result;
    }

    public function header_so($so_id)
    {
        $query = $this->db->query("select * from hd_sales_order where hd_sales_order_id  = '".$so_id."'");
        $result = $query->result();
        return $result;
    }

    public function detail_so($so_id)
    {
        $query = $this->db->query("select * from dt_sales_order where hd_sales_order_id  = '".$so_id."'");
        $result = $query->result();
        return $result;
    }
    
    //end sales order



    // start sales

    public function sales_list($search, $cat, $length, $start, $start_date, $end_date, $customer_filter, $payment_status_filter)
    {
        $this->db->select('*');
        $this->db->from('hd_sales');
        $this->db->join('dt_sales', 'hd_sales.hd_sales_id = dt_sales.hd_sales_id');
        $this->db->join('ms_customer', 'hd_sales.hd_sales_customer = ms_customer.customer_id');
        $this->db->join('ms_product', 'dt_sales.dt_sales_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_unit.unit_id = ms_product.product_unit');
        $this->db->join('ms_warehouse', 'hd_sales.hd_sales_warehouse = ms_warehouse.warehouse_id');
        $this->db->join('ms_salesman', 'hd_sales.hd_sales_salesman = ms_salesman.salesman_id', 'left');
        $this->db->join('ms_user', 'hd_sales.created_by = ms_user.user_id');
        $this->db->join('ms_ekspedisi', 'hd_sales.hd_sales_ekspedisi = ms_ekspedisi.ekspedisi_id');
        $this->db->where('hd_sales_type', $cat);
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
            $this->db->where('(ms_product.product_name like "%'.$search.'%" OR ms_product.product_code like "%'.$search.'%" OR ms_product.product_supplier_name like "%'.$search.'%" OR ms_product.product_key like "%'.$search.'%" OR ms_product.product_desc like "%'.$search.'%") ');
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
        $this->db->join('dt_sales', 'hd_sales.hd_sales_id = dt_sales.hd_sales_id');
        $this->db->join('ms_customer', 'hd_sales.hd_sales_customer = ms_customer.customer_id');
        $this->db->join('ms_product', 'dt_sales.dt_sales_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_unit.unit_id = ms_product.product_unit');
        $this->db->join('ms_warehouse', 'hd_sales.hd_sales_warehouse = ms_warehouse.warehouse_id');
        $this->db->join('ms_salesman', 'hd_sales.hd_sales_salesman = ms_salesman.salesman_id', 'left');
        $this->db->join('ms_user', 'hd_sales.created_by = ms_user.user_id');
        $this->db->join('ms_ekspedisi', 'hd_sales.hd_sales_ekspedisi = ms_ekspedisi.ekspedisi_id');
        $this->db->where('hd_sales_type', $cat);
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
            $this->db->where('(ms_product.product_name like "%'.$search.'%" OR ms_product.product_code like "%'.$search.'%" OR ms_product.product_supplier_name like "%'.$search.'%" OR ms_product.product_key like "%'.$search.'%" OR ms_product.product_desc like "%'.$search.'%") ');
        }
        if($search != null){
            $this->db->where('(ms_product.product_name like "%'.$search.'%" OR ms_product.product_code like "%'.$search.'%" OR ms_product.product_supplier_name like "%'.$search.'%" OR ms_product.product_key like "%'.$search.'%" OR ms_product.product_desc like "%'.$search.'%") ');
        }
        $query = $this->db->get();
        return $query;
    }
    
    public function edit_sales_order($data_insert, $sales_order_id)
    {
        $this->db->set($data_insert);
        $this->db->where('hd_sales_order_id ', $sales_order_id);
        $this->db->update('hd_sales_order');
    }

    public function delete_detail_sales_order($sales_order_id)
    {
        $this->db->where('hd_sales_order_id', $sales_order_id);
        $this->db->delete('dt_sales_order');
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

    public function check_temp_sales_input($product_id, $user_id)
    {
        $query = $this->db->query("select * from temp_sales where temp_product_id = '".$product_id."' and temp_user_id = '".$user_id."'");
        $result = $query->result();
        return $result;
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

    public function check_temp_sales($user_id)
    {
        $this->db->select('sum(temp_sales_total) as sub_total');
        $this->db->from('temp_sales');
        $this->db->where('temp_user_id', $user_id);
        $query = $this->db->get();
        return $query;
    }

    public function search_so($keyword)
    {
        $this->db->select('*');
        $this->db->from('hd_sales_order');
        $this->db->where('hd_sales_order_status', 'Pending');
        if($keyword != null){
            $this->db->where('hd_sales_order.hd_sales_order_inv like "%'.$keyword.'%"');
        }
        $this->db->limit(50);
        $query = $this->db->get();
        return $query;
    }

    public function clear_temp_sales($user_id)
    {
        $this->db->where('temp_user_id', $user_id);
        $this->db->delete('temp_sales');
    }

    public function get_dt_so($so_id)
    {
        $query = $this->db->query("select * from dt_sales_order where hd_sales_order_id = '".$so_id."'");
        $result = $query->result();
        return $result;
    }

    public function get_hd_so($so_id)
    {
        $query = $this->db->query("select * from hd_sales_order a, ms_warehouse b, ms_customer c, ms_user d, ms_ekspedisi e, ms_payment f where a.hd_sales_order_warehouse = b.warehouse_id and a.hd_sales_order_customer = c.customer_id and a.hd_sales_order_payment = f.payment_id and a.created_by = d.user_id and a.hd_sales_order_ekspedisi = e.ekspedisi_id and hd_sales_order_id = '".$so_id."'");
        $result = $query->result();
        return $result;
    }

    public function get_temp_sales_so_id($user_id)
    {
        $query = $this->db->query("select * from temp_sales where temp_user_id = '".$user_id."'");
        $result = $query->result();
        return $result;
    }

    public function last_sales_inv()
    {
        $query = $this->db->query("select hd_sales_inv from hd_sales where hd_sales_type = 'SALES' order by hd_sales_order_id desc limit 1");
        $result = $query->result();
        return $result;
    }

    public function save_sales($data_insert)
    {
        $this->db->trans_start();
        $this->db->insert('hd_sales', $data_insert);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return  $insert_id;
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

    public function save_detail_sales($data_insert_detail)
    {
        $this->db->insert('dt_sales', $data_insert_detail);
    }

    public function delete_temp_sales($product_id, $user_id)
    {
        $this->db->where('temp_product_id', $product_id);
        $this->db->where('temp_user_id', $user_id);
        $this->db->delete('temp_sales');
    }

    public function delete_sales($sales_id)
    {
        $this->db->set('hd_sales_status', 'Cancel');
        $this->db->where('hd_sales_id', $sales_id);
        $this->db->update('hd_sales');
    }

    public function  update_sales_order_status($sales_order_id)
    {
        $this->db->set('hd_sales_order_status', 'Success');
        $this->db->where('hd_sales_order_id', $sales_order_id);
        $this->db->update('hd_sales_order');
    }
    // end sales

    // retur sales

    public function retursales_list($search, $length, $start)
    {
        $this->db->select('*');
        $this->db->from('hd_retur_sales');
        $this->db->join('dt_retur_sales', 'hd_retur_sales.hd_retur_sales_id = dt_retur_sales.hd_retur_sales_id');
        $this->db->join('ms_customer', 'hd_retur_sales.hd_retur_sales_customer_id = ms_customer.customer_id');
        $this->db->join('ms_product', 'dt_retur_sales.dt_retur_sales_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_unit.unit_id = ms_product.product_unit');
        $this->db->join('ms_user', 'hd_retur_sales.created_by = ms_user.user_id');
        if($search != null){
            $this->db->where('ms_product.product_name like "%'.$search.'%"');
            $this->db->or_where('hd_retur_sales.hd_retur_sales_inv like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_code like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_supplier_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_key like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_desc like "%'.$search.'%"');
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
        $this->db->join('dt_retur_sales', 'hd_retur_sales.hd_retur_sales_id = dt_retur_sales.hd_retur_sales_id');
        $this->db->join('ms_customer', 'hd_retur_sales.hd_retur_sales_customer_id = ms_customer.customer_id');
        $this->db->join('ms_product', 'dt_retur_sales.dt_retur_sales_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_unit.unit_id = ms_product.product_unit');
        $this->db->join('ms_user', 'hd_retur_sales.created_by = ms_user.user_id');
        if($search != null){
            $this->db->where('ms_product.product_name like "%'.$search.'%"');
            $this->db->or_where('hd_retur_sales.hd_retur_sales_inv like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_code like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_supplier_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_key like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_desc like "%'.$search.'%"');
        }
        $query = $this->db->get();
        return $query;
    }

    public function search_product_retur($keyword, $sales_id)
    {
        $this->db->select('*');
        $this->db->from('hd_sales');
        $this->db->join('dt_sales', 'hd_sales.hd_sales_id = dt_sales.hd_sales_id');
        $this->db->join('ms_product', 'dt_sales.dt_sales_product_id = ms_product.product_id');
        if($keyword != null){
            $this->db->where('ms_product.product_name like "%'.$keyword.'%"');
            $this->db->or_where('ms_product.product_code like "%'.$keyword.'%"');
            $this->db->or_where('ms_product.product_supplier_name like "%'.$keyword.'%"');
            $this->db->or_where('ms_product.product_key like "%'.$keyword.'%"');
            $this->db->or_where('ms_product.product_desc like "%'.$keyword.'%"');
        }
        $this->db->where('hd_sales.hd_sales_id', $sales_id);
        $this->db->group_by('ms_product.product_id');
        $this->db->limit(50);
        $query = $this->db->get();
        return $query;
    }

    public function check_stock_warehouse($product_id, $warehouse_id)
    {
        $this->db->select('*');
        $this->db->from('ms_product_stock');
        $this->db->where('product_id', $product_id);
        $this->db->where('warehouse_id', $warehouse_id);
        $query = $this->db->get();
        return $query;
    }

    public function check_temp_retur_sales($user_id)
    {
        $this->db->select('sum(temp_retur_sales_total) as sub_total, temp_retur_sales_customer as customer');
        $this->db->from('temp_retur_sales');
        $this->db->where('temp_user_id', $user_id);
        $query = $this->db->get();
        return $query;
    }

    public function temp_retur_sales_list($search, $length, $start, $user)
    {
        $this->db->select('*');
        $this->db->from('temp_retur_sales');
        $this->db->join('ms_product', 'temp_retur_sales.temp_retur_sales_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_unit.unit_id = ms_product.product_unit');
        $this->db->join('ms_user', 'temp_retur_sales.temp_user_id = ms_user.user_id');
        $this->db->where('temp_user_id', $user);
        if($search != null){
            $this->db->where('ms_product.product_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_code like "%'.$search.'%"');
        }
        $this->db->order_by('temp_retur_sales.created_at', 'desc');
        $this->db->limit($length);
        $this->db->offset($start);
        $query = $this->db->get();
        return $query;
    }

    public function temp_retur_sales_list_count($search, $user)
    {
        $this->db->select('count(*) as total_row');
        $this->db->from('temp_retur_sales');
        $this->db->join('ms_product', 'temp_retur_sales.temp_retur_sales_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_unit.unit_id = ms_product.product_unit');
        $this->db->join('ms_user', 'temp_retur_sales.temp_user_id = ms_user.user_id');
        $this->db->where('temp_user_id', $user);
        if($search != null){
            $this->db->where('ms_product.product_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_code like "%'.$search.'%"');
        }
        $this->db->order_by('temp_retur_sales.created_at', 'desc');
        $query = $this->db->get();
        return $query;
    }

    public function check_total_item_retur($sales_id, $product_id)
    {
        $query = $this->db->query("select sum(dt_retur_sales_qty) as total_qty_retur from dt_retur_sales a, hd_retur_sales b where a.hd_retur_sales_id = b.hd_retur_sales_id  and dt_retur_sales_b_id = '".$sales_id."' and dt_retur_sales_product_id = '".$product_id."' and hd_retur_sales_status = 'Success'");
        $result = $query->result();
        return $result;
    }

    public function check_temp_retur_sales_input($sales_id, $product_id, $user_id)
    {
        $query = $this->db->query("select * from temp_retur_sales where temp_retur_sales_product_id = '".$product_id."' and temp_retur_sales_b_id ='".$sales_id."' and temp_user_id = '".$user_id."'");
        $result = $query->result();
        return $result;
    }

    public function add_temp_retur_sales($data_insert)
    {
        $this->db->insert('temp_retur_sales', $data_insert);
    }

    public function edit_temp_retur_sales($sales_id, $product_id, $user_id, $data_insert)
    {
        $this->db->set($data_insert);
        $this->db->where('temp_retur_sales_b_id ', $sales_id);
        $this->db->where('temp_retur_sales_product_id ', $product_id);
        $this->db->where('temp_user_id ', $user_id);
        $this->db->update('temp_retur_sales');
    }

    public function check_edit_temp_retur_sales($temp_product_id, $temp_sales_id, $temp_user_id)
    {
        $this->db->select('*');
        $this->db->from('temp_retur_sales');
        $this->db->join('ms_product', 'temp_retur_sales.temp_retur_sales_product_id = ms_product.product_id');
        $this->db->where('temp_retur_sales_product_id', $temp_product_id);
        $this->db->where('temp_retur_sales_b_id', $temp_sales_id);
        $this->db->where('temp_user_id', $temp_user_id);
        $query = $this->db->get();
        return $query;
    }

    public function delete_temp_retur_sales($product_id, $user_id)
    {
        $this->db->where('temp_retur_sales_product_id', $product_id);
        $this->db->where('temp_user_id', $user_id);
        $this->db->delete('temp_retur_sales');
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

    public function get_detail_retur_sales_data($retur_sales_id)
    {
        $query = $this->db->query("select * from dt_retur_sales where hd_retur_sales_id = '".$retur_sales_id."'");
        $result = $query->result();
        return $result;
    }

    public function last_retur_sales()
    {
        $query = $this->db->query("select hd_retur_sales_inv from hd_retur_sales order by hd_retur_sales_id  desc limit 1");
        $result = $query->result();
        return $result;
    }

    public function save_retur_sales($data_insert)
    {
        $this->db->trans_start();
        $this->db->insert('hd_retur_sales', $data_insert);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return  $insert_id;
    }

    public  function save_detail_retur_sales($data_insert_detail)
    {
        $this->db->insert('dt_retur_sales', $data_insert_detail);
    }

    public function get_temp_retur_sales($user_id)
    {
        $this->db->select('*');
        $this->db->from('temp_retur_sales');
        $this->db->join('ms_product', 'temp_retur_sales.temp_retur_sales_product_id = ms_product.product_id');
        $this->db->join('ms_user', 'temp_retur_sales.temp_user_id = ms_user.user_id');
        $this->db->where('temp_user_id ', $user_id);
        $query = $this->db->get();
        return $query;
    }

    public function clear_temp_retur_sales($user_id)
    {
        $this->db->where('temp_user_id', $user_id);
        $this->db->delete('temp_retur_sales');
    }

    public function get_warehouse_retur($sales_id)
    {
        $query = $this->db->query("select hd_sales_warehouse from hd_sales where hd_sales_id = '".$sales_id."'");
        $result = $query->result();
        return $result;
    }

    public function update_retur_sales($retur_sales_id, $payment_type)
    {
        $this->db->set('hd_retur_sales_payment_type', $payment_type);
        $this->db->set('hd_retur_sales_status', 'Success');
        $this->db->where('hd_retur_sales_id ', $retur_sales_id);
        $this->db->update('hd_retur_sales');
    }


    public function detail_retur_sales_delete($retur_sales_id)
    {
        $query = $this->db->query("select * from hd_retur_sales where hd_retur_sales_id = '".$retur_sales_id."'");
        $result = $query->result();
        return $result;
    }


    public function delete_retur_sales($retur_sales_id)
    {
        $this->db->set('hd_retur_sales_status', 'Cancel');
        $this->db->where('hd_retur_sales_id', $retur_sales_id);
        $this->db->update('hd_retur_sales');
    }

    public function header_sales($hd_sales_id)
    {
        $query = $this->db->query("select * from hd_sales a, ms_warehouse b, ms_customer c, ms_user d, ms_ekspedisi e, ms_payment f where a.hd_sales_warehouse = b.warehouse_id and a.hd_sales_customer = c.customer_id and a.hd_sales_payment = f.payment_id and a.created_by = d.user_id and a.hd_sales_ekspedisi = e.ekspedisi_id and hd_sales_id = '".$hd_sales_id."'");
        $result = $query->result();
        return $result;
    }

    public function detail_sales($hd_sales_id)
    {
        $query = $this->db->query("select * from dt_sales a, hd_sales b, ms_product c, ms_unit d, ms_user e where a.hd_sales_id  = b.hd_sales_id  and a.dt_sales_product_id = c.product_id and c.product_unit = d.unit_id and b.created_by = e.user_id and a.hd_sales_id  = '".$hd_sales_id."'");
        $result = $query->result();
        return $result;
    }
    // end retur sales


    // start revisi sales 

    public function get_sales_dt($sales_id)
    {
        $query = $this->db->query("select * from dt_sales where hd_sales_id = '".$sales_id."'");
        $result = $query->result();
        return $result;
    }

    public function get_hd_sales($sales_id)
    {
        $query = $this->db->query("select * from hd_sales where hd_sales_id  = '".$sales_id."'");
        $result = $query->result();
        return $result;
    }
    
    public function get_sales_id_inv($sales_id)
    {
       $query = $this->db->query("select hd_sales_inv from hd_sales where hd_sales_id  = '".$sales_id."'");
       $result = $query->result();
       return $result;
   }

   public function check_payment_receivable($sales_id)
   {
        $this->db->select('*');
        $this->db->from('dt_payment_receivable');
        $this->db->where('dt_payment_receivable_sales_id ', $sales_id);
        $query = $this->db->get();
        return $query;
   }
    // end revisi sales
}   

?>