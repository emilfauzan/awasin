<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>

<body>

    <table>
        <tr>
            <th>No</th>
            <th>Merk</th>
            <th>Nama Barang</th>
            <th>Deskripsi</th>
            <th>Kategori</th>
        </tr>
        <?php
        $no = 1;
        foreach ($merk as $m) : ?>

            <tr>
                <td><?= $no++; ?></td>
                <td><?= $m['merk']; ?></td>
                <td><?= $m['nama_barang']; ?></td>
                <td><?= $m['deskripsi']; ?></td>
                <td><?= $m['kategori']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>


    <script type="text/javascript">
        window.print();
    </script>

</body>

</html>