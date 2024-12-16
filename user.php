<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['id_user'])) {
    $_SESSION['err'] = '<strong>ERROR!</strong> Anda harus login terlebih dahulu.';
    header('Location: ./');
    die();
} else {
    if (isset($_REQUEST['aksi'])) {
        $aksi = $_REQUEST['aksi'];
        switch ($aksi) {
            case 'baru':
                include 'user_baru.php';
                break;
            case 'edit':
                include 'user_edit.php';
                break;
            case 'hapus':
                include 'user_hapus.php';
                break;
            default:
                echo '<p>Aksi tidak dikenali.</p>';
                break;
        }
    } else {
        echo '

        <div class="container">
        <div class="col-md-8">
            <h3 style="margin-bottom: -20px;">Daftar User</h3>
                <a href="./admin.php?hlm=user&aksi=baru" class="btn btn-success btn-s pull-right">Tambah User</a>
            <br/><hr/>

            <table class="table table-bordered">
             <thead>
               <tr class="info">
                 <th width="5%">No</th>
                 <th width="22%">Username</th>
                 <th width="33%">Nama</th>
                 <th width="20%">Level</th>
                 <th width="20%">Tindakan</th>
               </tr>
             </thead>
             <tbody>';

        // Skrip untuk menampilkan data dari database
        $sql = mysqli_query($koneksi, "SELECT * FROM user");
        if (mysqli_num_rows($sql) > 0) {
            $no = 0;

            while ($row = mysqli_fetch_array($sql)) {
                $no++;
                echo '

               <tr>
                 <td>' . $no . '</td>
                 <td>' . htmlspecialchars($row['username']) . '</td>
                 <td>' . htmlspecialchars($row['nama']) . '</td>
                 <td>';

                if ($row['level'] == 1) {
                    echo 'Admin';
                } elseif ($row['level'] == 2) {
                    echo 'Pemilik';
                } elseif ($row['level'] == 3) {
                    echo 'Pelanggan';
                } else {
                    echo 'User Tidak Dikenali';
                }

                echo '</td>
                 <td>

                <script type="text/javascript" language="JavaScript">
                    function konfirmasi() {
                        return confirm("Anda yakin akan menghapus user ini?");
                    }
                </script>

                 <a href="?hlm=user&aksi=edit&id_user=' . $row['id_user'] . '" class="btn btn-warning btn-s">Edit</a>
                 <a href="?hlm=user&aksi=hapus&submit=yes&id_user=' . $row['id_user'] . '" onclick="return konfirmasi()" class="btn btn-danger btn-s">Hapus</a>

                 </td>
               </tr>';
            }
        } else {
            echo '<tr><td colspan="5"><center><p class="add">Tidak ada data untuk ditampilkan. <u><a href="?hlm=user&aksi=baru">Tambah user baru</a></u></p></center></td></tr>';
        }
        echo '
            </tbody>
        </table>
        </div>
    </div>';
    }
}
?>