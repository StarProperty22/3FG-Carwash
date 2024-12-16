<?php
if (session_status() == PHP_SESSION_NONE) {
  
}
include "koneksi.php"; // Pastikan koneksi database sudah benar

if (empty($_SESSION['id_user'])) {
    $_SESSION['err'] = '<strong>ERROR!</strong> Anda harus login terlebih dahulu.';
    header('Location: ./');
    die();
} else {
    if (isset($_REQUEST['aksi'])) {
        $aksi = $_REQUEST['aksi'];
        switch ($aksi) {
            case 'baru':
                include 'transaksi_baru.php';
                break;
            case 'edit':
                include 'transaksi_edit.php';
                break;
            case 'hapus':
                include 'transaksi_hapus.php';
                break;
            case 'cetak':
                include 'cetak_nota.php';
                break;
            case 'konfirmasi':
                $id_transaksi = $_REQUEST['id_transaksi'];
                $update_sql = mysqli_query($koneksi, "UPDATE transaksi SET status = 'completed' WHERE id_transaksi = '$id_transaksi'");
                if ($update_sql) {
                    echo '<script>alert("Transaksi telah dikonfirmasi sebagai selesai."); window.location.href="?hlm=transaksi";</script>';
                } else {
                    echo '<script>alert("Gagal mengkonfirmasi transaksi."); window.location.href="?hlm=transaksi";</script>';
                }
                break;
        }
    } else {
        echo '
            <div class="container">
                <h3 style="margin-bottom: -20px;">Daftar Transaksi</h3>
                <a href="./admin.php?hlm=transaksi&aksi=baru" class="btn btn-success btn-s pull-right">Tambah Data</a>
                <br/><hr/>
                <table class="table table-bordered">
                    <thead>
                        <tr class="info">
                            <th width="5%">No</th>
                            <th width="10%">No. Nota</th>
                            <th width="20%">Nama Pelanggan</th>
                            <th width="20%">Jenis</th>
                            <th width="10%">Total Bayar</th>
                            <th width="10%">Tanggal</th>
                            <th width="10%">Status</th>
                            <th width="20%">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>';

        // Ambil id_user dan level dari session
        $id_user = $_SESSION['id_user'];
        $level = $_SESSION['level'];

        // Skrip untuk menampilkan data dari database
        if ($level == 1) { // Jika admin
            $sql = mysqli_query($koneksi, "SELECT * FROM transaksi");
        } else { // Jika bukan admin
            $sql = mysqli_query($koneksi, "SELECT * FROM transaksi WHERE id_user = '$id_user'");
        }

        if (mysqli_num_rows($sql) > 0) {
            $no = 0;
            while ($row = mysqli_fetch_array($sql)) {
                $no++;
                echo '
                    <tr>
                        <td>' . $no . '</td>
                        <td>' . $row['no_nota'] . '</td>
                        <td>' . $row['nama'] . '</td>
                        <td>' . $row['jenis'] . '</td>
                        <td>RP. ' . number_format($row['total']) . '</td>
                        <td>' . date("d M Y", strtotime($row['tanggal'])) . '</td>
                        <td>' . $row['status'] . '</td>
                        <td>';

                // Tindakan berdasarkan level pengguna
                if ($level == 1) { // Jika admin
                    echo '
                        <a href="?hlm=cetak&id_transaksi=' . $row['id_transaksi'] . '" class="btn btn-info btn-s" target="_blank" style="margin-right: 5px;">Cetak Nota</a>
                        <a href="?hlm=transaksi&aksi=edit&id_transaksi=' . $row['id_transaksi'] . '" class="btn btn-warning btn-s" style="margin-right: 5px;">Edit</a>
                        <a href="?hlm=transaksi&aksi=hapus&submit=yes&id_transaksi=' . $row['id_transaksi'] . '" onclick="return konfirmasi()" class="btn btn-danger btn-s" style="margin-right: 5px;">Hapus</a>';
                    
                    // Tampilkan tombol "Selesai" hanya jika status bukan "completed"
                    if ($row['status'] !== 'completed') {
                        echo '<a href="?hlm=transaksi&aksi=konfirmasi&id_transaksi=' . $row['id_transaksi'] . '" class="btn btn-success btn-s">Selesai</a>';
                    }
                } else { // Jika bukan admin
                    echo '
                        <a href="?hlm=cetak&id_transaksi=' . $row['id_transaksi'] . '" class="btn btn-info btn-s" target="_blank" style="margin-right: 5px;">Cetak Nota</a>';
                }

                echo '
                        </td>
                    </tr>';
            }
        } else {
            echo '<td colspan="8"><center><p class="add">Tidak ada data untuk ditampilkan. <u><a href="?hlm=transaksi&aksi=baru">Tambah data baru</a></u> </p></center></td></tr>';
        }
        echo '
                    </tbody>
                </table>
            </div>';
    }
}
?>