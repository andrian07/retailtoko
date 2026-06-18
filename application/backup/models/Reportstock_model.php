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
}

?>