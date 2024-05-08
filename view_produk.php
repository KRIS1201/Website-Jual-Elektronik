<?php
include "template/header.php";
?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Produk</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <tr>
                        <th>ID Produk</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Stock</th>
                        <th>Aksi</th>
                    </tr>
                    <?php
                    // Include file koneksi.php
                    include "koneksi.php";

                    // Query untuk mengambil data dari view_produk
                    $sql = $pdo->prepare("SELECT * FROM view_produk");
                    $sql->execute();

                    // Loop untuk menampilkan data
                    while ($data = $sql->fetch()) {
                        echo "<tr>";
                        echo "<td>" . $data['id_produk'] . "</td>";
                        echo "<td>" . $data['nama_produk'] . "</td>";
                        echo "<td>" . $data['harga'] . "</td>";
                        echo "<td>" . $data['stock'] . "</td>";
                        echo "<td>
                                <a href='ubah_produk.php?id_produk=" . $data['id_produk'] . "' onclick=\"return confirm('Apakah Anda yakin ingin mengedit data ini?')\" class='btn btn-primary btn-icon-split'>
                                    <span class='icon text-white-50'>
                                        <i class='fas fa-flag'></i>
                                    </span>
                                    <span class='text'>Edit</span>
                                </a>
                                <a href='hapus_produk.php?id_produk=" . $data['id_produk'] . "' onclick=\"return confirm('Apakah Anda yakin ingin menghapus data ini?')\" class='btn btn-danger btn-icon-split'>
                                    <span class='icon text-white-50'>
                                        <i class='fas fa-trash'></i>
                                    </span>
                                    <span class='text'>Hapus</span>
                                </a>
                              </td>";
                        echo "</tr>";
                    }
                    ?>
                </table>
                <td><a href='tambah_produk.php' class='btn btn-success btn-icon-split'>
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
