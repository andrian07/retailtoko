<?php

class payment_model extends CI_Model {


    // debt 

    public function debt_list($search, $length, $start)
    {
        $this->db->select('*, count(*) as total_nota, sum(hd_purchase_remaining_debt) as total_hutang');
        $this->db->from('hd_purchase');
        $this->db->join('ms_supplier', 'hd_purchase.hd_purchase_supplier = ms_supplier.supplier_id');
        $this->db->where('hd_purchase_status NOT Like "Cancel"');
        if($search != null){
            $this->db->or_where('ms_supplier.supplier_name like "%'.$search.'%"');
            $this->db->or_where('ms_supplier.supplier_code like "%'.$search.'%"');
        }
        $this->db->group_by('hd_purchase.hd_purchase_supplier');
        $this->db->order_by('ms_supplier.supplier_name', 'desc');
        $this->db->limit($length);
        $this->db->offset($start);
        $query = $this->db->get();
        return $query;
    }

    public function debt_list_count($search)
    {
        $this->db->select('count(*) as total_row');
        $this->db->from('hd_purchase');
        $this->db->join('ms_supplier', 'hd_purchase.hd_purchase_supplier = ms_supplier.supplier_id');
        $this->db->where('hd_purchase_status NOT Like "Cancel"');
        if($search != null){
            $this->db->or_where('ms_supplier.supplier_name like "%'.$search.'%"');
            $this->db->or_where('ms_supplier.supplier_code like "%'.$search.'%"');
        }
        $this->db->group_by('hd_purchase.hd_purchase_supplier');
        $this->db->order_by('ms_supplier.supplier_name', 'desc');
        $query = $this->db->get();
        return $query;
    }

    public function get_header_debt_pay($supplier_id)
    {
        $this->db->select('supplier_name, sum(hd_purchase_remaining_debt) as total_hutang');
        $this->db->from('hd_purchase');
        $this->db->join('ms_supplier', 'hd_purchase.hd_purchase_supplier = ms_supplier.supplier_id');
        $this->db->where('hd_purchase.hd_purchase_supplier', $supplier_id);
        $this->db->group_by('hd_purchase.hd_purchase_supplier');
        $query = $this->db->get();
        return $query;
    }

    public function get_footer_debt_pay($user_id)
    {
        $this->db->select('count(*) as total_nota, sum(temp_payment_debt_nominal) as total_payment_debt, sum(temp_payment_debt_retur) as total_retur_debt, sum(temp_payment_debt_discount) as total_payment_discount');
        $this->db->from('temp_payment_debt');
        $this->db->where('temp_payment_debt_user_id', $user_id);
        $this->db->where('temp_payment_debt_is_edited', 'Y');
        $query = $this->db->get();
        return $query;
    }

    public function get_purchase_debt($supplier_id)
    {
        $this->db->select('*');
        $this->db->from('hd_purchase');
        $this->db->where('hd_purchase.hd_purchase_supplier', $supplier_id);
        $this->db->where('hd_purchase.hd_purchase_remaining_debt > 0');
        $query = $this->db->get();
        return $query;
    }

    public function get_retur_purchase_total($purchase_id)
    {
        $this->db->select('sum(dt_retur_purchase_total) as total_retur');
        $this->db->from('dt_retur_purchase');
        $this->db->join('hd_retur_purchase', 'dt_retur_purchase.hd_retur_purchase_id = hd_retur_purchase.hd_retur_purchase_id');
        $this->db->where('dt_retur_purchase_b_id', $purchase_id);
        $this->db->where('dt_retur_purchase_process', 'N');
        $this->db->where('hd_retur_purchase_payment_type', 'PN');
        $query = $this->db->get();
        return $query;
    }

    public function save_temp_debt($data_insert)
    {
        $this->db->insert('temp_payment_debt', $data_insert);
    }

    public function clear_temp_debt($user_id)
    {
        $this->db->where('temp_payment_debt_user_id', $user_id);
        $this->db->delete('temp_payment_debt');
    }

    public function temp_debt_list($search, $length, $start, $user)
    {
        $this->db->select('*');
        $this->db->from('temp_payment_debt');
        $this->db->join('hd_purchase', 'temp_payment_debt.temp_payment_debt_purchase_id = hd_purchase.hd_purchase_id');
        if($search != null){
            $this->db->where('hd_purchase.hd_purchase_invoice like "%'.$search.'%"');
        }
        $this->db->where('temp_payment_debt.temp_payment_debt_user_id', $user);
        $this->db->limit($length);
        $this->db->offset($start);
        $query = $this->db->get();
        return $query;
    }

