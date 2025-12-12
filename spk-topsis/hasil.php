<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hasil Perhitungan TOPSIS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        .sidebar { height: 100vh; background-color: #343a40; color: white; min-width: 250px; position: fixed;}
        .sidebar a { color: white; text-decoration: none; display: block; padding: 10px 20px; }
        .sidebar a:hover { background-color: #495057; }
        .content { margin-left: 250px; padding: 20px; width: 100%; }
    </style>
</head>
<body class="bg-light">

    <div class="sidebar p-3">
        <h4 class="text-center mb-4">SPK TOPSIS</h4>
        <hr>
        <a href="index.php"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
        <a href="data_website.php"><i class="bi bi-table me-2"></i> Data Website</a>
        <a href="hasil.php"><i class="bi bi-calculator me-2"></i> Perhitungan</a>
    </div>

    <div class="content">
        <h3>Hasil Perhitungan TOPSIS</h3>
        <hr>

        <?php
        // --- LOGIKA TOPSIS (Sama seperti sebelumnya) ---
        $bobot = [5, 4, 3]; 
        $atribut = ['benefit', 'benefit', 'cost']; 

        $data = [];
        $nama = [];
        $sql = mysqli_query($koneksi, "SELECT * FROM website");
        while($row = mysqli_fetch_assoc($sql)){
            $nama[] = $row['nama_mahasiswa'];
            $data[] = [$row['c1'], $row['c2'], $row['c3']];
        }

        if(count($data) == 0) {
            echo "<div class='alert alert-warning'>Data masih kosong. Silakan input data terlebih dahulu.</div>";
        } else {
            // 1. Normalisasi
            $pembagi = [0, 0, 0];
            foreach($data as $row){
                for($i=0; $i<3; $i++) $pembagi[$i] += pow($row[$i], 2);
            }
            for($i=0; $i<3; $i++) $pembagi[$i] = sqrt($pembagi[$i]);

            $R = [];
            foreach($data as $row){
                $temp = [];
                for($i=0; $i<3; $i++) $temp[] = $row[$i] / $pembagi[$i];
                $R[] = $temp;
            }

            // 2. Normalisasi Terbobot (Y)
            $Y = [];
            foreach($R as $row){
                $temp = [];
                for($i=0; $i<3; $i++) $temp[] = $row[$i] * $bobot[$i];
                $Y[] = $temp;
            }

            // 3. Solusi Ideal A+ dan A-
            $A_plus = []; $A_min = [];
            for($i=0; $i<3; $i++){
                $col = array_column($Y, $i);
                if($atribut[$i] == 'benefit'){
                    $A_plus[$i] = max($col);
                    $A_min[$i] = min($col);
                } else {
                    $A_plus[$i] = min($col);
                    $A_min[$i] = max($col);
                }
            }

            // 4. Jarak & 5. Preferensi (V)
            $V = [];
            foreach($Y as $key => $row){
                $sum_plus = 0; $sum_min = 0;
                for($i=0; $i<3; $i++){
                    $sum_plus += pow($row[$i] - $A_plus[$i], 2);
                    $sum_min += pow($row[$i] - $A_min[$i], 2);
                }
                $D_plus = sqrt($sum_plus);
                $D_min = sqrt($sum_min);
                $div = ($D_min + $D_plus);
                $V[$key] = $div == 0 ? 0 : $D_min / $div;
            }

            // Ranking
            $hasil_akhir = [];
            foreach($nama as $key => $val){
                $hasil_akhir[] = ['nama' => $val, 'nilai' => $V[$key]];
            }
            usort($hasil_akhir, function($a, $b) {
                return $b['nilai'] <=> $a['nilai'];
            });
        ?>

        <div class="card shadow-sm mt-3">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Perankingan Akhir</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="10%">Ranking</th>
                            <th>Nama Mahasiswa</th>
                            <th>Nilai Preferensi (V)</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $rank = 1;
                        foreach($hasil_akhir as $h): 
                        ?>
                        <tr>
                            <td class="text-center fw-bold"><?php echo $rank; ?></td>
                            <td><?php echo $h['nama']; ?></td>
                            <td><?php echo number_format($h['nilai'], 4); ?></td>
                            <td>
                                <?php if($rank == 1) echo "<span class='badge bg-warning text-dark'>🏆 Rekomendasi Utama</span>"; ?>
                            </td>
                        </tr>
                        <?php 
                        $rank++;
                        endforeach; 
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <?php } // End if data not empty ?>
    </div>
</body>
</html>