<?php

class purchase_model extends CI_Model {



    // start po


    public function po_list($search, $length, $start, $start_date_val, $end_date_val, $supplier_filter_val)
    {
        $this->db->select('*');
        $this->db->from('hd_po');
        $this->db->join('ms_warehouse', 'hd_po.hd_po_warehouse = ms_warehouse.warehouse_id');
        $this->db->join('ms_supplier', 'hd_po.hd_po_supplier = ms_supplier.supplier_id');
        $this->db->join('ms_user', 'hd_po.created_by = ms_user.user_id');
        if($start_date_val != null){
            $this->db->where('hd_po_date between "'.$start_date_val.'" and "'.$end_date_val.'" ');
        }
        if($supplier_filter_val != null){
            $this->db->where('hd_po_supplier', $supplier_filter_val);
        }
        if($search != null){
            $this->db->where('hd_po_invoice like "%'.$search.'%"');
            $this->db->or_where('supplier_name like "%'.$search.'%"');
        }
        $this->db->order_by('hd_po.created_at', 'desc');
        $this->db->limit($length);
        $this->db->offset($start);
        $query = $this->db->get();
        return $query;
    }

    public function po_list_count($search, $start_date_val, $end_date_val, $supplier_filter_val)
    {
        $this->db->select('count(*) as total_row');
        $this->db->from('hd_po');
        $this->db->join('ms_warehouse', 'hd_po.hd_po_warehouse = ms_warehouse.warehouse_id');
        $this->db->join('ms_user', 'hd_po.created_by = ms_user.user_id');
        if($start_date_val != null){
            $this->db->where('hd_po_date between "'.$start_date_val.'" and "'.$end_date_val.'" ');
        }
        if($supplier_filter_val != null){
            $this->db->where('hd_po_supplier', $supplier_filter_val);
        }
        if($search != null){
            $this->db->where('hd_po_invoice like "%'.$search.'%"');
            $this->db->or_where('supplier_name like "%'.$search.'%"');
        }
        $query = $this->db->get();
        return $query;
    }

    public function temp_po_list($search, $length, $start, $user)
    {
        $this->db->select('*');
        $this->db->from('temp_po');
        $this->db->join('ms_product', 'temp_po.temp_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_unit.unit_id = ms_product.product_unit');
        $this->db->join('ms_user', 'temp_po.temp_user_id = ms_user.user_id');
        $this->db->where('temp_user_id', $user);
        if($search != null){
            $this->db->where('ms_product.product_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_code like "%'.$search.'%"');
        }
        $this->db->order_by('temp_po.created_at', 'desc');
        $this->db->limit($length);
        $this->db->offset($start);
        $query = $this->db->get();
        return $query;
    }

    public function temp_po_list_count($search, $user)
    {
        $this->db->select('count(*) as total_row');
        $this->db->from('temp_po');
        $this->db->join('ms_product', 'temp_po.temp_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_unit.unit_id = ms_product.product_unit');
        $this->db->join('ms_user', 'temp_po.temp_user_id = ms_user.user_id');
        $this->db->where('temp_user_id', $user);
        if($search != null){
            $this->db->where('ms_product.product_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_code like "%'.$search.'%"');
        }
        $this->db->order_by('temp_po.created_at', 'desc');
        $query = $this->db->get();
        return $query;
    }

    public function check_temp_po($user_id)
    {
        $this->db->select('sum(temp_po_total) as sub_total, is_ppn, temp_supplier_id');
        $this->db->from('temp_po');
        $this->db->join('ms_product', 'temp_po.temp_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_unit.unit_id = ms_product.product_unit');
        $this->db->join('ms_user', 'temp_po.temp_user_id = ms_user.user_id');
        $this->db->where('temp_user_id', $user_id);
        $query = $this->db->get();
        return $query;
    }

    public function check_temp_po_input($product_id, $user_id)
    {
        $query = $this->db->query("select * from temp_po where temp_product_id = '".$product_id."' and temp_user_id = '".$user_id."'");
        $result = $query->result();
        return $result;
    }

    public function edit_temp_po($product_id, $user_id, $data_insert)
    {
        $this->db->set($data_insert);
        $this->db->where('temp_product_id', $product_id);
        $this->db->where('temp_user_id', $user_id);
        $this->db->update('temp_po');
    }

    public function insert_temp_po($data_insert)
    {
        $this->db->insert('temp_po', $data_insert);
    }

