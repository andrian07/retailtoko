<?php

class masterdata_model extends CI_Model {

    // acount

    public function role_list()
    {
        $this->db->select('*');
        $this->db->from('ms_role');
        $this->db->where('is_active', 'Y');
        $query = $this->db->get();
        return $query;
    }

    public function account_list($search, $length, $start)
    {
        $this->db->select('*');
        $this->db->from('ms_user');
        $this->db->join('ms_role', 'ms_user.user_role = ms_role.role_id');
        $this->db->where('ms_user.is_active', 'Y');
        $this->db->where('ms_user.user_name not like "System"');
        if($search != null){
            $this->db->where('user_name like "%'.$search.'%"');
        }

        $this->db->limit($length);
        $this->db->offset($start);
        $query = $this->db->get();
        return $query;
    }

    public function account_list_count($search)
    {
        $this->db->select('count(*) as total_row');
        $this->db->from('ms_user');
        $this->db->join('ms_role', 'ms_user.user_role = ms_role.role_id');
        $this->db->where('ms_user.is_active', 'Y');
        $this->db->where('ms_user.user_name not like "System"');
        if($search != null){
            $this->db->where('user_name like "%'.$search.'%"');
        }
        $query = $this->db->get();
        return $query;
    }

    public function save_user($data_insert)
    {
        $this->db->insert('ms_user', $data_insert);
    }

    public function edit_user($data_insert, $user_id_inp)
    {
        $this->db->set($data_insert);
        $this->db->where('user_id', $user_id_inp);
        $this->db->update('ms_user');
    }

    public function delete_account($id)
    {
        $this->db->set('is_active', 'N');
        $this->db->where('user_id', $id);
        $this->db->update('ms_user');
    }

    // end account
    //group
    public function save_role($data_insert)
    {
        $this->db->insert('ms_role', $data_insert);
    }

    public function update_role_permision($data_edit, $role_permission)
    {
        $this->db->set($data_edit);
        $this->db->where('role_permision', $role_permission);
        $this->db->update('ms_role_permision');
    }

    public function get_setting_permission($id){
        $query = $this->db->query("select * from ms_role a, ms_role_permision b, ms_module c where a.role_id = b.role_id and b.module_id = c.module_id and a.role_id = '".$id."';");
        $result = $query->result();
        return $result;
    }

    public function save_permision($data_insert_permision)
    {
        $this->db->insert('ms_role_permision', $data_insert_permision);
    }
    
    public function group_role()
    {
        $query = $this->db->query("select * from ms_role where is_active = 'Y'");
        $result = $query->result();
        return $result;
    }

    public function update_role($data_update, $role_id)
    {
        $this->db->set($data_update);
        $this->db->where('role_id ', $role_id);
        $this->db->update('ms_role');
    }

    public function delete_role($role_id)
    {
        $this->db->set('is_active', 'N');
        $this->db->where('role_id ', $role_id);
        $this->db->update('ms_role');
    }

    public function check_role($role_name)
    {
        $query = $this->db->query("select * from ms_role where role_name = '".$role_name."' and is_active = 'Y'");
        $result = $query->result();
        return $result;
    }
    //end group
    
    //brand
    public function save_brand($data_insert)
    {
        $this->db->insert('ms_brand', $data_insert);
    }

    public function update_brand($data_update, $brand_id)
    {
        $this->db->set($data_update);
        $this->db->where('brand_id ', $brand_id);
        $this->db->update('ms_brand');
    }

    public function delete_brand($brand_id)
    {
        $this->db->set('is_active', 'N');
        $this->db->where('brand_id ', $brand_id);
        $this->db->update('ms_brand');
    }

    public function brand_list()
    {
        $query = $this->db->query("select * from ms_brand where is_active = 'Y'");
        $result = $query->result();
        return $result;
    }
    //end brand


    //customer
    public function customer_list()
    {
        $query = $this->db->query("select * from ms_customer where is_active = 'Y'");
        $result = $query->result();
        return $result;
    }

