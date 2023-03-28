<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
    public function delete($b)
    {
        $this->db->delete('user', array('id' => $b));
        return;
    }

    public function edituser($id)
    {
        return $this->db->get_where('user', ['id' => $id])->row_array();
    }
}