    public function check_edit_temp_po($temp_po_id)
    {
        $this->db->select('*');
        $this->db->from('temp_po');
        $this->db->join('ms_product', 'temp_po.temp_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_unit.unit_id = ms_product.product_unit');
        $this->db->where('temp_po_id', $temp_po_id);
        $query = $this->db->get();
        return $query;
    }

    public function delete_temp_po($temp_po_id)
    {
        $this->db->where('temp_po_id', $temp_po_id);
        $this->db->delete('temp_po');
    }

    public function save_po($data_insert)
    {
        $this->db->trans_start();
        $this->db->insert('hd_po', $data_insert);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return  $insert_id;
    }

    public function save_detail_po($data_insert_detail)
    {
        $this->db->insert('dt_po', $data_insert_detail);
    }

    public function clear_temp_po($user_id)
    {
        $this->db->where('temp_user_id', $user_id);
        $this->db->delete('temp_po');
    }

    public function last_po()
    {
        $query = $this->db->query("select hd_po_invoice from hd_po  order by hd_po_id desc limit 1");
        $result = $query->result();
        return $result;
    }

    public function get_temp_po($user_id)
    {
        $this->db->select('*');
        $this->db->from('temp_po');
        $this->db->join('ms_product', 'temp_po.temp_product_id = ms_product.product_id');
        $this->db->join('ms_user', 'temp_po.temp_user_id = ms_user.user_id');
        $this->db->where('temp_user_id ', $user_id);
        $query = $this->db->get();
        return $query;
    }

    public function header_po($po_id)
    {
        $this->db->select('*, a.created_at as tanggal_po');
        $this->db->from('hd_po a');
        $this->db->join('ms_warehouse b', 'a.hd_po_warehouse = b.warehouse_id');
        $this->db->join('ms_supplier c', 'a.hd_po_supplier = c.supplier_id');
        $this->db->join('ms_payment f', 'a.hd_po_payment = f.payment_id');
        $this->db->join('ms_user d', 'a.created_by = d.user_id');
        $this->db->where('a.hd_po_id', $po_id);
        $query = $this->db->get();
        return $query;
    }

    public function detail_po($po_id)
    {
        $this->db->select('*');
        $this->db->from('dt_po a');
        $this->db->join('hd_po b', 'a.hd_po_id = b.hd_po_id');
        $this->db->join('ms_product c', 'a.dt_product_id = c.product_id');
        $this->db->join('ms_unit d', 'c.product_unit = d.unit_id');
        $this->db->join('ms_user e', 'b.created_by = e.user_id');
        $this->db->where('a.hd_po_id', $po_id);
        $query = $this->db->get();
        return $query; 
    }

    public function edit_po($data_insert, $purchase_order_id)
    {
        $this->db->set($data_insert);
        $this->db->where('hd_po_id', $purchase_order_id);
        $this->db->update('hd_po');
    }

    public function clear_detail_po($purchase_order_id)
    {
        $this->db->where('hd_po_id', $purchase_order_id);
        $this->db->delete('dt_po');
    }

    public function get_po_code($po_id)
    {
        $query = $this->db->query("select hd_po_invoice from hd_po  where hd_po_id  = '".$po_id."'");
        $result = $query->result();
        return $result;
    }

    public function delete_po($po_id)
    {
        $this->db->set('hd_po_status', 'Cancel');
        $this->db->where('hd_po_id  ', $po_id);
        $this->db->update('hd_po');
    }

    // end po

    // start purchase
    public function purchase_list($search, $length, $start, $start_date_val, $end_date_val, $supplier_filter_val)
    {
        $this->db->select('*');
        $this->db->from('hd_purchase');
        $this->db->join('ms_warehouse', 'hd_purchase.hd_purchase_warehouse = ms_warehouse.warehouse_id');
        $this->db->join('ms_supplier', 'hd_purchase.hd_purchase_supplier = ms_supplier.supplier_id');
        $this->db->join('ms_user', 'hd_purchase.created_by = ms_user.user_id');
         if($start_date_val != null){
            $this->db->where('hd_purchase_date between "'.$start_date_val.'" and "'.$end_date_val.'" ');
        }
        if($supplier_filter_val != null){
            $this->db->where('hd_purchase_supplier', $supplier_filter_val);
        }
        if($search != null){
            $this->db->where('ms_supplier.supplier_name like "%'.$search.'%"');
            $this->db->or_where('hd_purchase.hd_purchase_invoice like "%'.$search.'%"');
        }
        $this->db->order_by('hd_purchase.created_at', 'desc');
        $this->db->limit($length);
        $this->db->offset($start);
        $query = $this->db->get();
        return $query;
    }

