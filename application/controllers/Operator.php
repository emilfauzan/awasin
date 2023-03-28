<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Operator extends CI_Controller
{

    // KETIKA SESSION HABIS, REDIRECT KE LOGIN PAGE (auth)
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->library('form_validation');
    }

    public function usermanagement()
    {
        $data['title'] = 'User Management';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $query = 'SELECT `user`.*,`role` from `user` LEFT JOIN `user_role` ON `user`.`role_id` = `user_role`.`id`';
        $data['userlist'] = $this->db->query($query)->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('operator/usermanagement', $data);
        $this->load->view('templates/footer');
    }

    public function edituser()
    {
        $data['title'] = 'Edit User Profile';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $id =  $this->input->get('id');
        $this->form_validation->set_rules('name', 'Full Name', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('operator/edituser', $data);
        } else {
            $name = $this->input->post('name');
            $email = $this->input->post('email');

            $this->db->query("UPDATE `user` SET `email`='" . $email . "',`name`='" . $name . "'  WHERE `id` = " . $id);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        User profile has been updated.</div>');
            redirect('operator/usermanagement');
        }
    }

    public function hapus()
    {
        $this->load->model('User_model');

        $u = $this->input->get('id');
        $this->User_model->delete($u);

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Satu User berhasil dihapus!</div>');
        redirect('operator/usermanagement');
    }
}
