<?php

class transferstock_model extends CI_Model {


    public function transferstock_list($search, $length, $start)
    {
        $this->db->select('*, from.warehouse_name as from, to.warehouse_name as to');
        $this->db->from('hd_transfer_stock');
        $this->db->join('dt_transfer_stock', 'hd_transfer_stock.hd_transfer_stock_id = dt_transfer_stock.hd_transfer_stock_id');
        $this->db->join('ms_product', 'dt_transfer_stock.dt_transfer_stock_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_product.product_unit = ms_unit.unit_id');
        $this->db->join('ms_warehouse AS from', 'dt_transfer_stock.dt_transfer_stock_warehouse_from = from.warehouse_id');
        $this->db->join('ms_warehouse AS to', 'dt_transfer_stock.dt_transfer_stock_warehouse_to = to.warehouse_id');
        $this->db->join('ms_user', 'hd_transfer_stock.user_id = ms_user.user_id');
        if($search != null){
            $this->db->where('ms_product.product_name like "%'.$search.'%"');
            $this->db->or_where('hd_transfer_stock.hd_transfer_stock_code like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_code like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_supplier_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_key like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_desc like "%'.$search.'%"');
        }
        $this->db->order_by('hd_transfer_stock.created_at', 'desc');
        $this->db->limit($length);
        $this->db->offset($start);
        $query = $this->db->get();
        return $query;
    }

    public function last_stock_from($product_id_check, $from_check)
    {
        $this->db->select('*');
        $this->db->from('ms_product_stock');
        $this->db->where('product_id', $product_id_check);
        $this->db->where('warehouse_id', $from_check);
        $query = $this->db->get();
        return $query;
    }

     public function last_stock_to($product_id_check, $to_check)
    {
        $this->db->select('*');
        $this->db->from('ms_product_stock');
        $this->db->where('product_id', $product_id_check);
        $this->db->where('warehouse_id', $to_check);
        $query = $this->db->get();
        return $query;
    }

    public function transferstock_list_count($search)
    {
        $this->db->select('count(*) as total_row');
        $this->db->from('hd_transfer_stock');
        $this->db->join('dt_transfer_stock', 'hd_transfer_stock.hd_transfer_stock_id = dt_transfer_stock.hd_transfer_stock_id');
        $this->db->join('ms_product', 'dt_transfer_stock.dt_transfer_stock_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_product.product_unit = ms_unit.unit_id');
        $this->db->join('ms_warehouse AS from', 'dt_transfer_stock.dt_transfer_stock_warehouse_from = from.warehouse_id');
        $this->db->join('ms_warehouse AS to', 'dt_transfer_stock.dt_transfer_stock_warehouse_to = to.warehouse_id');
        $this->db->join('ms_user', 'hd_transfer_stock.user_id = ms_user.user_id');
        if($search != null){
            $this->db->where('ms_product.product_name like "%'.$search.'%"');
            $this->db->or_where('hd_transfer_stock.hd_transfer_stock_code like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_code like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_supplier_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_key like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_desc like "%'.$search.'%"');
        }
        $query = $this->db->get();
        return $query;
    }

    public function check_temp_transfer_stock($user_id)
    {
        $this->db->select('sum(temp_transfer_stock_qty) as total');
        $this->db->from('temp_transfer_stock');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        return $query;
    }

    public function temp_transfer_stock_list($search, $length, $start, $user)
    {
        $this->db->select('*, from.warehouse_name as from, to.warehouse_name as to');
        $this->db->from('temp_transfer_stock');
        $this->db->join('ms_product', 'temp_transfer_stock.temp_transfer_stock_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_unit.unit_id = ms_product.product_unit');
        $this->db->join('ms_warehouse AS from', 'temp_transfer_stock.temp_transfer_stock_warehouse_from = from.warehouse_id');
        $this->db->join('ms_warehouse AS to', 'temp_transfer_stock.temp_transfer_stock_warehouse_to = to.warehouse_id');
        $this->db->join('ms_user', 'temp_transfer_stock.user_id = ms_user.user_id');
        $this->db->where('temp_transfer_stock.user_id', $user);
        if($search != null){
            $this->db->where('ms_product.product_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_code like "%'.$search.'%"');
        }
        $this->db->order_by('temp_transfer_stock.created_at', 'desc');
        $this->db->limit($length);
        $this->db->offset($start);
        $query = $this->db->get();
        return $query;
    }