    public function temp_debt_list_count($search, $user)
    {
        $this->db->select('count(*) as total_row');
        $this->db->from('temp_payment_debt');
        $this->db->join('hd_purchase', 'temp_payment_debt.temp_payment_debt_purchase_id = hd_purchase.hd_purchase_id');
        if($search != null){
            $this->db->where('hd_purchase.hd_purchase_invoice like "%'.$search.'%"');
        }
        $this->db->where('temp_payment_debt.temp_payment_debt_user_id', $user);
        $query = $this->db->get();
        return $query;
    }


    public function get_debt_temp_by_id($id, $user)
    {
        $this->db->select('*');
        $this->db->from('temp_payment_debt');
        $this->db->join('hd_purchase', 'temp_payment_debt.temp_payment_debt_purchase_id = hd_purchase.hd_purchase_id');
        $this->db->where('temp_payment_debt_purchase_id', $id);
        $this->db->where('temp_payment_debt_user_id', $user);
        $query = $this->db->get();
        return $query;
    }

    public function edit_temp_debt($purchase_id, $user_id, $data_update)
    {
        $this->db->set($data_update);
        $this->db->where('temp_payment_debt_purchase_id ', $purchase_id);
        $this->db->where('temp_payment_debt_user_id ', $user_id);
        $this->db->update('temp_payment_debt');
    }

    public function last_debt()
    {
        $query = $this->db->query("select payment_debt_invoice from hd_payment_debt  order by payment_debt_id  desc limit 1");
        $result = $query->result();
        return $result;
    }

    public function save_debt($data_insert)
    {
        $this->db->trans_start();
        $this->db->insert('hd_payment_debt', $data_insert);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return  $insert_id;
    }

    public function save_detail_debt($data_insert_detail)
    {
        $this->db->insert('dt_payment_debt', $data_insert_detail);
    }

    public function get_temp_debt($user_id)
    {
        $query = $this->db->query("select * from temp_payment_debt where temp_payment_debt_user_id = '".$user_id."' and temp_payment_debt_is_edited = 'Y'");
        $result = $query->result();
        return $result;
    }

    public function update_retur_purchase($purchase_id)
    {
        $this->db->set('dt_retur_purchase_process', 'Y');
        $this->db->where('dt_retur_purchase_b_id ', $purchase_id);
        $this->db->update('dt_retur_purchase');
    }

    public function update_remaining_debt($purchase_id, $new_remaining_debt)
    {
        $this->db->set('hd_purchase_remaining_debt', $new_remaining_debt);
        $this->db->where('hd_purchase_id  ', $purchase_id);
        $this->db->update('hd_purchase');
    }

    public function history_debt_list($search, $length, $start)
    {
        $this->db->select('*');
        $this->db->from('hd_payment_debt');
        $this->db->join('ms_supplier', 'hd_payment_debt.payment_debt_supplier_id = ms_supplier.supplier_id');
        $this->db->join('ms_payment', 'hd_payment_debt.payment_debt_method_id = ms_payment.payment_id');
        if($search != null){
            $this->db->or_where('ms_supplier.supplier_name like "%'.$search.'%"');
            $this->db->or_where('ms_supplier.supplier_code like "%'.$search.'%"');
            $this->db->or_where('ms_supplier.payment_debt_invoice like "%'.$search.'%"');
        }
        $this->db->order_by('payment_debt_id ', 'desc');
        $this->db->limit($length);
        $this->db->offset($start);
        $query = $this->db->get();
        return $query;
    }

    public function history_debt_list_count($search)
    {
        $this->db->select('count(*) as total_row');
        $this->db->from('hd_payment_debt');
        $this->db->join('ms_supplier', 'hd_payment_debt.payment_debt_supplier_id = ms_supplier.supplier_id');
        $this->db->join('ms_payment', 'hd_payment_debt.payment_debt_method_id = ms_payment.payment_id');
        if($search != null){
            $this->db->or_where('ms_supplier.supplier_name like "%'.$search.'%"');
            $this->db->or_where('ms_supplier.supplier_code like "%'.$search.'%"');
            $this->db->or_where('ms_supplier.payment_debt_invoice like "%'.$search.'%"');
        }
        $this->db->order_by('payment_debt_id ', 'desc');
        $query = $this->db->get();
        return $query;
    }

    public function header_debt_payment($payment_debt_id)
    {
        $query = $this->db->query("select * from hd_payment_debt a, ms_supplier b, ms_payment c, ms_user d where a.payment_debt_supplier_id = b.supplier_id and  a.payment_debt_method_id = c.payment_id and a.user_id = d.user_id and payment_debt_id  = '".$payment_debt_id."'");
        $result = $query->result();
        return $result;
    }

    public function detail_debt_payment($payment_debt_id)
    {
        $query = $this->db->query("select * from dt_payment_debt a, hd_purchase b where a.dt_payment_debt_purchase_id = b.hd_purchase_id and payment_debt_id  = '".$payment_debt_id."'");
        $result = $query->result();
        return $result;
    }
    // end debt