    public function purchase_list_count($search, $start_date_val, $end_date_val, $supplier_filter_val)
    {
        $this->db->select('count(*) as total_row');
        $this->db->from('hd_purchase');
        $this->db->join('ms_warehouse', 'hd_purchase.hd_purchase_warehouse = ms_warehouse.warehouse_id');
        $this->db->join('ms_supplier', 'hd_purchase.hd_purchase_supplier = ms_supplier.supplier_id');
        $this->db->join('ms_user', 'hd_purchase.created_by = ms_user.user_id');
        if($start_date_val != null){
            $this->db->where('hd_purchase_date between "'.$start_date_val.'" and "'.$end_date_val.'" ');
        }
        if($supplier_filter_val != null){
            $this->db->where('hd_purchase_supplier', $supplier_filter_val);
        }
        if($search != null){
            $this->db->where('ms_supplier.supplier_name like "%'.$search.'%"');
            $this->db->or_where('hd_purchase.hd_purchase_invoice like "%'.$search.'%"');
        }
        $query = $this->db->get();
        return $query;
    }
    

    public function header_purchase($purchase_id)
    {
        $this->db->select('*, a.created_at as tanggal_purchase');
        $this->db->from('hd_purchase a');
        $this->db->join('ms_warehouse b', 'a.hd_purchase_warehouse = b.warehouse_id');
        $this->db->join('ms_supplier c', 'a.hd_purchase_supplier = c.supplier_id');
        $this->db->join('ms_payment f', 'a.hd_purchase_payment = f.payment_id');
        $this->db->join('ms_user d', 'a.created_by = d.user_id');
        $this->db->where('a.hd_purchase_id', $purchase_id);
        $query = $this->db->get();
        return $query;
    }
    

    public function detail_purchase($purchase_id)
    {
        $this->db->select('*');
        $this->db->from('dt_purchase a');
        $this->db->join('hd_purchase b', 'a.hd_purchase_id = b.hd_purchase_id');
        $this->db->join('ms_product c', 'a.dt_product_id = c.product_id');
        $this->db->join('ms_unit d', 'c.product_unit = d.unit_id');
        $this->db->join('ms_user e', 'b.created_by = e.user_id');
        $this->db->where('a.hd_purchase_id', $purchase_id);
        $query = $this->db->get();
        return $query; 
    }

    public function search_po_purchase($search)
    {
        $this->db->select('*');
        $this->db->from('hd_po');
        $this->db->where('hd_po_status','Pending');
        if($search != null){
            $this->db->where('hd_po_invoice like "%'.$search.'%"');
        }
        $query = $this->db->get();
        return $query;
    }
    
    public function temp_purchase_list($search, $length, $start, $user)
    {
        $this->db->select('*');
        $this->db->from('temp_purchase');
        $this->db->join('ms_product', 'temp_purchase.temp_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_unit.unit_id = ms_product.product_unit');
        $this->db->join('ms_user', 'temp_purchase.temp_user_id = ms_user.user_id');
        $this->db->where('temp_user_id', $user);
        if($search != null){
            $this->db->where('ms_product.product_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_code like "%'.$search.'%"');
        }
        $this->db->order_by('temp_purchase.created_at', 'desc');
        $this->db->limit($length);
        $this->db->offset($start);
        $query = $this->db->get();
        return $query;
    }

    public function temp_purchase_list_count($search, $user)
    {
        $this->db->select('count(*) as total_row');
        $this->db->from('temp_purchase');
        $this->db->join('ms_product', 'temp_purchase.temp_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_unit.unit_id = ms_product.product_unit');
        $this->db->join('ms_user', 'temp_purchase.temp_user_id = ms_user.user_id');
        $this->db->where('ms_product.product_name like "%'.$search.'%"');
        $this->db->where('temp_user_id', $user);
        if($search != null){
            $this->db->where('ms_product.product_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_code like "%'.$search.'%"');
        }
        $this->db->order_by('temp_purchase.created_at', 'desc');
        $query = $this->db->get();
        return $query;
    }

    public function check_temp_purchase($user_id)
    {
        $this->db->select('*, sum(temp_purchase_total) as sub_total');
        $this->db->from('temp_purchase');
        $this->db->where('temp_user_id', $user_id);
        $query = $this->db->get();
        return $query;
    }
    public function check_temp_purchase_input($product_id, $user_id)
    {
        $query = $this->db->query("select * from temp_purchase where temp_product_id = '".$product_id."' and temp_user_id = '".$user_id."'");
        $result = $query->result();
        return $result;
    }
    public function edit_temp_purchase($product_id, $user_id, $data_insert)
    {
        $this->db->set($data_insert);
        $this->db->where('temp_product_id ', $product_id);
        $this->db->where('temp_user_id ', $user_id);
        $this->db->update('temp_purchase');
    }
    public function insert_temp_purchase($data_insert)
    {
        $this->db->insert('temp_purchase', $data_insert);
    }

