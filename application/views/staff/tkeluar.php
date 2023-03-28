<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg">

            <?php if (validation_errors()) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= validation_errors(); ?>
                </div>
            <?php endif; ?>

            <?= $this->session->flashdata('message'); ?>

            <div class="card shadow">
                <div class="card-body">
                    <?= form_open_multipart('staff/settanggaltkeluar') ?>
                    <!-- <form method="post" action=""> -->
                    <div class="row">
                        <div class="form-group col-lg-3 mb-3 ">
                            <h4 class="card-title">Tanggal Transaksi</h4>
                            <p class="card-text">Masukkan tanggal transaksi.</p>
                            <input type="date" name="tanggaltkeluar" class="form-control mb-3">
                            <button type="submit" name="tanggal" class="btn btn-primary">Set Tanggal</button>
                            <button type="button" class="btn btn-secondary" onclick="resetFilter()">Reset Tanggal</button>
                        </div>
                    </div>
                    </form>

                </div>
            </div>

            <br>

            <a href="" class="btn btn-primary btn-icon-split mb-3 shadow " data-toggle="modal" data-target="#newTkeluarModal">
                <span class="icon text-white-50"><i class="fas fa-plus"></i></span>
                <span class="text">
                    Tambah Transaksi
                </span> </a>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Merk</th>
                        <th scope="col">Nama Barang</th>
                        <th scope="col">Kategori</th>
                        <th scope="col">Stok</th>
                        <th scope="col">Keterangan</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1;
                    // print_r($keterangan);
                    foreach ($keterangan as $m) : ?>
                        <tr>
                            <th scope="row"><?= $i++; ?></th>
                            <td><?= $m['merk']; ?></td>
                            <td><?= $m['nama_barang']; ?></td>
                            <td><?= $m['kategori']; ?></td>
                            <td><?= $m['qty']; ?></td>
                            <td><?= $m['keterangan']; ?></td>
                            <td>
                                <a href="<?= base_url('staff/edittkeluar'); ?><?= '?id=' . $m['idtransaksi']; ?>" class=" shadow btn btn-success btn-circle btn-sm modalEditBarang" data-toggle="modal" data-target="#editDataBarangModal<?= $m['idtransaksi']; ?>" type="button" onclick="return edit(<?= $m['idtransaksi'] ?>)">
                                    <i class="fas fa-pen"></i></a>
                                <a href="<?= base_url('staff/hapustransaksi/'); ?><?= '?id=' . $m['idtransaksi']; ?>" class=" shadow btn btn-danger btn-circle btn-sm" type="button" onclick="return confirm('yakin?');">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Modal Tambah Data -->
<div class="modal fade" id="newTkeluarModal" tabindex="-1" aria-labelledby="newTkeluarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newTkeluarModalLabel">Tambah Transaksi Barang Keluar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <div class="modal-body">
                <?= form_open_multipart('staff/tkeluar'); ?>

                <!-- DATE -->
                <label for="text" class="col-form-label"></label>
                <input type="hidden" class="form-control" id="date" name="date"></input>

                <!-- JENIS TRANSAKSI -->
                <label for="text" class="col-form-label"></label>
                <input type="hidden" class="form-control" id="jenis_transaksi" name="jenis_transaksi" value="2"></input>

                <div class="form-group row">
                    <label for="formcontrolbarang" class="col-sm-3 col-form-label">Merk</label>
                    <div class="col-sm-9">
                        <select class="form-control" id="merk" name="merk">
                            <?php foreach ($transaksi as $t) : ?>
                                <option value="<?= $t->idbarang; ?>"><?= $t->merk; ?> || <?= $t->nama_barang; ?> || <?= $t->kategori; ?></option>
                            <?php endforeach ?>
                            <input type="hidden" name="idbarang" value="idbarang">
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="text" class="col-sm-3 col-form-label">Stok</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="qty" name="qty"></input>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="text" class="col-sm-3 col-form-label">Keterangan</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="keterangan" name="keterangan">
                    </div>
                </div>


            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary tombolTambahData">Tambah Transaksi</button>
            </div>

            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Data -->
<?php $no = 0;
foreach ($keterangan as $m) : $no++; ?>

    <div class="modal fade" id="editDataBarangModal<?= $m['idtransaksi']; ?>" tabindex="-1" aria-labelledby="editDataBarangModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="editDataBarangModalLabel">Edit Data Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>


                <div class="modal-body">
                    <form action="/awasin/staff/edittkeluar?id=<?= $m['idtransaksi']  ?>" method="POST" id="form-<?= $m['idtransaksi']  ?>">


                        <input type="hidden" name="idbarang" value="<?= $m['idbarang']; ?>">
                        <input type="hidden" name="idtransaksi" value="<?= $m['idtransaksi']; ?>">
                        <input type="hidden" id="jenis_transaksi" name="jenis_transaksi" value="<?= $m['jenis_transaksi']; ?>">

                        <div class="form-group row">
                            <label for="text" class="col-sm-2 col-form-label">Merk</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="merk" name="merk" value="<?= $m['merk']; ?>" readonly>
                            </div>
                        </div>

                        <div class=" form-group row">
                            <label for="text" class="col-sm-2 col-form-label">Nama Barang</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="<?= $m['nama_barang']; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="text" class="col-sm-2 col-form-label">Kategori</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="kategori" name="kategori" value="<?= $m['kategori']; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="text" class="col-sm-2 col-form-label">Stok</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="qty" name="qty" value="<?= $m['qty']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="text" class="col-sm-2 col-form-label">Keterangan</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="keterangan" name="keterangan" value="<?= $m['keterangan']; ?>">
                            </div>
                        </div>
                    </form>


                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary tombolTambahData" form="form-<?= $m['idtransaksi'] ?>">Simpan Data Transaksi</button>
                </div>

            </div>
        </div>
    </div>
    <script>
        function resetFilter() {
            var url = window.location.origin
            window.location.href = url + '/awasin/staff/tkeluar'
        }
    </script>
<?php endforeach; ?>