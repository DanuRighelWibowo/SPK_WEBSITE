<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard SPK TOPSIS</title>
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
        <h2>Dashboard</h2>
        <p class="text-muted">Selamat datang di Sistem Pendukung Keputusan Pemilihan Website Terbaik.</p>
        
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Kandidat</h5>
                        <?php
                        $data = mysqli_query($koneksi, "SELECT * FROM website");
                        $jumlah = mysqli_num_rows($data);
                        ?>
                        <h2 class="fw-bold"><?php echo $jumlah; ?> Mahasiswa</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Jumlah Kriteria</h5>
                        <h2 class="fw-bold">3 Kriteria</h2>
                        <small>Desain, Konten, Kecepatan</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>