<?php

class purchase_model extends CI_Model {


    // submission
    public function insert_submission($data_insert)
    {
        $this->db->insert('submission', $data_insert);
    }

    public function last_submission_inv()
    {
        $query = $this->db->query("select submission_invoice from submission  order by submission_id  desc limit 1");
        $result = $query->result();
        return $result;
    }

    public function submission_list($search, $length, $start, $start_date, $end_date, $supplier_filter, $keterangan_filter, $status_filter)
    {
        $this->db->select('*');
        $this->db->from('submission');
        $this->db->join('ms_product', 'submission.submission_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_unit.unit_id = ms_product.product_unit');
        $this->db->join('ms_warehouse', 'submission.submission_warehouse = ms_warehouse.warehouse_id');
        $this->db->join('ms_salesman', 'submission.submission_salesman = ms_salesman.salesman_id', 'left');
        $this->db->join('ms_supplier', 'submission.submission_last_supplier = ms_supplier.supplier_id', 'left');
        $this->db->join('ms_user', 'submission.created_by = ms_user.user_id');
        if($start_date != ''){
            $this->db->where('submission_date >=', $start_date);
        }
        if($end_date != ''){
            $this->db->where('submission_date <=', $end_date);
        }
        if($supplier_filter != ''){
            $this->db->where('submission_last_supplier', $supplier_filter);
        }
        if($keterangan_filter != ''){
            $this->db->like('submission_desc', $keterangan_filter);
        }
        if($status_filter != ''){
            $this->db->where('submission_status', $status_filter);
        }
        if($search != null){
            $this->db->where('ms_product.product_name like "%'.$search.'%"');
            $this->db->or_where('submission.submission_invoice like "%'.$search.'%"');
            $this->db->or_where('submission.submission_desc like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_code like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_supplier_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_key like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_desc like "%'.$search.'%"');
        }

        $this->db->order_by('submission.created_at', 'desc');
        $this->db->limit($length);
        $this->db->offset($start);
        $query = $this->db->get();
        return $query;
    }

    public function submission_list_count($search, $start_date, $end_date, $supplier_filter, $keterangan_filter, $status_filter)
    {
        $this->db->select('count(*) as total_row');
        $this->db->from('submission');
        $this->db->join('ms_product', 'submission.submission_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_unit.unit_id = ms_product.product_unit');
        $this->db->join('ms_warehouse', 'submission.submission_warehouse = ms_warehouse.warehouse_id');
        $this->db->join('ms_salesman', 'submission.submission_salesman = ms_salesman.salesman_id');
        $this->db->join('ms_supplier', 'submission.submission_last_supplier = ms_supplier.supplier_id', 'left');
        $this->db->join('ms_user', 'submission.created_by = ms_user.user_id');
        if($start_date != ''){
            $this->db->where('submission_date >=', $start_date);
        }
        if($end_date != ''){
            $this->db->where('submission_date <=', $end_date);
        }
        if($supplier_filter != ''){
            $this->db->where('submission_last_supplier', $supplier_filter);
        }
        if($keterangan_filter != ''){
            $this->db->where('submission_desc', $keterangan_filter);
        }
        if($status_filter != ''){
            $this->db->where('submission_status', $status_filter);
        }
        if($search != null){
            $this->db->where('ms_product.product_name like "%'.$search.'%"');
            $this->db->or_where('submission.submission_invoice like "%'.$search.'%"');
            $this->db->or_where('submission.submission_desc like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_code like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_supplier_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_key like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_desc like "%'.$search.'%"');
        }
        $query = $this->db->get();
        return $query;
    }

    public function submission_by_id($id)
    {
        $this->db->select('*');
        $this->db->from('submission');
        $this->db->join('ms_product', 'submission.submission_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_unit.unit_id = ms_product.product_unit');
        $this->db->join('ms_warehouse', 'submission.submission_warehouse = ms_warehouse.warehouse_id');
        $this->db->join('ms_salesman', 'submission.submission_salesman = ms_salesman.salesman_id', 'left');
        $this->db->join('ms_user', 'submission.created_by = ms_user.user_id');
        $this->db->where('submission_id like "%'.$id.'%"');
        $query = $this->db->get();
        return $query;
    }

    public function edit_submission($data_edit, $submission_id)
    {
        $this->db->set($data_edit);
        $this->db->where('submission_id ', $submission_id);
        $this->db->update('submission');
    }

    public function delete_submission($submission_id)
    {
        $this->db->set('submission_status', 'Cancel');
        $this->db->where('submission_id ', $submission_id);
        $this->db->update('submission');
    }

    public function get_current_stock($submission_product_id)
    {
        $query = $this->db->query("select sum(stock) as total_last_stock from ms_product a, ms_product_stock b where a.product_id = b.product_id and a.product_id = '".$submission_product_id."'");
        $result = $query->result();
        return $result;
    }

    public function get_submission_code($submission_id)
    {
        $query = $this->db->query("select submission_invoice from submission where submission_id  = '".$submission_id."'");
        $result = $query->result();
        return $result;
    }
    // end submission

