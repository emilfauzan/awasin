<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>

    <style>
        .table {
            border: solid 1px black;
            width: 100%;
            border-collapse: collapse;
        }

        .table tr {
            border: solid 1px black;
        }

        .table tr td,
        .table tr th {
            border: solid 1px black;
            text-align: center;
        }

        .center {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        p {
            font-weight: bold;
            font-size: 40px;
            font-family: Arial, Helvetica, sans-serif;
            text-align: center;
        }

        body {
            width: 100%;
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>
</head>

<body">
    <div class="center">
        <p><?= $title ?></p>
        <table border="0" class="table">
            <tr>
                <th>No.</th>
                <th>Merk</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Keterangan</th>
                <th>Tanggal</th>
                <th>Stok</th>
            </tr>
            <?php

            foreach ($barang as $key => $b) {
            ?>
                <tr>
                    <td><?= $key + 1 ?></td>
                    <td><?= $b->merk ?></td>
                    <td><?= $b->nama_barang ?></td>
                    <td><?= $b->kategori ?></td>
                    <td><?= $b->keterangan ?></td>
                    <td><?= $b->date ?></td>
                    <td><?= $b->qty ?></td>
                </tr>
            <?php
            }
            ?>

        </table>
    </div>


    <!-- 
    <script type="text/javascript">
        window.print();
    </script> -->

    </body>

</html>