    public function delete_temp_purchase($product_id, $user_id)
    {
        $this->db->where('temp_product_id', $product_id);
        $this->db->where('temp_user_id', $user_id);
        $this->db->delete('temp_purchase');
    }

    public function check_edit_temp_purchase($temp_product_id, $temp_user_id)
    {
        $this->db->select('*');
        $this->db->from('temp_purchase');
        $this->db->join('ms_product', 'temp_purchase.temp_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_unit.unit_id = ms_product.product_unit');
        $this->db->where('temp_product_id', $temp_product_id);
        $this->db->where('temp_user_id', $temp_user_id);
        $query = $this->db->get();
        return $query;
    }
    public function last_purchase()
    {  
        $query = $this->db->query("select hd_purchase_invoice from hd_purchase  order by hd_purchase_id desc limit 1");
        $result = $query->result();
        return $result;
    }
    public function save_purchase($data_insert)
    {
        $this->db->trans_start();
        $this->db->insert('hd_purchase', $data_insert);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return  $insert_id;
    }


    public function get_temp_purchase($user_id)
    {
        $this->db->select('*');
        $this->db->from('temp_purchase');
        $this->db->join('ms_product', 'temp_purchase.temp_product_id = ms_product.product_id');
        $this->db->join('ms_user', 'temp_purchase.temp_user_id = ms_user.user_id');
        $this->db->where('temp_user_id ', $user_id);
        $query = $this->db->get();
        return $query;
    }
    public function save_detail_purchase($data_insert_detail)
    {
        $this->db->insert('dt_purchase', $data_insert_detail);
    }

    public function update_purchase_po($po_id)
    {
        $this->db->set('hd_po_status', 'Success');
        $this->db->where('hd_po_id ', $po_id);
        $this->db->update('hd_po');
    }
    public function clear_temp_purchase($user_id)
    {
        $this->db->where('temp_user_id', $user_id);
        $this->db->delete('temp_purchase');
    }
    
    
    public function copy_temp_purchase($data_copy_temp)
    {
        $this->db->insert('temp_purchase', $data_copy_temp);
    }

    public function detail_po_purchase($po_id)
    {
        $query = $this->db->query("select * from dt_po a, hd_po b, ms_product c, ms_unit d, ms_user e, hd_input_stock f, dt_input_stock g where a.hd_po_id = b.hd_po_id and a.dt_product_id = c.product_id and c.product_unit = d.unit_id and b.hd_po_id = f.hd_po_id and f.hd_input_stock_id  = g.hd_is_id and b.created_by = e.user_id and a.hd_po_id  = '".$po_id."' and hd_input_stock_status = 'Pending' group by dt_po_id");
        $result = $query->result();
        return $result;
    }

    public function header_po_purchase($po_id)
    {
        $query = $this->db->query("select * from hd_po a, ms_warehouse b, ms_supplier c, ms_payment f, ms_user d where a.hd_po_warehouse = b.warehouse_id and a.hd_po_supplier = c.supplier_id and a.hd_po_payment = f.payment_id and a.created_by = d.user_id and a.hd_po_id  = '".$po_id."'");
        $result = $query->result();
        return $result;
    }

    // end purchase

    // start retur purchase
    public function returpurchase_list($search, $length, $start)
    {
        $this->db->select('*');
        $this->db->from('hd_retur_purchase');
        $this->db->join('ms_supplier', 'hd_retur_purchase.hd_retur_purchase_supplier_id = ms_supplier.supplier_id');
        $this->db->join('ms_user', 'hd_retur_purchase.created_by = ms_user.user_id');
        if($search != null){
            $this->db->where('hd_retur_purchase.hd_retur_purchase_inv like "%'.$search.'%"');
            $this->db->or_where('ms_supplier.supplier_name like "%'.$search.'%"');
        }
        $this->db->order_by('hd_retur_purchase.created_at', 'desc');
        $this->db->limit($length);
        $this->db->offset($start);
        $query = $this->db->get();
        return $query;
    }

