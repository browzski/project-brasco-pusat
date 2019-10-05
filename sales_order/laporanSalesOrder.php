<?php
include '../env.php';
$title = "Laporan Sales Order";
if (isset($_POST['cari'])) {
    extract($_POST);
    $sql = "SELECT * FROM sales_order WHERE ";
    if ($customer !== '') {
        $customer = rtrim($customer);
        $sql .= "kode_customer = '$customer' ";
    }
    if ($tanggal1 !== '') {
        if ($customer !== '') {
            $sql .= " AND ";
        }
        $sql2 = "tanggal_so = '$tanggal1'";
        if ($tanggal2 !== '') {
            $sql2 = "tanggal_so BETWEEN CAST('$tanggal1' AS DATE) AND CAST('$tanggal2' AS DATE)";
        }
        $sql .= $sql2;
    }
    if ($customer == 'sen') {
        $sql = "SELECT * FROM sales_order ";
    }
    $query = query($sql);
}

?>
<script>
    var active = 'header_sales';
    var active_2 = 'header_sales_laporan';
</script>

<?php include('../templates/header.php') ?>

<div class="content-wrapper">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h1>LAPORAN SALES ORDER</h1>
        </div>
        <div class="panel-body">
            <form action="" method="POST">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Tanggal </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <div style="display: inline-flex; ">
                                <input type="date" name="tanggal1" class="form-control">
                                <i style="font-size: 30px; margin-left: 30px;" class="fa fa-calendar"></i>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label style="max-width: 100%; text-align: center;">s/d</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <div style="display: inline-flex; ">
                                <input type="date" name="tanggal2" class="form-control">
                                <i style="font-size: 30px; margin-left: 30px" class="fa fa-calendar"></i>
                            </div>

                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Customer</label>

                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <select class="form-control" name="customer">
                                <option value="sen">-Semua Customer-</option>
                                <?php $s = query("SELECT * FROM customer");
                                foreach ($s as $d) : ?>
                                    <option value="<?= $d['kode'] ?>"><?= $d['nama'] ?></option>
                                <?php endforeach; ?>
                                <option value="">-Tidak pilih-</option>
                            </select>

                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <button class="btn btn-primary" name="cari" type="submit">Search</button>
                        </div>
                    </div>
            </form>
        </div>
        <?php if (isset($query)) : ?>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <button class="btn btn-light">Excel</button>
                        <button class="btn btn-light">PDF</button>
                        <button class="btn btn-light">Print</button>

                    </div>
                </div>
            </div>

            <div style="margin-top: 5px">

                <table class="table table-bordered ">
                    <thead align="center">
                        <tr>
                            <th>
                                <center>No</center>
                            </th>
                            <th>
                                <center>No Sales Order</center>
                            </th>
                            <th>
                                <center>Tanggal Sales Order</center>
                            </th>
                            <th>
                                <center>Customer</center>
                            </th>
                            <th>
                                <center>Total Item</center>
                            </th>
                            <th>
                                <center>Keterangan</center>
                            </th>
                            <th>
                                <center>Aksi</center>
                            </th>
                        </tr>
                    </thead>
                    <tbody align="center">
                        <?php $i = 1;
                            foreach ($query as $t) : extract($t);
                                $src = query("SELECT * FROM customer WHERE kode='$kode_customer'")[0]; ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= $nomor_so ?></td>
                                <td><?= $tanggal_so ?></td>
                                <td><?= $src['nama'] ?></td>
                                <td><?= $total ?></td>
                                <td><?= $keterangan ?></td>
                                <td>
                                    <a href="sales_order/edit_so.php?nomor=<?= $nomor_so ?>"><i style="color: blue;font-size:24px;" class="fa fa-pencil"></i></a>
                                    <a onclick="return confirm('Yakin ingin menghapus?')" href="sales_order/ajax.php?nomor=<?= $nomor_so ?>"><i style="color: red;font-size:24px;" class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

    </div>
</div>
</div>

<?php include('../templates/footer.php') ?>