    // receivable

    public function receivable_list($search, $length, $start)
    {
        $this->db->select('*, count(*) as total_nota, sum(hd_sales_remaining_debt) as total_hutang');
        $this->db->from('hd_sales');
        $this->db->join('ms_customer', 'hd_sales.hd_sales_customer = ms_customer.customer_id');
        $this->db->where('hd_sales_status NOT Like "Cancel"');
        if($search != null){
            $this->db->or_where('ms_customer.customer_name like "%'.$search.'%"');
            $this->db->or_where('ms_customer.customer_code like "%'.$search.'%"');
        }
        $this->db->group_by('hd_sales.hd_sales_customer');
        $this->db->order_by('ms_customer.customer_name', 'desc');
        $this->db->limit($length);
        $this->db->offset($start);
        $query = $this->db->get();
        return $query;
    }

    public function receivable_list_count($search)
    {
        $this->db->select('count(*) as total_row');
        $this->db->from('hd_sales');
        $this->db->join('ms_customer', 'hd_sales.hd_sales_customer = ms_customer.customer_id');
        $this->db->where('hd_sales_status NOT Like "Cancel"');
        if($search != null){
            $this->db->or_where('ms_customer.customer_name like "%'.$search.'%"');
            $this->db->or_where('ms_customer.customer_code like "%'.$search.'%"');
        }
        $this->db->group_by('hd_sales.hd_sales_customer');
        $this->db->order_by('ms_customer.customer_name', 'desc');
        $query = $this->db->get();
        return $query;
    }

    public function history_receivable_list($search, $length, $start)
    {
        $this->db->select('*');
        $this->db->from('hd_payment_receivable');
        $this->db->join('ms_customer', 'hd_payment_receivable.payment_receivable_customer_id = ms_customer.customer_id');
        $this->db->join('ms_payment', 'hd_payment_receivable.payment_receivable_method_id = ms_payment.payment_id');
        if($search != null){
            $this->db->or_where('ms_customer.customer_name like "%'.$search.'%"');
            $this->db->or_where('ms_customer.customer_code like "%'.$search.'%"');
            $this->db->or_where('ms_customer.payment_receivable_invoice like "%'.$search.'%"');
        }
        $this->db->order_by('payment_receivable_id', 'desc');
        $this->db->limit($length);
        $this->db->offset($start);
        $query = $this->db->get();
        return $query;
    }

    public function history_receivable_list_count($search)
    {
        $this->db->select('count(*) as total_row');
        $this->db->from('hd_payment_receivable');
        $this->db->join('ms_customer', 'hd_payment_receivable.payment_receivable_customer_id = ms_customer.customer_id');
        $this->db->join('ms_payment', 'hd_payment_receivable.payment_receivable_method_id = ms_payment.payment_id');
        if($search != null){
            $this->db->or_where('ms_customer.customer_name like "%'.$search.'%"');
            $this->db->or_where('ms_customer.customer_code like "%'.$search.'%"');
            $this->db->or_where('ms_customer.payment_receivable_invoice like "%'.$search.'%"');
        }
        $this->db->order_by('payment_receivable_id', 'desc');
        $query = $this->db->get();
        return $query;
    }

    public function get_sales_receivable($customer_id)
    {
        $this->db->select('*');
        $this->db->from('hd_sales');
        $this->db->where('hd_sales.hd_sales_customer', $customer_id);
        $this->db->where('hd_sales.hd_sales_remaining_debt > 0');
        $this->db->where('hd_sales_status', 'Success');
        $query = $this->db->get();
        return $query;
    }

    public function clear_temp_receivable($user_id)
    {
        $this->db->where('temp_payment_receivable_user_id', $user_id);
        $this->db->delete('temp_payment_receivable');
    }

    public function get_retur_sales_total($sales_id)
    {
        $this->db->select('sum(dt_retur_sales_total) as total_retur');
        $this->db->from('dt_retur_sales');
        $this->db->join('hd_retur_sales', 'dt_retur_sales.hd_retur_sales_id = hd_retur_sales.hd_retur_sales_id');
        $this->db->where('dt_retur_sales_b_id', $sales_id);
        $this->db->where('dt_retur_sales_process', 'N');
        $this->db->where('hd_retur_sales_payment_type', 'PN');
        $query = $this->db->get();
        return $query;
    }

    public function save_temp_receivable($data_insert)
    {
        $this->db->insert('temp_payment_receivable', $data_insert);
    }

