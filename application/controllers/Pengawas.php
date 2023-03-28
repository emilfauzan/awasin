<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Dompdf\Dompdf;

class Pengawas extends CI_Controller
{

    // KETIKA SESSION HABIS, REDIRECT KE LOGIN PAGE (auth)
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->library('form_validation');
    }

    public function laporandatabarang()
    {
        $data['title'] = 'Laporan Data Barang';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('pengawas/laporandatabarang', $data);
        $this->load->view('templates/footer');
    }

    public function laporantransaksibarangmasuk()
    {
        $data['title'] = 'Laporan Barang Masuk';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('pengawas/laporantransaksibarangmasuk', $data);
        $this->load->view('templates/footer');
    }

    public function laporantransaksibarangkeluar()
    {
        $data['title'] = 'Laporan Barang Keluar';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('pengawas/laporantransaksibarangkeluar', $data);
        $this->load->view('templates/footer');
    }

    public function pdfkeluar()
    {
        $this->load->model('Barang_model');
        $data['title'] = $this->input->get('title');
        $type = $this->input->get('type');
        if ($type == 1) {
            $id = 2;
            $tahun = $this->input->get('year');
            $data['barang']  = $this->Barang_model->datalaporantkeluarbyyear($tahun);
        } else {
            $tahun = $this->input->get('year');
            $bulan = $this->input->get('month');
            $data['barang']  = $this->Barang_model->datalaporantkeluarbymonthyear($bulan, $tahun);
        }

        // $data['barang'] = [1];
        $dompdf = new Dompdf();
        $html = $this->load->view('pengawas/pdftransaksi', $data, TRUE);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('test.pdf', array("Attachment" => 0));
    }

    public function pdfmasuk()
    {
        $this->load->model('Barang_model');
        $data['title'] = $this->input->get('title');
        $type = $this->input->get('type');
        if ($type == 1) {
            $id = 1;
            $tahun = $this->input->get('year');
            $data['barang']  = $this->Barang_model->datalaporantmasukbyyear($tahun);
        } else {
            $tahun = $this->input->get('year');
            $bulan = $this->input->get('month');
            $data['barang']  = $this->Barang_model->datalaporantmasukbymonthyear($bulan, $tahun);
        }

        // $data['barang'] = [1];
        $dompdf = new Dompdf();
        $html = $this->load->view('pengawas/pdftransaksi', $data, TRUE);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('test.pdf', array("Attachment" => 0));
    }

    public function pdfbarang()
    {
        $data['title'] = $this->input->get('title');
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

        $data['barang'] = $barang;
        $dompdf = new Dompdf();
        $html = $this->load->view('pengawas/pdfbarang', $data, TRUE);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('test.pdf', array("Attachment" => 0));
    }
}