    public function get_customer_by_id($id)
    {
        $query = $this->db->query("select * from ms_customer where is_active = 'Y' and customer_id='".$id."'");
        $result = $query->result();
        return $result;
    }

    public function get_customer_code($customer_id)
    {
        $query = $this->db->query("select customer_code, customer_name from ms_customer where customer_id = '".$customer_id."'");
        $result = $query->result();
        return $result;
    }

    public function delete_customer($customer_id)
    {
        $this->db->set('is_active', 'N');
        $this->db->where('customer_id ', $customer_id);
        $this->db->update('ms_customer');
    }

    public function edit_customer($data_edit, $customer_code)
    {
        $this->db->set($data_edit);
        $this->db->where('customer_code ', $customer_code);
        $this->db->update('ms_customer');
    }

    public function delete_customer_expedisi($customer_code)
    {
        $this->db->where('customer_code ', $customer_code);
        $this->db->delete('ms_customer_expedisi');
    }

    public function save_customer($data_insert)
    {
        $this->db->insert('ms_customer', $data_insert);
    }

    public function save_customer_ekspedisi($insert_exp)
    {
        $this->db->insert('ms_customer_expedisi', $insert_exp);
    }

    public function last_customer_code($customer_code)
    {
        $query = $this->db->query("select customer_code from ms_customer where customer_code like '".$customer_code."%' order by customer_id desc limit 1");
        $result = $query->result();
        return $result;
    }

    //end customer

    // ekspedisi 
    public function ekspedisi_list()
    {
        $query = $this->db->query("select * from ms_ekspedisi where is_active = 'Y'");
        $result = $query->result();
        return $result;
    }

    public function save_ekspedisi($data_insert)
    {
        $this->db->insert('ms_ekspedisi', $data_insert);
    }

    public function edit_ekspedisi($data_edit, $expedisi_id)
    {
        $this->db->set($data_edit);
        $this->db->where('ekspedisi_id', $expedisi_id);
        $this->db->update('ms_ekspedisi');
    }

    public function delete_ekspedisi($expedisi_id)
    {
        $this->db->set('is_active', 'N');
        $this->db->where('ekspedisi_id ', $expedisi_id);
        $this->db->update('ms_ekspedisi');
    }
    //end ekspedisi


    //warehouse

    public function save_warehouse($data_insert)
    {
        $this->db->insert('ms_warehouse', $data_insert);
    }

    public function warehouse_list()
    {
        $query = $this->db->query("select * from ms_warehouse where is_active = 'Y'");
        $result = $query->result();
        return $result;
    }

    public function edit_warehouse($data_edit, $warehouse_id)
    {
        $this->db->set($data_edit);
        $this->db->where('warehouse_id', $warehouse_id);
        $this->db->update('ms_warehouse');
    }

    public function delete_warehouse($warehouse_id)
    {
        $this->db->set('is_active', 'N');
        $this->db->where('warehouse_id ', $warehouse_id);
        $this->db->update('ms_warehouse');
    }

    public function get_warehouse_code($warehouse_id)
    {
        $query = $this->db->query("select warehouse_code, warehouse_name from ms_warehouse where warehouse_id = '".$warehouse_id."'");
        $result = $query->result();
        return $result;
    }
    //end warehouse



    //category

    public function save_category($data_insert)
    {
        $this->db->insert('ms_category', $data_insert);
    }

    public function category_list()
    {
        $query = $this->db->query("select * from ms_category where is_active = 'Y'");
        $result = $query->result();
        return $result;
    }

    public function edit_category($data_edit, $category_id)
    {
        $this->db->set($data_edit);
        $this->db->where('category_id', $category_id);
        $this->db->update('ms_category');
    }

    public function delete_category($category_id)
    {
        $this->db->set('is_active', 'N');
        $this->db->where('category_id ', $category_id);
        $this->db->update('ms_category');
    }
    //end warehouse

