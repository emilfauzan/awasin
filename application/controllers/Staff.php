<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Dompdf\Dompdf;

class Staff extends CI_Controller
{

    // KETIKA SESSION HABIS, REDIRECT KE LOGIN PAGE (auth)
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->library('form_validation');
    }

    public function databarang()
    {
        $data['title'] = 'Data Barang';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->model('Barang_model');

        $barang = $this->Barang_model->getdistinctproduct();

        foreach ($barang as $key => $b) {
            $transaksi = $this->Barang_model->getTransaksiByIdBarang($b['idbarang']);
            $count = 0;
            foreach ($transaksi as $t) {
                //masuk
                if ($t['jenis_transaksi'] == 1) {
                    $count += $t['qty'];
                } else {
                    $count -= $t['qty'];
                }
            }
            $barang[$key]['qty'] = $count;
        }

        $data['transaksi'] = $barang;

        $data['merk'] = $this->db->get('data_barang')->result_array();

        $this->form_validation->set_rules('merk', 'Merk', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('staff/databarang', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'merk' => $this->input->post('merk'),
                'nama_barang' => $this->input->post('nama_barang'),
                'deskripsi' => $this->input->post('deskripsi'),
                'kategori' => $this->input->post('kategori'),
            ];
            $this->db->insert('data_barang', $data);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Satu Data Barang berhasil ditambah!</div>');
            // , ['Satu Data Barang berhasil ditambah!', json_encode($data, true)]
            redirect('staff/databarang', 'refresh');
        }
    }

    public function editbarang()
    {
        $data['title'] = 'Edit Data Barang';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $id =  $this->input->get('id');
        $this->form_validation->set_rules('merk', 'Merk', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('staff/databarang', $data);
            $this->load->view('templates/footer');
        } else {
            $merk = $this->input->post('merk');
            $nama_barang = $this->input->post('nama_barang');
            $deskripsi = $this->input->post('deskripsi');
            $kategori = $this->input->post('kategori');

            $this->db->query("UPDATE `data_barang` SET `merk`='" . $merk . "',`nama_barang`='" . $nama_barang . "',`deskripsi`='" . $deskripsi . "',`kategori`='" . $kategori . "' WHERE `idbarang` = " . $id);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Satu Data Barang berhasil diubah!</div>');
            redirect('staff/databarang');
        }
    }

    // SOFTDELETE DATA BARANG
    public function hapus()
    {
        $this->load->model('Barang_model');
        parse_str($_SERVER['QUERY_STRING'], $_GET);

        $u = $this->input->get('id');
        $this->Barang_model->softdelete($u);

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Satu Data Barang berhasil dihapus!</div>');
        redirect('staff/databarang');
    }

    // SOFTDELETE TRANSAKSI BARANG
    public function hapustransaksi()
    {
        $this->load->model('Barang_model');
        parse_str($_SERVER['QUERY_STRING'], $_GET);

        $u = $this->input->get('id');
        $this->Barang_model->deletetransaksi($u);

        $data = [
            'is_deleted' => $this->input->post('is_deleted')
        ];
        $this->db->delete('transaksi', $data);

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Satu Data Transaksi Barang berhasil dihapus!</div>');
        redirect('staff/databarang');
    }

    public function settanggaltmasuk()
    {
        $this->form_validation->set_rules('tanggaltmasuk', 'Tanggal Masuk', 'required');
        if ($this->form_validation->run() == false) {
            redirect('staff/tmasuk');
        } else {
            $tanggal = $this->input->post('tanggaltmasuk');
            // 2022-10-11
            redirect('staff/tmasuk?filter=' . $tanggal);
        }
    }

    public function settanggaltkeluar()
    {
        $this->form_validation->set_rules('tanggaltkeluar', 'Tanggal Keluar', 'required');
        if ($this->form_validation->run() == false) {
            redirect('staff/tkeluar');
        } else {
            $tanggal = $this->input->post('tanggaltkeluar');
            // 2022-10-11
            redirect('staff/tkeluar?filter=' . $tanggal);
        }
    }

    public function tmasuk()
    {
        $data['title'] = 'Transaksi Barang Masuk';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->model('Barang_model');
        $data['transaksi'] = $this->Barang_model->getdata();
        $data['merk'] = $this->db->get('data_barang')->result_array();

        if ($this->input->get('filter') != null) {
            // var_dump($this->input->get('filter'));
            $data['keterangan'] = $this->Barang_model->getTransaksiFilter('masuk', $this->input->get('filter'));
        } else {
            $data['keterangan'] = $this->Barang_model->getTransaksi('masuk');
        }

        $this->form_validation->set_rules('merk', 'Merk', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('staff/tmasuk', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'date' => date("Y-m-d", strtotime("now")),
                'jenis_transaksi' => $this->input->post('jenis_transaksi'),
                'idbarang' => $this->input->post('merk'),
                'qty' => $this->input->post('qty'),
                'keterangan' => $this->input->post('keterangan'),
            ];

            $this->db->insert('transaksi', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Transaksi Barang Masuk berhasil ditambah!</div>');
            redirect('staff/tmasuk');
        }
    }

    public function edittmasuk()
    {
        $data['title'] = 'Edit Data Transaksi Barang Masuk';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $id =  $this->input->get('id');
        $this->form_validation->set_rules('merk', 'Merk', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('staff/databarang', $data);
            $this->load->view('templates/footer');
        } else {
            $qty = $this->input->post('qty');
            $keterangan = $this->input->post('keterangan');

            $this->db->query("UPDATE `transaksi` SET `keterangan`='" . $keterangan . "',`qty`='" . $qty . "' WHERE `idtransaksi` = " . $id);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Satu Data Transaksi Barang Masuk berhasil diubah!</div>');
            redirect('staff/tmasuk');
        }
    }

    public function edittkeluar()
    {
        $data['title'] = 'Edit Data Transaksi Barang Masuk';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $id =  $this->input->get('id');
        $this->form_validation->set_rules('merk', 'Merk', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('staff/databarang', $data);
            $this->load->view('templates/footer');
        } else {
            $idbarang = $this->input->post('idbarang');
            $qty = $this->input->post('qty');
            $keterangan = $this->input->post('keterangan');
            $idtransaksi = $this->input->post('idtransaksi');

            // $this->db->set('idbarang', $idbarang);
            // $this->db->set('qty', $qty);
            // $this->db->set('keterangan', $keterangan);
            // $this->db->where('idtransaksi', $id);

            // $this->db->update('transaksi');
            $this->db->query("UPDATE `transaksi` SET `keterangan`='" . $keterangan . "',`qty`='" . $qty . "' WHERE `idtransaksi` = " . $id);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Satu Data Transaksi Barang Keluar berhasil diubah!</div>');
            redirect('staff/tkeluar');
        }
    }

    public function tkeluar()
    {
        $data['title'] = 'Transaksi Barang Keluar';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->model('Barang_model');
        $data['transaksi'] = $this->Barang_model->getdata();

        $data['merk'] = $this->db->get('data_barang')->result_array();
        if ($this->input->get('filter') != null) {
            // var_dump($this->input->get('filter'));
            $data['keterangan'] = $this->Barang_model->getTransaksiFilter('keluar', $this->input->get('filter'));
        } else {
            $data['keterangan'] = $this->Barang_model->getTransaksi('keluar');
        }

        $this->form_validation->set_rules('merk', 'Merk', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('staff/tkeluar', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'date' => date("Y-m-d", strtotime("now")),
                'jenis_transaksi' => $this->input->post('jenis_transaksi'),
                'idbarang' => $this->input->post('merk'),
                'qty' => $this->input->post('qty'),
                'keterangan' => $this->input->post('keterangan'),
            ];

            $this->db->insert('transaksi', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Satu Data Transaksi Barang Keluar berhasil ditambah!</div>');
            redirect('staff/tkeluar');
        }
    }
}
