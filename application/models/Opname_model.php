<?php

class opname_model extends CI_Model {


    public function opname_list($search, $length, $start)
    {
        $this->db->select('*');
        $this->db->from('hd_opname');
        $this->db->join('ms_user', 'hd_opname.opname_user = ms_user.user_id');
        if($search != null){
            $this->db->or_where('hd_opname.opname_code like "%'.$search.'%"');
        }
        $this->db->order_by('hd_opname.opname_id', 'desc');
        $this->db->limit($length);
        $this->db->offset($start);
        $query = $this->db->get();
        return $query;
    }

    public function opname_list_count($search)
    {
        $this->db->select('count(*) as total_row');
        $this->db->from('hd_opname');
        $this->db->join('ms_user', 'hd_opname.opname_user = ms_user.user_id');
        if($search != null){
            $this->db->or_where('hd_opname.opname_code like "%'.$search.'%"');
        }
        $this->db->order_by('hd_opname.opname_id', 'desc');
        $query = $this->db->get();
        return $query;
    }

    public function temp_opname_list($search, $length, $start, $user, $warehouse)
    {
        $this->db->select('*');
        $this->db->from('temp_opname');
        $this->db->join('ms_product', 'temp_opname.temp_opname_product_id  = ms_product.product_id');
        $this->db->join('ms_user', 'temp_opname.user_id = ms_user.user_id');
        $this->db->where('temp_opname.user_id', $user);
        if($search != null){
            $this->db->where('ms_product.user_id like "%'.$search.'%"');
        }
        $this->db->order_by('temp_opname.temp_opname_product_id ', 'desc');
        $this->db->limit($length);
        $this->db->offset($start);
        $query = $this->db->get();
        return $query;
    }

    public function temp_opname_list_count($search, $user, $warehouse)
    {
        $this->db->select('count(*) as total_row');
        $this->db->from('temp_opname');
        $this->db->join('ms_product', 'temp_opname.temp_opname_product_id  = ms_product.product_id');
        $this->db->join('ms_user', 'temp_opname.user_id = ms_user.user_id');
        $this->db->where('temp_opname.user_id', $user);
        if($search != null){
            $this->db->where('ms_product.user_id like "%'.$search.'%"');
        }
        $this->db->order_by('temp_opname.temp_opname_product_id ', 'desc');
        $query = $this->db->get();
        return $query;
    }

    public function check_temp_opname_input($product_id, $user_id)
    {
        $query = $this->db->query("select * from temp_opname where temp_opname_product_id  = '".$product_id."' and user_id = '".$user_id."'");
        $result = $query->result();
        return $result;
    }

    public function add_temp_opname($data_insert)
    {
        $this->db->insert('temp_opname', $data_insert);
    }

    public function edit_temp_opname($product_id, $user_id, $data_insert)
    {
        $this->db->set($data_insert);
        $this->db->where('temp_opname_product_id', $product_id);
        $this->db->where('user_id', $user_id);
        $this->db->update('temp_opname');
    }

    public function delete_temp_opname($product_id, $user_id)
    {
        $this->db->where('temp_opname_product_id ', $product_id);
        $this->db->where('user_id', $user_id);
        $this->db->delete('temp_opname');
    }

    public function check_temp_opname($user_id)
    {
        $query = $this->db->query("select temp_opname_warehouse_id, sum(temp_opname_diferent_hpp) as total_diff from temp_opname where user_id = '".$user_id."'");
        $result = $query->result();
        return $result;
    }

    public function check_edit_temp_opname($temp_opname_product_id, $user_id)
    {
        $this->db->select('*');
        $this->db->from('temp_opname');
        $this->db->join('ms_product', 'temp_opname.temp_opname_product_id = ms_product.product_id');
        $this->db->where('temp_opname_product_id', $temp_opname_product_id);
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        return $query;
    }

    public function last_opname()
    {
        $query = $this->db->query("select opname_code from hd_opname  order by opname_id desc limit 1");
        $result = $query->result();
        return $result;
    }

    public function save_opname($data_insert)
    {
        $this->db->trans_start();
        $this->db->insert('hd_opname', $data_insert);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return  $insert_id;
    }


    public function get_temp_opname($user_id)
    {
        $this->db->select('*');
        $this->db->from('temp_opname');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        return $query;
    }

    public function save_detail_opname($data_insert_detail)
    {
        $this->db->insert('dt_opanme', $data_insert_detail);
    }

    public function clear_temp_opname($user_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->delete('temp_opname');
    }

}

?>