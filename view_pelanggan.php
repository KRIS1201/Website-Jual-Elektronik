<?php
include "template/header.php";
?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Pelanggan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID Pelanggan</th>
                            <th>Nama Pelanggan</th>
                            <th>Alamat</th>
                            <th>Aksi</th> 
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include "koneksi.php";

                        // Query untuk mengambil data pelanggan menggunakan view
                        $sql = $pdo->prepare("SELECT * FROM view_pelanggan");
                        $sql->execute();
                        while ($data = $sql->fetch()) {
                            echo "<tr>";
                            echo "<td>" . $data['id_pelanggan'] . "</td>";
                            echo "<td>" . $data['nama_pelanggan'] . "</td>";
                            echo "<td>" . $data['alamat'] . "</td>";
                            echo "<td>
                                    <a href='ubah_pelanggan.php?id_pelanggan=" . $data['id_pelanggan'] . "' class='btn btn-primary btn-icon-split'>
                                        <span class='icon text-white-50'>
                                            <i class='fas fa-edit'></i>
                                        </span>
                                        <span class='text'>Ubah</span>
                                    </a>
                                    <a href='hapus_pelanggan.php?id_pelanggan=" . $data['id_pelanggan'] . "' onclick='return confirm(\"Apakah Anda yakin ingin menghapus pelanggan ini?\")' class='btn btn-danger btn-icon-split'>
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
                <td><a href='tambah_pelanggan.php' class='btn btn-success btn-icon-split'>
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

<?php
include "template/footer.php";
?>