    public function temp_transfer_stock_list_count($search, $user)
    {
        $this->db->select('count(*) as total_row');
        $this->db->from('temp_transfer_stock');
        $this->db->join('ms_product', 'temp_transfer_stock.temp_transfer_stock_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_unit.unit_id = ms_product.product_unit');
        $this->db->join('ms_warehouse AS from', 'temp_transfer_stock.temp_transfer_stock_warehouse_from = from.warehouse_id');
        $this->db->join('ms_warehouse AS to', 'temp_transfer_stock.temp_transfer_stock_warehouse_to = to.warehouse_id');
        $this->db->join('ms_user', 'temp_transfer_stock.user_id = ms_user.user_id');
        $this->db->where('temp_transfer_stock.user_id', $user);
        if($search != null){
            $this->db->where('ms_product.product_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_code like "%'.$search.'%"');
        }
        $this->db->order_by('temp_transfer_stock.created_at', 'desc');
        $query = $this->db->get();
        return $query;
    }

    public function check_temp_transfer_stock_input($product_id, $user_id, $transfer_to)
    {
        $this->db->select('*');
        $this->db->from('temp_transfer_stock');
        $this->db->where('user_id', $user_id);
        $this->db->where('temp_transfer_stock_product_id', $product_id);
        $this->db->where('temp_transfer_stock_warehouse_to', $transfer_to);
        $query = $this->db->get();
        return $query;
    }

    public function temp_transfer_stock($user_id)
    {
        $this->db->select('*');
        $this->db->from('temp_transfer_stock');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        return $query;
    }

    public function add_temp_transfer_stock($data_insert)
    {
        $this->db->insert('temp_transfer_stock', $data_insert);
    }

    public function edit_temp_transfer_stock($product_id, $user_id, $data_insert)
    {
        $this->db->set($data_insert);
        $this->db->where('temp_transfer_stock_product_id', $product_id);
        $this->db->where('user_id', $user_id);
        $this->db->update('temp_transfer_stock');
    }

    public function check_edit_temp_transfer_stock($product_id, $user_id)
    {
        $this->db->select('temp_transfer_stock.*, product_name');
        $this->db->from('temp_transfer_stock');
        $this->db->join('ms_product', 'temp_transfer_stock.temp_transfer_stock_product_id = ms_product.product_id');
        $this->db->where('temp_transfer_stock_product_id', $product_id);
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        return $query;
    }

    public function delete_temp_transfer_stock($product_id, $user_id)
    {
        $this->db->where('temp_transfer_stock_product_id', $product_id);
        $this->db->where('user_id', $user_id);
        $this->db->delete('temp_transfer_stock');
    }

    public function save_detail_transfer_stock($data_insert_detail)
    {
        $this->db->insert('dt_transfer_stock', $data_insert_detail);
    }

    public function last_transfer_stock()
    {
        $query = $this->db->query("select hd_transfer_stock_code from hd_transfer_stock  order by hd_transfer_stock_id   desc limit 1");
        $result = $query->result();
        return $result;
    }

    public function save_transfer_stock($data_insert)
    {
        $this->db->trans_start();
        $this->db->insert('hd_transfer_stock', $data_insert);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return  $insert_id;
    }

    public function get_last_stock($product_id, $warehouse_id)
    {
        $query = $this->db->query("select stock from ms_product a, ms_product_stock b where a.product_id = b.product_id and b.warehouse_id = '".$warehouse_id."' and b.product_id = '".$product_id."'");
        $result = $query->result();
        return $result;
    }

    public function clear_transfer_stock($user_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->delete('temp_transfer_stock');
    }

    public function header_transfer_stock($hd_transfer_id)
    {   
        $query = $this->db->query("select * from hd_transfer_stock a, ms_user b where a.user_id = b.user_id and hd_transfer_stock_id   = '".$hd_transfer_id."'");
        $result = $query->result();
        return $result;
    }

    public function detail_transfer_stock($hd_transfer_id)
    {
        $this->db->select('*, from.warehouse_name as from, to.warehouse_name as to');
        $this->db->from('dt_transfer_stock');
        $this->db->join('ms_product', 'dt_transfer_stock.dt_transfer_stock_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_product.product_unit = ms_unit.unit_id');
        $this->db->join('ms_warehouse AS from', 'dt_transfer_stock.dt_transfer_stock_warehouse_from = from.warehouse_id');
        $this->db->join('ms_warehouse AS to', 'dt_transfer_stock.dt_transfer_stock_warehouse_to = to.warehouse_id');
        $this->db->where('hd_transfer_stock_id', $hd_transfer_id);
        $query = $this->db->get();
        return $query;
    }

    public function update_transfer_stock($hd_transfer_id)
    {
        $this->db->set('hd_transfer_stock_status', 'Cancel');
        $this->db->where('hd_transfer_stock_id', $hd_transfer_id);
        $this->db->update('hd_transfer_stock');
    }
}   

?>