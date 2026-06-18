<?php

class auth_model extends CI_Model {


    //login
    public function get_login_data($username, $password)
    {
        $query = $this->db->query("select * from ms_user a, ms_role b, ms_warehouse c where a.user_role and b.role_id and a.user_branch = c.warehouse_id and user_name = '".$username."' and user_password = '".$password."' and a.is_active = 'Y'");
        $result = $query->result();
        return $result;
    }
    //end login

}

?>