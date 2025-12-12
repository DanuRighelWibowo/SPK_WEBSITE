<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tambah Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css"> </head>
<body class="bg-light">
    <div class="container mt-5" style="max-width: 600px;">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Tambah Data Mahasiswa</h4>
            </div>
            <div class="card-body">
                <form action="" method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Mahasiswa</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Link Website (URL)</label>
                        <div class="input-group">
                            <span class="input-group-text">https://</span>
                            <input type="text" name="url_web" class="form-control" placeholder="github.com/mahasiswa/project" required>
                        </div>
                        <small class="text-muted">Masukkan link lengkap project atau demo.</small>
                    </div>