    public function temp_receivable_list($search, $length, $start, $user)
    {
        $this->db->select('*');
        $this->db->from('temp_payment_receivable');
        $this->db->join('hd_sales', 'temp_payment_receivable.temp_payment_receivable_sales_id = hd_sales.hd_sales_id');
        if($search != null){
            $this->db->where('hd_sales.hd_sales_invoice like "%'.$search.'%"');
        }
        $this->db->where('temp_payment_receivable.temp_payment_receivable_user_id', $user);
        $this->db->limit($length);
        $this->db->offset($start);
        $query = $this->db->get();
        return $query;
    }

    public function temp_receivable_list_count($search, $user)
    {
        $this->db->select('count(*) as total_row');
        $this->db->from('temp_payment_receivable');
        $this->db->join('hd_sales', 'temp_payment_receivable.temp_payment_receivable_sales_id = hd_sales.hd_sales_id');
        if($search != null){
            $this->db->where('hd_sales.hd_sales_invoice like "%'.$search.'%"');
        }
        $this->db->where('temp_payment_receivable.temp_payment_receivable_user_id', $user);
        $query = $this->db->get();
        return $query;
    }

    public function get_footer_receivable_pay($user_id)
    {
        $this->db->select('count(*) as total_nota, sum(temp_payment_receivable_nominal) as total_payment_receivable, sum(temp_payment_receivable_discount) as total_payment_discount, sum(temp_payment_receivable_retur) as total_retur_receivable');
        $this->db->from('temp_payment_receivable');
        $this->db->where('temp_payment_receivable_user_id', $user_id);
        $this->db->where('temp_payment_receivable_is_edited', 'Y');
        $query = $this->db->get();
        return $query;
    }

    public function get_header_receivable_pay($customer_id)
    {
        $this->db->select('customer_name, sum(hd_sales_remaining_debt) as total_hutang');
        $this->db->from('hd_sales');
        $this->db->join('ms_customer', 'hd_sales.hd_sales_customer = ms_customer.customer_id');
        $this->db->where('hd_sales.hd_sales_customer', $customer_id);
        $this->db->group_by('hd_sales.hd_sales_customer');
        $query = $this->db->get();
        return $query;
    }

    public function get_receivable_temp_by_id($id, $user)
    {
        $this->db->select('*');
        $this->db->from('temp_payment_receivable');
        $this->db->join('hd_sales', 'temp_payment_receivable.temp_payment_receivable_sales_id = hd_sales.hd_sales_id');
        $this->db->where('temp_payment_receivable_sales_id', $id);
        $this->db->where('temp_payment_receivable_user_id', $user);
        $query = $this->db->get();
        return $query;
    }

    public function edit_temp_receivable($sales_id, $user_id, $data_update)
    {
        $this->db->set($data_update);
        $this->db->where('temp_payment_receivable_sales_id ', $sales_id);
        $this->db->where('temp_payment_receivable_user_id ', $user_id);
        $this->db->update('temp_payment_receivable');
    }

    public function save_receivable($data_insert)
    {
        $this->db->trans_start();
        $this->db->insert('hd_payment_receivable', $data_insert);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return  $insert_id;
    }

    public function get_temp_receivable($user_id)
    {
        $query = $this->db->query("select * from temp_payment_receivable where temp_payment_receivable_user_id = '".$user_id."' and temp_payment_receivable_is_edited = 'Y'");
        $result = $query->result();
        return $result;
    }

    public function save_detail_receivable($data_insert_detail)
    {
        $this->db->insert('dt_payment_receivable', $data_insert_detail);
    }

    public function update_retur_sales($sales_id)
    {
        $this->db->set('dt_retur_sales_process', 'Y');
        $this->db->where('dt_retur_sales_b_id ', $sales_id);
        $this->db->update('dt_retur_sales');
    }


    public function update_remaining_receivable($sales_id, $new_remaining_receivable)
    {
        $this->db->set('hd_sales_remaining_debt', $new_remaining_receivable);
        $this->db->where('hd_sales_id  ', $sales_id);
        $this->db->update('hd_sales');
    }

    public function last_recivable()
    {
        $query = $this->db->query("select payment_receivable_invoice from hd_payment_receivable  order by payment_receivable_id   desc limit 1");
        $result = $query->result();
        return $result;
    }

    public function header_receivable_payment($payment_receivable_id)
    {
        $query = $this->db->query("select * from hd_payment_receivable a, ms_customer b, ms_payment c, ms_user d where a.payment_receivable_customer_id = b.customer_id and  a.payment_receivable_method_id = c.payment_id and a.user_id = d.user_id and payment_receivable_id   = '".$payment_receivable_id."'");
        $result = $query->result();
        return $result;
    }

    public function detail_receivable_payment($payment_receivable_id)
    {
        $query = $this->db->query("select * from dt_payment_receivable a, hd_sales b where a.dt_payment_receivable_sales_id = b.hd_sales_id and payment_receivable_id  = '".$payment_receivable_id."'");
        $result = $query->result();
        return $result;
    }
    // end receivable

}

?>