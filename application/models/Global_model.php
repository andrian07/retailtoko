<?php

class global_model extends CI_Model {

    public function save($data_insert_act)
    {
        $this->db->insert('activity_table', $data_insert_act);
    }

    public function check_auth_nav($user_role_id)
    {
        $query = $this->db->query("select * from ms_role a, ms_role_permision b, ms_module c where a.role_id = b.role_id and b.module_id = c.module_id and a.role_id = '".$user_role_id."' order by c.module_id");
        $result = $query->result();
        return $result;
    }

    public function check_access_dashboard($user_role_id)
    {
        $query = $this->db->query("select * from ms_role a, ms_role_permision b, ms_module c where a.role_id = b.role_id and b.module_id = c.module_id and a.role_id = '".$user_role_id."'");
        $result = $query->result();
        return $result;
    }

    public function check_access($user_role_id, $modul){
        $query = $this->db->query("select * from ms_role a, ms_role_permision b, ms_module c where a.role_id = b.role_id and b.module_id = c.module_id and a.role_id = '".$user_role_id."' and module_name = '".$modul."';");
        $result = $query->result();
        return $result;
    }


    public function search_product_purchase($keyword, $supplier_id)
    {
        $this->db->select('*');
        $this->db->from('ms_product');
        $this->db->join('ms_product_supplier', 'ms_product.product_id = ms_product_supplier.product_id');
        $this->db->join('ms_unit', 'ms_product.product_unit = ms_unit.unit_id');
        $this->db->where('ms_product_supplier.supplier_id', $supplier_id);
        if($keyword != null){
            $this->db->where('(ms_product.product_name like "%'.$keyword.'%" OR ms_product.product_code like "%'.$keyword.'%") ');
        }
        $this->db->limit(50);
        $query = $this->db->get();
        return $query;
    }

    public function search_product_sales($keyword)
    {
        $this->db->select('*');
        $this->db->from('ms_product');
        $this->db->join('ms_unit', 'ms_product.product_unit = ms_unit.unit_id');
        if($keyword != null){
            $this->db->where('(ms_product.product_name like "%'.$keyword.'%" OR ms_product.product_code like "%'.$keyword.'%") ');
        }
        $this->db->limit(50);
        $query = $this->db->get();
        return $query;
    }

    public function total_stock_search($product_id)
    {
        $this->db->select('sum(stock) as curent_stock');
        $this->db->from('ms_product_stock');
        $this->db->where('product_id', $product_id);
        $query = $this->db->get();
        return $query;
    }

    public function insert_movement_stock($movement_stock)
    {
        $this->db->insert('stock_movement', $movement_stock);
    }

    public function insert_product_stock($insert_product_stock)
    {
        $this->db->insert('ms_product_stock', $insert_product_stock);
    }

    public function insert_master_stock($insert_master_stock)
    {
        $this->db->insert('ms_product_stock', $insert_master_stock);
    }

    public function get_transaction_today()
    {
        $this->db->select('sum(hd_sales_total) as total_today, count(*) as total_transaction');
        $this->db->from('hd_sales');
        $this->db->where('hd_sales_date = CURDATE()', NULL, FALSE);
        $query = $this->db->get();
        return $query;
    }

    public function get_transaction_today_item()
    {
        $this->db->select('count(*) as total_item');
        $this->db->from('dt_sales');
        $this->db->join('hd_sales', 'dt_sales.hd_sales_id = hd_sales.hd_sales_id');
        $this->db->where('hd_sales_date = CURDATE()', NULL, FALSE);
        $query = $this->db->get();
        return $query;
    }

    public function get_transaction_month()
    {
        $start = date('Y-m-01');
        $end   = date('Y-m-t');

        $this->db->select('sum(hd_sales_total) as total_month, count(*) as total_transaction');
        $this->db->from('hd_sales');
        $this->db->where('hd_sales_date >=', $start);
        $this->db->where('hd_sales_date <=', $end);
        $query = $this->db->get();
        return $query;
    }

    public function get_transaction_month_item()
    {

        $start = date('Y-m-01');
        $end   = date('Y-m-t');
        $this->db->select('count(*) as total_item');
        $this->db->from('dt_sales');
        $this->db->join('hd_sales', 'dt_sales.hd_sales_id = hd_sales.hd_sales_id');
        $this->db->where('hd_sales_date >=', $start);
        $this->db->where('hd_sales_date <=', $end);
        $query = $this->db->get();
        return $query;
    }
    public function get_total_asset()
    {
        $this->db->select('sum(stock * product_hpp) as total_omzet');
        $this->db->from('ms_product');
        $this->db->join('ms_product_stock', 'ms_product.product_id = ms_product_stock.product_id');
        $this->db->where('is_active', 'Y');
        $query = $this->db->get();
        return $query;
    }

    public function get_total_asset_item()
    {
        $this->db->select('count(*) as total_item');
        $this->db->from('ms_product');
        $this->db->where('is_active', 'Y');
        $query = $this->db->get();
        return $query;
    }

