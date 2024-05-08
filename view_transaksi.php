<?php
include "template/header.php";
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Transaksi Penjualan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID Transaksi</th>
                            <th>Nama Pelanggan</th>
                            <th>Nama Produk</th>
                            <th>Kuantitas</th>
                            <th>Total Harga</th>
                            <th>Tanggal Transaksi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Include file koneksi.php
                        include "koneksi.php";

                        // Query untuk mengambil data dari view transaksi_penjualan
                        $sql = $pdo->prepare("SELECT * FROM view_transaksi_penjualan");
                        $sql->execute();

                        // Loop untuk menampilkan data
                        while ($data = $sql->fetch()) {
                            echo "<tr>";
                            echo "<td>" . $data['id_transaksi'] . "</td>";
                            echo "<td>" . $data['nama_pelanggan'] . "</td>";
                            echo "<td>" . $data['nama_produk'] . "</td>";
                            echo "<td>" . $data['kuantitas'] . "</td>";
                            echo "<td>" . $data['total_harga'] . "</td>";
                            echo "<td>" . $data['tanggal_transaksi'] . "</td>";
                            echo "<td>
                                    <a href='ubah_transaksi.php?id_transaksi=" . $data['id_transaksi'] . "' class='btn btn-primary btn-icon-split'>
                                        <span class='icon text-white-50'>
                                            <i class='fas fa-flag'></i>
                                        </span>
                                        <span class='text'>Edit</span>
                                    </a>
                                    <a href='hapus_transaksi.php?id_transaksi=" . $data['id_transaksi'] . "' class='btn btn-danger btn-icon-split' onclick='return confirm(\"Apakah Anda yakin ingin menghapus transaksi ini?\")'>
                                        <span class='icon text-white-50'>
                                            <i class='fas fa-trash'></i>
                                        </span>
                                        <span class='text'>Hapus</span>
                                    </a>
                                  </td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <td><a href='tambah_transaksi.php' class='btn btn-success btn-icon-split'>
                        <span class='icon text-white-50'>
                            <i class='fas fa-arrow-right'></i>
                        </span>
                        <span class='text'>Input Data</span>
                    </a></td>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<?php
include 'template/footer.php';
?>
