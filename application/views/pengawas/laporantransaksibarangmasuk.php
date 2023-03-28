<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row-cols-2">
        <div class="col-lg-6">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

    <!-- SET PERIODE -->
    <div class="card shadow">
        <div class="card-body">
            <form>
                <div class="row">
                    <div class="form-group col-lg-6 mb-3 ">
                        <h4 class="card-title">Pilih jenis dan periode</h4>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend"><select onchange="setDateForm()" id=jenis name="tgl[]" class="custom-select" value="<?= date('m') ?>">
                                    <option value="1">
                                        Tahunan </option>
                                    <option value="2">
                                        Bulanan </option>
                                </select></div>
                        </div>
                        <div class="input-group mb-3">
                            <div id='bulan' class="d-none input-group-prepend"><select id='bulan_input' name="tgl[]" class="custom-select" value="<?= date('m') ?>">
                                    <option value="01">
                                        Januari </option>
                                    <option value="02">
                                        Februari </option>
                                    <option value="03">
                                        Maret </option>
                                    <option value="04">
                                        April </option>
                                    <option value="05">
                                        Mei </option>
                                    <option value="06">
                                        Juni </option>
                                    <option value="07">
                                        Juli </option>
                                    <option value="08">
                                        Agustus </option>
                                    <option value="09">
                                        September </option>
                                    <option value="10">
                                        Oktober </option>
                                    <option value="11">
                                        November </option>
                                    <option value="12">
                                        Desember </option>
                                </select></div> <input id='tahun' autocomplete="off" type="number" value="<?= date('Y') ?>" min="1970" required="required" name="tgl[]" class="form-control form-control-line">
                            <div class="input-group-append"><input type="hidden" name="hal" value="Inventaris"></div>
                        </div>
                    </div>
                    <div class="form-group col-lg-6 mb-3">
                        <!-- <div class="card border-primary">

                            <div class="card-body text-primary">
                                <h4 class="alert-heading"><i class="fas fa-exclamation-circle"></i> Perhatian!</h4>
                                <p class="card-text">Silahkan pilih laporan sesuai periode dan waktu yang di inginkan kemudian tekan tombol
                                    <button type="button" class="btn btn-primary ">Set</button> untuk menampilkan preview laporan.
                                </p>
                            </div>
                        </div> -->
                    </div>
                </div>
            </form>
        </div>
    </div>

    <br>

    <!-- SET TEMPLATE LAPORAN -->
    <div class="card shadow">
        <div class="row no-gutters">
            <div class="card-body">
                <h4>Judul Laporan</h4>
                <form>
                    <div class="form-group">
                        <label for="juduldatabarang">Masukkan judul laporan untuk dicetak.</label>
                        <input type='text' class="form-control" id="juduldatabarang" rows="3" value="Laporan Transaksi Barang Masuk">
                        </input>
                        <br>
                        <div class="row">
                            <div class="col-lg-5 d-inline">
                                <a target="_blank" href="#" id='print_button' onclick="printpdf()" class="btn btn-info btn-icon-split">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-print"></i>
                                    </span>
                                    <span class="text">Print Laporan Transaksi Barang Masuk</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<br>

</div>
<!-- /.container-fluid -->
<script>
    function setDateForm(e) {

        if (document.getElementById('jenis').value == 1) {
            // tahunan
            document.getElementById('bulan').classList.add('d-none')
        } else {
            document.getElementById('bulan').classList.remove('d-none')
            // bulanan
        }
    }

    function printpdf() {
        var type = document.getElementById('jenis').value
        var month = document.getElementById('bulan_input').value
        var year = document.getElementById('tahun').value
        var title = document.getElementById('juduldatabarang').value
        var title = encodeURI(title)
        var url = window.location.origin

        if (type == 1) {
            window.open(url + '/awasin/pengawas/pdf/masuk?type=' + type + '&year=' + year + '&title=' + title)
        } else {
            window.open(url + '/awasin/pengawas/pdf/masuk?type=' + type + '&year=' + year + '&month=' + month + '&title=' + title)
        }
    }
</script>
<!-- End of Main Content -->