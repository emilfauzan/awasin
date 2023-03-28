<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang_model extends CI_Model
{

    // public function delete($u)
    // {
    //     $this->db->delete('data_barang', array('idbarang' => $u));
    //     return;
    // }

    public function deletetransaksi($v)
    {
        $this->db->delete('transaksi', array('idtransaksi' => $v));
        return;
    }

    // SOFT DELETE DATA BARANG
    public function softdelete($u)
    {
        $data = [
            'is_deleted' => 1,
        ];
        $this->db->where('idbarang', $u);
        $this->db->update('data_barang', $data);
        return;
    }

    public function edit($id)
    {
        return $this->db->get_where('data_barang', ['idbarang' => $id])->row_array();
    }

    public function edittmasuk($id)
    {
        return $this->db->get_where('transaksi', ['idtransaksi' => $id])->row_array();
    }

    public function edittkeluar($id)
    {
        return $this->db->get_where('transaksi', ['idtransaksi' => $id])->row_array();
    }

    public function getqty()
    {
        $query = "SELECT `transaksi`.*, `data_barang` . `merk`, `data_barang` . `nama_barang`, `data_barang` . `kategori`, `data_barang` . `deskripsi`, `data_barang` . `idbarang`
                  FROM   `data_barang` LEFT JOIN `transaksi` ON `transaksi`.`idbarang` = `data_barang`.`idbarang` 
                  ";
        return $this->db->query($query)->result_array();
    }

    public function getdistinctproduct()
    {
        $query = "SELECT *
                  FROM `data_barang` WHERE `is_deleted` = 0
                  ";
        return $this->db->query($query)->result_array();
    }

    public function getTransaksiByIdBarang($idBarang)
    {
        $query = "SELECT *
        FROM `transaksi` WHERE `transaksi`.`idbarang` = $idBarang
        ";
        return $this->db->query($query)->result_array();
    }

    public function getTransaksi($type)
    {
        if ($type == 'masuk') {
            $type = 1;
        } else {
            $type = 2;
        }
        $query = "SELECT `transaksi`.*, `data_barang` . `merk`, `data_barang` . `nama_barang`, `data_barang` . `kategori`, `data_barang` . `is_deleted`
                  FROM   `transaksi` LEFT JOIN `data_barang` ON `transaksi`.`idbarang` = `data_barang`.`idbarang` 
                  WHERE `jenis_transaksi`='$type'";
        return $this->db->query($query)->result_array();
    }

    public function getTransaksiFilter($type, $date)
    {
        if ($type == 'masuk') {
            $type = 1;
        } else {
            $type = 2;
        }
        $query = "SELECT `transaksi`.*, `data_barang` . `merk`, `data_barang` . `nama_barang`, `data_barang` . `kategori`, `data_barang` . `is_deleted`
                  FROM   `transaksi` LEFT JOIN `data_barang` ON `transaksi`.`idbarang` = `data_barang`.`idbarang` 
                  WHERE `transaksi`.`date` = '$date' AND `transaksi`.`jenis_transaksi` = $type
                  ";
        return $this->db->query($query)->result_array();
    }

    public function getdata()
    {
        $query = $this->db->query("SELECT * FROM data_barang WHERE `is_deleted` = 0 ORDER BY merk ASC");
        return $query->result();
    }

    public function datalaporantkeluarbyyear($year)
    {
        $res = $this->db->query('SELECT `b`.*,`a`.`date`,`a`.`qty`,`a`.`keterangan` from `transaksi` as `a` LEFT JOIN `data_barang` as `b` ON `a`.`idbarang` = `b`.`idbarang` WHERE `a`.`is_deleted`="0" AND  `jenis_transaksi`="2" AND `a`.`date` LIKE "%' . $year . '%"');

        return $res->result();
    }

    public function datalaporantkeluarbymonthyear($month, $year)
    {
        $string = $year . '-' . $month;
        $res = $this->db->query('SELECT `b`.*,`a`.`date`,`a`.`qty`,`a`.`keterangan` from `transaksi` as `a` LEFT JOIN `data_barang` as `b` ON `a`.`idbarang` = `b`.`idbarang` WHERE `a`.`is_deleted`="0" AND  `jenis_transaksi`="2" AND `a`.`date` LIKE "%' . $string . '%"');

        return $res->result();
    }

    public function datalaporantmasukbyyear($year)
    {
        $res = $this->db->query('SELECT `b`.*,`a`.`date`,`a`.`qty`,`a`.`keterangan` from `transaksi` as `a` LEFT JOIN `data_barang` as `b` ON `a`.`idbarang` = `b`.`idbarang` WHERE `a`.`is_deleted`="0" AND  `jenis_transaksi`="1" AND `a`.`date` LIKE "%' . $year . '%"');

        return $res->result();
    }

    public function datalaporantmasukbymonthyear($month, $year)
    {
        $string = $year . '-' . $month;
        $res = $this->db->query('SELECT `b`.*,`a`.`date`,`a`.`qty`,`a`.`keterangan` from `transaksi` as `a` LEFT JOIN `data_barang` as `b` ON `a`.`idbarang` = `b`.`idbarang` WHERE `a`.`is_deleted`="0" AND  `jenis_transaksi`="1" AND `a`.`date` LIKE "%' . $string . '%"');

        return $res->result();
    }

    public function datalaporandatabarang()
    {
        $query = $this->db->query("SELECT * FROM data_barang WHERE `is_deleted` = 0 ORDER BY merk ASC");
        return $query->result();
    }
}