    public function get_last_activity()
    {
        $this->db->select('*');
        $this->db->from('activity_table');
        $this->db->limit('10');
        $this->db->order_by('activity_table_id', 'desc');
        $query = $this->db->get();
        return $query;
    }
    public function get_last_stock($product_id, $warehouse_id)
    {
        $query = $this->db->query("select stock from ms_product a, ms_product_stock b where a.product_id = b.product_id and b.warehouse_id = '".$warehouse_id."' and b.product_id = '".$product_id."'");
        $result = $query->result();
        return $result;
    }
    public function update_stock($product_id, $purchase_warehouse, $new_stock)
    {
        $this->db->set('stock', $new_stock);
        $this->db->where('product_id ', $product_id);
        $this->db->where('warehouse_id ', $purchase_warehouse);
        $this->db->update('ms_product_stock');
    }

    public function save_stock_movement($data_movement_stock)
    {
        $this->db->insert('stock_movement', $data_movement_stock);
    }

    public function get_next_activity()
    {
       // Query purchase
        $this->db->select("hd_purchase_invoice as inv, hd_purchase_due_date AS due_date, 'purchase' AS keterangan");
        $this->db->from('hd_purchase');
        $this->db->where('hd_purchase_due_date > CURDATE()', null, false);
        $purchase_query = $this->db->get_compiled_select();

        // reset query builder
        $this->db->reset_query();

        // Query sales
        $this->db->select("hd_sales_inv as inv, hd_sales_due_date AS due_date, 'sales' AS keterangan");
        $this->db->from('hd_sales');
        $this->db->where('hd_sales_due_date > CURDATE()', null, false);
        $sales_query = $this->db->get_compiled_select();

        // gabungkan UNION
        $sql = "($purchase_query) UNION ALL ($sales_query) ORDER BY due_date ASC LIMIT 15";
        // execute
        $query = $this->db->query($sql);
        return $query;
    }

    public function lost_faktur()
    {
        $this->db->select('*');
        $this->db->from('hd_sales');
        $this->db->where('hd_sales_due_date < CURDATE()', null, false);
        $this->db->where('hd_sales_remaining_debt > 0');
        $this->db->limit('10');
        $this->db->order_by('created_at', 'desc');
        $query = $this->db->get();
        return $query;
    }

    public function top_product_3_month()
    {
        $this->db->select('pd.product_code, pd.product_name, ds.dt_sales_product_id,sum(ds.dt_sales_qty) AS total_transaction');
        $this->db->from('hd_sales hs');
        $this->db->join('dt_sales ds', 'hs.hd_sales_id = ds.hd_sales_id');
        $this->db->join('ms_product pd', 'ds.dt_sales_product_id = pd.product_id');
        $this->db->where('hs.hd_sales_date >= DATE_SUB(CURDATE(), INTERVAL 3 MONTH)', null, false);
        $this->db->group_by('ds.dt_sales_product_id');
        $this->db->order_by('total_transaction', 'DESC');
        $this->db->limit(10);
        $query = $this->db->get();
        return $query;
    }

    public function get_note()
    {
        $this->db->select('*');
        $this->db->from('ms_note hs');
        $query = $this->db->get();
        return $query;
    }

    public function save_comment($insert)
    {
        $this->db->set($insert);
        $this->db->where('ms_note_id ', '1');
        $this->db->update('ms_note');
    }

    // start dashboard

    public function dash_sales_summary($start, $end)
    {
        $query = $this->db->query("select coalesce(sum(hd_sales_total), 0) as total, count(*) as trx from hd_sales where hd_sales_status = 'Success' and hd_sales_date between ? and ?", array($start, $end));
        return $query->row_array();
    }

    public function dash_sales_item($start, $end)
    {
        $query = $this->db->query("select coalesce(sum(b.dt_sales_qty), 0) as qty from hd_sales a join dt_sales b on a.hd_sales_id = b.hd_sales_id where a.hd_sales_status = 'Success' and a.hd_sales_date between ? and ?", array($start, $end));
        return $query->row_array();
    }

    public function dash_sales_daily($start, $end)
    {
        $query = $this->db->query("select hd_sales_date as tgl, sum(hd_sales_total) as total, count(*) as trx from hd_sales where hd_sales_status = 'Success' and hd_sales_date between ? and ? group by hd_sales_date", array($start, $end));
        return $query->result_array();
    }

    public function dash_stock_asset()
    {
        $query = $this->db->query("select coalesce(sum(b.stock * a.product_hpp), 0) as asset, coalesce(sum(b.stock), 0) as qty from ms_product a join ms_product_stock b on a.product_id = b.product_id where a.is_active = 'Y'");
        return $query->row_array();
    }

    public function dash_last_activity($limit)
    {
        $query = $this->db->query("select * from activity_table order by activity_table_id desc limit ".(int) $limit);
        return $query->result_array();
    }

