<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg-6">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

    <!-- Greetings Card -->
    <div class="card row-cols-2 shadow">
        <div class="row no-gutters">
            <div class="col-md-4">
                <img src="<?= base_url('assets/img/profile/') . $user['image']; ?>" class="card-img">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title"><?= $user['name']; ?></h5>
                    <p class="card-text"><?= $user['email']; ?></p>
                    <p class="card-text"><?= $user['role_id'] == 1 ? 'Operator' : ($user['role_id'] == 2 ? 'Pengawas' : 'Staff'); ?></p>
                    <p class="card-text"><small class="text-muted">Registered member since <?= date('d F Y', $user['date_created']); ?></small></p>
                </div>
            </div>
        </div>
    </div>
    <br>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->