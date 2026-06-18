<?php

class Reportmaster_model extends CI_Model {

    public function brand_list()
    {
        $this->db->select('*');
        $this->db->from('ms_brand');
        $this->db->where('is_active', 'Y');
        $query = $this->db->get();
        return $query;
    }

    public function customer_list()
    {
        $this->db->select('*');
        $this->db->from('ms_customer');
        $this->db->where('is_active', 'Y');
        $query = $this->db->get();
        return $query;
    }

    public function ekspedisi_list()
    {
        $this->db->select('*');
        $this->db->from('ms_ekspedisi');
        $this->db->where('is_active', 'Y');
        $query = $this->db->get();
        return $query;
    }

    public function warehouse_list()
    {
        $this->db->select('*');
        $this->db->from('ms_warehouse');
        $this->db->where('is_active', 'Y');
        $query = $this->db->get();
        return $query;
    }

    public function category_list()
    {
        $this->db->select('*');
        $this->db->from('ms_category');
        $this->db->where('is_active', 'Y');
        $query = $this->db->get();
        return $query;
    }

    public function get_report_product($brand_report, $category_report, $Supplier_report)
    {
        $this->db->select('*');
        $this->db->from('ms_product');
        $this->db->join('ms_brand', 'ms_product.product_brand = ms_brand.brand_id');
        $this->db->join('ms_unit', 'ms_product.product_unit = ms_unit.unit_id');
        $this->db->join('ms_product_stock', 'ms_product.product_id = ms_product_stock.product_id', 'left');
        $this->db->join('ms_category', 'ms_product.product_category = ms_category.category_id');
        if($brand_report != null){
            $this->db->where('ms_product.product_brand = "'.$brand_report.'"');
        }
        if($category_report != null){
            $this->db->where('ms_product.product_category = "'.$category_report.'"');
        }
        if($Supplier_report != null){
            $this->db->where('ms_product.product_supplier_tag like "%'.$Supplier_report.'%"');
        }
        $query = $this->db->get();
        return $query;
    }

    public function salesman_list()
    {
        $this->db->select('*');
        $this->db->from('ms_salesman');
        $this->db->join('ms_warehouse', 'ms_salesman.salesman_branch = ms_warehouse.warehouse_id');
        $query = $this->db->get();
        return $query;
    }

    public function supplier_list()
    {
        $this->db->select('*');
        $this->db->from('ms_supplier');
        $query = $this->db->get();
        return $query;
    }

}

?>