    //salesman
    public function save_salesman($data_insert)
    {
        $this->db->insert('ms_salesman', $data_insert);
    }

    public function salesman_list()
    {
        $query = $this->db->query("select * from ms_salesman a, ms_warehouse b where a.salesman_branch = b.warehouse_id and a.is_active = 'Y'");
        $result = $query->result();
        return $result;
    }

    public function edit_salesman($data_edit, $salesman_id)
    {
        $this->db->set($data_edit);
        $this->db->where('salesman_id', $salesman_id);
        $this->db->update('ms_salesman');
    }

    public function delete_salesman($salesman_id)
    {
        $this->db->set('is_active', 'N');
        $this->db->where('salesman_id ', $salesman_id);
        $this->db->update('ms_salesman');
    }

    public function salesman_detail($id)
    {
        $query = $this->db->query("select * from ms_salesman a, ms_warehouse b where a.salesman_branch = b.warehouse_id and a.is_active = 'Y' and salesman_id = '".$id."'");
        $result = $query->result();
        return $result;
    }
    //end warehouse


    //unit
    public function save_unit($data_insert)
    {
        $this->db->insert('ms_unit', $data_insert);
    }

    public function unit_list()
    {
        $query = $this->db->query("select * from ms_unit where is_active = 'Y'");
        $result = $query->result();
        return $result;
    }

    public function edit_unit($data_edit, $unit_id)
    {
        $this->db->set($data_edit);
        $this->db->where('unit_id', $unit_id);
        $this->db->update('ms_unit');
    }

    public function delete_unit($unit_id)
    {
        $this->db->set('is_active', 'N');
        $this->db->where('unit_id ', $unit_id);
        $this->db->update('ms_unit');
    }
    //end unit

    //supplier
    public function save_supplier($data_insert)
    {
        $this->db->insert('ms_supplier', $data_insert);
    }

    public function get_last_supplier()
    {
        $query = $this->db->query("select supplier_code from ms_supplier order by supplier_id  desc limit 1");
        $result = $query->result();
        return $result;
    }

    public function supplier_list()
    {
        $query = $this->db->query("select * from ms_supplier where is_active = 'Y'");
        $result = $query->result();
        return $result;
    }

    public function edit_supplier($data_edit, $supplier_id)
    {
        $this->db->set($data_edit);
        $this->db->where('supplier_id', $supplier_id);
        $this->db->update('ms_supplier');
    }

    public function delete_supplier($supplier_id)
    {
        $this->db->set('is_active', 'N');
        $this->db->where('supplier_id ', $supplier_id);
        $this->db->update('ms_supplier');
    }

    public function get_supplier_code($supplier_id)
    {
        $query = $this->db->query("select supplier_code, supplier_name from ms_supplier where supplier_id = '".$supplier_id."'");
        $result = $query->result();
        return $result;
    }

    public function get_master_product_supplier($dt_product_id)
    {
        $query = $this->db->query("select product_supplier_id_tag, product_supplier_tag from ms_product where product_id = '".$dt_product_id."'");
        $result = $query->result();
        return $result;
    }
    //end supplier


    //product

    public function save_product($data_insert)
    {
        $this->db->trans_start();
        $this->db->insert('ms_product', $data_insert);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return  $insert_id;
    }

    public function save_product_stock($data_insert_master_stock)
    {
        $this->db->insert('ms_product_stock', $data_insert_master_stock);
    }

    public function save_product_supplier($insert_supplier)
    {
        $this->db->insert('ms_product_supplier', $insert_supplier);
    }

