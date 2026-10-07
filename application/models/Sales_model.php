<?php

class sales_model extends CI_Model {


    // start sales
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
        $query = $this->db->query("select *, a.created_at as trx_created_at from hd_sales a, ms_warehouse b, ms_customer c, ms_user d, ms_payment e where a.hd_sales_warehouse = b.warehouse_id and a.hd_sales_customer = c.customer_id and a.hd_sales_payment = e.payment_id and a.created_by = d.user_id and hd_sales_id = '".$hd_sales_id."'");
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
        $this->db->join('ms_product_package', 'temp_sales.temp_package_id = ms_product_package.package_id', 'left');
        $this->db->where('temp_user_id', $user);
        if($search != null){
            $this->db->group_start();
            $this->db->where('ms_product.product_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_code like "%'.$search.'%"');
            $this->db->group_end();
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
            $this->db->group_start();
            $this->db->where('ms_product.product_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_code like "%'.$search.'%"');
            $this->db->group_end();
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

    // satu baris keranjang = produk + satuan (satuan terkecil atau satuan besar tertentu)
    public function edit_temp_sales($product_id, $user_id, $package_id, $data_insert)
    {
        $this->db->set($data_insert);
        $this->db->where('temp_product_id ', $product_id);
        $this->db->where('temp_package_id ', $package_id);
        $this->db->where('temp_user_id ', $user_id);
        $this->db->update('temp_sales');
    }   

    public function add_temp_sales($data_insert)
    {
        $this->db->insert('temp_sales', $data_insert);
    }

    public function check_temp_sales_input($product_id, $user_id, $package_id)
    {
        $query = $this->db->query("select * from temp_sales where temp_product_id = ? and temp_package_id = ? and temp_user_id = ?", array($product_id, $package_id, $user_id));
        $result = $query->result();
        return $result;
    }

    // total satuan terkecil produk ini di keranjang pada baris satuan lain (untuk cek stok gabungan)
    public function temp_base_qty_other($product_id, $user_id, $package_id)
    {
        $row = $this->db->query("select coalesce(sum(temp_sales_qty * temp_package_conv), 0) as qty from temp_sales where temp_product_id = ? and temp_user_id = ? and temp_package_id <> ?", array($product_id, $user_id, $package_id))->row_array();
        return (int) $row['qty'];
    }

    public function check_edit_temp_sales($temp_product_id, $temp_user_id, $temp_package_id)
    {
        $this->db->select('*');
        $this->db->from('temp_sales');
        $this->db->join('ms_product', 'temp_sales.temp_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_unit.unit_id = ms_product.product_unit');
        $this->db->join('ms_product_package', 'temp_sales.temp_package_id = ms_product_package.package_id', 'left');
        $this->db->where('temp_product_id', $temp_product_id);
        $this->db->where('temp_package_id', $temp_package_id);
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

    // satuan besar aktif milik produk (null kalau tidak ada / bukan milik produk ini)
    public function get_package($product_id, $package_id)
    {
        return $this->db->query("select * from ms_product_package where package_id = ? and product_id = ? and is_active = 'Y'", array($package_id, $product_id))->row_array();
    }

    // daftar satuan besar beberapa produk sekaligus: [product_id => [package, ...]]
    public function packages_by_products($product_ids)
    {
        $result = array();
        $product_ids = array_values(array_filter(array_map('intval', (array) $product_ids)));
        if(empty($product_ids)){
            return $result;
        }
        $rows = $this->db->query("select package_id, product_id, package_name, package_qty from ms_product_package where is_active = 'Y' and product_id in (".implode(',', $product_ids).") order by package_qty asc")->result_array();
        foreach($rows as $row){
            $result[$row['product_id']][] = array('id' => (int) $row['package_id'], 'name' => $row['package_name'], 'qty' => (int) $row['package_qty']);
        }
        return $result;
    }

    public function delete_temp_sales($product_id, $user_id, $package_id)
    {
        $this->db->where('temp_product_id', $product_id);
        $this->db->where('temp_package_id', $package_id);
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
        $this->db->join('ms_product_package', 'temp_sales.temp_package_id = ms_product_package.package_id', 'left');
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

    // modal per unit: pakai product_hpp_discount kalau diisi, kalau kosong pakai product_hpp
    public function get_unit_cost($product_id)
    {
        $row = $this->db->query("select coalesce(nullif(product_hpp_discount, 0), product_hpp) as cost from ms_product where product_id = ?", array($product_id))->row_array();
        return $row ? (float) $row['cost'] : 0;
    }

    public function save_detail_sales($data_insert_detail)
    {
        // simpan modal & laba saat transaksi: laba = (harga jual - diskon item) - modal x qty
        $cost = $this->get_unit_cost($data_insert_detail['dt_sales_product_id']);
        $data_insert_detail['dt_sales_cost']   = $cost;
        $data_insert_detail['dt_sales_profit'] = $data_insert_detail['dt_sales_total'] - ($data_insert_detail['dt_sales_qty'] * $cost);
        $this->db->insert('dt_sales', $data_insert_detail);
    }

    public function delete_sales($sales_id)
    {
        $this->db->set('hd_sales_status', 'Cancel');
        $this->db->where('hd_sales_id', $sales_id);
        $this->db->update('hd_sales');
    }

    // end retur sales

    // start retur sales

    public function retursales_list($search, $length, $start)
    {
        $this->db->select('*');
        $this->db->from('hd_retur_sales');
        $this->db->join('ms_customer', 'hd_retur_sales.hd_retur_sales_customer_id = ms_customer.customer_id');
        $this->db->join('ms_user', 'hd_retur_sales.created_by = ms_user.user_id');
        if($search != null){
            $this->db->group_start();
            $this->db->where('hd_retur_sales.hd_retur_sales_inv like "%'.$search.'%"');
            $this->db->or_where('ms_customer.customer_name like "%'.$search.'%"');
            $this->db->group_end();
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
            $this->db->group_start();
            $this->db->where('hd_retur_sales.hd_retur_sales_inv like "%'.$search.'%"');
            $this->db->or_where('ms_customer.customer_name like "%'.$search.'%"');
            $this->db->group_end();
        }
        $query = $this->db->get();
        return $query;
    }

     public function header_retur_sales($retur_sales_id)
    {
        $query = $this->db->query("select *, a.created_at as trx_created_at from hd_retur_sales a, ms_customer c, ms_user d where a.hd_retur_sales_customer_id = c.customer_id and a.created_by = d.user_id and hd_retur_sales_id  = '".$retur_sales_id."'");
        $result = $query->result();
        return $result;
    }


    public function detail_retur_sales($retur_sales_id)
    {
        $query = $this->db->query("select * from dt_retur_sales a,  hd_sales b, ms_product c, ms_unit d, hd_retur_sales e where  a.dt_retur_sales_b_id = b.hd_sales_id and a.hd_retur_sales_id = e.hd_retur_sales_id and a.dt_retur_sales_product_id = c.product_id and c.product_unit = d.unit_id and a.hd_retur_sales_id = '".$retur_sales_id."'");
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

    public function delete_retur_sales($retur_sales_id)
    {
        $this->db->set('hd_retur_sales_status', 'Cancel');
        $this->db->where('hd_retur_sales_id', $retur_sales_id);
        $this->db->update('hd_retur_sales');
    }

    
    public function retur_sales_delete($retur_sales_id)
    {
        $query = $this->db->query("select * from hd_retur_sales a, dt_retur_sales b where a.hd_retur_sales_id = b.hd_retur_sales_id and a.hd_retur_sales_id = '".$retur_sales_id."'");
        $result = $query->result();
        return $result;
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
            $this->db->group_start();
            $this->db->where('ms_product.product_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_code like "%'.$search.'%"');
            $this->db->group_end();
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
            $this->db->group_start();
            $this->db->where('ms_product.product_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_code like "%'.$search.'%"');
            $this->db->group_end();
        }
        $this->db->order_by('temp_retur_sales.created_at', 'desc');
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

    public function search_product_retur($keyword, $sales_id)
    {
        $this->db->select('*');
        $this->db->from('hd_sales');
        $this->db->join('dt_sales', 'hd_sales.hd_sales_id = dt_sales.hd_sales_id');
        $this->db->join('ms_product', 'dt_sales.dt_sales_product_id = ms_product.product_id');
        if($keyword != null){
            $this->db->where('(ms_product.product_name like "%'.$keyword.'%"');
            $this->db->or_where('ms_product.product_code like "%'.$keyword.'%")');
        }
        $this->db->where('hd_sales.hd_sales_id', $sales_id);
        $this->db->group_by('ms_product.product_id');
        $this->db->limit(50);
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

    public  function save_detail_retur_sales($data_insert_detail)
    {
        $this->db->insert('dt_retur_sales', $data_insert_detail);
    }

    public function clear_temp_retur_sales($user_id)
    {
        $this->db->where('temp_user_id', $user_id);
        $this->db->delete('temp_retur_sales');
    }

    // end retur sales

    // start pos

    public function pos_categories()
    {
        $query = $this->db->query("select a.category_id, a.category_name, count(b.product_id) as total_product from ms_category a left join ms_product b on b.product_category = a.category_id and b.is_active = 'Y' where a.is_active = 'Y' group by a.category_id order by a.category_name");
        return $query->result_array();
    }

    public function pos_products($keyword, $category_id, $sort, $price_no, $warehouse_id, $limit)
    {
        $price_col = 'a.product_sell_price_'.(in_array($price_no, array(1, 2, 3, 4, 5)) ? $price_no : 1);
        $sql = "select a.product_id, a.product_code, a.product_name, a.product_image, a.product_sell_price_1, a.product_sell_price_2, a.product_sell_price_3, a.product_sell_price_4, a.product_sell_price_5, coalesce(nullif(a.product_hpp_discount, 0), a.product_hpp) as cost, b.unit_name, c.category_name, coalesce(d.stock, 0) as stock
                from ms_product a
                join ms_unit b on a.product_unit = b.unit_id
                left join ms_category c on a.product_category = c.category_id
                left join ms_product_stock d on d.product_id = a.product_id and d.warehouse_id = ?
                where a.is_active = 'Y'";
        $params = array($warehouse_id);

        if($category_id != null){
            $sql .= " and a.product_category = ?";
            $params[] = $category_id;
        }
        if($keyword != null){
            $sql .= " and (a.product_name like ? or a.product_code like ?)";
            $params[] = '%'.$keyword.'%';
            $params[] = '%'.$keyword.'%';
        }

        $order = array(
            'name'       => 'a.product_name asc',
            'price_asc'  => $price_col.' asc',
            'price_desc' => $price_col.' desc',
            'stock'      => 'stock desc',
        );
        $sql .= " order by ".(isset($order[$sort]) ? $order[$sort] : 'a.product_id desc');
        $sql .= " limit ".(int) $limit;

        return $this->db->query($sql, $params)->result_array();
    }

    // end pos

}

?>