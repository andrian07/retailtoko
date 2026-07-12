<?php

class reportstock_model extends CI_Model {

    public function get_report_stock($warehouse_report, $brand_report, $category_report)
    {
        $this->db->select('*');
        $this->db->from('ms_product');
        $this->db->join('ms_product_stock', 'ms_product.product_id = ms_product_stock.product_id');
        $this->db->join('ms_warehouse', 'ms_product_stock.warehouse_id = ms_warehouse.warehouse_id');
        if($warehouse_report != null){
            $this->db->where('ms_product_stock.warehouse_id', $warehouse_report);
        }
        if($brand_report != null){
            $this->db->where('product_brand', $brand_report);
        }
        if($category_report != null){
            $this->db->where('product_category', $category_report);
        }
        $query = $this->db->get();
        return $query;
    }

    public function get_movement_stock($product_id)
    {
        $this->db->select('*');
        $this->db->from('stock_movement');
        $this->db->join('ms_product', 'stock_movement.stock_movement_product_id = ms_product.product_id');
        $this->db->join('ms_unit', 'ms_product.product_unit = ms_unit.unit_id');
        $this->db->where('stock_movement_product_id', $product_id);
        $query = $this->db->get();
        return $query;
    }

    /* =====================================================================
     *  PROFIT & LOSS
     * ===================================================================== */

    public function get_total_sales($start_date, $end_date)
    {
        $sql = "SELECT IFNULL(SUM(hd_sales_total), 0) AS total
                FROM hd_sales
                WHERE hd_sales_status = 'Success'
                  AND hd_sales_date BETWEEN ? AND ?";
        return $this->db->query($sql, [$start_date, $end_date])->row()->total;
    }

    public function get_total_retur_sales($start_date, $end_date)
    {
        $sql = "SELECT IFNULL(SUM(hd_retur_sales_total), 0) AS total
                FROM hd_retur_sales
                WHERE hd_retur_sales_status = 'Success'
                  AND hd_retur_sales_date BETWEEN ? AND ?";
        return $this->db->query($sql, [$start_date, $end_date])->row()->total;
    }

    public function get_total_hpp($start_date, $end_date)
    {
        $sql = "SELECT IFNULL(SUM(ds.dt_sales_qty * p.product_hpp), 0) AS total
                FROM dt_sales ds
                JOIN hd_sales hs ON ds.hd_sales_id = hs.hd_sales_id
                JOIN ms_product p  ON ds.dt_sales_product_id = p.product_id
                WHERE hs.hd_sales_status = 'Success'
                  AND hs.hd_sales_date BETWEEN ? AND ?";
        return $this->db->query($sql, [$start_date, $end_date])->row()->total;
    }

    public function get_total_hpp_retur($start_date, $end_date)
    {
        $sql = "SELECT IFNULL(SUM(drs.dt_retur_sales_qty * p.product_hpp), 0) AS total
                FROM dt_retur_sales drs
                JOIN hd_retur_sales hrs ON drs.hd_retur_sales_id = hrs.hd_retur_sales_id
                JOIN ms_product p        ON drs.dt_retur_sales_product_id = p.product_id
                WHERE hrs.hd_retur_sales_status = 'Success'
                  AND hrs.hd_retur_sales_date BETWEEN ? AND ?";
        return $this->db->query($sql, [$start_date, $end_date])->row()->total;
    }

    public function get_pl_detail_by_product($start_date, $end_date)
    {
        $sql = "SELECT
                    p.product_code,
                    p.product_name,
                    p.product_hpp,
                    IFNULL(SUM(ds.dt_sales_qty), 0)                       AS qty_jual,
                    IFNULL(SUM(ds.dt_sales_total), 0)                     AS total_jual,
                    IFNULL(SUM(ds.dt_sales_qty * p.product_hpp), 0)       AS total_hpp,
                    IFNULL(SUM(ds.dt_sales_total), 0)
                      - IFNULL(SUM(ds.dt_sales_qty * p.product_hpp), 0)   AS laba
                FROM dt_sales ds
                JOIN hd_sales  hs ON ds.hd_sales_id         = hs.hd_sales_id
                JOIN ms_product p  ON ds.dt_sales_product_id = p.product_id
                WHERE hs.hd_sales_status = 'Success'
                  AND hs.hd_sales_date BETWEEN ? AND ?
                GROUP BY p.product_id
                ORDER BY laba DESC";
        return $this->db->query($sql, [$start_date, $end_date])->result_array();
    }
}

?>