    public function product_list($search, $length, $start, $supplier_filter, $category_filter, $brand_filter,$product_status_filter, $in_transit_filter)
    {
        $this->db->select('*');
        $this->db->from('ms_product');
        $this->db->join('ms_brand', 'ms_product.product_brand = ms_brand.brand_id');
        $this->db->join('ms_unit', 'ms_product.product_unit = ms_unit.unit_id');
        $this->db->join('ms_category', 'ms_product.product_category = ms_category.category_id');
        $this->db->where('ms_product.is_active', 'y');
        if($search != null){
            $this->db->where('ms_product.product_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_code like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_supplier_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_key like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_desc like "%'.$search.'%"');
        }
        if($supplier_filter != null){
            $this->db->where('ms_product.product_supplier_tag like "%'.$supplier_filter.'%"');
        }
        if($category_filter != null){
            $this->db->where('ms_product.product_category like "%'.$category_filter.'%"');
        }
        if($brand_filter != null){
            $this->db->where('ms_product.product_brand like "%'.$brand_filter.'%"');
        }
        if($product_status_filter != null){
            $this->db->where('ms_product.product_status', $product_status_filter);
        }
        if($in_transit_filter != null){
            if($in_transit_filter == 1){
                $this->db->where('ms_product.product_po_status = 0');
            }else{
                $this->db->where('ms_product.product_po_status > 0');
            }
        }
        $this->db->limit($length);
        $this->db->offset($start);
        $query = $this->db->get();
        return $query;
    }

    public function product_list_count($search, $supplier_filter, $category_filter, $brand_filter, $product_status_filter, $in_transit_filter)
    {
        $this->db->select('count(*) as total_row');
         $this->db->from('ms_product');
        $this->db->join('ms_brand', 'ms_product.product_brand = ms_brand.brand_id');
        $this->db->join('ms_unit', 'ms_product.product_unit = ms_unit.unit_id');
        $this->db->join('ms_category', 'ms_product.product_category = ms_category.category_id');
        $this->db->where('ms_product.is_active', 'y');
        if($search != null){
            $this->db->where('ms_product.product_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_code like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_supplier_name like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_key like "%'.$search.'%"');
            $this->db->or_where('ms_product.product_desc like "%'.$search.'%"');
        }
        if($supplier_filter != null){
            $this->db->where('ms_product.product_supplier_tag like "%'.$supplier_filter.'%"');
        }
        if($category_filter != null){
            $this->db->where('ms_product.product_category like "%'.$category_filter.'%"');
        }
        if($brand_filter != null){
            $this->db->where('ms_product.product_brand like "%'.$brand_filter.'%"');
        }
        if($product_status_filter != null){
            $this->db->where('ms_product.product_status', $product_status_filter);
        }
        if($in_transit_filter != null){
            if($in_transit_filter == 1){
                $this->db->where('ms_product.product_po_status = 0');
            }else{
                $this->db->where('ms_product.product_po_status > 0');
            }
        }
        $query = $this->db->get();
        return $query;
    }

    public function count_product()
    {
        $this->db->from('ms_product');
        $this->db->join('ms_brand', 'ms_product.product_brand = ms_brand.brand_id');
        $this->db->join('ms_category', 'ms_product.product_category = ms_category.category_id');
        $this->db->where('ms_product.is_active', 'y');
        return $this->db->count_all_results();
    }

    function count_product_filtered()
    {
        $this->db->select('*');
        $this->db->from('ms_product');
        $this->db->join('ms_brand', 'ms_product.product_brand = ms_brand.brand_id');
        $this->db->join('ms_category', 'ms_product.product_category = ms_category.category_id');
        $this->db->where('ms_product.is_active', 'y');
        $query = $this->db->get();
        return $query->num_rows();
    }


    public function last_product_code()
    {
        $query = $this->db->query("select product_code from ms_product order by product_id desc limit 1");
        $result = $query->result();
        return $result;
    }

    public function product_stock($id)
    {
        $query = $this->db->query("select * from ms_product_stock a, ms_warehouse b, ms_product c, ms_unit d where a.warehouse_id = b.warehouse_id and a.product_id = c.product_id and c.product_unit = d.unit_id and a.product_id = '".$id."'");
        $result = $query->result();
        return $result;
    }

