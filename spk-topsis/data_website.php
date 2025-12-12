<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Website - SPK TOPSIS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        .sidebar { height: 100vh; background-color: #343a40; color: white; min-width: 250px; }
        .sidebar a { color: white; text-decoration: none; display: block; padding: 10px 20px; }
        .sidebar a:hover { background-color: #495057; }
        .content { width: 100%; padding: 20px; }
    </style>
</head>
<body class="d-flex">

    <div class="sidebar p-3">
        <h4 class="text-center mb-4">SPK TOPSIS</h4>
        <hr>
        <a href="index.php"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
        <a href="data_website.php"><i class="bi bi-table me-2"></i> Data Website</a>
        <a href="hasil.php"><i class="bi bi-calculator me-2"></i> Perhitungan</a>
    </div>

    <div class="content bg-light">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Data Alternatif Mahasiswa</h3>
            <a href="tambah.php" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah Data</a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Mahasiswa</th>
                            <th>C1 (Desain)</th>
                            <th>C2 (Konten)</th>
                            <th>C3 (Kecepatan)</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $sql = mysqli_query($koneksi, "SELECT * FROM website");
                        while($d = mysqli_fetch_array($sql)){
                        ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $d['nama_mahasiswa']; ?></td>
                            <td><?php echo $d['c1']; ?></td>
                            <td><?php echo $d['c2']; ?></td>
                            <td><?php echo $d['c3']; ?> Detik</td>
                            <td>
                                <a href="hapus.php?id=<?php echo $d['id_web']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus data ini?')"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>