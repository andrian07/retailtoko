<?php

class global_model extends CI_Model {

    public function save($data_insert_act)
    {
        $this->db->insert('activity_table', $data_insert_act);
    }

    public function check_auth_nav($user_role_id)
    {
        $query = $this->db->query("select * from ms_role a, ms_role_permision b, ms_module c where a.role_id = b.role_id and b.module_id = c.module_id and a.role_id = '".$user_role_id."'");
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

    public function transfer_stock()
    {
        $this->db->select('
            hd_transfer_stock.*,
            dt_transfer_stock.*,
            wf.warehouse_name AS warehouse_from_name,
            wt.warehouse_name AS warehouse_to_name
        ');
        $this->db->from('hd_transfer_stock');
        $this->db->join(
            'dt_transfer_stock',
            'hd_transfer_stock.hd_transfer_stock_id = dt_transfer_stock.hd_transfer_stock_id'
        );
        $this->db->join(
            'ms_warehouse wf',
            'dt_transfer_stock.dt_transfer_stock_warehouse_from = wf.warehouse_id',
            'left'
        );
        $this->db->join(
            'ms_warehouse wt',
            'dt_transfer_stock.dt_transfer_stock_warehouse_to = wt.warehouse_id',
            'left'
        );
        $this->db->group_by('hd_transfer_stock.hd_transfer_stock_id');
        $this->db->order_by('hd_transfer_stock.created_at', 'desc');
        $this->db->limit(10);
        $query = $this->db->get();
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

    public function search_purchase_inv($keyword, $supplier_id)
    {
        $this->db->select('*');
        $this->db->from('hd_purchase');
        $this->db->where('hd_purchase_invoice like "%'.$keyword.'%"');
        $this->db->where('hd_purchase_supplier', $supplier_id);
        $this->db->limit(50);
        $query = $this->db->get();
        return $query;
    }

}