    public function settingproduct($id)
    {
        $query = $this->db->query("select * from ms_product a, ms_brand b, ms_unit c, ms_category d where a.product_brand = b.brand_id and a.product_unit = c.unit_id and a.product_category = d.category_id and a.product_id  = '".$id."' and a.is_active = 'Y'");
        $result = $query->result();
        return $result;
    }

    public function get_product_by_id($product_id)
    {
        $query = $this->db->query("select * from ms_product where product_id  = '".$product_id."' and is_active = 'Y'");

        $result = $query->result();
        return $result;
    }

    public function edit_product($data_edit, $product_id)
    {
        $this->db->set($data_edit);
        $this->db->where('product_id', $product_id);
        $this->db->update('ms_product');
    }

    public function delete_product_supplier($product_id)
    {
        $this->db->where('product_id ', $product_id);
        $this->db->delete('ms_product_supplier');
    }

    public function delete_product($id)
    {
        $this->db->set('is_active', 'N');
        $this->db->where('product_id ', $id);
        $this->db->update('ms_product');
    }


    public function delete_filter_product($user_id)
    {
        $this->db->where('user_id ', $user_id);
        $this->db->delete('product_filter');

    }

    public function insert_filter_product($data_insert)
    {
        $this->db->insert('product_filter', $data_insert);
    }

    public function get_filter_value($user_id)
    {
        $query = $this->db->query("select * from product_filter where user_id  = '".$user_id."'");
        $result = $query->result();
        return $result;
    }
    // end product

    // search product //

    public function search_product_list($searchin_key, $unit, $category, $brand, $supplier, $status, $paket, $ppn)
    {
        $this->db->select('*, sum(stock) as total_stock');
        $this->db->from('ms_product');
        $this->db->join('ms_brand', 'ms_product.product_brand = ms_brand.brand_id');
        $this->db->join('ms_unit', 'ms_product.product_unit = ms_unit.unit_id');
        $this->db->join('ms_product_stock', 'ms_product.product_id = ms_product_stock.product_id', 'left');
        $this->db->join('ms_category', 'ms_product.product_category = ms_category.category_id');
        $this->db->where('ms_product.is_active', 'y');
        if($unit != null) {
            $this->db->where('ms_product.product_unit', $unit);
        }
        if($category != null) {
            $this->db->where('ms_product.product_category', $category);
        }
        if($brand != null) {
            $this->db->where('ms_product.product_brand', $brand);
        }
        if($supplier != null) {
            $this->db->where('ms_product.product_supplier_tag like "%'.$supplier.'%"');
        }
        if($status != null) {
            $this->db->where('ms_product.product_status', $status);
        }
        if($paket != null) {
            $this->db->where('ms_product.product_paket', $paket);
        }
        if($ppn != null) {
            $this->db->where('ms_product.product_ppn', $ppn);
        }   
        if($searchin_key != null){
            $this->db->where('ms_product.product_name like "%'.$searchin_key.'%"');
            $this->db->or_where('ms_product.product_code like "%'.$searchin_key.'%"');
            $this->db->or_where('ms_product.product_supplier_name like "%'.$searchin_key.'%"');
            $this->db->or_where('ms_product.product_key like "%'.$searchin_key.'%"');
            $this->db->or_where('ms_product.product_desc like "%'.$searchin_key.'%"');
        }
        $this->db->limit(50);
        $this->db->group_by('ms_product.product_id');
        $query = $this->db->get();
        return $query;
    }
    // end search product //


    // payment type


    public function payment_list()
    {
        $query = $this->db->query("select * from ms_payment where is_active = 'Y'");
        $result = $query->result();
        return $result;
    }

    public function save_payment($insert)
    {
        $this->db->insert('ms_payment', $insert);
    }

    public function update_payment($update, $payment_id)
    {
        $this->db->set($update);
        $this->db->where('payment_id ', $payment_id);
        $this->db->update('ms_payment');
    }
    // end payment type

    //user 

    public function user_list()
    {
        $query = $this->db->query("select * from ms_user where is_active = 'Y'");
        $result = $query->result();
        return $result;
    }

    // end user
}

?>