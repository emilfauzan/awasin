<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Name_model extends CI_Model
{
    public function getName()
    {
        $query = "SELECT `user`.*, `user_role` . `role`
                    FROM `user` JOIN `user_role`
                    ON   `user`.`role_id` = `user_role`.`id` ";
        return $this->db->query($query)->result_array();
    }
}
