<?php

class auth_model extends CI_Model {


    //login
    public function get_login_data($username, $password)
    {
        $query = $this->db->query("select * from ms_user a, ms_role b, ms_warehouse c where a.user_role = b.role_id and b.is_active = 'Y' and a.user_branch = c.warehouse_id and user_name = ? and user_password = ? and a.is_active = 'Y'", array($username, $password));
        $result = $query->result();
        return $result;
    }
    //end login

}

?>