    // start po

    public function check_input_warehouse()
    {   
        $this->db->select('*');
        $this->db->from('hd_po');
        
    }

    public function save_po($data_insert)
    {
        $this->db->trans_start();
        $this->db->insert('hd_po', $data_insert);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return  $insert_id;
    }

    public function check_submission($product_id, $submission_warehouse)
    {
        $this->db->select('*');
        $this->db->from('submission');
        $this->db->where('submission_product_id', $product_id);
        $this->db->where('submission_warehouse', $submission_warehouse);
        $this->db->where('submission_status', 'Pending');
        $query = $this->db->get();
        return $query;
    }

    public function po_list($search, $length, $start, $start_date_val, $end_date_val, $supplier_filter_val)
    {
        $this->db->select('*');
        $this->db->from('hd_po');
        $this->db->join('dt_po', 'hd_po.hd_po_id  = dt_po.hd_po_id ');
        $this->db->join('ms_product', 'dt_po.dt_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_unit.unit_id = ms_product.product_unit');
        $this->db->join('ms_warehouse', 'hd_po.hd_po_warehouse = ms_warehouse.warehouse_id');
        $this->db->join('ms_supplier', 'hd_po.hd_po_supplier = ms_supplier.supplier_id');
        $this->db->join('ms_user', 'hd_po.created_by = ms_user.user_id');
        if($start_date_val != null){
            $this->db->where('hd_po_date between "'.$start_date_val.'" and "'.$end_date_val.'" ');
        }
        if($supplier_filter_val != null){
            $this->db->where('hd_po_supplier','"'.$supplier_filter_val.'"');
        }
        if($search != null){
            $this->db->where('ms_product.product_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_code like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_supplier_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_key like "%'.$search.'%"');
            $this->db->or_where('hd_po.hd_po_invoice like "%'.$search.'%"');
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
        $this->db->join('dt_po', 'hd_po.hd_po_id  = dt_po.hd_po_id ');
        $this->db->join('ms_product', 'dt_po.dt_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_unit.unit_id = ms_product.product_unit');
        $this->db->join('ms_warehouse', 'hd_po.hd_po_warehouse = ms_warehouse.warehouse_id');
        $this->db->join('ms_user', 'hd_po.created_by = ms_user.user_id');
        if($start_date_val != null){
            $this->db->where('hd_po_date between "'.$start_date_val.'" and "'.$end_date_val.'" ');
        }
        if($supplier_filter_val != null){
            $this->db->where('hd_po_supplier','"'.$supplier_filter_val.'"');
        }
        if($search != null){
            $this->db->where('ms_product.product_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_code like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_supplier_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_key like "%'.$search.'%"');
            $this->db->or_where('hd_po.hd_po_invoice like "%'.$search.'%"');
        }
        $query = $this->db->get();
        return $query;
    }

    public function header_po($po_id)
    {
        $query = $this->db->query("select *, a.created_at as tanggal_po from hd_po a, ms_warehouse b, ms_supplier c, ms_user d, ms_ekspedisi e, ms_payment f where a.hd_po_warehouse = b.warehouse_id and a.hd_po_supplier = c.supplier_id and a.hd_po_payment = f.payment_id and a.created_by = d.user_id and a.hd_po_ekspedisi = e.ekspedisi_id and hd_po_id  = '".$po_id."'");
        $result = $query->result();
        return $result;
    }

    public function detail_po($po_id)
    {
        $query = $this->db->query("select * from dt_po a, hd_po b, ms_product c, ms_unit d, ms_user e where a.hd_po_id = b.hd_po_id and a.dt_product_id = c.product_id and c.product_unit = d.unit_id and b.created_by = e.user_id and a.hd_po_id  = '".$po_id."'");
        $result = $query->result();
        return $result;
    }

    public function check_supplier_stock($dt_product_id, $supplier_id)
    {
        $query = $this->db->query("select * from ms_product_supplier where product_id = '".$dt_product_id."' and supplier_id = '".$supplier_id."'");
        $result = $query->result();
        return $result;
    }

    public function update_submission_pending($submission_id_val)
    {
        $this->db->set('submission_status', 'Pending');
        $this->db->where('submission_id  ', $submission_id_val);
        $this->db->update('submission');
    }
    
    public function search_submission($search)
    {
        $this->db->select('*');
        $this->db->from('submission');
        $this->db->join('ms_product', 'submission.submission_product_id  = ms_product.product_id');
        $this->db->where('submission_status','Pending');
        if($search != null){
            $this->db->where('submission_invoice like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_name like "%'.$search.'%" and submission_status = "Pending"');
            $this->db->or_where('ms_product.product_code like "%'.$search.'%" and submission_status = "Pending"');
            $this->db->or_where('ms_product.product_supplier_name like "%'.$search.'%" and submission_status = "Pending"');
            $this->db->or_where('ms_product.product_key like "%'.$search.'%" and submission_status = "Pending"');
            $this->db->or_where('ms_product.product_desc like "%'.$search.'%" and submission_status = "Pending"');
        }
        $query = $this->db->get();
        return $query;
    }

    public function insert_temp_po($data_insert)
    {
        $this->db->insert('temp_po', $data_insert);
    }

    public function save_detail_po($data_insert_detail)
    {
        $this->db->insert('dt_po', $data_insert_detail);
    }

    public function update_submission($submission_id_val)
    {
        $this->db->set('submission_status', 'Success');
        $this->db->where('submission_id  ', $submission_id_val);
        $this->db->update('submission');
    }

    public function update_product_tag($product_supplier_id_tag, $product_supplier_tag, $dt_product_id)
    {
        $this->db->set('product_supplier_id_tag', $product_supplier_id_tag);
        $this->db->set('product_supplier_tag', $product_supplier_tag);
        $this->db->where('product_id', $dt_product_id);
        $this->db->update('ms_product');
    }

    public function edit_temp_po($product_id, $user_id, $data_insert)
    {
        $this->db->set($data_insert);
        $this->db->where('temp_product_id', $product_id);
        $this->db->where('temp_user_id', $user_id);
        $this->db->update('temp_po');
    }

    public function get_temp_po($user_id)
    {
        $this->db->select('*');
        $this->db->from('temp_po');
        $this->db->join('submission', 'temp_po.temp_submission_id  = submission.submission_id', 'left');
        $this->db->join('ms_product', 'temp_po.temp_product_id = ms_product.product_id');
        $this->db->join('ms_user', 'temp_po.temp_user_id = ms_user.user_id');
        $this->db->where('temp_user_id ', $user_id);
        $query = $this->db->get();
        return $query;
    }


    public function temp_po_list($search, $length, $start, $user)
    {
        $this->db->select('*');
        $this->db->from('temp_po');
        $this->db->join('submission', 'temp_po.temp_submission_id  = submission.submission_id', 'left');
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
        $this->db->join('submission', 'temp_po.temp_submission_id  = submission.submission_id ');
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

    public function delete_temp_po($temp_po_id)
    {
        $this->db->where('temp_po_id', $temp_po_id);
        $this->db->delete('temp_po');
    }

    public function check_temp_po($user_id)
    {
        $this->db->select('sum(temp_po_total) as sub_total, sum(temp_po_total_ongkir) as ongkir, is_ppn, temp_supplier_id');
        $this->db->from('temp_po');
        $this->db->join('submission', 'temp_po.temp_submission_id  = submission.submission_id', 'left');
        $this->db->join('ms_product', 'temp_po.temp_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_unit.unit_id = ms_product.product_unit');
        $this->db->join('ms_user', 'temp_po.temp_user_id = ms_user.user_id');
        $this->db->where('temp_user_id', $user_id);
        $query = $this->db->get();
        return $query;
    }


    public function check_edit_temp_po($temp_po_id)
    {
        $this->db->select('*');
        $this->db->from('temp_po');
        $this->db->join('submission', 'temp_po.temp_submission_id  = submission.submission_id', 'left');
        $this->db->join('ms_product', 'temp_po.temp_product_id = ms_product.product_id');
        $this->db->where('temp_po_id', $temp_po_id);
        $query = $this->db->get();
        return $query;
    }

    public function check_temp_po_input($product_id, $user_id)
    {
        $query = $this->db->query("select * from temp_po where temp_product_id = '".$product_id."' and temp_user_id = '".$user_id."'");
        $result = $query->result();
        return $result;
    }

    public function last_po()
    {
        $query = $this->db->query("select hd_po_invoice from hd_po  order by hd_po_id desc limit 1");
        $result = $query->result();
        return $result;
    }

    public function clear_temp_po($user_id)
    {
        $this->db->where('temp_user_id', $user_id);
        $this->db->delete('temp_po');
    }

    public function delete_po($po_id)
    {
        $this->db->set('hd_po_status', 'Cancel');
        $this->db->where('hd_po_id  ', $po_id);
        $this->db->update('hd_po');
    }

    public function get_po_code($po_id)
    {
        $query = $this->db->query("select hd_po_invoice from hd_po  where hd_po_id  = '".$po_id."'");
        $result = $query->result();
        return $result;
    }

    public function last_product_po_status($dt_product_id)
    {
        $query = $this->db->query("select product_po_status from ms_product  where product_id   = '".$dt_product_id."'");
        $result = $query->result();
        return $result;
    }

    public function update_product_po_status($dt_product_id, $new_product_po_status_number)
    {
        $this->db->set('product_po_status', $new_product_po_status_number);
        $this->db->where('product_id', $dt_product_id);
        $this->db->update('ms_product');
    }

    public function edit_po($data_insert, $purchase_order_id)
    {
        $this->db->set($data_insert);
        $this->db->where('hd_po_id', $purchase_order_id);
        $this->db->update('hd_po');
    }
    // end po

    // start warehouse input 

    public function search_po($search)
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

    public function temp_input_stock_list($search, $length, $start, $user)
    {
        $this->db->select('*');
        $this->db->from('temp_input_stock');
        $this->db->join('ms_product', 'temp_input_stock.temp_is_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_unit.unit_id = ms_product.product_unit');
        $this->db->join('ms_user', 'temp_input_stock.temp_is_user_id = ms_user.user_id');
        $this->db->where('temp_is_user_id', $user);
        if($search != null){
            $this->db->where('ms_product.product_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_code like "%'.$search.'%"');
        }
        $this->db->order_by('temp_input_stock.created_at', 'desc');
        $this->db->limit($length);
        $this->db->offset($start);
        $query = $this->db->get();
        return $query;
    }

    public function temp_input_stock_count($search, $user)
    {
        $this->db->select('count(*) as total_row');
        $this->db->from('temp_input_stock');
        $this->db->join('ms_product', 'temp_input_stock.temp_is_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_unit.unit_id = ms_product.product_unit');
        $this->db->join('ms_user', 'temp_input_stock.temp_is_user_id = ms_user.user_id');
        $this->db->where('temp_is_user_id', $user);
        if($search != null){
            $this->db->where('ms_product.product_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_code like "%'.$search.'%"');
        }
        $this->db->order_by('temp_input_stock.created_at', 'desc');
        $query = $this->db->get();
        return $query;
    }

    public function copy_temp_po($data_copy_temp_po)
    {
        $this->db->insert('temp_input_stock', $data_copy_temp_po);
    }

    public function clear_temp_input_stock($user_id)
    {
        $this->db->where('temp_is_user_id', $user_id);
        $this->db->delete('temp_input_stock');
    }

    public function check_temp_input_stock($user_id)
    {
        $this->db->select('temp_is_supplier, sum(temp_is_qty) as total_item, temp_is_warehouse, temp_is_ekspedisi, temp_is_po_code, temp_is_po_id');
        $this->db->from('temp_input_stock');
        $this->db->where('temp_is_user_id', $user_id);
        $query = $this->db->get();
        return $query;
    }

    public function get_temp_input_stock($user_id)
    {
        $this->db->select('*');
        $this->db->from('temp_input_stock');
        $this->db->where('temp_is_user_id', $user_id);
        $query = $this->db->get();
        return $query;
    }

    public function check_edit_temp_input_stock($product_id, $user_id)
    {
        $this->db->select('*');
        $this->db->from('temp_input_stock');
        $this->db->join('ms_product', 'temp_input_stock.temp_is_product_id = ms_product.product_id');
        $this->db->where('temp_is_product_id', $product_id);
        $this->db->where('temp_is_user_id', $user_id);
        $query = $this->db->get();
        return $query;
    }

    public function delete_temp_input_stock($product_id, $user_id)
    {
        $this->db->where('temp_is_product_id', $product_id);
        $this->db->where('temp_is_user_id', $user_id);
        $this->db->delete('temp_input_stock');
    }

    public function edit_temp_input_stock($product_id, $user_id, $data_edit)
    {
        $this->db->set($data_edit);
        $this->db->where('temp_is_product_id ', $product_id);
        $this->db->where('temp_is_user_id ', $user_id);
        $this->db->update('temp_input_stock');
    }

    public function last_save_input()
    {
        $query = $this->db->query("select hd_input_stock_inv from hd_input_stock order by hd_input_stock_id desc limit 1");
        $result = $query->result();
        return $result;
    }

    public function save_input_stock($data_insert)
    {
        $this->db->trans_start();
        $this->db->insert('hd_input_stock', $data_insert);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return  $insert_id;
    }

    public function insert_detail_input_stock($data_insert)
    {
        $this->db->insert('dt_input_stock', $data_insert);
    }

    public function get_last_stock($product_id, $warehouse_id)
    {
        $query = $this->db->query("select stock from ms_product a, ms_product_stock b where a.product_id = b.product_id and b.warehouse_id = '".$warehouse_id."' and b.product_id = '".$product_id."'");
        $result = $query->result();
        return $result;
    }

    public function warehouseinput_list($search, $length, $start, $start_date_val, $end_date_val, $warehouse_filter_val, $supplier_filter_val)
    {
   
        $this->db->select('*');
        $this->db->from('hd_input_stock');
        $this->db->join('dt_input_stock', 'hd_input_stock.hd_input_stock_id   = dt_input_stock.hd_is_id ');
        $this->db->join('hd_po', 'hd_input_stock.hd_po_id   = hd_po.hd_po_id ');
        $this->db->join('ms_product', 'dt_input_stock.dt_is_product_id   = ms_product.product_id ');
        $this->db->join('ms_supplier', 'hd_po.hd_po_supplier   = ms_supplier.supplier_id ');
        $this->db->join('ms_warehouse', 'hd_input_stock.hd_input_stock_warehouse = ms_warehouse.warehouse_id');
        $this->db->join('ms_user', 'hd_input_stock.created_by = ms_user.user_id');
        if($start_date_val != null){
            $this->db->where('hd_input_stock_date between "'.$start_date_val.'" and "'.$end_date_val.'" ');
        }
        if($warehouse_filter_val != null){
            $this->db->where('hd_input_stock_warehouse', $warehouse_filter_val);
        }
        if($supplier_filter_val != null){
            $this->db->where('hd_po.hd_po_supplier', $supplier_filter_val);
        }
        if($search != null){
            $this->db->where('ms_product.product_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_code like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_supplier_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_key like "%'.$search.'%"');
            $this->db->or_where('hd_input_stock.hd_input_stock_inv like "%'.$search.'%"');
        }
        $this->db->order_by('hd_input_stock.created_at', 'desc');
        $this->db->limit($length);
        $this->db->offset($start);
        $query = $this->db->get();
        return $query;
    }

    public function warehouseinput_list_count($search, $start_date_val, $end_date_val, $warehouse_filter_val, $supplier_filter_val)
    {
        $this->db->select('count(*) as total_row');
        $this->db->from('hd_input_stock');
        $this->db->join('dt_input_stock', 'hd_input_stock.hd_input_stock_id   = dt_input_stock.hd_is_id ');
        $this->db->join('hd_po', 'hd_input_stock.hd_po_id   = hd_po.hd_po_id ');
        $this->db->join('ms_product', 'dt_input_stock.dt_is_product_id   = ms_product.product_id ');
        $this->db->join('ms_supplier', 'hd_po.hd_po_supplier   = ms_supplier.supplier_id ');
        $this->db->join('ms_warehouse', 'hd_input_stock.hd_input_stock_warehouse = ms_warehouse.warehouse_id');
        $this->db->join('ms_user', 'hd_input_stock.created_by = ms_user.user_id');
        if($start_date_val != null){
            $this->db->where('hd_input_stock_date between "'.$start_date_val.'" and "'.$end_date_val.'" ');
        }
        if($warehouse_filter_val != null){
            $this->db->where('hd_input_stock_warehouse', $warehouse_filter_val);
        }
        if($supplier_filter_val != null){
            $this->db->where('hd_po.hd_po_supplier', $supplier_filter_val);
        }
        if($search != null){
            $this->db->where('ms_product.product_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_code like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_supplier_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_key like "%'.$search.'%"');
            $this->db->or_where('hd_input_stock.hd_input_stock_inv like "%'.$search.'%"');
        }
        $query = $this->db->get();
        return $query;
    }

    public function header_input_stock($input_stock_id)
    {
        $query = $this->db->query("select * from hd_input_stock a, hd_po b, ms_warehouse c, ms_user d, ms_ekspedisi e where a.hd_po_id = b.hd_po_id and a.hd_input_stock_warehouse = c.warehouse_id and a.created_by = d.user_id and b.hd_po_ekspedisi = e.ekspedisi_id and hd_input_stock_id  = '".$input_stock_id."'");
        $result = $query->result();
        return $result;
    }

    public function detail_input_stock($input_stock_id)
    {
        $query = $this->db->query("select * from dt_input_stock a, hd_input_stock b, ms_product c, ms_unit d where a.hd_is_id = b.hd_input_stock_id  and a.dt_is_product_id = c.product_id and c.product_unit = d.unit_id and hd_is_id = '".$input_stock_id."'");
        $result = $query->result();
        return $result;
    }

    public function delete_warehouse_input($input_stock_id)
    {
        $this->db->set('hd_input_stock_status', 'Cancel');
        $this->db->where('hd_input_stock_id   ', $input_stock_id);
        $this->db->update('hd_input_stock');
    }

    public function update_po_status($po_inv_id)
    {
        $this->db->set('hd_po_status', 'Success');
        $this->db->where('hd_po_id ', $po_inv_id);
        $this->db->update('hd_po');
    }

    public function update_purchase_input_stock($po_id)
    {
        $this->db->set('hd_input_stock_status', 'Success');
        $this->db->where('hd_po_id ', $po_id);
        $this->db->update('hd_input_stock');
    }

    public function search_po_purchase($search)
    {
        $this->db->select('*');
        $this->db->from('hd_po');
        $this->db->where('hd_po_status','Success');
        $this->db->where('hd_po_purchase_status','Pending');
        if($search != null){
            $this->db->where('hd_po_invoice like "%'.$search.'%"');
        }
        $query = $this->db->get();
        return $query;
    }

    public function get_input_warehouse_code($input_stock_id)
    {
        $query = $this->db->query("select hd_input_stock_inv, hd_po_id from hd_input_stock  where hd_po_id  = '".$input_stock_id."'");
        $result = $query->result();
        return $result;
    }

    public function update_po_input($hd_po_id)
    {
        $this->db->set('hd_po_status', 'Pending');
        $this->db->where('hd_po_id ', $hd_po_id);
        $this->db->update('hd_po');
    }
    // end warehouse input 


    //purchase

    public function get_last_note_product($product_id_note)
    {
        $this->db->select('product_note');
        $this->db->from('ms_product');
        $this->db->where('product_id', $product_id_note);
        $query = $this->db->get();
        return $query;
    }

    public function update_note_product($product_id_note, $new_note)
    {
        $this->db->set('product_note', $new_note);
        $this->db->where('product_id', $product_id_note);
        $this->db->update('ms_product');
    }

    public function copy_temp_purchase($data_copy_temp)
    {
        $this->db->insert('temp_purchase', $data_copy_temp);
    }

    public function purchase_list($search, $length, $start, $start_date_val, $end_date_val, $supplier_filter_val, $purchase_type)
    {
        $this->db->select('*');
        $this->db->from('hd_purchase');
        $this->db->join('dt_purchase', 'hd_purchase.hd_purchase_id  = dt_purchase.hd_purchase_id ');
        $this->db->join('ms_product', 'dt_purchase.dt_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_unit.unit_id = ms_product.product_unit');
        $this->db->join('ms_warehouse', 'hd_purchase.hd_purchase_warehouse = ms_warehouse.warehouse_id');
        $this->db->join('ms_supplier', 'hd_purchase.hd_purchase_supplier = ms_supplier.supplier_id');
        $this->db->join('ms_user', 'hd_purchase.created_by = ms_user.user_id');
        $this->db->where('hd_purchase_type', $purchase_type);
        if($start_date_val != null){
            $this->db->where('hd_po_date between "'.$start_date_val.'" and "'.$end_date_val.'" ');
        }
        if($supplier_filter_val != null){
            $this->db->where('hd_purchase_supplier','"'.$supplier_filter_val.'"');
        }
        if($search != null){
            $this->db->where('ms_product.product_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_code like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_supplier_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_key like "%'.$search.'%"');
            $this->db->or_where('hd_purchase.hd_purchase_invoice like "%'.$search.'%"');
        }
        $this->db->order_by('hd_purchase.created_at', 'desc');
        $this->db->limit($length);
        $this->db->offset($start);
        $query = $this->db->get();
        return $query;
    }

    public function purchase_list_count($search, $start_date_val, $end_date_val, $supplier_filter_val, $purchase_type)
    {
        $this->db->select('count(*) as total_row');
        $this->db->from('hd_purchase');
        $this->db->join('dt_purchase', 'hd_purchase.hd_purchase_id  = dt_purchase.hd_purchase_id ');
        $this->db->join('ms_product', 'dt_purchase.dt_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_unit.unit_id = ms_product.product_unit');
        $this->db->join('ms_warehouse', 'hd_purchase.hd_purchase_warehouse = ms_warehouse.warehouse_id');
        $this->db->join('ms_supplier', 'hd_purchase.hd_purchase_supplier = ms_supplier.supplier_id');
        $this->db->join('ms_user', 'hd_purchase.created_by = ms_user.user_id');
        $this->db->where('hd_purchase_type', $purchase_type);
        if($start_date_val != null){
            $this->db->where('hd_po_date between "'.$start_date_val.'" and "'.$end_date_val.'" ');
        }
        if($supplier_filter_val != null){
            $this->db->where('hd_purchase_supplier','"'.$supplier_filter_val.'"');
        }
        if($search != null){
            $this->db->where('ms_product.product_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_code like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_supplier_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_key like "%'.$search.'%"');
            $this->db->or_where('hd_purchase.hd_purchase_invoice like "%'.$search.'%"');
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

    public function detail_po_purchase($po_id)
    {
        $query = $this->db->query("select * from dt_po a, hd_po b, ms_product c, ms_unit d, ms_user e, hd_input_stock f, dt_input_stock g where a.hd_po_id = b.hd_po_id and a.dt_product_id = c.product_id and c.product_unit = d.unit_id and b.hd_po_id = f.hd_po_id and f.hd_input_stock_id  = g.hd_is_id and b.created_by = e.user_id and a.hd_po_id  = '".$po_id."' and hd_input_stock_status = 'Pending' group by dt_po_id");
        $result = $query->result();
        return $result;
    }


    public function delete_temp_purchase($product_id, $user_id)
    {
        $this->db->where('temp_product_id', $product_id);
        $this->db->where('temp_user_id', $user_id);
        $this->db->delete('temp_purchase');
    }

    public function check_temp_purchase($user_id)
    {
        $this->db->select('*, sum(temp_purchase_total) as sub_total, sum(temp_purchase_total_ongkir) as ongkir');
        $this->db->from('temp_purchase');
        $this->db->join('hd_po', 'temp_purchase.temp_purchase_po_id  = hd_po.hd_po_id ');
        $this->db->where('temp_user_id', $user_id);
        $query = $this->db->get();
        return $query;
    }

    public function check_edit_temp_purchase($temp_product_id, $temp_user_id)
    {
        $this->db->select('*');
        $this->db->from('temp_purchase');
        $this->db->join('ms_product', 'temp_purchase.temp_product_id = ms_product.product_id');
        $this->db->where('temp_product_id', $temp_product_id);
        $this->db->where('temp_user_id', $temp_user_id);
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
        $this->db->set('hd_po_purchase_status', 'Success');
        $this->db->where('hd_po_id', $po_id);
        $this->db->update('hd_po');
    }

    public function clear_temp_purchase($user_id)
    {
        $this->db->where('temp_user_id', $user_id);
        $this->db->delete('temp_purchase');
    }

    public function header_purchase($purchase_id)
    {
        $query = $this->db->query("select *, a.created_at as tanggal_purchase from hd_purchase a, ms_warehouse b, ms_supplier c, ms_user d, ms_ekspedisi e, ms_payment f where a.hd_purchase_warehouse = b.warehouse_id and a.hd_purchase_supplier = c.supplier_id and a.hd_purchase_payment = f.payment_id and a.created_by = d.user_id and a.hd_purchase_ekspedisi = e.ekspedisi_id and hd_purchase_id  = '".$purchase_id."'");
        $result = $query->result();
        return $result;
    }

    public function detail_purchase($purchase_id)
    {
        $query = $this->db->query("select * from dt_purchase a, hd_purchase b, ms_product c, ms_unit d, ms_user e where a.hd_purchase_id = b.hd_purchase_id and a.dt_product_id = c.product_id and c.product_unit = d.unit_id and b.created_by = e.user_id and a.hd_purchase_id  = '".$purchase_id."'");
        $result = $query->result();
        return $result;
    }

    public function save_note_product($data_insert_note)
    {
        $this->db->insert('ms_product_note', $data_insert_note);
    }
    //end purchase


    // retur purchase

    public function returpurchase_list($search, $length, $start)
    {
        $this->db->select('*');
        $this->db->from('hd_retur_purchase');
        $this->db->join('dt_retur_purchase', 'hd_retur_purchase.hd_retur_purchase_id = dt_retur_purchase.hd_retur_purchase_id');
        $this->db->join('ms_supplier', 'hd_retur_purchase.hd_retur_purchase_supplier_id = ms_supplier.supplier_id');
        $this->db->join('ms_product', 'dt_retur_purchase.dt_retur_purchase_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_unit.unit_id = ms_product.product_unit');
        $this->db->join('ms_user', 'hd_retur_purchase.created_by = ms_user.user_id');
        if($search != null){
            $this->db->where('ms_product.product_name like "%'.$search.'%"');
            $this->db->or_where('hd_retur_purchase.hd_retur_purchase_inv like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_code like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_supplier_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_key like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_desc like "%'.$search.'%"');
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
        $this->db->join('dt_retur_purchase', 'hd_retur_purchase.hd_retur_purchase_id = dt_retur_purchase.hd_retur_purchase_id');
        $this->db->join('ms_supplier', 'hd_retur_purchase.hd_retur_purchase_supplier_id = ms_supplier.supplier_id');
        $this->db->join('ms_product', 'dt_retur_purchase.dt_retur_purchase_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_unit.unit_id = ms_product.product_unit');
        $this->db->join('ms_user', 'hd_retur_purchase.created_by = ms_user.user_id');
        if($search != null){
            $this->db->where('ms_product.product_name like "%'.$search.'%"');
            $this->db->or_where('hd_retur_purchase.hd_retur_purchase_inv like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_code like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_supplier_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_key like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_desc like "%'.$search.'%"');
        }
        $query = $this->db->get();
        return $query;
    }

    public function search_product_retur($keyword, $purchase_id)
    {
        $this->db->select('*');
        $this->db->from('hd_purchase');
        $this->db->join('dt_purchase', 'hd_purchase.hd_purchase_id = dt_purchase.hd_purchase_id');
        $this->db->join('ms_product', 'dt_purchase.dt_product_id = ms_product.product_id');
        if($keyword != null){
            $this->db->or_where('(ms_product.product_name like "%'.$keyword.'%" or ms_product.product_code like "%'.$keyword.'%" or ms_product.product_supplier_name like "%'.$keyword.'%" or ms_product.product_key like "%'.$keyword.'%" or ms_product.product_desc like "%'.$keyword.'%")' );
        }
        $this->db->where('hd_purchase.hd_purchase_id', $purchase_id);
        $this->db->limit(50);
        $query = $this->db->get();
        return $query;
    }

    public function check_temp_retur_purchase_input($purchase_id, $product_id, $user_id)
    {
        $query = $this->db->query("select * from temp_retur_purchase where temp_retur_purchase_product_id = '".$product_id."' and temp_retur_purchase_b_id ='".$purchase_id."' and temp_user_id = '".$user_id."'");
        $result = $query->result();
        return $result;
    }

    public function check_total_item_retur($purchase_id, $product_id)
    {
        $query = $this->db->query("select sum(dt_retur_purchase_qty) as total_qty_retur from dt_retur_purchase a, hd_retur_purchase b where a.hd_retur_purchase_id = b.hd_retur_purchase_id  and dt_retur_purchase_b_id = '".$purchase_id."' and dt_retur_purchase_product_id = '".$product_id."' and hd_retur_purchase_status = 'Success'");
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


    public function check_edit_temp_retur_purchase($temp_product_id, $temp_purchase_id, $temp_user_id)
    {
        $this->db->select('*');
        $this->db->from('temp_retur_purchase');
        $this->db->join('ms_product', 'temp_retur_purchase.temp_retur_purchase_product_id = ms_product.product_id');
        $this->db->where('temp_retur_purchase_product_id', $temp_product_id);
        $this->db->where('temp_retur_purchase_b_id', $temp_purchase_id);
        $this->db->where('temp_user_id', $temp_user_id);
        $query = $this->db->get();
        return $query;
    }

    public function delete_temp_retur_purchase($product_id, $purchase_id)
    {
        $this->db->where('temp_retur_purchase_product_id', $product_id);
        $this->db->where('temp_retur_purchase_b_id', $purchase_id);
        $this->db->delete('temp_retur_purchase');
    }

    public function last_retur_purchase()
    {
        $query = $this->db->query("select hd_retur_purchase_inv from hd_retur_purchase order by hd_retur_purchase_id  desc limit 1");
        $result = $query->result();
        return $result;
    }

    public function clear_detail_po($purchase_order_id)
    {
        $this->db->where('hd_po_id', $purchase_order_id);
        $this->db->delete('dt_po');
    }

    public function save_retur_purchase($data_insert)
    {
        $this->db->trans_start();
        $this->db->insert('hd_retur_purchase', $data_insert);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return  $insert_id;
    }

    public  function save_detail_retur_purchase($data_insert_detail)
    {
        $this->db->insert('dt_retur_purchase', $data_insert_detail);
    }

    public function clear_temp_retur_purchase($user_id)
    {
        $this->db->where('temp_user_id', $user_id);
        $this->db->delete('temp_retur_purchase');
    }

    public function get_temp_retur_purchase($user_id)
    {
        $this->db->select('*');
        $this->db->from('temp_retur_purchase');
        $this->db->join('ms_product', 'temp_retur_purchase.temp_retur_purchase_product_id = ms_product.product_id');
        $this->db->join('ms_user', 'temp_retur_purchase.temp_user_id = ms_user.user_id');
        $this->db->where('temp_user_id ', $user_id);
        $query = $this->db->get();
        return $query;
    }

    public function get_detail_retur_purchase_data($retur_purchase_id)
    {
        $query = $this->db->query("select * from dt_retur_purchase where hd_retur_purchase_id = '".$retur_purchase_id."'");
        $result = $query->result();
        return $result;
    }

    public function header_retur_purchase($retur_purchase_id)
    {
        $query = $this->db->query("select * from hd_retur_purchase a, ms_supplier c, ms_user d where a.hd_retur_purchase_supplier_id = c.supplier_id and a.created_by = d.user_id and hd_retur_purchase_id  = '".$retur_purchase_id."'");
        $result = $query->result();
        return $result;
    }


    public function detail_retur_purchase($retur_purchase_id)
    {
        $query = $this->db->query("select * from dt_retur_purchase a, ms_warehouse b, hd_purchase c, ms_product d, ms_unit e where a.dt_retur_warehouse_id = b.warehouse_id and a.dt_retur_purchase_b_id = c.hd_purchase_id and a.dt_retur_purchase_product_id = d.product_id and d.product_unit = e.unit_id and hd_retur_purchase_id = '".$retur_purchase_id."'");
        $result = $query->result();
        return $result;
    }

    public function detail_retur_purchase_delete($retur_purchase_id)
    {
        $query = $this->db->query("select * from dt_retur_purchase a, ms_warehouse b, hd_purchase c, ms_product d, ms_unit e, hd_retur_purchase f where a.dt_retur_warehouse_id = b.warehouse_id and a.dt_retur_purchase_b_id = c.hd_purchase_id and a.dt_retur_purchase_product_id = d.product_id and d.product_unit = e.unit_id and a.hd_retur_purchase_id = f.hd_retur_purchase_id and a.hd_retur_purchase_id = '".$retur_purchase_id."'");
        $result = $query->result();
        return $result;
    }

    public function delete_retur_purchase($retur_purchase_id)
    {
        $this->db->set('hd_retur_purchase_status', 'Cancel');
        $this->db->where('hd_retur_purchase_id', $retur_purchase_id);
        $this->db->update('hd_retur_purchase');
    }

    public function update_retur_purchase($retur_purchase_id, $payment_type)
    {
        $this->db->set('hd_retur_purchase_payment_type', $payment_type);
        $this->db->set('hd_retur_purchase_status', 'Success');
        $this->db->where('hd_retur_purchase_id ', $retur_purchase_id);
        $this->db->update('hd_retur_purchase');
    }

    public function check_temp_purchase_revisi($user_id)
    {
        $this->db->select('*, sum(temp_purchase_total) as sub_total, sum(temp_purchase_total_ongkir) as ongkir');
        $this->db->from('temp_purchase');
        $this->db->where('temp_user_id', $user_id);
        $query = $this->db->get();
        return $query;
    }
    // end retur purchase
}

?>