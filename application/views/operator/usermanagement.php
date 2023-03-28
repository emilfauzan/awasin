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
        </div>
    </div>

    <div class="col-lg">

        <table class="table table-hover">

            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col" class="col-lg-2">Image</th>
                    <th scope="col">Role</th>
                    <th scope="col">Status</th>
                    <th scope="col">Date</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1;
                foreach ($userlist as $u) : ?>
                    <tr>
                        <th scope="row"><?= $i++; ?></th>
                        <td><?= $u['name']; ?></td>
                        <td><?= $u['email']; ?></td>
                        <td><img src="<?= base_url('assets/img/profile/') . $u['image']; ?>" class="card-img col-md-6"></td>
                        <td><?= $u['role']; ?></td>
                        <td><?= $u['is_active'] == 1 ? 'Active' : 'Not Active'; ?></td>
                        <td><?= date('d F Y', $u['date_created']); ?></td>
                        <td>
                            <a href="<?= base_url('operator/edituser'); ?><?= '?id=' . $u['id']; ?>" class="btn btn-success btn-circle btn-sm modalEditUser" data-toggle="modal" data-target="#FormModal<?= $u['id']; ?>" type="button" onclick="return edituser(<?= $u['id'] ?>)">
                                <i class="fas fa-pen"></i></a>

                            <a href="<?= base_url('operator/hapus?id=' . $u['id']); ?>" class="btn btn-danger btn-circle btn-sm" onclick="return confirm('yakin?');">
                                <i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Modal -->
<?php $no = 0;
foreach ($userlist as $u) : $no++; ?>

    <div class="modal fade" id="FormModal<?= $u['id']; ?>" tabindex="-1" aria-labelledby="FormModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="FormModalLabel<?= $u['id']; ?>">Edit Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form action="/awasin/operator/edituser?id=<?= $u['id']  ?>" method="POST" id="form-<?= $u['id']  ?>">

                        <div class="form-group row">
                            <label for="email" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="email" name="email" value="<?= $u['email']; ?>" readonly>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Full Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" name="name" value="<?= $u['name']; ?>">
                                <?= form_error('name', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                        </div>


                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary tombolEditUser" form="form-<?= $u['id'] ?>">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>