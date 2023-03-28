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

            <a href="" class="btn btn-primary btn-icon-split mb-3 shadow" data-toggle="modal" data-target="#newDataBarangModal">
                <span class="icon text-white-50"><i class="fas fa-plus"></i></span>
                <span class="text">
                    Tambah Data Barang
                </span> </a>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Merk</th>
                        <th scope="col">Nama Barang</th>
                        <th scope="col">Deskripsi</th>
                        <th scope="col">Kategori</th>
                        <th scope="col">Stok</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1;
                    foreach ($transaksi as $m) : ?>
                        <tr>
                            <th scope="row"><?= $i++; ?></th>
                            <td><?= $m['merk']; ?></td>
                            <td><?= $m['nama_barang']; ?></td>
                            <td><?= $m['deskripsi']; ?></td>
                            <td><?= $m['kategori']; ?></td>
                            <td><?= $m['qty']; ?></td>
                            <td>
                                <a href="<?= base_url('staff/edittmasuk'); ?><?= '?id=' . $m['idbarang']; ?>" class="shadow btn btn-success btn-circle btn-sm modalEditBarang" data-toggle="modal" data-target="#editDataBarangModal<?= $m['idbarang']; ?>" type="button" onclick="return edit(<?= $m['idbarang'] ?>)">
                                    <i class="fas fa-pen"></i></a>
                                <a href="<?= base_url('staff/hapus'); ?><?= '?id=' . $m['idbarang']; ?>" class="shadow btn btn-danger btn-circle btn-sm" type="button" onclick="return confirm('yakin?');">
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
<div class="modal fade" id="newDataBarangModal" tabindex="-1" aria-labelledby="newDataBarangModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newDataBarangModalLabel">Tambah Data Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <div class="modal-body">
                <?= form_open_multipart('staff/databarang'); ?>

                <div class="form-group row">
                    <label for="text" class="col-sm-2 col-form-label">Merk</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="merk" name="merk">
                    </div>
                </div>
                <div class=" form-group row">
                    <label for="text" class="col-sm-2 col-form-label">Nama Barang</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nama_barang" name="nama_barang">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="text" class="col-sm-2 col-form-label">Deskripsi</label>
                    <div class="col-sm-10">
                        <textarea type="text" class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="text" class="col-sm-2 col-form-label">Kategori</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="kategori" name="kategori">
                    </div>
                </div>


            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary tombolTambahData">Tambah Data Barang</button>
            </div>

            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Data -->
<?php $no = 0;
foreach ($merk as $m) : $no++; ?>

    <div class="modal fade" id="editDataBarangModal<?= $m['idbarang']; ?>" tabindex="-1" aria-labelledby="editDataBarangModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="editDataBarangModalLabel">Edit Data Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>


                <div class="modal-body">
                    <form action="/awasin/staff/editbarang?id=<?= $m['idbarang']  ?>" method="POST" id="form-<?= $m['idbarang']  ?>">

                        <input type="hidden" name="idbarang" value="<?= $m['idbarang']; ?>">

                        <div class="form-group row">
                            <label for="text" class="col-sm-2 col-form-label">Merk</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="merk" name="merk" value="<?= $m['merk']; ?>">
                            </div>
                        </div>
                        <div class=" form-group row">
                            <label for="text" class="col-sm-2 col-form-label">Nama Barang</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="<?= $m['nama_barang']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="text" class="col-sm-2 col-form-label">Deskripsi</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="deskripsi" name="deskripsi" rows="3" value="<?= $m['deskripsi']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="text" class="col-sm-2 col-form-label">Kategori</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="kategori" name="kategori" value="<?= $m['kategori']; ?>">
                            </div>
                        </div>
                    </form>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary tombolEditData" form="form-<?= $m['idbarang'] ?>">Simpan Data Barang</button>
                </div>

            </div>
        </div>
    </div>
<?php endforeach; ?>


<script>
    <?php
    // if ($this->session->flashdata('Satu Data Barang berhasil ditambah!')[0] == 'Satu Data Barang berhasil ditambah!') :
    ?>
    // window.alert('
    <?php
    // $this->session->flashdata('Satu Data Barang berhasil ditambah!')[1] ')
    ?>

    <?php
    // endif;
    ?>
</script>