    public function returpurchase_list_count($search)
    {
        $this->db->select('count(*) as total_row');
        $this->db->from('hd_retur_purchase');
        $this->db->join('ms_supplier', 'hd_retur_purchase.hd_retur_purchase_supplier_id = ms_supplier.supplier_id');
        $this->db->join('ms_user', 'hd_retur_purchase.created_by = ms_user.user_id');
        if($search != null){
            $this->db->where('hd_retur_purchase.hd_retur_purchase_inv like "%'.$search.'%"');
            $this->db->or_where('ms_supplier.supplier_name like "%'.$search.'%"');
        }
        $query = $this->db->get();
        return $query;
    }

    public function temp_retur_purchase_list($search, $length, $start, $user)
    {
        $this->db->select('*');
        $this->db->from('temp_retur_purchase');
        $this->db->join('ms_product', 'temp_retur_purchase.temp_retur_purchase_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_unit.unit_id = ms_product.product_unit');
        $this->db->join('ms_user', 'temp_retur_purchase.temp_user_id = ms_user.user_id');
        $this->db->where('temp_user_id', $user);
        if($search != null){
            $this->db->where('ms_product.product_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_code like "%'.$search.'%"');
        }
        $this->db->order_by('temp_retur_purchase.created_at', 'desc');
        $this->db->limit($length);
        $this->db->offset($start);
        $query = $this->db->get();
        return $query;
    }

    public function temp_retur_purchase_list_count($search, $user)
    {
        $this->db->select('count(*) as total_row');
        $this->db->from('temp_retur_purchase');
        $this->db->join('ms_product', 'temp_retur_purchase.temp_retur_purchase_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_unit.unit_id = ms_product.product_unit');
        $this->db->join('ms_user', 'temp_retur_purchase.temp_user_id = ms_user.user_id');
        $this->db->where('temp_user_id', $user);
        if($search != null){
            $this->db->where('ms_product.product_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_code like "%'.$search.'%"');
        }
        $this->db->order_by('temp_retur_purchase.created_at', 'desc');
        $query = $this->db->get();
        return $query;
    }
    
     public function check_temp_retur_purchase($user_id)
    {
        $this->db->select('sum(temp_retur_purchase_total) as sub_total, temp_retur_purchase_supplier as supplier');
        $this->db->from('temp_retur_purchase');
        $this->db->where('temp_user_id', $user_id);
        $query = $this->db->get();
        return $query;
    }
    public function delete_temp_retur_purchase($product_id, $purchase_id, $user_id)
    {
        $this->db->where('temp_retur_purchase_product_id', $product_id);
        $this->db->where('temp_retur_purchase_b_id', $purchase_id);
        $this->db->where('temp_user_id', $user_id);
        $this->db->delete('temp_retur_purchase');
    }
    public function search_product_retur($keyword, $purchase_id)
    {
        $this->db->select('*');
        $this->db->from('hd_purchase');
        $this->db->join('dt_purchase', 'hd_purchase.hd_purchase_id = dt_purchase.hd_purchase_id');
        $this->db->join('ms_product', 'dt_purchase.dt_product_id = ms_product.product_id');
        if($keyword != null){
            $this->db->or_where('(ms_product.product_name like "%'.$keyword.'%" or ms_product.product_code like "%'.$keyword.'%")' );
        }
        $this->db->where('hd_purchase.hd_purchase_id', $purchase_id);
        $this->db->limit(50);
        $query = $this->db->get();
        return $query;
    }
    public function check_total_item_retur($purchase_id, $product_id)
    {
        $query = $this->db->query("select sum(dt_retur_purchase_qty) as total_qty_retur from dt_retur_purchase a, hd_retur_purchase b where a.hd_retur_purchase_id = b.hd_retur_purchase_id  and dt_retur_purchase_b_id = '".$purchase_id."' and dt_retur_purchase_product_id = '".$product_id."' and hd_retur_purchase_status = 'Success'");
        $result = $query->result();
        return $result;
    }
    public function check_temp_retur_purchase_input($purchase_id, $product_id, $user_id)
    {
        $query = $this->db->query("select * from temp_retur_purchase where temp_retur_purchase_product_id = '".$product_id."' and temp_retur_purchase_b_id ='".$purchase_id."' and temp_user_id = '".$user_id."'");
        $result = $query->result();
        return $result;
    }

    public function edit_temp_retur_purchase($purchase_id, $product_id, $user_id, $data_insert)
    {
        $this->db->set($data_insert);
        $this->db->where('temp_retur_purchase_b_id ', $purchase_id);
        $this->db->where('temp_retur_purchase_product_id ', $product_id);
        $this->db->where('temp_user_id ', $user_id);
        $this->db->update('temp_retur_purchase');
    }
    public function add_temp_retur_purchase($data_insert)
    {
        $this->db->insert('temp_retur_purchase', $data_insert);
    }
    // end retur purchase


}