    // cari nominal transaksi berdasarkan nomor invoice di deskripsi aktifitas
    public function dash_invoice_amount($inv)
    {
        $query = $this->db->query("
            select hd_sales_total as amount from hd_sales where hd_sales_inv = ?
            union all select hd_purchase_grand_total from hd_purchase where hd_purchase_invoice = ?
            union all select payment_receivable_total_pay from hd_payment_receivable where payment_receivable_invoice = ?
            union all select payment_debt_total_pay from hd_payment_debt where payment_debt_invoice = ?
            union all select hd_retur_sales_total from hd_retur_sales where hd_retur_sales_inv = ?
            union all select hd_retur_purchase_total from hd_retur_purchase where hd_retur_purchase_inv = ?
            union all select hd_po_grand_total from hd_po where hd_po_invoice = ?
            limit 1", array($inv, $inv, $inv, $inv, $inv, $inv, $inv));
        $row = $query->row_array();
        return $row ? $row['amount'] : null;
    }

    public function dash_top_product($limit)
    {
        $query = $this->db->query("select c.product_id, c.product_code, c.product_name, c.product_image, d.category_name, sum(b.dt_sales_qty) as qty from hd_sales a join dt_sales b on a.hd_sales_id = b.hd_sales_id join ms_product c on b.dt_sales_product_id = c.product_id left join ms_category d on c.product_category = d.category_id where a.hd_sales_status = 'Success' and a.hd_sales_date >= date_sub(curdate(), interval 3 month) group by c.product_id order by qty desc limit ".(int) $limit);
        return $query->result_array();
    }

    public function dash_overdue_invoice($limit)
    {
        $query = $this->db->query("select hd_sales_id, hd_sales_inv, hd_sales_date, hd_sales_due_date, hd_sales_remaining_debt, datediff(curdate(), hd_sales_due_date) as late_days from hd_sales where hd_sales_status = 'Success' and hd_sales_remaining_debt > 0 and hd_sales_due_date < curdate() order by hd_sales_due_date asc limit ".(int) $limit);
        return $query->result_array();
    }

    public function dash_overdue_count()
    {
        $query = $this->db->query("select count(*) as total from hd_sales where hd_sales_status = 'Success' and hd_sales_remaining_debt > 0 and hd_sales_due_date < curdate()");
        return $query->row_array()['total'];
    }

    public function dash_low_stock($limit)
    {
        $query = $this->db->query("select a.product_id, a.product_code, a.product_name, a.product_image, a.product_min_stock, coalesce(sum(b.stock), 0) as stock from ms_product a left join ms_product_stock b on a.product_id = b.product_id where a.is_active = 'Y' and a.product_min_stock > 0 group by a.product_id having stock <= a.product_min_stock order by stock / a.product_min_stock asc limit ".(int) $limit);
        return $query->result_array();
    }

    public function dash_low_stock_count()
    {
        $query = $this->db->query("select count(*) as total from (select a.product_id from ms_product a left join ms_product_stock b on a.product_id = b.product_id where a.is_active = 'Y' and a.product_min_stock > 0 group by a.product_id having coalesce(sum(b.stock), 0) <= a.product_min_stock) t");
        return $query->row_array()['total'];
    }

    // end dashboard

    public function search_purchase_inv($keyword, $supplier_id)
    {
        $this->db->select('*');
        $this->db->from('hd_purchase');
        $this->db->where('hd_purchase_invoice like "%'.$keyword.'%"');
        $this->db->where('hd_purchase_supplier', $supplier_id);
        $this->db->where('hd_purchase_status', 'Success');
        $this->db->limit(50);
        $query = $this->db->get();
        return $query;
    }

    public function search_sales_inv($keyword)
    {
        $this->db->select('*');
        $this->db->from('hd_sales');
        $this->db->where('hd_sales_inv like "%'.$keyword.'%"');
        $this->db->where('hd_sales_status', 'Success');
        $this->db->limit(50);
        $query = $this->db->get();
        return $query;
    }

    public function search_product_opname($keyword)
    {
        $this->db->select('*');
        $this->db->from('ms_product');
        $this->db->join('ms_unit', 'ms_product.product_unit = ms_unit.unit_id');
        $this->db->join('ms_product_stock', 'ms_product.product_id = ms_product_stock.product_id');

        if($keyword != null){
            $this->db->where('(ms_product.product_name like "%'.$keyword.'%" OR ms_product.product_code like "%'.$keyword.'%") ');
        }
        $this->db->limit(50);
        $query = $this->db->get();
        return $query;
    }

    public function search_product_all($keyword)
    {
        $this->db->select('*');
        $this->db->from('ms_product');
        $this->db->join('ms_unit', 'ms_product.product_unit = ms_unit.unit_id');
        if($keyword != null){
            $this->db->where('(ms_product.product_name like "%'.$keyword.'%" OR ms_product.product_code like "%'.$keyword.'%") ');
        }
        $this->db->limit(50);
        $query = $this->db->get();
        return $query;
    }

}
